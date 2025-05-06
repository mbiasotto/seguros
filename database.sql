SET FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------------------------
-- TablePlus 6.4.4(604)
--
-- https://tableplus.com/
--
-- Database: database.sqlite
-- Generation Time: 2025-05-06 01:20:21.6840
-- -------------------------------------------------------------


-- Inserindo dados em establishment_qr_code (depende de establishments)
INSERT INTO `establishment_qr_code` (`id`, `establishment_id`, `qr_code_id`, `created_at`, `updated_at`) VALUES
('1', '6', '1', NULL, NULL),
('2', '7', '100', NULL, NULL),
('6', '11', '13', NULL, NULL),
('7', '11', '50', NULL, NULL),
('10', '14', '10', NULL, NULL),
('11', '15', '7', NULL, NULL),
('12', '16', '22', NULL, NULL);

SET FOREIGN_KEY_CHECKS=1;

