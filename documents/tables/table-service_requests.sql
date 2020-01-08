--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_requests`
--

CREATE TABLE `service_requests` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `sites_id` int(10) UNSIGNED NOT NULL COMMENT 'Id de la tabla sede( sites ) .',
  `customers_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tabla cliente( customers).',
  `user_reg` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de usuario que realizó el registro.',
  `user_aproved` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de usuario que aprobó la solicitud de servicio.',
  `date_reg` date NOT NULL COMMENT 'Fecha de ingreso de la solicitud.',
  `date_aproved` date NOT NULL COMMENT 'Fecha de aprovación de la solicitud',
  `description` text NOT NULL COMMENT 'Descripción general de la solicitud de servicio.',
  `observation` text COMMENT 'Observación sobre la solicitud de servicio.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Pendiente de aprobación\n 2: Eliminado,\n 3: Aprobado,\n 4: Cancelado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Solicitudes de servicios - detalle: \n Contiene las solicitudes de servicios ingresados.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_requests_sites_id_foreign` (`sites_id`),
  ADD KEY `service_requests_customers_id_foreign` (`customers_id`),
  ADD KEY `service_requests_user_reg_index` (`user_reg`),
  ADD KEY `service_requests_user_aproved_index` (`user_aproved`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_customers_id_foreign` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `service_requests_sites_id_foreign` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`);
