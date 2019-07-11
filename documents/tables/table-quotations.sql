--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED NOT NULL,
  `providers_id` bigint(20) UNSIGNED NOT NULL,
  `user_reg` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `attach` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Cotizaciones de compras';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `quotations_providers_id_foreign` (`providers_id`),
  ADD KEY `quotations_user_reg_index` (`user_reg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_providers_id_foreign` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`),
  ADD CONSTRAINT `quotations_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_request` (`id`);

