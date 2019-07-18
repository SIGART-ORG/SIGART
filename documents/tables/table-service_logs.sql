--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `service_logs`
--

CREATE TABLE `service_logs` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `services_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla servicio( services ).',
  `description` text NOT NULL COMMENT 'Descripción del registro.',
  `binnacles_id` int(11) NOT NULL COMMENT 'Registro del tipo de registro.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `service_logs`
--
ALTER TABLE `service_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_logs_services_id_foreign` (`services_id`),
  ADD KEY `service_logs_binnacles_id_index` (`binnacles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `service_logs`
--
ALTER TABLE `service_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_logs`
--
ALTER TABLE `service_logs`
  ADD CONSTRAINT `service_logs_services_id_foreign` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);
