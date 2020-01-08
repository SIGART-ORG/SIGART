--
-- Database: `d_pintart`
--

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `type_person` int(11) NOT NULL DEFAULT '1',
  `document` varchar(20) NOT NULL,
  `type_document` int(11) NOT NULL DEFAULT '1',
  `legal_representative` varchar(100) DEFAULT NULL,
  `document_lp` varchar(20) DEFAULT NULL,
  `type_document_lp` int(11) DEFAULT '1',
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `district_id` char(6) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `providers_type_person_index` (`type_person`),
  ADD KEY `providers_district_id_index` (`district_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
