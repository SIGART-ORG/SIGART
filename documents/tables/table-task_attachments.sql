--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_attachments`
--

CREATE TABLE `task_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `tasks_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla tareas( task ).',
  `file_name` varchar(20) NOT NULL COMMENT 'Nombre del archivo adjunto.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_attachments_tasks_id_foreign` (`tasks_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_attachments`
--
ALTER TABLE `task_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD CONSTRAINT `task_attachments_tasks_id_foreign` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`);

