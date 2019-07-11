--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `input_orders`
--

CREATE TABLE `input_orders` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registo de orden de entrada.',
  `purchase_orders_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la orden de compra ( Purchase_orders ).',
  `code` varchar(15) NOT NULL COMMENT 'Código interno de la orden de entrada',
  `date_input_reg` date NOT NULL COMMENT 'Fecha de emisión de la orden de entrada.',
  `user_reg` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de usuario que ingreso el registro.',
  `date_input` date NOT NULL COMMENT 'Fecha que se entraron los productos al almacen.',
  `user_input` int(11) NOT NULL DEFAULT '0' COMMENT 'Id del almacenero que recibe los productos.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Generado\n 2: Anulado,\n 3: Entregado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Orden de entrada - detalle: \n Contiene los datos de las ordenes de entrada';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `input_orders`
--
ALTER TABLE `input_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `input_orders_purchase_orders_id_foreign` (`purchase_orders_id`),
  ADD KEY `input_orders_user_reg_index` (`user_reg`),
  ADD KEY `input_orders_user_input_index` (`user_input`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `input_orders`
--
ALTER TABLE `input_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registo de orden de entrada.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `input_orders`
--
ALTER TABLE `input_orders`
  ADD CONSTRAINT `input_orders_purchase_orders_id_foreign` FOREIGN KEY (`purchase_orders_id`) REFERENCES `purchase_orders` (`id`);

