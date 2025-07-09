-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 18:58:08
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
-- Base de datos: `saludhoy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `cedula`, `nombre`, `apellido`, `clave`) VALUES
(1, '1012345678', 'Juan', 'Pérez', 'claveSegura123'),
(2, '1098765432', 'María', 'Gómez', 'claveFuerte456'),
(3, '10533225', 'Robinson', 'Alza', '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_medica`
--

CREATE TABLE `cita_medica` (
  `codigo_cita` int(11) NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `id_consultorio` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_tipo_cita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita_medica`
--

INSERT INTO `cita_medica` (`codigo_cita`, `fecha_cita`, `id_consultorio`, `id_medico`, `id_paciente`, `id_tipo_cita`) VALUES
(1, '2025-06-20 08:00:00', 1, 1, 1, 1),
(2, '2025-06-27 08:00:00', 2, 2, 1, 2),
(3, '2025-06-20 09:00:00', 2, 3, 2, 3),
(4, '2025-06-27 09:00:00', 3, 4, 2, 1),
(5, '2025-06-21 08:00:00', 3, 5, 3, 2),
(6, '2025-06-28 08:00:00', 4, 6, 3, 3),
(7, '2025-06-21 09:00:00', 4, 7, 4, 1),
(8, '2025-06-28 09:00:00', 5, 8, 4, 2),
(9, '2025-06-22 08:00:00', 5, 9, 5, 3),
(10, '2025-06-29 08:00:00', 6, 10, 5, 1),
(11, '2025-06-22 09:00:00', 6, 1, 6, 2),
(12, '2025-06-29 09:00:00', 7, 2, 6, 3),
(13, '2025-06-23 08:00:00', 7, 3, 7, 1),
(14, '2025-06-30 08:00:00', 8, 4, 7, 2),
(15, '2025-06-23 09:00:00', 8, 5, 8, 3),
(16, '2025-06-30 09:00:00', 9, 6, 8, 1),
(17, '2025-06-24 08:00:00', 9, 7, 9, 2),
(18, '2025-06-30 10:00:00', 10, 8, 9, 3),
(19, '2025-06-24 09:00:00', 10, 9, 10, 1),
(20, '2025-07-01 08:00:00', 1, 10, 10, 2),
(21, '2025-07-05 08:00:00', 2, 1, 1, 3),
(22, '2025-07-12 08:30:00', 3, 2, 1, 1),
(23, '2025-07-06 09:00:00', 4, 3, 2, 2),
(24, '2025-07-13 10:00:00', 5, 4, 2, 3),
(25, '2025-07-07 08:00:00', 6, 5, 3, 1),
(26, '2025-07-14 09:30:00', 7, 6, 3, 2),
(27, '2025-07-08 10:00:00', 8, 7, 4, 3),
(28, '2025-07-15 08:00:00', 9, 8, 4, 1),
(29, '2025-07-09 08:30:00', 10, 9, 5, 2),
(30, '2025-07-16 09:00:00', 1, 10, 5, 3),
(31, '2025-07-10 08:00:00', 2, 1, 6, 1),
(32, '2025-07-17 10:00:00', 3, 2, 6, 2),
(33, '2025-07-11 09:30:00', 4, 3, 7, 3),
(34, '2025-07-18 08:00:00', 5, 4, 7, 1),
(35, '2025-07-12 08:00:00', 6, 5, 8, 2),
(36, '2025-07-19 10:30:00', 7, 6, 8, 3),
(37, '2025-07-13 09:00:00', 8, 7, 9, 1),
(38, '2025-07-20 08:00:00', 9, 8, 9, 2),
(39, '2025-07-14 08:00:00', 10, 9, 10, 3),
(40, '2025-07-09 11:48:00', 1, 10, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorio`
--

CREATE TABLE `consultorio` (
  `id_consultorio` int(11) NOT NULL,
  `lugar_cita` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultorio`
--

INSERT INTO `consultorio` (`id_consultorio`, `lugar_cita`) VALUES
(1, 'Consultorio 101 - Torre A'),
(2, 'Consultorio 102 - Torre A'),
(3, 'Consultorio 201 - Torre B'),
(4, 'Consultorio 202 - Torre B'),
(5, 'Consultorio 301 - Torre C'),
(6, 'Consultorio 302 - Torre C'),
(7, 'Consultorio 401 - Torre D'),
(8, 'Consultorio 402 - Torre D'),
(9, 'Consultorio Pediatría - Piso 2'),
(10, 'Consultorio Medicina General - Piso 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especializacion`
--

CREATE TABLE `especializacion` (
  `id_especializacion` int(11) NOT NULL,
  `especializacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especializacion`
--

INSERT INTO `especializacion` (`id_especializacion`, `especializacion`) VALUES
(1, 'Medicina General'),
(2, 'Pediatría'),
(3, 'Cardiología'),
(4, 'odontologia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cita`
--

CREATE TABLE `estado_cita` (
  `id_estado_cita` int(11) NOT NULL,
  `descripcion_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_cita`
--

INSERT INTO `estado_cita` (`id_estado_cita`, `descripcion_estado`) VALUES
(1, 'Programada'),
(2, 'Cancelada'),
(3, 'Finalizada'),
(4, 'Inasistencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cita`
--

CREATE TABLE `historial_cita` (
  `id_historial_cita` int(11) NOT NULL,
  `codigo_cita` int(11) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_terminacion` datetime DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `id_estado_cita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_cita`
--

INSERT INTO `historial_cita` (`id_historial_cita`, `codigo_cita`, `fecha_inicio`, `fecha_terminacion`, `motivo`, `id_estado_cita`) VALUES
(1, 1, '2025-06-20 08:00:00', '2025-06-20 08:30:00', 'Dolor de cabeza frecuente', 3),
(2, 2, '2025-06-27 08:00:00', '2025-06-27 08:30:00', 'Control general', 3),
(3, 3, '2025-06-20 09:00:00', '2025-06-20 09:45:00', 'Fiebre y malestar', 3),
(4, 4, '2025-06-27 09:00:00', '2025-06-27 09:45:00', 'Chequeo presión alta', 3),
(5, 5, '2025-06-21 08:00:00', NULL, 'Paciente canceló por viaje', 2),
(6, 6, '2025-06-28 08:00:00', '2025-06-28 08:30:00', 'Dolor abdominal', 3),
(7, 7, '2025-06-21 09:00:00', '2025-06-21 09:30:00', 'Evaluación post-operatoria', 3),
(8, 8, '2025-06-28 09:00:00', NULL, 'Cancelada por médico', 2),
(9, 9, '2025-06-22 08:00:00', '2025-06-22 08:40:00', 'Chequeo pediátrico', 3),
(10, 10, '2025-06-29 08:00:00', '2025-06-29 08:45:00', 'Control hipertensión', 3),
(11, 11, '2025-06-22 09:00:00', '2025-06-22 09:30:00', 'Chequeo general', 3),
(12, 12, '2025-06-29 09:00:00', '2025-06-29 09:30:00', 'Revisión de laboratorio', 3),
(13, 13, '2025-06-23 08:00:00', '2025-06-23 08:45:00', 'Dolor lumbar', 3),
(14, 14, '2025-06-30 08:00:00', '2025-06-30 08:30:00', 'Control por anemia', 3),
(15, 15, '2025-06-23 09:00:00', NULL, 'Paciente no asistió', 2),
(16, 16, '2025-06-30 09:00:00', '2025-06-30 09:30:00', 'Chequeo de rutina', 3),
(17, 17, '2025-06-24 08:00:00', '2025-06-24 08:30:00', 'Dolor articular', 3),
(18, 18, '2025-06-30 10:00:00', '2025-06-30 10:45:00', 'Revisión post-vacuna', 3),
(19, 19, '2025-06-24 09:00:00', NULL, 'Cancelada por reprogramación', 2),
(20, 20, '2025-07-01 08:00:00', '2025-07-01 08:30:00', 'Chequeo odontológico', 3),
(21, 21, '2025-07-05 08:00:00', '2025-07-05 08:30:00', 'Revisión posoperatoria', 3),
(22, 22, '2025-07-12 08:30:00', NULL, 'Pendiente de realizar', 1),
(23, 23, '2025-07-06 09:00:00', '2025-07-06 09:30:00', 'Revisión control', 3),
(24, 24, '2025-07-13 10:00:00', NULL, 'Programada', 1),
(25, 25, '2025-07-07 08:00:00', '2025-07-07 08:45:00', 'Chequeo mensual', 3),
(26, 26, '2025-07-14 09:30:00', NULL, 'Pendiente', 1),
(27, 27, '2025-07-08 10:00:00', '2025-07-08 10:30:00', 'Valoración psicológica', 3),
(28, 28, '2025-07-15 08:00:00', NULL, 'Reprogramada por agenda', 1),
(29, 29, '2025-07-09 08:30:00', '2025-07-09 09:00:00', 'Dolor cervical', 3),
(30, 30, '2025-07-16 09:00:00', NULL, 'Paciente aún no llega', 1),
(31, 31, '2025-07-10 08:00:00', '2025-07-10 08:30:00', 'Evaluación médica', 3),
(32, 32, '2025-07-17 10:00:00', NULL, 'Programada', 1),
(33, 33, '2025-07-11 09:30:00', '2025-07-11 10:00:00', 'Control rutina', 3),
(34, 34, '2025-07-18 08:00:00', NULL, 'A la espera del paciente', 1),
(35, 35, '2025-07-12 08:00:00', '2025-07-12 08:45:00', 'Consulta preoperatoria', 3),
(36, 36, '2025-07-19 10:30:00', NULL, 'Pendiente confirmación', 1),
(37, 37, '2025-07-13 09:00:00', '2025-07-13 09:30:00', 'Control de peso', 3),
(38, 38, '2025-07-20 08:00:00', NULL, 'Programada', 1),
(39, 39, '2025-07-14 08:00:00', '2025-07-14 08:30:00', 'Revisión respiratoria', 3),
(40, 40, '2025-07-21 09:00:00', NULL, 'Revisión general', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_disponible`
--

CREATE TABLE `horario_disponible` (
  `id_medico` int(11) NOT NULL,
  `fecha_horario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario_disponible`
--

INSERT INTO `horario_disponible` (`id_medico`, `fecha_horario`) VALUES
(1, '2025-06-20 08:00:00'),
(1, '2025-06-20 14:00:00'),
(1, '2025-06-21 08:00:00'),
(1, '2025-06-21 14:00:00'),
(2, '2025-06-20 09:00:00'),
(2, '2025-06-20 15:00:00'),
(2, '2025-06-21 09:00:00'),
(2, '2025-06-21 15:00:00'),
(3, '2025-06-22 08:00:00'),
(3, '2025-06-22 14:00:00'),
(3, '2025-06-23 08:00:00'),
(3, '2025-06-23 14:00:00'),
(4, '2025-06-22 09:00:00'),
(4, '2025-06-22 15:00:00'),
(4, '2025-06-23 09:00:00'),
(4, '2025-06-23 15:00:00'),
(5, '2025-06-20 10:00:00'),
(5, '2025-06-20 16:00:00'),
(5, '2025-06-21 10:00:00'),
(5, '2025-06-21 16:00:00'),
(6, '2025-06-22 10:00:00'),
(6, '2025-06-22 16:00:00'),
(6, '2025-06-23 10:00:00'),
(6, '2025-06-23 16:00:00'),
(7, '2025-06-20 08:00:00'),
(7, '2025-06-20 14:00:00'),
(7, '2025-06-24 08:00:00'),
(7, '2025-06-24 14:00:00'),
(8, '2025-06-21 09:00:00'),
(8, '2025-06-21 15:00:00'),
(8, '2025-06-24 09:00:00'),
(8, '2025-06-24 15:00:00'),
(9, '2025-06-22 10:00:00'),
(9, '2025-06-22 16:00:00'),
(9, '2025-06-24 10:00:00'),
(9, '2025-06-24 16:00:00'),
(10, '2025-06-23 08:00:00'),
(10, '2025-06-23 14:00:00'),
(10, '2025-06-24 08:00:00'),
(10, '2025-06-24 14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_hospital`
--

CREATE TABLE `ingreso_hospital` (
  `id_ingreso_hospital` int(11) NOT NULL,
  `id_consultorio` int(11) NOT NULL,
  `id_cita_medica` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingreso_hospital`
--

INSERT INTO `ingreso_hospital` (`id_ingreso_hospital`, `id_consultorio`, `id_cita_medica`, `fecha_ingreso`) VALUES
(1, 1, 1, '2025-06-20 07:50:00'),
(2, 2, 2, '2025-06-27 07:55:00'),
(3, 2, 3, '2025-06-20 08:50:00'),
(4, 3, 4, '2025-06-27 08:50:00'),
(5, 4, 6, '2025-06-28 07:50:00'),
(6, 4, 7, '2025-06-21 08:55:00'),
(7, 5, 9, '2025-06-22 07:55:00'),
(8, 6, 10, '2025-06-29 07:50:00'),
(9, 6, 11, '2025-06-22 08:55:00'),
(10, 7, 12, '2025-06-29 08:55:00'),
(11, 7, 13, '2025-06-23 07:55:00'),
(12, 8, 14, '2025-06-30 07:50:00'),
(13, 9, 16, '2025-06-30 08:55:00'),
(14, 9, 17, '2025-06-24 07:50:00'),
(15, 10, 18, '2025-06-30 09:50:00'),
(16, 10, 20, '2025-07-01 07:55:00'),
(17, 2, 21, '2025-07-05 07:55:00'),
(18, 4, 23, '2025-07-06 08:50:00'),
(19, 6, 25, '2025-07-07 07:55:00'),
(20, 8, 27, '2025-07-08 09:50:00'),
(21, 9, 29, '2025-07-09 08:15:00'),
(22, 2, 31, '2025-07-10 07:50:00'),
(23, 4, 33, '2025-07-11 09:15:00'),
(24, 6, 35, '2025-07-12 07:50:00'),
(25, 8, 37, '2025-07-13 08:45:00'),
(26, 10, 39, '2025-07-14 07:55:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `id_medico` int(11) NOT NULL,
  `id_numero_identificacion` int(11) NOT NULL,
  `id_especializacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`id_medico`, `id_numero_identificacion`, `id_especializacion`) VALUES
(1, 10000011, 1),
(2, 10000012, 2),
(3, 10000013, 3),
(4, 10000014, 1),
(5, 10000015, 2),
(6, 10000016, 3),
(7, 10000017, 1),
(8, 10000018, 2),
(9, 10000019, 3),
(10, 10000020, 1),
(26, 10101010, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio_residencia`
--

CREATE TABLE `municipio_residencia` (
  `id_municipio_residencia` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipio_residencia`
--

INSERT INTO `municipio_residencia` (`id_municipio_residencia`, `municipio`) VALUES
(1, 'Bogotá'),
(2, 'Medellín'),
(3, 'Cali');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `id_numero_identificacion` int(11) NOT NULL,
  `id_tipo_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `id_numero_identificacion`, `id_tipo_paciente`) VALUES
(1, 10000001, 1),
(2, 10000002, 2),
(3, 10000003, 3),
(4, 10000004, 1),
(5, 10000005, 2),
(6, 10000006, 3),
(7, 10000007, 1),
(8, 10000008, 2),
(9, 10000009, 3),
(10, 10000010, 1),
(15, 202020, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `numero_identificacion` int(11) NOT NULL,
  `id_tipo_identificacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `id_municipio_residencia` int(11) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`numero_identificacion`, `id_tipo_identificacion`, `nombre`, `apellido`, `direccion`, `id_municipio_residencia`, `fecha_nacimiento`, `clave`) VALUES
(202020, 1, 'Emmanuel', 'Vargas', 'Calle 104- 80 Sur', 1, '2005-06-15', '12345678'),
(10000001, 1, 'Ana', 'Ramírez', 'Cra 10 #12-34', 1, '1990-05-15', 'clave123'),
(10000002, 2, 'Carlos', 'González', 'Calle 45 #3-15', 2, '1988-09-22', 'clave456'),
(10000003, 3, 'Laura', 'Torres', 'Diag 7 #8-20', 3, '1995-02-10', 'clave789'),
(10000004, 1, 'Miguel', 'Rodríguez', 'Transv 12 #9-87', 2, '1982-12-01', 'clave321'),
(10000005, 2, 'Sofía', 'Martínez', 'Calle 23 #6-66', 1, '1993-07-30', 'clave654'),
(10000006, 3, 'David', 'Pérez', 'Av 1 #2-45', 3, '1985-03-18', 'clave987'),
(10000007, 1, 'Camila', 'García', 'Cra 15 #20-10', 1, '1999-11-25', 'clave147'),
(10000008, 2, 'Julián', 'Ruiz', 'Calle 50 #10-90', 2, '1975-08-09', 'clave258'),
(10000009, 3, 'Natalia', 'López', 'Diag 30 #5-25', 3, '1987-06-14', 'clave369'),
(10000010, 1, 'Andrés', 'Jiménez', 'Cra 7 #12-67', 2, '1992-04-04', 'clave741'),
(10000011, 2, 'Valentina', 'Moreno', 'Calle 8 #9-40', 3, '1998-01-19', 'clave852'),
(10000012, 3, 'Sebastián', 'Ramos', 'Cra 18 #6-19', 1, '1980-10-10', 'clave963'),
(10000013, 1, 'Paula', 'Vargas', 'Calle 60 #4-33', 2, '1994-03-21', 'clave159'),
(10000014, 2, 'Tomás', 'Castaño', 'Diag 5 #7-77', 3, '1986-05-08', 'clave753'),
(10000015, 3, 'Daniela', 'Mendoza', 'Transv 3 #5-65', 1, '1991-12-12', 'clave357'),
(10000016, 1, 'Felipe', 'Navarro', 'Calle 40 #11-22', 2, '1990-09-29', 'clave951'),
(10000017, 2, 'Lucía', 'Salazar', 'Cra 9 #14-05', 3, '1996-06-06', 'clave4567'),
(10000018, 3, 'Mateo', 'Guzmán', 'Av 6 #9-60', 1, '1983-07-15', 'clave1234'),
(10000019, 1, 'Isabella', 'Ortega', 'Calle 17 #3-88', 2, '1997-02-28', 'clave678'),
(10000020, 2, 'Santiago', 'Castro', 'Cra 20 #15-55', 3, '1984-11-11', 'clave000'),
(10101010, 1, 'Mateo', 'Cárdenas', 'Calle 104- 80 Sur', 1, '2005-07-07', '12345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono_persona`
--

CREATE TABLE `telefono_persona` (
  `id_persona` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefono_persona`
--

INSERT INTO `telefono_persona` (`id_persona`, `telefono`) VALUES
(10000001, '3101234567'),
(10000002, '3112345678'),
(10000003, '3123456789'),
(10000004, '3134567890'),
(10000005, '3145678901'),
(10000006, '3156789012'),
(10000007, '3167890123'),
(10000008, '3178901234'),
(10000009, '3189012345'),
(10000010, '3190123456'),
(10000011, '3201234567'),
(10000012, '3212345678'),
(10000013, '3223456789'),
(10000014, '3234567890'),
(10000015, '3245678901'),
(10000016, '3256789012'),
(10000017, '3267890123'),
(10000018, '3278901234'),
(10000019, '3289012345'),
(10000020, '3290123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_identificacion`
--

CREATE TABLE `tipo_identificacion` (
  `id_tipo_identificacion` int(11) NOT NULL,
  `tipo_identificacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_identificacion`
--

INSERT INTO `tipo_identificacion` (`id_tipo_identificacion`, `tipo_identificacion`) VALUES
(1, 'Cédula de ciudadanía'),
(2, 'Tarjeta de identidad'),
(3, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_paciente`
--

CREATE TABLE `tipo_paciente` (
  `id_tipo_paciente` int(11) NOT NULL,
  `nombre_tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_paciente`
--

INSERT INTO `tipo_paciente` (`id_tipo_paciente`, `nombre_tipo`) VALUES
(1, 'Regular'),
(2, 'Prioritario'),
(3, 'Emergencia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  ADD PRIMARY KEY (`codigo_cita`),
  ADD KEY `id_consultorio` (`id_consultorio`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `fk_tipo_cita` (`id_tipo_cita`);

--
-- Indices de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  ADD PRIMARY KEY (`id_consultorio`);

--
-- Indices de la tabla `especializacion`
--
ALTER TABLE `especializacion`
  ADD PRIMARY KEY (`id_especializacion`);

--
-- Indices de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  ADD PRIMARY KEY (`id_estado_cita`);

--
-- Indices de la tabla `historial_cita`
--
ALTER TABLE `historial_cita`
  ADD PRIMARY KEY (`id_historial_cita`),
  ADD UNIQUE KEY `codigo_cita` (`codigo_cita`),
  ADD KEY `fk_id_estado_cita` (`id_estado_cita`);

--
-- Indices de la tabla `horario_disponible`
--
ALTER TABLE `horario_disponible`
  ADD PRIMARY KEY (`id_medico`,`fecha_horario`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `ingreso_hospital`
--
ALTER TABLE `ingreso_hospital`
  ADD PRIMARY KEY (`id_ingreso_hospital`),
  ADD KEY `id_consultorio` (`id_consultorio`),
  ADD KEY `id_cita_medica` (`id_cita_medica`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id_medico`),
  ADD KEY `id_numero_identificacion` (`id_numero_identificacion`),
  ADD KEY `id_especializacion` (`id_especializacion`);

--
-- Indices de la tabla `municipio_residencia`
--
ALTER TABLE `municipio_residencia`
  ADD PRIMARY KEY (`id_municipio_residencia`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `id_numero_identificacion` (`id_numero_identificacion`),
  ADD KEY `id_tipo_paciente` (`id_tipo_paciente`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`numero_identificacion`),
  ADD KEY `id_tipo_identificacion` (`id_tipo_identificacion`),
  ADD KEY `id_municipio_residencia` (`id_municipio_residencia`);

--
-- Indices de la tabla `telefono_persona`
--
ALTER TABLE `telefono_persona`
  ADD PRIMARY KEY (`id_persona`,`telefono`);

--
-- Indices de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  ADD PRIMARY KEY (`id_tipo_identificacion`);

--
-- Indices de la tabla `tipo_paciente`
--
ALTER TABLE `tipo_paciente`
  ADD PRIMARY KEY (`id_tipo_paciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  MODIFY `codigo_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1046;

--
-- AUTO_INCREMENT de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  MODIFY `id_consultorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `especializacion`
--
ALTER TABLE `especializacion`
  MODIFY `id_especializacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  MODIFY `id_estado_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_cita`
--
ALTER TABLE `historial_cita`
  MODIFY `id_historial_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `ingreso_hospital`
--
ALTER TABLE `ingreso_hospital`
  MODIFY `id_ingreso_hospital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `municipio_residencia`
--
ALTER TABLE `municipio_residencia`
  MODIFY `id_municipio_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_identificacion`
--
ALTER TABLE `tipo_identificacion`
  MODIFY `id_tipo_identificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_paciente`
--
ALTER TABLE `tipo_paciente`
  MODIFY `id_tipo_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  ADD CONSTRAINT `cita_medica_ibfk_1` FOREIGN KEY (`id_consultorio`) REFERENCES `consultorio` (`id_consultorio`),
  ADD CONSTRAINT `cita_medica_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  ADD CONSTRAINT `cita_medica_ibfk_3` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `fk_tipo_cita` FOREIGN KEY (`id_tipo_cita`) REFERENCES `especializacion` (`id_especializacion`);

--
-- Filtros para la tabla `historial_cita`
--
ALTER TABLE `historial_cita`
  ADD CONSTRAINT `fk_id_estado_cita` FOREIGN KEY (`id_estado_cita`) REFERENCES `estado_cita` (`id_estado_cita`),
  ADD CONSTRAINT `historial_cita_ibfk_1` FOREIGN KEY (`codigo_cita`) REFERENCES `cita_medica` (`codigo_cita`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario_disponible`
--
ALTER TABLE `horario_disponible`
  ADD CONSTRAINT `horario_disponible_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`);

--
-- Filtros para la tabla `ingreso_hospital`
--
ALTER TABLE `ingreso_hospital`
  ADD CONSTRAINT `ingreso_hospital_ibfk_1` FOREIGN KEY (`id_consultorio`) REFERENCES `consultorio` (`id_consultorio`),
  ADD CONSTRAINT `ingreso_hospital_ibfk_2` FOREIGN KEY (`id_cita_medica`) REFERENCES `cita_medica` (`codigo_cita`);

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`id_numero_identificacion`) REFERENCES `persona` (`numero_identificacion`),
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`id_especializacion`) REFERENCES `especializacion` (`id_especializacion`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_numero_identificacion`) REFERENCES `persona` (`numero_identificacion`),
  ADD CONSTRAINT `paciente_ibfk_2` FOREIGN KEY (`id_tipo_paciente`) REFERENCES `tipo_paciente` (`id_tipo_paciente`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_tipo_identificacion`) REFERENCES `tipo_identificacion` (`id_tipo_identificacion`),
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`id_municipio_residencia`) REFERENCES `municipio_residencia` (`id_municipio_residencia`);

--
-- Filtros para la tabla `telefono_persona`
--
ALTER TABLE `telefono_persona`
  ADD CONSTRAINT `telefono_persona_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`numero_identificacion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
