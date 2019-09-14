--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `url` varchar(100) NOT NULL,
  `view_panel` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `module_id`, `name`, `icon`, `url`, `view_panel`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Módulos', '', 'module/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(2, 2, 'Colaboradores', '', 'user/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(3, 2, 'Rol de usuario', '', 'role/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(4, 1, 'Páginas', '', 'page/dashboard', 0, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(5, 2, 'Accesos', '', 'access/dashboard', 0, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(6, 3, 'Iconos', '', 'icons/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(7, 3, 'Sedes', '', 'sites/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(8, 3, 'Categorias de productos', '', 'categories/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(9, 4, 'Feriados', '', 'holidays/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(10, 4, 'Google Calendar', '', 'calendar/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(11, 3, 'Unidad de medida', '', 'unity/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(12, 1, 'Log', '', 'logs/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(13, 1, 'Acceder como colaborador', '', 'loginUser/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(14, 5, 'Productos', '', 'products/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(15, 6, 'Clientes', '', 'customers/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(16, 7, 'Proveedores/dashboard', '', 'providers', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(17, 5, 'Stock', '', 'stock/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(18, 6, 'Solicitudes de compra', '', 'purchase-request/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20'),
(19, 6, 'Cotizaciones', '', 'quotations/dashboard', 1, 1, '2019-07-15 22:42:20', '2019-07-15 22:42:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_module_id_foreign` (`module_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);
