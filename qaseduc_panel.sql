-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-05-2026 a las 17:54:52
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qaseduc_panel`
--

DELIMITER $$
--
-- Procedimientos
--
$$

$$

$$

$$

--
-- Funciones
--
CREATE DEFINER=`qaseduc`@`localhost` FUNCTION `generarIdentificadorUnico` () RETURNS VARCHAR(16) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci  BEGIN
    DECLARE chars CHAR(62) DEFAULT 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    DECLARE result CHAR(16) DEFAULT '';
    DECLARE i INT DEFAULT 0;
    WHILE i < 16 DO
        SET result = CONCAT(result, SUBSTRING(chars, FLOOR(1 + RAND() * 62), 1));
        SET i = i + 1;
    END WHILE;
    RETURN result;
END$$

CREATE DEFINER=`qaseduc`@`localhost` FUNCTION `generarIdentificadorUnicoo` () RETURNS VARCHAR(16) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci  BEGIN
    DECLARE chars CHAR(62) DEFAULT 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    DECLARE result CHAR(16) DEFAULT '';
    DECLARE i INT DEFAULT 0;
    WHILE i < 16 DO
        SET result = CONCAT(result, SUBSTRING(chars, FLOOR(1 + RAND() * 62), 1));
        SET i = i + 1;
    END WHILE;
    RETURN result;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_adjuntos_ticket`
--

CREATE TABLE `archivos_adjuntos_ticket` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `adjunto` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `archivos_adjuntos_ticket`
--

