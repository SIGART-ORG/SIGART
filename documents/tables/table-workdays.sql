--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `workdays`
--

CREATE TABLE `workdays` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `assigned_workers_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla trabajadores asigandos( assigned_workers ).',
  `day` datetime NOT NULL COMMENT 'Día.',
  `description` text NOT NULL COMMENT 'Descripción.',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Registro de estado:\n0: Desactivado.\n1: Activo.\n2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `workdays`
--
ALTER TABLE `workdays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `workdays`
--
ALTER TABLE `workdays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
