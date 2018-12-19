-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2018 a las 14:43:03
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practicaphp`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `logs` (IN `nombre` VARCHAR(50), IN `rol` VARCHAR(50), IN `accion` VARCHAR(50))  NO SQL
BEGIN
INSERT INTO `log`(`nombre`, `fecha`, `rol`, `accion`) VALUES (nombre, SYSDATE(),rol,accion);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `idAsignaturas` int(11) NOT NULL,
  `Cursos_idCursos` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bach`
--

CREATE TABLE `bach` (
  `idBACH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cf`
--

CREATE TABLE `cf` (
  `idCF` int(11) NOT NULL,
  `FP_idFP` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idCursos` int(11) NOT NULL,
  `BACH_idBACH` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eso`
--

CREATE TABLE `eso` (
  `idESO` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eso_has_solicitud`
--

CREATE TABLE `eso_has_solicitud` (
  `ESO_idESO` int(11) NOT NULL,
  `solicitud_id_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fp`
--

CREATE TABLE `fp` (
  `idFP` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fp_has_solicitud`
--

CREATE TABLE `fp_has_solicitud` (
  `FP_idFP` int(11) NOT NULL,
  `solicitud_id_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `rol` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `accion` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`nombre`, `fecha`, `rol`, `accion`) VALUES
('juanma', '2018-12-19 03:58:34', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 04:00:15', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 04:01:10', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 04:02:05', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 13:04:19', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 13:13:04', 'administrador', 'inicio sesion'),
('juanma', '2018-12-19 13:54:22', 'administrador', 'inicio sesion'),
('Natalia', '2018-12-19 14:20:47', 'administrador', 'inicio sesion'),
('Nat', '2018-12-19 14:21:00', 'administrador', 'inicio sesion'),
('Nat', '2018-12-19 14:21:05', 'administrador', 'inicio sesion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idModulo` int(11) NOT NULL,
  `CF_idCF` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `id_ensenianza` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_has_bach`
--

CREATE TABLE `solicitud_has_bach` (
  `solicitud_id_solicitud` int(11) NOT NULL,
  `BACH_idBACH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `NIF` varchar(9) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `apellido1` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `apellido2` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `imagen` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nickname` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `rol` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefonomov` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `telefonofijo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `departamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `paginaweb` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccionblog` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `twitter` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `activo` tinyint(4) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Asignaturas` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `NIF`, `nombre`, `apellido1`, `apellido2`, `imagen`, `nickname`, `password`, `rol`, `telefonomov`, `telefonofijo`, `email`, `departamento`, `paginaweb`, `direccionblog`, `twitter`, `activo`, `Fecha`, `Asignaturas`) VALUES
(1, '49117809K', 'juanma', 'silva', 'cerrejón', NULL, 'juanma', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador', '610569348', NULL, NULL, 'Informática', NULL, NULL, NULL, 1, '2018-12-19 00:00:00', NULL),
(2, '49117809C', 'Natalia', 'Romero', NULL, NULL, 'Nat', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Profesor', '671258501', NULL, NULL, 'Administracion', NULL, NULL, NULL, 1, '2018-12-19 00:00:00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`idAsignaturas`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_Asignaturas_Cursos2_idx` (`Cursos_idCursos`);

--
-- Indices de la tabla `bach`
--
ALTER TABLE `bach`
  ADD PRIMARY KEY (`idBACH`);

--
-- Indices de la tabla `cf`
--
ALTER TABLE `cf`
  ADD PRIMARY KEY (`idCF`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_CF_FP1_idx` (`FP_idFP`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCursos`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_Cursos_BACH1_idx` (`BACH_idBACH`);

--
-- Indices de la tabla `eso`
--
ALTER TABLE `eso`
  ADD PRIMARY KEY (`idESO`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `eso_has_solicitud`
--
ALTER TABLE `eso_has_solicitud`
  ADD PRIMARY KEY (`ESO_idESO`,`solicitud_id_solicitud`),
  ADD KEY `fk_ESO_has_solicitud_solicitud1_idx` (`solicitud_id_solicitud`),
  ADD KEY `fk_ESO_has_solicitud_ESO1_idx` (`ESO_idESO`);

--
-- Indices de la tabla `fp`
--
ALTER TABLE `fp`
  ADD PRIMARY KEY (`idFP`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `fp_has_solicitud`
--
ALTER TABLE `fp_has_solicitud`
  ADD PRIMARY KEY (`FP_idFP`,`solicitud_id_solicitud`),
  ADD KEY `fk_FP_has_solicitud_solicitud1_idx` (`solicitud_id_solicitud`),
  ADD KEY `fk_FP_has_solicitud_FP1_idx` (`FP_idFP`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idModulo`),
  ADD UNIQUE KEY `Modulocol_UNIQUE` (`nombre`),
  ADD KEY `fk_Modulo_CF1_idx` (`CF_idCF`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fk_solicitud_Usuarios_idx` (`Usuarios_idUsuarios`);

--
-- Indices de la tabla `solicitud_has_bach`
--
ALTER TABLE `solicitud_has_bach`
  ADD PRIMARY KEY (`solicitud_id_solicitud`,`BACH_idBACH`),
  ADD KEY `fk_solicitud_has_BACH_BACH1_idx` (`BACH_idBACH`),
  ADD KEY `fk_solicitud_has_BACH_solicitud1_idx` (`solicitud_id_solicitud`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD UNIQUE KEY `nickname_UNIQUE` (`nickname`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `fk_Asignaturas_Cursos2` FOREIGN KEY (`Cursos_idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cf`
--
ALTER TABLE `cf`
  ADD CONSTRAINT `fk_CF_FP1` FOREIGN KEY (`FP_idFP`) REFERENCES `fp` (`idFP`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `fk_Cursos_BACH1` FOREIGN KEY (`BACH_idBACH`) REFERENCES `bach` (`idBACH`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `eso_has_solicitud`
--
ALTER TABLE `eso_has_solicitud`
  ADD CONSTRAINT `fk_ESO_has_solicitud_ESO1` FOREIGN KEY (`ESO_idESO`) REFERENCES `eso` (`idESO`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ESO_has_solicitud_solicitud1` FOREIGN KEY (`solicitud_id_solicitud`) REFERENCES `solicitud` (`id_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fp_has_solicitud`
--
ALTER TABLE `fp_has_solicitud`
  ADD CONSTRAINT `fk_FP_has_solicitud_FP1` FOREIGN KEY (`FP_idFP`) REFERENCES `fp` (`idFP`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_FP_has_solicitud_solicitud1` FOREIGN KEY (`solicitud_id_solicitud`) REFERENCES `solicitud` (`id_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_Modulo_CF1` FOREIGN KEY (`CF_idCF`) REFERENCES `cf` (`idCF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_has_bach`
--
ALTER TABLE `solicitud_has_bach`
  ADD CONSTRAINT `fk_solicitud_has_BACH_BACH1` FOREIGN KEY (`BACH_idBACH`) REFERENCES `bach` (`idBACH`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitud_has_BACH_solicitud1` FOREIGN KEY (`solicitud_id_solicitud`) REFERENCES `solicitud` (`id_solicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
