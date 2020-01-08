--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `purchases_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla compras ( Purchases ).',
  `presentation_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla presentaciones ( Presentation ).',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT 'Cantidad del producto solicitado.',
  `price_unit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Precio unitario del producto.',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Precio de la cantidad por precio unitario del producto.',
  `igv` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del IGV(18%)',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Sumatoria del IGV mas el sub total.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchases_id_foreign` (`purchases_id`),
  ADD KEY `purchase_details_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `purchase_details_purchases_id_foreign` FOREIGN KEY (`purchases_id`) REFERENCES `purchases` (`id`);
