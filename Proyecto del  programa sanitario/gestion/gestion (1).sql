-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2026 a las 10:47:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
  `id_operativo` int(11) NOT NULL,
  `id_lugar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_fechas`
--

CREATE TABLE `grupos_fechas` (
  `id_grupos_fechas` int(11) NOT NULL,
  `id_grupos` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_promotoras`
--

CREATE TABLE `grupos_promotoras` (
  `id_grupo_promotas` int(11) NOT NULL,
  `id_grupos` int(11) NOT NULL,
  `dni_promotoras` int(11) NOT NULL,
  `id_tareas` int(11) NOT NULL
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

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id_lugar`, `lugar`, `direccion`, `localidad`) VALUES
(1, 'Plaza san justo', 'Yporiton Yrigoyen 667', 'Gonzales catan'),
(7, 'PRUEBA', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaivos`
--

CREATE TABLE `operaivos` (
  `id_operativos` int(11) NOT NULL,
  `operativos` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operaivos`
--

INSERT INTO `operaivos` (`id_operativos`, `operativos`) VALUES
(1, 'vacunar'),
(5, 'PRUEBA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotoras`
--

CREATE TABLE `promotoras` (
  `dni_promotoras` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `domicilio` varchar(100) NOT NULL,
  `barrio` varchar(200) NOT NULL,
  `contraseña` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promotoras`
--

INSERT INTO `promotoras` (`dni_promotoras`, `nombre_completo`, `domicilio`, `barrio`, `contraseña`) VALUES
(3123, 'dawd', 'adwawd', 'dawaw', 'dawd'),
(12312, 'dawd', 'wda', 'dawdawd', 'waddw'),
(23123, 'dawd', 'dawd', 'dawdaw', '312312'),
(123123, 'dawdaw', 'wdawd', 'dwadawd', 'dawdaw'),
(37822910, 'Valentina Rocío Silva', 'San Martín 950, Mendoza', 'dawdawd', '$2b$10$qW1'),
(38192044, 'Micaela Elizabeth Castro', 'Av. Colón 3200, Mar del Plata', 'adwdawawd', '$2b$10$oP5'),
(38441092, 'Mariela Soledad Paz', 'Av. Rivadavia 4520, CABA', 'dawdawd', '$2b$10$eF/'),
(39102944, 'Sofía Antonella Gómez', 'Belgrano 1240, Córdoba', 'dawdawd', '$2b$10$kP1'),
(39844211, 'Julieta Micaela Romero', 'Alvear 890, Sdan Salvador de Jujuy', 'dawdawd', '$2b$10$rE2'),
(40291844, 'Camila Belén Rodríguez', 'Calle 14 nro 782, La Plata', 'dawdawd', '$2b$10$mN3'),
(40911203, 'Lucía Agustina Herrera', 'Av. Sarmiento 450, Resistencia', 'adawdawdw', '$2b$10$tY4'),
(41509332, 'Florencia Nair Díaz', 'Pellegrini 312, Rosario', 'adawdawd', '$2b$10$zX9'),
(42301988, 'Martina Victoria López', 'Urquiza 1845, Paraná', 'dwadawdaw', '$2b$10$vB8'),
(43102988, 'Ailén bautista Torres', 'España 120, Salta', 'dawdawdw', '$2b$10$uI8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tareas` int(11) NOT NULL,
  `tareas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tareas`, `tareas`) VALUES
(1, 'Realizar conteos de vacunados'),
(2, 'Realizar conteos de vacunados'),
(7, 'PRUEBA'),
(8, 'Orueva 2'),
(9, 'awdaw');

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
  ADD KEY `id_lugar` (`id_lugar`),
  ADD KEY `id_operativo_2` (`id_operativo`);

--
-- Indices de la tabla `grupos_fechas`
--
ALTER TABLE `grupos_fechas`
  ADD PRIMARY KEY (`id_grupos_fechas`),
  ADD KEY `id_grupos` (`id_grupos`);

--
-- Indices de la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  ADD PRIMARY KEY (`id_grupo_promotas`),
  ADD KEY `id_grupos` (`id_grupos`),
  ADD KEY `dni_promotoras` (`dni_promotoras`),
  ADD KEY `id_tareas` (`id_tareas`);

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
  MODIFY `id_grupos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `grupos_fechas`
--
ALTER TABLE `grupos_fechas`
  MODIFY `id_grupos_fechas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  MODIFY `id_grupo_promotas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `operaivos`
--
ALTER TABLE `operaivos`
  MODIFY `id_operativos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `promotoras`
--
ALTER TABLE `promotoras`
  MODIFY `dni_promotoras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43102989;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tareas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_lugar`) REFERENCES `lugar` (`id_lugar`),
  ADD CONSTRAINT `grupos_ibfk_3` FOREIGN KEY (`id_operativo`) REFERENCES `operaivos` (`id_operativos`);

--
-- Filtros para la tabla `grupos_fechas`
--
ALTER TABLE `grupos_fechas`
  ADD CONSTRAINT `grupos_fechas_ibfk_1` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`);

--
-- Filtros para la tabla `grupos_promotoras`
--
ALTER TABLE `grupos_promotoras`
  ADD CONSTRAINT `grupos_promotoras_ibfk_1` FOREIGN KEY (`dni_promotoras`) REFERENCES `promotoras` (`dni_promotoras`),
  ADD CONSTRAINT `grupos_promotoras_ibfk_2` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupos`),
  ADD CONSTRAINT `grupos_promotoras_ibfk_3` FOREIGN KEY (`id_tareas`) REFERENCES `tareas` (`id_tareas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
