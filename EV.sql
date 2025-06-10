-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2025 a las 19:54:51
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `EV`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Acordes`
--

CREATE TABLE `Acordes` (
  `acorde_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Acordes`
--

INSERT INTO `Acordes` (`acorde_id`, `nombre`) VALUES
(1, 'A'),
(2, 'A#'),
(3, 'A#m'),
(4, 'A#°'),
(5, 'Ab'),
(6, 'Abm'),
(7, 'Ab°'),
(8, 'Am'),
(9, 'A°'),
(10, 'B'),
(11, 'Bb'),
(12, 'Bbm'),
(13, 'Bb°'),
(14, 'Bm'),
(15, 'B°'),
(16, 'C'),
(17, 'C#'),
(18, 'C#m'),
(19, 'C#°'),
(20, 'Cb'),
(21, 'Cbm'),
(22, 'Cb°'),
(23, 'Cm'),
(24, 'C°'),
(25, 'D'),
(26, 'D#'),
(27, 'D#m'),
(28, 'D#°'),
(29, 'Db'),
(30, 'Dbm'),
(31, 'Db°'),
(32, 'Dm'),
(33, 'D°'),
(34, 'E'),
(35, 'Eb'),
(36, 'Ebm'),
(37, 'Eb°'),
(38, 'Em'),
(39, 'E°'),
(40, 'F'),
(41, 'F#'),
(42, 'F#m'),
(43, 'F#°'),
(44, 'Fb'),
(45, 'Fbm'),
(46, 'Fb°'),
(47, 'Fm'),
(48, 'F°'),
(49, 'G'),
(50, 'G#'),
(51, 'G#m'),
(52, 'G#°'),
(53, 'Gb'),
(54, 'Gbm'),
(55, 'Gb°'),
(56, 'Gm'),
(57, 'G°');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Acordes_Canciones`
--

