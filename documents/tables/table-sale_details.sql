--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `sales_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla venta( sales ).',
  `presentation_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Id de la tabla presentaciones ( Presentation ).',
  `description` text COMMENT 'Descripción puntual del item del servicio.',
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
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_sales_id_foreign` (`sales_id`),
  ADD KEY `sale_details_presentation_id_index` (`presentation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`);
