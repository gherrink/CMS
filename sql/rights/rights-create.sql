INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('MEMBER', 'mrbirne', NULL, 'N;'),
('MSITE', 'mrbirne', NULL, 'N;'),
('USER', 'mrbirne', NULL, 'N;');

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('addSiteNewLanguage', 0, '', NULL, 'N;'),
('changeMail', 0, '', NULL, 'N;'),
('contact', 0, '', NULL, 'N;'),
('createContent', 0, '', NULL, 'N;'),
('createSite', 0, '', NULL, 'N;'),
('deleteContent', 0, '', NULL, 'N;'),
('deleteSite', 0, '', NULL, 'N;'),
('deleteSiteLanguage', 0, '', NULL, 'N;'),
('login', 0, '', NULL, 'N;'),
('logout', 0, '', NULL, 'N;'),
('MEMBER', 2, '', NULL, 'N;'),
('MSITE', 2, '', NULL, 'N;'),
('register', 0, '', NULL, 'N;'),
('resendMail', 0, '', NULL, 'N;'),
('updateContent', 0, '', NULL, 'N;'),
('updateSite', 0, '', NULL, 'N;'),
('USER', 2, '', NULL, 'N;'),
('VISITOR', 2, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MSITE', 'addSiteNewLanguage'),
('VISITOR', 'changeMail'),
('USER', 'contact'),
('VISITOR', 'contact'),
('MSITE', 'createContent'),
('MSITE', 'createSite'),
('MSITE', 'deleteContent'),
('MSITE', 'deleteSite'),
('MSITE', 'deleteSiteLanguage'),
('VISITOR', 'login'),
('USER', 'logout'),
('VISITOR', 'register'),
('VISITOR', 'resendMail'),
('MSITE', 'updateContent'),
('MSITE', 'updateSite');
