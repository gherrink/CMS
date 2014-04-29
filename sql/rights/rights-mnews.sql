INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('deleteNews', 0, '', NULL, 'N;'),
('editNews', 0, '', NULL, 'N;'),
('MNEWS', 2, '', NULL, 'N;'),
('updateNews', 0, '', NULL, 'N;');

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('MNEWS', 'createNews'),
('MNEWS', 'deleteNews'),
('MNEWS', 'editNews'),
('MNEWS', 'updateNews');
