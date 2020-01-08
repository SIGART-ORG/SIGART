--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la orden de compras.',
  `sites_id` int(10) UNSIGNED NOT NULL COMMENT 'Id de la sede.',
  `provider_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id del Proveedor.',
  `quotations_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Id de la cotización, si es que fuese necesario.',
  `user_reg` int(11) NOT NULL DEFAULT '0' COMMENT 'Usuario que registro la orden de compra',
  `user_aproved` int(11) NOT NULL DEFAULT '0' COMMENT 'Usuario que aprobó la orden de compra',
  `code` varchar(6) NOT NULL COMMENT 'Código interno de la orden de compra.',
  `date_reg` date NOT NULL COMMENT 'Fecha de registro de la orden de compra',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto total de la orden de compra sin el IGV.',
  `igv` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del IGV del total de la orden compra.',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del total de la orden compra(inc IGV).',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado,\n 3: Aprobado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Orden de compra\n Base de datos que contendra los registros de la ordenes de compras';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_code_unique` (`code`),
  ADD KEY `purchase_orders_provider_id_foreign` (`provider_id`),
  ADD KEY `purchase_orders_sites_id_foreign` (`sites_id`),
  ADD KEY `purchase_orders_quotations_id_index` (`quotations_id`),
  ADD KEY `purchase_orders_user_reg_index` (`user_reg`),
  ADD KEY `purchase_orders_user_aproved_index` (`user_aproved`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de la orden de compras.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`),
  ADD CONSTRAINT `purchase_orders_sites_id_foreign` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`);

