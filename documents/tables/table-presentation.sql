--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `presentation`
--

CREATE TABLE `presentation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `unity_id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(20) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `description` varchar(50) NOT NULL,
  `equivalence` int(11) NOT NULL DEFAULT '1',
  `stock` int(11) NOT NULL DEFAULT '0',
  `pricetag_purchase` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `presentation`
--
ALTER TABLE `presentation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `presentation_sku_unique` (`sku`),
  ADD UNIQUE KEY `presentation_slug_unique` (`slug`),
  ADD KEY `presentation_products_id_foreign` (`products_id`),
  ADD KEY `presentation_unity_id_foreign` (`unity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `presentation`
--
ALTER TABLE `presentation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `presentation`
--
ALTER TABLE `presentation`
  ADD CONSTRAINT `presentation_products_id_foreign` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `presentation_unity_id_foreign` FOREIGN KEY (`unity_id`) REFERENCES `unity` (`id`);
