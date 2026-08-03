-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2026 a las 17:48:09
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
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupos` int(11) NOT NULL,
  `numero_grupo` int(100) NOT NULL,
  `nombre_grupo` varchar(100) NOT NULL,
  `id_tareas` int(11) NOT NULL,
  `id_operativo` int(11) NOT NULL,
  `id_lugar` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_grupos_promotoras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupos`, `numero_grupo`, `nombre_grupo`, `id_tareas`, `id_operativo`, `id_lugar`, `fecha`, `id_grupos_promotoras`) VALUES
(1, 1, 'prueba', 1, 1, 1, '2026-07-13', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupos`),
  ADD UNIQUE KEY `id_operativo` (`id_operativo`,`id_lugar`),
  ADD KEY `id_tareas` (`id_tareas`),
  ADD KEY `id_lugar` (`id_lugar`),
  ADD KEY `id_tareas_2` (`id_tareas`,`id_operativo`,`id_lugar`),
  ADD KEY `id_grupos_promotoras` (`id_grupos_promotoras`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
