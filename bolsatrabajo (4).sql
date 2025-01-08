-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2025 a las 23:57:27
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
-- Base de datos: `bolsatrabajo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_a` int(11) NOT NULL,
  `correo` varchar(55) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_a`, `correo`, `pass`) VALUES
(1, 'michel@gmail.com', '$2y$10$7P91Cv..MJn1.NzojrQo0eZI9inV2N0hWxuLCxivX0FUj8G.zp46S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_b` int(11) NOT NULL,
  `accion` varchar(55) NOT NULL,
  `descripcion` varchar(55) NOT NULL,
  `fecha_modificacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tabla_modificada` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buscadores`
--

CREATE TABLE `buscadores` (
  `id_buscador` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apaterno` varchar(45) NOT NULL,
  `amaterno` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `fn` date NOT NULL,
  `edad` int(11) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `foto_perfil` longblob NOT NULL,
  `foto_portada` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `buscadores`
--

INSERT INTO `buscadores` (`id_buscador`, `nombre`, `apaterno`, `amaterno`, `direccion`, `fn`, `edad`, `correo`, `telefono`, `pass`, `foto_perfil`, `foto_portada`) VALUES
(1, 'JESSICA MICHEL', 'ESCAMILLA', 'VELAZQUEZ', 'NIÑOS HEROES NORTE', '2001-08-30', 23, 'jessi@gmail.com', '7896541230', '$2y$10$7P91Cv..MJn1.NzojrQo0eZI9inV2N0hWxuLCxivX0FUj8G.zp46S', 0x75706c6f6164732f315f70657266696c5f706e676567672e706e67, 0x75706c6f6164732f315f706f72746164615f312e6a7067),
(2, 'MERARI', 'GONZALEZ', 'PAVON', 'PROGRESO', '2002-02-15', 22, 'sam@gmail.com', '1234567895', '$2y$10$pNwX97BVwHhKWFI15WZgdOQ7iYny0WAOlrsnY/.I8Zk7ml75zWaWK', 0x75706c6f6164732f325f70657266696c5f57494e5f32303234313030395f31375f31365f35305f50726f2e6a7067, 0x75706c6f6164732f325f706f72746164615f57494e5f32303232303632325f31345f31375f31385f50726f2e6a7067),
(3, 'Merari', 'gonzalez', 'pavon', 'progreso', '2002-02-15', 22, 'merari@gmail.com', '7293683094', '$2y$10$oSyIRhdyolclc1yM3Yd17.don8tiBZLqOfFOpUolKx8LsgKm2hVaa', 0x75706c6f6164732f335f70657266696c5f7573756172696f2e706e67, 0x75706c6f6164732f335f706f72746164615f312e6a7067);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cv`
--

CREATE TABLE `cv` (
  `id_cv` int(11) NOT NULL,
  `id_info` int(11) NOT NULL,
  `archivo_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cv`
--

INSERT INTO `cv` (`id_cv`, `id_info`, `archivo_pdf`) VALUES
(1, 2, '2.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_e` int(11) NOT NULL,
  `nombre_empresa` varchar(45) NOT NULL,
  `rfc_empresa` varchar(20) NOT NULL,
  `direccion_empresa` varchar(45) NOT NULL,
  `telefono_empresa` varchar(15) NOT NULL,
  `descripcion_empresa` varchar(255) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `nombre_reclutador` varchar(50) NOT NULL,
  `apaterno_reclutador` varchar(50) NOT NULL,
  `amaterno_reclutador` varchar(50) NOT NULL,
  `pass` longtext NOT NULL,
  `imagen` longblob NOT NULL,
  `foto_perfil` longblob NOT NULL,
  `foto_portada` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_e`, `nombre_empresa`, `rfc_empresa`, `direccion_empresa`, `telefono_empresa`, `descripcion_empresa`, `correo`, `nombre_reclutador`, `apaterno_reclutador`, `amaterno_reclutador`, `pass`, `imagen`, `foto_perfil`, `foto_portada`) VALUES
(1, 'trios y asociados SA DE CV', 'TRC789ASCE', 'NIÑOS HEROES 0,1', '7258888888888', 'Empresa con visión de crecimiento', 'triosascs@gmail.com', 'JESSICA', 'ESCAMILLA', 'VELAZQUEZ', '$2y$10$bvlMvH0Q1SONEPs5JXQOdumpXyku5osjazACue7pyK9Tq2fyOiOpS', 0x75706c6f6164732f5f70657266696c5f636f72726563746f2e706e67, '', 0x75706c6f6164732f5f706f72746164615f696d616765732e6a7067),
(2, 'TechNova Solutions', 'TNS100101T34', 'Edificio TechNova, Piso 4, Col. Innovación, C', '(55) 1234 5678', 'TechNova Solutions ofrece soluciones tecnológicas innovadoras para optimizar procesos empresariales. Nos especializamos en el desarrollo de software a medida, sistemas ERP y ciberseguridad, brindando herramientas que mejoran la productividad y eficiencia ', 'contacto@technovasolutions.com', 'Merari', 'Gonzalez', 'Pavon', '$2y$10$lRUPWtq7JvPhvoNpxXRH.eLlqhFDBozqtk.Amf5K0H2o.cw0QQY6m', 0x75706c6f6164732f5f70657266696c5f7465632e77656270, '', 0x75706c6f6164732f5f706f72746164615f7465632e77656270);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_postulacion`
--

