--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardexes`
--

CREATE TABLE `kardexes` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'id de registro.',
  `stocks_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla stocks ( stocks ).',
  `input_orders_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Id de la tabla orden de entrada( input_orders ).',
  `output_orders_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Id de la tabla orden de salida( output_orders ).',
  `quantity_input` int(11) NOT NULL DEFAULT 0 COMMENT 'Cantidad de entrada.',
  `quantity_output` int(11) NOT NULL DEFAULT 0 COMMENT 'Cantidad de salida.',
  `total` int(11) NOT NULL DEFAULT 0 COMMENT 'Total.',
  `last_price_unit` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Ultimo precio unitario de producto.',
  `price_unit` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Precio unitario de producto.',
  `price_total` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Precio total del producto( PU * cantidad ).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `kardexes`
--
ALTER TABLE `kardexes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kardexes_stocks_id_foreign` (`stocks_id`),
  ADD KEY `kardexes_input_orders_id_index` (`input_orders_id`),
  ADD KEY `kardexes_output_orders_id_index` (`output_orders_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `kardexes`
--
ALTER TABLE `kardexes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id de registro.';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `kardexes`
--
ALTER TABLE `kardexes`
  ADD CONSTRAINT `kardexes_stocks_id_foreign` FOREIGN KEY (`stocks_id`) REFERENCES `stocks` (`id`);
