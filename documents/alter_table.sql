--
-- Nuevas Columnas 19/03/2019
--
ALTER TABLE `users` ADD `img_profile` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `phone`, ADD `img_cover_page` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `img_profile`;

--
-- Nuevas columnas 06/06/2019
--
ALTER TABLE `presentation` ADD `sku` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `unity_id`;
ALTER TABLE `presentation` ADD `pricetag_purchase` DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER `stock`;