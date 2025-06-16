-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2025 a las 03:24:34
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
-- Estructura de tabla para la tabla `cita_medica`
--

CREATE TABLE `cita_medica` (
  `codigo_cita` int(11) NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `id_consultorio` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_estado_cita` int(11) NOT NULL,
  `id_tipo_cita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita_medica`
--

INSERT INTO `cita_medica` (`codigo_cita`, `fecha_cita`, `id_consultorio`, `id_medico`, `id_paciente`, `id_estado_cita`, `id_tipo_cita`) VALUES
(7, '2025-06-01 08:00:00', 1, 6, 1, 1, 1),
(8, '2025-06-02 09:00:00', 2, 7, 2, 2, 2),
(1010, '2025-06-11 00:13:09', 2, 19, 2, 1, 3);

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
(1, 'Consultorio 101'),
(2, 'Consultorio 102');

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
(3, 'Cardiología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cita`
--

CREATE TABLE `estado_cita` (
  `id_estado_cita` int(11) NOT NULL,
  `estado_cita` varchar(50) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_terminacion` datetime DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_cita`
--

INSERT INTO `estado_cita` (`id_estado_cita`, `estado_cita`, `fecha_inicio`, `fecha_terminacion`, `motivo`) VALUES
(1, 'Programada', '2025-05-29 10:00:00', '2025-06-10 08:41:03', 'inasistencia'),
(2, 'Cancelada', '2025-05-28 08:00:00', '2025-05-28 09:00:00', 'Paciente no asistió');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_disponible`
--

CREATE TABLE `horario_disponible` (
  `id_horario_disponible` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha_horario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario_disponible`
--

INSERT INTO `horario_disponible` (`id_horario_disponible`, `id_medico`, `fecha_horario`) VALUES
(5, 6, '2025-06-01 08:00:00'),
(6, 7, '2025-06-01 09:00:00');

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
(6, 10101010, 1),
(7, 20202020, 2),
(8, 40404040, 2),
(19, 12345678, 1),
(20, 1234, 1),
(21, 1234456, 3),
(22, 54321, 2),
(23, 12345543, 2),
(24, 12345223, 2);

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
(1, 10101010, 1),
(2, 20202020, 2),
(3, 30303030, 2),
(8, 1234, 1),
(13, 23546534, 2),
(14, 1053322859, 1);

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
(1234, 1, 'karen', 'alza', 'calle 19 #21 -24', 2, '2025-06-06', '12345678'),
(6543, 3, 'rovinson', 'alza', 'calle 19 #21 -24', 2, '2025-06-25', '0'),
(54321, 2, 'yerson', 'lara', 'calle 19 #21 -24', 2, '2025-07-04', 'clave789'),
(54325, 2, 'aSAds', 'alzalas', 'calle 19 #21 -24', 2, '2025-06-26', 'clave789'),
(123321, 1, 'dsfsfdssdfdsfsf', 'lara', 'calle 19 #21 -24', 3, '2025-12-31', '12345678'),
(123678, 2, 'dsfsfdssdfdsfsf', 'alzalas', 'calle 19 #21 -24', 2, '2025-12-30', '12345678'),
(433444, 2, 'robinsonalza', 'lara', 'calle 19 #21 -24', 1, '2024-12-31', 'clave789'),
(1234456, 3, 'sadsadfdsdff', 'lara', 'calle 19 #21 -24', 2, '2025-06-18', '123456'),
(10101010, 1, 'pedro', 'Pérez', 'Calle 123 # 80 -06', 1, '1980-05-09', 'clave123'),
(12345223, 2, 'Juan', 'Pérez', 'Calle 123', 3, '2025-06-20', '1234567'),
(12345543, 2, 'dsfsfdssdfdsfsf', 'alza', 'calle 19 #21 -24', 2, '2025-12-31', '12345678'),
(12345678, 2, 'robin', 'lara', 'calle 19 #21 -24', 2, '2025-06-06', '12345678'),
(20202020, 1, 'Ana', 'García', 'Carrera 45', 2, '1990-03-20', '123456'),
(23546534, 2, 'johan', 'alza', 'calle 19 #21 -24', 2, '2025-06-16', '12345'),
(30303030, 2, 'Carlos', 'López', 'Av. 30', 3, '1975-08-10', 'clave789'),
(40404040, 1, 'jeiller', 'lara', 'calle 104 #14 -80', 1, '2005-05-31', '12345678'),
(123457805, 2, 'robin', 'lara', 'calle 19 #21 -24', 2, '2025-07-03', '123456'),
(1053322859, 1, 'Robinsito', 'alza', 'calle 19 #21 -24', 2, '2004-03-31', '12345678'),
(2147483647, 1, 'robin', 'wqertgfvd', 'calle 19 #21 -24', 1, '2025-06-18', '12345');

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
(1234, '0987654321'),
(1234, '1234567890'),
(54321, '123'),
(1234456, '0987654321'),
(1234456, '1234567890'),
(10101010, '3001112212'),
(12345223, '1234567890'),
(12345543, '1234561234'),
(12345543, '1234567899'),
(20202020, '3102223344'),
(23546534, '0987654311'),
(23546534, '1234567890'),
(30303030, '3203334455'),
(1053322859, '0987654321'),
(1053322859, '1234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cita`
--

CREATE TABLE `tipo_cita` (
  `id_tipo_cita` int(11) NOT NULL,
  `especialidad` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_cita`
--

INSERT INTO `tipo_cita` (`id_tipo_cita`, `especialidad`) VALUES
(1, 'Medicina General'),
(2, 'Pediatría'),
(3, 'Ginecología'),
(4, 'Odontología'),
(5, 'Dermatología');

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
-- Indices de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  ADD PRIMARY KEY (`codigo_cita`),
  ADD KEY `id_consultorio` (`id_consultorio`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_estado_cita` (`id_estado_cita`),
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
-- Indices de la tabla `horario_disponible`
--
ALTER TABLE `horario_disponible`
  ADD PRIMARY KEY (`id_horario_disponible`),
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
-- Indices de la tabla `tipo_cita`
--
ALTER TABLE `tipo_cita`
  ADD PRIMARY KEY (`id_tipo_cita`);

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
-- AUTO_INCREMENT de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  MODIFY `codigo_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  MODIFY `id_consultorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `especializacion`
--
ALTER TABLE `especializacion`
  MODIFY `id_especializacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_cita`
--
ALTER TABLE `estado_cita`
  MODIFY `id_estado_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horario_disponible`
--
ALTER TABLE `horario_disponible`
  MODIFY `id_horario_disponible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ingreso_hospital`
--
ALTER TABLE `ingreso_hospital`
  MODIFY `id_ingreso_hospital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `municipio_residencia`
--
ALTER TABLE `municipio_residencia`
  MODIFY `id_municipio_residencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_cita`
--
ALTER TABLE `tipo_cita`
  MODIFY `id_tipo_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `cita_medica_ibfk_4` FOREIGN KEY (`id_estado_cita`) REFERENCES `estado_cita` (`id_estado_cita`),
  ADD CONSTRAINT `fk_tipo_cita` FOREIGN KEY (`id_tipo_cita`) REFERENCES `tipo_cita` (`id_tipo_cita`);

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
