--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `type_payment_methods`
--

CREATE TABLE `type_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id del registro del tipo de método de pago.',
  `name` varchar(30) NOT NULL COMMENT 'Nombre del tipo del método de pago.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Tipo de método de pago.\n Tabla que contendra los registros de tipos de métodos de pago.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `type_payment_methods`
--
ALTER TABLE `type_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `type_payment_methods`
--
ALTER TABLE `type_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id del registro del tipo de método de pago.';
