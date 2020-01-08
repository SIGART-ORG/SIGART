--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `service_stages`
--

CREATE TABLE `service_stages` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro',
  `services_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla servicio( services ).',
  `name` varchar(20) NOT NULL COMMENT 'Nombre de la etapa del servicio.',
  `date_start` date NOT NULL COMMENT 'Fecha de inicio de la etapa.',
  `date_end` date NOT NULL COMMENT 'Fecha de culminación de la etapa.',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Registro para identificar si la etapa se planifico o no al iniciar el servicio.\n0: Planificado.\n1: Ajuste.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Registro de estado:\n0: Desactivado.\n1: Activo.\n2:Eliminado.\n3:En proceso.\n4: Terminado.\n5: Cerrado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Etapas de servicio: \n Contiene las etapas del servicio.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `service_stages`
--
ALTER TABLE `service_stages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_stages_services_id_foreign` (`services_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `service_stages`
--
ALTER TABLE `service_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_stages`
--
ALTER TABLE `service_stages`
  ADD CONSTRAINT `service_stages_services_id_foreign` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);
