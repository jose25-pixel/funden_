-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2022 a las 22:35:19
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fundell`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcategoria` int(10) UNSIGNED NOT NULL,
  `idgramaje` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concentracion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `administracion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `idcategoria`, `idgramaje`, `nombre`, `concentracion`, `administracion`, `presentacion`, `items`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'meta', '500', 'Vía Ocular', 'blister', 'no aplica', 0, '2022-07-19 13:54:26', '2022-07-21 12:47:47'),
(2, 1, 1, 'acetaminofen', '500', 'Vía oral', 'blister', '1x10', 1, '2022-07-19 13:59:32', '2022-07-19 13:59:32'),
(3, 1, 1, 'casa', '350', 'Vía Inyectables', 'blister', '1x4', 1, '2022-07-19 14:47:27', '2022-07-19 14:47:27'),
(4, 1, 1, 'Vick', '10', 'Vía Nasal', 'Cja', '1', 1, '2022-07-20 03:15:14', '2022-07-20 03:15:14'),
(5, 2, 1, 'amoxicilina', '500', 'Vía oral', 'blister', '1x10', 1, '2022-07-21 19:41:58', '2022-07-21 19:41:58'),
(6, 2, 1, 'anatran', '250', 'Vía oral', 'blister', '1x10', 1, '2022-07-21 20:32:09', '2022-07-21 20:32:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'fardel', NULL, 1, '2022-07-19 13:53:06', '2022-07-19 13:53:06'),
(2, 'lopez', NULL, 1, '2022-07-21 19:40:48', '2022-07-21 19:40:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

CREATE TABLE `detalle_ingresos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idingreso` int(10) UNSIGNED NOT NULL,
  `idinventario` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_blister` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ingresos`
--

INSERT INTO `detalle_ingresos` (`id`, `idingreso`, `idinventario`, `cantidad`, `cantidad_blister`, `precio`) VALUES
(1, 1, 2, 3, 1, '3.00'),
(2, 2, 2, 30, 0, '1.00'),
(3, 3, 2, 22, 0, '1.00'),
(4, 4, 1, 1000, 100, '1.00'),
(5, 5, 3, 1000, 100, '1.00'),
(8, 8, 2, 100, 10, '1.00'),
(10, 10, 2, 100, 10, '1.00'),
(11, 11, 2, 10, 1, '1.00'),
(12, 12, 1, 100, 10, '1.00'),
(15, 15, 2, 10, 1, '10.00');

--
-- Disparadores `detalle_ingresos`
--
DELIMITER $$
CREATE TRIGGER `u_stock_entada` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW BEGIN
UPDATE inventarios SET cantidad_tableta = cantidad_tableta + NEW.cantidad,
cantidad_blister = cantidad_blister + NEW.cantidad_blister
WHERE inventarios.id = NEW.idinventario;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_inventarios`
--

CREATE TABLE `detalle_inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `idinventarios` int(10) UNSIGNED NOT NULL,
  `antiguo_tableta` int(11) NOT NULL,
  `antiguo_blister` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_inventarios`
--

INSERT INTO `detalle_inventarios` (`id`, `idinventarios`, `antiguo_tableta`, `antiguo_blister`, `created_at`, `updated_at`) VALUES
(3, 2, 200, 21, NULL, NULL),
(4, 1, 1000, 100, NULL, NULL),
(5, 2, 210, 22, NULL, NULL),
(6, 2, 110, 12, NULL, NULL),
(7, 11, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idventa` int(10) UNSIGNED NOT NULL,
  `idinventario` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_blister` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `idventa`, `idinventario`, `cantidad`, `cantidad_blister`, `precio`) VALUES
