-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2019 a las 04:08:12
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `orange`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rut` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_2` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carnet` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `carnet_expiration` date DEFAULT NULL,
  `type` enum('persona','empresario','pyme','compañia','corporacion') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comuna` int(10) UNSIGNED DEFAULT NULL,
  `class` enum('normal','bci') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `rut`, `name`, `email`, `last_name`, `last_name_2`, `phone`, `address`, `carnet`, `birthday`, `carnet_expiration`, `type`, `comuna`, `class`, `created_at`, `updated_at`) VALUES
(1, '27.201.276', 'Hector', NULL, 'Ferrer', 'Cabrera', '584126992473', 'Guayana, la churuata', '27201276', '2008-03-28', '2008-03-12', NULL, NULL, NULL, NULL, NULL),
(2, '19.443.612-2', 'Parra', NULL, 'Valentina', 'Alicia', '584126992473', 'Chile', '194436122', '2008-03-28', '2008-03-28', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sell` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communes`
--

CREATE TABLE `communes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `communes`
--

INSERT INTO `communes` (`id`, `name`, `region_id`, `created_at`, `updated_at`) VALUES
(1, 'Arica', 1, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(2, 'Camarones', 1, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(3, 'General Lagos', 1, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(4, 'Putre', 1, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(5, 'Alto Hospicio', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(6, 'Iquique', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(7, 'Camiña', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(8, 'Colchane', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(9, 'Huara', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(10, 'Pica', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(11, 'Pozo Almonte', 2, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(12, 'Antofagasta', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(13, 'Mejillones', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(14, 'Sierra Gorda', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(15, 'Taltal', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(16, 'Calama', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(17, 'Ollague', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(18, 'San Pedro de Atacama', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(19, 'María Elena', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(20, 'Tocopilla', 3, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(21, 'Chañaral', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(22, 'Diego de Almagro', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(23, 'Caldera', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(24, 'Copiapó', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(25, 'Tierra Amarilla', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(26, 'Alto del Carmen', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(27, 'Freirina', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(28, 'Huasco', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(29, 'Vallenar', 4, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(30, 'Canela', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(31, 'Illapel', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(32, 'Los Vilos', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(33, 'Salamanca', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(34, 'Andacollo', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(35, 'Coquimbo', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(36, 'La Higuera', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(37, 'La Serena', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(38, 'Paihuaco', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(39, 'Vicuña', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(40, 'Combarbalá', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(41, 'Monte Patria', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(42, 'Ovalle', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(43, 'Punitaqui', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(44, 'Río Hurtado', 5, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(45, 'Isla de Pascua', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(46, 'Calle Larga', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(47, 'Los Andes', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(48, 'Rinconada', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(49, 'San Esteban', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(50, 'La Ligua', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(51, 'Papudo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(52, 'Petorca', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(53, 'Zapallar', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(54, 'Hijuelas', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(55, 'La Calera', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(56, 'La Cruz', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(57, 'Limache', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(58, 'Nogales', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(59, 'Olmué', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(60, 'Quillota', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(61, 'Algarrobo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(62, 'Cartagena', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(63, 'El Quisco', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(64, 'El Tabo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(65, 'San Antonio', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(66, 'Santo Domingo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(67, 'Catemu', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(68, 'Llaillay', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(69, 'Panquehue', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(70, 'Putaendo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(71, 'San Felipe', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(72, 'Santa María', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(73, 'Casablanca', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(74, 'Concón', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(75, 'Juan Fernández', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(76, 'Puchuncaví', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(77, 'Quilpué', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(78, 'Quintero', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(79, 'Valparaíso', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(80, 'Villa Alemana', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(81, 'Viña del Mar', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(82, 'Colina', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(83, 'Lampa', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(84, 'Tiltil', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(85, 'Pirque', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(86, 'Puente Alto', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(87, 'San José de Maipo', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(88, 'Buin', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(89, 'Calera de Tango', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(90, 'Paine', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(91, 'San Bernardo', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(92, 'Alhué', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(93, 'Curacaví', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(94, 'María Pinto', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(95, 'Melipilla', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(96, 'San Pedro', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(97, 'Cerrillos', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(98, 'Cerro Navia', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(99, 'Conchalí', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(100, 'El Bosque', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(101, 'Estación Central', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(102, 'Huechuraba', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(103, 'Independencia', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(104, 'La Cisterna', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(105, 'La Granja', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(106, 'La Florida', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(107, 'La Pintana', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(108, 'La Reina', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(109, 'Las Condes', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(110, 'Lo Barnechea', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(111, 'Lo Espejo', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(112, 'Lo Prado', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(113, 'Macul', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(114, 'Maipú', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(115, 'Ñuñoa', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(116, 'Pedro Aguirre Cerda', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(117, 'Peñalolén', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(118, 'Providencia', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(119, 'Pudahuel', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(120, 'Quilicura', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(121, 'Quinta Normal', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(122, 'Recoleta', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(123, 'Renca', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(124, 'San Miguel', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(125, 'San Joaquín', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(126, 'San Ramón', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(127, 'Santiago', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(128, 'Vitacura', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(129, 'El Monte', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(130, 'Isla de Maipo', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(131, 'Padre Hurtado', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(132, 'Peñaflor', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(133, 'Talagante', 7, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(134, 'Codegua', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(135, 'Coínco', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(136, 'Coltauco', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(137, 'Doñihue', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(138, 'Graneros', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(139, 'Las Cabras', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(140, 'Machalí', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(141, 'Malloa', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(142, 'Mostazal', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(143, 'Olivar', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(144, 'Peumo', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(145, 'Pichidegua', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(146, 'Quinta de Tilcoco', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(147, 'Rancagua', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(148, 'Rengo', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(149, 'Requínoa', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(150, 'San Vicente de Tagua Tagua', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(151, 'La Estrella', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(152, 'Litueche', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(153, 'Marchihue', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(154, 'Navidad', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(155, 'Peredones', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(156, 'Pichilemu', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(157, 'Chépica', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(158, 'Chimbarongo', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(159, 'Lolol', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(160, 'Nancagua', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(161, 'Palmilla', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(162, 'Peralillo', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(163, 'Placilla', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(164, 'Pumanque', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(165, 'San Fernando', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(166, 'Santa Cruz', 8, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(167, 'Cauquenes', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(168, 'Chanco', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(169, 'Pelluhue', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(170, 'Curicó', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(171, 'Hualañé', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(172, 'Licantén', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(173, 'Molina', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(174, 'Rauco', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(175, 'Romeral', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(176, 'Sagrada Familia', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(177, 'Teno', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(178, 'Vichuquén', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(179, 'Colbún', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(180, 'Linares', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(181, 'Longaví', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(182, 'Parral', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(183, 'Retiro', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(184, 'San Javier', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(185, 'Villa Alegre', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(186, 'Yerbas Buenas', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(187, 'Constitución', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(188, 'Curepto', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(189, 'Empedrado', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(190, 'Maule', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(191, 'Pelarco', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(192, 'Pencahue', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(193, 'Río Claro', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(194, 'San Clemente', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(195, 'San Rafael', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(196, 'Talca', 9, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(197, 'Arauco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(198, 'Cañete', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(199, 'Contulmo', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(200, 'Curanilahue', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(201, 'Lebu', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(202, 'Los Álamos', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(203, 'Tirúa', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(204, 'Alto Biobío', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(205, 'Antuco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(206, 'Cabrero', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(207, 'Laja', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(208, 'Los Ángeles', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(209, 'Mulchén', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(210, 'Nacimiento', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(211, 'Negrete', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(212, 'Quilaco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(213, 'Quilleco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(214, 'San Rosendo', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(215, 'Santa Bárbara', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(216, 'Tucapel', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(217, 'Yumbel', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(218, 'Chiguayante', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(219, 'Concepción', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(220, 'Coronel', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(221, 'Florida', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(222, 'Hualpén', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(223, 'Hualqui', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(224, 'Lota', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(225, 'Penco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(226, 'San Pedro de La Paz', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(227, 'Santa Juana', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(228, 'Talcahuano', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(229, 'Tomé', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(230, 'Bulnes', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(231, 'Chillán', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(232, 'Chillán Viejo', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(233, 'Cobquecura', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(234, 'Coelemu', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(235, 'Coihueco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(236, 'El Carmen', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(237, 'Ninhue', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(238, 'Ñiquen', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(239, 'Pemuco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(240, 'Pinto', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(241, 'Portezuelo', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(242, 'Quillón', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(243, 'Quirihue', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(244, 'Ránquil', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(245, 'San Carlos', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(246, 'San Fabián', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(247, 'San Ignacio', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(248, 'San Nicolás', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(249, 'Treguaco', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(250, 'Yungay', 10, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(251, 'Carahue', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(252, 'Cholchol', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(253, 'Cunco', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(254, 'Curarrehue', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(255, 'Freire', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(256, 'Galvarino', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(257, 'Gorbea', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(258, 'Lautaro', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(259, 'Loncoche', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(260, 'Melipeuco', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(261, 'Nueva Imperial', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(262, 'Padre Las Casas', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(263, 'Perquenco', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(264, 'Pitrufquén', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(265, 'Pucón', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(266, 'Saavedra', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(267, 'Temuco', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(268, 'Teodoro Schmidt', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(269, 'Toltén', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(270, 'Vilcún', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(271, 'Villarrica', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(272, 'Angol', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(273, 'Collipulli', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(274, 'Curacautín', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(275, 'Ercilla', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(276, 'Lonquimay', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(277, 'Los Sauces', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(278, 'Lumaco', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(279, 'Purén', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(280, 'Renaico', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(281, 'Traiguén', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(282, 'Victoria', 11, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(283, 'Corral', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(284, 'Lanco', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(285, 'Los Lagos', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(286, 'Máfil', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(287, 'Mariquina', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(288, 'Paillaco', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(289, 'Panguipulli', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(290, 'Valdivia', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(291, 'Futrono', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(292, 'La Unión', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(293, 'Lago Ranco', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(294, 'Río Bueno', 12, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(295, 'Ancud', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(296, 'Castro', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(297, 'Chonchi', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(298, 'Curaco de Vélez', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(299, 'Dalcahue', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(300, 'Puqueldón', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(301, 'Queilén', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(302, 'Quemchi', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(303, 'Quellón', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(304, 'Quinchao', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(305, 'Calbuco', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(306, 'Cochamó', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(307, 'Fresia', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(308, 'Frutillar', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(309, 'Llanquihue', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(310, 'Los Muermos', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(311, 'Maullín', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(312, 'Puerto Montt', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(313, 'Puerto Varas', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(314, 'Osorno', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(315, 'Puero Octay', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(316, 'Purranque', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(317, 'Puyehue', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(318, 'Río Negro', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(319, 'San Juan de la Costa', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(320, 'San Pablo', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(321, 'Chaitén', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(322, 'Futaleufú', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(323, 'Hualaihué', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(324, 'Palena', 13, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(325, 'Aisén', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(326, 'Cisnes', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(327, 'Guaitecas', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(328, 'Cochrane', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(329, 'O\'higgins', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(330, 'Tortel', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(331, 'Coihaique', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(332, 'Lago Verde', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(333, 'Chile Chico', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(334, 'Río Ibáñez', 14, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(335, 'Antártica', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(336, 'Cabo de Hornos', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(337, 'Laguna Blanca', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(338, 'Punta Arenas', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(339, 'Río Verde', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(340, 'San Gregorio', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(341, 'Porvenir', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(342, 'Primavera', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(343, 'Timaukel', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(344, 'Natales', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(345, 'Torres del Paine', 15, '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(346, 'Cabildo', 6, '2019-08-31 02:07:33', '2019-08-31 02:07:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description_html` text COLLATE utf8mb4_unicode_ci,
  `mark` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `details` text COLLATE utf8mb4_unicode_ci,
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `exception` tinyint(1) NOT NULL DEFAULT '0',
  `is_html` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipments`
--

INSERT INTO `equipments` (`id`, `code`, `name`, `description`, `image`, `description_html`, `mark`, `price`, `details`, `trash`, `active`, `exception`, `is_html`, `created_at`, `updated_at`) VALUES
(1, 'one_plus_7t', 'One Plus 7T', 'OnePlus 7 Pro Dual Sim Factory GM1917 8 GB + 256 GB Nebula Blue (ATT, Verizon, Tmobile)', 'uploads/devices/OnePlus7t.jpg', '', 'One Plus', '889.99', '{\"screen\":{\"height\":3120,\"width\":1440},\"camera\":48,\"storage\":256}', 0, 1, 1, 0, NULL, NULL),
(2, 'one_plus_6t', 'One Plus 6T', 'OnePlus 6T A6013 128GB Mirror Black - US Version T-Mobile GSM Unlocked Phone (Renewed)', 'uploads/devices/OnePlus6t.jpg', '', 'One Plus', '356.95', '{\"screen\":{\"height\":2340,\"width\":1080},\"camera\":20,\"storage\":128}', 0, 1, 0, 0, NULL, NULL),
(3, 'huawei_p30_pro', 'Huawei P30 Pro', '\r\n            Huawei P30 Pro 256GB+8GB RAM (VOG-L29) 40MP LTE Factory Unlocked GSM Smartphone (International Version, No Warranty in the US) (Aurora)', 'uploads/devices/Huaweip30pro.jpg', '', 'Huawei', '819.00', '{\"screen\":{\"height\":2340,\"width\":1080},\"camera\":40,\"storage\":256}', 0, 0, 0, 0, NULL, NULL),
(4, 'huawei_y221', 'Huawei Y221', '', 'uploads/devices/HuaweiY220.jpg', '', 'Huawei', '50990.00', '{\"screen\":{\"height\":480,\"width\":320},\"camera\":2,\"storage\":0.512}', 1, 1, 0, 0, NULL, NULL),
(5, 'lenovo_a916', 'Lenovo A916', '', 'uploads/devices/LenovoA916.png', '', 'Lenovo', '150.99', '{\"screen\":{\"height\":1280,\"width\":720},\"camera\":11,\"storage\":8}', 1, 1, 1, 0, NULL, NULL),
(6, 'samsung_galaxy_note9', 'Samsung Galaxy Note9', 'Samsung Galaxy Note9 N960U 128GB Unlocked 4G LTE Phone w/ Dual 12MP Camera - Midnight Black', 'uploads/devices/Note9.jpg', '<h1>Hello</h1>', 'Samsung Galaxy', '698.87', '{\"screen\":{\"height\":2960,\"width\":1440},\"camera\":12,\"storage\":128}', 0, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale` bigint(20) UNSIGNED DEFAULT NULL,
  `notificationId` bigint(20) UNSIGNED DEFAULT NULL,
  `by` bigint(20) UNSIGNED DEFAULT NULL,
  `for` bigint(20) UNSIGNED NOT NULL,
  `state` enum('alert','viewed','click') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'alert',
  `oculto` tinyint(1) NOT NULL DEFAULT '0',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `icon`, `sale`, `notificationId`, `by`, `for`, `state`, `oculto`, `trash`, `created_at`, `updated_at`) VALUES
