--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_requirements`
--

CREATE TABLE `task_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `tasks_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla tareas( tasks ).',
  `presentation_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla presentaciones ( Presentation ).',
  `quantity` int(11) NOT NULL COMMENT 'Cantidad de producto.',
  `assumed_customer` int(11) NOT NULL COMMENT 'Registro para identificar si el materiales necesarios los traera el cliente.\n0: El Cliente los traera.\n1: Se retirará del almacen.',
  `price` decimal(10,2) NOT NULL COMMENT 'Costo del material utilizado.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_requirements`
--
ALTER TABLE `task_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_requirements_tasks_id_foreign` (`tasks_id`),
  ADD KEY `task_requirements_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_requirements`
--
ALTER TABLE `task_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_requirements`
--
ALTER TABLE `task_requirements`
  ADD CONSTRAINT `task_requirements_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `task_requirements_tasks_id_foreign` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`);

