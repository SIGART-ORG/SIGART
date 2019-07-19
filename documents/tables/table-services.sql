--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro',
  `service_requests_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de solicitud de servicio( service_requests ).',
  `serial_doc` varchar(3) NOT NULL COMMENT 'Serie del servicio.',
  `number_doc` varchar(6) NOT NULL COMMENT 'Número del servicio.',
  `user_reg` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de usuario que realizó el registro.',
  `user_aproved` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de usuario que aprobó el servicio.',
  `is_aproved_customer` int(11) NOT NULL DEFAULT '0' COMMENT 'Aprobación del servicio por parte del cliente:\n 1:Pendiente de aprobación.\n 2: Aprobado.\n 3: No aprobado.',
  `date_reg` date NOT NULL COMMENT 'Fecha de ingreso de la solicitud.',
  `date_aproved` date NOT NULL COMMENT 'Fecha de aprovación del servicio por la empresa.',
  `date_aproved_customer` date NOT NULL COMMENT 'Fecha de aprovación del servicio por parte del liente..',
  `description` text NOT NULL COMMENT 'Descripción general de la solicitud de servicio.',
  `observation` text COMMENT 'Observación sobre la solicitud de servicio.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Servicios: \n Contiene los registros de los servicios.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_service_requests_id_foreign` (`service_requests_id`),
  ADD KEY `services_user_reg_index` (`user_reg`),
  ADD KEY `services_user_aproved_index` (`user_aproved`),
  ADD KEY `services_is_aproved_customer_index` (`is_aproved_customer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_service_requests_id_foreign` FOREIGN KEY (`service_requests_id`) REFERENCES `service_requests` (`id`);
