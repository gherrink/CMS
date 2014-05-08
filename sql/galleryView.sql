ALTER TABLE `Gallery` ADD `position` SMALLINT NOT NULL AFTER `roleaccess` ;

CREATE VIEW GalleryView AS SELECT g.galleryid, gl.languageid, g.label, g.roleaccess, gl.head, i.imageid, i.url, g.parent_galleryid, gp.label parent_label, g.create_userid, g.create_time, g.update_userid, g.update_time
FROM Gallery g
RIGHT JOIN GalleryLanguage gl ON g.galleryid = gl.galleryid
LEFT JOIN Image i ON g.imageid = i.imageid
LEFT JOIN Gallery gp ON g.parent_galleryid = gp.galleryid
ORDER BY g.position
