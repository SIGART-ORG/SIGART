--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro.',
  `sites_id` int(10) UNSIGNED NOT NULL COMMENT 'Id de la tabla sede( sites ) .',
  `presentation_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla presentaciones ( Presentation ).',
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT 'Stock actual del producto.',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Precio referencial del producto',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_sites_id_foreign` (`sites_id`),
  ADD KEY `stocks_presentation_id_foreign` (`presentation_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_presentation_id_foreign` FOREIGN KEY (`presentation_id`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `stocks_sites_id_foreign` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`);
