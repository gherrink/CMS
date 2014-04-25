INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('addSiteNewLanguage', 0, '', NULL, 'N;'),
('deleteSiteLanguage', 0, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MSITE', 'addSiteNewLanguage'),
('MSITE', 'deleteSiteLanguage');
