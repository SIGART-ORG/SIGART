--
-- Base de datos: `d_pintart`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms`
--

CREATE TABLE `sms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_user_index` (`user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
