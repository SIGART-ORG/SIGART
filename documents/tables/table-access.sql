--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE `access` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `access`
--

INSERT INTO `access` (`id`, `role_id`, `page_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(2, 1, 2, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(3, 1, 3, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(4, 1, 4, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(5, 1, 5, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(6, 1, 6, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(7, 1, 7, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(8, 1, 8, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(9, 1, 9, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(10, 1, 10, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(11, 1, 11, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(12, 1, 12, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(13, 1, 13, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(14, 1, 14, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(15, 1, 15, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(16, 1, 16, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(17, 1, 17, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(18, 1, 18, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(19, 1, 19, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_role_id_foreign` (`role_id`),
  ADD KEY `access_page_id_foreign` (`page_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `access`
--
ALTER TABLE `access`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `access_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