(1, 'Eduardo es bello', 'El que diga lo contrario es feo', 'fa fa-times', 1, NULL, 1, 2, 'alert', 0, 0, '1999-09-21 14:00:00', NULL),
(2, 'Eduardo es bello', 'El que diga lo contrario es feo', 'fa fa-times', 2, NULL, 2, 3, 'alert', 0, 0, '1999-09-21 14:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excels`
--

CREATE TABLE `excels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `originalName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale` bigint(20) UNSIGNED DEFAULT NULL,
  `by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `histories`
--

INSERT INTO `histories` (`id`, `title`, `description`, `icon`, `sale`, `by`, `created_at`, `updated_at`) VALUES
(1, 'Nueva venta creada con exito', 'Nueva venta creada con exito por el sistema', 'fa fa-star', 1, 1, '1999-07-21 14:00:00', NULL),
(2, 'Venta editada con exito por el sistema', 'Venta editada con exito por el sistema', 'fa fa-pencil', 1, 1, '1999-08-21 14:00:00', NULL),
(3, 'Eduardo es bello', 'El que diga lo contrario es feo', 'fa fa-times', 1, 1, '1999-09-21 14:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lines`
--

CREATE TABLE `lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale` bigint(20) UNSIGNED DEFAULT NULL,
  `pcs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imei` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan` bigint(20) UNSIGNED DEFAULT NULL,
  `equipment` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_cost` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `fees` int(11) DEFAULT NULL,
  `chip_price` double(8,2) DEFAULT NULL,
  `substate` bigint(20) UNSIGNED NOT NULL,
  `creation` date DEFAULT NULL,
  `executive_send` date DEFAULT NULL,
  `supervisor_send` date DEFAULT NULL,
  `warehouse_send` date DEFAULT NULL,
  `map_assigned_biker` date DEFAULT NULL,
  `biker_send` date DEFAULT NULL,
  `ok` date DEFAULT NULL,
  `sstm` date DEFAULT NULL,
  `finalization` date DEFAULT NULL,
  `donor_company` enum('none','wom','entel','vtr','claro','virgin','movistar') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('none','nueva_linea','migracion','portabilidad','bam') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `ambit` enum('none','fisica','digital','ambas','otro') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lines`
--

INSERT INTO `lines` (`id`, `sale`, `pcs`, `imei`, `sim`, `plan`, `equipment`, `plan_cost`, `price`, `fees`, `chip_price`, `substate`, `creation`, `executive_send`, `supervisor_send`, `warehouse_send`, `map_assigned_biker`, `biker_send`, `ok`, `sstm`, `finalization`, `donor_company`, `type`, `canceled`, `ambit`, `created_at`, `updated_at`) VALUES
(1, 1, 'sagfsdag', '1afasdfsd', 'jdbehjrbwygv', 1, 1, 14.53, 15.00, 3, 21.13, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'entel', 'portabilidad', 0, 'digital', NULL, NULL),
(2, 1, 'sagfsdag', '1afasdfsd', 'jdbehjrbwygv', 1, 1, 14.53, 15.00, 3, 21.13, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'entel', 'portabilidad', 0, 'digital', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(97, '2011_11_21_144804_create_regions_table', 1),
(98, '2011_11_21_144957_create_communes_table', 1),
(99, '2013_08_15_192523_create_clients_table', 1),
(100, '2014_10_12_000000_create_users_table', 1),
(101, '2019_08_09_195431_create_states_table', 1),
(102, '2019_08_09_201634_create_substates_table', 1),
(103, '2019_08_12_195003_create_plans_table', 1),
(104, '2019_08_12_201606_create_equipment_table', 1),
(105, '2019_08_15_180356_create_sales_table', 1),
(106, '2019_08_15_200955_create_lines_table', 1),
(107, '2019_08_21_170916_create_events_table', 1),
(108, '2019_08_21_201907_create_promotions_table', 1),
(109, '2019_08_22_151810_create_stocks_table', 1),
(110, '2019_08_23_143059_create_excels_table', 1),
(111, '2019_08_26_144141_create_comments_table', 1),
(112, '2019_08_28_182018_create_histories_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `activation_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `points` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `activation_price`, `points`, `active`, `trash`, `created_at`, `updated_at`) VALUES
(1, 'Plan l port', '21.99', '84.99', 2, 1, 0, NULL, NULL),
(2, 'Plan lx port', '26.99', '92.99', 2, 1, 0, NULL, NULL),
(3, 'Plan l ep port', '18.99', '54.99', 1, 1, 0, NULL, NULL),
(4, 'Plan lx ep port', '24.99', '74.99', 2, 1, 0, NULL, NULL),
(5, 'Plan s ep ce port', '9.99', '27.99', 1, 0, 0, NULL, NULL),
(6, 'Plan m ep ce port', '14.99', '44.99', 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan` bigint(20) UNSIGNED NOT NULL,
  `equipment` bigint(20) UNSIGNED NOT NULL,
  `activation_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `prepaid_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `promotions`
--

INSERT INTO `promotions` (`id`, `plan`, `equipment`, `activation_price`, `prepaid_price`, `trash`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '84.99', '21.99', 0, 1, NULL, NULL),
(2, 2, 1, '92.99', '26.99', 0, 1, NULL, NULL),
(3, 3, 1, '54.99', '18.99', 0, 1, NULL, NULL),
(4, 4, 1, '74.99', '24.99', 0, 1, NULL, NULL),
(5, 5, 1, '27.99', '9.99', 1, 1, NULL, NULL),
(6, 6, 1, '14.99', '44.99', 0, 0, NULL, NULL),
(7, 1, 2, '84.99', '21.99', 0, 1, NULL, NULL),
(8, 2, 2, '92.99', '26.99', 0, 1, NULL, NULL),
(9, 3, 3, '54.99', '18.99', 0, 1, NULL, NULL),
(10, 2, 3, '92.99', '26.99', 0, 1, NULL, NULL),
(11, 5, 5, '27.99', '9.99', 0, 1, NULL, NULL),
(12, 6, 5, '44.99', '14.99', 0, 1, NULL, NULL),
(13, 1, 6, '84.99', '21.99', 1, 1, NULL, NULL),
(14, 1, 6, '84.99', '21.99', 0, 1, NULL, NULL),
(15, 1, 6, '84.99', '21.99', 0, 0, NULL, NULL),
(16, 5, 3, '27.99', '9.99', 0, 1, NULL, NULL),
(17, 6, 3, '44.99', '14.99', 0, 1, NULL, NULL),
(18, 5, 6, '27.99', '9.99', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regions`
--

CREATE TABLE `regions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordinal` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `regions`
--

INSERT INTO `regions` (`id`, `name`, `ordinal`, `created_at`, `updated_at`) VALUES
(1, 'Arica y Parinacota', 'XV', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(2, 'Tarapacá', 'I', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(3, 'Antofagasta', 'II', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(4, 'Atacama', 'III', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(5, 'Coquimbo', 'IV', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(6, 'Valparaiso', 'V', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(7, 'Metropolitana de Santiago', 'RM', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(8, 'Libertador General Bernardo O\'Higgins', 'VI', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(9, 'Maule', 'VII', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(10, 'Biobío', 'VIII', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(11, 'La Araucanía', 'IX', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(12, 'Los Ríos', 'XIV', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(13, 'Los Lagos', 'X', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(14, 'Aisén del General Carlos Ibáñez del Campo', 'XI', '2019-08-31 02:07:33', '2019-08-31 02:07:33'),
(15, 'Magallanes y de la Antártica Chilena', 'XII', '2019-08-31 02:07:33', '2019-08-31 02:07:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `observation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client` bigint(20) UNSIGNED NOT NULL,
  `seller` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor` bigint(20) UNSIGNED DEFAULT NULL,
  `analyst` bigint(20) UNSIGNED DEFAULT NULL,
  `biker` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_region` int(10) UNSIGNED DEFAULT NULL,
  `delivery_commune` int(10) UNSIGNED DEFAULT NULL,
  `delivery_phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_initial_time` datetime DEFAULT NULL,
  `delivery_final_time` datetime DEFAULT NULL,
  `delivery_geographic_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_observation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chip_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `delivery_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `activation_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `claro_debt` decimal(12,2) NOT NULL DEFAULT '0.00',
  `agreement_footer` decimal(12,2) NOT NULL DEFAULT '0.00',
  `advance_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(14,3) NOT NULL DEFAULT '0.000',
  `other_data` text COLLATE utf8mb4_unicode_ci,
  `metadata` text COLLATE utf8mb4_unicode_ci,
  `substate` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `observation`, `client`, `seller`, `supervisor`, `analyst`, `biker`, `delivery_address`, `delivery_region`, `delivery_commune`, `delivery_phone`, `delivery_initial_time`, `delivery_final_time`, `delivery_geographic_location`, `delivery_observation`, `chip_price`, `delivery_price`, `activation_price`, `claro_debt`, `agreement_footer`, `advance_charge`, `total`, `other_data`, `metadata`, `substate`, `created_at`, `updated_at`) VALUES
(1, 'Ee5jisgnzs', 1, 1, 1, 1, NULL, 'Guayana', 1, 1, '584126992473', NULL, NULL, 'oVRA80fXBu', 'xeP5I7YuN9', '5325.00', '387.00', '8108.00', '5670.00', '7898.00', '833.00', '1614.000', NULL, NULL, 1, NULL, NULL),
(2, 'wZzDlC7khJ', 2, 4, 1, 2, 3, 'Guayana', 1, 1, '584146902273', NULL, NULL, 'VtCi2fRt4y', 'aOY7kTckDR', '8196.00', '4905.00', '8360.00', '848.00', '1013.00', '5066.00', '3238.000', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowed_roles` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `states`
--

INSERT INTO `states` (`id`, `name`, `allowed_roles`, `created_at`, `updated_at`) VALUES
(1, 'Planteamiento', '[\"ejecutivo\"]', NULL, NULL),
(2, 'Revisión', '[\"supervisor\"]', NULL, NULL),
(3, 'Proceso', '[\"backoffice\"]', NULL, NULL),
(4, 'Recepción', '[\"bodega\"]', NULL, NULL),
(5, 'Chequeo', '[\"backoffice\"]', NULL, NULL),
(6, 'SSTM Y EQUIPO EN BOLSA', '[\"mapa\"]', NULL, NULL),
(7, 'En ruta', '[\"mapa\",\"motorista\"]', NULL, NULL),
(8, 'Terminada', '[\"backoffice\", \"backoffice_general\"]', NULL, NULL),
(9, 'Cancelada', '[\"supervisor\", \"backoffice\", \"backoffice_general\"]', NULL, NULL),
(10, 'Fallida', '[\"backoffice\", \"backoffice_general\"]', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imei` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lost` tinyint(1) NOT NULL DEFAULT '0',
  `office_guide` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trash` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `line` bigint(20) UNSIGNED DEFAULT NULL,
  `equipment` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `stocks`
--

INSERT INTO `stocks` (`id`, `imei`, `sim`, `lost`, `office_guide`, `sku`, `color`, `trash`, `created_at`, `updated_at`, `line`, `equipment`) VALUES
(1, '1234567890123001', '1234567890123201', 0, '12345601', '12345678901301', 'negro', 0, NULL, NULL, NULL, 1),
(2, '1234567890123002', '1234567890123202', 0, '12345602', '1234567890123302', 'azul', 0, NULL, NULL, NULL, 1),
(3, '1234567890123003', '1234567890123203', 0, '12345603', '1234567890123303', 'verde', 1, NULL, NULL, NULL, 1),
(4, '1234567890123004', '1234567890123204', 0, '12345604', '1234567890123304', 'negro', 0, NULL, NULL, NULL, 2),
(5, '1234567890123005', '1234567890123205', 0, '12345605', '1234567890123305', 'morado', 0, NULL, NULL, NULL, 2),
(6, '1234567890123006', '1234567890123206', 0, '12345606', '1234567890123306', 'gris', 0, NULL, NULL, NULL, 2),
(7, '1234567890123007', '1234567890123207', 0, '12345607', '1234567890123307', 'morado', 0, NULL, NULL, NULL, 3),
(8, '1234567890123008', '1234567890123208', 0, '12345608', '1234567890123308', 'negro', 0, NULL, NULL, NULL, 3),
(9, '1234567890123009', '1234567890123209', 0, '12345609', '1234567890123309', 'gris', 0, NULL, NULL, NULL, 3),
(10, '1234567890123010', '1234567890123210', 0, '12345610', '1234567890123310', 'gris', 0, NULL, NULL, NULL, 4),
(11, '1234567890123011', '1234567890123211', 0, '12345611', '1234567890123311', 'verde', 0, NULL, NULL, NULL, 4),
(12, '1234567890123012', '1234567890123212', 0, '12345612', '1234567890123312', 'verde', 0, NULL, NULL, NULL, 4),
(13, '1234567890123013', '1234567890123213', 0, '12345613', '1234567890123313', 'gris', 0, NULL, NULL, NULL, 5),
(14, '1234567890123014', '1234567890123214', 0, '12345614', '1234567890123314', 'morado', 0, NULL, NULL, NULL, 5),
(15, '1234567890123015', '1234567890123215', 0, '12345615', '1234567890123315', 'negro', 0, NULL, NULL, NULL, 5),
(16, '1234567890123016', '1234567890123216', 0, '12345616', '1234567890123316', 'blanco', 0, NULL, NULL, NULL, 6),
(17, '1234567890123017', '1234567890123217', 0, '12345617', '1234567890123317', 'blanco', 0, NULL, NULL, NULL, 6),
(18, '1234567890123018', '1234567890123218', 0, '12345618', '1234567890123318', 'mordad', 0, NULL, NULL, NULL, 6),
(19, '12345523890123001', '12312490123201', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(20, '125323890123001', '1235320123201', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(21, '123456430123001', '11230123201', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(22, '123456430155523001', '112301523555201', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(23, '1235320123001', '112301532201', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(24, '15321421401', '5123', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1),
(25, '123530123001', '5325325', 0, '12532601', '123435238901301', 'negro', 0, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `substates`
--

CREATE TABLE `substates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `substates`
--

INSERT INTO `substates` (`id`, `name`, `state`, `created_at`, `updated_at`) VALUES
(1, 'SIN ACCIONES', 1, NULL, NULL),
(2, 'DEVUELTA AL EJECUTIVO', 1, NULL, NULL),
(3, 'ENVIADA AL SUPERVISOR', 2, NULL, NULL),
(4, 'RECHAZADA POR BACKOFFICE', 2, NULL, NULL),
(5, 'EN PROCESO DE ANALISIS', 3, NULL, NULL),
(6, 'PENDIENTE BODEGA', 4, NULL, NULL),
(7, 'BODEGA OK', 5, NULL, NULL),
(8, 'PENDIENTE RUTA', 6, NULL, NULL),
(9, 'RUTA SANTIAGO', 7, NULL, NULL),
(10, 'RUTA VIÑA', 7, NULL, NULL),
(11, 'RUTA LA SEREÑA', 7, NULL, NULL),
(12, 'RUTA RANCAGUA', 7, NULL, NULL),
(13, 'RUTA CONCEPCION', 7, NULL, NULL),
(14, 'RUTA LA SEREÑA', 7, NULL, NULL),
(15, 'COMPLETADA', 8, NULL, NULL),
(16, 'CANCELADA', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name_2` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comuna` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('masculino','femenino','otro') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rut` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('usuario','ejecutivo','supervisor','backoffice','bodega','backoffice_general','rrhh','mapa','motorista','bct','lavadora','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  `verify_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verifiedEmail` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `last_name`, `last_name_2`, `phone`, `comuna`, `address`, `education_level`, `birthday`, `gender`, `nationality`, `civil_status`, `rut`, `assigned_to`, `avatar`, `role`, `verify_token`, `slug`, `verifiedEmail`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$FF3MKRXZbd523JwsL5COP.lN1XMNrdGf1QeZlfqzeEJ0ZvL5Un/qe', 'admin@admin.com', 'Admin', 'Sistema', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice_general', NULL, 'administrador-sistema', 1, NULL, NULL),
(2, 'Moncki', '$2y$10$SKMQYB.nuwtx8dXy491KXO67by19aP.dQiq0gy1rDwz/1T8O3.OtK', 'moncki21@gmail.com', 'Eduardo', 'Lara', 'Salazar', '04249104569', 21, 'Villa Africana', 'Secundaria', '1999-09-21', 'masculino', 'Venezolana', 'Soltero', '27935371', 1, 'uploads/users/negro_eslacvo.png', 'backoffice', '2y2h324hsa21as', 'eduardolarasalazar', 1, NULL, NULL),
(3, 'darens', '$2y$10$J3tcKl6bcQ/yB6Ft7.P3nuw/DtrHRGtkhOern2UYTmiIvqhdzccw2', 'heasdas@gmail.com', 'Andres', 'Rodriguez', 'Salazar', '+512312412', 21, 'villa africana', '', '1999-01-30', 'masculino', 'Venezolano', 'Soltero', '27506424', 2, 'uploads/users/negro_eslacvo.png', 'supervisor', '2y2h324hsa21as', 'andres-rodrigues', 1, NULL, NULL),
(4, 'HectorXD', '$2y$10$.TrDSsUxxJK3HeERSPN9U.VgzHx3ZuYYnr3/zfunSlc7P10kU9uSm', 'Hector1567XD@gmail.com', 'Hector', 'Ferrer', 'Cabrera', '+584126992473', 20, 'Guayana', 'Bachillerato', '2000-03-28', 'masculino', 'Venezolano', 'Soltero', '27201276', 3, NULL, 'ejecutivo', '2y2h324ha21as2', 'hector-ferrer', 1, NULL, NULL),
(5, 'backoffice', '$2y$10$PxR0ivwHA5.WYRlk142mIOn5m6nW61mwiLHfnu3xx7i3.fprzntIK', 'backoffice@backoffice.com', 'Backoffice', 'Generico', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, 9, NULL, 'backoffice', NULL, 'backoffice-generico', 1, NULL, NULL),
(6, 'supervisor', '$2y$10$kKZMIL4bJ3opbGLFdUruRut8I6Xic/3toHrX956vRWQ3JgY8pGete', 'supervisor@supervisor.com', 'Supervisor', 'Generico', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, 5, NULL, 'supervisor', NULL, 'supervisor-generico', 1, NULL, NULL),
(7, 'ejecutivo', '$2y$10$d7sCV7axVMFarxKcPK1wFumGfR3TLkRCEhEUsmbvkTpEotSqgdbBO', 'ejecutivo@ejecutivo.com', 'Ejecutivo', 'Generico', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, 6, NULL, 'ejecutivo', NULL, 'ejecutivo-generico', 1, NULL, NULL),
(8, 'bodega', '$2y$10$yiw8DG4Kc/wa0ChbMGacOOD8vz6MiZCiUpVmEB6/h1btebctPumpi', 'bodega@bodega.com', 'Bodega', 'Generico', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'bodega', NULL, 'bodega-generico', 1, NULL, NULL),
(9, 'backoffice_general', '$2y$10$nYxbPk3f5E6b5h6DvkMJsuSnUr5dClxOXfc47.FgYg/lr3f7Yv2bC', 'backoffice_general@backoffice_general.com', 'Backoffice General', 'Generico', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'backoffice_general', NULL, 'backoffice_general-generico', 1, NULL, NULL),
(10, 'Z3ngDb-test0', '$2y$10$q0mAWAF0fzTofK4mHmkCRetfF.0iDEDj2fxHq0i5LiveOr0JCexim', 'user-0@test.com', 'backoffice ay8lAUc', 'xlUcJ2 0', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-0', 0, NULL, NULL),
(11, 't7Gwrf-test1', '$2y$10$xY2iTmM9KV3mycTlflo/uO0jpW55uRIKginMK6JIKiBk7cDdBwuTq', 'user-1@test.com', 'supervisor Zs11AWN', 'jPr2P1 1', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-1', 0, NULL, NULL),
(12, 'uaruUR-test2', '$2y$10$W5fnScMvgfA/1RMQmvTZ1OjMzkRUyD5EO4GqSXxEzoa6ra4nLItiy', 'user-2@test.com', 'supervisor 6dqeoxD', 'MYcy5R 2', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-2', 0, NULL, NULL),
(13, 'J1PcT7-test3', '$2y$10$cAJxVSi52GSwfjaEjnFD7OjE0mxttjogSR5.SFNozT7i6pAm4uEQW', 'user-3@test.com', 'ejecutivo DNQFrOa', 'Qv2R7H 3', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-3', 0, NULL, NULL),
(14, 'bZSDLT-test4', '$2y$10$twJaCiVraD7cJQi1XTD/WOfJI8xmjsqUftlFp0zU2lH8s4LH1l5aS', 'user-4@test.com', 'backoffice oqBopnS', '5HSDls 4', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-4', 0, NULL, NULL),
(15, 's8RDpS-test5', '$2y$10$C3Kt9te2YAYEfqK77ceIFOi.KAjQemti/AwGh0JiAMMxznaj1vMlS', 'user-5@test.com', 'supervisor FC5bE0W', 'PJNx9y 5', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-5', 0, NULL, NULL),
(16, '6z04Gt-test6', '$2y$10$bVpEmHKlUPOCgjD34XJyh.L.Y28tHnigxrFbJiJgWAXjbny//8Cvq', 'user-6@test.com', 'ejecutivo zy4tUxU', 'A3666C 6', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-6', 0, NULL, NULL),
(17, 'Mh5tYw-test7', '$2y$10$wYuSqGm8r1NV27zmYWVqlOyHobfIiPFTcxmHj5ag5iv/gHgrbb0TO', 'user-7@test.com', 'supervisor uLHGkPX', '6ZCgal 7', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-7', 0, NULL, NULL),
(18, 'xT6qEQ-test8', '$2y$10$FkCaM1h5XdL29EZW8JPWOOTu9rwZ/4M0S8KkD5H1L28e/VxE0ZHHy', 'user-8@test.com', 'ejecutivo h6U3xHy', '17LXKt 8', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-8', 0, NULL, NULL),
(19, '4mrhvX-test9', '$2y$10$3Q.DQJjZqCYK5Yq4.UbVme9f0/iviqpUFrovWgDNW5EEVVLLtcHJm', 'user-9@test.com', 'supervisor NNnHPuC', 'stTGST 9', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-9', 0, NULL, NULL),
(20, 'UdLDe6-test10', '$2y$10$ndhVjSR92WyibkL7Euouk.LJNm2.hpZycUAVyU.OAl87WsVvUpdky', 'user-10@test.com', 'supervisor XC9PseX', 'VHFCZb 10', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-10', 0, NULL, NULL),
(21, '4CMQng-test11', '$2y$10$B9cD3kGzAEfAWi/WQ72mkOgRUCbG951pcy5CaiUd0syUtED8eDoo2', 'user-11@test.com', 'ejecutivo CvoZkWq', 'BaSR6f 11', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-11', 0, NULL, NULL),
(22, 't41Vou-test12', '$2y$10$GkU0PUXYLGVOoEWjL3A3cuSnGi4yhOzP.YvtpNS.kDlA27pXpq86a', 'user-12@test.com', 'supervisor sr2GB2Q', 'vqg6QQ 12', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-12', 0, NULL, NULL),
(23, '0G6tb7-test13', '$2y$10$1XK1G2I.stk1ZnG7fctILu6XHXrohym1jAh7NCf8zypsQ1xE9CSRy', 'user-13@test.com', 'backoffice gL7MJy6', 'GoW1bV 13', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-13', 0, NULL, NULL),
(24, 'vYcExj-test14', '$2y$10$4yyYh5PLeSP29TxN/uvtBeOmgGuHKqgKipNUixKErsTNwcAIyvmDi', 'user-14@test.com', 'ejecutivo N2WXTPV', 'EmZJrM 14', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-14', 0, NULL, NULL),
(25, 'cqXoHO-test15', '$2y$10$X9/P9Lt6/zSniHy3f0cgte1JU1o8YTcAd1G2IPooA6iUYWNBwUqgG', 'user-15@test.com', 'supervisor 6Pkrlth', 'yt3Bt6 15', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-15', 0, NULL, NULL),
(26, '2FwdoK-test16', '$2y$10$f4YOYtcX9eoWucZVrAcp7.qrhJH7RwWTzkvrjuX3cpEJwgd6TrBuW', 'user-16@test.com', 'supervisor uREjpxU', '6px1kA 16', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-16', 0, NULL, NULL),
(27, 'ltkgm4-test17', '$2y$10$J4oWIlNTrInKpfQAjSEREOyVHnRqXxcgzF2bnp3oku8QsTTV8H9IK', 'user-17@test.com', 'supervisor Gr6XYcQ', 'TI2WsE 17', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-17', 0, NULL, NULL),
(28, 'Pihmld-test18', '$2y$10$g5sJlkd1GS7MurDM7/oKfuTUfFCA60MPg7fG/50oZifZQRGxavniW', 'user-18@test.com', 'ejecutivo bRkkPdY', '7RCQPp 18', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-18', 0, NULL, NULL),
(29, 'ocAIGo-test19', '$2y$10$NKRuhXTzAaENI0eCujrQgOgdqG4xf7YrMMg7b/Ld7QNFsZM0xttje', 'user-19@test.com', 'backoffice 8M5M9hW', 'bN0rk1 19', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-19', 0, NULL, NULL),
(30, 'MBAETw-test20', '$2y$10$pmy2kDNibxfFnAbPy/kafO5BzEwnh91eBZrS5Mb19VK2T163nIGQK', 'user-20@test.com', 'ejecutivo b0QAv4o', 'UbHgA8 20', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-20', 0, NULL, NULL),
(31, 'CUZhNx-test21', '$2y$10$ZDrAo3638HMzaMe5030U0O/4WbzTnP9nA/r8dIZF6XruGvLav.JNy', 'user-21@test.com', 'ejecutivo 8YF9WXy', 'nJfgoB 21', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-21', 0, NULL, NULL),
(32, 'YctNru-test22', '$2y$10$4qK81PFswH4cxy3o3x8mReIx/2w5h/JJ6bQLqqwXESKdXa1bLRdAe', 'user-22@test.com', 'ejecutivo f5xbXPL', 'DZp0Ww 22', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-22', 0, NULL, NULL),
(33, 'KKJbF6-test23', '$2y$10$9pzbrwK79hHOUj/12dGaCuqjH7pAOtv9cXWrRyXD/lo77UiwpjZ4S', 'user-23@test.com', 'backoffice LdBb95t', 'Wqky0P 23', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-23', 0, NULL, NULL),
(34, 'XARyID-test24', '$2y$10$vt2uiRFHXL3Gxqqv5zQ4LeMDGIsG4eB0s.PWY8sPDcVm0eWdskoTi', 'user-24@test.com', 'ejecutivo FXVKbIs', 'rtMPOn 24', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-24', 0, NULL, NULL),
(35, 'eEECYW-test25', '$2y$10$GR2Byk1fiXpDYmAJF9wRG.zG9nvm3HzsvEhwLFjWaeJBpmyW5p4um', 'user-25@test.com', 'ejecutivo 00904JI', 's7ZbWv 25', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-25', 0, NULL, NULL),
(36, 'KlR0ZL-test26', '$2y$10$8rXdBzJP4YFI3Z6m0xbv0OisX.52JBv6CsjYrdbOK6wRv8sXaCpwC', 'user-26@test.com', 'supervisor DYMgkOp', 'QpBEDf 26', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-26', 0, NULL, NULL),
(37, 'uMYmXQ-test27', '$2y$10$Gx2s.t5rW/156wWJ/At6FOKlhV/1GkweEeRzdJfPBUAlAm1AoshSm', 'user-27@test.com', 'supervisor xUmtAaM', 'SU7ZpM 27', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-27', 0, NULL, NULL),
(38, 'm4vBpa-test28', '$2y$10$2jnTdzkDRLWVnh.ckiwzbeSmDtKE672xxq..antOwdbQG/lZW63hW', 'user-28@test.com', 'backoffice 8QqaOkd', 'etlza5 28', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-28', 0, NULL, NULL),
(39, 'oSBEx9-test29', '$2y$10$fKvEKCkPE./WJqP4wCt5Pu5tdyiJhlrLtaSudadAfk.gMJwXdnvqW', 'user-29@test.com', 'backoffice 1620epR', 'PID0UU 29', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-29', 0, NULL, NULL),
(40, 'ATkaY6-test30', '$2y$10$GgnYbgte/ANGz54eLA1MN.btb1x1AeJgdoE.jiSSJWQqWapKVCKx6', 'user-30@test.com', 'backoffice eY7kPqF', 'fLdAVl 30', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-30', 0, NULL, NULL),
(41, 'c75J6p-test31', '$2y$10$A.TO42wyRaRfdIpSD7p70ekoB7uu3lYTyknfvAMP0VOlYnoqNXuH6', 'user-31@test.com', 'supervisor fDf1wGX', 'dOnRfk 31', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-31', 0, NULL, NULL),
(42, 'exRVmF-test32', '$2y$10$YMg/ARVvyJjmtazCoKoj4uNN.kx6sIQqKOmnPGjVLVJ94uj11V5.6', 'user-32@test.com', 'ejecutivo zL9vMEe', 'M7MeJD 32', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-32', 0, NULL, NULL),
(43, 'OamerQ-test33', '$2y$10$YTZ.KiZySVfdFKxiJeTcN.hJMeAJ9aPP84HcqGvZ68.NQzHHaKnD.', 'user-33@test.com', 'ejecutivo Mi5mJgc', 'ULbuu0 33', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-33', 0, NULL, NULL),
(44, 'EdKL4F-test34', '$2y$10$oShIYYQl99Aq1O3ZPw1uJ.Tnxefk8rMqFWKzYTii6xlG2hPIpILOu', 'user-34@test.com', 'ejecutivo zxCZws3', 'bWeWch 34', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-34', 0, NULL, NULL),
(45, 'YkLxSc-test35', '$2y$10$p6JMSC2e2I/bRhc14SxeSOyiJaJBntBREdBo08hnsv9NRzMbGLnpa', 'user-35@test.com', 'supervisor wHk1QpJ', 'dhYyzS 35', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-35', 0, NULL, NULL),
(46, 'mk8jnW-test36', '$2y$10$tDsjE8bKhqdOSTHR/gcugeV5SCdizxFZArjkFVNdOML6u0a2S33iy', 'user-36@test.com', 'ejecutivo EIguhW5', '8b8hQc 36', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-36', 0, NULL, NULL),
(47, '3xGvvA-test37', '$2y$10$7nCN4Wt8jmf5n304vYxHUekXuPggG1MykY7ItGMpSX4bE8VaexZCm', 'user-37@test.com', 'supervisor hbUlUuC', 'ZRFHor 37', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-37', 0, NULL, NULL),
(48, 'iHFISz-test38', '$2y$10$hE0bFsbp3TFTape9A5mqMOJMC0T3n6rP8XwlEfbDZaqti9MQKuUBq', 'user-38@test.com', 'backoffice 1SIq8QZ', 'Y6f0Vy 38', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-38', 0, NULL, NULL),
(49, '1IJRZF-test39', '$2y$10$XGYFYblXYPsn41BrsifEEOI10YCogrCw045u3bpYDpVIGnrOvuPqm', 'user-39@test.com', 'backoffice BoWjzVD', 'CSQN8T 39', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'backoffice', NULL, 'backoffice-test-39', 0, NULL, NULL),
(50, 'g3pczi-test40', '$2y$10$B2NJXa7HNGsELXIjw3jYEeC3FBHq6gnR6g9R8OPc54zYNidlU9nFK', 'user-40@test.com', 'ejecutivo 5M0AieT', 'xjfmKM 40', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-40', 0, NULL, NULL),
(51, 'R8rBC6-test41', '$2y$10$qTehLKyIW1ru36y/GuwP0.OWI0spJwTSYFVy4FreECq8QNIcLvO1O', 'user-41@test.com', 'ejecutivo sJgWzls', 'nYXhty 41', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-41', 0, NULL, NULL),
(52, 'Q1UywR-test42', '$2y$10$wQxL1uu6Eg8wQ7wGPGA3SOjfeLLiZT5LZZf8Ok1u9GpggazjWrxFK', 'user-42@test.com', 'supervisor dO0PIVg', 'BnyQhl 42', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-42', 0, NULL, NULL),
(53, 'bPc13R-test43', '$2y$10$lBq2x9E0ig3dvkV9BuqwSurcQ6UmdzmiWkW31Cimb6EvQuH8vy3Nu', 'user-43@test.com', 'supervisor sRWFNW3', '0HgoJR 43', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-43', 0, NULL, NULL),
(54, 'QOB034-test44', '$2y$10$W7d6NN6q0x0HhmBOlNjlV.Y5SqWVXmqeV8WSohTUkcyRdS5JgLwpG', 'user-44@test.com', 'ejecutivo Mgsrvrm', '4dQxQM 44', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-44', 0, NULL, NULL),
(55, 'NTPIHz-test45', '$2y$10$li.NBwtPGKqPaQAxVkkNLuZ9zQ2osFDpKtPCnalX8LCikrpoBYKUa', 'user-45@test.com', 'ejecutivo 03ZxcMr', 'vSpgVi 45', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-45', 0, NULL, NULL),
(56, 'WVWFbx-test46', '$2y$10$30SDz3IVjDz4Rlzdbsb8O.UC9fFg.0nRMeDBlxlAqf9LozUJfOfYK', 'user-46@test.com', 'supervisor 7tJhgSm', 'Kmc6zZ 46', NULL, NULL, NULL, NULL, NULL, NULL, 'masculino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-46', 0, NULL, NULL),
(57, '05Ioa0-test47', '$2y$10$f60dGbTpc4TUIvIUH4WzBeOTWG2brIW.Svfo47LyglWgzwwo1JvFu', 'user-47@test.com', 'supervisor MxNaVde', 'Tg2OvU 47', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'supervisor', NULL, 'supervisor-test-47', 0, NULL, NULL),
(58, '1Q6QmT-test48', '$2y$10$CwWnU2n2Qc0nYWJD6WyjlupICyb5jaGCebO4o9p3sIB/uD6Mo6nQO', 'user-48@test.com', 'ejecutivo VV2t1AI', 'xhlOjF 48', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-48', 0, NULL, NULL),
(59, 'TcAFwq-test49', '$2y$10$mDvO0Ja1YZ2.l7Pt3QDG2e6lBHrrZPRzesVvVLn/84pg/vfDYRDUa', 'user-49@test.com', 'ejecutivo ZdCzuDF', 'nRlEs4 49', NULL, NULL, NULL, NULL, NULL, NULL, 'femenino', NULL, NULL, NULL, NULL, NULL, 'ejecutivo', NULL, 'ejecutivo-test-49', 0, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_rut_unique` (`rut`),
  ADD KEY `clients_comuna_foreign` (`comuna`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_sell_foreign` (`sell`),
  ADD KEY `comments_user_foreign` (`user`);

--
-- Indices de la tabla `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communes_region_id_foreign` (`region_id`);

--
-- Indices de la tabla `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipments_code_unique` (`code`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_sale_foreign` (`sale`),
  ADD KEY `events_by_foreign` (`by`),
  ADD KEY `events_for_foreign` (`for`);

--
-- Indices de la tabla `excels`
--
ALTER TABLE `excels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histories_sale_foreign` (`sale`),
  ADD KEY `histories_by_foreign` (`by`);

--
-- Indices de la tabla `lines`
--
ALTER TABLE `lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lines_sale_foreign` (`sale`),
  ADD KEY `lines_plan_foreign` (`plan`),
  ADD KEY `lines_equipment_foreign` (`equipment`),
  ADD KEY `lines_substate_foreign` (`substate`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_name_unique` (`name`);

--
-- Indices de la tabla `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_plan_foreign` (`plan`),
  ADD KEY `promotions_equipment_foreign` (`equipment`);

--
-- Indices de la tabla `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_client_foreign` (`client`),
  ADD KEY `sales_seller_foreign` (`seller`),
  ADD KEY `sales_supervisor_foreign` (`supervisor`),
  ADD KEY `sales_analyst_foreign` (`analyst`),
  ADD KEY `sales_biker_foreign` (`biker`),
  ADD KEY `sales_delivery_region_foreign` (`delivery_region`),
  ADD KEY `sales_delivery_commune_foreign` (`delivery_commune`),
  ADD KEY `sales_substate_foreign` (`substate`);

--
-- Indices de la tabla `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_imei_unique` (`imei`),
  ADD KEY `stocks_line_foreign` (`line`),
  ADD KEY `stocks_equipment_foreign` (`equipment`);

--
-- Indices de la tabla `substates`
--
ALTER TABLE `substates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_slug_unique` (`slug`),
  ADD KEY `users_comuna_foreign` (`comuna`),
  ADD KEY `users_assigned_to_foreign` (`assigned_to`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `communes`
--
ALTER TABLE `communes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT de la tabla `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `excels`
--
ALTER TABLE `excels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `lines`
--
ALTER TABLE `lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `substates`
--
ALTER TABLE `substates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_comuna_foreign` FOREIGN KEY (`comuna`) REFERENCES `communes` (`id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_sell_foreign` FOREIGN KEY (`sell`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `comments_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `communes`
--
ALTER TABLE `communes`
  ADD CONSTRAINT `communes_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_by_foreign` FOREIGN KEY (`by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_for_foreign` FOREIGN KEY (`for`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_sale_foreign` FOREIGN KEY (`sale`) REFERENCES `sales` (`id`);

--
-- Filtros para la tabla `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_by_foreign` FOREIGN KEY (`by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `histories_sale_foreign` FOREIGN KEY (`sale`) REFERENCES `sales` (`id`);

--
-- Filtros para la tabla `lines`
--
ALTER TABLE `lines`
  ADD CONSTRAINT `lines_equipment_foreign` FOREIGN KEY (`equipment`) REFERENCES `equipments` (`id`),
  ADD CONSTRAINT `lines_plan_foreign` FOREIGN KEY (`plan`) REFERENCES `plans` (`id`),
  ADD CONSTRAINT `lines_sale_foreign` FOREIGN KEY (`sale`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `lines_substate_foreign` FOREIGN KEY (`substate`) REFERENCES `substates` (`id`);

--
-- Filtros para la tabla `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_equipment_foreign` FOREIGN KEY (`equipment`) REFERENCES `equipments` (`id`),
  ADD CONSTRAINT `promotions_plan_foreign` FOREIGN KEY (`plan`) REFERENCES `plans` (`id`);

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_analyst_foreign` FOREIGN KEY (`analyst`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_biker_foreign` FOREIGN KEY (`biker`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_client_foreign` FOREIGN KEY (`client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `sales_delivery_commune_foreign` FOREIGN KEY (`delivery_commune`) REFERENCES `communes` (`id`),
  ADD CONSTRAINT `sales_delivery_region_foreign` FOREIGN KEY (`delivery_region`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `sales_seller_foreign` FOREIGN KEY (`seller`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_substate_foreign` FOREIGN KEY (`substate`) REFERENCES `substates` (`id`),
  ADD CONSTRAINT `sales_supervisor_foreign` FOREIGN KEY (`supervisor`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_equipment_foreign` FOREIGN KEY (`equipment`) REFERENCES `equipments` (`id`),
  ADD CONSTRAINT `stocks_line_foreign` FOREIGN KEY (`line`) REFERENCES `lines` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_comuna_foreign` FOREIGN KEY (`comuna`) REFERENCES `communes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
