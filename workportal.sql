-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2024 a las 03:57:52
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
-- Base de datos: `workportal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `educacion`
--

CREATE TABLE `educacion` (
  `id_educacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `institucion` varchar(255) NOT NULL,
  `titulo_carrera` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `actualidad` tinyint(1) DEFAULT 0,
  `nivel_estudio` enum('primaria completa','primaria incompleta','secundario completo','secundario incompleto','terciario completo','terciario incompleto','universitario completo','universitario incompleto') NOT NULL,
  `id_cv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `educacion`
--

INSERT INTO `educacion` (`id_educacion`, `id_usuario`, `institucion`, `titulo_carrera`, `fecha_inicio`, `fecha_fin`, `actualidad`, `nivel_estudio`, `id_cv`) VALUES
(36, 1, 'IFTS 12', 'Analisis de sistemas', '2024-09-03', '2024-09-18', 0, 'terciario incompleto', NULL),
(38, 6, 'UTN', 'Ingenieria en SIstemas', '2010-09-03', '2024-05-05', 0, 'universitario completo', NULL),
(39, 1, 'Colegio Migue Otero Silva', 'Bachiller', '2010-09-01', '2016-09-01', 0, 'secundario completo', NULL),
(40, 7, 'IFTS 12', 'Analisis de sistemas', '2022-02-01', '2024-12-12', 0, 'terciario completo', NULL),
(41, 8, 'IFTS 12', 'Analisis de sistemas', '2022-03-01', '0000-00-00', 0, 'primaria completa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `cuit` varchar(20) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `domicilio` varchar(255) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `nombre_empresa`, `cuit`, `contrasena`, `correo_electronico`, `domicilio`, `pais`, `telefono`, `token`, `descripcion`, `foto_perfil`) VALUES
(1, 'Coca Cola Ar Reclutamiento.', '3094334533', '1234', 'cocacola@gmail.com', 'av cordoba 560', 'Argentina', '', NULL, 'The Coca-Cola Company: Fundada en 1886, The Coca-Cola Company es la compañía de bebidas más grande del mundo, refrescando a sus consumidores con más de 500 marcas de refrescos\r\n', 'uploads/images.JPG'),
(3, 'Grupo Gestion', '30126883383', '1234', 'busquedasgrupogestion@gmail.com', 'Av corrientes 1222, CABA', 'Argentina', '43138008', NULL, '', NULL),
(4, 'PCMALL', '12334432222', '1234', 'PCMALL@HOTMAIL.COM', 'Av Belgrano 1233, CABA', 'Argentina', '43138045', NULL, NULL, NULL),
(6, 'ANDREANI Capital Federal', '12543333444', '1234', 'andreanicaba@gmail.com', 'Av cordoba 5444', 'Argentina', '43138555', NULL, NULL, NULL),
(7, 'Correo Argentino', '3455556665', '1234', 'correoargentin0busquesdas@gmail.com', 'Av Leandro Alem, 345, CABA', 'Argentina', '3456543333', NULL, NULL, NULL),
(8, 'Librerias LIBRO', '30345543333', '1234', 'Librerialibrob@gmail.com', 'av. rivadavia 2333', 'Argentina', '43138099', NULL, NULL, NULL),
(10, 'Acudir emergencias', '200004477', '1234', 'acudiremergencias@gmail.com', 'Av Leandro Alem, 400, Ciudad autonoma de Buenos Aires', 'Argentina', '43137008', NULL, NULL, NULL),
(12, 'Forum RRHH', '335585877', '1234', 'ForumRRHH@gmail.com', 'Sarmiento 566 Caba', 'Argentina', '644447456', NULL, NULL, NULL),
(14, 'Pullmen central', '122333223', '1234', 'busquedaspm@gmail.com', 'av cordoba 5600, CABA', 'Argentina', '1122535181', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `experiencia_laboral`
--

CREATE TABLE `experiencia_laboral` (
  `id_experiencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `actualidad` tinyint(1) DEFAULT 0,
  `tareas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `experiencia_laboral`
--

INSERT INTO `experiencia_laboral` (`id_experiencia`, `id_usuario`, `puesto`, `empresa`, `fecha_inicio`, `fecha_fin`, `actualidad`, `tareas`) VALUES
(18, 6, 'Gerente IT', 'Globant', '2010-09-03', '2024-05-05', 0, 'Gerente'),
(19, 1, 'Vendedor', 'Zapateria', '2024-09-03', '2024-09-18', 0, 'Vender'),
(20, 7, 'ddddddd', 'dd', '2022-02-01', '2024-12-12', 0, 'ssssxs'),
(21, 7, 'sss', 'sss', '2024-09-03', '2024-10-10', 0, 'jhhh'),
(22, 8, 'Analista', 'Globant', '2022-03-01', '0000-00-00', 0, 'Analisis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE `idiomas` (
  `id_idioma` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `idioma` varchar(100) DEFAULT NULL,
  `nivel_competencia` enum('oral','escrito','nativo') DEFAULT NULL,
  `nivel_habilidad` enum('básico','intermedio','experto') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id_idioma`, `id_usuario`, `idioma`, `nivel_competencia`, `nivel_habilidad`) VALUES
