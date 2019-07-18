--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parameters`
--

CREATE TABLE `parameters` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `type_services_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de tipo de servicio( type_services ).',
  `name` varchar(50) NOT NULL COMMENT 'Nombre del parametro.',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Parametros: \n Contiene los registros de los parametros por tipo de servicio.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parameters_type_services_id_foreign` (`type_services_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `parameters`
--
ALTER TABLE `parameters`
  ADD CONSTRAINT `parameters_type_services_id_foreign` FOREIGN KEY (`type_services_id`) REFERENCES `type_services` (`id`);
