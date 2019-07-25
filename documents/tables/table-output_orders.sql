--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `output_orders`
--

CREATE TABLE `output_orders` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de registro',
  `sales_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Id de la tabla venta( sales ).',
  `code` varchar(15) NOT NULL COMMENT 'Código interno de la orden de salida',
  `date_input_reg` date NOT NULL COMMENT 'Fecha de emisión de la orden de salida.',
  `user_reg` int(11) NOT NULL DEFAULT 0 COMMENT 'Id de usuario que ingreso el registro.',
  `date_output` date NOT NULL COMMENT 'Fecha que se entraron los productos al almacen.',
  `user_input` int(11) NOT NULL DEFAULT 0 COMMENT 'Id del almacenero que entrega los productos.',
  `user_output` int(11) NOT NULL DEFAULT 0 COMMENT 'Id de trabajador que recibe los productos.',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT 'Estado del registro: \n 0: Desactivado\n 1: Generado\n 2: Anulado,\n 3: Entregado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `output_orders`
--
ALTER TABLE `output_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `output_orders_sales_id_foreign` (`sales_id`),
  ADD KEY `output_orders_user_reg_index` (`user_reg`),
  ADD KEY `output_orders_user_input_index` (`user_input`),
  ADD KEY `output_orders_user_output_index` (`user_output`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `output_orders`
--
ALTER TABLE `output_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id de registro';
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `output_orders`
--
ALTER TABLE `output_orders`
  ADD CONSTRAINT `output_orders_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`);

