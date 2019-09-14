--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_images`
--

CREATE TABLE `products_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `image_original` varchar(100) NOT NULL,
  `image_galery` varchar(100) DEFAULT NULL,
  `image_admin` varchar(100) DEFAULT NULL,
  `image_facebook` varchar(100) DEFAULT NULL,
  `image_default` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_images_products_id_foreign` (`products_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `products_images_products_id_foreign` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);