(5, 6, 'Ingles', 'oral', 'intermedio'),
(6, 1, 'Español', 'oral', 'experto'),
(7, 7, 'INGLES', 'escrito', 'experto'),
(8, 8, 'ingles', 'oral', 'intermedio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `leida` tinyint(1) DEFAULT 0,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `id_usuario`, `mensaje`, `fecha`, `leida`, `estado`) VALUES
(5, 1, 'Tu CV para Contador Publico fue visto.', '2024-10-13 19:21:33', 1, 'visto'),
(6, 1, 'Tu CV para Contador Publico ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.', '2024-10-13 19:23:34', 1, 'seleccionado'),
(7, 7, 'Lo sentimos, tu CV para la búsqueda Desarrollador Web Frontend ha sido rechazado.', '2024-10-13 19:25:25', 1, 'rechazado'),
(8, 7, 'Tu CV para Contador Publico fue visto.', '2024-10-13 19:32:10', 1, 'visto'),
(9, 7, 'Tu CV para Contador Publico fue visto.', '2024-10-13 19:38:14', 1, 'visto'),
(10, 7, 'Tu CV para Contador Publico ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.', '2024-10-13 19:38:34', 1, 'seleccionado'),
(11, 2, 'Tu CV para Desarrollador Web Frontend fue visto.', '2024-10-13 19:39:54', 1, 'visto'),
(12, 2, 'Tu CV para Desarrollador Web Frontend fue visto.', '2024-10-13 19:40:08', 1, 'visto'),
(13, 2, 'Tu CV para Desarrollador Web Frontend ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.', '2024-10-13 19:51:09', 1, 'seleccionado'),
(14, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 19:57:53', 1, 'visto'),
(15, 2, 'Tu CV para Contador Publico ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.', '2024-10-13 19:58:31', 1, 'seleccionado'),
(16, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 20:01:35', 1, 'visto'),
(17, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 20:04:44', 1, 'visto'),
(18, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 20:06:25', 1, 'visto'),
(19, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 21:37:04', 1, 'visto'),
(20, 2, 'Tu CV para Contador Publico ha sido seleccionado. Pronto la empresa se comunicará con vos para una entrevista.', '2024-10-13 21:53:50', 1, 'seleccionado'),
(21, 2, 'Lo sentimos, tu CV para la búsqueda Contador Publico ha sido rechazado.', '2024-10-13 21:58:27', 1, 'rechazado'),
(22, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 22:01:24', 1, 'visto'),
(23, 2, 'Tu CV para Contador Publico fue visto.', '2024-10-13 22:06:25', 1, 'visto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id_postulacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vacante` int(11) NOT NULL,
  `tipo_cv` enum('pdf','manual') NOT NULL,
  `fecha_postulacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('enviado','visto','seleccionado','rechazado') DEFAULT 'enviado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id_postulacion`, `id_usuario`, `id_vacante`, `tipo_cv`, `fecha_postulacion`, `estado`) VALUES
(1, 1, 3, 'pdf', '2024-09-18 23:49:40', 'seleccionado'),
(2, 1, 5, 'pdf', '2024-09-19 00:03:28', 'rechazado'),
(3, 2, 3, 'manual', '2024-09-19 00:21:46', 'visto'),
(4, 7, 3, 'pdf', '2024-09-19 16:42:53', 'rechazado'),
(5, 7, 5, 'pdf', '2024-09-19 16:46:54', 'rechazado'),
(6, 3, 3, 'pdf', '2024-09-19 16:48:32', 'visto'),
(7, 5, 3, 'pdf', '2024-09-19 21:46:19', 'seleccionado'),
(8, 8, 3, 'pdf', '2024-09-19 22:37:26', 'rechazado'),
(9, 8, 5, 'pdf', '2024-09-19 22:38:24', 'enviado'),
(10, 1, 6, 'manual', '2024-09-26 03:25:46', 'seleccionado'),
(11, 7, 6, 'manual', '2024-10-13 22:31:50', 'seleccionado'),
(12, 2, 5, 'pdf', '2024-10-13 22:39:39', 'seleccionado'),
(15, 2, 6, 'pdf', '2024-10-14 00:58:05', 'visto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT 'img/sinfoto.png',
  `sobre_mi` text DEFAULT NULL,
  `cv_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo_electronico`, `contrasena`, `apellido`, `dni`, `localidad`, `provincia`, `pais`, `telefono`, `token`, `foto_perfil`, `sobre_mi`, `cv_pdf`) VALUES
(1, 'maria', 'adrianamorenocard@gmail.com', '12345', 'Moreno', '96027940', 'Almagro', 'CABA', 'Argentina', '1123956105', NULL, 'uploads/3.jpg', 'estudianteeee hols', 'uploads/CV MACARENA MORRONE pdf.pdf'),
(2, 'Maria fernanda', 'gomezmaria@gmail.com', '1234', 'Gomez', '234477877', 'balvanera', 'CAPITAL FEDERAL', 'Argentina', '112323655', NULL, 'uploads/farmacia imagen.jpg', 'fffff', NULL),
(3, 'Oriana', 'hermosoor@gmail.com', '1234', 'Hermoso', '25447777', 'CABA', 'CAPITAL FEDERAL', 'Argentina', '112355585', NULL, 'uploads/images.jfif', NULL, NULL),
(5, 'Ivan', 'martinivanquiroga@gmail.com', '1234', 'Quiroga', '123444444', 'Almagro', 'CABA', 'Argentina', '1123956108', NULL, 'img/sinfoto.png', 'hola', NULL),
(6, 'Oriana', 'busquedaspm@gmail.com', '1234', 'Mariño', '35647444', 'CABA', 'CAPITAL FEDERAL', 'Argentina', '43138005', NULL, 'uploads/descarga.jpeg', 'Capacidad de trabajo en equipo', 'uploads/CV - Adriana moreno.pdf'),
(7, 'Maria', 'mariajimenez@gmail.com', '1234', 'Moreno', '98888888', 'Almagro', 'CABA', 'Argentina', '1123956105', NULL, 'uploads/descarga.jpeg', 'aaaaaa', 'uploads/CV MACARENA MORRONE pdf.pdf'),
(8, 'Laura', 'lauram@gmail.com', '1234', 'Martinez', '12333444', 'Almagro', 'CABA', 'Argentina', '112395614', NULL, 'uploads/descarga.jpeg', 'Estudiante, analista', 'uploads/CV - Moreno Adriana..pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacantes`
--

CREATE TABLE `vacantes` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `modalidad` varchar(50) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `localidad` varchar(50) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `nivel_laboral` varchar(50) DEFAULT NULL,
  `carga_horaria` varchar(50) DEFAULT NULL,
  `estado` enum('activa','finalizada') DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacantes`
--

INSERT INTO `vacantes` (`id`, `id_empresa`, `titulo`, `descripcion`, `salario`, `fecha_publicacion`, `modalidad`, `area`, `provincia`, `localidad`, `pais`, `nivel_laboral`, `carga_horaria`, `estado`) VALUES
(3, 1, 'Desarrollador Web Frontend 1', 'Estamos buscando un desarrollador web frontend altamente motivado para unirse a nuestro equipo. El candidato ideal tendrá experiencia en HTML, CSS y JavaScript, así como habilidades de diseño y atención al detalle. Se espera que colabore estrechamente con nuestro equipo de desarrollo para crear experiencias de usuario excepcionales en nuestros sitios web y aplicaciones web.', 2500000.00, '2024-05-31 19:34:55', 'Remoto', 'Administración y Finanzas', 'CAPITAL FEDERAL', 'CABA', 'Argentina', 'Senior', 'Full-time', 'activa'),
(5, 1, 'Desarrollador Web Frontend', 'Estamos buscando un desarrollador web frontend altamente motivado para unirse a nuestro equipo. El candidato ideal tendrá experiencia en HTML, CSS y JavaScript, así como habilidades de diseño y atención al detalle. Se espera que colabore estrechamente con nuestro equipo de desarrollo para crear experiencias de usuario excepcionales en nuestros sitios web y aplicaciones web.', 1500000.00, '2024-06-13 20:37:59', 'Remoto', 'Administración y Finanzas', 'CAPITAL FEDERAL', 'CABA', 'Argentina', 'Junior', 'Part-time', 'activa'),
(6, 1, 'Contador Publico', 'Buscamos incorporar un/a Contador/a Público/a o Estudiante próximo a graduarse.\r\n\r\nTendrá bajo su responsabilidad principal el proceso de armado de la contabilidad general con sus papeles de trabajo tanto histórico como el ajustado por inflación y tareas administrativas relacionadas al post cierre balance, asi como armado de papeles de trabajo para confeccionar las DDJJ impositivas mensuales y anuales.\r\n\r\nEntre las tareas a desarrollar se encuentran:\r\n\r\n*Elaboración y registración de asientos contables\r\n\r\n*Análisis de cuentas y armado de Estados Contables\r\n\r\n*Preparación del ajuste por inflación de estados contables', 2333333.00, '2024-09-26 03:25:28', 'Presencial', 'Administracion, contabilidad y finanzas', 'CABA', 'Almagro', 'Argentina', 'Senior', 'Full-time', 'activa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `educacion`
--
ALTER TABLE `educacion`
  ADD PRIMARY KEY (`id_educacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cv` (`id_cv`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
  ADD PRIMARY KEY (`id_experiencia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id_idioma`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id_postulacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_vacante` (`id_vacante`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `educacion`
--
ALTER TABLE `educacion`
  MODIFY `id_educacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
  MODIFY `id_experiencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id_postulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `educacion`
--
ALTER TABLE `educacion`
  ADD CONSTRAINT `educacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `educacion_ibfk_2` FOREIGN KEY (`id_cv`) REFERENCES `cv_postulantes` (`id_cv`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `experiencia_laboral`
--
ALTER TABLE `experiencia_laboral`
  ADD CONSTRAINT `experiencia_laboral_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD CONSTRAINT `idiomas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `postulaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `postulaciones_ibfk_2` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id`);

--
-- Filtros para la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD CONSTRAINT `vacantes_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
