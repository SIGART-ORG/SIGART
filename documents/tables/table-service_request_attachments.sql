--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_request_attachments`
--

CREATE TABLE `service_request_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `service_requests_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de solicitud de servicio( service_requests ).',
  `file_name` varchar(100) NOT NULL COMMENT 'Nombre del archivo adjunto',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Solicitudes de servicios - adjunto: \n Contiene los archivos adjuntos en la solicitud de servicio.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `service_request_attachments`
--
ALTER TABLE `service_request_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_request_attachments_service_requests_id_foreign` (`service_requests_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `service_request_attachments`
--
ALTER TABLE `service_request_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `service_request_attachments`
--
ALTER TABLE `service_request_attachments`
  ADD CONSTRAINT `service_request_attachments_service_requests_id_foreign` FOREIGN KEY (`service_requests_id`) REFERENCES `service_requests` (`id`);
