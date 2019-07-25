--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`id`, `name`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Seguridad', 'fa-key', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(2, 'Accessos', 'fa-eye', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(3, 'Configuración', 'icon-settings', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(4, 'Eventos', 'icon-calendar', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(5, 'Almacén', 'fa-cubes', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(6, 'Compras', 'fa-shopping-bag', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13'),
(7, 'Ventas', 'fa-shopping-cart', 1, '2019-07-15 22:42:13', '2019-07-15 22:42:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