(2, 2, 2, 100, 10, '0.50'),
(3, 3, 2, 100, 10, '0.00');

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `stock_salidad` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
UPDATE inventarios SET cantidad_tableta = cantidad_tableta - NEW.cantidad,
cantidad_blister = cantidad_blister - NEW.cantidad_blister
WHERE inventarios.id = NEW.idinventario;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gramajes`
--

CREATE TABLE `gramajes` (
  `id` int(10) UNSIGNED NOT NULL,
  `gramaje` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `gramajes`
--

INSERT INTO `gramajes` (`id`, `gramaje`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'mg', 1, '2022-07-19 13:53:19', '2022-07-19 13:53:19'),
(2, 'militros', 1, '2022-07-21 19:41:03', '2022-07-21 19:41:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idproveedor` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_comprobante` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_compra` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `lote` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_compra`, `fecha_vencimiento`, `lote`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'CCF', '567', '4567', '2022-07-21', '2022-07-21', '8908', '9.00', 'Registrado', '2022-07-19 14:04:27', '2022-07-19 14:04:27'),
(2, 2, 1, 'CCF', '09876', '789065', '2022-07-19', '2022-07-20', '098745', '30.00', 'Registrado', '2022-07-19 14:05:27', '2022-07-19 14:05:27'),
(3, 2, 1, 'FACTURA', '897845', '09876', '2022-07-20', '2022-07-21', '098', '22.00', 'Registrado', '2022-07-19 14:06:48', '2022-07-19 14:06:48'),
(4, 2, 1, 'FACTURA', '09887', '9807', '2022-07-21', '2022-07-21', '0987', '1000.00', 'Registrado', '2022-07-19 14:07:50', '2022-07-19 14:07:50'),
(5, 2, 1, 'CCF', '09876', '0987', '2022-07-14', '2022-07-30', '09876', '1000.00', 'Registrado', '2022-07-19 14:48:58', '2022-07-19 14:48:58'),
(8, 2, 1, 'CCF', '9087', '0987', '2022-07-20', '2022-07-22', '0987', '100.00', 'Registrado', '2022-07-21 02:29:22', '2022-07-21 02:29:22'),
(10, 2, 1, 'CCF', '0089', '09745', '2022-07-21', '2022-07-21', '098565', '100.00', 'Registrado', '2022-07-21 02:52:47', '2022-07-21 02:52:47'),
(11, 2, 1, 'CCF', '09876', '098756', '2022-07-21', '2022-07-22', '0987', '10.00', 'Registrado', '2022-07-21 03:12:16', '2022-07-21 03:12:16'),
(12, 2, 1, 'CCF', '09876', '09876', '2022-07-21', '2022-07-23', '098', '100.00', 'Registrado', '2022-07-21 03:14:17', '2022-07-21 03:14:17'),
(15, 2, 1, 'FACTURA', '0987645', '09876', '2022-07-22', '2022-07-20', '09846', '100.00', 'Registrado', '2022-07-21 19:49:23', '2022-07-21 19:49:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `idproducto` int(10) UNSIGNED NOT NULL,
  `cantidad_tableta` int(11) NOT NULL,
  `cantidad_blister` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`id`, `idproducto`, `cantidad_tableta`, `cantidad_blister`, `created_at`, `updated_at`) VALUES
(1, 1, 1100, 110, NULL, NULL),
(2, 2, 120, 13, NULL, NULL),
(3, 3, 1012, 104, NULL, NULL),
(10, 4, 2, 2, '2022-07-20 03:36:43', '2022-07-20 03:36:43'),
(11, 5, 0, 0, '2022-07-21 19:42:46', '2022-07-21 19:42:46'),
(12, 6, 1, 1, '2022-07-21 20:33:11', '2022-07-21 20:33:11');

--
-- Disparadores `inventarios`
--
DELIMITER $$
CREATE TRIGGER `stock_antiguo` AFTER UPDATE ON `inventarios` FOR EACH ROW INSERT into detalle_inventarios(antiguo_tableta,antiguo_blister,idinventarios)VALUES
(old.cantidad_tableta,old.cantidad_blister,NEW.id)
$$
DELIMITER ;

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
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2022_03_12_221454_create_categorias_table', 1),
(31, '2022_03_13_205545_create_gramajes_table', 1),
(32, '2022_04_02_203335_create_articulos_table', 1),
(33, '2022_04_23_203026_create_personas_table', 1),
(34, '2022_04_29_175628_create_proveedores_table', 1),
(35, '2022_04_29_210536_create_roles_table', 1),
(36, '2022_04_29_211650_create_inventarios_table', 1),
(37, '2022_04_29_211721_create_detalle_inventarios_table', 1),
(38, '2022_04_30_000000_create_users_table', 1),
(39, '2022_05_03_034331_create_ingresos_table', 1),
(40, '2022_05_03_034431_create_detalle_ingresos_table', 1),
(41, '2022_05_18_185508_create_ventas_table', 1),
(42, '2022_05_18_185526_create_detalle_ventas_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '', '', '', '', '', NULL, NULL),
(2, 'fardel', 'PASS', '098745', 'avennidad crismal', '76543423', 'fardel@fardel', '2022-07-19 13:57:56', '2022-07-19 13:57:56'),
(3, 'santiago nonualco', 'RUC', '45678', 'sa.', '76856754', 'santiago@nonualco', '2022-07-19 13:58:43', '2022-07-19 13:58:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `contacto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `contacto`, `telefono_contacto`) VALUES
(2, 'fardel', '76543223');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Administrador', 'Administradores de área', 1),
(2, 'Vendedor', 'Vendedor área venta', 1),
(3, 'Almacenero', 'Almacenero área compras', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `condicion`, `idrol`, `remember_token`) VALUES
(1, 'administrador', '$2y$10$H8v7yYZImp8T5H35DdkHUueMq7bxFqsbbANYajQ/f.49fCMLpdnpO', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `fecha_salida` date NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idcliente`, `idusuario`, `fecha_salida`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(2, 3, 1, '2022-07-21', '50.00', 'Registrado', '2022-07-21 02:56:27', '2022-07-21 02:56:27'),
(3, 3, 1, '2022-07-21', '0.00', 'Registrado', '2022-07-21 03:17:39', '2022-07-21 03:17:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articulos_nombre_unique` (`nombre`),
  ADD KEY `articulos_idcategoria_foreign` (`idcategoria`),
  ADD KEY `articulos_idgramaje_foreign` (`idgramaje`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ingresos_idingreso_foreign` (`idingreso`),
  ADD KEY `detalle_ingresos_idinventario_foreign` (`idinventario`);

--
-- Indices de la tabla `detalle_inventarios`
--
ALTER TABLE `detalle_inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_inventarios_idinventarios_foreign` (`idinventarios`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_idventa_foreign` (`idventa`),
  ADD KEY `detalle_ventas_idinventario_foreign` (`idinventario`);

--
-- Indices de la tabla `gramajes`
--
ALTER TABLE `gramajes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gramajes_gramaje_unique` (`gramaje`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingresos_idproveedor_foreign` (`idproveedor`),
  ADD KEY `ingresos_idusuario_foreign` (`idusuario`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventarios_idproducto_foreign` (`idproducto`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_nombre_unique` (`nombre`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD KEY `proveedores_id_foreign` (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD KEY `users_id_foreign` (`id`),
  ADD KEY `users_idrol_foreign` (`idrol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_idcliente_foreign` (`idcliente`),
  ADD KEY `ventas_idusuario_foreign` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detalle_inventarios`
--
ALTER TABLE `detalle_inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gramajes`
--
ALTER TABLE `gramajes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_idcategoria_foreign` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `articulos_idgramaje_foreign` FOREIGN KEY (`idgramaje`) REFERENCES `gramajes` (`id`);

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `detalle_ingresos_idingreso_foreign` FOREIGN KEY (`idingreso`) REFERENCES `ingresos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_ingresos_idinventario_foreign` FOREIGN KEY (`idinventario`) REFERENCES `inventarios` (`id`);

--
-- Filtros para la tabla `detalle_inventarios`
--
ALTER TABLE `detalle_inventarios`
  ADD CONSTRAINT `detalle_inventarios_idinventarios_foreign` FOREIGN KEY (`idinventarios`) REFERENCES `inventarios` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_idinventario_foreign` FOREIGN KEY (`idinventario`) REFERENCES `inventarios` (`id`),
  ADD CONSTRAINT `detalle_ventas_idventa_foreign` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_idproveedor_foreign` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `ingresos_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_idproducto_foreign` FOREIGN KEY (`idproducto`) REFERENCES `articulos` (`id`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_idrol_foreign` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `ventas_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
