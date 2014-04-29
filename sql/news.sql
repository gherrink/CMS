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

ALTER TABLE News
	ADD FOREIGN KEY (roleaccess)
	REFERENCES AuthItem (name)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;

ALTER TABLE News
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

ALTER TABLE NewsLanguage
	ADD FOREIGN KEY (newsid)
	REFERENCES News (newsid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;

ALTER TABLE NewsLanguage
	ADD FOREIGN KEY (languageid)
	REFERENCES Language (languageid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;
