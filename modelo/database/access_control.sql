-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2022 a las 21:43:19
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `access_control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE `access` (
  `id_access` int(11) NOT NULL,
  `arrival` time DEFAULT NULL,
  `deserted` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `access`
--

INSERT INTO `access` (`id_access`, `arrival`, `deserted`, `date`, `id_user`) VALUES
(1, '06:00:00', '12:00:00', '2022-02-22', 6),
(2, '06:00:00', '12:00:00', '2022-02-22', 6),
(3, '06:00:00', '12:00:00', '2022-02-22', 6),
(4, '06:00:00', '12:00:00', '2022-02-22', 6),
(5, '06:00:00', '12:00:00', '2022-02-22', 6),
(6, '06:00:00', '12:00:00', '2022-02-22', 6),
(7, '07:28:21', '12:00:00', '2022-02-24', 5),
(8, '07:28:21', '12:00:00', '2022-02-24', 5),
(9, '07:28:21', '12:00:00', '2022-02-24', 5),
(10, '07:28:21', '12:00:00', '2022-02-24', 5),
(11, '07:28:21', '12:00:00', '2022-02-24', 5),
(12, '17:27:07', '17:27:59', '2022-04-01', 5),
(13, '17:27:21', '17:28:12', '2022-04-01', 6),
(14, '17:31:55', '17:32:43', '2022-04-01', 5),
(15, '17:58:02', '17:58:26', '2022-04-01', 5),
(16, '18:08:11', '18:08:48', '2022-04-01', 6),
(17, '20:30:14', '20:30:38', '2022-04-01', 5),
(18, '20:40:21', '20:40:38', '2022-04-01', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_document` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `last_name`, `document_type`, `number_document`, `email`, `password`, `state`, `id_type`) VALUES
(1, 'Alfonso', 'Gamez', 'CC', '1031174524', 'alfonso@gmail.com', '$2y$10$wpaQN.xWa7v3VuKfDDjX0.oZVSu.Oh6rpxuZ.Wmw4R7GB92ujbNzy', 'Activo', 2),
(3, 'Dilson', 'Cruz', 'CC', '56420340', 'dil@gmail.com', '$2y$10$IVwLN9lj.E3QMx8E6tWMme.VO6a5DDsoH.IxNiabmoWw7Y4ftKOsC', 'Activo', 1),
(4, 'Tania', 'Quintero', 'CC', '1031174524', 'tania@gmail.com', '$2y$10$FJN6Du3LXFsFPygF4QiAr.G8q127sr0g7mvIxRdHyeQZULu8na.hO', 'Activo', 1),
(5, 'Jorge', 'Albino', 'CC', '1000172759', 'jorge@gmail.com', '$2y$10$Ux3YQC/3L8mGJMebZLbiSu6MOgxNGN4lB.yjtUY/D.KIBk7JkNH6e', 'Activo', 1),
(6, 'Ober', 'Meza', 'CC', '898979791', 'ober@gmail.com', '$2y$10$Wi9S76BceXlgecqqnz6or.u0CKGZycQDqNvBZSIpvfqj.wgXF4d.C', 'Activo', 1),
(8, 'Juan', 'Castro', 'CC', '1031179897', 'juan@gmail.com', '$2y$10$aGfE.F5sX6ALfaCw8MVRHuUsk4IoD.Wpg8lJ1AQFcNYMBGvTywTYu', 'Activo', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_type`
--

CREATE TABLE `user_type` (
  `id_type` int(11) NOT NULL,
  `name_type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_type`
--

INSERT INTO `user_type` (`id_type`, `name_type`) VALUES
(1, 'usuario'),
(2, 'admin'),
(3, 'operador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id_access`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type` (`id_type`);

--
-- Indices de la tabla `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `access`
--
ALTER TABLE `access`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `user_type` (`id_type`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
