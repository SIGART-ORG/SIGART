--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_request_details`
--

CREATE TABLE `service_request_details` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `service_requests_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de solicitud de servicio( service_requests ).',
  `name` varchar(20) NOT NULL COMMENT 'Nombre del item de la solicitud de servicio.',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT 'Cantidad del item de la solicitud de servicio.',
  `description` text COMMENT 'Descripción(opcional) del item de la solicitud de servicio.',
  `assumed_customer` int(11) NOT NULL COMMENT 'Registro para identificar si los materiales necesarios seran sumados en la cotización.\n0: Se considera.\n1: No se considera.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado.\n 1: Activado.\n 2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Solicitudes de servicios - detalle: \n Contiene los detalles de la solicitud de servicio.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `service_request_details`
--
ALTER TABLE `service_request_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_request_details_service_requests_id_foreign` (`service_requests_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `service_request_details`
--
ALTER TABLE `service_request_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `service_request_details`
--
ALTER TABLE `service_request_details`
  ADD CONSTRAINT `service_request_details_service_requests_id_foreign` FOREIGN KEY (`service_requests_id`) REFERENCES `service_requests` (`id`);
