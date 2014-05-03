SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Views */

DROP VIEW IF EXISTS SiteContentView;
DROP VIEW IF EXISTS VisitUserSite;



/* DROP TABLE IF EXISTSs */

DROP TABLE IF EXISTS AuthItemChild;
DROP TABLE IF EXISTS GalleryImage;
DROP TABLE IF EXISTS GalleryLanguage;
DROP TABLE IF EXISTS Gallery;
DROP TABLE IF EXISTS NewsLanguage;
DROP TABLE IF EXISTS News;
DROP TABLE IF EXISTS ImageLanguage;
DROP TABLE IF EXISTS Image;
DROP TABLE IF EXISTS AuthAssignment;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS VisitSite;
DROP TABLE IF EXISTS SiteContent;
DROP TABLE IF EXISTS SiteLanguage;
DROP TABLE IF EXISTS Site;
DROP TABLE IF EXISTS Content;
DROP TABLE IF EXISTS AuthItem;
DROP TABLE IF EXISTS VisitUser;
DROP TABLE IF EXISTS Visit;
DROP TABLE IF EXISTS UserValidate;
DROP TABLE IF EXISTS Language;
DROP TABLE IF EXISTS User;

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


CREATE TABLE SiteLanguage
(
	siteid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	head varchar(40),
	PRIMARY KEY (siteid, languageid)
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


CREATE TABLE UserValidate
(
	validateid char(32) NOT NULL UNIQUE,
	userid varchar(20) NOT NULL UNIQUE,
	time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (validateid)
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
	parent_menuid char(32),
	parent_langugageid char(2),
	roleaccess varchar(64) NOT NULL,
	update_userid varchar(20) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	create_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	PRIMARY KEY (menuid, languageid)
);


CREATE TABLE GalleryImage
(
	galleryid char(32) NOT NULL,
	imageid char(32) NOT NULL,
	position smallint NOT NULL
);


CREATE TABLE News
(
	newsid char(32) NOT NULL,
	label varchar(20) NOT NULL UNIQUE,
	roleaccess varchar(64) NOT NULL,
	update_userid varchar(20) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	create_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	PRIMARY KEY (newsid)
);


CREATE TABLE NewsLanguage
(
	newsid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	text text NOT NULL,
	PRIMARY KEY (newsid, languageid)
);


CREATE TABLE ImageLanguage
(
	imageid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	head varchar(40),
	text text,
	PRIMARY KEY (imageid, languageid)
);


CREATE TABLE Language
(
	languageid char(2) NOT NULL,
	label varchar(20) NOT NULL,
	active boolean DEFAULT '0' NOT NULL,
	flag varchar(50) NOT NULL,
	PRIMARY KEY (languageid)
);


CREATE TABLE User
(
	userid varchar(20) NOT NULL,
	firstname varchar(20) NOT NULL,
	lastname varchar(30) NOT NULL,
	password char(64) NOT NULL,
	mail varchar(60) NOT NULL,
	mail_valid boolean DEFAULT '0' NOT NULL,
	active boolean DEFAULT '1' NOT NULL,
	PRIMARY KEY (userid)
);


CREATE TABLE Site
(
	siteid char(32) NOT NULL,
	label varchar(20) NOT NULL UNIQUE,
	layout char(5) NOT NULL,
	roleaccess varchar(64) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	update_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	create_userid varchar(20) NOT NULL,
	PRIMARY KEY (siteid)
);


CREATE TABLE Gallery
(
	galleryid char(32) NOT NULL,
	label varchar(20) NOT NULL UNIQUE,
	imageid char(32) NOT NULL,
	parent_galleryid char(32),
	roleaccess varchar(64) NOT NULL,
	update_userid varchar(20) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	create_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	PRIMARY KEY (galleryid)
);


CREATE TABLE Image
(
	imageid char(32) NOT NULL,
	url varchar(50) NOT NULL,
	roleaccess varchar(64) NOT NULL,
	update_userid varchar(20) NOT NULL,
	update_time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	create_userid varchar(20) NOT NULL,
	create_time timestamp NOT NULL,
	PRIMARY KEY (imageid)
);


CREATE TABLE GalleryLanguage
(
	galleryid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	head varchar(40),
	PRIMARY KEY (galleryid, languageid)
);


CREATE TABLE Content
(
	contentid char(32) NOT NULL,
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



/* Create Foreign Keys */

ALTER TABLE Gallery
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE News
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Image
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


ALTER TABLE AuthAssignment
	ADD CONSTRAINT AuthAssignment_ibfk_1 FOREIGN KEY (itemname)
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


ALTER TABLE Site
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Content
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE AuthItemChild
	ADD CONSTRAINT AuthItemChild_ibfk_1 FOREIGN KEY (parent)
	REFERENCES AuthItem (name)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE VisitSite
	ADD FOREIGN KEY (visitid)
	REFERENCES Visit (visitid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE VisitUser
	ADD FOREIGN KEY (visitid)
	REFERENCES Visit (visitid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE VisitSite
	ADD FOREIGN KEY (siteid, languageid)
	REFERENCES SiteLanguage (siteid, languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE SiteContent
	ADD FOREIGN KEY (siteid, languageid)
	REFERENCES SiteLanguage (siteid, languageid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Menu
	ADD FOREIGN KEY (parent_menuid, parent_langugageid)
	REFERENCES Menu (menuid, languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE NewsLanguage
	ADD FOREIGN KEY (newsid)
	REFERENCES News (newsid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Content
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE ImageLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE NewsLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE GalleryLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Menu
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE SiteLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Site
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE News
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Image
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE News
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE UserValidate
	ADD FOREIGN KEY (userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Content
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Gallery
	ADD FOREIGN KEY (create_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE Image
	ADD FOREIGN KEY (update_userid)
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


ALTER TABLE Gallery
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


ALTER TABLE Menu
	ADD FOREIGN KEY (update_userid)
	REFERENCES User (userid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE SiteLanguage
	ADD FOREIGN KEY (siteid)
	REFERENCES Site (siteid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Gallery
	ADD FOREIGN KEY (parent_galleryid)
	REFERENCES Gallery (galleryid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE GalleryImage
	ADD FOREIGN KEY (galleryid)
	REFERENCES Gallery (galleryid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE GalleryLanguage
	ADD FOREIGN KEY (galleryid)
	REFERENCES Gallery (galleryid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE GalleryImage
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE Gallery
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;


ALTER TABLE ImageLanguage
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;


ALTER TABLE SiteContent
	ADD FOREIGN KEY (contentid)
	REFERENCES Content (contentid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;



/* Create Views */

CREATE VIEW SiteContentView AS SELECT site.siteid as siteid, site.languageid as languageid, site.contentid as contentid, site.col as col, con.label as label, site.position as position, con.text as text, con.roleaccess as roleaccess, con.update_time as update_time, con.update_userid as update_userid, con.create_time as create_time, con.create_userid as create_userid
FROM SiteContent as site
LEFT JOIN Content as con ON site.contentid = con.contentid
ORDER BY contentid, col, position;
CREATE VIEW VisitUserSite AS SELECT user.visitid AS visitid, user.userid AS userid, site.siteid AS siteid, site.languageid AS languageid, site.time AS time
FROM VisitUser user
RIGHT JOIN VisitSite site ON user.visitid = site.visitid;



