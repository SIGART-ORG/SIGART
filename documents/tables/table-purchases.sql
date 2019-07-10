--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `purchase_orders_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la compra.',
  `type_vouchers_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tipo de comprobante.',
  `type_payment_methods_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tipo de método de pago.',
  `serial_doc` varchar(6) NOT NULL COMMENT 'Serie de la compra.',
  `number_doc` varchar(6) NOT NULL COMMENT 'Número de la compra.',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto total de la compra sin el IGV.',
  `igv` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del IGV del total de la compra.',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del total de la compra(inc IGV).',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente de pago\n 2: Anulado,\n 3: Pagado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Orden de compra\n Base de datos que contendra las compras';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_purchase_orders_id_foreign` (`purchase_orders_id`),
  ADD KEY `purchases_type_vouchers_id_foreign` (`type_vouchers_id`),
  ADD KEY `purchases_type_payment_methods_id_foreign` (`type_payment_methods_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_purchase_orders_id_foreign` FOREIGN KEY (`purchase_orders_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `purchases_type_payment_methods_id_foreign` FOREIGN KEY (`type_payment_methods_id`) REFERENCES `type_payment_methods` (`id`),
  ADD CONSTRAINT `purchases_type_vouchers_id_foreign` FOREIGN KEY (`type_vouchers_id`) REFERENCES `type_vouchers` (`id`);
