--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentation_images`
--

CREATE TABLE `presentation_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `presentation_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla presentaciones( presentation ).',
  `image_original` varchar(191) NOT NULL COMMENT 'Archivo original que se envio en el formulario.',
  `order` int(11) NOT NULL COMMENT 'Orden en el que mostraran las imagenes.',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Activo\n 2: Eliminado.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `presentation_images`
--
ALTER TABLE `presentation_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presentation_images_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `presentation_images`
--
ALTER TABLE `presentation_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `presentation_images`
--
ALTER TABLE `presentation_images`
  ADD CONSTRAINT `presentation_images_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`);
