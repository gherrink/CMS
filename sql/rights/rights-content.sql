INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('addSiteContent', 0, '', NULL, 'N;'),
('deleteSiteContent', 0, '', NULL, 'N;'),
('updateContentText', 0, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MSITE', 'addSiteContent'),
('MSITE', 'deleteSiteContent'),
('MSITE', 'updateContentText');
