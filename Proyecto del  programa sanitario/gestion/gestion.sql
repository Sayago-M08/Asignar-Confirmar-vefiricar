-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2026 a las 17:44:43
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
-- Base de datos: `gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `dni_admin` int(11) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `contraseña` int(10) NOT NULL,
  `gmail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`dni_admin`, `nombre_completo`, `contraseña`, `gmail`) VALUES
(48574837, 'Mateo Sayago', 123, 'mateo@gmail.com\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupos` int(11) NOT NULL,
  `numero_grupo` int(100) NOT NULL,
  `nombre_grupo` varchar(100) NOT NULL,
  `id_tareas` int(11) NOT NULL,
  `id_operativo` int(11) NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_promotoras`
--

CREATE TABLE `grupos_promotoras` (
  `id_grupo_promotas` int(11) NOT NULL,
  `id_grupos` int(11) NOT NULL,
  `dni_promotoras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `id_lugar` int(11) NOT NULL,
  `lugar` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `localidad` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaivos`
--

CREATE TABLE `operaivos` (
  `id_operativos` int(11) NOT NULL,
  `opearativos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotoras`
--

CREATE TABLE `promotoras` (
  `dni_promotoras` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `domiciolio` varchar(100) NOT NULL,
  `contraseña` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tareas` int(11) NOT NULL,
  `tareas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`dni_admin`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupos`),
  ADD UNIQUE KEY `id_operativo` (`id_operativo`,`id_lugar`),
  ADD KEY `id_tareas` (`id_tareas`),
  ADD KEY `id_lugar` (`id_lugar`),
  ADD KEY `id_tareas_2` (`id_tareas`,`id_operativo`,`id_lugar`);

--
-- Indices de la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  ADD PRIMARY KEY (`id_grupo_promotas`),
  ADD KEY `id_grupos` (`id_grupos`),
  ADD KEY `dni_promotoras` (`dni_promotoras`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`id_lugar`);

--
-- Indices de la tabla `operaivos`
--
ALTER TABLE `operaivos`
  ADD PRIMARY KEY (`id_operativos`);

--
-- Indices de la tabla `promotoras`
--
ALTER TABLE `promotoras`
  ADD PRIMARY KEY (`dni_promotoras`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tareas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  MODIFY `id_grupo_promotas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operaivos`
--
ALTER TABLE `operaivos`
  MODIFY `id_operativos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `promotoras`
--
ALTER TABLE `promotoras`
  MODIFY `dni_promotoras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tareas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_lugar`) REFERENCES `lugar` (`id_lugar`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`id_tareas`) REFERENCES `tareas` (`id_tareas`),
  ADD CONSTRAINT `grupos_ibfk_3` FOREIGN KEY (`id_operativo`) REFERENCES `operaivos` (`id_operativos`);

--
-- Filtros para la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  ADD CONSTRAINT `grupos_promotoras_ibfk_1` FOREIGN KEY (`dni_promotoras`) REFERENCES `promotoras` (`dni_promotoras`),
  ADD CONSTRAINT `grupos_promotoras_ibfk_2` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
