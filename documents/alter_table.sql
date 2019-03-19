--
-- Nuevas Columnas 19/03/2019
--
ALTER TABLE `users` ADD `img_profile` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `phone`, ADD `img_cover_page` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `img_profile`;
