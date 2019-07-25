--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `services_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla servicio( services ).',
  `type_vouchers_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tipo de comprobante( type_vouchers ).',
  `type_payment_methods_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tipo de método de pago( type_payment_methods ).',
  `serial_doc` varchar(3) NOT NULL COMMENT 'Serie de la venta.',
  `number_doc` varchar(6) NOT NULL COMMENT 'Número de la venta.',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto total de la venta sin el IGV.',
  `igv` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del IGV del total de la venta.',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Monto del total de la venta(inc IGV).',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente de pago\n 2: Anulado,\n 3: Pagado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_services_id_foreign` (`services_id`),
  ADD KEY `sales_type_vouchers_id_foreign` (`type_vouchers_id`),
  ADD KEY `sales_type_payment_methods_id_foreign` (`type_payment_methods_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_services_id_foreign` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `sales_type_payment_methods_id_foreign` FOREIGN KEY (`type_payment_methods_id`) REFERENCES `type_payment_methods` (`id`),
  ADD CONSTRAINT `sales_type_vouchers_id_foreign` FOREIGN KEY (`type_vouchers_id`) REFERENCES `type_vouchers` (`id`);

