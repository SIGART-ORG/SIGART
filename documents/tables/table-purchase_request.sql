--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sites_id` int(10) UNSIGNED NOT NULL COMMENT 'Id de la sede.',
  `user_reg` int(11) NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Solicitud de compra\n Contendra las solicitudes de compras generadas.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_request_sites_id_foreign` (`sites_id`),
  ADD KEY `purchase_request_user_reg_index` (`user_reg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD CONSTRAINT `purchase_request_sites_id_foreign` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`);
