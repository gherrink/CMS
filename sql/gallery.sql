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


CREATE TABLE ImageLanguage
(
	imageid char(32) NOT NULL,
	languageid char(2) NOT NULL,
	head varchar(40),
	text text,
	PRIMARY KEY (imageid, languageid)
);


CREATE TABLE GalleryImage
(
	galleryid char(32) NOT NULL,
	imageid char(32) NOT NULL,
	position smallint NOT NULL
);

ALTER TABLE Gallery
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;

ALTER TABLE Gallery
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

ALTER TABLE Gallery
	ADD FOREIGN KEY (parent_galleryid)
	REFERENCES Gallery (galleryid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;

ALTER TABLE Gallery
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;

ALTER TABLE GalleryLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;

ALTER TABLE GalleryLanguage
	ADD FOREIGN KEY (galleryid)
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

ALTER TABLE GalleryImage
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;

ALTER TABLE Image
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;

ALTER TABLE Image
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

ALTER TABLE ImageLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;

ALTER TABLE ImageLanguage
	ADD FOREIGN KEY (imageid)
	REFERENCES Image (imageid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;
