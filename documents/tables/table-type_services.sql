--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_services`
--

CREATE TABLE `type_services` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `name` varchar(60) NOT NULL COMMENT 'Nombre del servicio',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TABLA: Tipos de servicios: \n Contiene los registros de todos los servicios que se ofrecen.';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `type_services`
--
ALTER TABLE `type_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `type_services`
--
ALTER TABLE `type_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
