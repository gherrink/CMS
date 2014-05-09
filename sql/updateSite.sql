DROP TABLE IF EXISTS SiteContent;
DROP VIEW IF EXISTS SiteContentView;

CREATE TABLE SiteContent
(
	siteid char(32) NOT NULL,
	contentid char(32) NOT NULL,
	col smallint NOT NULL,
	position smallint NOT NULL,
	PRIMARY KEY (siteid, contentid)
);

ALTER TABLE SiteContent
	ADD FOREIGN KEY (siteid)
	REFERENCES Site (siteid)
	ON UPDATE CASCADE
	ON DELETE CASCADE
;

ALTER TABLE SiteContent
	ADD FOREIGN KEY (contentid)
	REFERENCES Content (contentid)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
;

CREATE VIEW SiteContentView AS SELECT c.contentid, sc.siteid, c.languageid, sc.col, sc.position, c.label, c.roleaccess, c.update_time, c.update_userid, c.create_time, c.create_userid, c.text
FROM Content c 
RIGHT JOIN SiteContent sc ON c.contentid = sc.contentid
ORDER BY sc.position;