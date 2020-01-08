--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_workers`
--

CREATE TABLE `assigned_workers` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id registro.',
  `tasks_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla tareas( task ).',
  `users_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla usuarios( users ).',
  `user_in_charge` enum('0','1') NOT NULL COMMENT 'Registro para identificar si el usuario es responsable de la tarea asignada.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_workers`
--
ALTER TABLE `assigned_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_workers_tasks_id_foreign` (`tasks_id`),
  ADD KEY `assigned_workers_users_id_foreign` (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_workers`
--
ALTER TABLE `assigned_workers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_workers`
--
ALTER TABLE `assigned_workers`
  ADD CONSTRAINT `assigned_workers_tasks_id_foreign` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `assigned_workers_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