CREATE TABLE `estatus_postulacion` (
  `id_estatus` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus_postulacion`
--

INSERT INTO `estatus_postulacion` (`id_estatus`, `descripcion`) VALUES
(1, 'Pendiente'),
(2, 'En revisión'),
(3, 'Preseleccionado'),
(4, 'En entrevista'),
(5, 'En espera'),
(6, 'Aceptado'),
(7, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experiencia_laboral`
--

CREATE TABLE `experiencia_laboral` (
  `id_ex` int(11) NOT NULL,
  `id_info` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `duracion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion_academica`
--

CREATE TABLE `formacion_academica` (
  `id` int(11) NOT NULL,
  `id_info` int(11) NOT NULL,
  `institucion` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `fecha_graduacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_personal`
--

CREATE TABLE `informacion_personal` (
  `id_info` int(11) NOT NULL,
  `id_buscador` int(11) NOT NULL,
  `cargo` varchar(55) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(55) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `sobremi` varchar(255) NOT NULL,
  `habilidades_b` varchar(255) NOT NULL,
  `imagen` longblob NOT NULL,
  `nomimagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informacion_personal`
--

INSERT INTO `informacion_personal` (`id_info`, `id_buscador`, `cargo`, `nombre`, `correo`, `telefono`, `sobremi`, `habilidades_b`, `imagen`, `nomimagen`) VALUES
(1, 1, 'desarrolladorA', 'JESSICA MICHEL escamilla velazquez', 'jessi@gmail.com', '7225371731', 'programadora de aplicaciones web ', 'manejo de php y html', '', 'Flat White.jpeg'),
(2, 1, 'desarrolladorA', 'JESSICA MICHEL escamilla velazquez', 'jessi@gmail.com', '7225371731', 'programadora de aplicaciones web ', 'manejo de php y html', '', 'espresso.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_buscador` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones_empresa`
--

CREATE TABLE `notificaciones_empresa` (
  `id_ne` int(11) NOT NULL,
  `id_buscador` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `leida` int(11) NOT NULL,
  `mensaje` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id_postulacion` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `id_buscador` int(11) NOT NULL,
  `cv` varchar(55) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  `fecha_postulacion` datetime NOT NULL,
  `id_estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id_postulacion`, `id_vacante`, `id_buscador`, `cv`, `estatus`, `fecha_postulacion`, `id_estatus`) VALUES
(1, 1, 1, '2.pdf', 'Pendiente', '2025-01-07 23:46:44', 1),
(2, 3, 1, '2.pdf', 'Pendiente', '2025-01-07 23:46:58', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `expiracion` datetime NOT NULL,
  `tipo_usuario` enum('buscador','empresa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacantes`
--

CREATE TABLE `vacantes` (
  `id_vacante` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `puesto` varchar(45) NOT NULL,
  `salario` double NOT NULL,
  `horario` text NOT NULL,
  `habilidades` varchar(255) NOT NULL,
  `prestaciones` text NOT NULL,
  `experiencia` text NOT NULL,
  `tiempo_experiencia` varchar(20) NOT NULL,
  `formacion` text NOT NULL,
  `idioma` varchar(20) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacantes`
--

INSERT INTO `vacantes` (`id_vacante`, `id_empresa`, `puesto`, `salario`, `horario`, `habilidades`, `prestaciones`, `experiencia`, `tiempo_experiencia`, `formacion`, `idioma`, `rol`) VALUES
(1, 1, 'supervisor', 30000, '5:00-1:00', 'saber sobre vetas', 'de ley', 'en ventas', '2 años', 'maestria en administracion', 'español e ingles', 'ingeniero'),
(3, 1, 'Desarrollador web', 18000, 'Lunes a viernes de 9:00 AM a 6:00 PM', 'HTML, CSS, JavaScript, PHP, MySQL', 'Seguro médico, bono anual, vacaciones pagadas', 'Mínimo 2 años trabaj', ' 2 años', ' Licenciatura en Ciencias de la Computación o', 'B2', ' Desarrollador Front-End');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_a`);

--
-- Indices de la tabla `buscadores`
--
ALTER TABLE `buscadores`
  ADD PRIMARY KEY (`id_buscador`);

--
-- Indices de la tabla `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id_cv`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_e`);

--
-- Indices de la tabla `estatus_postulacion`
--
ALTER TABLE `estatus_postulacion`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
  ADD PRIMARY KEY (`id_ex`),
  ADD KEY `id_info` (`id_info`);

--
-- Indices de la tabla `formacion_academica`
--
ALTER TABLE `formacion_academica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_info` (`id_info`);

--
-- Indices de la tabla `informacion_personal`
--
ALTER TABLE `informacion_personal`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `id_buscador` (`id_buscador`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_buscador` (`id_buscador`),
  ADD KEY `id_vacante` (`id_vacante`);

--
-- Indices de la tabla `notificaciones_empresa`
--
ALTER TABLE `notificaciones_empresa`
  ADD PRIMARY KEY (`id_ne`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id_postulacion`),
  ADD UNIQUE KEY `id_vacante_2` (`id_vacante`,`id_buscador`),
  ADD KEY `id_buscador` (`id_buscador`),
  ADD KEY `id_estatus` (`id_estatus`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD PRIMARY KEY (`id_vacante`),
  ADD KEY `fk_id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `buscadores`
--
ALTER TABLE `buscadores`
  MODIFY `id_buscador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cv`
--
ALTER TABLE `cv`
  MODIFY `id_cv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_e` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estatus_postulacion`
--
ALTER TABLE `estatus_postulacion`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
  MODIFY `id_ex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formacion_academica`
--
ALTER TABLE `formacion_academica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informacion_personal`
--
ALTER TABLE `informacion_personal`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones_empresa`
--
ALTER TABLE `notificaciones_empresa`
  MODIFY `id_ne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id_postulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  MODIFY `id_vacante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `informacion_personal`
--
ALTER TABLE `informacion_personal`
  ADD CONSTRAINT `informacion_personal_ibfk_1` FOREIGN KEY (`id_buscador`) REFERENCES `buscadores` (`id_buscador`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_buscador`) REFERENCES `buscadores` (`id_buscador`);

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `postulaciones_ibfk_1` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`),
  ADD CONSTRAINT `postulaciones_ibfk_2` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_postulacion` (`id_estatus`);

--
-- Filtros para la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD CONSTRAINT `fk_id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_e`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
