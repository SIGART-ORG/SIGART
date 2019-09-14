--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `value_serv_reqs`
--

CREATE TABLE `value_serv_reqs` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `service_request_details_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla detalle de solicitud de servicio( service_request_details ).',
  `parameters_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla parametros( parameters ).',
  `value` varchar(5) NOT NULL COMMENT 'Valor asignado.',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Estado del registro: \n 0: Desactivado.\n 1: Activado.\n 2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Valores de parametros: \n Contiene los valores de los parametros de los items de la solicitud de servicio.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `value_serv_reqs`
--
ALTER TABLE `value_serv_reqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `value_serv_reqs_service_request_details_id_foreign` (`service_request_details_id`),
  ADD KEY `value_serv_reqs_parameters_id_foreign` (`parameters_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `value_serv_reqs`
--
ALTER TABLE `value_serv_reqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `value_serv_reqs`
--
ALTER TABLE `value_serv_reqs`
  ADD CONSTRAINT `value_serv_reqs_parameters_id_foreign` FOREIGN KEY (`parameters_id`) REFERENCES `parameters` (`id`),
  ADD CONSTRAINT `value_serv_reqs_service_request_details_id_foreign` FOREIGN KEY (`service_request_details_id`) REFERENCES `service_request_details` (`id`);
