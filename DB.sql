SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Views */

DROP VIEW SiteContentView;
DROP VIEW VisitUserSite;



/* Drop Tables */

DROP TABLE AuthItemChild;
DROP TABLE SiteContent;
DROP TABLE Content;
DROP TABLE VisitSite;
DROP TABLE SiteLanguage;
DROP TABLE Site;
DROP TABLE AuthAssignment;
DROP TABLE Menu;
DROP TABLE AuthItem;
DROP TABLE Language;
DROP TABLE VisitUser;
DROP TABLE Visit;
DROP TABLE UserValidate;
DROP TABLE User;




/* Create Tables */

CREATE TABLE AuthItemChild
(
	parent varchar(64) NOT NULL,
	child varchar(64) NOT NULL,
	PRIMARY KEY (parent, child)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE TABLE AuthItem
(
	name varchar(64) NOT NULL,
	type int NOT NULL,
	description text,
	bizrule text,
	data text,
	PRIMARY KEY (name)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE TABLE AuthAssignment
(
	itemname varchar(64) NOT NULL,
	userid varchar(20) NOT NULL,
	bizrule text,
	data text,
	PRIMARY KEY (itemname, userid)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE TABLE Language
(
	languageid char(2) NOT NULL UNIQUE,
	label varchar(20) NOT NULL,
	active boolean DEFAULT '0' NOT NULL,
	flag varchar(50) NOT NULL,
	PRIMARY KEY (languageid)
);


CREATE TABLE Menu
(
	menuid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	label varchar(20) NOT NULL,
	url_intern boolean NOT NULL,
	url varchar(50),
	siteid char(32),
	icon varchar(20),
	position smallint NOT NULL,
	roleaccess varchar(64) NOT NULL,
	parent_menuid char(32),
	parent_langugageid char(2),
	update_userid varchar(20) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	create_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	PRIMARY KEY (menuid, languageid)
);


CREATE TABLE Visit
(
	visitid char(32) NOT NULL UNIQUE,
	session varchar(32) NOT NULL,
	ip varchar(15) NOT NULL,
	system char(3) NOT NULL,
	browser char(3) NOT NULL,
	version varchar(20) NOT NULL,
	PRIMARY KEY (visitid)
);


CREATE TABLE SiteContent
(
	siteid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	contentid char(32) NOT NULL,
	col smallint NOT NULL,
	position smallint NOT NULL,
	PRIMARY KEY (siteid, languageid, contentid)
);


CREATE TABLE SiteLanguage
(
	siteid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	head varchar(40),
	PRIMARY KEY (siteid, languageid)
);


CREATE TABLE User
(
	userid varchar(20) NOT NULL UNIQUE,
	firstname varchar(20) NOT NULL,
	lastname varchar(30) NOT NULL,
	password char(64) NOT NULL,
	mail varchar(60) NOT NULL,
	mail_valid boolean DEFAULT '0' NOT NULL,
	active boolean DEFAULT '1' NOT NULL,
	PRIMARY KEY (userid)
);


CREATE TABLE VisitUser
(
	visitid char(32) NOT NULL,
	userid varchar(20) NOT NULL,
	time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (visitid, userid)
);


CREATE TABLE VisitSite
(
	visitid char(32) NOT NULL,
	siteid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (visitid, siteid, languageid)
);


CREATE TABLE Site
(
	siteid char(32) NOT NULL UNIQUE,
	label varchar(20) NOT NULL UNIQUE,
	layout char(5) NOT NULL,
	roleaccess varchar(64) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	update_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	create_userid varchar(20) NOT NULL,
	PRIMARY KEY (siteid)
);


CREATE TABLE Content
(
	contentid char(32) NOT NULL UNIQUE,
	label varchar(20) NOT NULL,
	text text NOT NULL,
	languageid char(2) NOT NULL,
	roleaccess varchar(64) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	update_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	create_userid varchar(20) NOT NULL,
	PRIMARY KEY (contentid)
);


CREATE TABLE UserValidate
(
	validateid char(32) NOT NULL UNIQUE,
	userid varchar(20) NOT NULL UNIQUE,
	time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (validateid)
);



/* Create Foreign Keys */

ALTER TABLE Content
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE AuthItemChild
	ADD CONSTRAINT AuthItemChild_ibfk_2 FOREIGN KEY (child)
	REFERENCES AuthItem (name)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Site
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE AuthAssignment
	ADD CONSTRAINT AuthAssignment_ibfk_1 FOREIGN KEY (itemname)
	REFERENCES AuthItem (name)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE AuthItemChild
	ADD CONSTRAINT AuthItemChild_ibfk_1 FOREIGN KEY (parent)
	REFERENCES AuthItem (name)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Menu
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Menu
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE SiteLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Content
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Menu
	ADD FOREIGN KEY (parent_menuid, parent_langugageid)
	REFERENCES Menu (menuid, languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE VisitUser
	ADD FOREIGN KEY (visitid)
	REFERENCES Visit (visitid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE VisitSite
	ADD FOREIGN KEY (visitid)
	REFERENCES Visit (visitid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE VisitSite
	ADD FOREIGN KEY (siteid, languageid)
	REFERENCES SiteLanguage (siteid, languageid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE SiteContent
	ADD FOREIGN KEY (siteid, languageid)
	REFERENCES SiteLanguage (siteid, languageid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Menu
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Menu
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Content
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE AuthAssignment
	ADD FOREIGN KEY (userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE UserValidate
	ADD FOREIGN KEY (userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Site
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Content
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE VisitUser
	ADD FOREIGN KEY (userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Site
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE SiteLanguage
	ADD FOREIGN KEY (siteid)
	REFERENCES Site (siteid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE SiteContent
	ADD FOREIGN KEY (contentid)
	REFERENCES Content (contentid)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



/* Create Views */

CREATE VIEW SiteContentView AS SELECT site.siteid as siteid, site.languageid as languageid, site.contentid as contentid, site.col as col, site.position as position, con.text as text, con.roleaccess as roleaccess, con.update_time as update_time, con.update_userid as update_userid, con.create_time as create_time, con.create_userid as create_userid
FROM SiteContent as site
LEFT JOIN Content as con ON site.contentid = con.contentid
ORDER BY contentid, col, position;
CREATE VIEW VisitUserSite AS SELECT user.visitid AS visitid, user.userid AS userid, site.siteid AS siteid, site.languageid AS languageid, site.time AS time
FROM VisitUser user
RIGHT JOIN VisitSite site ON user.visitid = site.visitid;