CREATE TABLE `Acordes_Canciones` (
  `cancion_id` int(11) NOT NULL,
  `coordenada_x` float NOT NULL,
  `coordenada_y` int(11) NOT NULL,
  `grado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Acordes_Tonalidades`
--

CREATE TABLE `Acordes_Tonalidades` (
  `acorde_id` int(11) NOT NULL,
  `tonalidad_id` int(11) NOT NULL,
  `grado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Acordes_Tonalidades`
--

INSERT INTO `Acordes_Tonalidades` (`acorde_id`, `tonalidad_id`, `grado`) VALUES
(1, 2, '5'),
(1, 3, '4'),
(1, 6, '1'),
(1, 14, '7'),
(1, 19, '7'),
(4, 7, '7'),
(5, 8, '6'),
(5, 9, '6'),
(5, 11, '3'),
(5, 15, '5'),
(5, 16, '4'),
(5, 17, '2'),
(5, 18, '1'),
(8, 1, '6'),
(8, 4, '3'),
(8, 5, '2'),
(8, 9, '5'),
(8, 10, '4'),
(8, 13, '1'),
(9, 12, '2'),
(10, 3, '5'),
(10, 7, '1'),
(11, 4, '4'),
(11, 8, '7'),
(11, 9, '7'),
(11, 11, '4'),
(11, 12, '3'),
(11, 15, '6'),
(11, 16, '5'),
(11, 17, '3'),
(11, 18, '2'),
(11, 19, '1'),
(14, 2, '6'),
(14, 5, '3'),
(14, 6, '2'),
(14, 10, '5'),
(14, 14, '1'),
(15, 1, '7'),
(15, 13, '2'),
(16, 1, '1'),
(16, 4, '5'),
(16, 5, '4'),
(16, 10, '6'),
(16, 11, '5'),
(16, 12, '4'),
(16, 13, '3'),
(16, 15, '7'),
(16, 16, '6'),
(16, 18, '3'),
(16, 19, '2'),
(18, 3, '6'),
(18, 6, '3'),
(18, 7, '2'),
(19, 2, '7'),
(19, 14, '2'),
(20, 17, '4'),
(23, 8, '1'),
(25, 2, '1'),
(25, 5, '5'),
(25, 6, '4'),
(25, 10, '7'),
(25, 14, '3'),
(25, 16, '7'),
(25, 19, '3'),
(27, 7, '3'),
(28, 3, '7'),
(29, 11, '6'),
(29, 15, '1'),
(29, 17, '5'),
(29, 18, '4'),
(32, 1, '2'),
(32, 4, '6'),
(32, 9, '1'),
(32, 12, '5'),
(32, 13, '4'),
(33, 8, '2'),
(34, 3, '1'),
(34, 6, '5'),
(34, 7, '4'),
(35, 8, '3'),
(35, 11, '7'),
(35, 12, '6'),
(35, 15, '2'),
(35, 16, '1'),
(35, 17, '6'),
(35, 18, '5'),
(35, 19, '4'),
(38, 1, '3'),
(38, 2, '2'),
(38, 5, '6'),
(38, 10, '1'),
(38, 13, '5'),
(38, 14, '4'),
(39, 4, '7'),
(39, 9, '2'),
(40, 1, '4'),
(40, 4, '1'),
(40, 9, '3'),
(40, 12, '7'),
(40, 13, '6'),
(40, 15, '3'),
(40, 16, '2'),
(40, 17, '7'),
(40, 18, '6'),
(40, 19, '5'),
(41, 7, '5'),
(42, 2, '3'),
(42, 3, '2'),
(42, 6, '6'),
(42, 14, '5'),
(43, 5, '7'),
(43, 10, '2'),
(47, 8, '4'),
(47, 11, '1'),
(49, 1, '5'),
(49, 2, '4'),
(49, 5, '1'),
(49, 10, '3'),
(49, 13, '7'),
(49, 14, '6'),
(49, 16, '3'),
(49, 18, '7'),
(49, 19, '6'),
(51, 3, '3'),
(51, 7, '6'),
(52, 6, '7'),
(53, 15, '4'),
(53, 17, '1'),
(56, 4, '2'),
(56, 8, '5'),
(56, 9, '4'),
(56, 12, '1'),
(57, 11, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Canciones`
--

CREATE TABLE `Canciones` (
  `cancion_id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `tonalidad_id` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `compas` varchar(10) NOT NULL DEFAULT '4/4',
  `genero` varchar(25) NOT NULL,
  `tempo` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Canciones_Eventos`
--

CREATE TABLE `Canciones_Eventos` (
  `evento_id` int(11) NOT NULL,
  `cancion_id` int(11) NOT NULL,
  `nueva_tonalidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estructuras_Canciones`
--

CREATE TABLE `Estructuras_Canciones` (
  `estructura_id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `posicion_y` int(11) NOT NULL,
  `cancion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE `Eventos` (
  `evento_id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `nombre_evento` varchar(255) NOT NULL,
  `fecha_evento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Grupos`
--

CREATE TABLE `Grupos` (
  `grupo_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `suscripcion_estado` enum('activa','expirada','cancelada') NOT NULL DEFAULT 'activa',
  `suscripcion_expira_en` date DEFAULT NULL,
  `stripe_customer_id` varchar(255) NOT NULL,
  `stripe_subscription_id` varchar(255) NOT NULL,
  `termsConditions` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `plan_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Letras_Canciones`
--

CREATE TABLE `Letras_Canciones` (
  `letra_id` int(11) NOT NULL,
  `coordenada_y` int(11) NOT NULL,
  `cancion_id` int(11) NOT NULL,
  `letra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `language` varchar(10) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `token` varchar(32) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0,
  `promotions` int(11) DEFAULT 0,
  `termsConditions` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `plan_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `max_canciones` int(11) DEFAULT NULL,
  `max_usuarios` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`plan_id`, `nombre`, `max_canciones`, `max_usuarios`, `precio`) VALUES
(1, 'free', 3, 3, 0.00),
(2, 'pro', 20, 20, 9.99),
(3, 'premium', 50, 50, 19.99),
(4, 'especial', NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_password_tokens`
--

CREATE TABLE `reset_password_tokens` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tonalidades`
--

CREATE TABLE `Tonalidades` (
  `tonalidad_id` int(11) NOT NULL,
  `nombre` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Tonalidades`
--

INSERT INTO `Tonalidades` (`tonalidad_id`, `nombre`) VALUES
(1, 'C'),
(2, 'D'),
(3, 'E'),
(4, 'F'),
(5, 'G'),
(6, 'A'),
(7, 'B'),
(8, 'Cm'),
(9, 'Dm'),
(10, 'Em'),
(11, 'Fm'),
(12, 'Gm'),
(13, 'Am'),
(14, 'Bm'),
(15, 'Db'),
(16, 'Eb'),
(17, 'Gb'),
(18, 'Ab'),
(19, 'Bb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `language` int(11) NOT NULL DEFAULT 1,
  `img` varchar(255) DEFAULT 'default_img',
  `actual_group` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `promotions` int(11) NOT NULL DEFAULT 0,
  `session_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios_Grupos`
--

CREATE TABLE `Usuarios_Grupos` (
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `rol` enum('admin','colaborador','normal') NOT NULL DEFAULT 'normal',
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','pendiente','rechazado') NOT NULL DEFAULT 'pendiente',
  `visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Acordes`
--
ALTER TABLE `Acordes`
  ADD PRIMARY KEY (`acorde_id`);

--
-- Indices de la tabla `Acordes_Canciones`
--
ALTER TABLE `Acordes_Canciones`
  ADD PRIMARY KEY (`cancion_id`,`coordenada_x`,`coordenada_y`),
  ADD KEY `acorde_id` (`grado`);

--
-- Indices de la tabla `Acordes_Tonalidades`
--
ALTER TABLE `Acordes_Tonalidades`
  ADD PRIMARY KEY (`acorde_id`,`tonalidad_id`),
  ADD KEY `tonalidad_id` (`tonalidad_id`);

--
-- Indices de la tabla `Canciones`
--
ALTER TABLE `Canciones`
  ADD PRIMARY KEY (`cancion_id`),
  ADD KEY `grupo_id` (`grupo_id`),
  ADD KEY `tonalidad_id` (`tonalidad_id`);

--
-- Indices de la tabla `Canciones_Eventos`
--
ALTER TABLE `Canciones_Eventos`
  ADD PRIMARY KEY (`evento_id`,`cancion_id`,`nueva_tonalidad`),
  ADD KEY `cancion_id` (`cancion_id`);

--
-- Indices de la tabla `Estructuras_Canciones`
--
ALTER TABLE `Estructuras_Canciones`
  ADD PRIMARY KEY (`estructura_id`),
  ADD KEY `cancion_id` (`cancion_id`);

--
-- Indices de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD PRIMARY KEY (`evento_id`),
  ADD KEY `grupo_id` (`grupo_id`);

--
-- Indices de la tabla `Grupos`
--
ALTER TABLE `Grupos`
  ADD PRIMARY KEY (`grupo_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_grupo_plan` (`plan_id`);

--
-- Indices de la tabla `Letras_Canciones`
--
ALTER TABLE `Letras_Canciones`
  ADD PRIMARY KEY (`letra_id`),
  ADD KEY `cancion_id` (`cancion_id`);

--
-- Indices de la tabla `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indices de la tabla `reset_password_tokens`
--
ALTER TABLE `reset_password_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `Tonalidades`
--
ALTER TABLE `Tonalidades`
  ADD PRIMARY KEY (`tonalidad_id`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `Usuarios_Grupos`
--
ALTER TABLE `Usuarios_Grupos`
  ADD PRIMARY KEY (`usuario_id`,`grupo_id`),
  ADD KEY `grupo_id` (`grupo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Acordes`
--
ALTER TABLE `Acordes`
  MODIFY `acorde_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `Acordes_Canciones`
--
ALTER TABLE `Acordes_Canciones`
  MODIFY `cancion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `Canciones`
--
ALTER TABLE `Canciones`
  MODIFY `cancion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `Estructuras_Canciones`
--
ALTER TABLE `Estructuras_Canciones`
  MODIFY `estructura_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  MODIFY `evento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Grupos`
--
ALTER TABLE `Grupos`
  MODIFY `grupo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `Letras_Canciones`
--
ALTER TABLE `Letras_Canciones`
  MODIFY `letra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reset_password_tokens`
--
ALTER TABLE `reset_password_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Tonalidades`
--
ALTER TABLE `Tonalidades`
  MODIFY `tonalidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Acordes_Canciones`
--
ALTER TABLE `Acordes_Canciones`
  ADD CONSTRAINT `acordes_canciones_ibfk_2` FOREIGN KEY (`cancion_id`) REFERENCES `Canciones` (`cancion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Acordes_Tonalidades`
--
ALTER TABLE `Acordes_Tonalidades`
  ADD CONSTRAINT `acordes_tonalidades_ibfk_1` FOREIGN KEY (`acorde_id`) REFERENCES `Acordes` (`acorde_id`),
  ADD CONSTRAINT `acordes_tonalidades_ibfk_2` FOREIGN KEY (`tonalidad_id`) REFERENCES `Tonalidades` (`tonalidad_id`);

--
-- Filtros para la tabla `Canciones`
--
ALTER TABLE `Canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `Grupos` (`grupo_id`),
  ADD CONSTRAINT `canciones_ibfk_2` FOREIGN KEY (`tonalidad_id`) REFERENCES `Tonalidades` (`tonalidad_id`);

--
-- Filtros para la tabla `Canciones_Eventos`
--
ALTER TABLE `Canciones_Eventos`
  ADD CONSTRAINT `canciones_eventos_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `Eventos` (`evento_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canciones_eventos_ibfk_2` FOREIGN KEY (`cancion_id`) REFERENCES `Canciones` (`cancion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Estructuras_Canciones`
--
ALTER TABLE `Estructuras_Canciones`
  ADD CONSTRAINT `estructuras_canciones_ibfk_1` FOREIGN KEY (`cancion_id`) REFERENCES `Canciones` (`cancion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `Grupos` (`grupo_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Grupos`
--
ALTER TABLE `Grupos`
  ADD CONSTRAINT `fk_grupo_plan` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`plan_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Letras_Canciones`
--
ALTER TABLE `Letras_Canciones`
  ADD CONSTRAINT `letras_canciones_ibfk_1` FOREIGN KEY (`cancion_id`) REFERENCES `Canciones` (`cancion_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reset_password_tokens`
--
ALTER TABLE `reset_password_tokens`
  ADD CONSTRAINT `reset_password_tokens_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `Usuarios` (`usuario_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Usuarios_Grupos`
--
ALTER TABLE `Usuarios_Grupos`
  ADD CONSTRAINT `usuarios_grupos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `Usuarios` (`usuario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_grupos_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `Grupos` (`grupo_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
