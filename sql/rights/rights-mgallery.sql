INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('readGallery', 0, '', NULL, 'N;'),
('deleteGallery', 0, '', NULL, 'N;'),
('editGallery', 0, '', NULL, 'N;'),
('MGALLERY', 2, '', NULL, 'N;'),
('updateGallery', 0, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MGALLERY', 'readGallery'),
('MGALLERY', 'createGallery'),
('MGALLERY', 'deleteGallery'),
('MGALLERY', 'editGallery'),
('MGALLERY', 'updateGallery');
