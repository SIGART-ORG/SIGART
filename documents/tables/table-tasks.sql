--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro',
  `service_stages_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla etapas del servicio( service_stages ).',
  `date_start_prog` datetime NOT NULL COMMENT 'Fecha de inicio programado de la tarea',
  `name` varchar(20) NOT NULL COMMENT 'Nombre de la tarea.',
  `description` text NOT NULL COMMENT 'Descrición de la tarea.',
  `date_end_prog` datetime NOT NULL COMMENT 'Fecha de culminación programado de la tarea.',
  `date_start` datetime NOT NULL COMMENT 'Fecha de inicio de la tarea',
  `date_end` datetime NOT NULL COMMENT 'Fecha de culminación de la tarea.',
  `observation` text NOT NULL COMMENT 'Registro de observaciones generados al realizar la tarea.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Registro de estado:\n0: Desactivado.\n1: Activo.\n2:Eliminado.\n3:En proceso.\n4: Terminado.\n5: Cerrado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_service_stages_id_foreign` (`service_stages_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_service_stages_id_foreign` FOREIGN KEY (`service_stages_id`) REFERENCES `service_stages` (`id`);
