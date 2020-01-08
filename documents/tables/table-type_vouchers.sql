--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `type_vouchers`
--

CREATE TABLE `type_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id del registro del tipo de comprobante.',
  `name` varchar(30) NOT NULL COMMENT 'Nombre del tipo de comprobante.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente\n 2: Eliminado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Tipo de comprobante.\n Tabla que contendra los registros de tipos comprobantes.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `type_vouchers`
--
ALTER TABLE `type_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `type_vouchers`
--
ALTER TABLE `type_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id del registro del tipo de comprobante.';