INSERT INTO `archivos_adjuntos_ticket` (`id`, `id_ticket`, `adjunto`) VALUES
(171, 515, 'archivos/69c19a8d723fd-WhatsApp Image 2026-03-02 at 11.50.00 AM.jpeg'),
(133, 385, 'archivos/686d74866c8d8-5270924550.pdf'),
(134, 385, 'archivos/adjuntosConversacionTicket/1752005369_5237774012.pdf'),
(167, 471, 'archivos/69611abd87d13-reporte_cursos.xlsx'),
(166, 470, 'archivos/696112ecf0757-imagen.jpg'),
(165, 460, 'archivos/adjuntosConversacionTicket/1761670897_reglas_tabancura.png'),
(164, 453, 'archivos/68ed555dcd937-Listado (9).xls'),
(163, 452, 'archivos/68ed0a1f7d7ac-Resumen colegios para Carga Masiva.xlsx'),
(162, 451, 'archivos/68e79dbc09d19-pATRONhUIN.xlsx'),
(161, 439, 'archivos/68c09d2245c63-ejemplo.jpeg'),
(160, 423, 'archivos/68a78d6c40db5-7A.pdf'),
(147, 391, 'archivos/adjuntosConversacionTicket/1752250594_rack_A.png'),
(159, 420, 'archivos/688b854faf460-Captura de pantalla 2024-06-19 112453.png'),
(158, 417, 'archivos/688a81469beb2-3.1.2 Planilla evaluaciÃ³n de proyectos.xlsx'),
(157, 416, 'archivos/688a80e5dd8e1-grafico_criterios_apilado.png'),
(156, 414, 'archivos/688a80aec9c2f-Informe_Evaluacion_Factibilidad_Proyecto.docx'),
(155, 410, 'archivos/6888f3355aa55-JUAN DE DIOS FUENZALIDA IZQUIERDO IVA.pdf'),
(174, 520, 'archivos/adjuntosConversacionTicket/1774440383_modulo_eliminar_ticket_00.png'),
(175, 520, 'archivos/adjuntosConversacionTicket/1774440409_modulo_eliminar_ticket_01.png'),
(176, 520, 'archivos/adjuntosConversacionTicket/1774440419_modulo_eliminar_ticket_02.png'),
(177, 520, 'archivos/adjuntosConversacionTicket/1774440429_modulo_eliminar_ticket_03.png'),
(178, 520, 'archivos/adjuntosConversacionTicket/1774440440_modulo_eliminar_ticket_04.png'),
(179, 529, 'archivos/69d5223781325-Inicio SIAE.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_trabajo`
--

CREATE TABLE `area_trabajo` (
  `id_area` int(10) NOT NULL,
  `nombre_area` varchar(100) NOT NULL,
  `encargado_area` varchar(20) NOT NULL,
  `sigla_area` varchar(20) NOT NULL,
  `correo_encargado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `area_trabajo`
--

INSERT INTO `area_trabajo` (`id_area`, `nombre_area`, `encargado_area`, `sigla_area`, `correo_encargado`) VALUES
(1, 'INFORMATICA', 'Manuel Gonzalez', 'info', 'manuel@seduc.cl'),
(2, 'CONTABILIDAD', 'Chavez Marcos', 'cont', 'marcos@seduc.cl'),
(3, 'RECURSOS HUMANOS', 'Guadalupe Jorquera', 'RRHH', 'guadalupe@seduc.cl'),
(4, 'PROFESORAS', ' Felipe Contreras', 'O.Y.H', 'felipe@seduc.cl'),
(5, 'PREVENCION ', 'Gonzalo ', 'pr', 'gonzalo@seduc.cl'),
(6, 'VISITAS', 'xxxx', 'Vis', 'xxx@seduc.cl'),
(7, 'GERENCIA', 'ramon', 'Dios', 'dios@seduc.cl'),
(8, 'FINANZAS', 'Yanalis Reyes', 'FIN', 'yreyes@seduc.cl'),
(9, 'PERIODISTAS', 'Antonip Valdes', 'PER', 'avaldes@seduc.cl'),
(10, 'ADMINISTADOR COLEGIO', 'CCCC', 'RWE', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arquitectura_alumnos`
--

CREATE TABLE `arquitectura_alumnos` (
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ape_paterno` varchar(100) NOT NULL,
  `ape_materno` varchar(100) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sexo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `arquitectura_alumnos`
--

INSERT INTO `arquitectura_alumnos` (`id_alumno`, `nombre`, `ape_paterno`, `ape_materno`, `curso`, `edad`, `foto`, `sexo`) VALUES
(1, 'Juan', 'Perez', 'Gonzalez', '1- Basico', 6, 'img/alumno.jpg', 1),
(2, 'Maria', 'Lopez', 'Fernandez', '2-Basico', 7, 'img/alumna.jpg', 2),
(3, 'Carlos', 'Sanchez', 'Martinez', '3- Basico', 8, 'img/alumno.jpg', 1),
(4, 'Ana', 'Gomez', 'Hernandez', '4- Basico', 9, 'img/alumna.jpg', 2),
(5, 'Luis', 'Diaz', 'Paredes', '5- Basico', 10, 'img/alumno.jpg', 1),
(6, 'Paula', 'Cortes', 'Vargas', '6- Basico', 11, 'img/alumna.jpg', 2),
(7, 'Ricardo', 'Salinas', 'Morales', '7- Basico', 12, 'img/alumno.jpg', 1),
(8, 'Carla', 'Navarro', 'Castro', '8- Basico', 13, 'img/alumna.jpg', 2),
(9, 'Esteban', 'Mendez', 'Bravo', '1- Medio', 14, 'img/alumno.jpg', 1),
(10, 'Sofia', 'Rojas', 'Alvarado', '2do Medio', 15, 'img/alumna.jpg', 2),
(23, 'Juan', 'Perez', 'Gonzalez', '4to Basico', 10, 'ruta_foto.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arquitectura_apoderado`
--

CREATE TABLE `arquitectura_apoderado` (
  `id_apoderado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ape_paterno` varchar(100) NOT NULL,
  `ape_materno` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sexo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `arquitectura_apoderado`
--

INSERT INTO `arquitectura_apoderado` (`id_apoderado`, `nombre`, `ape_paterno`, `ape_materno`, `telefono`, `email`, `direccion`, `foto`, `sexo`) VALUES
(1, 'Pedro', 'Perez', 'Gonzalez', '912345678', 'pedro.perez@gmail.com', 'Calle 123, Santiago', 'img/apoderado.jpg', 1),
(2, 'Claudia', 'Lopez', 'Fernandez', '912345679', 'claudia.lopez@gmail.com', 'Avenida Siempre Viva 742, Santiago', 'img/apoderada.jpg', 2),
(3, 'Felipe', 'Sanchez', 'Martinez', '912345680', 'felipe.sanchez@gmail.com', 'Calle Los Robles 54, Valparaíso', 'img/apoderado.jpg', 1),
(4, 'Marcela', 'Gomez', 'Hernandez', '912345681', 'marcela.gomez@gmail.com', 'Avenida La Paz 100, Concepción', 'img/apoderada.jpg', 2),
(5, 'Jorge', 'Diaz', 'Paredes', '912345682', 'jorge.diaz@gmail.com', 'Calle Las Palmas 45, Antofagasta', 'img/apoderado.jpg', 1),
(6, 'Veronica', 'Cortes', 'Vargas', '912345683', 'veronica.cortes@gmail.com', 'Pasaje Las Flores 12, La Serena', 'img/apoderada.jpg', 2),
(7, 'Rodrigo', 'Salinas', 'Morales', '912345684', 'rodrigo.salinas@gmail.com', 'Calle Central 90, Rancagua', 'img/apoderado.jpg', 1),
(8, 'Lorena', 'Navarro', 'Castro', '912345685', 'lorena.navarro@gmail.com', 'Avenida Libertad 200, Talca', 'img/apoderada.jpg', 2),
(9, 'Cristian', 'Mendez', 'Bravo', '912345686', 'cristian.mendez@gmail.com', 'Calle Santa María 11, Iquique', 'img/apoderado.jpg', 1),
(10, 'Sandra', 'Rojas', 'Alvarado', '912345687', 'sandra.rojas@gmail.com', 'Avenida Del Mar 99, Arica', 'img/apoderada.jpg', 2),
(23, 'Maria', 'Perez', 'Gonzalez', '987654321', 'correo@ejemplo.com', 'Direccin 123', 'ruta_foto_apoderado.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arquitectura_retiro`
--

CREATE TABLE `arquitectura_retiro` (
  `id_retiro` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_apoderado` int(11) NOT NULL,
  `hora_retiro` time NOT NULL,
  `fecha_retiro` date NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `autorizado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `arquitectura_retiro`
--

INSERT INTO `arquitectura_retiro` (`id_retiro`, `id_alumno`, `id_apoderado`, `hora_retiro`, `fecha_retiro`, `motivo`, `observaciones`, `autorizado`) VALUES
(11, 1, 1, '10:30:00', '2024-12-01', 'Consulta médica', 'Retiro autorizado por la dirección.', 1),
(12, 2, 2, '11:00:00', '2024-12-02', 'Cita dental', 'El apoderado presentó una autorización escrita.', 1),
(13, 3, 3, '12:00:00', '2024-12-03', 'Razones familiares', 'Motivo informado por teléfono.', 0),
(14, 4, 4, '09:30:00', '2024-12-04', 'Viaje urgente', 'El alumno tenía una actividad escolar pendiente.', 1),
(15, 5, 5, '13:00:00', '2024-12-05', 'Motivo personal', 'Observaciones no registradas.', 0),
(16, 6, 6, '14:30:00', '2024-12-06', 'Emergencia', 'El apoderado contactó a la administración.', 1),
(17, 7, 7, '08:00:00', '2024-12-07', 'Razones personales', 'El apoderado no dio mayores detalles.', 0),
(18, 8, 8, '15:00:00', '2024-12-08', 'Consulta médica', 'El alumno presentó un certificado.', 1),
(19, 9, 9, '10:45:00', '2024-12-09', 'Cita oftalmológica', 'El apoderado presentó un justificativo.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avance_tecnicos`
--

CREATE TABLE `avance_tecnicos` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha_avance` date NOT NULL,
  `hora_avance` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `avance_tecnicos`
--

INSERT INTO `avance_tecnicos` (`id`, `id_ticket`, `accion`, `fecha_avance`, `hora_avance`) VALUES
(2, 1, 'ya se descargaron los archivos y se procesaron en suite ', '2024-05-10', '09:57:17'),
(4, 2, 'Se envio correo a FChavez con la solicitud de CAF', '2024-05-10', '10:00:30'),
(5, 2, 'se carga CAF en suite DBNET y se copia archivo a sucursal', '2024-05-10', '10:32:25'),
(7, 1, 'se valido y estan generadas', '2024-05-10', '10:34:19'),
(10, 3, 'ya se solicito cotizaciÃ³n a proveedores', '2024-05-10', '12:56:34'),
(12, 11, 'se recibio cotizacion y se aprobo por OM', '2024-05-14', '15:14:43'),
(14, 13, 'se realiza visita y se entregan archivos de topologia realizada en 2022', '2024-05-17', '09:52:16'),
(15, 13, 'Se sugiere realizar cambios de cables de usuario y ordenamiento de rack', '2024-05-17', '09:52:48'),
(17, 11, 'se envia OC', '2024-05-17', '10:26:30'),
(18, 3, 'Se envio aceptacion de presupuesto', '2024-05-17', '10:26:52'),
(19, 11, 'ya se encuentran cargados y facturados', '2024-05-22', '08:56:49'),
(375, 304, 'se formateo el disco y se soluciono el problema de update', '2025-06-18', '16:45:36'),
(388, 411, 'se informa que ya quedo instalado y operativo', '2025-07-31', '12:36:01'),
(29, 19, 'se hizo el contacto a Entel, Ticket 6395249', '2024-05-23', '09:18:21'),
(31, 133, 'reunion con chavez', '2024-05-23', '15:30:39'),
(463, 453, 'ya estamos terminando la revisión y salieron algunos detalles', '2025-10-14', '12:18:33'),
(462, 453, 'estoy revisando la documentación antes de iniciar', '2025-10-14', '12:15:34'),
(371, 294, 'Tengo las pilas de repuestos', '2025-06-16', '16:57:55'),
(51, 19, 'aun con problemas despues de la falla masiva, se comunico nuevamente con entel y se genero un nuevo ticket 6424242\n', '2024-05-31', '10:35:20'),
(58, 17, 'cambios realizados y en produccion', '2024-06-03', '09:01:52'),
(60, 3, 'ya recepcionado y configurado', '2024-06-03', '09:02:23'),
(387, 411, 'se realiza visita y se deja SW en prestamo para superar contingencia', '2025-07-31', '12:35:46'),
(68, 222, 'estoy validando informacion , favor esperar', '2024-06-04', '10:42:58'),
(71, 223, 'se contacto a Ejecutivo Daniel Mariangel y enviara coti', '2024-06-04', '12:36:08'),
(72, 223, 'se acepto la propuesta y esta en curso', '2024-06-04', '12:36:32'),
(73, 223, 'upgrade realizado', '2024-06-04', '12:36:47'),
(79, 275, 'preparando plantilla', '2024-06-05', '16:38:34'),
(82, 284, 'me contacte con entel y estara enlace monitoreajdo', '2024-06-06', '16:18:34'),
(83, 284, 'falla masiva del sector', '2024-06-06', '16:18:53'),
(84, 284, 'tema resuelto corte de FO', '2024-06-06', '16:19:04'),
(95, 303, 'Deben indicar lo que necesitan y restricciones para desarrollar,', '2024-06-14', '09:31:52'),
(163, 376, 'Sistema funcionando y operativo', '2024-06-24', '16:30:56'),
(169, 23, 'papel atascado', '2024-07-09', '12:16:33'),
(190, 61, 'ningun problema  para comenzar', '2024-07-27', '13:31:08'),
(191, 61, 'eduardo macaya\n', '2024-07-27', '13:31:22'),
(192, 61, 'Ã±Ã±Ã±Ã±', '2024-07-27', '13:32:16'),
(225, 110, 'Acceso creado y omunicado', '2025-03-05', '08:47:54'),
(232, 117, 'Reporte Generado', '2025-03-06', '11:50:59'),
(235, 118, 'Carga terminada 3 usuarias ya habÃ­an hecho el curso', '2025-03-06', '13:23:27'),
(500, 506, 'preparacion de base', '2026-03-17', '11:17:10'),
(491, 481, 'Re evaluar modalidad de aviso de modificaciones de ficha', '2026-03-16', '15:25:27'),
(490, 504, 'cuenta mpcorrea@ existe', '2026-03-12', '16:44:18'),
(489, 504, 'cuentas mlpavic@ creada', '2026-03-12', '16:44:07'),
(488, 452, 'favor dar datos del nuevo usuario:\n-correo \n- Anexo \n- Área de trabajo', '2026-03-11', '22:03:26'),
(487, 488, 'HOJA de Respuesta configurada y exportada a todos los colegios', '2026-03-09', '15:48:25'),
(486, 483, 'Todos los colegios cargados', '2026-03-03', '10:30:54'),
(485, 476, 'correo ya creado', '2026-03-02', '11:52:26'),
(262, 122, 'informaciomn enviada por correo al usuario', '2025-03-11', '15:50:25'),
(264, 131, 'todos los correos enviados x colegio', '2025-03-12', '14:08:40'),
(484, 479, 'Planilla configurada para ColexIA', '2026-02-26', '11:36:42'),
(267, 133, 'Realizada copia del curso y asignaciÃ³n de profesores', '2025-03-13', '08:57:23'),
(270, 134, 'Esperando AsignaciÃ³n de hora para la instalaciÃ³n por parte del usuario', '2025-03-13', '09:30:04'),
(459, 451, 'Generado XML y se procede a la carga', '2025-10-09', '08:35:44'),
(461, 451, 'Se valida Carga. Se harÃ¡ Ajuste de nombre en el futuro pero todos estÃ¡n cargados', '2025-10-09', '08:45:17'),
(455, 447, 'qqq', '2025-09-22', '14:14:49'),
(456, 447, '77777777', '2025-09-23', '11:07:02'),
(284, 135, 'el usuario le falta clases de programacion ', '2025-03-13', '16:25:24'),
(460, 451, 'Carga XML en Follett', '2025-10-09', '08:36:13'),
(373, 269, 'usuario siae@colegiolosandes.cl  con la clave 123456\n\nCon respesto al usuario del colegio cordillera POR FAVOR confirmar Correo info@colegiocordillera.cl', '2025-06-17', '11:37:40'),
(483, 473, 'Curso migrado. Algunas preguntas de las evaluaciones deben modificarse por el tipo de respuesta requerida', '2026-02-26', '11:36:09'),
(482, 471, 'Se cargan todos los cursos y proveedores validados. Quedan los cursos PLP que requieren definiciones', '2026-01-12', '10:54:31'),
(480, 469, 'se valido y ya quedo operativo', '2026-01-08', '09:50:02'),
(481, 471, 'Se crean todos los curso en BUK. En proceso carga de instancias', '2026-01-09', '12:13:47'),
(479, 469, 'Se llamo a Soporte para validar bloqueo', '2026-01-08', '09:49:51'),
(478, 462, 'generando DNS y regla', '2025-11-06', '14:26:57'),
(372, 294, 'Evento todo Un exito', '2025-06-17', '11:02:14'),
(305, 123, 'Logre adoptar los Tenant con la cuenta mgutierrez@ de cada dominio', '2025-03-27', '10:30:12'),
(306, 123, 'se habilitara cuenta a TI del colegio para su administracion y creacion de usuarios', '2025-03-27', '10:30:58'),
(477, 461, 'creacion de DNS y regla de redireccionamiento', '2025-10-29', '11:53:55'),
(374, 304, 'estoy actualizando el equipo ya que tenia una version mas antigua', '2025-06-18', '16:32:49'),
(370, 294, 'el evento serÃ¡ a las 9:15 dirigido por Gonzalo MuÃ±oz', '2025-06-16', '16:57:43'),
(369, 267, 'problemas con la tinta', '2025-06-13', '14:01:02'),
(476, 460, 'ya se realiza la habiliotacion y prueba', '2025-10-28', '14:07:41'),
(475, 460, 'se eliminan congresoconvivencia y segundociclo', '2025-10-28', '14:07:15'),
(467, 457, 'ok , ok', '2025-10-14', '16:37:27'),
(474, 460, 'se procede a consultar que redireccionamiento se pueden elimianr ya que solo se soportan 10', '2025-10-28', '14:06:52'),
(464, 457, 'ok', '2025-10-14', '15:37:54'),
(386, 394, 'Se crea regla y se valida', '2025-07-15', '11:05:02'),
(385, 394, 'Se creo DNS', '2025-07-15', '11:04:52'),
(384, 391, 'dentro de las evaluadas es la mejor', '2025-07-11', '12:21:13'),
(383, 391, 'analizando propuerstas de la marca', '2025-07-11', '12:20:43'),
(382, 159, 'Listo', '2025-07-08', '16:45:22'),
(381, 161, 'Factura OK , Pagada', '2025-07-08', '16:44:38'),
(380, 230, 'Creadas Carpetas en Drive Unidades compartidas', '2025-07-08', '16:44:06'),
(379, 385, 'respuesta enviada del proveedor', '2025-07-08', '16:13:37'),
(378, 385, 'esperando respuesta de Microsoft', '2025-07-08', '16:13:05'),
(377, 339, 'se puede agregar mas comentarios', '2025-06-26', '09:00:22'),
(376, 339, 'Revisando y analizando  informacion enviada', '2025-06-26', '08:57:37'),
(353, 233, 'probando', '2025-06-08', '22:56:48'),
(390, 434, 'Ya se estan creando las cuentas en el portal', '2025-09-04', '10:36:29'),
(389, 424, 'regla realizada', '2025-09-03', '09:19:26'),
(360, 231, 'estoy revisando la opcion de acceso web a office 365', '2025-06-09', '15:11:37'),
(361, 231, 'por error puse finalizar', '2025-06-09', '15:15:20'),
(362, 231, 'se debe poner un modal de confirmacion', '2025-06-09', '15:15:43'),
(502, 520, '- creación en el  menú de configuración -> permisos  la pestaña de \"mantenimiento Ticket\"', '2026-03-25', '08:55:59'),
(503, 520, '- En \"mantenimiento ticket\" hay dos contenedores  1. eliminar ticket y 2. fusionar Ticket', '2026-03-25', '08:56:49'),
(504, 520, 'En eliminar Ticket están un listado de  los ticket con un button  eliminar , al presionarlo te manda un codigo al correo para confirma r el proceso , se ingresa el código en el mismo modal y se elimina el ticket en todas tus tablas relacionada', '2026-03-25', '08:58:29'),
(505, 515, 'estructura lista https://qa.seduc.cl/jorquera/sistema_lectura/  . trabajando con las tablas', '2026-04-01', '10:24:23'),
(506, 527, 'Espera de la validación de Francisco Valenzuela.\n\nComparto el enlace de acceso al sistema para revisión:\nhttps://qa.seduc.cl/jorquera/calculo_remuneraciones/login.php\n\nUsuario: correo corporativo\nContraseña inicial: 123456 (válida para todos los usuarios ', '2026-04-01', '12:05:55'),
(507, 527, 'El sistema fue revisado y aprobado por Francisco Valenzuela. Se realizará el cambio de nombre desde “Sistema de Horarios” a “Calculadora de Horas Pedagógicas y Cronológicas”.\n\nFrancisco utilizará el módulo de envío de credenciales, el cual permite que al ', '2026-04-01', '14:37:22'),
(508, 527, 'correo enviado', '2026-04-01', '14:58:54'),
(509, 515, 'Sistema en evaluación por Ramon , esperando aprobación', '2026-04-06', '10:23:23'),
(510, 528, 'Se informa que el módulo de Inventario de Software ya fue desarrollado y se encuentra avanzado en su implementación.\nActualmente permite registrar y administrar licencias de software, páginas web asociadas, responsables del sistema, proveedores y datos re', '2026-04-06', '14:33:39'),
(511, 530, 'Se soliictaron acceso como usuario administrador de los dominios', '2026-04-07', '14:20:14'),
(512, 530, 'se modificaron datos de facturacion de los dominios a Seduc Spa', '2026-04-07', '14:20:35'),
(513, 480, 'Solicitar a Veronica Alvarez detalles sobre finalidad del comentario', '2026-04-07', '15:17:56'),
(514, 480, 'OK, espero respuesta', '2026-04-07', '15:21:34'),
(515, 492, 'AR contactará a consejo de algún colegio  para piloto con PJ para citas', '2026-04-07', '15:24:48'),
(516, 492, 'Modificar envío de correo para que el PJ decida a quien enviar el correo primero', '2026-04-07', '15:27:30'),
(517, 480, 'La tnes puede agregar un comentario con texto libre y este debe enviarse por correo al apoderado indicando \"Información adicional a la atención de enfermería del dia-----\"', '2026-04-07', '16:25:21'),
(518, 528, 'Agregar usuario – terminado.\n\nAl crear un nuevo usuario, se enviará automáticamente un correo electrónico al usuario registrado. Desde ese correo podrá definir su propia contraseña, la cual debe ser alfanumérica y tener un máximo de 8 caracteres.', '2026-04-07', '21:54:24'),
(519, 530, 'se genero pago y quedo ok la renovacion hasta 2029', '2026-04-08', '15:20:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficios_destacados`
--

CREATE TABLE `beneficios_destacados` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `img` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficios_destacados`
--

INSERT INTO `beneficios_destacados` (`id`, `titulo`, `img`, `descripcion`, `url`) VALUES
(14, 'beneficio de salida', 'imagenes/599010.jpg', 'horario de salida los viernes  3:30', 'eeeeeee'),
(15, 'Programador de la NASA', 'imagenes/468739.jpg', 'CHILENO Cristian jorquera es contratado por al NASA', 'DDDDDDDD'),
(16, 'ramon', 'imagenes/firma_email.jpg', 'el ramon es entero pulento', 'erwr');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficios_principales`
--

CREATE TABLE `beneficios_principales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficios_principales`
--

INSERT INTO `beneficios_principales` (`id`, `nombre`, `imagen`, `url`) VALUES
(1, 'SALUD', 'imagenesdescuento_salud.jpeg', 'beneficios_salud.php'),
(2, 'EDUCACION', 'imagenestiempo_libre.jpeg', 'imagenes/educacion.jpeg'),
(3, 'VIDA FAMILIAR', 'imagenesfamilia.jpeg', 'imagenes/tiempo_libre.jpeg\''),
(4, 'DEPORTE', 'imagenesdeporte.jpeg', 'imagenes/deporte.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_eventos`
--

CREATE TABLE `calendario_eventos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(180) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `todo_el_dia` tinyint(1) NOT NULL DEFAULT 0,
  `color` varchar(20) NOT NULL DEFAULT '#2563eb',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendario_eventos`
--

INSERT INTO `calendario_eventos` (`id`, `id_usuario`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `todo_el_dia`, `color`, `created_at`, `updated_at`) VALUES
(1, 1, 'reunion de informatica', 'reunión informativa de informatica', '2026-03-04 15:00:00', '2026-03-04 15:02:00', 1, '#dc2626', '2026-03-03 12:02:02', '2026-03-03 12:02:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_ticket`
--

CREATE TABLE `calificacion_ticket` (
  `id` int(11) NOT NULL,
  `calificacion` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `calificacion_ticket`
--

INSERT INTO `calificacion_ticket` (`id`, `calificacion`, `orden`) VALUES
(4, 'Satisfactorio', 1),
(3, 'Insatisfactorio', 2),
(2, 'Incompleto', 3),
(1, 'Requiere revisión', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_tickett`
--

CREATE TABLE `calificacion_tickett` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `id_calificacion` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ip_usuario` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `calificacion_tickett`
--

INSERT INTO `calificacion_tickett` (`id`, `id_ticket`, `id_usuario`, `id_tecnico`, `id_calificacion`, `comentario`, `fecha`, `hora`, `ip_usuario`) VALUES
(80, 504, 42, 7, 4, 'USUARIOS OK', '2026-03-16', '11:00:14', '186.67.42.46'),
(81, 495, 42, 42, 4, 'Perfecto', '2026-03-16', '11:00:52', '186.67.42.46'),
(82, 496, 42, 42, 4, 'OK', '2026-03-16', '11:01:17', '186.67.42.46'),
(83, 472, 42, 8, 4, 'Está OK', '2026-03-16', '15:07:29', '186.67.42.46'),
(84, 423, 45, 6, 4, NULL, NULL, NULL, ''),
(85, 460, 45, 7, 4, NULL, NULL, NULL, ''),
(79, 476, 42, 7, 4, '', '2026-03-12', '10:53:12', '186.67.42.46'),
(77, 478, 42, 42, 3, 'Se modifica con solución alternativa', '2026-03-09', '15:53:10', '186.67.42.46'),
(78, 486, 42, 6, 4, 'Correcciones OK', '2026-03-10', '15:34:20', '186.67.42.46'),
(76, 487, 42, 42, 4, 'Licencias OK', '2026-03-09', '15:51:30', '186.67.42.46'),
(67, 471, 42, 42, 4, 'Todo Queda OK', '2026-01-12', '10:57:34', '186.67.42.46'),
(68, 469, 42, 7, 4, 'Arreglado muy rapidamente', '2026-01-12', '10:58:05', '186.67.42.46'),
(69, 485, 42, 7, 4, 'Perfecto', '2026-03-09', '15:44:52', '186.67.42.46'),
(70, 483, 42, 42, 4, 'OK', '2026-03-09', '15:45:42', '186.67.42.46'),
(71, 482, 42, 7, 4, 'quedan OK', '2026-03-09', '15:46:10', '186.67.42.46'),
(72, 479, 42, 42, 4, 'Listo', '2026-03-09', '15:46:40', '186.67.42.46'),
(73, 477, 42, 42, 4, 'Perfil OK', '2026-03-09', '15:47:07', '186.67.42.46'),
(74, 473, 42, 42, 4, 'Curso probado OK', '2026-03-09', '15:47:44', '186.67.42.46'),
(75, 488, 42, 42, 4, 'EPHC1 OK', '2026-03-09', '15:51:03', '186.67.42.46'),
(65, 447, 27, 8, 4, '', '2025-09-23', '12:04:53', '186.67.42.46'),
(66, 451, 42, 42, 4, 'El tecnico realizÃ³ el trabajo a la perfeccion', '2025-10-09', '15:13:50', '186.67.42.46'),
(64, 418, 42, 6, 4, 'Recibido OK', '2025-07-30', '16:52:50', '186.67.42.46'),
(63, 419, 42, 6, 4, 'Archivo recibido correctamente', '2025-07-30', '16:52:15', '186.67.42.46'),
(62, 394, 45, 7, 2, 'probando', '2025-07-24', '14:19:12', '186.67.42.46'),
(59, 385, 31, 7, 4, 'todo perfecto !!!', '2025-07-08', '16:27:30', '186.67.42.46'),
(60, 391, 31, 7, 4, 'buen trabajo', '2025-07-11', '12:23:46', '186.67.42.46'),
(86, 11, 10, 6, 4, '', '2026-03-24', '10:00:59', '186.67.42.46'),
(87, 513, 42, 42, 4, 'Cambio OK', '2026-03-24', '10:06:43', '186.67.42.46'),
(88, 521, 42, 42, 4, 'Correos OK', '2026-03-25', '13:04:07', '186.67.42.46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capsulas`
--

CREATE TABLE `capsulas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumen` text NOT NULL,
  `contenido` longtext NOT NULL,
  `categoria` enum('phishing','smishing','vishing','malware','fraude','contrasenas','redes','identidad') NOT NULL,
  `nivel` enum('basico','intermedio','avanzado') DEFAULT 'basico',
  `icono` varchar(100) DEFAULT 'shield',
  `archivo_descarga` varchar(255) DEFAULT NULL,
  `url_profundizar` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `destacado` tinyint(1) DEFAULT 0,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `vistas` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capsulas`
--

INSERT INTO `capsulas` (`id`, `titulo`, `resumen`, `contenido`, `categoria`, `nivel`, `icono`, `archivo_descarga`, `url_profundizar`, `activo`, `destacado`, `fecha_publicacion`, `vistas`) VALUES
(1, '¿Qué es el Phishing?', 'Aprende a identificar correos fraudulentos que buscan robar tus datos.', 'El phishing es...', 'phishing', 'basico', 'mail', NULL, 'https://www.creadess.org/phishing', 1, 1, '2026-05-10 20:47:35', 0),
(2, 'Smishing: Fraudes por SMS', 'Los mensajes de texto también pueden ser una trampa. Conoce cómo protegerte.', 'El smishing es...', 'smishing', 'basico', 'smartphone', NULL, 'https://sitiospublicos.bancochile.cl/personas/seguridad/detalle/smishing', 1, 1, '2026-05-10 20:47:35', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_de_ticket`
--

CREATE TABLE `categoria_de_ticket` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `abreviacion` varchar(50) NOT NULL,
  `icono` varchar(30) NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria_de_ticket`
--

INSERT INTO `categoria_de_ticket` (`id_categoria`, `nombre_categoria`, `abreviacion`, `icono`, `orden`, `estado`) VALUES
(1, 'Seduc Servicios', 'S.Servicios', 'bi-building', 1, 1),
(2, 'Siae', 'Siae', 'bi-person-workspace', 2, 1),
(3, 'Redes', 'Redes', 'bi-wifi', 3, 1),
(4, 'Telefonica', 'Telefonia', 'bi-telephone', 4, 1),
(5, 'Impresiones', 'Impresiones', 'bi-printer', 5, 1),
(6, 'Soporte', 'Soporte', 'bi-tools', 6, 1),
(7, 'Correos', 'Correos', 'bi-envelope', 7, 1),
(10, 'Otros', 'Otros', 'bi-puzzle', 11, 1),
(8, 'Moddle', 'Moddle', 'bi-box', 8, 1),
(9, 'Follet', 'Follet', 'bi-book', 9, 1),
(11, ' Sistema de  Ticket', 'S. Ticket', 'bi-server', 10, 1),
(12, 'Web', 'Paginas Web ', 'bi bi-diagram-3', 12, 1),
(16, 'Licenciamiento', 'Licen', 'bi-key-fill', 13, 1),
(17, 'BUK', 'buk', 'bi-people-fill', 14, 1),
(18, 'Envio Mail', 'EMail', 'bi-envelope-fill', 15, 1),
(19, 'ejemplo', 'ejemplo', 'bi-wifi', 16, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_herramienta_catalogo`
--

CREATE TABLE `categoria_herramienta_catalogo` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(80) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_herramienta_catalogo`
--

INSERT INTO `categoria_herramienta_catalogo` (`id_categoria`, `nombre_categoria`, `activo`) VALUES
(1, 'Manual', 1),
(2, 'Electrica', 1),
(3, 'Medicion', 1),
(4, 'Seguridad', 1),
(5, 'Mantencion', 1),
(6, 'Jardineria', 1),
(7, 'Limpieza', 1),
(8, 'Otro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_tecnico`
--

CREATE TABLE `categoria_tecnico` (
  `id_categoria_tecnico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria_tecnico`
--

INSERT INTO `categoria_tecnico` (`id_categoria_tecnico`, `id_categoria`, `id_tecnico`) VALUES
(140, 4, 7),
(134, 1, 6),
(114, 2, 6),
(139, 3, 7),
(141, 5, 8),
(142, 8, 42),
(144, 9, 42),
(145, 6, 7),
(156, 18, 6),
(147, 11, 8),
(148, 7, 7),
(155, 16, 7),
(154, 17, 42),
(153, 12, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_qr`
--

CREATE TABLE `codigos_qr` (
  `id_qr` int(11) NOT NULL,
  `nombre_taller` varchar(255) NOT NULL,
  `fecha_taller` date NOT NULL,
  `url_formulario` text NOT NULL,
  `qr_path` varchar(255) NOT NULL,
  `generado_por` int(11) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colegio`
--

CREATE TABLE `colegio` (
  `id_colegio` int(11) NOT NULL,
  `nom_colegio` varchar(60) NOT NULL,
  `rza_colegio` varchar(50) NOT NULL,
  `nco_colegio` varchar(150) NOT NULL,
  `dir_colegio` varchar(50) NOT NULL,
  `rbd_colegio` varchar(10) NOT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_comuna` int(11) NOT NULL,
  `tel_colegio` varchar(10) NOT NULL,
  `web_colegio` varchar(60) NOT NULL,
  `bd` varchar(30) NOT NULL,
  `orden` int(11) NOT NULL,
  `email_entrevista` varchar(100) NOT NULL,
  `num_r_educacion` int(11) NOT NULL,
  `ano_r_educacion` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `email_comunicaciones` varchar(100) NOT NULL,
  `sexo` int(11) NOT NULL DEFAULT 0,
  `multi_cole` varchar(2) NOT NULL DEFAULT 'no',
  `identificador` varchar(20) NOT NULL,
  `rut_colegio` varchar(12) NOT NULL,
  `correo_contrato` varchar(50) NOT NULL,
  `url_pagina` varchar(255) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = activo |\r\n0 = inactivo\r\n\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `colegio`
--

INSERT INTO `colegio` (`id_colegio`, `nom_colegio`, `rza_colegio`, `nco_colegio`, `dir_colegio`, `rbd_colegio`, `id_dependencia`, `id_comuna`, `tel_colegio`, `web_colegio`, `bd`, `orden`, `email_entrevista`, `num_r_educacion`, `ano_r_educacion`, `ip`, `email_comunicaciones`, `sexo`, `multi_cole`, `identificador`, `rut_colegio`, `correo_contrato`, `url_pagina`, `estado`) VALUES
(1, 'Colegio Cordillera de las Condes', 'SEDUC Spa y Compañia CPA Cuatro', 'Colegio Cordillera', 'Los Pumas Nro 12015', '8902-8', 2, 290, '4295900', 'http://www.colegiocordillera.cl', 'seduc', 4, 'info@colegiocordillera.cl', 40, 1983, '200.111.15.3', 'comunicacion@colegiocordillera.cl', 1, 'no', 'CBHgdA8z7j74n3933pKQ', '79848720-5', 'cm.mail.com', 'cordillera.php', 1),
(8, 'Colegio Tabancura', 'SEDUC Spa y Compañia CPA Dos', 'Colegio Tabancura', 'Las Hualtatas Nro 10650', '8862-5', 2, 308, '8976300', 'http://www.tabancura.cl', 'seduc', 2, 'consejodireccion@tabancura.cl', 152, 1986, '152.231.78.42', 'consejodireccion@tabancura.cl', 1, 'no', '64N93dwf6k76P3N9y858', '83332100-5', 'administradorColegioTabancura@gmail.com', 'tabancura.php', 1),
(9, 'Colegio Los Andes de Vitacura', 'SEDUC Spa y Compañia CPA Uno', 'Colegio Los Andes', 'San Damian Nro 0100', '8871-4', 5, 308, '232232500', 'http://www.colegiolosandes.cl/', 'seduc', 1, 'entrevista@colegiolosandes.cl', 10118, 1979, '152.231.77.98', 'colegiolosandes@colegiolosandes.cl', 2, 'no', 'uoB53uIn51qb1ad4537u', '70054800-7', 'administacionColegiolosandes@gmail.com', 'losAndess.php', 1),
(10, 'Colegio Los Alerces', 'SEDUC Spa y Compañia CPA Cinco', 'Colegio Los Alerces', 'El Radal Nro 437', '24979-3', 4, 291, '228207900', 'http://www.colegiolosalerces.cl/', 'seduc', 5, 'colegioalerces@siae.cl', 3127, 1996, '186.67.49.138', 'colegiolosalerces@colegiolosalerces.cl', 2, 'no', 'RxLNwR61Vee02s2VzKyi', '87152200-6', 'lupejorquera@gmail.com', 'losAlerces.php', 1),
(11, 'Colegio Huelén', 'SEDUC Spa y Compañia CPA Tres', 'COLEGIO HUELEN', 'Av. Santa María Nro 6.480', '8953-2', 308, 308, '', 'http://www.colegiohuelen.cl/', 'seduc', 3, 'entrevista@huelen.cl', 5171, 1978, '152.231.77.114', 'comunicaciones@huelen.cl', 2, 'no', '2sc922imu2eFvyvsX53B', '87042000-5', 'administradorCOLEGIOHUELEN@gmail.com', 'hulen.php', 1),
(12, 'Colegio Cantagallo', 'SEDUC Spa y Compañia CPA Siete', 'Colegio Cantagallo', ' Av. Monseñor Escrivá de Balaguer Nro 13.322', '12345-6', 0, 290, '0', 'http://colegiocantagallo.cl/', 'seduc', 10, 'secretaria@colegiocantagallo.cl', 0, 0, '190.82.87.210', 'secretaria@colegiocantagallo.cl', 1, 'si', 'j6i8IdpDB7jsp52yE3Iw', '76328035-7', 'cm.jorquerag@gmail.com', NULL, 1),
(13, 'Colegio Huinganal', 'SEDUC Spa y Compañia CPA Seis', 'Colegio Huinganal', 'Av. Monseñor Adolfo Rodríguez Nro 13210', '20311-4', 0, 308, '225921720', 'http://www.colegiohuinganal.cl/', 'seduc', 7, 'huinganal@siae.cl', 3523, 2014, '', 'comunicaciones@colegiohuinganal.cl', 1, 'no', 'KH0RWJv5N7P4HcL333WK', '76232345-1', 'cm.jorquerag@gmail.com', 'huinganal.php', 1),
(14, 'Colegio Prueba', 'Colegio Prueba Ltda', 'Colegio Prueba', 'direccion', '9999-9', 1, 290, '111111', '', 'prueba', 1, 'soporte@siae.cl', 1999, 2011, '', 'soporte@siae.cl', 0, 'no', '3K67M9z8801aF3YNt6c0', '', 'administradorColegioPrueba@gmail.com', 'colegioPrueba.php', 1),
(15, 'Seduc SpA', 'Seduc SpA', 'Seduc', 'Las Hualtatas 10030', '9876-5', 3, 290, '224380300', 'www.seduc.cl', 'seduc', 0, 'seduc.informa@seduc.cl', 0, 0, '186.67.42.46', 'seduc.informa@seduc.cl', 0, 'no', '024Jw16809k8gopl85fJ', '', 'cm.jorquerag@gmail.com', 'seduc.php', 1),
(17, 'Valle Alegre', 'Valle Alegre', 'Valle Alegre', ' ', '11111-1', 0, 290, '0', 'http://www.valegre.cl/', 'seduc', 11, 'secretaria@valegre.cl', 0, 0, '190.82.87.210', 'secretaria@valegre.cl', 1, 'no', 'tte45asashw22346hh', '', 'administra@gmail.com', NULL, 2),
(22, 'Colegio Pinares', 'Sociedad Administradora Educacional y Cía. CPA Pin', 'Pinares', 'Camino a Chiguayante N 5583', 'b', 0, 0, '', '', '', 0, '', 0, 0, '', '', 0, 'no', '', '87019400-5', 'administradorPinares@gmail.com', NULL, 1),
(23, 'Colegio Itahue', 'Sociedad Administradora Educacional y Cía. CPA Ita', 'Itahue', '', 'a', 0, 0, '', '', '', 0, '', 0, 0, '', '', 0, 'no', '', '87019200-2', 'administradorItahue@gmail.com', NULL, 2),
(24, 'Alto Rio', 'Alto Rio', 'Alto Rio', '', 'd', 0, 0, '', '', '', 0, '', 0, 0, '', '', 0, 'no', '', '', 'administradorAlto Rio@gmail.com', NULL, 2),
(25, 'Adesa', 'Adesa', 'Adesa', '', 'E', 0, 0, '', '', '', 0, '', 0, 0, '', '', 0, 'no', '', '', 'administradorAdesa@gmail.com', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_ticket`
--

CREATE TABLE `comentarios_ticket` (
  `id_comentario` int(11) NOT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_usuario` int(2) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_comentario` date DEFAULT NULL,
  `hora_comentario` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comentarios_ticket`
--

INSERT INTO `comentarios_ticket` (`id_comentario`, `id_ticket`, `id_usuario`, `id_tecnico`, `comentario`, `fecha_comentario`, `hora_comentario`) VALUES
(19, 25, 8, NULL, NULL, NULL, NULL),
(18, 24, 8, NULL, NULL, NULL, NULL),
(20, 26, 8, NULL, NULL, NULL, NULL),
(21, 27, 8, NULL, NULL, NULL, NULL),
(22, 28, 8, NULL, NULL, NULL, NULL),
(23, 29, 8, NULL, NULL, NULL, NULL),
(24, 30, 8, NULL, NULL, NULL, NULL),
(25, 31, 8, NULL, NULL, NULL, NULL),
(26, 32, 8, NULL, NULL, NULL, NULL),
(27, 33, 8, NULL, NULL, NULL, NULL),
(28, 34, 8, NULL, NULL, NULL, NULL),
(29, 35, 8, NULL, NULL, NULL, NULL),
(30, 36, 8, NULL, NULL, NULL, NULL),
(31, 37, 8, NULL, NULL, NULL, NULL),
(32, 38, 8, NULL, NULL, NULL, NULL),
(33, 39, 7, NULL, NULL, NULL, NULL),
(34, 40, 7, NULL, NULL, NULL, NULL),
(35, 41, 8, NULL, NULL, NULL, NULL),
(36, 42, 8, NULL, NULL, NULL, NULL),
(37, 43, 8, NULL, NULL, NULL, NULL),
(38, 44, 8, NULL, NULL, NULL, NULL),
(39, 45, 8, NULL, NULL, NULL, NULL),
(40, 46, 8, NULL, NULL, NULL, NULL),
(41, 47, 8, NULL, NULL, NULL, NULL),
(42, 48, 7, NULL, NULL, NULL, NULL),
(43, 49, 7, NULL, NULL, NULL, NULL),
(44, 50, 7, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedor`
--

CREATE TABLE `contenedor` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `url_` varchar(500) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `contenedor`
--

INSERT INTO `contenedor` (`id`, `id_usuario`, `nombre`, `url_`, `imagen`, `descripcion`, `fecha`, `hora`) VALUES
(1, 1, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(221, 1, 'seduc', 'https://mail.google.com/mail/u/0/#inbox', 'gmail.jpg', '', '2025-02-26', '15:14:01'),
(4, 1, 'cpanel', 'https://cp.seduc.cl:2083/', 'panel-de-control-de-cpanel-1.png', '', '2024-04-24', '16:04:29'),
(5, 1, 'La tercera', 'https://www.latercera.com/', 'la_tercera.png', '', '2024-04-24', '16:04:29'),
(6, 1, 'Rexm', 'https://cliente.hostgator.cl/', 'hosgator.png', '', '2024-04-24', '16:04:29'),
(8, 3, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(9, 3, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(10, 4, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(250, 1, 'eee', 'www.google.cl', '', '', '2026-05-10', '18:04:31'),
(12, 4, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(13, 5, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(14, 5, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(15, 5, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(16, 6, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(17, 6, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(212, 7, 'GOOGLE', 'www.google.cl', 'google_.png', '', '2024-06-19', '10:24:13'),
(215, 7, 'CORREO', 'https://https//mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'resized_GMAIL.jpeg', '', '2024-06-19', '10:30:31'),
(21, 7, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(218, 8, 'EJEMPLO', 'www.seduc.cl', 'WIN_20231010_20_16_53_Pro.jpg', '', '2024-12-23', '16:13:03'),
(174, 28, 'Seduc', 'www.seduc.cl', '', '', '2024-06-04', '10:36:30'),
(222, 1, 'Duoc', 'https://campusvirtual.duoc.cl/ultra/stream', 'duoc_ava.jpg', '', '2025-05-15', '20:05:05'),
(25, 9, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(26, 9, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(27, 9, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(28, 10, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(29, 10, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(30, 10, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(31, 11, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(32, 11, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(33, 11, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(34, 12, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(35, 12, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(36, 12, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(37, 13, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(38, 13, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(39, 13, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(40, 14, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(41, 14, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(42, 14, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(43, 15, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(44, 15, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(45, 15, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(46, 16, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(47, 16, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(48, 16, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(49, 17, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(50, 17, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(51, 17, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(52, 18, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(53, 18, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(54, 18, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(55, 19, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(56, 19, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(57, 19, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(58, 20, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(59, 20, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(60, 20, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(61, 21, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(62, 21, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(63, 21, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(64, 22, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(65, 22, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(66, 22, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(67, 23, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(68, 23, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(69, 23, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(70, 24, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(71, 24, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(72, 24, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(73, 25, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(74, 25, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(75, 25, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(76, 26, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(77, 26, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(78, 26, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(79, 27, 'Google', 'www.google.cl', 'google.png', '', '2024-04-24', '16:04:29'),
(80, 27, 'Correo', 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', 'correo_electronico.png', '', '2024-04-24', '16:04:29'),
(81, 27, 'Rexm', 'URL_de_rexm', 'rex_mas.png', '', '2024-04-24', '16:04:29'),
(198, 35, '4444444', '444444', 'resized_deporte.jpeg', '', '2024-06-12', '10:30:41'),
(143, 7, 'FIN700', 'http://198.41.33.125/Fin700Seduc/', 'logo_contenedor.png', '', '2024-05-10', '15:23:54'),
(210, 8, 'rex', 'https://qa.seduc.cl/sistema/', 'rex_mas.png', '', '2024-06-19', '10:14:35'),
(142, 7, 'Seduc', 'www.seduc.cl', 'logo_contenedor.png', '', '2024-05-03', '09:43:23'),
(145, 7, 'DBNet', 'https://fe.cl.dbnetcorp.com/SE62/DBNET_GENE', 'logo_contenedor.png', '', '2024-05-10', '15:25:19'),
(223, 1, 'Banco', 'https://login.portales.bancochile.cl/login?state=hKFo2SByLU5ySUdCUG9oZTJTdUpCX19oQUF1cTNNdHEzNTFCd6FupWxvZ2luo3RpZNkgczdEOE5EeThUaHBHNkVGMnU5QTdkc3JHek5VaUZ4NkGjY2lk2SBmUDdKVmRvcGV2VGFvZmJYcmZrMUZUZW9sVTVYTDE2NQ&client=fP7JVdopevTaofbXrfk1FTeolU5XL165&pro', 'el-banco-de-chile-vector-logo.png', '', '2026-03-03', '08:35:03'),
(153, 25, 'YOUTUBE', 'https://www.youtube.com/watch?v=t62CCTH-OlY&list=RD1rcU4v-R_gY&index=32', 'trabajo.jpg', '', '2024-05-27', '09:10:57'),
(156, 7, 'NIC', 'www.nic.cl', 'Oferta comercial SEDUC.png', '', '2024-05-31', '15:06:26'),
(196, 35, '3333', '3333', 'resized_grafico_de_barras.jpg', '', '2024-06-12', '10:29:03'),
(170, 28, 'SIAE', 'www.siae.cl', 'logo_contenedor.png', '', '2024-06-03', '14:54:33'),
(224, 1, 'Yotube', 'https://personas.seduc.cl/principal.php', 'Youtube_logo.png', '', '2026-03-03', '08:48:19'),
(225, 1, 'banco santander', 'https://banco.scotiabank.cl/mfe-login/scotia?c=N0lQXniwgYD9sdCsuh1vHpKCvIvcRQ3roynKYRlmKsSPeZMyl3lyesgRTzn5WpCYR7f-Bdei5ayhhYQyxVCAXStFmYeEorlDPEvMZ44XNJs', 'banco-santander-20260329202156.png', '', '2026-03-26', '18:53:40'),
(226, 1, 'ssitemaa ticket', 'https://acceso.seduc.cl/', 'logo_ticket.jpeg', '', '2026-03-26', '18:59:05'),
(227, 1, 'sistema calculo horas', 'https://qa.seduc.cl/calculo_horas/login.php', 'sistema-calculo-horas-20260326190108.png', '', '2026-03-26', '19:01:08'),
(228, 1, 'caja 2026', 'https://qa.seduc.cl/jorquera/tesis/', 'seduc_servicios.png', '', '2026-03-26', '19:05:31'),
(229, 1, 'sisema personal seduc', 'https://personas.seduc.cl/', 'sistema_personal_seduc.jpg', '', '2026-03-26', '19:08:42'),
(230, 1, 'sitema finanzas', 'https://qa.seduc.cl/jorquera/sistema_finanzas/explicacion.php', 'FINAZAS.jpeg', '', '2026-03-26', '19:12:59'),
(231, 1, 'sitema compras', 'https://qa.seduc.cl/jorquera/sistema_compras/explicacion.php', 'sistema_universal.jpg', '', '2026-03-26', '19:14:19'),
(232, 1, 'duoc VIVO', 'https://experienciavivo.duoc.cl/alumnos/?_gl=1*li8iqv*_gcl_au*MTA3NzU3NzkxMS4xNzc0Mjk4OTAx*_ga*MTY2ODM2OTE1MC4xNzcyNDYyMTg3*_ga_JMVN3R1WDD*czE3NzQ1Njc5NTYkbzQ2JGcxJHQxNzc0NTY4MTkzJGozNyRsMCRoMA..', 'duoc-VIVO-20260326203856.png', '', '2026-03-26', '20:37:20'),
(233, 1, 'colegio san pablo', 'https://qa.seduc.cl/jorquera/colegiosanpablo/', 'colegio-san-pablo-20260327090208.png', '', '2026-03-27', '09:01:32'),
(234, 1, 'chat gpt', 'https://chatgpt.com/', 'chat-gpt-20260327111324.png', '', '2026-03-27', '11:12:22'),
(235, 1, 'Banco Itau', 'https://banco.itau.cl/wps/portal/newolb/web/login/!ut/p/z1/04_Sj9CPykssy0xPLMnMz0vMAfIjo8ziLf1dzIw8DYz8DLxcjA3MTIJNA52MQwwMjMz1wwkpiAJKG-AAjgZA_VFgJXAT_D28DQ0CvY0CLT0NAgP8jQygCvCYUZAbYZDpqKgIAFKI8TE!/dz/d5/L2dBISEvZ0FBIS9nQSEh/?action=logout', 'Banco-Itau-20260329201834.jpg', '', '2026-03-29', '20:17:31'),
(237, 1, 'BIK', 'http://seduc.buk.cl/users/login', 'BIK-20260407095549.png', '', '2026-04-07', '09:54:55'),
(238, 1, 'webnia', 'https://www.webnia.cl/', 'webnia-20260407104303.png', '', '2026-04-07', '10:31:18'),
(239, 1, 'sistema finanzas graduaciion', 'https://qa.seduc.cl/jorquera/sistema_finanzas_graduacion/login.php', 'sistema-finanzas-graduaciion-20260408145119.jpg', '', '2026-04-08', '14:35:19'),
(240, 1, 'Metro Gas', 'https://sucursalvirtual.metrogas.cl/cuentas/resumen', 'Metro-Gas-20260412190421.png', '', '2026-04-12', '19:04:21'),
(242, 1, 'Notebook', 'https://notebooklm.google.com/?icid=home_maincta&_gl=1*1s8ntgz*_ga*OTQyMzYwNDY0LjE3NzYxMjIwNjM.*_ga_W0LDH41ZCB*czE3NzYxMjIwNjMkbzEkZzEkdDE3NzYxMjIxMTMkajEwJGwwJGgw', 'Notebook-20260510191040.jpg', '', '2026-04-13', '19:19:40'),
(243, 1, 'COLEGIÓ SAN PABLO ORIGINAL', 'https://sanpablo.edu.uy/', '', '', '2026-04-14', '18:17:52'),
(244, 1, 'sistema base', 'https://qa.seduc.cl/jorquera/sbase', '', '', '2026-04-22', '09:00:17'),
(245, 1, 'claude', 'https://claude.ai/new', 'claude-20260425192602.png', '', '2026-04-25', '19:25:14'),
(246, 1, 'Sistema Mariachi', 'https://qa.seduc.cl/jorquera/sistema_mariachi/', '', '', '2026-04-28', '17:52:14'),
(247, 1, 'PAGO TAG', 'https://botonpago.unired.cl/Pago/IniciarFlujoOnline?u=8O5NVE5BEq0YCkr2hmB9Lm6DtZnzm8lPKQrdqVKbAbU%3D', 'PAGO-TAG-20260429101037.jpg', '', '2026-04-29', '10:10:37'),
(248, 1, 'google colab', 'https://colab.research.google.com/drive/1oGA4f0zR_7L6fgK_Vh8BKWASZcLY1g7n#scrollTo=1btKzFp_kB0-', '', '', '2026-04-29', '20:07:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedores_layout`
--

CREATE TABLE `contenedores_layout` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text DEFAULT NULL,
  `posicion_x` int(11) DEFAULT 0,
  `posicion_y` int(11) DEFAULT 0,
  `ancho` int(11) DEFAULT 4,
  `alto` int(11) DEFAULT 1,
  `color_fondo` varchar(20) DEFAULT '#ffffff',
  `icono` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icono_fa` varchar(100) DEFAULT '',
  `url` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contenedores_layout`
--

INSERT INTO `contenedores_layout` (`id`, `id_usuario`, `titulo`, `contenido`, `posicion_x`, `posicion_y`, `ancho`, `alto`, `color_fondo`, `icono`, `orden`, `fecha_creacion`, `fecha_actualizacion`, `icono_fa`, `url`) VALUES
(1, 1, 'Gmail', 'Accede a tu correo institucional.', 0, 0, 4, 1, '#fce8e6', 'bi-envelope-fill', 1, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(2, 1, 'Estudios', 'Resumen académico, horarios y ramos.', 0, 1, 4, 1, '#e8f5e9', 'bi-book-fill', 2, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(3, 1, 'Bancos', 'Revisa tus pagos, transferencias y cuentas.', 0, 2, 4, 1, '#e3f2fd', 'bi-bank', 3, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(4, 1, 'Sistemas Internos', 'Acceso a los sistemas internos institucionales.', 0, 3, 4, 1, '#fff3e0', 'bi-hdd-network', 4, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(5, 1, 'Portafolio', 'Gestión de portafolios académicos y proyectos.', 0, 4, 4, 1, '#f3e5f5', 'bi-briefcase-fill', 5, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(6, 1, 'Calendario', 'Agenda de eventos y actividades.', 4, 0, 4, 1, '#ede7f6', 'bi-calendar-event', 6, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(7, 1, 'Tareas Pendientes', 'Tareas, trabajos y entregas programadas.', 4, 1, 4, 1, '#e1f5fe', 'bi-list-check', 7, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(8, 1, 'Sitema Ticket', 'Notas obtenidas por asignatura.', 4, 2, 4, 1, '#fffde7', 'bi-star-fill', 8, '2025-07-23 11:56:18', '2025-07-23 15:20:18', '', 'https://acceso.seduc.cl/'),
(9, 1, 'Biblioteca Virtual', 'Acceso a material de estudio digital.', 4, 3, 4, 1, '#f9fbe7', 'bi-journal-bookmark-fill', 9, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(10, 1, 'Ayuda & Soporte', 'Centro de ayuda y asistencia técnica.', 4, 4, 4, 1, '#fbe9e7', 'bi-question-circle-fill', 10, '2025-07-23 11:56:18', '2025-07-23 11:56:18', '', ''),
(11, 1, 'Google', NULL, 0, 0, 4, 1, '#ffffff', NULL, 1, '2025-07-23 12:22:35', '2025-07-23 12:22:35', 'fab fa-google fa-2x', ''),
(13, 1, 'Drive', NULL, 0, 0, 4, 1, '#ffffff', NULL, 3, '2025-07-23 12:22:35', '2025-07-23 12:22:35', 'fab fa-google-drive fa-2x', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios`
--

CREATE TABLE `convenios` (
  `id_convenio` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `destacado` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `convenios`
--

INSERT INTO `convenios` (`id_convenio`, `id_tipo`, `empresa`, `descripcion`, `descuento`, `imagen`, `url`, `fecha_inicio`, `fecha_termino`, `activo`, `destacado`, `fecha_creacion`) VALUES
(1, 1, 'Banco de Chile', 'Cuenta vista sin costo y créditos con tasa preferencial para colaboradores SEDUC', 'Tasa preferencial', 'banco_chile.png', 'https://www.bancochile.cl', '2026-01-01', '2026-12-31', 1, 1, '2026-05-10 19:55:09'),
(2, 1, 'Scotiabank', 'Crédito de consumo con condiciones especiales y tarjeta sin costo de mantención', 'Sin costo mantención', 'scotiabank.png', 'https://www.scotiabank.cl', '2026-01-01', '2026-12-31', 1, 1, '2026-05-10 19:55:09'),
(3, 1, 'Itaú', 'Cuenta corriente preferencial y acceso a productos financieros exclusivos', 'Cuenta preferencial', 'itau.png', 'https://www.itau.cl', '2026-01-01', '2026-12-31', 1, 0, '2026-05-10 19:55:09'),
(4, 3, 'NotebookMania', 'Descuento en equipos computacionales, accesorios y periféricos', '15% dcto', 'notebookmania.png', 'https://www.notebookmania.cl', '2026-01-01', '2026-12-31', 1, 1, '2026-05-10 19:55:09'),
(5, 4, 'Trogas', 'Precio especial en gas licuado para el hogar con despacho a domicilio', 'Precio convenio', 'trogas_1778459106.png', 'https://www.trogas.cl', '2026-01-01', '2026-12-31', 1, 0, '2026-05-10 19:55:09'),
(6, 2, 'Clínica BUPA', 'Atención médica con descuento en consultas y exámenes', '20% dcto', 'cl__nica_bupa_1778459067.png', 'https://www.bupa.cl', '2026-01-01', '2026-12-31', 1, 0, '2026-05-10 19:55:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversacion`
--

CREATE TABLE `conversacion` (
  `id_conversacion` int(11) NOT NULL,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversaciones`
--

CREATE TABLE `conversaciones` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `contenido` mediumtext NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo` enum('user','tech') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_codigos_qr`
--

CREATE TABLE `curso_codigos_qr` (
  `id_qr` int(11) NOT NULL,
  `nombre_taller` varchar(255) NOT NULL,
  `fecha_taller` date NOT NULL,
  `url_formulario` text NOT NULL,
  `qr_path` varchar(255) NOT NULL,
  `generado_por` int(11) NOT NULL,
  `fecha_generacion` timestamp NULL DEFAULT current_timestamp(),
  `eliminado` enum('si','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_codigos_qr`
--

INSERT INTO `curso_codigos_qr` (`id_qr`, `nombre_taller`, `fecha_taller`, `url_formulario`, `qr_path`, `generado_por`, `fecha_generacion`, `eliminado`) VALUES
(3, 'Calculo', '2025-03-20', 'https://docs.google.com/forms/d/11zDFj9v5xd7MSGerWog5Af8GT5RqRg9fVFeIwQCx9tg/edit', 'codigosQR\\asistenciaCursos', 43, '2025-03-12 18:33:50', 'si'),
(4, 'Ingles Avanzado', '2025-03-20', 'https://docs.google.com/forms/d/11zDFj9v5xd7MSGerWog5Af8GT5RqRg9fVFeIwQCx9tg/edit', 'codigosQR\\asistenciaCursos', 43, '2025-03-12 18:33:50', 'si'),
(5, 'ewrwer', '2025-03-13', 'https://docs.google.com/forms/d/11zDFj9v5xd7MSGerWog5Af8GT5RqRg9fVFeIwQCx9tg/edit', '', 8, '2025-03-20 15:38:56', 'si'),
(6, 'qweqwe', '2025-03-22', 'https://docs.google.com/forms/d/11zDFj9v5xd7MSGerWog5Af8GT5RqRg9fVFeIwQCx9tg/edit', '', 8, '2025-03-20 15:41:13', 'si'),
(7, 'qweqwe', '2025-03-15', 'qweqweqw', '', 8, '2025-03-20 17:34:41', 'si'),
(8, 'Angeles negros', '2025-03-29', 'https://docs.google.com/forms/d/e/1FAIpQLSftL85lWkXkVG8s6zxRkGiraGusOP0wDuMXkg3CS-1Nzgsvvg/viewform?usp=preview', '', 8, '2025-03-20 17:35:31', 'si'),
(9, 'LUIS Miguel', '2024-12-31', 'https://docs.google.com/forms/d/e/1FAIpQLSftL85lWkXkVG8s6zxRkGiraGusOP0wDuMXkg3CS-1Nzgsvvg/viewform?usp=preview', '../../../codigosQR/asistenciaCursos/Curso_9.png', 8, '2025-03-20 17:48:50', 'si'),
(10, 'LUIS Miguel', '2025-03-03', 'https://docs.google.com/forms/d/e/1FAIpQLSftL85lWkXkVG8s6zxRkGiraGusOP0wDuMXkg3CS-1Nzgsvvg/viewform?usp=preview', '../../../codigosQR/asistenciaCursos/Curso_10.png', 42, '2025-03-20 21:14:53', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncias_acoso`
--

CREATE TABLE `denuncias_acoso` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fecha_incidente` date NOT NULL,
  `involucrado` varchar(255) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `anonima` tinyint(1) DEFAULT 0,
  `contactar` tinyint(1) DEFAULT 0,
  `confidencial` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_colegio` int(11) NOT NULL,
  `id_usuario_asignado` int(11) DEFAULT NULL,
  `nombre_equipo` varchar(255) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `producto` varchar(255) DEFAULT NULL,
  `numero_serie` varchar(255) DEFAULT NULL,
  `tipo_pc` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `id_usuario`, `id_colegio`, `id_usuario_asignado`, `nombre_equipo`, `fabricante`, `producto`, `numero_serie`, `tipo_pc`, `qr_code`, `id_estado`) VALUES
(54, 1, 15, 0, 'AESPINOSA-PC.txt', 'MSI', 'MS-7A15', 'Default string', 'Desktop', '../../codigosQR/computadores/54Sin_asignar.png', 1),
(55, 3, 15, NULL, 'AFUENTES', 'Dell Inc.', 'Inspiron 3501', 'F7JLPH3', 'Notebook', '../../codigosQR/computadores/55Sin_asignar.png', 1),
(56, 2, 15, NULL, 'FCHAVEZ', 'HP', 'HP Pavilion Laptop 15-cs1xxx', '5CD9215BTT', 'Notebook', '../../codigosQR/computadores/56_2.png', 1),
(57, 39, 15, NULL, 'FGOMEZ', 'Dell Inc.', 'Inspiron 15 3511', '231M7K3', 'Notebook', '../../codigosQR/computadores/57_2462.png', 1),
(58, 12, 15, NULL, 'FVALENZUELA-NTB.txt', 'HP', 'HP Laptop 15-ef1xxx', '5CD119FKWG', 'Notebook', '../../codigosQR/computadores/58Sin_asignar.png', 1),
(59, 9, 15, 0, 'GMUNOZ', 'HP', 'HP Laptop 14-cf2xxx', '5CG1113SW0', 'Notebook', '../../codigosQR/computadores/59Sin_asignar.png', 1),
(60, 4, 15, NULL, 'RLEON', 'Dell Inc.', 'Inspiron 3501', 'J6NLPH3', 'Notebook', '../../codigosQR/computadores/60_4.png', 1),
(61, 5, 15, NULL, 'VPEREZ', 'Dell Inc.', 'Inspiron 3501', '19VMPH3', 'Notebook', '../../codigosQR/computadores/61_5.png', 1),
(62, 8, 15, NULL, 'CJORQUERA', 'Dell Inc.', 'Inspiron 3505', 'FQQ6J93', 'Notebook', '../../codigosQR/computadores/62_8.png', 1),
(63, 36, 15, NULL, 'JFERNANDEZ', 'HP', 'Victus by HP Gaming Laptop 15-fa1', '5CD41039D2', 'Notebook', '../../codigosQR/computadores/63_36.png', 1),
(64, 6, 15, NULL, 'RAMON.txt', 'HP', 'Victus by HP Laptop 16-d0xxx', '5CD251BFJD', 'Notebook', '../../codigosQR/computadores/64_6.png', 1),
(65, 7, 15, NULL, 'MGUTIERREZ', 'HP', 'HP Pavilion Laptop 15-eh0xxx', '5CD21114W0', 'Notebook', '../../codigosQR/computadores/65Sin_asignar.png', 1),
(66, 16, 15, NULL, 'GFRIEDL', 'HP', 'HP Laptop 15-da1xxx', 'CND02658LV', 'Notebook', '../../codigosQR/computadores/66_16.png', 1),
(67, 26, 15, NULL, 'JMACKENNA', 'HP', 'HP Laptop 15-dy5xxx', '5CD248DRVZ', 'Notebook', '../../codigosQR/computadores/67_26.png', 1),
(68, 40, 15, NULL, 'JPRIETO.txt', 'HP', 'HP Laptop 15-dy5xxx', '5CD338F0B5', 'Notebook', '../../codigosQR/computadores/68_2463.png', 1),
(69, 17, 15, NULL, 'CNIETO', 'LENOVO', '82FG', 'PF3DBNE4', 'Notebook', '../../codigosQR/computadores/69_17.png', 1),
(70, 25, 15, NULL, 'NOTEBOOK.txt', 'LENOVO', '82XF', 'MP2MD192', 'Notebook', '../../codigosQR/computadores/70_25.png', 1),
(71, 23, 15, NULL, 'COSTORNOL', 'LENOVO', '82H7', 'PF3QKAJ6', 'Notebook', '../../codigosQR/computadores/71_23.png', 1),
(72, 21, 15, NULL, 'CBARROS', 'LENOVO', '82A3', 'LT10AN81', 'Notebook', '../../codigosQR/computadores/72_21.png', 1),
(73, 20, 15, NULL, 'MIBANEZ', 'HP', 'HP Pavilion Laptop 15-cs1xxx', '5CD9215BM1', 'Notebook', '../../codigosQR/computadores/73_20.png', 1),
(74, 41, 0, NULL, 'TERRAZURIZ', 'LENOVO', '82H7', 'PF3CY56W', 'Notebook', '../../codigosQR/computadores/74Sin_asignar.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_compra`
--

CREATE TABLE `equipos_compra` (
  `id_equipo` int(11) NOT NULL,
  `valor_equipo` int(10) DEFAULT NULL,
  `proveedor` varchar(255) DEFAULT NULL,
  `numero_factura` varchar(255) DEFAULT NULL,
  `fecha_compra` date DEFAULT '0000-00-00',
  `observacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos_compra`
--

INSERT INTO `equipos_compra` (`id_equipo`, `valor_equipo`, `proveedor`, `numero_factura`, `fecha_compra`, `observacion`) VALUES
(54, 0, 'falabella', '', '0000-00-00', ''),
(55, 0, '', '', '0000-00-00', ''),
(56, 0, '', '', '0000-00-00', ''),
(57, 0, '', '', '0000-00-00', ''),
(58, 0, '', '', '0000-00-00', ''),
(59, 0, '', '', '0000-00-00', ''),
(60, 0, '', '', '0000-00-00', ''),
(61, 0, '', '', '0000-00-00', ''),
(62, 0, '', '', '0000-00-00', ''),
(63, 0, '', '', '0000-00-00', ''),
(64, 0, '', '', '0000-00-00', ''),
(65, 0, '', '', '0000-00-00', ''),
(66, 0, '', '', '0000-00-00', ''),
(67, 0, '', '', '0000-00-00', ''),
(68, 0, '', '', '0000-00-00', ''),
(69, 0, '', '', '0000-00-00', ''),
(70, 0, '', '', '0000-00-00', ''),
(71, 0, '', '', '0000-00-00', ''),
(72, 0, '', '', '0000-00-00', ''),
(73, 0, '', '', '0000-00-00', ''),
(74, 0, '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_almacenamiento`
--

CREATE TABLE `equipo_almacenamiento` (
  `id_equipo` int(11) NOT NULL,
  `equipo_modelo` varchar(100) DEFAULT NULL,
  `equipo_capacidad` varchar(50) DEFAULT NULL,
  `equipo_tamano` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_almacenamiento`
--

INSERT INTO `equipo_almacenamiento` (`id_equipo`, `equipo_modelo`, `equipo_capacidad`, `equipo_tamano`) VALUES
(54, 'Crucial_CT275MX300SSD1', '256.2', 'Fixed, SSD'),
(55, 'PM991a NVMe Samsung 256GB', '2385', 'Fixed'),
(56, 'KBG30ZMV256G TOSHIBA', '238.5', 'Fixed, SSD'),
(57, 'KBG40ZNS256G NVMe KIOXIA 256GB', '238.5', 'Fixed'),
(58, 'SK hynix BC511 HFM256GDJTNI-82A0A', '238.5', 'Fixed, SSD'),
(59, 'Optane+238GBSSD', '238.5', 'Fixed'),
(60, 'PM991a NVMe Samsung 256GB', '238.5', 'Fixed'),
(61, 'PM991a NVMe Samsung 256GB', '238.5', 'Fixed'),
(62, 'WDC  WDS500G2B0A-00SM50 (Modelo)', '465.8', 'Fixed, SSD'),
(63, 'WD PC SN740 SDDPNQD-512G-2006', '476.9', 'Fixed, SSD'),
(64, 'WD PC SN810 SDCPNRY-512G-1006', '476.9', 'Fixed, SSD'),
(65, 'SAMSUNG MZVLQ512HBLU-00BH1', '476.9', 'Fixed, SSD'),
(66, 'WDC PC SN520 SDAPNUW-256G-1006', '238.5', 'Fixed, SSD'),
(67, 'KBG50ZNV512G KIOXIA', '476.9', 'Fixed, SSD'),
(68, 'WD PC SN740 SDDPNQD-512G-1006', '476.9', 'Fixed, SSD'),
(69, 'SAMSUNG MZALQ512HALU-000L2', '476.9', 'Fixed'),
(70, 'WD PC SN740 SDDPMQD-512G-1101', '476.9', 'Fixed, SSD'),
(71, 'SAMSUNG MZALQ512HBLU-00BL2', '476.9', 'Fixed'),
(72, 'SKHynix_HFS512GD9TNI-L2A0B', '476.9', 'Fixed, SSD'),
(73, 'KBG30ZMV256G TOSHIBA', '238.5', 'Fixed, SSD'),
(74, 'SAMSUNG MZALQ512HBLU-00BL2', '476.9', 'Fixed');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_fotos`
--

CREATE TABLE `equipo_fotos` (
  `id_foto` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `ruta_foto` varchar(255) NOT NULL,
  `tipo_foto` enum('normal','otro') NOT NULL DEFAULT 'normal',
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `orden_foto` int(11) NOT NULL DEFAULT 1,
  `fecha_subida` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo_fotos`
--

INSERT INTO `equipo_fotos` (`id_foto`, `id_equipo`, `ruta_foto`, `tipo_foto`, `principal`, `orden_foto`, `fecha_subida`) VALUES
(5, 54, '/uploads/equipos/54/foto_69b58cbd80fa64.74663127.png', 'normal', 1, 1, '2026-03-14 13:28:45'),
(6, 54, '/uploads/equipos/54/foto_69b58cd6ae3ba7.53442777.png', 'normal', 1, 1, '2026-03-14 13:29:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_memoria`
--

CREATE TABLE `equipo_memoria` (
  `id_memoria` int(11) NOT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `designacion_memoria` varchar(255) DEFAULT NULL,
  `formato_memoria` varchar(255) DEFAULT NULL,
  `tipo_memoria` varchar(255) DEFAULT NULL,
  `tamano_memoria` int(11) DEFAULT NULL,
  `frecuencia_memoria` int(11) DEFAULT NULL,
  `marca_memoria` varchar(255) DEFAULT NULL,
  `orden_memoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_memoria`
--

INSERT INTO `equipo_memoria` (`id_memoria`, `id_equipo`, `designacion_memoria`, `formato_memoria`, `tipo_memoria`, `tamano_memoria`, `frecuencia_memoria`, `marca_memoria`, `orden_memoria`) VALUES
(295, 55, 'DIMM A', 'SODIMM', 'DDR4', 8, 2667, 'Samsung', 1),
(296, 55, 'DIMM B', '', '', 0, 0, '', 2),
(297, 56, 'Bottom-slot 1(left)', 'SODIMM', 'DDR4', 8, 2400, 'Samsung', 1),
(298, 56, 'Bottom-slot 2(right)', 'SODIMM', 'DDR', 0, 0, '', 2),
(299, 57, 'DIMM A', 'SODIMM', 'DDR4', 8, 2667, 'Samsung', 1),
(300, 57, 'DIMM B', '', '', 0, 0, '', 2),
(301, 58, 'Bottom - Slot 1 (left)', 'SODIMM', '', 0, 0, '', 1),
(302, 58, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 8, 2667, 'SK Hynix', 2),
(305, 60, 'DIMM A', 'SODIMM', 'DDR4', 8, 2667, 'Samsung', 1),
(306, 60, 'DIMM B', '', '', 0, 0, '', 2),
(307, 61, 'DIMM A', 'SODIMM', 'DDR4', 8, 2667, 'Samsung', 1),
(308, 61, 'DIMM B', '', '', 0, 0, '', 2),
(309, 62, 'DIMM 0', 'SODIMM', 'DDR4', 8, 2400, 'Hynix', 1),
(310, 62, 'DIMM 0', 'SODIMM', 'DDR4', 8, 2400, 'Samsung', 2),
(311, 63, 'Bottom - Slot 1 (left)', 'SODIMM', 'DDR4', 8, 3200, 'Samsung', 1),
(312, 63, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 8, 3200, 'Samsung 2', 2),
(313, 64, 'Bottom - Slot 1 (left)', 'SODIMM', 'DDR4', 8, 3200, 'Micron Technology', 1),
(314, 64, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 8, 3200, 'Micron Technology', 2),
(315, 65, 'Bottom - Slot 1 (left) MG', 'SODIMM', 'DDR4', 8, 3200, 'Samsung', 1),
(316, 65, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 8, 3200, 'Samsung', 2),
(317, 66, 'Bottom-Slot 1(left)', 'SODIMM', 'DDR4', 8, 2133, 'Ramaxel Technology', 1),
(318, 66, 'Bottom-Slot 2(right)', 'SODIMM', 'DDR', 0, 0, '', 2),
(319, 67, 'Bottom - Slot 1 (left)', 'SODIMM', 'DDR4', 4, 3200, 'SK Hynix', 1),
(320, 67, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 4, 3200, 'SK Hynix', 2),
(321, 68, 'Bottom - Slot 1 (left)', 'SODIMM', 'DDR4', 4, 3200, 'Micron Technology', 1),
(322, 68, 'Bottom - Slot 2 (right)', 'SODIMM', 'DDR4', 4, 3200, 'Micron Technology', 2),
(323, 69, 'Controller0-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'Samsung', 1),
(324, 69, 'Controller1-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'Samsung', 2),
(325, 70, 'Controller0-ChannelA', 'DIMM', 'LPDDR4', 8, 5200, 'Samsung', 1),
(326, 70, 'Controller1-ChannelA', 'DIMM', 'LPDDR4', 8, 5200, 'Samsung', 2),
(327, 71, 'Controller0-ChannelA-DIMM0', 'SODIMM', 'DDR4', 4, 3200, 'SK Hynix', 1),
(328, 71, 'Controller1-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'Samsung', 2),
(329, 72, 'Controller0-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'SK Hynix', 1),
(330, 72, 'Controller1-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'SK Hynix', 2),
(331, 73, 'Bottom-slot 1(left)', 'SODIMM', 'DDR4', 8, 2400, 'Samsung', 1),
(332, 73, 'Bottom-slot 2(right)', 'SODIMM', 'DDR', 0, 0, '', 2),
(333, 74, 'Controller0-ChannelA-DIMM0', 'SODIMM', 'DDR4', 4, 3200, 'Micron Technology', 1),
(334, 74, 'Controller1-ChannelA', 'Row of chips', 'DDR4', 4, 3200, 'Samsung', 2),
(343, 59, 'Bottom-slot 1(left)', 'SODIMM', 'DDR4', 4, 2667, 'SK Hynix', 1),
(344, 59, 'Bottom-slot 2(right)', 'SODIMM', 'DDR', 0, 0, '', 2),
(381, 54, 'ChannelA-DIMM0', '', '', 0, 0, '', 1),
(382, 54, 'ChannelA-DIMM1', '', '', 0, 0, '', 2),
(383, 54, 'ChannelB-DIMM0', 'DIMM', 'DDR4', 8, 2133, '859B', 3),
(384, 54, 'ChannelB-DIMM1', '', '', 0, 0, '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_monitor`
--

CREATE TABLE `equipo_monitor` (
  `id_monitor` int(11) NOT NULL,
  `id_equipo` int(11) DEFAULT NULL,
  `modelo_monitor` varchar(255) DEFAULT NULL,
  `codigo_monitor` varchar(255) DEFAULT NULL,
  `serie_monitor` varchar(11) DEFAULT NULL,
  `tamano_monitor` int(10) DEFAULT NULL,
  `resolucion_monitor` varchar(50) DEFAULT NULL,
  `orden_monitor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_monitor`
--

INSERT INTO `equipo_monitor` (`id_monitor`, `id_equipo`, `modelo_monitor`, `codigo_monitor`, `serie_monitor`, `tamano_monitor`, `resolucion_monitor`, `orden_monitor`) VALUES
(269, 55, '()', 'BOE0A23', '', 15, '1366 x 768', 1),
(270, 55, 'SMB2030N (Samsung)', 'SAM0634', 'H9LB201570', 20, '1600 x 900', 2),
(271, 56, '()', 'BOE07FF', '', 15, '1920 x 1080', 1),
(272, 56, 'LED MONITOR ()', 'SAC952D', '', 22, '1920 x 1080', 2),
(273, 57, '831W (AOC International)', 'AOC1831', '', 19, '1366 x 768', 1),
(274, 57, '()', 'BOE097D', '', 15, '1920 x 1080', 2),
(275, 58, '()', 'BOE0920', '', 15, '1366 x 768', 1),
(276, 58, 'E2042 (LG Electronics (GoldStar))', 'GSM4ED7', '206NDSK6U16', 20, '1600 x 900', 2),
(279, 60, '()', 'BOE0A23', '', 15, '1366 x 768', 1),
(280, 60, '', '', '', 0, '', 2),
(281, 61, '831W (AOC International)', 'AOC1831', '', 19, '1366 x 768', 1),
(282, 61, '()', 'BOE0A23', '', 15, '1366 x 768', 2),
(283, 62, '()   ****', 'BOE08CD', '3423424  **', 15, '1366 x 768', 1),
(284, 62, 'E2251 (LG Electronics (GoldStar))', 'GSM586D', '111LTSS3U07', 22, '1920 x 1080', 2),
(285, 63, 'HP', 'AUO2992', '', 15, '1920 x 1080', 1),
(286, 63, 'LG FHD (LG Electronics (GoldStar))', 'GSM5C66', '404TFGC0Y11', 24, '1920 x 1080', 2),
(287, 64, '()', 'CMN161A', '', 16, '1920 x 1080', 1),
(288, 64, 'S24F350 (Samsung)', 'SAM0D20', 'H4ZH800057', 23, '1920 x 1080', 2),
(289, 65, 'SA', 'AUO4799', 'C40H7K', 15, '1920 x 1080', 1),
(290, 65, 'HP 22w', 'HPN342E', 'CNC7440H7K', 22, '1920 x 1080', 2),
(291, 66, '()', 'CMN15DC', '', 15, '1366 x 768', 1),
(292, 66, '', '', '', 0, '', 2),
(293, 67, 'S22A33x (Samsung)', 'SAM7122', 'H4TTC00365', 22, '1920 x 1080', 1),
(294, 67, '()', 'AUO499F', '', 15, '1920 x 1080', 2),
(295, 68, '()', 'BOE0B14', '', 15, '1920 x 1080', 1),
(296, 68, 'S20B300 (Samsung)', 'SAM08A8', 'HTLC401303', 20, '1600 x 900', 2),
(297, 69, '()', 'BOE08E2', '', 15, '1920 x 1080', 1),
(298, 69, '', '', '', 0, '', 2),
(299, 70, '()', 'LEN9156', '', 16, '1920 x 1200', 1),
(300, 70, 'S22A33x (Samsung)', 'SAM7122', 'H4TTC00357', 22, '1920 x 1080', 2),
(301, 71, '()', 'BOE09AE', '', 14, '1920 x 1080', 1),
(302, 71, '', '', '', 0, '', 2),
(303, 72, '()', 'LEN889A', '', 14, '1920 x 1080', 1),
(304, 72, '', '', '', 0, '', 2),
(305, 73, '()', 'BOE07FF', '', 15, '1920 x 1080', 1),
(306, 73, '22B2WG5 (AOC International)', 'AOC2202', 'QNHM9HA0844', 22, '1920 x 1080', 2),
(307, 74, '()', 'BOE09AE', '', 14, '1920 x 1080', 1),
(308, 74, '', '', '', 0, '', 2),
(313, 59, '()', 'CMN1413', '', 14, '1366 x 768', 1),
(314, 59, '', '', '', 0, '', 2),
(333, 54, 'VA2248 SERIES (ViewSonic)', 'VSC0E28', 'SDD11492332', 22, '1920 x 1080', 1),
(334, 54, '', '', '', 0, '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_procesador`
--

CREATE TABLE `equipo_procesador` (
  `id_equipo` int(11) NOT NULL,
  `equipo_fabricante` varchar(100) DEFAULT NULL,
  `equipo_modelo` varchar(100) DEFAULT NULL,
  `equipo_velocidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_procesador`
--

INSERT INTO `equipo_procesador` (`id_equipo`, `equipo_fabricante`, `equipo_modelo`, `equipo_velocidad`) VALUES
(54, 'Intel(R) Corporation', 'Intel(R) Core(TM) i5-6400 CPU @ 2.70GHz', '2700.0'),
(55, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '3800.0'),
(56, 'Intel(R) Corporation', 'Intel(R) Core(TM) i5-8265U CPU @ 1.60GHz', '1485.0'),
(57, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '2400.0'),
(58, 'Advanced Micro Devices Inc.', 'AMD Ryzen 5 4500U with Radeon Graphics', '2375.0'),
(59, 'Intel(R) Corporation', 'Intel(R) Core(TM) i3-10110U CPU @ 2.10GHz', '1980.0'),
(60, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '3800.0'),
(61, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '3800.0'),
(62, 'Advanced Micro Devices Inc.  ****', 'AMD Ryzen 5 3450U with Radeon Vega Mobile Gfx (Procesador)', '2100.0'),
(63, 'Intel(R) Corporation', '12th Gen Intel(R) Core(TM) i5-12500H', '4158.0'),
(64, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i7-11800H @ 2.30GHz', '2178.0'),
(65, 'Advanced Micro Devices Inc.', 'AMD Ryzen 7 4700U with Radeon Graphics', '2000.0'),
(66, 'Intel(R) Corporation', 'Intel(R) Pentium(R) CPU 5405U @ 2.30GHz', '2178.0'),
(67, 'Intel(R) Corporation', '12th Gen Intel(R) Core(TM) i5-1235U', '3960.0'),
(68, 'Intel(R) Corporation', '12th Gen Intel(R) Core(TM) i5-1235U', '3960.0'),
(69, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '2400.0'),
(70, 'Intel(R) Corporation', '13th Gen Intel(R) Core(TM) i7-13620H', '4653.0'),
(71, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i3-1115G4 @ 3.00GHz', '3000.0'),
(72, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz', '2400.0'),
(73, 'Intel(R) Corporation', 'Intel(R) Core(TM) i5-8265U CPU @ 1.60GHz', '1485.0'),
(74, 'Intel(R) Corporation', '11th Gen Intel(R) Core(TM) i3-1115G4 @ 3.00GHz', '3000.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_software`
--

CREATE TABLE `equipo_software` (
  `id_equipo` int(11) NOT NULL,
  `windows` varchar(50) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `antivirus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_software`
--

INSERT INTO `equipo_software` (`id_equipo`, `windows`, `office`, `antivirus`) VALUES
(54, 'Microsoft Windows 10  Professional (x64), Version', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(55, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(56, 'Microsoft Windows 11  Home (x64), Version 24H2, Bu', '', ''),
(57, 'Microsoft Windows 11  Home Single Language (x64),', '', ''),
(58, 'Microsoft Windows 10  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(59, 'Microsoft Windows 10  Home Single Language (x64),', '', ''),
(60, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(61, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(62, 'Microsoft Windows 11  Pro for Workstations (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(63, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(64, 'Microsoft Windows 11  Pro for Workstations (x64), ', '', ''),
(65, 'Microsoft Windows 11  Home Single Language (x64),', '', ''),
(66, 'Microsoft Windows 10  Professional (x64), Version', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(67, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', ''),
(68, 'Microsoft Windows 11  Home Single Language (x64),', '', ''),
(69, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)'),
(70, 'Microsoft Windows 11  Home Single Language (x64), ', '', ''),
(71, 'Microsoft Windows 11  Home Single Language (x64), ', 'Microsoft Office Professional Plus 2016', ''),
(72, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', ''),
(73, 'Microsoft Windows 11  Home (x64), Version 23H2, Bu', 'Microsoft Office Professional Plus 2016', ''),
(74, 'Microsoft Windows 11  Home Single Language (x64),', 'Microsoft Office Professional Plus 2016', 'Xcitium (Client- Security)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_ticket`
--

CREATE TABLE `estados_ticket` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `color_degradado` varchar(100) DEFAULT NULL,
  `descripcion_estado` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `estados_ticket`
--

INSERT INTO `estados_ticket` (`id`, `nombre`, `orden`, `color`, `color_degradado`, `descripcion_estado`) VALUES
(1, 'Recibido', 1, '#E6E6FA', 'linear-gradient(135deg, #E6E6FA, #FFFFFF)', 'El ticket ha sido creado, pero aun no ha sido asignado a un tecnico para su atencion.\n'),
(2, 'Asignado', 2, '#FFF4C1', 'linear-gradient(135deg, #FFF4C1, #FFFFE0)', 'El ticket ya fue asignado a un tecnico y esta a la espera de ser atendido.\n'),
(3, 'En proceso', 3, '#FFE0E0', 'linear-gradient(135deg, #FFE0E0, #FFF0F0)', 'El tecnico esta trabajando activamente en la solucion del ticket.\n'),
(5, 'Terminado', 4, '#C8F7C5', 'linear-gradient(135deg, #D8F8D8, #F0FFF0)', 'El tecnico ha finalizado su trabajo. El ticket esta pendiente de revision o cierre.\n'),
(4, 'Borrador', 4, '#F3E5F5', 'linear-gradient(135deg, #F3E5F5, #FFFFFF)', 'El ticket ha sido creado pero aun no ha sido activado. Esta en etapa de preparacion y no sera visibl'),
(6, 'Cerrado', 6, '#E0E0E0', 'linear-gradient(135deg, #E0E0E0, #F7F7F7)', 'El ticket fue resuelto y cerrado definitivamente por el sistema o un administrador.\n'),
(7, 'Demorado', 7, '#FFD6A5', 'linear-gradient(135deg, #FFD6A5, #FFF0E0)', 'El ticket esta atrasado respecto a su fecha limite de resolucion. Se requiere atencion urgente.\n\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_calificacion_ticket`
--

CREATE TABLE `estado_calificacion_ticket` (
  `id` int(11) NOT NULL,
  `calificacion` varchar(100) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estado_calificacion_ticket`
--

INSERT INTO `estado_calificacion_ticket` (`id`, `calificacion`, `orden`) VALUES
(1, 'Satisfactorio', 1),
(2, 'Insatisfactorio', 2),
(3, 'Incompleto', 3),
(4, 'Requiere revisión', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_herramienta`
--

CREATE TABLE `estado_herramienta` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(60) NOT NULL,
  `color_badge` varchar(20) NOT NULL DEFAULT 'secondary'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_herramienta`
--

INSERT INTO `estado_herramienta` (`id_estado`, `nombre_estado`, `color_badge`) VALUES
(1, 'Disponible', 'success'),
(2, 'En bodega', 'secondary'),
(3, 'En reparacion', 'warning'),
(4, 'Baja', 'danger'),
(5, 'Prestada', 'info'),
(6, 'Extraviada', 'dark');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `hora_evento` time NOT NULL,
  `con_audio` tinyint(1) DEFAULT 0,
  `solo_presentacion` tinyint(1) DEFAULT 0,
  `musica_ambiental` tinyint(1) DEFAULT 0,
  `cantidad_personas` int(11) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `tipo_evento` varchar(50) NOT NULL DEFAULT 'reunion',
  `estado` varchar(30) NOT NULL DEFAULT 'programado',
  `color_evento` varchar(20) DEFAULT NULL,
  `observaciones_logisticas` text DEFAULT NULL,
  `correo_enviado` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT NULL,
  `responsable_id` int(11) NOT NULL,
  `eliminado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `hora_inicio`, `hora_fin`, `hora_evento`, `con_audio`, `solo_presentacion`, `musica_ambiental`, `cantidad_personas`, `ubicacion`, `tipo_evento`, `estado`, `color_evento`, `observaciones_logisticas`, `correo_enviado`, `creado_en`, `actualizado_en`, `responsable_id`, `eliminado`) VALUES
(12, 'Reunionwwww', 'Coordinacion mensual con todo el equipo.', '2025-08-01', '2025-08-01', '10:00:00', NULL, '10:00:00', 1, 0, 1, 15, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 1, 'sÃ'),
(13, 'Capacitacion interna', 'Formacion sobre ciberseguridad.', '2025-08-02', '2025-08-02', '15:30:00', NULL, '15:30:00', 1, 1, 0, 12, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 2, 'sÃ'),
(14, 'Charla externa', 'Charla con invitado internacional.', '2025-07-29', '2025-07-29', '11:00:00', NULL, '11:00:00', 1, 1, 1, 30, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 3, 'sÃ'),
(15, 'Cumpleanos del jefe', 'Celebracion informal.', '2025-08-04', '2025-08-04', '13:00:00', NULL, '13:00:00', 0, 0, 1, 20, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 4, 'sÃ'),
(16, 'Evaluacion de proyectos', 'Revision del estado de avance.', '2025-08-05', '2025-08-05', '09:00:00', NULL, '09:00:00', 1, 1, 1, 10, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 1, 'no'),
(17, 'Taller de innovacion', 'Ideas para nuevos procesos.', '2025-08-06', '2025-08-06', '14:00:00', NULL, '14:00:00', 1, 1, 1, 25, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 2, 'no'),
(18, 'Reunion Informatica', 'reuniÃ³n para ver avances en el departamento', '2025-08-07', '2025-08-07', '16:30:00', NULL, '16:30:00', 1, 1, 0, 8, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 3, 'no'),
(19, 'Prueba de sonido', 'Configuracion para evento grande.', '2025-08-08', '2025-08-08', '08:00:00', NULL, '08:00:00', 1, 0, 1, 5, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 4, 'sÃ'),
(20, 'Almuerzo Despedida', 'Despedida de Carola Barros', '2025-07-29', '2025-07-29', '13:32:00', NULL, '13:32:00', 0, 0, 0, 10, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 1, 'sÃ'),
(21, 'Actividad recreativa', 'Dinamica grupal para el equipo.', '2025-08-10', '2025-08-10', '17:00:00', NULL, '17:00:00', 0, 0, 1, 18, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 19:07:15', NULL, 2, 'no'),
(22, 'pppppppppppp', 'qwqwqw', '2025-08-12', '2025-08-12', '20:59:00', NULL, '20:59:00', 1, 1, 1, 22, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-28 20:56:06', NULL, 8, 'no'),
(23, 'guadalupe Jorquera', 'guadalupe Jorquera', '2025-07-29', '2025-07-29', '13:24:00', NULL, '13:24:00', 1, 1, 1, 22, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-29 15:23:25', NULL, 8, 'sÃ'),
(24, 'agusto', 'agusto', '2025-07-30', '2025-07-30', '15:26:00', NULL, '15:26:00', 0, 0, 0, 22, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-29 15:24:09', NULL, 8, 'no'),
(25, '34534534', '34535345', '2025-07-09', '2025-07-09', '14:31:00', NULL, '14:31:00', 1, 1, 1, 333, NULL, 'reunion', 'programado', NULL, NULL, 0, '2025-07-29 15:29:54', NULL, 8, 'sÃ'),
(26, 'EVENTO DE PRUEBA', 'qweqwe', '2026-03-16', '2026-03-16', '17:33:00', '18:37:00', '17:33:00', 1, 1, 1, 23, 'www', 'capacitacion', 'cancelado', '#059669', '323432', 1, '2026-03-15 16:33:43', '2026-03-15 22:05:19', 8, '0'),
(27, 'EVENTO DE PRUEBA', 'qweqwe', '2026-03-16', '2026-03-16', '17:33:00', '18:37:00', '17:33:00', 1, 1, 1, 23, 'www', 'capacitacion', 'programado', '#ebebeb', '323432', 1, '2026-03-15 16:33:50', '2026-03-15 13:39:35', 8, '0'),
(28, 'qweqwe', 'qweqwe', '2026-03-17', '2026-03-17', '13:55:00', '17:55:00', '13:55:00', 1, 1, 1, 0, '', 'reunion', 'cancelado', '#e7eb24', 'qweqwe', 1, '2026-03-15 16:55:47', '2026-03-15 22:17:33', 8, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_historial`
--

CREATE TABLE `eventos_historial` (
  `id` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos_historial`
--

INSERT INTO `eventos_historial` (`id`, `id_evento`, `accion`, `descripcion`, `id_usuario`, `creado_en`) VALUES
(1, 27, 'edicion', 'Se edito el evento \"EVENTO DE PRUEBA\".', 8, '2026-03-15 13:39:35'),
(2, 26, 'cancelacion', 'Se cancelo el evento \"EVENTO DE PRUEBA\".', 8, '2026-03-15 13:39:45'),
(3, 28, 'creacion', 'Se creo el evento \"qweqwe\".', 8, '2026-03-15 13:55:48'),
(4, 26, 'edicion', 'Se edito el evento \"EVENTO DE PRUEBA\".', 8, '2026-03-15 22:05:19'),
(5, 28, 'cancelacion', 'Se cancelo el evento \"qweqwe\".', 8, '2026-03-15 22:17:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `id_herramienta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `id_usuario_asignado` int(11) DEFAULT NULL,
  `nombre_herramienta` varchar(150) NOT NULL,
  `marca` varchar(120) DEFAULT '',
  `modelo` varchar(120) DEFAULT '',
  `numero_serie` varchar(120) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `qr_code` varchar(120) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `stock_minimo` int(11) NOT NULL DEFAULT 0,
  `ubicacion` varchar(150) DEFAULT '',
  `observaciones` text DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramientas`
--

INSERT INTO `herramientas` (`id_herramienta`, `id_usuario`, `id_colegio`, `id_usuario_asignado`, `nombre_herramienta`, `marca`, `modelo`, `numero_serie`, `categoria`, `qr_code`, `id_estado`, `cantidad`, `stock_minimo`, `ubicacion`, `observaciones`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 1, 0, 'Taladro Percutor', 'Bosch', 'GSB13RE', 'SERIE-1001', 'Electrica', 'QR-HERR-0001', 1, 2, 1, 'Bodega Mantención', 'Taladro utilizado para trabajos generales', '2026-03-16 09:07:00', '2026-03-16 09:25:27'),
(2, 1, 1, NULL, 'Martillo Carpintero', 'Stanley', 'STHT51346', 'SERIE-1002', 'Manual', 'QR-HERR-0002', 1, 5, 2, 'Bodega Mantención', 'Martillos para trabajos menores', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(3, 1, 1, 5, 'Escalera Aluminio 6 Peldaños', 'Werken', 'ALU6', 'SERIE-1003', 'Mantencion', 'QR-HERR-0003', 5, 1, 1, 'Sala de Mantención', 'Prestada al encargado de mantención', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(4, 1, 1, NULL, 'Multimetro Digital', 'Fluke', 'F115', 'SERIE-1004', 'Medicion', 'QR-HERR-0004', 1, 1, 0, 'Caja Herramientas Electricista', 'Equipo para medición eléctrica', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(5, 1, 1, NULL, 'Hidrolavadora', 'Karcher', 'K2', 'SERIE-1005', 'Limpieza', 'QR-HERR-0005', 2, 1, 0, 'Bodega Aseo', 'Usada para limpieza de patios', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(6, 1, 1, NULL, 'Cortadora de Pasto', 'Makita', 'PLM4120', 'SERIE-1006', 'Jardineria', 'QR-HERR-0006', 3, 1, 0, 'Bodega Jardinería', 'En reparación por falla en motor', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(7, 1, 1, NULL, 'Guantes de Seguridad', '3M', 'SAFE100', 'SERIE-1007', 'Seguridad', 'QR-HERR-0007', 1, 20, 5, 'Bodega Seguridad', 'Guantes para trabajos de mantención', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(8, 1, 1, NULL, 'Sierra Circular', 'DeWalt', 'DWE560', 'SERIE-1008', 'Electrica', 'QR-HERR-0008', 1, 1, 0, 'Bodega Mantención', 'Herramienta eléctrica para carpintería', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(9, 1, 1, NULL, 'Juego Llaves Inglesas', 'Truper', 'LLI-SET', 'SERIE-1009', 'Manual', 'QR-HERR-0009', 1, 3, 1, 'Caja Herramientas', 'Juego de llaves ajustables', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(10, 1, 1, NULL, 'Detector de Voltaje', 'Klein Tools', 'NCVT1', 'SERIE-1010', 'Medicion', 'QR-HERR-0010', 6, 1, 0, 'Bodega Mantención', 'Herramienta extraviada en inventario', '2026-03-16 09:07:00', '2026-03-16 09:07:00'),
(11, 1, 2, NULL, 'Taladro Inalambrico', 'Makita', 'DHP453', 'SERIE-2001', 'Electrica', 'QR-HERR-2001', 1, 2, 1, 'Bodega Mantención', 'Taladro para trabajos generales', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(12, 1, 2, NULL, 'Destornilladores Set', 'Stanley', 'STHT600', 'SERIE-2002', 'Manual', 'QR-HERR-2002', 1, 6, 2, 'Caja Herramientas', 'Set completo de destornilladores', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(13, 1, 2, 7, 'Escalera Fibra 8 Peldaños', 'Werken', 'FIB8', 'SERIE-2003', 'Mantencion', 'QR-HERR-2003', 5, 1, 1, 'Sala Mantención', 'Prestada al encargado de infraestructura', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(14, 1, 2, NULL, 'Tester Voltaje', 'Fluke', 'T5-600', 'SERIE-2004', 'Medicion', 'QR-HERR-2004', 1, 1, 0, 'Caja Electricista', 'Equipo para revisar corriente', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(15, 1, 2, NULL, 'Aspiradora Industrial', 'Karcher', 'WD3', 'SERIE-2005', 'Limpieza', 'QR-HERR-2005', 2, 1, 0, 'Bodega Aseo', 'Utilizada para limpieza profunda', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(16, 1, 2, NULL, 'Desbrozadora', 'Stihl', 'FS120', 'SERIE-2006', 'Jardineria', 'QR-HERR-2006', 1, 1, 0, 'Bodega Jardinería', 'Para mantención de áreas verdes', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(17, 1, 2, NULL, 'Casco Seguridad', '3M', 'H700', 'SERIE-2007', 'Seguridad', 'QR-HERR-2007', 1, 10, 3, 'Bodega Seguridad', 'Casco para trabajos de riesgo', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(18, 1, 2, NULL, 'Sierra Caladora', 'Bosch', 'GST650', 'SERIE-2008', 'Electrica', 'QR-HERR-2008', 3, 1, 0, 'Bodega Mantención', 'En reparación por vibración excesiva', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(19, 1, 2, NULL, 'Juego Llaves Allen', 'Truper', 'ALLEN-SET', 'SERIE-2009', 'Manual', 'QR-HERR-2009', 1, 4, 1, 'Caja Herramientas', 'Juego completo llaves allen', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(20, 1, 2, NULL, 'Nivel Laser', 'Bosch', 'GLL30', 'SERIE-2010', 'Medicion', 'QR-HERR-2010', 4, 1, 0, 'Bodega Mantención', 'Equipo dado de baja por daño interno', '2026-03-16 09:10:09', '2026-03-16 09:10:09'),
(21, 1, 3, NULL, 'Taladro Industrial', 'DeWalt', 'DWD024', 'SERIE-3001', 'Electrica', 'QR-HERR-3001', 1, 2, 1, 'Bodega Mantención', 'Taladro para trabajos estructurales', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(22, 1, 3, NULL, 'Juego Llaves Francesas', 'Truper', 'JF-SET', 'SERIE-3002', 'Manual', 'QR-HERR-3002', 1, 4, 1, 'Caja Herramientas', 'Juego completo de llaves ajustables', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(23, 1, 3, 8, 'Escalera Telescopica', 'Werken', 'TEL12', 'SERIE-3003', 'Mantencion', 'QR-HERR-3003', 5, 1, 1, 'Sala Mantención', 'Prestada al encargado de mantención', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(24, 1, 3, NULL, 'Multimetro Profesional', 'Fluke', 'F117', 'SERIE-3004', 'Medicion', 'QR-HERR-3004', 1, 1, 0, 'Caja Electricista', 'Equipo para mediciones eléctricas', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(25, 1, 3, NULL, 'Pulidora Angular', 'Bosch', 'GWS750', 'SERIE-3005', 'Electrica', 'QR-HERR-3005', 1, 1, 0, 'Bodega Mantención', 'Herramienta para corte y pulido', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(26, 1, 3, NULL, 'Sopladora Hojas', 'Stihl', 'BG50', 'SERIE-3006', 'Jardineria', 'QR-HERR-3006', 2, 1, 0, 'Bodega Jardinería', 'Guardada después de temporada', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(27, 1, 3, NULL, 'Lentes Seguridad', '3M', 'SAFE-VISION', 'SERIE-3007', 'Seguridad', 'QR-HERR-3007', 1, 15, 5, 'Bodega Seguridad', 'Protección ocular para trabajos', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(28, 1, 3, NULL, 'Hidrolavadora Industrial', 'Karcher', 'HD585', 'SERIE-3008', 'Limpieza', 'QR-HERR-3008', 3, 1, 0, 'Bodega Aseo', 'En reparación por falla de presión', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(29, 1, 3, NULL, 'Nivel Burbuja', 'Stanley', 'STHT42074', 'SERIE-3009', 'Medicion', 'QR-HERR-3009', 1, 3, 1, 'Caja Herramientas', 'Nivel para instalación y carpintería', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(30, 1, 3, NULL, 'Detector Metales Pared', 'Bosch', 'DMF10', 'SERIE-3010', 'Medicion', 'QR-HERR-3010', 6, 1, 0, 'Bodega Mantención', 'Equipo extraviado en inventario', '2026-03-16 09:10:57', '2026-03-16 09:10:57'),
(31, 1, 1, NULL, 'Llave Stilson', 'Truper', 'ST-24', 'SERIE-1011', 'Manual', 'QR-HERR-1011', 1, 3, 1, 'Caja Herramientas', 'Llaves para tuberías', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(32, 1, 1, NULL, 'Sierra Manual', 'Stanley', 'HAND-SA', 'SERIE-1012', 'Manual', 'QR-HERR-1012', 1, 2, 1, 'Caja Herramientas', 'Uso carpintería', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(33, 1, 1, NULL, 'Escoba Industrial', 'Virutex', 'IND200', 'SERIE-1013', 'Limpieza', 'QR-HERR-1013', 1, 10, 3, 'Bodega Aseo', 'Escobas patio', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(34, 1, 1, NULL, 'Pala Jardín', 'Truper', 'PJ-01', 'SERIE-1014', 'Jardineria', 'QR-HERR-1014', 1, 4, 1, 'Bodega Jardinería', 'Uso áreas verdes', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(35, 1, 1, NULL, 'Taladro Banco', 'Bosch', 'TB500', 'SERIE-1015', 'Electrica', 'QR-HERR-1015', 2, 1, 0, 'Bodega Mantención', 'Guardado en bodega', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(36, 1, 1, NULL, 'Compresor Aire', 'Makita', 'MAC2400', 'SERIE-1016', 'Electrica', 'QR-HERR-1016', 1, 1, 0, 'Bodega Mantención', 'Para inflado y limpieza', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(37, 1, 1, NULL, 'Metro Medición', 'Stanley', 'MT-8M', 'SERIE-1017', 'Medicion', 'QR-HERR-1017', 1, 6, 2, 'Caja Herramientas', 'Cintas métricas', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(38, 1, 1, NULL, 'Extintor', 'Ansul', 'EXT6', 'SERIE-1018', 'Seguridad', 'QR-HERR-1018', 1, 8, 2, 'Bodega Seguridad', 'Extintores portátiles', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(39, 1, 1, NULL, 'Carretilla', 'Truper', 'CAR-80', 'SERIE-1019', 'Mantencion', 'QR-HERR-1019', 1, 2, 1, 'Patio Mantención', 'Transporte materiales', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(40, 1, 1, NULL, 'Pulverizador', 'Solo', 'SPR-5', 'SERIE-1020', 'Jardineria', 'QR-HERR-1020', 1, 2, 1, 'Bodega Jardinería', 'Fumigación plantas', '2026-03-16 09:11:31', '2026-03-16 09:11:31'),
(41, 1, 2, NULL, 'Llave Francesa', 'Truper', 'LF10', 'SERIE-2011', 'Manual', 'QR-HERR-2011', 1, 4, 1, 'Caja Herramientas', 'Llaves ajustables', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(42, 1, 2, NULL, 'Sierra Circular Grande', 'DeWalt', 'DWE575', 'SERIE-2012', 'Electrica', 'QR-HERR-2012', 1, 1, 0, 'Bodega Mantención', 'Uso carpintería', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(43, 1, 2, NULL, 'Barredora Patio', 'Karcher', 'KM70', 'SERIE-2013', 'Limpieza', 'QR-HERR-2013', 2, 1, 0, 'Bodega Aseo', 'Guardada en bodega', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(44, 1, 2, NULL, 'Tijeras Podar', 'Gardena', 'TP100', 'SERIE-2014', 'Jardineria', 'QR-HERR-2014', 1, 3, 1, 'Bodega Jardinería', 'Podar árboles', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(45, 1, 2, NULL, 'Taladro Demoledor', 'Bosch', 'GSH5', 'SERIE-2015', 'Electrica', 'QR-HERR-2015', 3, 1, 0, 'Bodega Mantención', 'En reparación', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(46, 1, 2, NULL, 'Detector Voltaje', 'Fluke', 'DV200', 'SERIE-2016', 'Medicion', 'QR-HERR-2016', 1, 2, 0, 'Caja Electricista', 'Detección corriente', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(47, 1, 2, NULL, 'Guantes Seguridad', '3M', 'GS300', 'SERIE-2017', 'Seguridad', 'QR-HERR-2017', 1, 20, 5, 'Bodega Seguridad', 'Protección manos', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(48, 1, 2, NULL, 'Carro Limpieza', 'Rubbermaid', 'CL200', 'SERIE-2018', 'Limpieza', 'QR-HERR-2018', 1, 2, 1, 'Bodega Aseo', 'Carros aseo', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(49, 1, 2, NULL, 'Nivel Digital', 'Bosch', 'ND500', 'SERIE-2019', 'Medicion', 'QR-HERR-2019', 1, 1, 0, 'Caja Herramientas', 'Nivel precisión', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(50, 1, 2, NULL, 'Carretilla Jardín', 'Truper', 'CJ90', 'SERIE-2020', 'Jardineria', 'QR-HERR-2020', 1, 2, 1, 'Bodega Jardinería', 'Transporte tierra', '2026-03-16 09:11:39', '2026-03-16 09:11:39'),
(51, 1, 3, NULL, 'Taladro Atornillador', 'Makita', 'DF330', 'SERIE-3011', 'Electrica', 'QR-HERR-3011', 1, 2, 1, 'Bodega Mantención', 'Uso general', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(52, 1, 3, NULL, 'Martillo Goma', 'Stanley', 'MG300', 'SERIE-3012', 'Manual', 'QR-HERR-3012', 1, 3, 1, 'Caja Herramientas', 'Trabajos delicados', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(53, 1, 3, NULL, 'Escoba Patio', 'Virutex', 'EP200', 'SERIE-3013', 'Limpieza', 'QR-HERR-3013', 1, 8, 2, 'Bodega Aseo', 'Barrido patios', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(54, 1, 3, NULL, 'Rastrillo', 'Truper', 'RA10', 'SERIE-3014', 'Jardineria', 'QR-HERR-3014', 1, 4, 1, 'Bodega Jardinería', 'Limpieza hojas', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(55, 1, 3, NULL, 'Pulidora Metal', 'Bosch', 'PM900', 'SERIE-3015', 'Electrica', 'QR-HERR-3015', 1, 1, 0, 'Bodega Mantención', 'Pulido metal', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(56, 1, 3, NULL, 'Tester Corriente', 'Fluke', 'TC300', 'SERIE-3016', 'Medicion', 'QR-HERR-3016', 1, 1, 0, 'Caja Electricista', 'Pruebas eléctricas', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(57, 1, 3, NULL, 'Casco Seguridad', '3M', 'CS500', 'SERIE-3017', 'Seguridad', 'QR-HERR-3017', 1, 12, 4, 'Bodega Seguridad', 'Protección cabeza', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(58, 1, 3, NULL, 'Carro Transporte', 'Truper', 'CT200', 'SERIE-3018', 'Mantencion', 'QR-HERR-3018', 1, 1, 0, 'Patio Mantención', 'Mover materiales', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(59, 1, 3, NULL, 'Manguera Industrial', 'Karcher', 'MI30', 'SERIE-3019', 'Limpieza', 'QR-HERR-3019', 1, 3, 1, 'Bodega Aseo', 'Limpieza patios', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(60, 1, 3, NULL, 'Cortasetos', 'Stihl', 'CSH100', 'SERIE-3020', 'Jardineria', 'QR-HERR-3020', 1, 1, 0, 'Bodega Jardinería', 'Mantención jardines', '2026-03-16 09:11:50', '2026-03-16 09:11:50'),
(61, 42, 8, 45, 'Zipgrade', 'Zipgrade', 'Zipgrade', 'SIN', 'Otro', 'HER-SIN', 1, 1, 0, '', '', '2026-03-16 09:36:49', '2026-03-16 09:36:49'),
(62, 8, 15, 8, 'prueba', '', '', 'A13123', 'Electrica', 'HER-A13123', 1, 1, 0, '', '', '2026-03-16 09:37:19', '2026-03-16 09:37:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_compra`
--

CREATE TABLE `herramienta_compra` (
  `id_compra` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `valor_herramienta` decimal(12,2) NOT NULL DEFAULT 0.00,
  `proveedor` varchar(150) DEFAULT '',
  `numero_factura` varchar(120) DEFAULT '',
  `fecha_compra` date DEFAULT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta_compra`
--

INSERT INTO `herramienta_compra` (`id_compra`, `id_herramienta`, `valor_herramienta`, `proveedor`, `numero_factura`, `fecha_compra`, `observacion`) VALUES
(2, 1, 0.00, '', '', '0000-00-00', ''),
(3, 61, 0.00, '', '', '0000-00-00', ''),
(4, 62, 0.00, '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_detalle`
--

CREATE TABLE `herramienta_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `tipo_energia` varchar(60) DEFAULT '',
  `medida` varchar(80) DEFAULT '',
  `capacidad` varchar(80) DEFAULT '',
  `requiere_mantencion` tinyint(1) NOT NULL DEFAULT 0,
  `frecuencia_mantencion_dias` int(11) NOT NULL DEFAULT 0,
  `fecha_ultima_mantencion` date DEFAULT NULL,
  `fecha_proxima_mantencion` date DEFAULT NULL,
  `garantia_hasta` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta_detalle`
--

INSERT INTO `herramienta_detalle` (`id_detalle`, `id_herramienta`, `tipo_energia`, `medida`, `capacidad`, `requiere_mantencion`, `frecuencia_mantencion_dias`, `fecha_ultima_mantencion`, `fecha_proxima_mantencion`, `garantia_hasta`) VALUES
(2, 1, '', '', '', 0, 0, '0000-00-00', '0000-00-00', '0000-00-00'),
(3, 61, '', '', '', 0, 0, '0000-00-00', '0000-00-00', '0000-00-00'),
(4, 62, '', '', '', 0, 0, '0000-00-00', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_fotos`
--

CREATE TABLE `herramienta_fotos` (
  `id_foto` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `ruta_foto` varchar(255) NOT NULL,
  `principal` tinyint(1) NOT NULL DEFAULT 0,
  `orden_foto` int(11) NOT NULL DEFAULT 1,
  `fecha_subida` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta_fotos`
--

INSERT INTO `herramienta_fotos` (`id_foto`, `id_herramienta`, `ruta_foto`, `principal`, `orden_foto`, `fecha_subida`) VALUES
(1, 1, '/uploads/herramientas/1/foto_69b7f6d55e8379.09517284.jpg', 1, 1, '2026-03-16 09:25:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_historial`
--

CREATE TABLE `herramienta_historial` (
  `id_historial` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `accion` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta_historial`
--

INSERT INTO `herramienta_historial` (`id_historial`, `id_herramienta`, `accion`, `descripcion`, `id_usuario`, `fecha`) VALUES
(1, 1, 'actualizacion', 'Herramienta actualizada desde el modulo de inventario.', 8, '2026-03-16 09:25:27'),
(2, 1, 'actualizacion', 'Herramienta actualizada desde el modulo de inventario.', 8, '2026-03-16 09:25:57'),
(3, 61, 'creacion', 'Herramienta registrada en inventario.', 42, '2026-03-16 09:36:49'),
(4, 62, 'creacion', 'Herramienta registrada en inventario.', 8, '2026-03-16 09:37:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_mantenciones`
--

CREATE TABLE `herramienta_mantenciones` (
  `id_mantencion` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `fecha_mantencion` date DEFAULT NULL,
  `tipo_mantencion` varchar(120) DEFAULT '',
  `proveedor` varchar(150) DEFAULT '',
  `costo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `proxima_fecha` date DEFAULT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta_prestamos`
--

CREATE TABLE `herramienta_prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `responsable_entrega` varchar(150) DEFAULT '',
  `responsable_recibe` varchar(150) DEFAULT '',
  `fecha_salida` date DEFAULT NULL,
  `fecha_devolucion_prevista` date DEFAULT NULL,
  `fecha_devolucion_real` date DEFAULT NULL,
  `estado_prestamo` varchar(60) DEFAULT '',
  `observacion` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_pc`
--

CREATE TABLE `inventario_pc` (
  `id_pc` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `nombre_equipo` varchar(100) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `tipo_pc` varchar(30) DEFAULT NULL,
  `estado` enum('OK','REP','BAJA') DEFAULT 'OK',
  `fecha_compra` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_pc`
--

INSERT INTO `inventario_pc` (`id_pc`, `id_colegio`, `nombre_equipo`, `marca`, `modelo`, `tipo_pc`, `estado`, `fecha_compra`, `id_usuario`, `created_at`) VALUES
(1, 1, 'PC-ADM-01', 'HP', 'ProDesk 400', 'Desktop', 'OK', '2021-03-15', NULL, '2026-01-07 19:21:29'),
(2, 1, 'PC-ADM-02', 'Dell', 'Optiplex 3080', 'Desktop', 'OK', '2020-06-10', NULL, '2026-01-07 19:21:29'),
(3, 1, 'NOTE-DOC-01', 'Lenovo', 'ThinkPad L14', 'Notebook', 'REP', '2019-04-22', NULL, '2026-01-07 19:21:29'),
(4, 1, 'NOTE-DOC-02', 'HP', '240 G7', 'Notebook', 'BAJA', '2016-08-30', NULL, '2026-01-07 19:21:29'),
(5, 2, 'PC-LAB-01', 'HP', 'EliteDesk 800', 'Desktop', 'OK', '2022-01-12', NULL, '2026-01-07 19:21:29'),
(6, 2, 'PC-LAB-02', 'HP', 'EliteDesk 800', 'Desktop', 'OK', '2022-01-12', NULL, '2026-01-07 19:21:29'),
(7, 2, 'NOTE-ADM-01', 'Acer', 'Aspire 5', 'Notebook', 'REP', '2018-11-05', NULL, '2026-01-07 19:21:29'),
(8, 3, 'PC-LAB-01', 'Lenovo', 'ThinkCentre M720', 'Desktop', 'OK', '2021-07-18', NULL, '2026-01-07 19:21:29'),
(9, 3, 'PC-LAB-02', 'Lenovo', 'ThinkCentre M720', 'Desktop', 'OK', '2021-07-18', NULL, '2026-01-07 19:21:29'),
(10, 3, 'NOTE-DIR-01', 'Apple', 'MacBook Air', 'Notebook', 'OK', '2023-03-10', NULL, '2026-01-07 19:21:29'),
(11, 3, 'NOTE-DOC-01', 'HP', '240 G6', 'Notebook', 'REP', '2017-09-01', NULL, '2026-01-07 19:21:29'),
(12, 5, 'PC-ADM-01', 'HP', 'ProDesk 600', 'Desktop', 'OK', '2021-05-20', NULL, '2026-01-07 19:22:27'),
(13, 5, 'PC-ADM-02', 'HP', 'ProDesk 600', 'Desktop', 'OK', '2021-05-20', NULL, '2026-01-07 19:22:27'),
(14, 5, 'PC-LAB-01', 'Dell', 'Optiplex 3070', 'Desktop', 'OK', '2020-09-15', NULL, '2026-01-07 19:22:27'),
(15, 5, 'PC-LAB-02', 'Dell', 'Optiplex 3070', 'Desktop', 'REP', '2020-09-15', NULL, '2026-01-07 19:22:27'),
(16, 5, 'NOTE-DOC-01', 'Lenovo', 'ThinkPad E14', 'Notebook', 'OK', '2022-04-10', NULL, '2026-01-07 19:22:27'),
(17, 5, 'NOTE-DOC-02', 'HP', '240 G7', 'Notebook', 'BAJA', '2016-11-02', NULL, '2026-01-07 19:22:27'),
(18, 6, 'PC-ADM-01', 'Lenovo', 'ThinkCentre M710', 'Desktop', 'OK', '2019-08-12', NULL, '2026-01-07 19:22:27'),
(19, 6, 'PC-ADM-02', 'Lenovo', 'ThinkCentre M710', 'Desktop', 'REP', '2019-08-12', NULL, '2026-01-07 19:22:27'),
(20, 6, 'PC-LAB-01', 'HP', 'EliteDesk 800', 'Desktop', 'OK', '2021-03-25', NULL, '2026-01-07 19:22:27'),
(21, 6, 'PC-LAB-02', 'HP', 'EliteDesk 800', 'Desktop', 'OK', '2021-03-25', NULL, '2026-01-07 19:22:27'),
(22, 6, 'NOTE-DOC-01', 'Acer', 'Aspire 3', 'Notebook', 'OK', '2020-06-18', NULL, '2026-01-07 19:22:27'),
(23, 7, 'PC-ADM-01', 'HP', 'ProDesk 400', 'Desktop', 'OK', '2020-02-14', NULL, '2026-01-07 19:22:27'),
(24, 7, 'PC-ADM-02', 'HP', 'ProDesk 400', 'Desktop', 'OK', '2020-02-14', NULL, '2026-01-07 19:22:27'),
(25, 7, 'PC-LAB-01', 'Dell', 'Optiplex 3050', 'Desktop', 'OK', '2018-07-30', NULL, '2026-01-07 19:22:27'),
(26, 7, 'PC-LAB-02', 'Dell', 'Optiplex 3050', 'Desktop', 'REP', '2018-07-30', NULL, '2026-01-07 19:22:27'),
(27, 7, 'NOTE-DOC-01', 'Lenovo', 'ThinkPad L13', 'Notebook', 'OK', '2021-09-08', NULL, '2026-01-07 19:22:27'),
(28, 7, 'NOTE-DOC-02', 'HP', '240 G6', 'Notebook', 'BAJA', '2016-05-19', NULL, '2026-01-07 19:22:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_software_datos_sensibles`
--

CREATE TABLE `inventario_software_datos_sensibles` (
  `id_dato_sensible` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_software_datos_sensibles`
--

INSERT INTO `inventario_software_datos_sensibles` (`id_dato_sensible`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'RUT', 'Identificador tributario o de identidad', 1, '2026-04-06 11:29:16', '2026-04-06 11:29:16'),
(2, 'Nombre', 'Nombre completo de personas', 1, '2026-04-06 11:29:16', '2026-04-06 11:29:16'),
(3, 'Tarjeta de credito', 'Numeros o informacion de pago', 1, '2026-04-06 11:29:16', '2026-04-06 11:29:16'),
(4, 'Email', 'Correo electronico personal o institucional', 1, '2026-04-06 11:29:16', '2026-04-06 11:29:16'),
(5, 'Direccion', 'Direccion fisica o de despacho', 1, '2026-04-06 11:29:17', '2026-04-06 11:29:17'),
(7, 'Nombre completo', 'Nombre y apellidos de una persona', 1, '2026-04-07 14:10:29', '2026-04-07 14:10:29'),
(8, 'Telefono', 'Numero de contacto', 1, '2026-04-07 14:10:29', '2026-04-07 14:10:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_software_tipo_usuario`
--

CREATE TABLE `inventario_software_tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_software_tipo_usuario`
--

INSERT INTO `inventario_software_tipo_usuario` (`id_tipo_usuario`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Colaborador', NULL, 1, '2026-04-06 15:01:47', '2026-04-06 15:01:47'),
(2, 'Alumno', NULL, 1, '2026-04-06 15:01:47', '2026-04-06 15:01:47'),
(3, 'Proveedor', NULL, 1, '2026-04-06 15:01:47', '2026-04-06 15:01:47'),
(4, 'Otro', NULL, 1, '2026-04-06 15:01:47', '2026-04-06 15:01:47'),
(6, 'Apoderado', '', 1, '2026-04-07 18:43:14', '2026-04-07 18:43:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keep_notas`
--

CREATE TABLE `keep_notas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `contenido` text NOT NULL,
  `color` varchar(30) DEFAULT '#ffffff',
  `fijada` tinyint(1) DEFAULT 0,
  `recordatorio` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `keep_notas`
--

INSERT INTO `keep_notas` (`id`, `id_usuario`, `titulo`, `contenido`, `color`, `fijada`, `recordatorio`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(2, 1, 'prueba', 'recordar llamar a anaibal', '#f4ddff', 0, '2026-03-02 09:15:00', '2026-03-01 20:12:54', '2026-03-01 20:15:36'),
(3, 1, 'primer dia de clases', 'mañana es el primera dia de clases de lupe', '#d8f5d0', 1, '2026-03-02 20:15:00', '2026-03-01 20:14:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_eliminacion_tickets`
--

CREATE TABLE `log_eliminacion_tickets` (
  `id_log` int(10) UNSIGNED NOT NULL,
  `id_ticket` int(10) UNSIGNED NOT NULL,
  `justificacion_eliminacion` text NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo_eliminacion` enum('logica','fisica') DEFAULT 'logica',
  `estado_anterior` int(10) UNSIGNED DEFAULT NULL,
  `asunto_ticket` varchar(255) DEFAULT NULL,
  `observacion_admin` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_eliminacion_tickets`
--

INSERT INTO `log_eliminacion_tickets` (`id_log`, `id_ticket`, `justificacion_eliminacion`, `id_usuario`, `ip`, `fecha`, `hora`, `tipo_eliminacion`, `estado_anterior`, `asunto_ticket`, `observacion_admin`, `creado_en`) VALUES
(3, 519, 'eliminar ticket para ver si funciona el modulo', 8, '152.230.70.162', '2026-03-24', '20:27:18', 'logica', 2, NULL, NULL, '2026-03-24 23:27:18'),
(4, 520, 'por que es un ejemplo', 8, '186.67.42.46', '2026-03-30', '10:34:16', 'logica', 3, NULL, NULL, '2026-03-30 13:34:16'),
(5, 525, 'werwer', 8, '186.67.42.46', '2026-03-31', '12:21:14', 'logica', 3, NULL, NULL, '2026-03-31 15:21:14'),
(6, 522, 'qweqwe', 8, '186.67.42.46', '2026-03-31', '12:22:51', 'logica', 2, NULL, NULL, '2026-03-31 15:22:51'),
(7, 526, 'werwerwe', 8, '186.67.42.46', '2026-03-31', '12:42:22', 'logica', 2, NULL, NULL, '2026-03-31 15:42:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_sesiones`
--

CREATE TABLE `log_sesiones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `hora_ingreso` time DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_sesiones_usuario`
--

CREATE TABLE `log_sesiones_usuario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_sesiones_usuario`
--

INSERT INTO `log_sesiones_usuario` (`id`, `id_usuario`, `fecha`, `hora`, `ip`) VALUES
(1, 1, '2025-04-09', '08:12:34', '192.168.0.10'),
(2, 1, '2025-04-09', '10:44:22', '192.168.0.15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `para` int(11) NOT NULL,
  `de` int(10) NOT NULL,
  `tiempo` int(10) DEFAULT NULL,
  `leido` varchar(11) DEFAULT NULL,
  `urgente` varchar(2) NOT NULL,
  `fecha` date DEFAULT current_timestamp(),
  `hora` time NOT NULL,
  `eliminado` varchar(2) NOT NULL,
  `prioridad` enum('Alta','Media','Baja') DEFAULT 'Media',
  `id_conversacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `mensaje`, `para`, `de`, `tiempo`, `leido`, `urgente`, `fecha`, `hora`, `eliminado`, `prioridad`, `id_conversacion`) VALUES
(214, 'hola', 8, 27, 2025, '0', '0', '2025-07-10', '16:35:59', '0', 'Alta', 0),
(215, 'SALUDOS', 42, 8, 2026, '0', '0', '2026-01-08', '15:10:35', '0', 'Alta', 0),
(216, 'Hola', 8, 42, 2026, '0', '0', '2026-01-08', '15:24:22', '0', 'Alta', 0),
(187, 'hola , Alejandro', 42, 8, 2025, '0', '0', '2025-06-12', '10:49:27', '0', 'Alta', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_chat`
--

CREATE TABLE `mensajes_chat` (
  `id` int(11) NOT NULL,
  `id_padre` int(11) DEFAULT NULL,
  `id_conversacion` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `de` int(11) NOT NULL,
  `para` int(11) NOT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0,
  `urgente` tinyint(1) DEFAULT 0,
  `eliminado` tinyint(1) DEFAULT 0,
  `prioridad` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes_chat`
--

INSERT INTO `mensajes_chat` (`id`, `id_padre`, `id_conversacion`, `mensaje`, `de`, `para`, `fecha_hora`, `leido`, `urgente`, `eliminado`, `prioridad`) VALUES
(1, 8, 1, 'hola', 8, 1, '2025-03-26 21:53:54', 0, 0, 1, NULL),
(2, NULL, 1, 'qwerqwe', 8, 1, '2025-03-27 09:00:48', 0, 0, 0, 'Media');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_1`
--

CREATE TABLE `menu_1` (
  `id_menu` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `abreviacion` varchar(50) DEFAULT NULL,
  `archivo` varchar(50) DEFAULT NULL,
  `icono` varchar(100) NOT NULL,
  `caracteristica` text NOT NULL,
  `orden` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `menu_1`
--

INSERT INTO `menu_1` (`id_menu`, `nombre`, `abreviacion`, `archivo`, `icono`, `caracteristica`, `orden`) VALUES
(1, 'Colaboradores', 'col', 'colaboradores.php', '<i class=\"bi bi-people-fill\" style=\"color:black;\"></i>', 'Administra y consulta la información de los colaboradores del sistema, facilitando su organización y seguimiento.', '2'),
(2, 'Mensajes', 'men', 'mensaje.php', '<i class=\"bi bi-chat-dots-fill\" style=\"color:black;\"></i>', 'Gestiona la comunicación interna con tus colaboradores mediante envío y revisión de mensajes dentro del sistema.', '3'),
(3, 'Ticket Nuevo', 'ti', 'ticket.php', '<i class=\"bi bi-plus-circle-fill\" style=\"color:black;\"></i>', 'Crea nuevos tickets para reportar incidencias, solicitudes o requerimientos de soporte de manera rápida y ordenada.', '4'),
(4, 'Ticket Administrador', 'timan', 'ticket_admin_v2.php', '<i class=\"bi bi-clipboard-data-fill\" style=\"color:black;\"></i>', 'Administra y supervisa todos los tickets del sistema, permitiendo revisar estados, reasignar y dar seguimiento general.', '5'),
(5, 'Ticket Asignados', 'tick-asig', 'ticket_asignados.php', '<i class=\"bi bi-person-workspace\" style=\"color:black;\"></i>', 'Visualiza y gestiona los tickets asignados a técnicos o responsables, facilitando el control de tareas pendientes y en proceso.', '6'),
(7, 'Configuracion', 'conf', 'configuracion/permisos.php', '<i class=\"bi bi-gear-fill\" style=\"color:black;\"></i>', 'Configura permisos, accesos, parámetros generales y opciones del sistema según el perfil de cada usuario.', '7'),
(8, 'INICIO', 'index', 'principal.php', '<i class=\"bi bi-house-door-fill\" style=\"color:black;\"></i>', 'Panel principal del sistema donde puedes ver accesos rápidos, métricas, gráficos y un resumen general de la plataforma.', '1'),
(9, 'Inventario', 'bita', 'inventario', '<i class=\"bi bi-pc-display-horizontal\" style=\"color:black;\"></i>', 'Registra, controla y da seguimiento al inventario de equipos, dispositivos y recursos tecnológicos disponibles.', '8'),
(10, 'Generador de Qr ', 'GQ-T', 'generadorQr.php', '<i class=\"bi bi-qr-code-scan\" style=\"color:black;\"></i>', 'Genera códigos QR para identificar recursos, equipos o accesos de forma rápida y facilitar su control dentro del sistema.', '9'),
(11, 'Estadistica', 'est', 'Estadistica', '<i class=\"bi bi-bar-chart-line-fill\" style=\"color:black;\"></i>', 'Consulta reportes, indicadores y estadísticas del sistema para apoyar el análisis y la toma de decisiones.', '10'),
(12, 'Acoso Laboral', 'al', 'denunciaAcoso.php', '<i class=\"bi bi-exclamation-octagon-fill\" style=\"color:black;\"></i>', 'Módulo destinado al registro, seguimiento y gestión de denuncias o situaciones relacionadas con acoso laboral.', '11'),
(13, 'Eventos', 'calen', 'eventos/index.php', '<i class=\"bi bi-calendar-event-fill\" style=\"color:black;\"></i>', 'Permite registrar, organizar y visualizar eventos, actividades importantes, reuniones o fechas relevantes del sistema.', '12'),
(15, 'Licenciamientos', 'licen', 'inventario_sofware\\index.php', '<i class=\"bi bi-shield-check\" style=\"color:black;\"></i>', 'Módulo de gestión de licencias de software que permite registrar, controlar vencimientos, responsables, proveedores y estado de cada licencia.', '13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_1_sub`
--

CREATE TABLE `menu_1_sub` (
  `id_submenu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_1_sub`
--

INSERT INTO `menu_1_sub` (`id_submenu`, `id_menu`, `nombre`, `archivo`, `icono`, `orden`) VALUES
(1, 2, 'Enviados', 'mensaje_enviados.php', '<i class=\"bi bi-send-fill\" style=\"color:black;\"></i>', 1),
(2, 2, 'Recibidos', 'mensaje.php', '<i class=\"bi bi-inbox-fill\" style=\"color:black;\"></i>', 2),
(3, 2, 'Archivados', 'men_archivados.php', '<i class=\"bi bi-archive-fill\" style=\"color:black;\"></i>', 3),
(4, 7, 'Perrmisos', 'permisos.php', '<i class=\"fa-envelope-send\" style=\"color:black;\"></i>', 3),
(5, 7, 'Gráficos', 'graficoss.php', '<i class=\"bi bi-bar-chart-fill\" style=\"color:black;\"></i>', 2),
(8, 9, 'Inventario Aseo', 'inventario_aseo/index.php', '<i class=\"bi bi-droplet-fill\" style=\"color:black;\"></i>', 3),
(9, 9, 'Inventario Herramientas', 'inventario_herramintas/index.php', '<i class=\"bi bi-tools\" style=\"color:black;\"></i>', 2),
(10, 9, 'Inventario PC', 'inventario/index.php', '<i class=\"bi bi-pc-display-horizontal\" style=\"color:black;\"></i>', 1),
(11, 11, 'Vida del Ticket', 'estadistica/vida_ticket.php', '<i class=\"bi bi-diagram-3-fill\" style=\"color:black;\"></i>', 1),
(12, 11, 'Estadística General', 'estadistica/index.php', '<i class=\"bi bi-graph-up-arrow\" style=\"color:black;\"></i>', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_h`
--

CREATE TABLE `menu_h` (
  `id_menu_h` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `pagina` varchar(120) NOT NULL,
  `icono` varchar(120) DEFAULT '',
  `carpeta` varchar(120) DEFAULT '',
  `orden` int(11) NOT NULL DEFAULT 0,
  `final` varchar(2) NOT NULL DEFAULT 'no',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `menu_h`
--

INSERT INTO `menu_h` (`id_menu_h`, `menu`, `pagina`, `icono`, `carpeta`, `orden`, `final`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Inicio', 'index_1.php', '', '', 1, 'no', 1, '2026-02-26 00:11:14', '2026-05-10 18:40:30'),
(2, 'Apps', 'apps.php', '', '', 2, 'no', 1, '2026-02-26 00:11:14', '2026-02-26 00:11:14'),
(3, 'Contactos', 'contactos.php', '', '', 3, 'no', 1, '2026-02-26 00:11:14', '2026-02-26 00:11:14'),
(4, 'Notas', 'notas.php', '', '', 4, 'no', 1, '2026-02-26 00:11:14', '2026-02-26 00:11:14'),
(5, 'Beneficios', 'beneficio.php', '', '', 5, 'no', 1, '2026-05-10 19:55:09', '2026-05-10 20:54:41'),
(6, 'seduc Informa', 'seduc_informa.php', '', '', 6, 'no', 1, '2026-05-10 20:41:59', '2026-05-10 20:42:19'),
(7, 'Informativo', 'capsulas.php', '', '', 7, 'no', 1, '2026-05-10 20:43:38', '2026-05-10 20:52:14'),
(8, 'eventos', 'eventos.php', '', '', 8, 'no', 1, '2026-05-10 22:56:01', '2026-05-10 22:56:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_principal`
--

CREATE TABLE `menu_principal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `menu_principal`
--

INSERT INTO `menu_principal` (`id`, `nombre`, `orden`) VALUES
(1, 'Menus', 1),
(2, 'Contactos', 2),
(3, 'Mensaje', 3),
(4, 'Salir', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_dispositivos`
--

CREATE TABLE `otros_dispositivos` (
  `id_dispositivo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `n_serie` varchar(11) DEFAULT NULL,
  `n_factura` varchar(100) NOT NULL,
  `asignado` varchar(100) DEFAULT NULL,
  `proveedor` varchar(30) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `fecha_compra` date DEFAULT '0000-00-00',
  `observaciones` text DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `otros_dispositivos`
--

INSERT INTO `otros_dispositivos` (`id_dispositivo`, `tipo`, `marca`, `modelo`, `n_serie`, `n_factura`, `asignado`, `proveedor`, `precio`, `fecha_compra`, `observaciones`, `qr_code`) VALUES
(1, '1', 'EPSON', 'L365', '434DSD343', '', '7', '', 0, '0000-00-00', '', 'codigosQR/equipos/1_7.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `nombre`) VALUES
(1, 'usuario'),
(2, 'tecnico'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `orden`) VALUES
(1, 'Control total', 1),
(2, 'Solo lectura', 2),
(3, 'Sin permiso', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_menu_1`
--

CREATE TABLE `permisos_menu_1` (
  `id` int(11) NOT NULL,
  `id_menu1` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_tipo_permiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permisos_menu_1`
--

INSERT INTO `permisos_menu_1` (`id`, `id_menu1`, `id_usuario`, `id_tipo_permiso`) VALUES
(1, 13, 1, 3),
(2, 12, 1, 3),
(3, 11, 1, 3),
(4, 10, 1, 3),
(5, 9, 1, 3),
(6, 8, 1, 1),
(7, 7, 1, 3),
(8, 5, 1, 3),
(9, 4, 1, 3),
(10, 3, 1, 1),
(11, 2, 1, 1),
(12, 1, 1, 1),
(13, 13, 3, 3),
(14, 12, 3, 3),
(15, 11, 3, 3),
(16, 10, 3, 3),
(17, 9, 3, 3),
(18, 8, 3, 1),
(19, 7, 3, 3),
(20, 5, 3, 3),
(21, 4, 3, 3),
(22, 3, 3, 1),
(23, 2, 3, 1),
(24, 1, 3, 1),
(25, 13, 42, 1),
(26, 12, 42, 3),
(27, 11, 42, 1),
(28, 10, 42, 1),
(29, 9, 42, 1),
(30, 8, 42, 1),
(31, 7, 42, 1),
(32, 5, 42, 1),
(33, 4, 42, 1),
(34, 3, 42, 1),
(35, 2, 42, 1),
(36, 1, 42, 1),
(37, 13, 11, 3),
(38, 12, 11, 3),
(39, 11, 11, 3),
(40, 10, 11, 3),
(41, 9, 11, 3),
(42, 8, 11, 1),
(43, 7, 11, 3),
(44, 5, 11, 3),
(45, 4, 11, 3),
(46, 3, 11, 1),
(47, 2, 11, 1),
(48, 1, 11, 1),
(49, 13, 15, 3),
(50, 12, 15, 3),
(51, 11, 15, 3),
(52, 10, 15, 3),
(53, 9, 15, 3),
(54, 8, 15, 1),
(55, 7, 15, 3),
(56, 5, 15, 3),
(57, 4, 15, 3),
(58, 3, 15, 1),
(59, 2, 15, 1),
(60, 1, 15, 1),
(61, 13, 35, 1),
(62, 12, 35, 3),
(63, 11, 35, 3),
(64, 10, 35, 3),
(65, 9, 35, 3),
(66, 8, 35, 3),
(67, 7, 35, 3),
(68, 5, 35, 3),
(69, 4, 35, 3),
(70, 3, 35, 1),
(71, 2, 35, 1),
(72, 1, 35, 1),
(73, 13, 21, 3),
(74, 12, 21, 3),
(75, 11, 21, 3),
(76, 10, 21, 3),
(77, 9, 21, 3),
(78, 8, 21, 1),
(79, 7, 21, 3),
(80, 5, 21, 3),
(81, 4, 21, 3),
(82, 3, 21, 1),
(83, 2, 21, 1),
(84, 1, 21, 1),
(85, 13, 8, 1),
(86, 12, 8, 3),
(87, 11, 8, 1),
(88, 10, 8, 1),
(89, 9, 8, 1),
(90, 8, 8, 1),
(91, 7, 8, 1),
(92, 5, 8, 1),
(93, 4, 8, 1),
(94, 3, 8, 1),
(95, 2, 8, 1),
(96, 1, 8, 1),
(97, 13, 27, 1),
(98, 12, 27, 3),
(99, 11, 27, 3),
(100, 10, 27, 3),
(101, 9, 27, 3),
(102, 8, 27, 1),
(103, 7, 27, 3),
(104, 5, 27, 3),
(105, 4, 27, 3),
(106, 3, 27, 1),
(107, 2, 27, 1),
(108, 1, 27, 1),
(121, 13, 22, 3),
(122, 12, 22, 3),
(123, 11, 22, 3),
(124, 10, 22, 3),
(125, 9, 22, 3),
(126, 8, 22, 1),
(127, 7, 22, 3),
(128, 5, 22, 3),
(129, 4, 22, 3),
(130, 3, 22, 1),
(131, 2, 22, 1),
(132, 1, 22, 1),
(133, 13, 17, 3),
(134, 12, 17, 3),
(135, 11, 17, 3),
(136, 10, 17, 3),
(137, 9, 17, 3),
(138, 8, 17, 1),
(139, 7, 17, 3),
(140, 5, 17, 3),
(141, 4, 17, 3),
(142, 3, 17, 1),
(143, 2, 17, 1),
(144, 1, 17, 1),
(145, 13, 28, 3),
(146, 12, 28, 3),
(147, 11, 28, 3),
(148, 10, 28, 3),
(149, 9, 28, 1),
(150, 8, 28, 1),
(151, 7, 28, 3),
(152, 5, 28, 3),
(153, 4, 28, 3),
(154, 3, 28, 1),
(155, 2, 28, 3),
(156, 1, 28, 3),
(157, 13, 23, 3),
(158, 12, 23, 3),
(159, 11, 23, 3),
(160, 10, 23, 3),
(161, 9, 23, 3),
(162, 8, 23, 1),
(163, 7, 23, 3),
(164, 5, 23, 3),
(165, 4, 23, 3),
(166, 3, 23, 1),
(167, 2, 23, 1),
(168, 1, 23, 1),
(169, 13, 19, 3),
(170, 12, 19, 3),
(171, 11, 19, 3),
(172, 10, 19, 3),
(173, 9, 19, 3),
(174, 8, 19, 1),
(175, 7, 19, 3),
(176, 5, 19, 3),
(177, 4, 19, 3),
(178, 3, 19, 1),
(179, 2, 19, 1),
(180, 1, 19, 1),
(181, 13, 2, 3),
(182, 12, 2, 3),
(183, 11, 2, 3),
(184, 10, 2, 3),
(185, 9, 2, 3),
(186, 8, 2, 1),
(187, 7, 2, 3),
(188, 5, 2, 3),
(189, 4, 2, 3),
(190, 3, 2, 1),
(191, 2, 2, 1),
(192, 1, 2, 1),
(193, 13, 39, 3),
(194, 12, 39, 3),
(195, 11, 39, 3),
(196, 10, 39, 3),
(197, 9, 39, 3),
(198, 8, 39, 1),
(199, 7, 39, 3),
(200, 5, 39, 3),
(201, 4, 39, 3),
(202, 3, 39, 1),
(203, 2, 39, 1),
(204, 1, 39, 1),
(205, 13, 43, 1),
(206, 12, 43, 3),
(207, 11, 43, 1),
(208, 10, 43, 3),
(209, 9, 43, 3),
(210, 8, 43, 1),
(211, 7, 43, 3),
(212, 5, 43, 3),
(213, 4, 43, 3),
(214, 3, 43, 1),
(215, 2, 43, 1),
(216, 1, 43, 1),
(217, 13, 14, 3),
(218, 12, 14, 3),
(219, 11, 14, 3),
(220, 10, 14, 3),
(221, 9, 14, 3),
(222, 8, 14, 1),
(223, 7, 14, 3),
(224, 5, 14, 3),
(225, 4, 14, 3),
(226, 3, 14, 1),
(227, 2, 14, 1),
(228, 1, 14, 1),
(229, 13, 12, 3),
(230, 12, 12, 3),
(231, 11, 12, 3),
(232, 10, 12, 3),
(233, 9, 12, 3),
(234, 8, 12, 1),
(235, 7, 12, 3),
(236, 5, 12, 3),
(237, 4, 12, 3),
(238, 3, 12, 1),
(239, 2, 12, 1),
(240, 1, 12, 1),
(241, 13, 16, 3),
(242, 12, 16, 3),
(243, 11, 16, 3),
(244, 10, 16, 3),
(245, 9, 16, 3),
(246, 8, 16, 1),
(247, 7, 16, 3),
(248, 5, 16, 3),
(249, 4, 16, 3),
(250, 3, 16, 1),
(251, 2, 16, 1),
(252, 1, 16, 1),
(253, 13, 9, 3),
(254, 12, 9, 3),
(255, 11, 9, 3),
(256, 10, 9, 3),
(257, 9, 9, 3),
(258, 8, 9, 1),
(259, 7, 9, 3),
(260, 5, 9, 3),
(261, 4, 9, 3),
(262, 3, 9, 1),
(263, 2, 9, 1),
(264, 1, 9, 1),
(277, 13, 13, 1),
(278, 12, 13, 3),
(279, 11, 13, 1),
(280, 10, 13, 1),
(281, 9, 13, 1),
(282, 8, 13, 1),
(283, 7, 13, 1),
(284, 5, 13, 1),
(285, 4, 13, 1),
(286, 3, 13, 1),
(287, 2, 13, 1),
(288, 1, 13, 1),
(289, 13, 26, 3),
(290, 12, 26, 3),
(291, 11, 26, 3),
(292, 10, 26, 3),
(293, 9, 26, 3),
(294, 8, 26, 1),
(295, 7, 26, 3),
(296, 5, 26, 3),
(297, 4, 26, 3),
(298, 3, 26, 1),
(299, 2, 26, 1),
(300, 1, 26, 1),
(301, 13, 40, 1),
(302, 12, 40, 3),
(303, 11, 40, 1),
(304, 10, 40, 1),
(305, 9, 40, 1),
(306, 8, 40, 1),
(307, 7, 40, 1),
(308, 5, 40, 1),
(309, 4, 40, 1),
(310, 3, 40, 1),
(311, 2, 40, 1),
(312, 1, 40, 1),
(313, 13, 7, 1),
(314, 12, 7, 3),
(315, 11, 7, 1),
(316, 10, 7, 1),
(317, 9, 7, 1),
(318, 8, 7, 1),
(319, 7, 7, 1),
(320, 5, 7, 1),
(321, 4, 7, 1),
(322, 3, 7, 1),
(323, 2, 7, 1),
(324, 1, 7, 1),
(325, 13, 20, 3),
(326, 12, 20, 3),
(327, 11, 20, 3),
(328, 10, 20, 3),
(329, 9, 20, 3),
(330, 8, 20, 1),
(331, 7, 20, 3),
(332, 5, 20, 3),
(333, 4, 20, 3),
(334, 3, 20, 1),
(335, 2, 20, 1),
(336, 1, 20, 1),
(337, 13, 10, 3),
(338, 12, 10, 3),
(339, 11, 10, 3),
(340, 10, 10, 3),
(341, 9, 10, 3),
(342, 8, 10, 1),
(343, 7, 10, 3),
(344, 5, 10, 3),
(345, 4, 10, 3),
(346, 3, 10, 1),
(347, 2, 10, 1),
(348, 1, 10, 1),
(349, 13, 24, 3),
(350, 12, 24, 3),
(351, 11, 24, 3),
(352, 10, 24, 3),
(353, 9, 24, 3),
(354, 8, 24, 1),
(355, 7, 24, 3),
(356, 5, 24, 3),
(357, 4, 24, 3),
(358, 3, 24, 1),
(359, 2, 24, 1),
(360, 1, 24, 1),
(361, 13, 38, 1),
(362, 12, 38, 1),
(363, 11, 38, 1),
(364, 10, 38, 1),
(365, 9, 38, 1),
(366, 8, 38, 1),
(367, 7, 38, 1),
(368, 5, 38, 1),
(369, 4, 38, 1),
(370, 3, 38, 1),
(371, 2, 38, 1),
(372, 1, 38, 1),
(373, 13, 4, 3),
(374, 12, 4, 3),
(375, 11, 4, 3),
(376, 10, 4, 3),
(377, 9, 4, 3),
(378, 8, 4, 1),
(379, 7, 4, 3),
(380, 5, 4, 3),
(381, 4, 4, 3),
(382, 3, 4, 1),
(383, 2, 4, 1),
(384, 1, 4, 1),
(385, 13, 6, 3),
(386, 12, 6, 3),
(387, 11, 6, 3),
(388, 10, 6, 3),
(389, 9, 6, 3),
(390, 8, 6, 1),
(391, 7, 6, 3),
(392, 5, 6, 1),
(393, 4, 6, 3),
(394, 3, 6, 1),
(395, 2, 6, 1),
(396, 1, 6, 1),
(409, 13, 44, 3),
(410, 12, 44, 3),
(411, 11, 44, 3),
(412, 10, 44, 3),
(413, 9, 44, 3),
(414, 8, 44, 1),
(415, 7, 44, 3),
(416, 5, 44, 3),
(417, 4, 44, 3),
(418, 3, 44, 1),
(419, 2, 44, 1),
(420, 1, 44, 1),
(421, 13, 41, 3),
(422, 12, 41, 3),
(423, 11, 41, 3),
(424, 10, 41, 3),
(425, 9, 41, 3),
(426, 8, 41, 1),
(427, 7, 41, 3),
(428, 5, 41, 3),
(429, 4, 41, 3),
(430, 3, 41, 1),
(431, 2, 41, 1),
(432, 1, 41, 1),
(433, 13, 18, 3),
(434, 12, 18, 3),
(435, 11, 18, 3),
(436, 10, 18, 3),
(437, 9, 18, 3),
(438, 8, 18, 1),
(439, 7, 18, 3),
(440, 5, 18, 3),
(441, 4, 18, 3),
(442, 3, 18, 1),
(443, 2, 18, 1),
(444, 1, 18, 1),
(445, 13, 5, 3),
(446, 12, 5, 3),
(447, 11, 5, 3),
(448, 10, 5, 3),
(449, 9, 5, 3),
(450, 8, 5, 1),
(451, 7, 5, 3),
(452, 5, 5, 3),
(453, 4, 5, 3),
(454, 3, 5, 1),
(455, 2, 5, 1),
(456, 1, 5, 1),
(457, 13, 34, 3),
(458, 12, 34, 3),
(459, 11, 34, 3),
(460, 10, 34, 3),
(461, 9, 34, 3),
(462, 8, 34, 1),
(463, 7, 34, 3),
(464, 5, 34, 3),
(465, 4, 34, 3),
(466, 3, 34, 1),
(467, 2, 34, 3),
(468, 1, 34, 3),
(469, 13, 31, 3),
(470, 12, 31, 3),
(471, 11, 31, 3),
(472, 10, 31, 3),
(473, 9, 31, 3),
(474, 8, 31, 1),
(475, 7, 31, 3),
(476, 5, 31, 3),
(477, 4, 31, 3),
(478, 3, 31, 1),
(479, 2, 31, 3),
(480, 1, 31, 3),
(481, 13, 30, 3),
(482, 12, 30, 3),
(483, 11, 30, 3),
(484, 10, 30, 3),
(485, 9, 30, 3),
(486, 8, 30, 1),
(487, 7, 30, 3),
(488, 5, 30, 3),
(489, 4, 30, 3),
(490, 3, 30, 1),
(491, 2, 30, 3),
(492, 1, 30, 3),
(493, 13, 33, 3),
(494, 12, 33, 3),
(495, 11, 33, 3),
(496, 10, 33, 3),
(497, 9, 33, 3),
(498, 8, 33, 1),
(499, 7, 33, 3),
(500, 5, 33, 3),
(501, 4, 33, 3),
(502, 3, 33, 1),
(503, 2, 33, 3),
(504, 1, 33, 3),
(505, 13, 32, 3),
(506, 12, 32, 3),
(507, 11, 32, 3),
(508, 10, 32, 3),
(509, 9, 32, 3),
(510, 8, 32, 1),
(511, 7, 32, 3),
(512, 5, 32, 3),
(513, 4, 32, 3),
(514, 3, 32, 1),
(515, 2, 32, 3),
(516, 1, 32, 3),
(517, 13, 25, 3),
(518, 12, 25, 3),
(519, 11, 25, 3),
(520, 10, 25, 3),
(521, 9, 25, 3),
(522, 8, 25, 1),
(523, 7, 25, 3),
(524, 5, 25, 3),
(525, 4, 25, 3),
(526, 3, 25, 1),
(527, 2, 25, 1),
(528, 1, 25, 1),
(601, 1, 45, 1),
(602, 3, 45, 1),
(603, 4, 45, 3),
(604, 5, 45, 3),
(606, 7, 45, 3),
(607, 8, 45, 1),
(608, 9, 45, 3),
(609, 10, 45, 3),
(610, 11, 45, 3),
(611, 12, 45, 3),
(612, 13, 45, 3),
(614, 15, 45, 3),
(628, 1, 49, 3),
(629, 2, 49, 3),
(630, 3, 49, 3),
(631, 4, 49, 3),
(632, 3, 49, 1),
(633, 4, 49, 3),
(634, 5, 49, 3),
(636, 7, 49, 3),
(637, 8, 49, 1),
(638, 9, 49, 3),
(639, 10, 49, 3),
(640, 11, 49, 3),
(641, 12, 49, 3),
(642, 1, 48, 3),
(643, 2, 48, 3),
(644, 3, 48, 1),
(645, 4, 48, 3),
(646, 5, 48, 3),
(648, 7, 48, 3),
(649, 8, 48, 1),
(650, 9, 48, 3),
(651, 10, 48, 3),
(652, 11, 48, 3),
(653, 12, 48, 3),
(656, 1, 2476, 3),
(657, 2, 2476, 3),
(658, 3, 2476, 1),
(659, 4, 2476, 3),
(660, 5, 2476, 3),
(661, 7, 2476, 3),
(662, 8, 2476, 1),
(663, 9, 2476, 3),
(664, 10, 2476, 3),
(665, 11, 2476, 3),
(666, 12, 2476, 3),
(667, 13, 2476, 3),
(680, 15, 8, 1),
(681, 15, 6, 1),
(682, 15, 7, 1),
(683, 15, 42, 1),
(749, 1, 2483, 3),
(750, 2, 2483, 3),
(751, 3, 2483, 1),
(752, 4, 2483, 3),
(753, 5, 2483, 3),
(754, 7, 2483, 3),
(755, 8, 2483, 1),
(756, 9, 2483, 3),
(757, 10, 2483, 3),
(758, 11, 2483, 3),
(759, 12, 2483, 3),
(760, 13, 2483, 3),
(761, 15, 2483, 1),
(762, 1, 2484, 3),
(763, 2, 2484, 3),
(764, 3, 2484, 1),
(765, 4, 2484, 3),
(766, 5, 2484, 3),
(767, 7, 2484, 3),
(768, 8, 2484, 1),
(769, 9, 2484, 3),
(770, 10, 2484, 3),
(771, 11, 2484, 3),
(772, 12, 2484, 3),
(773, 13, 2484, 3),
(774, 15, 2484, 1),
(775, 1, 2485, 3),
(776, 2, 2485, 3),
(777, 3, 2485, 1),
(778, 4, 2485, 3),
(779, 5, 2485, 3),
(780, 7, 2485, 3),
(781, 8, 2485, 1),
(782, 9, 2485, 3),
(783, 10, 2485, 3),
(784, 11, 2485, 3),
(785, 12, 2485, 3),
(786, 13, 2485, 3),
(787, 15, 2485, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE `prioridad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`id`, `nombre`, `orden`) VALUES
(1, 'Alta', 1),
(2, 'Media', 2),
(3, 'Baja', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso_tickets`
--

CREATE TABLE `proceso_tickets` (
  `id_proceso` int(11) NOT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `fecha_creacion_inicio` date DEFAULT NULL,
  `hora_creacion_inicio` time DEFAULT NULL,
  `fecha_estimada_admin` date DEFAULT NULL,
  `dias_estimada_admin` int(11) DEFAULT NULL,
  `fecha_asignacion_tecnico` date DEFAULT NULL,
  `hora_asignacion_tecnico` time DEFAULT NULL,
  `fecha_comienzo_ticket` date DEFAULT NULL,
  `hora_comienzo_ticket` time DEFAULT NULL,
  `fecha_termino_ticket` date DEFAULT NULL,
  `hora_termino_ticket` time DEFAULT NULL,
  `fecha_cierre_ticket` date DEFAULT NULL,
  `hora_cierre_ticket` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proceso_tickets`
--

INSERT INTO `proceso_tickets` (`id_proceso`, `id_ticket`, `fecha_creacion_inicio`, `hora_creacion_inicio`, `fecha_estimada_admin`, `dias_estimada_admin`, `fecha_asignacion_tecnico`, `hora_asignacion_tecnico`, `fecha_comienzo_ticket`, `hora_comienzo_ticket`, `fecha_termino_ticket`, `hora_termino_ticket`, `fecha_cierre_ticket`, `hora_cierre_ticket`) VALUES
(1, 1, '2024-05-10', '09:12:32', '2024-05-10', 1, '2024-05-10', '09:13:13', '2024-05-10', '09:23:13', '2024-05-10', '10:23:13', '2025-04-01', '22:21:58'),
(11, 11, '2024-06-06', '12:05:09', '2024-06-10', 4, '2024-06-06', '12:05:57', '2024-06-10', '12:25:32', '2024-06-10', '12:25:40', '2026-03-24', '10:00:59'),
(13, 13, '2024-06-10', '16:45:13', '2024-06-14', 4, '2024-06-10', '16:45:53', '2024-06-14', '09:30:47', '2024-07-29', '16:54:08', NULL, NULL),
(17, 17, '2024-06-19', '09:38:31', '0000-00-00', 3, '0000-00-00', '00:00:00', '2024-06-19', '09:38:43', '2024-06-25', '08:20:01', NULL, NULL),
(23, 23, '2024-06-26', '15:02:44', '2024-06-26', 3, '0000-00-00', '00:20:24', '0000-00-00', NULL, '2024-07-09', '12:16:36', '2025-03-13', '16:09:05'),
(32, 36, '2024-07-10', '10:12:03', '2024-07-22', 10, '2024-07-10', '10:12:03', '2024-07-12', '11:10:28', '2024-07-29', '16:55:05', NULL, NULL),
(35, 39, '2024-07-10', '10:14:26', '2024-07-17', 5, '2024-07-10', '10:14:26', '2024-07-12', '11:11:07', NULL, NULL, NULL, NULL),
(116, 134, '2025-03-13', '09:28:49', '2025-03-18', 5, '2025-03-13', '09:29:15', '2025-03-13', '09:29:33', '2025-03-17', '11:30:47', NULL, NULL),
(128, 146, '2025-03-24', '16:57:03', '2025-03-25', 1, '2025-03-24', '16:57:22', '2025-03-24', '16:59:02', '2025-03-25', '09:46:16', NULL, NULL),
(129, 147, '2025-03-25', '09:45:41', '2025-03-25', 1, '2025-03-25', '09:45:41', '2025-03-25', '09:46:38', '2025-03-25', '09:47:35', NULL, NULL),
(205, 223, '2025-05-16', '12:00:12', '0000-00-00', 0, '2025-05-16', '12:00:12', '2025-05-16', '12:04:02', '2026-04-07', '15:11:11', NULL, NULL),
(213, 231, '2025-06-04', '12:01:09', '0000-00-00', 0, '2025-06-06', '11:05:31', '2025-06-06', '12:28:38', '2025-06-09', '15:12:44', NULL, NULL),
(497, 515, '2026-03-23', '16:54:53', '2026-03-26', 2, '2026-03-23', '16:55:21', '2026-03-24', '02:00:01', NULL, NULL, NULL, NULL),
(496, 514, '2026-03-23', '16:50:03', '2026-04-03', 7, '2026-03-23', '16:50:03', '2026-03-27', '09:48:17', NULL, NULL, NULL, NULL),
(495, 513, '2026-03-23', '10:08:09', '0000-00-00', 0, '2026-03-23', '10:08:09', '2026-03-23', '16:51:10', '2026-03-23', '16:52:15', '2026-03-24', '10:06:43'),
(491, 509, '2026-03-17', '12:49:22', '0000-00-00', 0, '2026-03-17', '12:49:22', '2026-03-18', '16:27:21', NULL, NULL, NULL, NULL),
(490, 508, '2026-03-16', '16:30:52', '2026-04-03', 7, '2026-03-16', '16:30:52', '2026-03-27', '09:48:38', NULL, NULL, NULL, NULL),
(489, 507, '2026-03-16', '14:18:22', '2026-03-18', 2, '2026-03-16', '14:18:22', '2026-03-16', '14:18:47', '2026-03-27', '09:50:23', NULL, NULL),
(488, 506, '2026-03-16', '13:39:14', '0000-00-00', 0, '2026-03-16', '13:39:14', '2026-03-18', '16:27:54', '2026-03-30', '14:54:35', NULL, NULL),
(487, 505, '2026-03-13', '12:26:47', '0000-00-00', 0, '2026-03-13', '12:29:34', '2026-03-13', '12:29:47', '2026-04-07', '15:34:17', NULL, NULL),
(486, 504, '2026-03-12', '16:39:09', '2026-03-12', 0, '2026-03-12', '16:39:09', '2026-03-12', '16:43:37', '2026-03-12', '16:44:43', '2026-03-16', '11:00:14'),
(485, 503, '2026-03-12', '15:11:51', '2026-03-17', 1, '2026-03-13', '12:28:02', '2026-03-16', '13:38:12', '2026-03-16', '15:35:00', NULL, NULL),
(484, 502, '2026-03-12', '11:45:23', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(483, 501, '2026-03-12', '11:16:27', '0000-00-00', 0, '2026-03-12', '11:16:27', NULL, NULL, NULL, NULL, NULL, NULL),
(482, 500, '2026-03-12', '10:55:30', '2026-04-03', 7, '2026-03-13', '12:28:17', '2026-03-27', '09:48:57', NULL, NULL, NULL, NULL),
(481, 499, '2026-03-12', '10:54:32', '2026-04-03', 7, '2026-03-12', '10:54:32', '2026-03-27', '09:43:44', NULL, NULL, NULL, NULL),
(480, 498, '2026-03-11', '16:28:49', '2026-03-11', 0, '2026-03-11', '16:28:49', '2026-03-11', '16:29:29', '2026-03-11', '16:29:40', NULL, NULL),
(479, 497, '2026-03-11', '16:27:10', '2026-03-11', 0, '2026-03-11', '16:27:10', '2026-03-11', '16:27:31', '2026-03-11', '16:29:10', NULL, NULL),
(478, 496, '2026-03-11', '11:35:31', '0000-00-00', 0, '2026-03-12', '10:56:09', '2026-03-12', '10:56:37', '2026-03-13', '12:28:47', '2026-03-16', '11:01:17'),
(477, 495, '2026-03-11', '11:34:53', '2026-03-12', 0, '2026-03-12', '10:56:20', '2026-03-12', '10:57:05', '2026-03-13', '12:29:01', '2026-03-16', '11:00:52'),
(476, 494, '2026-03-10', '08:42:16', '2026-03-13', 1, '2026-03-10', '08:42:16', '2026-03-12', '16:45:08', '2026-03-16', '15:32:55', NULL, NULL),
(475, 493, '2026-03-10', '08:40:38', '2026-03-13', 1, '2026-03-10', '08:40:38', '2026-03-12', '16:45:24', '2026-03-16', '15:35:16', NULL, NULL),
(474, 492, '2026-03-09', '15:57:09', '2026-03-16', 7, '2026-03-09', '15:57:09', '2026-03-09', '16:16:13', NULL, NULL, NULL, NULL),
(473, 491, '2026-03-09', '15:56:14', '2026-03-13', 4, '2026-03-09', '15:56:14', '2026-03-09', '16:16:31', '2026-03-16', '15:31:18', NULL, NULL),
(472, 490, '2026-03-09', '15:55:22', '2026-03-16', 7, '2026-03-09', '15:55:22', '2026-03-09', '16:16:50', '2026-04-07', '14:45:05', NULL, NULL),
(471, 489, '2026-03-09', '15:54:39', '2026-03-16', 7, '2026-03-09', '15:54:39', '2026-03-09', '16:17:10', NULL, NULL, NULL, NULL),
(470, 488, '2026-03-05', '14:19:05', '2026-03-09', 0, '2026-03-05', '14:19:28', '2026-03-09', '15:48:29', '2026-03-09', '15:49:15', '2026-03-09', '15:51:03'),
(469, 487, '2026-03-03', '14:49:10', '2026-03-09', 0, '2026-03-03', '14:50:26', '2026-03-09', '15:49:37', '2026-03-09', '15:50:09', '2026-03-09', '15:51:30'),
(468, 486, '2026-03-02', '08:24:58', '2026-03-10', 0, '2026-03-02', '08:24:58', '2026-03-10', '10:01:55', '2026-03-10', '10:02:06', '2026-03-10', '15:34:20'),
(467, 485, '2026-03-02', '08:19:48', '2026-03-02', 0, '2026-03-02', '08:19:48', '2026-03-02', '11:55:10', '2026-03-05', '14:26:17', '2026-03-09', '15:44:52'),
(466, 484, '2026-02-27', '12:43:22', '0000-00-00', 0, '2026-02-27', '12:43:22', '2026-03-24', '11:26:01', '2026-03-27', '09:47:02', NULL, NULL),
(465, 483, '2026-02-27', '12:33:51', '2026-03-03', 0, '2026-02-27', '12:33:51', '2026-03-03', '10:30:34', '2026-03-03', '10:30:59', '2026-03-09', '15:45:42'),
(464, 482, '2026-02-26', '11:28:55', '2026-03-02', 0, '2026-02-26', '11:28:55', '2026-03-02', '11:55:53', '2026-03-05', '14:26:08', '2026-03-09', '15:46:10'),
(463, 481, '2026-02-26', '11:27:27', '2026-04-03', 7, '2026-02-26', '11:27:27', '2026-03-27', '09:38:11', NULL, NULL, NULL, NULL),
(462, 480, '2026-02-26', '11:24:48', '2026-04-03', 7, '2026-02-26', '11:24:48', '2026-03-27', '09:37:44', NULL, NULL, NULL, NULL),
(461, 479, '2026-02-24', '11:11:56', '2026-02-27', 1, '2026-02-24', '11:12:52', '2026-02-26', '11:36:54', '2026-02-26', '11:37:06', '2026-03-09', '15:46:40'),
(460, 478, '2026-02-23', '10:56:19', '2026-02-23', 0, '2026-02-23', '10:56:19', '2026-02-23', '11:01:02', '2026-02-24', '11:10:36', '2026-03-09', '15:53:10'),
(459, 477, '2026-02-23', '10:54:59', '2026-02-23', 0, '2026-02-23', '10:54:59', '2026-02-23', '11:01:28', '2026-02-23', '14:32:28', '2026-03-09', '15:47:07'),
(458, 476, '2026-02-23', '10:53:58', '2026-03-02', 0, '2026-02-23', '10:53:58', '2026-03-02', '11:52:10', '2026-03-02', '11:52:40', '2026-03-12', '10:53:12'),
(457, 475, '2026-02-20', '08:40:41', '2026-02-20', 0, '2026-02-20', '08:40:41', '2026-02-20', '10:48:10', '2026-02-20', '10:48:29', NULL, NULL),
(456, 474, '2026-01-13', '09:12:59', '2026-03-03', 0, '2026-01-13', '09:12:59', '2026-03-03', '15:20:07', '2026-03-11', '20:54:33', NULL, NULL),
(455, 473, '2026-01-13', '09:11:29', '2026-03-02', 7, '2026-01-13', '09:12:05', '2026-02-23', '11:01:52', '2026-02-26', '11:36:15', '2026-03-09', '15:47:44'),
(454, 472, '2026-01-13', '09:10:29', '2026-03-12', 1, '2026-01-13', '09:10:29', '2026-03-11', '20:31:23', '2026-03-12', '11:49:25', '2026-03-16', '15:07:29'),
(453, 471, '2026-01-09', '12:11:57', '2026-01-13', 4, '2026-01-09', '12:12:48', '2026-01-09', '12:14:03', '2026-01-12', '10:54:39', '2026-01-12', '10:57:34'),
(452, 470, '2026-01-09', '11:38:36', '0000-00-00', 0, '2026-01-09', '11:38:36', '2026-03-16', '15:18:51', NULL, NULL, NULL, NULL),
(451, 469, '2026-01-07', '16:23:40', '2026-01-08', 0, '2026-01-07', '16:23:40', '2026-01-08', '09:48:23', '2026-01-08', '09:50:24', '2026-01-12', '10:58:05'),
(450, 468, '2026-01-07', '16:04:51', '0000-00-00', 0, '2026-01-07', '16:04:51', '2026-03-24', '11:26:53', '2026-03-27', '09:49:43', NULL, NULL),
(449, 467, '2026-01-05', '08:30:43', '2026-03-27', 0, '2026-01-05', '08:30:43', '2026-03-27', '09:37:09', '2026-03-27', '09:44:54', NULL, NULL),
(448, 466, '2025-12-15', '16:07:44', '2026-03-27', 0, '2025-12-15', '16:07:44', '2026-03-27', '09:36:24', '2026-03-27', '09:49:24', NULL, NULL),
(447, 465, '2025-11-27', '12:14:34', '2025-12-01', 3, '2025-11-27', '12:14:34', '2025-11-28', '09:26:28', '2026-03-16', '15:30:28', NULL, NULL),
(446, 464, '2025-11-10', '11:22:29', '2025-11-11', 0, '2025-11-10', '11:22:29', '2025-11-11', '12:21:06', '2025-11-11', '12:21:50', NULL, NULL),
(445, 463, '2025-11-10', '09:11:08', '0000-00-00', 0, '2026-01-08', '15:15:51', '2026-03-17', '12:50:34', '2026-03-17', '12:50:58', NULL, NULL),
(444, 462, '2025-11-04', '12:41:34', '2025-11-06', 0, '2025-11-04', '12:41:34', '2025-11-06', '14:27:13', '2025-11-06', '14:28:36', NULL, NULL),
(443, 461, '2025-10-29', '11:43:33', '2025-10-29', 0, '2025-10-29', '11:43:33', '2025-10-29', '11:53:19', '2025-10-29', '11:55:26', NULL, NULL),
(442, 460, '2025-10-28', '09:04:46', '2025-10-28', 0, '2025-10-28', '09:04:46', '2025-10-28', '13:57:13', '2025-10-28', '14:08:38', NULL, NULL),
(441, 459, '2025-10-23', '08:46:29', '2025-10-24', 1, '2025-10-23', '08:46:29', '2025-10-23', '09:12:26', '2025-10-23', '10:00:07', NULL, NULL),
(440, 458, '2025-10-23', '08:42:12', '2025-10-24', 1, '2025-10-23', '08:42:12', '2025-10-23', '08:52:38', '2025-10-23', '09:11:43', NULL, NULL),
(439, 457, '2025-10-14', '14:55:44', '2026-03-27', 0, '2025-10-14', '14:55:44', '2026-03-27', '09:36:01', '2026-03-27', '09:46:27', NULL, NULL),
(438, 456, '2025-10-14', '14:53:40', '2026-03-27', 0, '2025-10-14', '14:53:40', '2026-03-27', '09:35:34', '2026-03-27', '09:46:03', NULL, NULL),
(437, 455, '2025-10-14', '09:20:12', '2025-10-14', 0, '2025-10-14', '09:20:12', '2025-10-14', '09:20:43', '2025-10-14', '09:20:52', NULL, NULL),
(436, 454, '2025-10-14', '09:16:12', '2025-10-26', 6, '2025-10-14', '09:16:12', '2025-10-20', '11:10:25', NULL, NULL, NULL, NULL),
(435, 453, '2025-10-13', '16:39:09', '2025-10-17', 3, '2025-10-13', '16:39:09', '2025-10-14', '12:16:34', '2026-03-16', '15:30:04', NULL, NULL),
(434, 452, '2025-10-13', '11:18:07', '2026-03-12', 1, '2025-10-13', '11:18:07', '2026-03-11', '20:32:56', '2026-03-12', '10:22:34', NULL, NULL),
(433, 451, '2025-10-09', '08:34:20', '2025-10-09', 0, '2025-10-09', '08:34:20', '2025-10-09', '08:35:22', '2025-10-09', '08:45:31', '2025-10-09', '15:13:50'),
(432, 450, '2025-10-07', '21:24:31', '0000-00-00', 0, '2025-10-07', '21:24:31', NULL, NULL, NULL, NULL, NULL, NULL),
(431, 449, '2025-09-29', '21:18:57', '0000-00-00', 0, '2025-09-29', '21:18:57', NULL, NULL, NULL, NULL, NULL, NULL),
(430, 448, '2025-09-22', '14:04:29', '2025-09-28', 6, '2025-09-22', '14:04:29', '2025-09-22', '16:24:48', NULL, NULL, NULL, NULL),
(429, 447, '2025-09-22', '13:59:14', '2025-09-23', 1, '2025-09-22', '13:59:14', '2025-09-23', '11:06:45', '2025-09-23', '11:07:20', '2025-09-23', '12:04:53'),
(428, 446, '2025-09-22', '11:32:02', '2025-09-27', 5, '2025-09-22', '11:32:02', '2025-09-22', '11:32:17', '2025-09-22', '11:45:23', NULL, NULL),
(427, 445, '2025-09-22', '10:53:50', '2025-09-23', 1, '2025-09-22', '10:53:50', '2025-09-22', '10:59:15', '2025-09-22', '11:00:17', NULL, NULL),
(426, 444, '2025-09-22', '10:53:31', '2025-09-28', 6, '2025-09-22', '10:53:31', '2025-09-22', '11:17:30', '2025-09-22', '11:18:26', NULL, NULL),
(425, 443, '2025-09-15', '11:58:43', '2025-09-30', 15, '2025-09-15', '11:58:43', '2025-09-15', '11:59:03', '2025-09-15', '13:17:43', NULL, NULL),
(424, 442, '2025-09-15', '09:59:21', '2025-09-28', 13, '2025-09-15', '09:59:21', '2025-09-15', '11:19:22', '2025-09-22', '11:16:06', NULL, NULL),
(423, 441, '2025-09-10', '10:00:20', '2025-09-11', 1, '2025-09-10', '10:00:20', '2025-09-10', '10:12:14', '2025-09-22', '11:02:45', NULL, NULL),
(422, 440, '2025-09-09', '18:34:04', '0000-00-00', 0, '2025-09-09', '18:34:04', NULL, NULL, NULL, NULL, NULL, NULL),
(421, 439, '2025-09-09', '18:33:22', '0000-00-00', 0, '2025-09-09', '18:33:22', NULL, NULL, NULL, NULL, NULL, NULL),
(420, 438, '2025-09-09', '18:32:22', '0000-00-00', 0, '2025-09-09', '18:32:22', NULL, NULL, NULL, NULL, NULL, NULL),
(419, 437, '2025-09-09', '16:39:32', '0000-00-00', 0, '2025-09-09', '16:39:32', NULL, NULL, NULL, NULL, NULL, NULL),
(418, 436, '2025-09-04', '10:00:40', '2025-09-05', 1, '2025-09-04', '10:00:40', '2025-09-04', '10:27:37', '2025-09-04', '10:28:13', NULL, NULL),
(417, 435, '2025-09-04', '09:59:28', '2026-03-27', 0, '2025-09-04', '09:59:28', '2026-03-27', '09:34:51', '2026-03-27', '09:44:32', NULL, NULL),
(416, 434, '2025-09-04', '09:56:03', '2025-09-05', 1, '2025-09-04', '10:08:30', '2025-09-04', '10:11:41', '2025-09-04', '11:37:11', NULL, NULL),
(415, 433, '2025-09-03', '11:31:48', '0000-00-00', 0, '2025-09-03', '11:47:23', NULL, NULL, NULL, NULL, NULL, NULL),
(414, 432, '2025-09-03', '11:23:54', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(413, 431, '2025-09-03', '11:20:42', '0000-00-00', 0, '2025-09-03', '11:20:42', NULL, NULL, NULL, NULL, NULL, NULL),
(412, 430, '2025-09-03', '11:15:24', '0000-00-00', 0, '2025-09-03', '12:08:33', NULL, NULL, NULL, NULL, NULL, NULL),
(367, 385, '2025-07-08', '15:41:58', '2025-07-11', 3, '2025-07-08', '15:41:58', '2025-07-08', '16:05:47', '2025-07-08', '16:13:42', '2025-07-08', '16:27:30'),
(411, 429, '2025-09-03', '11:07:23', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(410, 428, '2025-09-03', '11:01:36', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(409, 427, '2025-09-03', '10:26:21', '0000-00-00', 0, '2025-09-03', '10:26:21', NULL, NULL, NULL, NULL, NULL, NULL),
(408, 426, '2025-09-03', '10:21:25', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(407, 425, '2025-09-03', '09:22:48', '0000-00-00', 0, '2025-09-03', '09:22:48', NULL, NULL, NULL, NULL, NULL, NULL),
(373, 391, '2025-07-11', '12:13:25', '2025-07-14', 3, '2025-07-11', '12:13:25', '2025-07-11', '12:18:21', '2025-07-11', '12:21:25', '2025-07-11', '12:23:46'),
(406, 424, '2025-09-02', '09:53:19', '0000-00-00', 0, '2025-09-03', '08:41:01', '2025-09-03', '09:19:29', '2025-09-03', '09:19:45', NULL, NULL),
(405, 423, '2025-08-21', '17:19:40', '2025-08-25', 3, '2025-08-21', '17:19:40', '2025-08-22', '12:07:37', '2026-03-16', '15:29:29', NULL, NULL),
(376, 394, '2025-07-15', '10:07:25', '2025-07-15', 0, NULL, NULL, '2025-07-15', '10:52:00', '2025-07-15', '11:05:10', '2025-07-24', '14:19:12'),
(404, 422, '2025-08-21', '08:44:29', '0000-00-00', 0, '2025-08-21', '08:44:29', NULL, NULL, NULL, NULL, NULL, NULL),
(403, 421, '2025-08-21', '08:43:11', '2026-04-03', 7, '2025-08-21', '08:43:11', '2026-03-27', '09:41:22', NULL, NULL, NULL, NULL),
(402, 420, '2025-07-31', '11:01:35', '0000-00-00', 0, '2025-07-31', '11:01:35', NULL, NULL, NULL, NULL, NULL, NULL),
(401, 419, '2025-07-30', '16:49:10', '2025-07-30', 1, '2025-07-30', '16:49:10', '2025-07-30', '16:49:56', '2025-07-30', '16:50:18', '2025-07-30', '16:52:15'),
(400, 418, '2025-07-30', '16:47:59', '2025-07-30', 0, '2025-07-30', '16:47:59', '2025-07-30', '16:49:16', '2025-07-30', '16:49:34', '2025-07-30', '16:52:50'),
(399, 417, '2025-07-30', '16:32:06', '0000-00-00', 0, '2025-07-30', '16:32:06', NULL, NULL, NULL, NULL, NULL, NULL),
(398, 416, '2025-07-30', '16:30:29', '0000-00-00', 0, '2025-07-30', '16:30:29', NULL, NULL, NULL, NULL, NULL, NULL),
(397, 415, '2025-07-30', '16:30:03', '0000-00-00', 0, '2025-07-30', '16:30:03', NULL, NULL, NULL, NULL, NULL, NULL),
(396, 414, '2025-07-30', '16:29:34', '0000-00-00', 0, '2025-07-30', '16:29:34', NULL, NULL, NULL, NULL, NULL, NULL),
(395, 413, '2025-07-30', '15:52:53', '2025-08-15', 16, '2025-07-30', '15:52:53', '2025-07-30', '15:53:27', '2026-03-16', '15:12:52', NULL, NULL),
(394, 412, '2025-07-30', '15:48:35', '2025-08-01', 2, '2025-07-30', '15:48:35', '2025-07-30', '15:49:46', '2026-03-16', '15:11:51', NULL, NULL),
(393, 411, '2025-07-30', '15:47:23', '2025-07-31', 1, '2025-07-30', '15:47:23', '2025-07-30', '15:49:09', '2025-07-31', '12:36:07', NULL, NULL),
(392, 410, '2025-07-29', '12:13:41', '2025-07-31', 2, '2025-07-29', '12:13:41', '2025-07-29', '16:57:25', '2025-07-30', '10:13:48', NULL, NULL),
(391, 409, '2025-07-22', '15:20:35', '0000-00-00', 0, '2025-07-22', '15:20:35', NULL, NULL, NULL, NULL, NULL, NULL),
(498, 516, '2026-03-24', '10:09:16', '2026-04-03', 7, '2026-03-24', '10:09:16', '2026-03-27', '09:48:01', NULL, NULL, NULL, NULL),
(502, 520, '2026-03-24', '20:39:58', '2026-03-27', 3, '2026-03-24', '20:39:58', '2026-03-24', '20:40:35', '2026-03-30', '10:29:54', NULL, NULL),
(503, 521, '2026-03-25', '13:02:20', '2026-03-25', 0, '2026-03-25', '13:02:20', '2026-03-25', '13:02:50', '2026-03-25', '13:03:28', '2026-03-25', '13:04:07'),
(504, 522, '2026-03-27', '12:38:16', '0000-00-00', 0, '2026-03-27', '12:38:16', NULL, NULL, NULL, NULL, NULL, NULL),
(505, 523, '2026-03-30', '14:56:03', '2026-03-31', 1, '2026-03-30', '14:57:15', '2026-03-30', '14:57:41', '2026-04-08', '15:21:29', NULL, NULL),
(506, 524, '2026-03-30', '15:44:18', '2026-03-31', 1, '2026-03-30', '15:44:18', '2026-03-30', '15:44:52', '2026-04-07', '14:21:06', NULL, NULL),
(507, 525, '2026-03-31', '11:52:32', '0000-00-00', 0, '2026-03-31', '11:52:32', NULL, NULL, NULL, NULL, NULL, NULL),
(508, 526, '2026-03-31', '12:41:47', '0000-00-00', 0, '2026-03-31', '12:41:47', NULL, NULL, NULL, NULL, NULL, NULL),
(509, 527, '2026-04-01', '12:01:44', '2026-04-06', 5, '2026-04-01', '12:02:43', '2026-04-01', '12:03:02', '2026-04-01', '14:58:56', NULL, NULL),
(510, 528, '2026-04-06', '11:54:17', '2026-04-13', 7, '2026-04-06', '11:54:17', '2026-04-06', '11:54:42', NULL, NULL, NULL, NULL),
(511, 529, '2026-04-07', '11:26:47', '2026-04-07', 0, '2026-04-07', '11:26:47', '2026-04-07', '14:44:16', '2026-04-07', '14:44:29', NULL, NULL),
(512, 530, '2026-04-07', '14:19:18', '2026-04-09', 2, '2026-04-07', '14:19:18', '2026-04-07', '14:19:46', '2026-04-08', '15:20:40', NULL, NULL),
(513, 531, '2026-04-07', '19:18:20', '0000-00-00', 0, '2026-04-07', '19:18:20', NULL, NULL, NULL, NULL, NULL, NULL),
(514, 532, '2026-04-07', '19:28:06', '0000-00-00', 0, '2026-04-07', '19:28:06', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quiz_preguntas`
--

CREATE TABLE `quiz_preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `opcion_a` varchar(255) NOT NULL,
  `opcion_b` varchar(255) NOT NULL,
  `opcion_c` varchar(255) NOT NULL,
  `opcion_d` varchar(255) NOT NULL,
  `respuesta_correcta` enum('a','b','c','d') NOT NULL,
  `explicacion` text DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `quiz_preguntas`
--

INSERT INTO `quiz_preguntas` (`id`, `pregunta`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `respuesta_correcta`, `explicacion`, `categoria`, `activo`) VALUES
(1, '¿Cuál de estas señales indica que un correo puede ser phishing?', 'Viene de un amigo conocido', 'Tiene urgencia extrema y pide tus datos bancarios', 'Tiene imágenes coloridas', 'Está escrito en español', 'b', 'Los correos de phishing suelen crear urgencia falsa para presionarte a actuar sin pensar.', 'phishing', 1),
(2, '¿Qué debes hacer si recibes un SMS pidiendo verificar tu cuenta bancaria con un enlace?', 'Hacer clic y verificar', 'Ignorarlo y borrar el mensaje', 'Llamar al número del mensaje', 'Reenviar a tus contactos', 'b', 'Nunca hagas clic en enlaces de SMS no solicitados. Contacta a tu banco directamente por sus canales oficiales.', 'smishing', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quiz_resultados`
--

CREATE TABLE `quiz_resultados` (
  `id` int(11) NOT NULL,
  `sesion_id` varchar(64) DEFAULT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `total_preguntas` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razones_bloqueo_usuario`
--

CREATE TABLE `razones_bloqueo_usuario` (
  `id` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `razones_bloqueo_usuario`
--

INSERT INTO `razones_bloqueo_usuario` (`id`, `razon`, `comentario`) VALUES
(1, 'Despido', ''),
(2, 'Mal manejo de sistema', ''),
(3, 'En juicio', ''),
(4, 'Inactividad prolongada', ''),
(5, 'Falsificacion de documentos', ''),
(6, 'Incumplimiento de politicas', ''),
(7, 'Acceso no autorizado', ''),
(8, 'Conducta inapropiada', ''),
(9, 'Rendimiento insuficiente', ''),
(10, 'otra ', ''),
(11, 'Falta de integridad', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reactivacion_ticket`
--

CREATE TABLE `reactivacion_ticket` (
  `id_reactivacion` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_reactivacion` datetime DEFAULT current_timestamp(),
  `hora_reactivacion` time DEFAULT NULL,
  `usuario_reactivacion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `reactivacion_ticket`
--

INSERT INTO `reactivacion_ticket` (`id_reactivacion`, `id_ticket`, `comentario`, `fecha_reactivacion`, `hora_reactivacion`, `usuario_reactivacion`) VALUES
(10, 263, '5555', '2024-09-04 00:00:00', '12:07:38', '8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorio`
--

CREATE TABLE `recordatorio` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `detalle` text DEFAULT NULL,
  `recordar` varchar(2) NOT NULL,
  `completada` varchar(2) NOT NULL DEFAULT 'NO',
  `fecha` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_mensajes`
--

CREATE TABLE `respuestas_mensajes` (
  `id` int(11) NOT NULL,
  `id_mensaje_origen` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `para` int(11) NOT NULL,
  `de` int(11) NOT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `leido` varchar(11) DEFAULT 'NO',
  `urgente` varchar(2) DEFAULT 'NO',
  `eliminado` varchar(2) DEFAULT 'NO',
  `prioridad` enum('Alta','Media','Baja') DEFAULT 'Media'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas_mensajes`
--

INSERT INTO `respuestas_mensajes` (`id`, `id_mensaje_origen`, `mensaje`, `para`, `de`, `fecha_hora`, `leido`, `urgente`, `eliminado`, `prioridad`) VALUES
(17, 11, '333', 8, 1, '2025-03-06 10:36:36', 'NO', 'NO', 'NO', 'Media'),
(20, 11, 'dasd', 8, 1, '2025-03-06 10:47:26', 'NO', 'NO', 'NO', 'Media');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seduc_calendario`
--

CREATE TABLE `seduc_calendario` (
  `id` int(11) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `fecha_texto` varchar(300) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `tipo` enum('ingreso','vacaciones','feriado','jornada','fin_ano','otro') DEFAULT 'otro',
  `estamento` varchar(200) DEFAULT NULL,
  `anio` smallint(6) DEFAULT 2026,
  `activo` tinyint(1) DEFAULT 1,
  `actualizado` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seduc_carga_excel`
--

CREATE TABLE `seduc_carga_excel` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `filas_cargadas` int(11) DEFAULT 0,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seduc_funcionarios`
--

CREATE TABLE `seduc_funcionarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(120) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `fecha_nac` date NOT NULL,
  `cargo` varchar(150) DEFAULT NULL,
  `unidad` enum('seduc_central','colegio','equipos_tecnicos','consejo_direccion','paradocente','auxiliar') DEFAULT 'seduc_central',
  `email` varchar(150) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `creado_en` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios_web_catalogo`
--

CREATE TABLE `sitios_web_catalogo` (
  `id_sitio` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `id_usuario_responsable` int(11) NOT NULL DEFAULT 0,
  `nombre_sitio` varchar(180) NOT NULL,
  `tipo_sitio` enum('Web','App','Cliente') NOT NULL DEFAULT 'Web',
  `url_sitio` varchar(255) DEFAULT NULL,
  `proveedor_hosting` varchar(180) DEFAULT NULL,
  `estado_sitio` enum('Activo','Mantenimiento','En desarrollo','Inactivo') NOT NULL DEFAULT 'Activo',
  `observaciones` text DEFAULT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sitios_web_catalogo`
--

INSERT INTO `sitios_web_catalogo` (`id_sitio`, `id_colegio`, `id_usuario_responsable`, `nombre_sitio`, `tipo_sitio`, `url_sitio`, `proveedor_hosting`, `estado_sitio`, `observaciones`, `id_usuario`, `activo`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 'Biblioteca Digital', 'Web', 'https://biblioteca.colegio.cl', 'Hostinger', 'Activo', 'Acceso a material digital para alumnos y docentes.', 1, 1, '2026-03-16 11:48:50', '2026-03-16 11:48:50'),
(6, 2, 2, 'App Inspector', 'App', 'https://inspector.colegio.cl', 'VPS institucional', 'Activo', 'Aplicacion de control de atrasos y asistencia.', 2, 1, '2026-03-16 11:48:50', '2026-03-16 11:48:50'),
(7, 2, 3, 'Cliente Inventario Local', 'Cliente', 'inventario-local', 'Servidor local', 'Mantenimiento', 'Cliente interno para bodega y activos.', 2, 1, '2026-03-16 11:48:50', '2026-03-16 11:48:50'),
(8, 3, 1, 'Portal Apoderados', 'Web', 'https://apoderados.colegio.cl', 'AWS', 'Activo', 'Portal de pagos, comunicados y seguimiento academico.', 1, 1, '2026-03-16 11:48:50', '2026-03-16 11:48:50'),
(9, 1, 1, 'Portal Colegio Centro', 'Web', 'https://centro.colegio.cl', 'Hostinger', 'Activo', 'Sitio institucional principal.', 1, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(10, 1, 2, 'App Comunicados Centro', 'App', 'https://app-centro.colegio.cl', 'VPS institucional', 'Activo', 'App de comunicados internos.', 1, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(11, 2, 2, 'Portal Colegio Norte', 'Web', 'https://norte.colegio.cl', 'AWS', 'Activo', 'Sitio institucional de la sede norte.', 2, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(12, 2, 3, 'Cliente Asistencia Norte', 'Cliente', 'cliente-asistencia-norte', 'Servidor local', 'Mantenimiento', 'Cliente interno para asistencia.', 2, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(13, 3, 1, 'Biblioteca Digital Sur', 'Web', 'https://biblioteca-sur.colegio.cl', 'Hostinger', 'Activo', 'Acceso a recursos digitales.', 1, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(14, 3, 2, 'App Inspector Sur', 'App', 'https://inspector-sur.colegio.cl', 'DigitalOcean', 'Activo', 'App de apoyo a inspectoria.', 2, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(15, 4, 3, 'Portal Apoderados Oriente', 'Web', 'https://apoderados-oriente.colegio.cl', 'AWS', 'Activo', 'Portal para apoderados.', 3, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(16, 4, 1, 'Cliente Inventario Oriente', 'Cliente', 'cliente-inventario-oriente', 'Servidor local', 'Activo', 'Cliente local de inventario.', 1, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(17, 4, 1, 'App Reservas Oriente', 'App', 'https://reservas-oriente.colegio.cl', 'VPS institucional', 'En desarrollo', 'Reservas de recursos y espacios.', 1, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(18, 2, 2, 'Mesa de Ayuda Norte', 'Web', 'https://soporte-norte.colegio.cl', 'Hostinger', 'Activo', 'Portal de soporte TI.', 2, 1, '2026-03-16 12:15:05', '2026-03-16 12:15:05'),
(19, 15, 42, 'Portal Dashboard Académico', 'Web', 'academic.inquba.cl', 'Inquba', 'Activo', '', 42, 1, '2026-04-07 08:46:45', '2026-04-07 08:46:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_catalogo`
--

CREATE TABLE `software_catalogo` (
  `id_software` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `id_usuario_responsable` int(11) NOT NULL DEFAULT 0,
  `id_tipo_usuario` int(11) NOT NULL DEFAULT 0,
  `nombre_software` varchar(180) NOT NULL,
  `version_software` varchar(80) DEFAULT NULL,
  `cantidad_licencias` int(11) NOT NULL DEFAULT 1,
  `tipo_licenciamiento` enum('Suscripcion','Licencia perpetua','Gratuita') NOT NULL DEFAULT 'Suscripcion',
  `fecha_inicio_licencia` date DEFAULT NULL,
  `fecha_fin_licencia` date DEFAULT NULL,
  `pagado_por` enum('Colegio','Persona') NOT NULL DEFAULT 'Colegio',
  `costo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `moneda` varchar(10) NOT NULL DEFAULT 'USD',
  `proveedor` varchar(180) DEFAULT NULL,
  `url_referencia` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `software_catalogo`
--

INSERT INTO `software_catalogo` (`id_software`, `id_colegio`, `id_usuario_responsable`, `id_tipo_usuario`, `nombre_software`, `version_software`, `cantidad_licencias`, `tipo_licenciamiento`, `fecha_inicio_licencia`, `fecha_fin_licencia`, `pagado_por`, `costo`, `moneda`, `proveedor`, `url_referencia`, `observaciones`, `id_usuario`, `activo`, `created_at`, `updated_at`) VALUES
(5, 15, 42, 1, 'Zipgrade', '', 6, 'Suscripcion', '2026-03-01', '2027-03-01', '', 49.00, 'USD', 'Zipgrade', 'www.zipgrade.com', 'Evaluaciones Ensayos PAES', 42, 1, '2026-04-06 16:01:07', '2026-04-06 16:32:31'),
(6, 15, 42, 1, 'Follett Destiny', '', 5, 'Suscripcion', '0000-00-00', '0000-00-00', 'Colegio', 6600.00, 'USD', 'Follett Software', 'seduc.follettdestiny.com', 'Sistema Administrador de bibliotecas', 42, 1, '2026-04-06 16:20:28', '2026-04-06 16:24:51'),
(7, 15, 42, 1, 'Moodle', '4.2', 1, 'Gratuita', '0000-00-00', '0000-00-00', '', 500.00, 'USD', 'Moodle', 'www.seducformacion.cl', 'Licenciamiento gratuito. Solo se paga hosting', 42, 1, '2026-04-06 16:22:43', '2026-04-06 16:22:43'),
(8, 15, 6, 0, 'SIAE', '', 1, 'Suscripcion', NULL, NULL, '', 0.00, 'CLP', 'SIAE', 'www.siae.cl', '', 42, 1, '2026-04-07 14:42:11', '2026-04-07 14:42:11'),
(9, 15, 42, 0, 'Padlet', '', 1, 'Suscripcion', NULL, NULL, 'Persona', 4.00, 'USD', 'padlet', 'www.padlet.cl', '', 42, 1, '2026-04-07 14:43:28', '2026-04-07 14:43:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_datos_almacenamiento`
--

CREATE TABLE `software_datos_almacenamiento` (
  `id_dato` int(11) NOT NULL,
  `id_software` int(11) NOT NULL,
  `nombre_contacto` varchar(180) DEFAULT NULL,
  `rut_contacto` varchar(20) DEFAULT NULL,
  `email_contacto` varchar(180) DEFAULT NULL,
  `otros_datos` varchar(255) DEFAULT NULL,
  `orden_dato` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_datos_sensibles_rel`
--

CREATE TABLE `software_datos_sensibles_rel` (
  `id_relacion` int(11) NOT NULL,
  `id_software` int(11) NOT NULL,
  `id_dato_sensible` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `software_datos_sensibles_rel`
--

INSERT INTO `software_datos_sensibles_rel` (`id_relacion`, `id_software`, `id_dato_sensible`, `created_at`) VALUES
(21, 7, 1, '2026-04-06 16:22:43'),
(22, 7, 2, '2026-04-06 16:22:43'),
(23, 7, 4, '2026-04-06 16:22:43'),
(24, 6, 1, '2026-04-06 16:24:51'),
(25, 6, 2, '2026-04-06 16:24:51'),
(26, 6, 4, '2026-04-06 16:24:51'),
(27, 5, 1, '2026-04-06 16:32:31'),
(28, 5, 2, '2026-04-06 16:32:31'),
(29, 8, 5, '2026-04-07 14:42:11'),
(30, 8, 4, '2026-04-07 14:42:11'),
(31, 8, 2, '2026-04-07 14:42:11'),
(32, 8, 7, '2026-04-07 14:42:11'),
(33, 8, 1, '2026-04-07 14:42:11'),
(34, 8, 8, '2026-04-07 14:42:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_historial`
--

CREATE TABLE `software_historial` (
  `id_historial` int(11) NOT NULL,
  `id_software` int(11) NOT NULL,
  `accion` varchar(60) NOT NULL,
  `detalle` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `software_historial`
--

INSERT INTO `software_historial` (`id_historial`, `id_software`, `accion`, `detalle`, `id_usuario`, `fecha_registro`) VALUES
(7, 5, 'creacion', 'Software creado', 42, '2026-04-06 16:01:07'),
(8, 6, 'creacion', 'Software creado', 42, '2026-04-06 16:20:28'),
(9, 7, 'creacion', 'Software creado', 42, '2026-04-06 16:22:43'),
(10, 6, 'actualizacion', 'Software actualizado', 42, '2026-04-06 16:24:51'),
(11, 5, 'actualizacion', 'Software actualizado', 42, '2026-04-06 16:32:31'),
(12, 8, 'creacion', 'Software creado', 42, '2026-04-07 14:42:11'),
(13, 9, 'creacion', 'Software creado', 42, '2026-04-07 14:43:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_tipo_usuario_rel`
--

CREATE TABLE `software_tipo_usuario_rel` (
  `id_relacion` int(11) NOT NULL,
  `id_software` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `software_tipo_usuario_rel`
--

INSERT INTO `software_tipo_usuario_rel` (`id_relacion`, `id_software`, `id_tipo_usuario`, `created_at`) VALUES
(1, 8, 1, '2026-04-07 14:42:11'),
(2, 8, 2, '2026-04-07 14:42:11'),
(3, 9, 1, '2026-04-07 14:43:28'),
(4, 9, 6, '2026-04-07 14:43:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_conversacion`
--

CREATE TABLE `tabla_conversacion` (
  `id` int(11) NOT NULL,
  `texto` text DEFAULT '\'\\\'\\\\\\\'----\\\\\\\'\\\'\'',
  `id_usuario` int(11) DEFAULT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tabla_conversacion`
--

INSERT INTO `tabla_conversacion` (`id`, `texto`, `id_usuario`, `id_tecnico`, `id_ticket`) VALUES
(220, 'VICTOR PEREZ', 5, NULL, 22),
(219, 'VICTOR PEREZ', 8, NULL, 21),
(218, 'gisela', 7, NULL, 20),
(216, 'qwe', 0, NULL, 18),
(217, 'joruwera', 0, NULL, 19),
(215, 'JAVIER URETA', 14, NULL, 17),
(214, 'qwe', 8, NULL, 16),
(213, 'asd', 7, NULL, 15),
(212, 'problema 4', 7, NULL, 14),
(211, 'problema 3\r\n', 7, NULL, 13),
(210, 'problema 2', 7, NULL, 12),
(209, 'problema 1', 7, NULL, 11),
(208, 'problema 10', 8, NULL, 10),
(207, 'problema 9', 8, NULL, 9),
(205, 'problema 6', 8, NULL, 7),
(206, 'PROBLEMA 8', 8, NULL, 8),
(204, 'problema 5', 8, NULL, 6),
(203, 'problema 4 ', 8, NULL, 5),
(202, 'PROBLEMA 3', 8, NULL, 4),
(201, 'problema 2\r\n', 8, NULL, 3),
(200, 'problema 1', 8, NULL, 2),
(199, 'Enviar archivos de Matriculas 2023 y 2024 para auditoria', 7, NULL, 1),
(198, 'la caja esta desactualizada', 8, NULL, 1),
(197, 'prblema', 8, NULL, 2),
(196, 'dsds\r\n', 8, NULL, 1),
(195, 'eeeeeeeeee', 8, NULL, 254),
(194, 'asd', 8, NULL, 253),
(193, ' HIKAJ QUERIDA', 1, NULL, 252),
(192, 'PROBLEMAS CON LA CAJA', 8, NULL, 251);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `id_tecnico` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `anexo` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tecnicos`
--

INSERT INTO `tecnicos` (`id_tecnico`, `nombre`, `ape_paterno`, `ape_materno`, `email`, `telefono`, `anexo`, `foto`, `estado`) VALUES
(1, 'Manuel', 'Gutierrez', 'Gutierrez', 'mgutierrez@seduc.cl', '123456789', '358', NULL, 1),
(2, 'Ramon', 'Oliva', 'Zenteno', 'roliva@seduc.cl', '+5687545621', '359', NULL, 1),
(3, 'Cristian', 'Jorquera', 'Gonzalez', 'cjorquera@seduc.cl', '+56988302735', '322', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `descripcion_ticket` text DEFAULT NULL,
  `id_categoria_ticket` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_prioridad` int(11) DEFAULT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `comentario_administrador` text DEFAULT NULL,
  `comentario_final` varchar(100) DEFAULT NULL,
  `comentario_reactivacion` varchar(100) NOT NULL,
  `identificador` varchar(16) NOT NULL,
  `estado` int(10) NOT NULL DEFAULT 1 COMMENT '1=activo / 2= borrado '
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `id_usuario`, `asunto`, `descripcion_ticket`, `id_categoria_ticket`, `id_estado`, `id_prioridad`, `id_tecnico`, `comentario_administrador`, `comentario_final`, `comentario_reactivacion`, `identificador`, `estado`) VALUES
(1, 1, 'Procesar boletas faltantes', 'Apoderado necesita las boletas A8795 06/05/2024', 5, 5, 1, 7, 'se deben descargar de la caja y procesar en DBNET', '', '', '', 1),
(11, 10, 'Familia Ugarte Vidaurre tema alumno', 'De acuerdo a lo conversado, te detallo la informaciÃ³n del exalumno del Cordillera para ser incorporado como antecedente en la ficha de la familia UGARTE VIDAURRE, en SEDUC Servicios.\r\n', 1, 5, 1, 6, 'Ramon, ver opcion de campo observaciones en la ficha del alumno', '', '', 'iUmndwYkbEuttc8T', 1),
(13, 25, 'Habilitar pago webpay cheque a fecha y protestado', 'Habilitar pago webpay cheque a fecha y protestado', 1, 5, 1, 6, 'se entregara el criterio para su implementacion.\r\n', '', '', 'A2zCj68nE2ThkpVi', 1),
(17, 17, 'Email de cobranza mensual', 'Modificar enviÃ³ actual, filtrar por mes e incluir toda la deuda del apoderado', 1, 5, 3, 6, NULL, '', '', 'gX5rzCaFgHTzuvQV', 1),
(36, 29, 'Acceso a notas Jefas de Departamento', 'Las Jefas de Departamento no tienen acceso a ver todas las notas de su asignatura en los distintos cursos. Por lo tanto, serÃ­a muy Ãºtil dar acceso a Jefas de Departamento a que vean todas las notas de sus asignaturas.', 2, 5, 1, 6, '', '', '', '1Jx0cELhRR9vsT2p', 1),
(39, 29, 'Acceso a biblioteca digital', 'Profesoras de lenguaje necesitan desde su SIAE acceso a la biblioteca digital, para saber quÃ© libros estÃ¡n disponibles. (sÃ³lo que tengan acceso, entiendo que en el SIAE no gestionan la biblioteca)', 2, 5, 1, 6, '', '', '', 'R7SyimM6Wo8T8TcE', 1),
(410, 45, 'Problema en cÃ¡lculo de notas', 'Estimados, \r\n\r\nEl promedio del alumno JUAN DE DIOS FUENZALIDA IZQUIERDO estÃ¡ calculÃ¡ndose mal, el promedio correcto es: 62,71428571 y arroja un 6.0 en su libreta de notas.\r\n\r\nTengo la impresiÃ³n que es la primera informativa la que se estÃ¡ calculando mal.\r\n\r\nQuedo atento a sus comentarios.\r\n\r\nDe antemano, gracias.', 2, 5, 2, 6, NULL, '', '', 'IYZKtsWSpcyjxOSN', 1),
(411, 7, 'Problema SW Casino', 'Visita maÃ±ana jueves 31/07, para diagnosticar falla del equipo y posible reemplazo', 3, 5, 1, 7, NULL, '', '', 'UynEZv9iGJ3MW4yR', 1),
(394, 45, 'Redireccionar web', 'Estimados,\r\n\r\nPor favor redireccionar URL\r\noutdoor.tabancura.cl a https://sites.google.com/tabancura.cl/outdoortabancura2025?usp=sharing \r\n\r\nDe antemano gracias.', 10, 5, 2, 7, NULL, '', '', 'Dhk6ExpvacELxKtu', 1),
(391, 31, 'Revisar propuesta red', 'ver tema de cambio de equipos ubiquiti', 3, 5, 1, 7, NULL, '', '', 'LQhxlBtquL0jh273', 1),
(385, 31, 'Enviar claves MS', 'Enviar claves de Office y Win', 7, 5, 2, 7, NULL, '', '', '468sL4BGJxRmpwKt', 1),
(231, 45, 'Office MAC', 'Estimados,\n\nNecesitamos contar con el acceso a las licencias de office para equipos Mac, con PC estamos OK, pero no hemos recibido informaciÃ³n de mac y no contamos actualmente con la herramienta.\n\nQuedo atento y muchas gracias.', 10, 5, 0, 7, '', '', '', 'swMWqPy6KoVQ3GN0', 1),
(223, 45, 'Problema Apoderada', 'Estimados,\n\nReciba­ esta solicitud de una mama¡. \n\nDe antemano muchas gracias\n\nEstimado Gerardo,\n\nComo esta¡?\nSin querer, ayer puse â€œdesuscribirmeâ€ a la lista de correos del colegio. Le pido por favor si me pudiera agregar nuevamente.\n\nMi correo es valentinagar@gmail.com\n\nMuchas gracias por su ayuda.\nSaludos cordiales,\n\nValentina GarcÃ­a\nMamÃ¡ de Augusto (8C) e Ismael Poblete (1A)', 7, 5, 1, 36, NULL, '', '', 'puYh6Z90lbL0j9hE', 1),
(412, 7, 'Sin Interner Ed. Fisica', 'problema sala de profesores Ed. Fisica por obras de mejoramiento cancha, al parecer cortaron enlace, se debe evaluar alternativa de enlace inalambrico o recableado', 3, 5, 1, 7, NULL, '', '', 'Y75jFPTYv426kQDL', 1),
(413, 7, 'Implementacion Firewall Ubiquiti', 'Implementar y coordinar con proveedor el cambio de Firewall de Mikrotik a EFG Ubiquiti, para que quede todo en la misma plataforma.', 3, 5, 1, 7, NULL, '', '', 'cUI0cWYSgwukPoUC', 1),
(418, 42, 'Reporte de envÃ­o de Correos', 'Gererar reporte de envÃ­o de Correos del mes de julio para evaluar rebotes y entregas', 2, 5, 2, 6, NULL, '', '', '3MdUO2612dQWHmUR', 1),
(419, 42, 'Reporte de envÃ­o de correos U de Navarra', 'Enviar reporte del envio para la charla de la universidad de Navarra', 2, 5, 2, 6, NULL, '', '', 'JkAkCKWjRNtUY60B', 1),
(421, 42, 'Lectura de RUT a partir de QR para porteria', 'Prrmitir la lectura de QR de RUT para registro de proterÃ­a', 2, 3, 2, 6, NULL, NULL, '', 'fk5bnRaVVNSoExQr', 1),
(508, 42, 'Permitir eliminar reserva de salas', 'Permitir eliminar reserva de salas de SIAE', 2, 3, 2, 6, NULL, NULL, '', 'Lmg4neiymFnoISeJ', 1),
(509, 42, 'Agregar otros hermanos en SIAE', 'Agregar otros Hermanos en SIAE para que los agregue la encargada de familia', 2, 3, 1, 6, NULL, NULL, '', 'ojm9hxUMuQzoQbcN', 1),
(423, 45, 'SIAE', 'Estimado,\r\n\r\nTenemos porcentjes que se estÃ¡n presentando mal en este archivo (Ciencias Naturales y Ed FÃ­sica y Salud)\r\n\r\nDe antemano muchas gracias.', 2, 5, 2, 6, NULL, '', '', 'ip0WCdNjfxxYI5LJ', 1),
(424, 45, 'Redireccionamiento', 'Estimados,\r\n\r\nFavor redireccionar\r\nhttp://arte.tabancura.cl/\r\na\r\nhttps://docs.google.com/forms/d/e/1FAIpQLSdX6HYKw6SDcWTNfMX7yForKaeUEApEzCykOXQzY2UBnuXfOw/viewform\r\n\r\nDe antemano gracias.', 10, 5, 0, 7, 'Se procedera a la brevedad.', '', '', 'rj0zWJ2ltxL49efd', 1),
(489, 42, 'Permitir adjuntar archivos en comunicaciones de la App de padres', 'El solicitar un retiro o inasistencia permitir adjuntar archivos', 2, 3, 2, 6, NULL, NULL, '', 'NnsZZd1ivpwcWwwF', 1),
(490, 42, 'Adjuntar archivos en módulo de enfermería', 'Permitir adjuntar recetas medicas en la ficha del alumno (recetas)', 2, 5, 2, 6, NULL, '', '', 'k2CLa1UTnk8amZsx', 1),
(452, 2476, 'Implementacion sistema TICKET', 'enviar datos de acceso a sistema', 11, 5, 3, 8, NULL, 'Usuario creado correctamente en el Sistema de Tickets. Se envió un correo de activación a la casilla', '', 'cDLBHl2YstjtnYHq', 1),
(436, 45, 'Atrasos', 'Estimados,\r\n\r\nHe recibido este correo de Miguel Sandoval coordinador de IIIer ciclo.\r\n\r\n\"Estuve revisando los atrasos de nuestros alumnos en el SIAE, pero en esta primera informativa (2Âº semestre) ningÃºn curso del III ciclo tiene registros. UtilicÃ© las dos rutas que nos dio RamÃ³n Oliva en el primer semestre, y en ambas el resultado es el mismo: cero atrasos en todos los cursos.\r\nLas rutas son las siguientes:\r\nAcadÃ©mica --> Libro de clase --> Atrasos periodo.\r\nLibreta de notas periodo.\r\nTe pido, por favor, que puedas preguntar si ocurriÃ³ algÃºn error en el sistema.\r\nDesde ya muchas gracias por la colaboraciÃ³n.\r\n\r\nSaludos cordiales.\"\r\n\r\nNos pueden ayudar?', 2, 5, 2, 6, NULL, '', '', 'GKAfTZXBX6fqFEaj', 1),
(435, 45, 'Leccionarios 2023 y 2024', 'Estimados,\r\n\r\nEl profesor Luis Jovel solicita:\r\nLeccionarios de ReligiÃ³n de IIÂ° Medio, del aÃ±o pasado y de 2023\r\n\r\nPor favor, nos pueden ayudar?', 2, 5, 2, 6, NULL, '', '', 'pFIU1PpVrjWkupDM', 1),
(434, 45, 'Office 365', 'Estimados,\r\n\r\nIda Mege y Antonia Muzard nos solicitan office 365, podrÃ­an colaborarnos?\r\nSus correos son imege@tabancura.cl, amuzard@tabancura.cl\r\n\r\nDe antemano gracias.', 10, 5, 2, 7, 'Asignar licencia', '', '', 'so7sX7zDbpfs5x8f', 1),
(453, 33, 'prueba - revision de red', 'puerta en marcha de sistema ticket', 3, 5, 2, 7, NULL, '', '', 'c80c9rNRTqfrAECM', 1),
(503, 42, 'Verificar usuario y enviar credenciales', 'Verificar usuario de Catalina Irarrazaval cirarrazaval@colegiolosandes.cl y enviarle enlace y credenciales', 2, 5, 2, 6, '', '', '', 'jVPoYhrlYGiF5aR8', 1),
(451, 42, 'Carga Profesores', 'Carga profesores en sistema Folett (Colegio Huinganal)', 9, 5, 1, 42, NULL, 'Se cargaron los profesores a Follett', '', 'IQQxFZCdqgHmffLy', 1),
(488, 42, 'COnfigurar Ensayo PAES HISTORIA', 'Configurar EPHC1', 10, 5, 1, 42, 'Asignar', '', '', 'fjdhDRMMiJ2apsIl', 1),
(456, 7, 'Envio de contratos educacionales', 'Favor trabajar en el envio de contratos educacionales firmados y con pago de matricula 2026 validado', 2, 5, 2, 6, NULL, '', '', '1qt4esZ3fwafYPWP', 1),
(457, 7, 'Descuento resolucion ctas devengadas', 'Favor trabajar en la adecuación de las cuentas devengadas de los descuentos resolución, que debe aplicarse desde mes de pago hasta diciembre y no como ahora desde ene-dic', 1, 5, 2, 6, NULL, '', '', 'kZqZjHYXxsU3rBdf', 1),
(458, 45, 'Entrevista con Padres - Cambio de fecha', 'Estimados,\r\n\r\nRecibí esta solicitud del profesor Francisco Salazar.\r\n\"La entrevista realizada por quien escribe el día 28 de Julio con la familia Saelzer Benavente, corresponde a la entrevista del II Semestre. Sin embargo, el sistema la tomó como entrevista del I Semestre. ¿Es posible que pueda modificarse para que quede asignada al II Semestre?\"\r\n\r\nQuedo atento a sus comentarios', 2, 5, 2, 6, NULL, 'Estimados\nLa entrevista registrada con fecha 28 de julio de 2025 no aparece en los resúmenes del seg', '', 'OgSuAPYd5gZrlsoW', 1),
(459, 45, 'Atrasos', 'Estimados,\r\n\r\nLa levantamos una solicitud ticket el 4 de septiembre y se ve solucionada el 5 del mismo mes, pero me notificaron que continúa el problema (es el ticket 00-436)\r\nCabe destacar que el IC es el único curso del ciclo que arroja correctamente los atrasos.\r\n\r\nAdjunto comentarios del docente:\r\n\"Nuevamente tenemos problemas con los registros de los atrasos en el SIAE. En el primer semestre ocurrió lo mismo y se corrigió, pero ahora vuelve a ocurrir lo mismo:\r\nCuando se sigue la siguiente ruta \"Académica - Libro de clase - Atrasos período - Segundo semestre\" los siguientes cursos aparecen con 0 atrasos en la 1ª y 2ª informativa: IA, IB, IIA, IIB y IIC.\r\nPor favor ayúdanos con esta situación.\r\n\r\nSaludos cordiales.\"', 2, 5, 2, 6, NULL, 'Se respondió por email', '', 'jhIJrfF41SWlWzvz', 1),
(460, 45, 'Redireccionamiento web', 'Estimados,\r\n\r\nPor favor habilitar el redireccionamiento teatro.tabancura.cl a https://sites.google.com/tabancura.cl/teatro2025\r\n\r\nGracias', 12, 5, 2, 7, NULL, 'Gerardo, ya se realizo la habilitacion y prueba del direccionamiento.\nSaludos', '', '8rdeJYiVz1B3fGvD', 1),
(461, 45, 'Redireccionamiento web', 'Estimados,\r\n\r\n¿Nos pueden ayudar con este redireccionamiento?\r\nconcierto.tabancura.cl a \r\nhttps://sites.google.com/tabancura.cl/concierto2025/inicio\r\n\r\nGracias!', 12, 5, 2, 7, NULL, 'Gerardo, redireccionamiento creado y funcionando.\nSaludos', '', '3LUKAurYwYRNxrPv', 1),
(462, 45, 'Redireccionamiento Web', 'Estimados,\r\n\r\nPor favor redireccionar prevencion.tabancura.cl a https://sites.google.com/tabancura.cl/test-ponografia\r\n\r\nGracias.', 12, 5, 2, 7, NULL, 'Redireccionamiento creado y validado.', '', 'b7EEErTxzStL0DFs', 1),
(463, 45, 'Licencia Office 365', 'Estimado,\r\n\r\nRequiero licencia de office 365 para los siguientes usuarios:\r\nMiguel Sandoval msandoval@tabancura.cl\r\nIda Mege imege@tabancura.cl\r\nJorge Toro jorgetoro@tabancura.cl\r\n\r\nQuedo atento, gracias.', 10, 5, 0, 7, 'EWEQW', '', '', 'o8eRug5ONIHJkqW7', 1),
(464, 45, 'Redireccionamiento web', 'Estimados,\r\n\r\nFavor redireccionar:\r\nferiadeciencias.tabancura.cl\r\na\r\n\r\nhttps://sites.google.com/tabancura.cl/feriadeciencias2024/charlas-científicas-feria-de-ciencias-2025\r\n\r\nDe antemano gracias.', 12, 5, 2, 7, NULL, 'Se realiza redirecionamiento estado validdo y funcionando', '', '5Np1dGX6GFVYUMC0', 1),
(465, 45, 'Problema borrado de notas', 'Estimados,\r\n\r\nDos profesores me indicaron el mismo error, de distintos cursos y me preocupé, por lo mismo les pido si nos ayudan a dilucidar que pudo pasar:\r\nEl profesor Antoni Avendaño comenta que ayer jueves de 14:50 a las 15:30 puso notas en \r\n2A Social Studies\r\nHoy en la mañana no estaban. Se percató previamente que en 2 ocasiones que se habían borrado por lo que probó 3 veces con distintos dispositivos, volviendo a iniciar sesión con distintas redes de internet.\r\n__\r\nLo mismo le ocurrió el día martes, miércoles y jueves con la asignatura\r\n2A Science.\r\n\r\nEl problema estuvo en la nota 18 (segundo semestre, 3era informativa), ya lo ingresó nuevamente y ahora si se guardaron.\r\n\r\n__\r\nMismo caso ocurrió con Rodrigo Valenzuela del 2C English\r\nSegundo semestre, 3era informativa, Nota 18, ya la ingresó nuevamente.\r\n\r\nNo sé si tiene algo que ver, pero ayer entre las 10:50 y 11:30 (aprox, quizás fue antes) no pudimos ingresar al sistema, no cargaba la página.\r\n\r\nQuedo atento a sus comentarios, de antemano gracias.', 2, 5, 2, 6, NULL, '', '', 'fe4AQeE6SbRYObex', 1),
(466, 45, 'Problemas con leccionarios', 'Estimados,\r\n\r\nAgradezco que, por favor, nos puedan ayudar a solucionar un problema con la exportación de los leccionarios. En SIAE 2.0 no resulta exportar el archivo y en ambas versiones, al descargarlo para imprimir el archivo sale con múltiples errores, especialmente en los tildes y caracteres especiales, lo que dificulta muchísimo la lectura.\r\n\r\nMuchas gracias.\r\n\r\nSaludos,', 2, 5, 2, 6, NULL, '', '', 'YO9ZchbGwj6oPq65', 1),
(467, 45, 'Rol Coordinadores', 'Estimados,\r\n\r\nLes escribo para solicitar su ayuda para poder configurar el perfil de coordinador en SIAE.\r\nLa idea es que pueda acceder a anotaciones, testamentos e informes de notas de los estudiantes de todo el colegio, ¿nos pueden colaborar con esto?, de antemano gracias.\r\n\r\nQuedo atento a sus comentarios', 2, 5, 2, 6, NULL, '', '', 'mWa8LOKAU6VzLjBO', 1),
(468, 42, 'Perfil SIAE Macarena Errazuriz', 'Permitir estos accesos\r\n- hacer cambios en los datos de los apoderados (teléfonos, correos, etc)\r\n- hacer envíos de mails a través del SIAE', 2, 5, 0, 6, NULL, '', '', 'OAetoMVb1zMAbI6L', 1),
(469, 42, 'Larga Distancia no funciona', 'Da mensaje de telefono no autorizado al tratar de hacer llamadas', 4, 5, 2, 7, NULL, 'Alejandro, el servicio ya se encuentra vaidado para llamadas internacionales', '', 'HknEDBZIWDqpV5v2', 1),
(470, 42, 'Desarrollar utilitario de calculo de horas', 'Hacer calculadora de horas lectivas / cronológicas similar a SeducServicios pero standAlone para entregar a los colegios', 1, 3, 0, 6, NULL, NULL, '', 'Qxwb7Iqs32QvDMWx', 1),
(471, 42, 'Carga Cursos Históricos en BUK', 'Carga cursos den BUK a partir de archivo histórico REX+', 17, 5, 2, 42, 'Cargar los datos', '', '', 'R95COaLmaoiJazPS', 1),
(472, 42, 'Cambio te técnico', 'Permitir que el administrador cambie el tecnico asignado antes de iniciar un ticket', 11, 5, 2, 8, NULL, 'Se implementó un botón en la tabla de tickets para gestionar la asignación de técnicos.\n\n.Si el tick', '', 'faYRpy5JG3ZbuG1u', 1),
(473, 42, 'Migración Curso DEC a plataforma LMS BUK', 'Crear curso DEC en BUK', 17, 5, 2, 42, 'Crear Curso', '', '', '7Nk5PJVNSmQA51mk', 1),
(474, 42, 'Al asignar tecnico oblig a llenar campos innecesarios', 'Quitar la obligatoriedad de llemar el campo comentario técnico al asignar técnico', 11, 5, 3, 8, NULL, 'ahora ya no es necesario dar un comentario para aignar tecnico', '', 'vkEsxd6X2A9U1lmb', 1),
(475, 42, 'Bloqueo WebPay', 'Bloquear pago de matricula por webpay cuando existan cheques en cartera. Desbloquear solo 6 disas posterior al vencimiento del último cheque', 2, 5, 1, 6, NULL, '', '', 'kpRm0BlvTZm2GoPd', 1),
(476, 42, 'Crear Correo etreligión@seduc.cl', 'Crear correo indicado', 7, 5, 2, 7, NULL, 'Correo creado e informado a usuario', '', 'ws0cQxuXIGPPW267', 1),
(477, 42, 'Asignar permisos a Carolina martinez', 'acceso al Moodle de Religión de nuestras 4 carpetas: 7°, 8°, I° y II° Medio con este nuevo correo: etreligionseduc@gmail.cl que está asignado a Carolina martinez', 8, 5, 2, 42, NULL, '', '', 'B1Y5pP4Z4PSZhzC9', 1),
(478, 42, 'Corregir correo de Pilar Valdivieso', 'pvaldivieso@colegiolosalerces.cl', 9, 5, 1, 42, NULL, '', '', 'nPvvCI7ShciYCiTr', 1),
(479, 42, 'Plantilla de evaulacion de software', 'Desarrollar plantilla de evaluación de software', 10, 5, 2, 42, 'Hacer planilla', '', '', 'nY9XlIWxNAsVBUcM', 1),
(480, 42, 'Comentario en atenciones de enfermerí', 'Permitir agregar un comentario en la atención de enfermería luego de ser grabada', 2, 3, 2, 6, NULL, NULL, '', 'xVppkQyrqEN4V0JQ', 1),
(481, 42, 'Enviar notificación a TENS', 'Enviar notificación de correo a TENS correspondiente cuando se modifica una ficha médica', 2, 3, 2, 6, NULL, NULL, '', 'uHXgFJUKqAggXuYj', 1),
(482, 42, 'Crear correos enfemería', 'Crear correos para enfermeria@xxxxxx  para los colegios: Huinganal, Hulén Cantagallo y Cordillera', 7, 5, 2, 7, NULL, '', '', 's9mdKtfJzEKsLa85', 1),
(483, 42, 'Carga alumnos nuevos', 'Carga alumnos en Follett', 9, 5, 1, 42, NULL, '', '', 'LFadOwKXZDHnEwEH', 1),
(484, 42, 'Separar anotaciones positivas y negativas (Mostrar 2 numeros)', 'Separar las sume de anotaciones en 2: (Positivas y negativas)', 2, 5, 0, 6, NULL, '', '', 'JpWhGpruhCxeqZ6X', 1),
(485, 42, 'Creación Correos para plataforma evaluación', 'Crar correo evaluación@colegioxxx.cl  para todos los colegios menos los alerces.', 7, 5, 2, 7, NULL, '', '', '2U8VYKyG72AFOpOH', 1),
(486, 42, 'Corregir ortografía SIAE', 'En pantalla inicial SIAE 2.0\r\n\r\nDice \"Asignatura que han bajado el promedio\"  agregar s a Asignatura \"Asignaturas\"\r\nDice ACADéMICA, poner la E con tilde en Mayuscula \"ACADÉMICA\"\r\nDice ENFERMERÏA, poner tilde \"ENFERMERÍA\"', 2, 5, 3, 6, NULL, '', '', 'teevmGluMV1J8xaH', 1),
(487, 42, 'Crear licencias Zipgrade', 'Crear licencias Zipgrade con los correos evaluaciones@colegioxx', 10, 5, 1, 42, 'Asignar licencias a correos indicados', 'Licencias OK para todos los colegios', '', 'Fz4th0D0XpYGnX2s', 1),
(491, 42, 'Corregir módulo de calendarpi en SIAE 2.0', 'Terminar implementación modulo calendario en SIAE', 2, 5, 2, 6, NULL, '', '', 'tErTdoS8LmEYU6eS', 1),
(492, 42, 'Funcionalidad de citas de entrevistas', 'Implementar funcionalidad de citas de entrevistas en SIAE', 2, 3, 2, 6, NULL, NULL, '', 'LpJ2hYeDWB8JJAdt', 1),
(493, 42, 'Enviar contraseña SIAE', 'Crear cuenta patricia Subercaseaux', 6, 5, 2, 7, NULL, '', '', '57Glj4N2uh1s6MMo', 1),
(494, 42, 'Usuario SIAE', 'Usuario SIAE para Dora Oyerse', 6, 5, 2, 7, NULL, '', '', 'fMpDPTjYh7hIhjdG', 1),
(495, 42, 'Geolocalizar Familias Nuevas', 'Geolocalizar Familias Nuevas', 10, 5, 1, 42, '', '', '', 'IS3ruuuG9SPy8PrX', 1),
(496, 42, 'Descargar Familias por colegio', 'Descargar Familias por colegio', 2, 5, 0, 42, '', '', '', 'j4CQ28oxCENEWNdB', 1),
(497, 6, 'Envío mail Oxford', 'DESDE: SEDUC Informa, con plantilla de Seduc y el logo que incluye el texto, a la derecha.\r\nPARA: papá y mamá (HIJO MENOR) de todos los colegios, incluyendo Cantagallo.', 2, 5, 2, 6, NULL, '', '', 'vRoPusECzvAstlEh', 1),
(498, 6, 'Enviar email Alumni', 'De acuerdo a lo conversado, le envío el listado de los egresados que debieran recibir el correo cargado por Diego Barrios en el sistema SIAE esta mañana.\r\nAsunto: De egresados a apoderados, bienvenidos a casa.', 2, 5, 2, 6, NULL, '', '', 'MakryG1TzZJt6cNx', 1),
(499, 42, 'Agrupar visión de todos los hijos de una familia', 'Permitir ver todoas los hijos de una familia en SEDUC o Colegios, lo que sea mas facil', 2, 3, 2, 6, NULL, NULL, '', 'HhnZ3dC0cCg7zcau', 1),
(500, 42, 'pantalla de configuracion de envios comunicaciones', 'Permitir que los envis de comunicaciones via app de padres se puedan configurar por colegio los destinatarios de la comunicación', 2, 3, 2, 6, '', NULL, '', 'WjoTZ1lWqAJ8xheo', 1),
(504, 42, 'Usuarios Office 365', 'Crear usuarios Office 365 para María Paz Correa y María Luisa pavic', 6, 5, 2, 7, NULL, 'Cuentas creadas y ambas contraseña inicial: Seduc.2026', '', 'aLFtrE2BaMeSjlOa', 1),
(505, 42, 'Formulario de Inventario de Herramientas Academicas', 'Crear formulario y compartir Colegios', 10, 5, 0, 42, '', '', '', 'x8ppm2MhVoTatP94', 1),
(506, 6, 'Envio email Seguro uandes', 'Enviar email por colegio mas colaboradores colegios y seduc', 7, 5, 0, 7, NULL, 'enviado', '', 'Pp7BuTD2jORjVKNv', 1),
(507, 6, 'Informe descuentos 2025', 'Informe descuento 2025 para anuario\r\n- familias con descuento\r\n- numero de alumnos\r\n- descuento promedio', 2, 5, 2, 6, NULL, '', '', 'RejvAPcSoSnpxQGY', 1),
(520, 8, 'Capacidad de poder Eliminar un Ticket', 'Crear la lógica para eliminar un ticket (solo perfil admin)', 11, 5, 2, 8, NULL, 'Se implementa módulo Eliminar Ticket.\nLa eliminación cambia el estado del ticket, por lo que no se m', '', 'MztP6Ubv4iFbPocU', 2),
(516, 42, 'Permitir Borrado de Salas reservadas', 'Permitir eliminar una reserva de sala', 2, 3, 2, 6, NULL, NULL, '', 'nv1wM3W8lr7aERFq', 1),
(513, 42, 'Cambiar período de prestamo', 'Bajar prestamos de 2 a 1 semana', 9, 5, 0, 42, NULL, '', '', '1FNMru4zQVZisnQC', 1),
(514, 42, 'Copiar una prueba a otro curso del mismo nivel', 'Permitir la copia de un prueba de un curso a otro del nivel', 2, 3, 2, 6, NULL, NULL, '', 'NzUAxCqMSDk3L6uj', 1),
(515, 42, 'pantalla de ingreso test FLO', 'Desarrollar pantalla de ingreso test FLO de acuerdo a formulario', 10, 3, 2, 8, '', NULL, '', 'Y69QcUzJQkJPKigl', 1),
(521, 42, 'Carga Correos Follett', 'Cargar Correos de Padre y Madre en Follett', 9, 5, 1, 42, NULL, 'Correos cargados en Campos email2 e email3 respectivamente', '', 'HkajZfjvCzTZs8zd', 1),
(522, 8, 'eliminar ticket', 'probando la funcionalidad del eliminar ticket', 11, 2, NULL, 8, NULL, NULL, '', 'AOnkCRPCvddhD1De', 2),
(523, 7, 'Facturar Instrumentos Musicales CPA2', 'Facturar taller instrumentos musicales CPA2, segun planilla enviada en correo', 10, 5, 2, 7, 'Solicitare archivo de facturacion a ROLIVA', 'Se realizo con exito carga de archivo de facturacion a sistema Fin700', '', '2m5uz9Xhu0FcUI7n', 1),
(524, 7, 'Requerimeinto ptos de red - Huelén', 'Se solicita visita a Colegio Huelen, para ver requerimeinto de nuevos puntos de red en salas', 3, 5, 2, 7, NULL, '', '', 'YdA0kiBPse7T7JtH', 1),
(525, 8, 'pruebas', 'pruebas', 5, 2, NULL, 8, NULL, NULL, '', 'bGFM4ISRfzAES9JG', 2),
(526, 8, 'prueba nuevamente de elimian r', 'prueba nuevamente de elimian r', 5, 2, NULL, 8, NULL, NULL, '', 'xd1vof1gJzw94OeK', 2),
(527, 8, 'sistema calculo de horas docentes', 'Crear un sistema de cálculo de horas docentes que permita registrar y administrar la distribución horaria semanal de funcionarios por colegio. El sistema deberá permitir cargar horarios de lunes a viernes (mañana y tarde), validar la consistencia de los tramos horarios y calcular automáticamente el resumen de horas cronológicas, lectivas y no lectivas. Además, deberá generar un listado de funcionarios que permita revisar, modificar y mantener trazabilidad de cada registro, considerando dos perfiles de acceso: Super admin (visualiza todos los colegios) y Administrador hora colegio (solo funcionarios de su colegio).', 10, 5, 1, 8, '', '', '', 'PjvHbrYxrLTJCLbt', 1),
(528, 8, 'modulo Inventario', 'Se solicita crear un módulo de Inventario de Software que permita administrar las distintas licencias y páginas web utilizadas por la organización. El módulo deberá permitir registrar información relevante como tipo de software, licencias, responsable del sistema, datos sensibles asociados al licenciamiento (credenciales o información de acceso), proveedor y observaciones. El objetivo es centralizar la información y facilitar la gestión, control y seguimiento de los sistemas y servicios utilizados.', 11, 3, 1, 8, NULL, NULL, '', 'hoOzi1KDsBD89Js0', 1),
(529, 42, 'Cambir boton pantalla inicial \"Acceso Colegio\" por Acceso Profesores y Funcionarios', 'Cambir boton pantalla inicial \"Acceso Colegio\" por Acceso Profesores y Funcionarios', 2, 5, 2, 6, NULL, '', '', 'ILhkDFG2zDXk7XOJ', 1),
(530, 7, 'Renoavcion de Dominios', 'Se solicta renovar x 3 años dominios de seduc y sus colegios que estan por vencer', 12, 5, 2, 7, NULL, 'Se realizo renovacion de todos los dominios hasta año 2029', '', '7QzEHzYnU0Tzfwsn', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_conversaciones`
--

CREATE TABLE `ticket_conversaciones` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `emisor` int(11) NOT NULL,
  `receptor` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `leido` int(11) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_conversaciones`
--

INSERT INTO `ticket_conversaciones` (`id`, `id_ticket`, `emisor`, `receptor`, `mensaje`, `adjunto`, `fecha`, `hora`, `leido`, `eliminado`, `creado_en`) VALUES
(87, 267, 27, 8, 'probando', NULL, '2025-06-13', '14:00:17', 0, 0, '2025-06-13 18:00:17'),
(88, 280, 27, 8, 'Es necesario evaluar el ticket?', NULL, '2025-06-14', '12:07:47', 0, 0, '2025-06-14 16:07:47'),
(89, 294, 7, 8, 'Cristian no sae haga la guagua', NULL, '2025-06-16', '16:48:24', 1, 0, '2025-06-16 20:48:24'),
(4, 102, 9, 43, 'Buenas tardes, el proyector no funciona.', NULL, '2025-06-11', '14:05:00', 1, 0, '2025-06-12 18:35:26'),
(5, 102, 43, 9, 'Gracias por avisar. ¿Ya lo revisaron en el colegio?', NULL, '2025-06-11', '14:07:00', 1, 0, '2025-06-12 18:35:26'),
(6, 103, 10, 44, 'No puedo imprimir, marca error.', NULL, '2025-06-10', '08:20:00', 1, 0, '2025-06-12 18:35:26'),
(7, 103, 44, 10, '¿Qué error aparece exactamente?', NULL, '2025-06-10', '08:21:30', 1, 0, '2025-06-12 18:35:26'),
(8, 104, 8, 42, '¿Cuándo vendrán a revisar el equipo?', NULL, '2025-06-11', '10:30:00', 0, 0, '2025-06-12 18:35:26'),
(9, 104, 42, 8, 'Hoy en la tarde estaremos allá.', NULL, '2025-06-11', '10:35:00', 0, 0, '2025-06-12 18:35:26'),
(10, 104, 8, 42, 'Perfecto, muchas gracias.', NULL, '2025-06-11', '10:36:00', 0, 0, '2025-06-12 18:35:26'),
(90, 294, 8, 7, 'ok, mensaje leÃ­do', NULL, '2025-06-16', '16:56:10', 1, 0, '2025-06-16 20:56:10'),
(86, 266, 8, 7, '', 'archivos/adjuntosConversacionTicket/1749833097_tarjeta_jorquera.png', '2025-06-13', '12:44:57', 0, 0, '2025-06-13 16:44:57'),
(79, 226, 27, 8, '', 'archivos/archivos/adjuntosConversacionTicket1749832613_WIN_20231010_20_16_36_Pro.jpg', '2025-06-13', '12:36:53', 0, 0, '2025-06-13 16:36:53'),
(80, 226, 27, 8, '', 'archivos/archivos/adjuntosConversacionTicket1749832626_17012-4k.jpg', '2025-06-13', '12:37:06', 0, 0, '2025-06-13 16:37:06'),
(81, 226, 27, 8, 'bh', NULL, '2025-06-13', '12:39:46', 0, 0, '2025-06-13 16:39:46'),
(82, 226, 27, 8, '', 'archivos/adjuntosConversacionTicket/1749832793_468739.jpg', '2025-06-13', '12:39:53', 0, 0, '2025-06-13 16:39:53'),
(83, 266, 7, 8, 'Cristian favor entregar a la brevedad', NULL, '2025-06-13', '12:43:42', 0, 0, '2025-06-13 16:43:42'),
(84, 266, 8, 7, 'ok, jefe', NULL, '2025-06-13', '12:43:58', 0, 0, '2025-06-13 16:43:58'),
(85, 266, 7, 8, '', 'archivos/adjuntosConversacionTicket/1749833077_Cartilla_Clasificatoria2026_Fecha15y16.pdf', '2025-06-13', '12:44:37', 0, 0, '2025-06-13 16:44:37'),
(91, 294, 8, 7, 'deje 2 mensajes en mensajes del tecnico', NULL, '2025-06-16', '16:58:30', 1, 0, '2025-06-16 20:58:30'),
(92, 294, 8, 7, 'evento todo un Ã©xito . Ahora guardare equipos', NULL, '2025-06-17', '11:02:57', 1, 0, '2025-06-17 15:02:57'),
(93, 269, 8, 7, 'usuario siae@colegiolosandes.cl  con la clave 123456  Con respesto al usuario del colegio cordillera POR FAVOR confirmar Correo info@colegiocordillera.cl', NULL, '2025-06-17', '11:37:50', 0, 0, '2025-06-17 15:37:50'),
(94, 301, 27, 0, 'revisar el adjunto , por favor Crisia', NULL, '2025-06-17', '18:17:03', 0, 0, '2025-06-17 22:17:03'),
(95, 302, 27, 8, 'Buen dÃ­a . Tu ticket estÃ¡ finalizado', NULL, '2025-06-18', '08:06:59', 0, 0, '2025-06-18 12:06:59'),
(96, 306, 27, 8, 'hola Cristian , tengo probemas con este tiicket , me puedes ayudar', NULL, '2025-06-23', '14:42:01', 0, 0, '2025-06-23 18:42:01'),
(97, 306, 8, 27, 'dime , en que te peudo ayudar', NULL, '2025-06-23', '14:42:18', 0, 0, '2025-06-23 18:42:18'),
(98, 307, 27, 8, 'tengo problemas con la caja . me puedes ayudar', NULL, '2025-06-24', '09:47:46', 0, 0, '2025-06-24 13:47:46'),
(99, 308, 27, 8, 'tengo problemas con la impresora , se atasca el papel', NULL, '2025-06-24', '10:16:21', 0, 0, '2025-06-24 14:16:21'),
(100, 338, 31, 8, '', 'archivos/adjuntosConversacionTicket/1750912253_certificacion_1.png', '2025-06-26', '00:30:53', 0, 0, '2025-06-26 04:30:53'),
(101, 338, 31, 8, 'me peude ayudar con este ticket?', NULL, '2025-06-26', '00:31:03', 0, 0, '2025-06-26 04:31:03'),
(102, 339, 31, 7, 'Favor dar prioridad ya que me lo estan solicitandoi', NULL, '2025-06-26', '08:55:08', 0, 0, '2025-06-26 12:55:08'),
(103, 339, 31, 7, '', 'archivos/adjuntosConversacionTicket/1750942522_5270924550.pdf', '2025-06-26', '08:55:22', 0, 0, '2025-06-26 12:55:22'),
(104, 339, 7, 31, 'ok, dare prioridad dentro de lo posble', NULL, '2025-06-26', '08:58:36', 0, 0, '2025-06-26 12:58:36'),
(105, 339, 7, 31, 'Quedo terminado', NULL, '2025-06-26', '08:59:17', 0, 0, '2025-06-26 12:59:17'),
(106, 372, 8, 27, 'cuentame en que te puedo ayudar', NULL, '2025-06-27', '13:11:46', 0, 0, '2025-06-27 17:11:46'),
(107, 372, 27, 8, 'hlla', NULL, '2025-06-29', '21:09:46', 0, 0, '2025-06-30 01:09:46'),
(108, 372, 27, 8, 'wwww', NULL, '2025-06-29', '21:53:15', 0, 0, '2025-06-30 01:53:15'),
(109, 372, 27, 8, '', 'archivos/adjuntosConversacionTicket/1751251269_ChatGPT_Image_28_jun_2025__22_43_13.png', '2025-06-29', '22:41:09', 0, 0, '2025-06-30 02:41:09'),
(110, 375, 27, 8, 'hlola', NULL, '2025-06-29', '23:16:38', 0, 0, '2025-06-30 03:16:38'),
(111, 375, 27, 8, 'qweqwe', NULL, '2025-06-29', '23:17:00', 0, 0, '2025-06-30 03:17:00'),
(122, 376, 27, 8, '222222', NULL, '2025-06-30', '01:20:33', 1, 0, '2025-06-30 05:20:33'),
(121, 376, 27, 8, 'ewqeq', NULL, '2025-06-30', '01:14:57', 1, 0, '2025-06-30 05:14:57'),
(123, 376, 8, 27, 'digame', NULL, '2025-06-30', '01:41:42', 1, 0, '2025-06-30 05:41:42'),
(178, 382, 8, 27, '', 'archivos/adjuntosConversacionTicket/1751999273_Portafolios.xlsx', '2025-07-08', '14:27:53', 1, 0, '2025-07-08 18:27:53'),
(179, 382, 27, 8, '', 'archivos/adjuntosConversacionTicket/1751999299_17.png', '2025-07-08', '14:28:19', 1, 0, '2025-07-08 18:28:19'),
(180, 385, 7, 31, 'enviare a la brevedad la info', NULL, '2025-07-08', '16:06:17', 1, 0, '2025-07-08 20:06:17'),
(176, 382, 27, 8, 'hola', NULL, '2025-07-08', '14:23:50', 1, 0, '2025-07-08 18:23:50'),
(177, 382, 8, 27, '', 'archivos/adjuntosConversacionTicket/1751999179_ticket_A00309.pdf', '2025-07-08', '14:26:19', 1, 0, '2025-07-08 18:26:19'),
(174, 381, 27, 8, '', 'archivos/adjuntosConversacionTicket/1751998850_funcionarios.xlsx', '2025-07-08', '14:20:50', 1, 0, '2025-07-08 18:20:50'),
(175, 382, 27, 8, '', 'archivos/adjuntosConversacionTicket/1751998996_50250904_normal_1289.pdf', '2025-07-08', '14:23:16', 1, 0, '2025-07-08 18:23:16'),
(172, 379, 27, 8, '33333', NULL, '2025-07-08', '14:17:50', 0, 0, '2025-07-08 18:17:50'),
(173, 381, 27, 8, '', 'archivos/adjuntosConversacionTicket/1751998822_tornillo.jpeg', '2025-07-08', '14:20:22', 1, 0, '2025-07-08 18:20:22'),
(181, 385, 31, 7, 'ideal si puedes hoy mismo', NULL, '2025-07-08', '16:07:20', 1, 0, '2025-07-08 20:07:20'),
(182, 385, 7, 31, '', 'archivos/adjuntosConversacionTicket/1752005369_5237774012.pdf', '2025-07-08', '16:09:29', 1, 0, '2025-07-08 20:09:29'),
(226, 407, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752610698_Manual_Usuario_Sistema_Tickets_SEDUC.docx', '2025-07-15', '16:18:18', 1, 0, '2025-07-15 20:18:18'),
(185, 374, 8, 8, 'hola', NULL, '2025-07-09', '18:07:27', 1, 0, '2025-07-09 22:07:27'),
(186, 374, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752098955_login.png', '2025-07-09', '18:09:15', 1, 0, '2025-07-09 22:09:15'),
(187, 374, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752098983_FELIZ_CUMPE__ALOS.jpeg', '2025-07-09', '18:09:43', 1, 0, '2025-07-09 22:09:43'),
(225, 407, 8, 8, '22222222', NULL, '2025-07-15', '16:18:06', 1, 0, '2025-07-15 20:18:06'),
(224, 407, 8, 8, '222222', NULL, '2025-07-15', '16:18:00', 1, 0, '2025-07-15 20:18:00'),
(223, 407, 8, 8, '333', NULL, '2025-07-15', '16:17:33', 1, 0, '2025-07-15 20:17:33'),
(222, 407, 8, 8, '333', NULL, '2025-07-15', '16:17:12', 1, 0, '2025-07-15 20:17:12'),
(219, 394, 45, 7, 'Gracias!', NULL, '2025-07-15', '10:54:13', 1, 0, '2025-07-15 14:54:13'),
(194, 374, 8, 8, '55', NULL, '2025-07-10', '09:42:26', 1, 0, '2025-07-10 13:42:26'),
(195, 374, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752154960_ticket_A00309.pdf', '2025-07-10', '09:42:40', 1, 0, '2025-07-10 13:42:40'),
(196, 374, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752154987_doc__7_.pdf', '2025-07-10', '09:43:07', 1, 0, '2025-07-10 13:43:07'),
(197, 387, 27, 0, '', 'archivos/adjuntosConversacionTicket/1752158048_slack_logo.png', '2025-07-10', '10:34:08', 1, 0, '2025-07-10 14:34:08'),
(218, 394, 7, 45, 'Hola Gerardo, lo comenzare, te aviso si necesito algo adicional', NULL, '2025-07-15', '10:52:41', 1, 0, '2025-07-15 14:52:41'),
(220, 394, 7, 45, 'Listo', NULL, '2025-07-15', '11:04:38', 1, 0, '2025-07-15 15:04:38'),
(221, 397, 8, 8, '', 'archivos/adjuntosConversacionTicket/1752610590_modelo_as-is.png', '2025-07-15', '16:16:30', 1, 0, '2025-07-15 20:16:30'),
(217, 391, 7, 31, 'kkkkkk', NULL, '2025-07-11', '14:48:31', 1, 0, '2025-07-11 18:48:31'),
(216, 391, 31, 7, 'qq', NULL, '2025-07-11', '14:47:39', 1, 0, '2025-07-11 18:47:39'),
(213, 389, 27, 8, 'hola yo soy prueba jorquera', NULL, '2025-07-11', '14:41:53', 1, 0, '2025-07-11 18:41:53'),
(212, 389, 8, 27, 'hola , yo soy el tecnico cristian jorquera', NULL, '2025-07-11', '14:41:28', 1, 0, '2025-07-11 18:41:28'),
(207, 294, 7, 8, 'hola', NULL, '2025-07-11', '14:11:48', 1, 0, '2025-07-11 18:11:48'),
(211, 389, 27, 8, 'hhhh', NULL, '2025-07-11', '14:40:34', 1, 0, '2025-07-11 18:40:34'),
(210, 389, 8, 27, 'hola', NULL, '2025-07-11', '14:40:07', 1, 0, '2025-07-11 18:40:07'),
(215, 391, 7, 31, 'dime', NULL, '2025-07-11', '14:47:15', 1, 0, '2025-07-11 18:47:15'),
(214, 391, 31, 7, 'hola manuel', NULL, '2025-07-11', '14:47:09', 1, 0, '2025-07-11 18:47:09'),
(227, 406, 8, 8, '33333', NULL, '2025-07-15', '16:29:51', 1, 0, '2025-07-15 20:29:51'),
(228, 406, 8, 8, '3333333', NULL, '2025-07-15', '16:37:44', 1, 0, '2025-07-15 20:37:44'),
(229, 406, 8, 8, '333333', NULL, '2025-07-15', '16:42:42', 1, 0, '2025-07-15 20:42:42'),
(230, 402, 8, 8, '33333', NULL, '2025-07-15', '16:42:56', 1, 0, '2025-07-15 20:42:56'),
(231, 406, 8, 8, '2222', NULL, '2025-07-15', '16:44:24', 0, 0, '2025-07-15 20:44:24'),
(232, 402, 8, 8, '2222', NULL, '2025-07-15', '16:44:43', 0, 0, '2025-07-15 20:44:43'),
(233, 407, 8, 8, '222', NULL, '2025-07-15', '16:49:32', 1, 0, '2025-07-15 20:49:32'),
(234, 407, 8, 8, '222', NULL, '2025-07-15', '16:52:22', 0, 0, '2025-07-15 20:52:22'),
(235, 434, 7, 45, 'Gerardo, ya esta creada la cuenta', NULL, '2025-09-04', '10:36:57', 1, 0, '2025-09-04 14:36:57'),
(236, 434, 7, 45, 'Nombre para mostrar: Ida Mege Nombre de usuario: imege@tabancura.cl ContraseÃ±a: Tabancura.2025', NULL, '2025-09-04', '10:37:02', 1, 0, '2025-09-04 14:37:02'),
(237, 434, 7, 45, 'Nombre de usuario: amuzard@tabancura.cl ContraseÃ±a: Tabancura.2025', NULL, '2025-09-04', '11:36:23', 1, 0, '2025-09-04 15:36:23'),
(238, 453, 33, 7, 'Hola Manuel, como va todo?', NULL, '2025-10-14', '12:29:15', 1, 0, '2025-10-14 15:29:15'),
(239, 453, 33, 7, 'si necesitas alguna info adicional me la pides nomas', NULL, '2025-10-14', '12:29:33', 1, 0, '2025-10-14 15:29:33'),
(240, 460, 7, 45, 'Gerardo, cual de estas se puede borrar ya que solo me permite tener 10 habilitadas', NULL, '2025-10-28', '14:01:14', 1, 0, '2025-10-28 17:01:14'),
(241, 460, 7, 45, '', 'archivos/adjuntosConversacionTicket/1761670897_reglas_tabancura.png', '2025-10-28', '14:01:37', 1, 0, '2025-10-28 17:01:37'),
(242, 469, 7, 42, 'Alejandro, se llamo a Soporte Entel y se valido el SLD', NULL, '2026-01-08', '09:48:57', 0, 0, '2026-01-08 12:48:57'),
(243, 469, 7, 42, 'existia unn tipo de bloqueo especifico que no era tecnico sino comercial segun informaron', NULL, '2026-01-08', '09:49:27', 0, 0, '2026-01-08 12:49:27'),
(250, 520, 8, 8, '', 'archivos/adjuntosConversacionTicket/1774440419_modulo_eliminar_ticket_02.png', '2026-03-25', '09:06:59', 1, 0, '2026-03-25 12:06:59'),
(249, 520, 8, 8, '', 'archivos/adjuntosConversacionTicket/1774440409_modulo_eliminar_ticket_01.png', '2026-03-25', '09:06:49', 1, 0, '2026-03-25 12:06:49'),
(248, 520, 8, 8, '', 'archivos/adjuntosConversacionTicket/1774440383_modulo_eliminar_ticket_00.png', '2026-03-25', '09:06:23', 1, 0, '2026-03-25 12:06:23'),
(251, 520, 8, 8, '', 'archivos/adjuntosConversacionTicket/1774440429_modulo_eliminar_ticket_03.png', '2026-03-25', '09:07:09', 1, 0, '2026-03-25 12:07:09'),
(252, 520, 8, 8, '', 'archivos/adjuntosConversacionTicket/1774440440_modulo_eliminar_ticket_04.png', '2026-03-25', '09:07:20', 1, 0, '2026-03-25 12:07:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_dispositivos`
--

CREATE TABLE `tipos_dispositivos` (
  `id_tipo_dispositivo` int(11) NOT NULL,
  `nombre_dispositivo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icono` varchar(50) NOT NULL DEFAULT 'bi-box'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_dispositivos`
--

INSERT INTO `tipos_dispositivos` (`id_tipo_dispositivo`, `nombre_dispositivo`, `icono`) VALUES
(1, 'Impresora', 'bi-printer'),
(2, 'Telefono', 'bi-telephone'),
(3, 'Teclado', 'bi-keyboard'),
(4, 'Pantalla', 'bi-display'),
(11, 'Escaner', 'bi bi-printer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_convenio`
--

CREATE TABLE `tipo_convenio` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_convenio`
--

INSERT INTO `tipo_convenio` (`id_tipo`, `nombre`, `icono`, `orden`) VALUES
(1, 'Financiero', 'bank', 1),
(2, 'Salud', 'heart', 2),
(3, 'Tecnología', 'device-laptop', 3),
(4, 'Hogar', 'home', 4),
(5, 'Educación', 'school', 5),
(6, 'Alimentación', 'tools-kitchen', 6),
(7, 'Seguros', 'shield', 7),
(8, 'Otros', 'tag', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) DEFAULT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `id_area_trabajo` int(11) DEFAULT NULL,
  `foto` blob DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `anexo` char(10) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_reinicio` varchar(100) DEFAULT NULL,
  `identificador` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `fecha_nacimiento`, `email`, `telefono`, `sexo`, `clave`, `cargo`, `intentos_fallidos`, `id_area_trabajo`, `foto`, `estado`, `anexo`, `fecha_creacion`, `token_reinicio`, `identificador`) VALUES
(1, 'Alex', 'Espinoza', '', '0000-00-00', 'aespinosa@seduc.cl', '5551234567', 1, '$2y$10$bxbSZqUra.5g3O7XXP8NmeJtlRbulv.dgYJAr7pA/jaGUDBjFUTui', 'Analista de Recaudación', 0, 8, NULL, 'Activo', '304', '2024-04-10 13:36:23', '', 'xY8ziBWNWc1jmHg1'),
(2, 'Francisco', 'Chavez', '', '2024-07-03', 'fchavez@seduc.cl', '5551234567', 2, '$2y$10$bxbSZqUra.5g3O7XXP8NmeJtlRbulv.dgYJAr7pA/jaGUDBjFUTui', 'Contador General', 0, 2, NULL, 'Activo', '306', '2024-04-10 14:01:47', '', 'dPjXIubfwJUb2t84'),
(3, 'Alvaro', 'Fuentes', '', '2024-04-26', 'afuentes@seduc.cl', '5551234567', 1, '$2y$10$7vPGbufjJHK2naf22UZ1Zec27jQGFjCkIk.jK.vbIB6x0FCrk/Qjq', 'Analista Contable', 0, 2, NULL, 'Activo', '308', '2024-04-10 14:01:47', '', 'LtW8EHnCO4IeRsxa'),
(4, 'Rodrigo', 'Leon', '', '2024-12-11', 'rleon@seduc.cl', '5551234567', 1, '$2y$10$gS9B7B8GrOmPdmL7rw.EXOyBAbwex93VwZMXL1uMwhLzp9X3wEWem', 'Analista Contable', 0, 2, NULL, 'Activo', '319', '2024-04-10 14:01:47', '', '4ESjNPCq8eCfdb5H'),
(5, 'Victor', 'Perez', '', '2024-08-24', 'vperez@seduc.cl', '5551234567', 1, '$2y$10$OMqYArUZxKRsq4kz.SN9buD1M5Kq7BKX64ikUHTLUd7y5RD.gruMG', 'Analista Contable', 1, 2, NULL, 'Activo', '353', '2024-04-10 14:01:47', '', '6fO83HcKXoUgo0Jr'),
(6, 'Ramon', 'Oliva', 'Zenteno', '2024-05-18', 'roliva@seduc.cl', '5551234567', 1, '$2y$10$wIY1b4bRE1cOFL5wL9kHPOvZTshIZ/qq6yre6DI0wQ5Rpng/sbS9G', 'Analista Programador', 0, 1, NULL, 'Activo', '359', '2024-04-10 14:01:47', '', 'TY26fLT3qMvZinOM'),
(7, 'Manuel', 'Gutierrez', '', '2024-01-09', 'mgutierrez@seduc.cl', '123456', 1, '$2y$10$80CED.Ajy2TSWWFawdMAY.2Q4DtbskPJjr4DLOQUuUSsAPu8wcI3a', 'Jefe de Computación e Informatica', 0, 1, NULL, 'Activo', '322', '2024-04-10 14:01:47', '', 'iZTkQ4CKH6hTstQC'),
(8, 'Cristian', 'jorquera', 'Gonzalez', '1986-01-10', 'cjorquera@seduc.cl', '988302735', 1, '$2y$10$SiKLsCw3jhormsfqTcboweJvROJGO5hnDdF8EWRYjPO3mpIFulF8G', 'Analista Programador', 1, 1, NULL, 'Activo', '358', '2024-04-10 14:01:47', '', 'q8ctAnYBSqmlvl20'),
(9, 'Gonzalo', 'Munoz', '', '2024-03-13', 'gmunoz@seduc.cl', '5551234567', 1, '$2y$10$JQno0PyxlgRYoGS.Q.ell.xkealbQiYAGs9xLFORJFPjoHYPF62l.', 'Prevencionista de Riesgos', 0, 5, NULL, 'Activo', '302', '2024-04-10 14:01:47', '', 'JwfvBkHnCO3EVuy7'),
(10, 'Maria Jose', 'Sanchez', '', '2024-07-13', 'mjsanchez@seduc.cl', '5551234567', 2, '$2y$10$i4IvA1eaqjPudl93jgMnvuHi6UAUyrblQfSMUC2lkkhs/lszx71lq', 'Director (a) de Comunicaciones y Marketing', 0, 3, NULL, 'Activo', '337', '2024-04-10 14:01:47', '', 'Lj8AnVmQZe4rTZ4f'),
(11, 'Antonio', 'Valdes', '', '2024-05-02', 'avaldes@seduc.cl', '5551234567', 1, '$2y$10$Hxab9ZB8/BZO45UwdYKhvueMHquT7GPYTGLomQCP1BiZwfE5JdGYC', 'Jefe de Comunicaciones', 0, 9, NULL, 'Activo', '346', '2024-04-10 14:01:47', '', 'Rqot5PK3R0ikzHBL'),
(12, 'Francisco', 'Valenzuela', '', '2024-04-11', 'fvalenzuela@seduc.cl', '5551234567', 1, '$2y$10$U0SUIVSdqO6beNVpwjn9NuWoYWbc7n1Fcf/nm3cFcrUUAd4cNTSpS', 'Administrador General de Remuneraciones', 0, 3, NULL, 'Activo', '314', '2024-04-10 14:01:47', '', 'TZ8x9X9I0Gf3lrYq'),
(13, 'Jose Ignacio', 'Diaz', '', '2024-06-27', 'jidiaz@seduc.cl', '5551234567', 1, '$2y$10$sTbOdH36jRDeoP1ZYVPuPOVgu1E4lGkEyhSAOXMU42PknRnOy8Tqu', 'Director General', 0, 7, NULL, 'Activo', '331', '2024-04-10 14:01:47', '', '2JoDNXd3u81AFqWh'),
(14, 'Javier', 'Ureta', '', '2024-10-12', 'fjureta@seduc.cl', '5551234567', 1, '$2y$10$A/Ew3an5Z6OfxqKn9Hnwm.jjPkBxqSJGE29pvIP049tyG4/40q4bS', 'Director de Personas', 0, 7, NULL, 'Activo', '320', '2024-04-10 14:01:47', '', 'q8fElCWDd1koOHWr'),
(15, 'Beatriz', 'Herrera', '', '2024-04-28', 'bherrera@seduc.cl', '5551234567', 2, '$2y$10$gArFkwxx2/DqKuw.d/swl.B7M.aT57vKZhF4Y79Mz9lqiJSV9rQFG', 'Coordinador General de Proyectos y Gestión', 0, 5, NULL, 'Activo', '354', '2024-04-10 14:01:47', '', 'cxVQhJDOZlCUuBmR'),
(16, 'Gisela', 'Friedl', '', '2024-09-19', 'gfriedl@seduc.cl', '5551234567', 2, '$2y$10$N3KZs9utSofJXLlgkHe4iOTAczF9fw1sszj0AXxyFD32W7z9I1loe', 'Coordinador(a) de Sistemas de Personas', 0, 3, NULL, 'Activo', '356', '2024-04-10 14:01:47', '', '4zuzgo3T9TSyZ5j8'),
(17, 'Constanza', 'Nieto', '', '2024-07-23', 'cnieto@seduc.cl', '5551234567', 2, '$2y$10$hfMAtdY8VJjRkc8RaZGO2ucu.RgXCW47fO4L8XjaKy6vgVGKI393q', 'Coordinador(a) de Personas', 0, 3, NULL, 'Activo', '345', '2024-04-10 14:01:47', '', 'Bp6ajUrk8zhwDq2N'),
(18, 'Veronica', 'Alvarez', '', '2024-10-05', 'valvarez@seduc.cl', '5551234567', 2, '$2y$10$i6DwqMspGndJJ2qxqSbl0.PPJnlzw/nbBD.NYg5WFzHgDb5rflREq', 'Enfermera Coordinador(a)', 0, 4, NULL, 'Activo', '312', '2024-04-10 14:01:47', '', 'FQ0lAHCQa95QMdCe'),
(19, 'Carola', 'Prado', '', '2024-10-06', 'cprado@seduc.cl', '5551234567', 2, '$2y$10$fPeQIJFMHgOjR4aCnNdDKuvPzyqaazqorTROV2yxYVZZa4CAhK5cO', 'Subdirector(a) Académico', 0, 4, NULL, 'Activo', '324', '2024-04-10 14:01:47', '', 'c5H2YCXO1ufDgdb4'),
(20, 'Magdalena', 'Ibanez', '', '2024-01-03', 'mibanez@seduc.cl', '5551234567', 2, '$2y$10$ofrmF6ZXGjJwXEx67xexkeKYYQfPRoE0SJQt8M3aYd5ny3CyujKDG', 'Subdirector(a) de Formación', 0, 4, NULL, 'Activo', '350', '2024-04-10 14:01:47', '', 'DQ6RPpoBGpQPuNj4'),
(21, 'Carola', 'Barros', '', '2024-04-05', 'cbarros@seduc.cl', '5551234567', 2, '$2y$10$.zWmTKsrkzH3jebXz/BcIuw5wnFI7VQOgRgt8QNcSgBkiU2NYVTPy', 'Asesor(a) Equipo Técnico PEIS', 0, 4, NULL, 'Activo', '348', '2024-04-10 14:01:47', '', 'cEwvNhRjNTTGxwNg'),
(22, 'Cecilia', 'Nestler', '', '2024-10-09', 'cnestler@seduc.cl', '5551234567', 2, '$2y$10$DbifWSJHeTJKPgw61UE9puVfVZQeNmMeMis0gxKVaA.kje9V9L4.C', 'Asesora Equipo Técnico de Ingles', 0, 4, NULL, 'Activo', '349', '2024-04-10 14:01:47', '', 'N1xtAmR5FXAVHAGs'),
(23, 'Cecilia', 'Ostornol', '', '2024-04-02', 'costornol@seduc.cl', '5551234567', 2, '$2y$10$.HBo0x.sk1naRaPoY2xNLesYSGWBFSs6cv4V5o./BBhTExtQ6lSey', 'Asesora Equipo Técnico de Ingles', 0, 4, NULL, 'Activo', '313', '2024-04-10 14:01:47', '', '73MxelUkJxlWvzaX'),
(24, 'Oscar', 'Mercado', '', '2024-06-26', 'omercado@seduc.cl', '5551234567', 1, '$2y$10$iTksx0PSjSiFTchicQWiJ.lbXJhaQ39iTN3Bh9IetDmAcWuEAudKe', 'Director de Administración y Finanzas', 0, 7, NULL, 'Activo', '334', '2024-04-10 14:01:47', '', '8DE9DzM2GbFFaHOP'),
(25, 'Yanelis', 'Reyes', '', '2024-08-16', 'yreyes@seduc.cl', '5551234567', 2, '$2y$10$Ww/RV9n..WLGRl46yxzZ3OqnTLGv8MCuz33JwuDINMFsyJeq2oRfC', 'Jefe(a) de Finanzas', 0, 8, NULL, 'Activo', '325', '2024-04-10 14:01:47', '', 'vRGGbKZzJKnvfAZ2'),
(26, 'Josefina', 'Mackenna', '', '2024-04-09', 'jmackenna@seduc.cl', '5551234567', 2, '$2y$10$8yYcZn8gRwbxYywMQLV.MeCcbtS5PYWEV0DymY8SzAJyoY/nJZ2lC', 'Jefe(a) de Administración ', 0, 8, NULL, 'Activo', '321', '2024-04-10 14:01:47', '', '30HjkyEoS3t3F344'),
(27, 'prueba', 'jorquera', 'Gonzalez', '2024-04-24', 'cm.jordddquerag@gmail.com', '988302735', 1, '$2y$10$TccG7I0F6geKXOZiPEEybO4/j7RhQFx3P6XRKywFwhFxxTxgY44Vi', 'espia', 0, 1, NULL, 'Activo', '888', '2024-04-24 14:17:44', '1087d9cdce76d4aaf4eeaee53593b409', 'YumbFF8vW4oytx7M'),
(28, 'COLEGIO ', 'TABANCURA', ' ', '0000-00-00', 'contacto@tabancura.cl', '23717450', 2, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'Secretaria', 0, 10, NULL, 'Activo', '23717450', '2024-05-10 16:27:17', '', 'pzrnmviP7TY38opG'),
(30, 'COLEGIO', ' HUELEN', ' ', '0000-00-00', 'www.colegiohuelen.cl', '23659191', 2, '$2y$10$K2BYoDn7neJL9c28.RQPuudzQ0Sflme44iudfx3B5rvdTjI8Qgida', 'Secretaria', 0, 10, NULL, 'Activo', '23659191', '2024-05-10 16:27:17', '', 'IvfzUHAHzzZ3awVW'),
(31, 'Javier ', 'Gonzalez ', 'COORDILLERA', '0000-00-00', 'jgonzalez@colegiocordillera.cl ', '24295900', 2, '$2y$10$2AAVHIFwEJyOXQ5NNBaxPORRQU2fZwTQia2bBjfYuwaEgF8MzcFxO', 'Secretaria', 0, 10, NULL, 'Activo', '24295900', '2024-05-10 16:27:17', '', 'JF0P1s1BO6RTIJkk'),
(32, 'COLEGIO ', ' LOS ALERCES', ' ', '0000-00-00', 'www.colegiolosalerces.cl', '24322102', 2, '$2y$10$zlW5xFBPvY1ec/Qp3Vzheu9z9VQFnVnMJG8S7piebZVrYU0RbWBY.', 'Secretaria', 0, 10, NULL, 'Activo', '24322102', '2024-05-10 16:27:17', '', 'tcrrH0OUUEmIjimM'),
(33, 'Miguel ', ' Ortuzar', ' HUINGANAL', '0000-00-00', 'mortuzar@colegiohuinganal.cl', '225921720', 2, '$2y$10$QdtFXifrS1lmTWj9DJb6kO/TIS.v.H1M1oew.UK2k23ojdUP1s2Eq', 'Secretaria', 0, 10, NULL, 'Activo', '225921720', '2024-05-10 16:27:17', '', 'EIwgDbQz6FTgsnnx'),
(34, 'COLEGIO', 'CANTAGALLO ', ' ', '0000-00-00', 'www.colegiocantagallo.cl', '22157520', 2, '$2y$10$hpfiDyYi5Vra3JoQLNz.iOcaDEF7H6GGTr9H3Aw7dNRd1BTzJzrLa', 'Secretaria', 0, 10, NULL, 'Activo', '22157520', '2024-05-10 16:27:17', '', 'qlgbUQm5eHGazflQ'),
(35, 'Catalina', 'Aspillaga', 'Finlay', '0000-00-00', 'caspillaga@seduc.cl', '32423423', 2, '$2y$10$WfvrJoHUcmFtMlGDxBRq9O6zqm23YYCxT1duV6q0b8dPd8rypki8u', 'Dueña de casa y Secretaria', 0, 10, NULL, 'Activo', '301', '2024-06-10 19:15:56', NULL, NULL),
(38, 'prueba', 'prueba', 'prueba', '2024-12-18', 'prueba@prueba.cl', '988302735', 1, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'admin', 0, NULL, NULL, 'Activo', NULL, '2024-12-09 18:01:34', NULL, NULL),
(39, 'Francisco ', 'Gomez', 'Gomez', NULL, 'fgomez@seduc.cl', '5551234567', 1, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'Contador General', 0, 2, NULL, 'Activo', '328', '2024-04-10 14:01:47', NULL, 'TZ8x9X9I0Gf3lJgw'),
(40, 'Jessica', 'Prieto', 'Prieto', '2005-12-05', 'jprieto@seduc.cl', '22157520', 2, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'Finanzas', 0, 8, NULL, 'Activo', '318', '2024-12-20 12:55:41', NULL, 'TZ8x9X9I0Gf5487A'),
(41, 'Trinidad ', 'Errazuriz', 'Errazuriz', '0000-00-00', 'terrazuriz@seduc.cl', '22157520', 2, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'Asesor(a) Equipo Técnico PEIS', 0, 4, NULL, 'Activo', '348', '2025-01-02 15:11:48', NULL, 'TZ8x9X9I0Gf3JHGr'),
(42, 'Alejandro ', 'Rojas', 'Schweitzer', '0000-00-00', 'arojas@seduc.cl', '', 1, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', 'Jefe de Computación e Informatica', 0, 1, NULL, 'Activo', '332', '2025-02-26 15:02:00', NULL, 'q8ctAnYBSqmgSsQW'),
(43, 'Felipe ', 'Guzman ', '', '0000-00-00', 'fguzman@seduc.cl', NULL, 1, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', NULL, 0, 7, NULL, 'Activo', '331', '2025-02-27 15:44:22', NULL, 'dPjXIubfwJUb2ew1'),
(44, 'Trinidad', 'Alamos', '', '0000-00-00', 'talamos@seduc.cl', '22157520', 2, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', NULL, 0, 6, NULL, 'Activo', '', '2025-03-10 17:22:20', NULL, 'TZ8339I0Gf54rES'),
(45, 'Gerardo', 'Elgueta', '', '0000-00-00', 'gelgueta@tabancura.cl', '', 1, '$2y$10$RDPiHV4lDp7d0NJnRP1zbuiSCcriCg7AqsZjFPGaXDVNxRX9.Qa4C', NULL, 0, 6, NULL, 'Activo', '', '2025-05-05 16:36:49', NULL, '123x9X440Gf54rES'),
(46, 'Macarena', 'Urrutia', '', '0000-00-00', 'm.urrutia@huelen.cl', '', 2, '$2y$10$.HBo0x.sk1naRaPoY2xNLesYSGWBFSs6cv4V5o./BBhTExtQ6lSey', NULL, 0, 10, NULL, 'Activo', '', '2025-05-12 18:55:18', NULL, 'TZ8x9X12230Gf54r'),
(48, 'Samuel ', 'Aranda', 'CORDILLERA', '2025-10-13', 'saranda@colegiocordillera.cl', NULL, NULL, '123456', NULL, 0, NULL, NULL, NULL, NULL, '2025-10-13 19:07:35', NULL, NULL),
(49, 'Leandro ', 'Barrios', 'LOS ANDES\r\n', '2025-10-13', 'lbarrios@colegiolosandes.cl', NULL, NULL, '$2y$10$.HBo0x.sk1naRaPoY2xNLesYSGWBFSs6cv4V5o./BBhTExtQ6lSey', NULL, 0, NULL, NULL, NULL, NULL, '2025-10-13 19:45:49', NULL, NULL),
(2476, 'Catalina', 'Irarrazaval', '', '0000-00-00', 'cirarrazaval@colegiolosandes.cl', '', 2, '$2y$10$Z0Tf3db2X5T1Je2LfUtLtOS2ED7hB4mHaoMfw/uBHLmDKPtTqfUTy', NULL, 0, 10, NULL, 'Pendiente', '', '2026-03-12 14:02:56', '', NULL),
(2483, 'CRISTIAN', 'Espinoza', 'MICHEL', '0000-00-00', 'cm.jorquerag@gmail.com', '', 2, NULL, NULL, 0, 10, NULL, 'Pendiente', '', '2026-04-07 23:26:56', '12f0a1ed80e9b196e09d569a8b900374', NULL),
(2484, 'CRISTIAN', 'jorquera', 'MICHEL', '0000-00-00', 'cr.jorquerag@duocuc.cl', '', 2, '$2y$10$7Zb/hFKMPCrk67ojtDtAfuqVAhdJBhDFpZUz67o2qBiNQwODeIxqO', NULL, 0, 10, NULL, 'Activo', '', '2026-04-08 01:03:02', '', NULL),
(2485, 'Alejandro', 'Rojas', '', '0000-00-00', 'alejandro.rojas.sch@gmail.com', '', 1, NULL, NULL, 0, 1, NULL, 'Pendiente', '', '2026-04-08 19:40:09', 'dc87c5727df5550524763ae279b6d273', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_colegio`
--

CREATE TABLE `usuario_colegio` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_colegio` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = activo | 0 = inactivo',
  `fecha_asignacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_colegio`
--

INSERT INTO `usuario_colegio` (`id`, `id_usuario`, `id_colegio`, `id_perfil`, `estado`, `fecha_asignacion`) VALUES
(1, 1, 15, 1, 1, '2026-01-08 10:20:26'),
(2, 2, 15, 1, 1, '2026-01-08 10:20:26'),
(3, 3, 15, 1, 1, '2026-01-08 10:20:26'),
(4, 4, 15, 1, 1, '2026-01-08 10:20:26'),
(5, 5, 15, 1, 1, '2026-01-08 10:20:26'),
(6, 6, 15, 1, 1, '2026-01-08 10:20:26'),
(7, 7, 15, 1, 1, '2026-01-08 10:20:26'),
(8, 8, 15, 1, 1, '2026-01-08 10:20:26'),
(9, 9, 15, 1, 1, '2026-01-08 10:20:26'),
(10, 10, 15, 1, 1, '2026-01-08 10:20:26'),
(11, 11, 15, 1, 1, '2026-01-08 10:20:26'),
(12, 12, 15, 1, 1, '2026-01-08 10:20:26'),
(13, 13, 15, 1, 1, '2026-01-08 10:20:26'),
(14, 14, 15, 1, 1, '2026-01-08 10:20:26'),
(15, 15, 15, 1, 1, '2026-01-08 10:20:26'),
(16, 16, 15, 1, 1, '2026-01-08 10:20:26'),
(17, 17, 15, 1, 1, '2026-01-08 10:20:26'),
(18, 18, 15, 1, 1, '2026-01-08 10:20:26'),
(19, 19, 15, 1, 1, '2026-01-08 10:20:26'),
(20, 20, 15, 1, 1, '2026-01-08 10:20:26'),
(21, 21, 15, 1, 1, '2026-01-08 10:20:26'),
(22, 22, 15, 1, 1, '2026-01-08 10:20:26'),
(23, 23, 15, 1, 1, '2026-01-08 10:20:26'),
(24, 24, 15, 1, 1, '2026-01-08 10:20:26'),
(25, 25, 15, 1, 1, '2026-01-08 10:20:26'),
(26, 26, 15, 1, 1, '2026-01-08 10:20:26'),
(29, 38, 15, 1, 1, '2026-01-08 10:20:26'),
(30, 39, 15, 1, 1, '2026-01-08 10:20:26'),
(31, 40, 15, 1, 1, '2026-01-08 10:20:26'),
(32, 41, 15, 1, 1, '2026-01-08 10:20:26'),
(33, 42, 15, 1, 1, '2026-01-08 10:20:26'),
(34, 43, 15, 1, 1, '2026-01-08 10:20:26'),
(35, 44, 15, 1, 1, '2026-01-08 10:20:26'),
(36, 45, 15, 1, 1, '2026-01-08 10:20:26'),
(37, 46, 15, 1, 1, '2026-01-08 10:20:26'),
(38, 30, 11, 1, 1, '2026-01-08 10:26:11'),
(40, 32, 11, 1, 1, '2026-01-08 10:26:11'),
(41, 48, 1, 1, 1, '2026-01-08 10:26:11'),
(42, 49, 9, 1, 1, '2026-01-08 10:26:11'),
(43, 34, 12, 1, 1, '2026-01-08 10:26:11'),
(44, 32, 1, 1, 1, '2026-01-08 10:26:11'),
(45, 28, 8, 1, 1, '2026-01-08 10:26:11'),
(46, 2476, 1, 1, 1, '2026-03-12 11:02:56'),
(53, 2483, 10, 1, 1, '2026-04-07 19:26:56'),
(54, 2484, 8, 1, 1, '2026-04-07 21:03:02'),
(55, 2485, 15, 1, 1, '2026-04-08 15:40:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_perfil`
--

INSERT INTO `usuario_perfil` (`id_usuario`, `id_perfil`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(42, 2),
(42, 3),
(43, 1),
(43, 3),
(44, 1),
(45, 1),
(46, 1),
(2476, 1),
(2483, 1),
(2484, 1),
(2485, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_adjuntos_ticket`
--
ALTER TABLE `archivos_adjuntos_ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ticket` (`id_ticket`);

--
-- Indices de la tabla `area_trabajo`
--
ALTER TABLE `area_trabajo`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `arquitectura_alumnos`
--
ALTER TABLE `arquitectura_alumnos`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `arquitectura_apoderado`
--
ALTER TABLE `arquitectura_apoderado`
  ADD PRIMARY KEY (`id_apoderado`);

--
-- Indices de la tabla `arquitectura_retiro`
--
ALTER TABLE `arquitectura_retiro`
  ADD PRIMARY KEY (`id_retiro`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_apoderado` (`id_apoderado`);

--
-- Indices de la tabla `avance_tecnicos`
--
ALTER TABLE `avance_tecnicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_ticket_2` (`id_ticket`);

--
-- Indices de la tabla `beneficios_destacados`
--
ALTER TABLE `beneficios_destacados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `beneficios_principales`
--
ALTER TABLE `beneficios_principales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario_eventos`
--
ALTER TABLE `calendario_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_calendario_usuario_inicio` (`id_usuario`,`fecha_inicio`),
  ADD KEY `idx_calendario_rango` (`fecha_inicio`,`fecha_fin`);

--
-- Indices de la tabla `calificacion_ticket`
--
ALTER TABLE `calificacion_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificacion_tickett`
--
ALTER TABLE `calificacion_tickett`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calificacion_ticket` (`id_ticket`);

--
-- Indices de la tabla `capsulas`
--
ALTER TABLE `capsulas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_de_ticket`
--
ALTER TABLE `categoria_de_ticket`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `categoria_herramienta_catalogo`
--
ALTER TABLE `categoria_herramienta_catalogo`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre_categoria` (`nombre_categoria`);

--
-- Indices de la tabla `categoria_tecnico`
--
ALTER TABLE `categoria_tecnico`
  ADD PRIMARY KEY (`id_categoria_tecnico`),
  ADD KEY `id_tecnico` (`id_tecnico`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_categoria_2` (`id_categoria`);

--
-- Indices de la tabla `codigos_qr`
--
ALTER TABLE `codigos_qr`
  ADD PRIMARY KEY (`id_qr`),
  ADD KEY `generado_por` (`generado_por`);

--
-- Indices de la tabla `colegio`
--
ALTER TABLE `colegio`
  ADD PRIMARY KEY (`id_colegio`);

--
-- Indices de la tabla `comentarios_ticket`
--
ALTER TABLE `comentarios_ticket`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_tecnico` (`id_tecnico`),
  ADD KEY `fk_comentarios_ticket` (`id_ticket`);

--
-- Indices de la tabla `contenedor`
--
ALTER TABLE `contenedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contenedores_layout`
--
ALTER TABLE `contenedores_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`id_convenio`),
  ADD KEY `fk_convenio_tipo` (`id_tipo`);

--
-- Indices de la tabla `conversacion`
--
ALTER TABLE `conversacion`
  ADD PRIMARY KEY (`id_conversacion`),
  ADD KEY `id_de` (`id_de`),
  ADD KEY `id_para` (`id_para`);

--
-- Indices de la tabla `conversaciones`
--
ALTER TABLE `conversaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `curso_codigos_qr`
--
ALTER TABLE `curso_codigos_qr`
  ADD PRIMARY KEY (`id_qr`),
  ADD KEY `generado_por` (`generado_por`);

--
-- Indices de la tabla `denuncias_acoso`
--
ALTER TABLE `denuncias_acoso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD UNIQUE KEY `ux_equipos_numero_serie` (`numero_serie`),
  ADD KEY `idx_equipos_asignado` (`id_usuario_asignado`),
  ADD KEY `idx_equipos_colegio` (`id_colegio`),
  ADD KEY `idx_equipos_creado_por` (`id_usuario`);

--
-- Indices de la tabla `equipos_compra`
--
ALTER TABLE `equipos_compra`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `equipo_almacenamiento`
--
ALTER TABLE `equipo_almacenamiento`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `equipo_fotos`
--
ALTER TABLE `equipo_fotos`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `idx_equipo_fotos_equipo` (`id_equipo`);

--
-- Indices de la tabla `equipo_memoria`
--
ALTER TABLE `equipo_memoria`
  ADD PRIMARY KEY (`id_memoria`),
  ADD KEY `id_equipo` (`id_equipo`);

--
-- Indices de la tabla `equipo_monitor`
--
ALTER TABLE `equipo_monitor`
  ADD PRIMARY KEY (`id_monitor`),
  ADD KEY `id_equipo` (`id_equipo`);

--
-- Indices de la tabla `equipo_procesador`
--
ALTER TABLE `equipo_procesador`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `equipo_software`
--
ALTER TABLE `equipo_software`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `estados_ticket`
--
ALTER TABLE `estados_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_calificacion_ticket`
--
ALTER TABLE `estado_calificacion_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_herramienta`
--
ALTER TABLE `estado_herramienta`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_eventos_fecha_inicio` (`fecha_inicio`),
  ADD KEY `idx_eventos_fecha_fin` (`fecha_fin`),
  ADD KEY `idx_eventos_responsable` (`responsable_id`),
  ADD KEY `idx_eventos_estado` (`estado`),
  ADD KEY `idx_eventos_tipo` (`tipo_evento`),
  ADD KEY `idx_eventos_eliminado` (`eliminado`);

--
-- Indices de la tabla `eventos_historial`
--
ALTER TABLE `eventos_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_historial_evento` (`id_evento`),
  ADD KEY `idx_historial_usuario` (`id_usuario`);

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`id_herramienta`),
  ADD UNIQUE KEY `uq_herramientas_numero_serie` (`numero_serie`),
  ADD UNIQUE KEY `uq_herramientas_qr_code` (`qr_code`),
  ADD KEY `idx_herramientas_colegio` (`id_colegio`),
  ADD KEY `idx_herramientas_usuario` (`id_usuario`),
  ADD KEY `idx_herramientas_usuario_asignado` (`id_usuario_asignado`),
  ADD KEY `idx_herramientas_estado` (`id_estado`),
  ADD KEY `idx_herramientas_categoria` (`categoria`);

--
-- Indices de la tabla `herramienta_compra`
--
ALTER TABLE `herramienta_compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD UNIQUE KEY `uq_herramienta_compra_herramienta` (`id_herramienta`),
  ADD KEY `idx_herramienta_compra_fecha` (`fecha_compra`);

--
-- Indices de la tabla `herramienta_detalle`
--
ALTER TABLE `herramienta_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD UNIQUE KEY `uq_herramienta_detalle_herramienta` (`id_herramienta`);

--
-- Indices de la tabla `herramienta_fotos`
--
ALTER TABLE `herramienta_fotos`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `idx_herramienta_fotos_herramienta` (`id_herramienta`),
  ADD KEY `idx_herramienta_fotos_principal` (`id_herramienta`,`principal`);

--
-- Indices de la tabla `herramienta_historial`
--
ALTER TABLE `herramienta_historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_herramienta_historial_herramienta` (`id_herramienta`),
  ADD KEY `idx_herramienta_historial_usuario` (`id_usuario`),
  ADD KEY `idx_herramienta_historial_fecha` (`fecha`);

--
-- Indices de la tabla `herramienta_mantenciones`
--
ALTER TABLE `herramienta_mantenciones`
  ADD PRIMARY KEY (`id_mantencion`),
  ADD KEY `idx_herramienta_mantenciones_herramienta` (`id_herramienta`),
  ADD KEY `idx_herramienta_mantenciones_fecha` (`fecha_mantencion`),
  ADD KEY `idx_herramienta_mantenciones_proxima` (`proxima_fecha`);

--
-- Indices de la tabla `herramienta_prestamos`
--
ALTER TABLE `herramienta_prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `idx_herramienta_prestamos_herramienta` (`id_herramienta`),
  ADD KEY `idx_herramienta_prestamos_salida` (`fecha_salida`),
  ADD KEY `idx_herramienta_prestamos_estado` (`estado_prestamo`);

--
-- Indices de la tabla `inventario_pc`
--
ALTER TABLE `inventario_pc`
  ADD PRIMARY KEY (`id_pc`);

--
-- Indices de la tabla `inventario_software_datos_sensibles`
--
ALTER TABLE `inventario_software_datos_sensibles`
  ADD PRIMARY KEY (`id_dato_sensible`),
  ADD UNIQUE KEY `uq_dato_sensible_nombre` (`nombre`);

--
-- Indices de la tabla `inventario_software_tipo_usuario`
--
ALTER TABLE `inventario_software_tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `keep_notas`
--
ALTER TABLE `keep_notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `log_eliminacion_tickets`
--
ALTER TABLE `log_eliminacion_tickets`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_ticket` (`id_ticket`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_fecha` (`fecha`);

--
-- Indices de la tabla `log_sesiones`
--
ALTER TABLE `log_sesiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `log_sesiones_usuario`
--
ALTER TABLE `log_sesiones_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`para`),
  ADD KEY `id_conversacion` (`id_conversacion`);

--
-- Indices de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_1`
--
ALTER TABLE `menu_1`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `menu_1_sub`
--
ALTER TABLE `menu_1_sub`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `idx_menu_1_sub_id_menu` (`id_menu`);

--
-- Indices de la tabla `menu_h`
--
ALTER TABLE `menu_h`
  ADD PRIMARY KEY (`id_menu_h`),
  ADD KEY `idx_menu_h_orden` (`orden`),
  ADD KEY `idx_menu_h_activo` (`activo`);

--
-- Indices de la tabla `menu_principal`
--
ALTER TABLE `menu_principal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `otros_dispositivos`
--
ALTER TABLE `otros_dispositivos`
  ADD PRIMARY KEY (`id_dispositivo`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_menu_1`
--
ALTER TABLE `permisos_menu_1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu1` (`id_menu1`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tipo_permiso` (`id_tipo_permiso`),
  ADD KEY `idx_permisos_menu_1_id_usuario` (`id_usuario`),
  ADD KEY `idx_permisos_menu_1_id_menu1` (`id_menu1`);

--
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proceso_tickets`
--
ALTER TABLE `proceso_tickets`
  ADD PRIMARY KEY (`id_proceso`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `quiz_preguntas`
--
ALTER TABLE `quiz_preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `quiz_resultados`
--
ALTER TABLE `quiz_resultados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `razones_bloqueo_usuario`
--
ALTER TABLE `razones_bloqueo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reactivacion_ticket`
--
ALTER TABLE `reactivacion_ticket`
  ADD PRIMARY KEY (`id_reactivacion`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Indices de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `respuestas_mensajes`
--
ALTER TABLE `respuestas_mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mensaje_origen` (`id_mensaje_origen`),
  ADD KEY `para` (`para`),
  ADD KEY `de` (`de`);

--
-- Indices de la tabla `seduc_calendario`
--
ALTER TABLE `seduc_calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seduc_carga_excel`
--
ALTER TABLE `seduc_carga_excel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seduc_funcionarios`
--
ALTER TABLE `seduc_funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sitios_web_catalogo`
--
ALTER TABLE `sitios_web_catalogo`
  ADD PRIMARY KEY (`id_sitio`),
  ADD KEY `idx_sitio_colegio` (`id_colegio`),
  ADD KEY `idx_sitio_responsable` (`id_usuario_responsable`);

--
-- Indices de la tabla `software_catalogo`
--
ALTER TABLE `software_catalogo`
  ADD PRIMARY KEY (`id_software`),
  ADD KEY `idx_software_colegio` (`id_colegio`),
  ADD KEY `idx_software_responsable` (`id_usuario_responsable`);

--
-- Indices de la tabla `software_datos_almacenamiento`
--
ALTER TABLE `software_datos_almacenamiento`
  ADD PRIMARY KEY (`id_dato`),
  ADD KEY `idx_dato_software` (`id_software`);

--
-- Indices de la tabla `software_datos_sensibles_rel`
--
ALTER TABLE `software_datos_sensibles_rel`
  ADD PRIMARY KEY (`id_relacion`),
  ADD UNIQUE KEY `uq_software_dato_sensible` (`id_software`,`id_dato_sensible`),
  ADD KEY `idx_rel_dato_sensible` (`id_dato_sensible`);

--
-- Indices de la tabla `software_historial`
--
ALTER TABLE `software_historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_software` (`id_software`);

--
-- Indices de la tabla `software_tipo_usuario_rel`
--
ALTER TABLE `software_tipo_usuario_rel`
  ADD PRIMARY KEY (`id_relacion`),
  ADD UNIQUE KEY `uq_software_tipo_usuario` (`id_software`,`id_tipo_usuario`),
  ADD KEY `idx_rel_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `idx_rel_tipo_software` (`id_software`);

--
-- Indices de la tabla `tabla_conversacion`
--
ALTER TABLE `tabla_conversacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Indices de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`id_tecnico`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD UNIQUE KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_prioridad` (`id_prioridad`),
  ADD KEY `id_asignacion` (`id_tecnico`);

--
-- Indices de la tabla `ticket_conversaciones`
--
ALTER TABLE `ticket_conversaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conversaciones_ticket` (`id_ticket`);

--
-- Indices de la tabla `tipos_dispositivos`
--
ALTER TABLE `tipos_dispositivos`
  ADD PRIMARY KEY (`id_tipo_dispositivo`);

--
-- Indices de la tabla `tipo_convenio`
--
ALTER TABLE `tipo_convenio`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuarios_id_area_trabajo` (`id_area_trabajo`);

--
-- Indices de la tabla `usuario_colegio`
--
ALTER TABLE `usuario_colegio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_usuario_colegio` (`id_usuario`,`id_colegio`,`id_perfil`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_colegio` (`id_colegio`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_usuario_colegio_id_usuario` (`id_usuario`),
  ADD KEY `idx_usuario_colegio_id_colegio` (`id_colegio`);

--
-- Indices de la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`id_usuario`,`id_perfil`),
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `idx_usuario_perfil_id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_adjuntos_ticket`
--
ALTER TABLE `archivos_adjuntos_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de la tabla `area_trabajo`
--
ALTER TABLE `area_trabajo`
  MODIFY `id_area` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `arquitectura_alumnos`
--
ALTER TABLE `arquitectura_alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `arquitectura_apoderado`
--
ALTER TABLE `arquitectura_apoderado`
  MODIFY `id_apoderado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `arquitectura_retiro`
--
ALTER TABLE `arquitectura_retiro`
  MODIFY `id_retiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `avance_tecnicos`
--
ALTER TABLE `avance_tecnicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- AUTO_INCREMENT de la tabla `beneficios_destacados`
--
ALTER TABLE `beneficios_destacados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `beneficios_principales`
--
ALTER TABLE `beneficios_principales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `calendario_eventos`
--
ALTER TABLE `calendario_eventos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificacion_ticket`
--
ALTER TABLE `calificacion_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT de la tabla `calificacion_tickett`
--
ALTER TABLE `calificacion_tickett`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `capsulas`
--
ALTER TABLE `capsulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria_de_ticket`
--
ALTER TABLE `categoria_de_ticket`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `categoria_herramienta_catalogo`
--
ALTER TABLE `categoria_herramienta_catalogo`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categoria_tecnico`
--
ALTER TABLE `categoria_tecnico`
  MODIFY `id_categoria_tecnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `codigos_qr`
--
ALTER TABLE `codigos_qr`
  MODIFY `id_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `colegio`
--
ALTER TABLE `colegio`
  MODIFY `id_colegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `comentarios_ticket`
--
ALTER TABLE `comentarios_ticket`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `contenedor`
--
ALTER TABLE `contenedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT de la tabla `contenedores_layout`
--
ALTER TABLE `contenedores_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `convenios`
--
ALTER TABLE `convenios`
  MODIFY `id_convenio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `conversacion`
--
ALTER TABLE `conversacion`
  MODIFY `id_conversacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `conversaciones`
--
ALTER TABLE `conversaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `curso_codigos_qr`
--
ALTER TABLE `curso_codigos_qr`
  MODIFY `id_qr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `denuncias_acoso`
--
ALTER TABLE `denuncias_acoso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `equipos_compra`
--
ALTER TABLE `equipos_compra`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `equipo_almacenamiento`
--
ALTER TABLE `equipo_almacenamiento`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `equipo_fotos`
--
ALTER TABLE `equipo_fotos`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `equipo_memoria`
--
ALTER TABLE `equipo_memoria`
  MODIFY `id_memoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT de la tabla `equipo_monitor`
--
ALTER TABLE `equipo_monitor`
  MODIFY `id_monitor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT de la tabla `equipo_procesador`
--
ALTER TABLE `equipo_procesador`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `equipo_software`
--
ALTER TABLE `equipo_software`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `estados_ticket`
--
ALTER TABLE `estados_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estado_calificacion_ticket`
--
ALTER TABLE `estado_calificacion_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `eventos_historial`
--
ALTER TABLE `eventos_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `id_herramienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `herramienta_compra`
--
ALTER TABLE `herramienta_compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `herramienta_detalle`
--
ALTER TABLE `herramienta_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `herramienta_fotos`
--
ALTER TABLE `herramienta_fotos`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `herramienta_historial`
--
ALTER TABLE `herramienta_historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `herramienta_mantenciones`
--
ALTER TABLE `herramienta_mantenciones`
  MODIFY `id_mantencion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `herramienta_prestamos`
--
ALTER TABLE `herramienta_prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario_pc`
--
ALTER TABLE `inventario_pc`
  MODIFY `id_pc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `inventario_software_datos_sensibles`
--
ALTER TABLE `inventario_software_datos_sensibles`
  MODIFY `id_dato_sensible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `inventario_software_tipo_usuario`
--
ALTER TABLE `inventario_software_tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `keep_notas`
--
ALTER TABLE `keep_notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `log_eliminacion_tickets`
--
ALTER TABLE `log_eliminacion_tickets`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `log_sesiones`
--
ALTER TABLE `log_sesiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_sesiones_usuario`
--
ALTER TABLE `log_sesiones_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menu_1`
--
ALTER TABLE `menu_1`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `menu_1_sub`
--
ALTER TABLE `menu_1_sub`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `menu_h`
--
ALTER TABLE `menu_h`
  MODIFY `id_menu_h` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `menu_principal`
--
ALTER TABLE `menu_principal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `otros_dispositivos`
--
ALTER TABLE `otros_dispositivos`
  MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos_menu_1`
--
ALTER TABLE `permisos_menu_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=788;

--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proceso_tickets`
--
ALTER TABLE `proceso_tickets`
  MODIFY `id_proceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT de la tabla `quiz_preguntas`
--
ALTER TABLE `quiz_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `quiz_resultados`
--
ALTER TABLE `quiz_resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `razones_bloqueo_usuario`
--
ALTER TABLE `razones_bloqueo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reactivacion_ticket`
--
ALTER TABLE `reactivacion_ticket`
  MODIFY `id_reactivacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `respuestas_mensajes`
--
ALTER TABLE `respuestas_mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `seduc_calendario`
--
ALTER TABLE `seduc_calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seduc_carga_excel`
--
ALTER TABLE `seduc_carga_excel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seduc_funcionarios`
--
ALTER TABLE `seduc_funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sitios_web_catalogo`
--
ALTER TABLE `sitios_web_catalogo`
  MODIFY `id_sitio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `software_catalogo`
--
ALTER TABLE `software_catalogo`
  MODIFY `id_software` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `software_datos_almacenamiento`
--
ALTER TABLE `software_datos_almacenamiento`
  MODIFY `id_dato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `software_datos_sensibles_rel`
--
ALTER TABLE `software_datos_sensibles_rel`
  MODIFY `id_relacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `software_historial`
--
ALTER TABLE `software_historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `software_tipo_usuario_rel`
--
ALTER TABLE `software_tipo_usuario_rel`
  MODIFY `id_relacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tabla_conversacion`
--
ALTER TABLE `tabla_conversacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `id_tecnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT de la tabla `ticket_conversaciones`
--
ALTER TABLE `ticket_conversaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de la tabla `tipos_dispositivos`
--
ALTER TABLE `tipos_dispositivos`
  MODIFY `id_tipo_dispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_convenio`
--
ALTER TABLE `tipo_convenio`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2486;

--
-- AUTO_INCREMENT de la tabla `usuario_colegio`
--
ALTER TABLE `usuario_colegio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convenios`
--
ALTER TABLE `convenios`
  ADD CONSTRAINT `fk_convenio_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_convenio` (`id_tipo`);

--
-- Filtros para la tabla `equipos_compra`
--
ALTER TABLE `equipos_compra`
  ADD CONSTRAINT `equipos_compra_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipo_memoria`
--
ALTER TABLE `equipo_memoria`
  ADD CONSTRAINT `equipo_memoria_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipo_monitor`
--
ALTER TABLE `equipo_monitor`
  ADD CONSTRAINT `equipo_monitor_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_eventos_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `log_sesiones`
--
ALTER TABLE `log_sesiones`
  ADD CONSTRAINT `log_sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `menu_1_sub`
--
ALTER TABLE `menu_1_sub`
  ADD CONSTRAINT `fk_ms_m1_20260408_01` FOREIGN KEY (`id_menu`) REFERENCES `menu_1` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos_menu_1`
--
ALTER TABLE `permisos_menu_1`
  ADD CONSTRAINT `fk_permisos_menu_1_menu1_final` FOREIGN KEY (`id_menu1`) REFERENCES `menu_1` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_permisos_menu_1_usuario_final` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `software_datos_almacenamiento`
--
ALTER TABLE `software_datos_almacenamiento`
  ADD CONSTRAINT `fk_dato_software` FOREIGN KEY (`id_software`) REFERENCES `software_catalogo` (`id_software`) ON DELETE CASCADE;

--
-- Filtros para la tabla `software_datos_sensibles_rel`
--
ALTER TABLE `software_datos_sensibles_rel`
  ADD CONSTRAINT `fk_rel_dato_sensible` FOREIGN KEY (`id_dato_sensible`) REFERENCES `inventario_software_datos_sensibles` (`id_dato_sensible`),
  ADD CONSTRAINT `fk_rel_software` FOREIGN KEY (`id_software`) REFERENCES `software_catalogo` (`id_software`) ON DELETE CASCADE;

--
-- Filtros para la tabla `software_historial`
--
ALTER TABLE `software_historial`
  ADD CONSTRAINT `fk_historial_software` FOREIGN KEY (`id_software`) REFERENCES `software_catalogo` (`id_software`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_area_trabajo` FOREIGN KEY (`id_area_trabajo`) REFERENCES `area_trabajo` (`id_area`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_colegio`
--
ALTER TABLE `usuario_colegio`
  ADD CONSTRAINT `fk_usuario_colegio_colegio` FOREIGN KEY (`id_colegio`) REFERENCES `colegio` (`id_colegio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD CONSTRAINT `fk_usuario_perfil_usuario_final` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
