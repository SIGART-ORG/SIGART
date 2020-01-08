--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `document` varchar(8) NOT NULL,
  `address` varchar(300) NOT NULL,
  `birthday` date NOT NULL,
  `date_entry` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(191) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(9) DEFAULT NULL,
  `img_profile` varchar(60) DEFAULT NULL,
  `img_cover_page` varchar(60) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `document`, `address`, `birthday`, `date_entry`, `email`, `password`, `status`, `phone`, `img_profile`, `img_cover_page`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Julio Alcides', 'Salsavilca Huamanyauri', '47140697', 'Santa Anita', '1991-07-08', '2019-07-15', 'j.salsavilca@gmail.com', '$2y$10$1obu39xfGljn6NoMEwL2i.IzIeWb/CfDTU6qulC1KLOH1QEoxhPbm', 1, NULL, NULL, NULL, NULL, '2019-07-15 22:42:13', '2019-07-15 22:42:13', 1),
(2, 'Jonathan Benjamín', 'Monsefu Gomez', '47166996', 'Naranjal', '1992-07-08', '2019-07-15', 'benjamin.mg.20@gmail.com', '$2y$10$j6x0cS8UMiVrQMvXWyxig.AE2EQVlhRCxsRt2hFIA2gfDk0MfEt9O', 1, NULL, NULL, NULL, NULL, '2019-07-15 22:42:13', '2019-07-15 22:42:13', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
