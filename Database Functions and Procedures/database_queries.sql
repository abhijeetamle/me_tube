--- Reference: https://www.youtube.com/watch?v=RswtHsz4v-0
---Adjacency list model

--- creating a contact list table which will store all the contact groups for each user


CREATE TABLE CONTACT_LIST (
  contact_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  parent_id int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (contact_id),
  FOREIGN KEY (parent_id) REFERENCES CONTACT_LIST (contact_id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);


--- Adding root node to the table
--- here title is also used to store user_id of users

INSERT INTO CONTACT_LIST(title,parent_id) VALUES ('parent_root',null);


--- Function to get contact_id if you pass the username of user and the title

DELIMITER EOF
create function get_CONTACT_LIST_id(user_name varchar(255), titlevar char(255) )
returns int
begin
	declare cont_id int;
	declare puser_id int;
	if locate('@',titlevar) then 
		select contact_id into cont_id from CONTACT_LIST where title=titlevar and parent_id=1;
	elseif titlevar='parent_root' then
		select contact_id into cont_id from CONTACT_LIST where title=titlevar;
	else
		select contact_id into puser_id from CONTACT_LIST where title=user_name and parent_id=1;
		select contact_id into cont_id from CONTACT_LIST where title=titlevar and parent_id=puser_id;
	end if;
	return cont_id;
end;
EOF
DELIMITER ;



--- drop function get_CONTACT_LIST_id;

--- Function to get the title if you pass contact_id

DELIMITER EOF
create function get_CONTACT_LIST_title(cont_id int)
returns char(255)
begin
	declare titlevar char(255) default '';
	select title into titlevar from CONTACT_LIST where contact_id=cont_id;
	return titlevar;
end;
EOF
DELIMITER ;


--- Procedure to insert into CONTACT_LIST 
-- it will first check whether that user is present in any other group or not 
-- if already present in other group it will delete that user from that group 
--- user_name: User id of the user
--- cname: contact name 
--- pname: parent name 
--- if pname: None then it will delete the user from that list

delimiter $
create procedure add_contact (user_name varchar(255), cname varchar(255), pname varchar(255))
begin
set @parent = (select get_CONTACT_LIST_id(user_name, pname));
set @current_grp = (select get_group_name(user_name, cname));
	if ((@parent is not null) and @current_grp='None')  then
		insert into CONTACT_LIST (title, parent_id) values (cname, @parent);
	elseif (pname='None') then
		set @current_grp_id = (select get_CONTACT_LIST_id(user_name, @current_grp));
		delete from CONTACT_LIST where title=cname and parent_id=@current_grp_id;
	else
		set @current_grp_id = (select get_CONTACT_LIST_id(user_name, @current_grp));
		delete from CONTACT_LIST where title=cname and parent_id=@current_grp_id;
		insert into CONTACT_LIST (title, parent_id) values (cname, @parent);
	end if;
end $
delimiter ;


--- call the procedure add_contact to insert into CONTACT_LIST table
--- Query: call add_contact (user_name, title, parent)


--- adding groups to user id 1
call add_contact('abc@g.clemson.edu','Friends','abc@g.clemson.edu');
call add_contact('abc@g.clemson.edu', 'Family','abc@g.clemson.edu');
call add_contact('abc@g.clemson.edu', 'Favorite','abc@g.clemson.edu');
call add_contact('abc@g.clemson.edu', 'Block','abc@g.clemson.edu');

--- adding user to Friend list of abc@g.clemson.edu

call add_contact('abc@g.clemson.edu', 'User@2', 'Friends');

--- adding user to Family list of abc@g.clemson.edu

call add_contact('abc@g.clemson.edu', 'User@2', 'Family');


--- adding groups to user 2
call add_contact('User@2', 'Friends','User@2');
call add_contact('User@2', 'Family','User@2');
call add_contact('User@2', 'Favorite','User@2');
call add_contact('User@2', 'Block','User@2');

--- adding user to Favorite list of User@2

call add_contact('User@2', 'abc@g.clemson.edu', 'Favorite');
call add_contact('User@2', 'User@3', 'Favorite');

--- adding user to Family list of User@2

call add_contact('User@2','abc@g.clemson.edu', 'Family');


---------- User@3

call add_contact('User@3', 'User@3','parent_root');

--- adding groups to user 3
call add_contact('User@3', 'Friends','User@3');
call add_contact('User@3', 'Family','User@3');
call add_contact('User@3', 'Favorite','User@3');
call add_contact('User@3', 'Block','User@3');

--- adding user to Family list of User@2

call add_contact('User@3','abc@g.clemson.edu', 'Family');
call add_contact('User@3','User@2', 'Family');


----- function for querying a group id for a perticular User

DELIMITER EOF
create function get_USER_LIST_id(user_name varchar(255), titlevar char(255) )
returns int
begin
	declare list_id int;
	declare puser_id int;
	select contact_id into puser_id from CONTACT_LIST where title=user_name and parent_id=1;
	select contact_id into list_id from CONTACT_LIST where title=titlevar and parent_id=puser_id;
	return list_id;
end;
EOF
DELIMITER ;


--- pass User id and group name to the function
select get_USER_LIST_id('User@3', 'Family');
@parent = (select get_USER_LIST_id(user_name, pname));


--- trigger to add all groups for a new registered user on the MeTube

DELIMITER EOF
CREATE or REPLACE TRIGGER add_contact_groups
    AFTER INSERT
    ON USER_ACCOUNT FOR EACH ROW
begin
	call add_contact(NEW.email_id, NEW.email_id,'parent_root');
	call add_contact(NEW.email_id, 'Friends',NEW.email_id);
	call add_contact(NEW.email_id, 'Family',NEW.email_id);
	call add_contact(NEW.email_id, 'Favorite',NEW.email_id);
	call add_contact(NEW.email_id, 'Block',NEW.email_id);
end;
EOF
DELIMITER ;


--- Procedure to rate a media
--- procedure will calculate average and store it 
 

delimiter $
create procedure rate_media(media_url varchar(40), user_rating int)
begin
set @org_rating = (select rating from VIDEO_LIST where video_url=media_url);
set @org_rated_by = (select rated_by from VIDEO_LIST where video_url=media_url);
	update VIDEO_LIST set rating=round((((@org_rating*@org_rated_by)+user_rating)/(@org_rated_by+1)),2), rated_by=@org_rated_by+1 where video_url=media_url;
end $
delimiter ;

-- rate_media(video_url, user_rating); 
call rate_media('05071d62e8361df86228',5);


--- Function to get the group name for a user

DELIMITER EOF
create function get_group_name(user_name varchar(255), friend_name varchar(255))
returns char(255)
begin
	declare friend_grp char(255) default '';
	
	set @grp_friend_id = (select get_CONTACT_LIST_id(user_name, 'Friends'));
	set @grp_family_id = (select get_CONTACT_LIST_id(user_name, 'Family'));
	set @grp_favorite_id = (select get_CONTACT_LIST_id(user_name, 'Favorite'));
	set @grp_block_id = (select get_CONTACT_LIST_id(user_name, 'Block'));
	
	if (SELECT EXISTS(select contact_id from CONTACT_LIST WHERE parent_id=@grp_friend_id and title=friend_name)) then
		set friend_grp = 'Friends';
	elseif (SELECT EXISTS(select contact_id from CONTACT_LIST WHERE parent_id=@grp_family_id and title=friend_name)) then
		set friend_grp = 'Family';
	elseif (SELECT EXISTS(select contact_id from CONTACT_LIST WHERE parent_id=@grp_favorite_id and title=friend_name)) then
		set friend_grp = 'Favorite';
	elseif (SELECT EXISTS(select contact_id from CONTACT_LIST WHERE parent_id=@grp_block_id and title=friend_name)) then
		set friend_grp = 'Block';
	else
		set friend_grp = 'None';
	end if;
	return friend_grp;
end;
EOF
DELIMITER ;


-- call with session user and friend name 
select get_group_name('abc@clemson.edu','test2@clemson.edu')

select get_group_name('abc@clemson.edu','test4@clemson.edu')

