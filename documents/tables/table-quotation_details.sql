--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotations_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla cotizaciones ( Quotations )',
  `presentation_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla presentaciones ( Presentation ).',
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `selected` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Cotizaciones de compras - detalles';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_details_quotations_id_foreign` (`quotations_id`),
  ADD KEY `quotation_details_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD CONSTRAINT `quotation_details_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `quotation_details_quotations_id_foreign` FOREIGN KEY (`quotations_id`) REFERENCES `quotations` (`id`);
