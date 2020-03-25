-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-03-2020 a las 01:00:42
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente`
--

CREATE TABLE `expediente` (
  `id_expediente` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `comentario` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(11) NOT NULL,
  `nombre_externo` varchar(50) NOT NULL,
  `nombre_interno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `nombre_externo`, `nombre_interno`) VALUES
(1, 'Expedientes', 'adm_expediente'),
(2, 'Usuarios', 'adm_usuario'),
(3, 'Turnos', 'adm_turno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Doctor'),
(3, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_permiso`
--

CREATE TABLE `tipo_permiso` (
  `id_tipo` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_permiso`
--

INSERT INTO `tipo_permiso` (`id_tipo`, `id_permiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `id_turno` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicial` time DEFAULT NULL,
  `hora_final` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `contrasena`, `fecha_creacion`, `id_tipo`) VALUES
(1, 'admin', 'admin', '2020-03-23', 1),
(2, 'bucaro', '1234', '2020-03-23', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita`
--

CREATE TABLE `visita` (
  `id_visita` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `comentario` varchar(5000) DEFAULT NULL,
  `id_expediente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`id_expediente`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tipo_permiso`
--
ALTER TABLE `tipo_permiso`
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`id_turno`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_expediente` (`id_expediente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id_expediente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `visita`
--
ALTER TABLE `visita`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tipo_permiso`
--
ALTER TABLE `tipo_permiso`
  ADD CONSTRAINT `tipo_permiso_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `tipo_permiso_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id_permiso`);

--
-- Filtros para la tabla `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `turno_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`id_expediente`) REFERENCES `expediente` (`id_expediente`),
  ADD CONSTRAINT `visita_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
