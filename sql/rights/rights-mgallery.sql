INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('deleteGallery', 0, '', NULL, 'N;'),
('editGallery', 0, '', NULL, 'N;'),
('MGALLERY', 2, '', NULL, 'N;'),
('updateGallery', 0, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MGALLERY', 'createGallery'),
('MGALLERY', 'deleteGallery'),
('MGALLERY', 'editGallery'),
('MGALLERY', 'updateGallery');