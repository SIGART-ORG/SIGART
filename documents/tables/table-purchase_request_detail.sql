--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request_detail`
--

CREATE TABLE `purchase_request_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_request_id` bigint(20) UNSIGNED NOT NULL,
  `presentation_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Detalle de solicitud de compra';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_request_detail`
--
ALTER TABLE `purchase_request_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_request_detail_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `purchase_request_detail_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_request_detail`
--
ALTER TABLE `purchase_request_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_request_detail`
--
ALTER TABLE `purchase_request_detail`
  ADD CONSTRAINT `purchase_request_detail_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `purchase_request_detail_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_request` (`id`);
