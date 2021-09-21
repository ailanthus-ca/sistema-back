-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-09-2021 a las 11:34:31
-- Versión del servidor: 10.2.36-MariaDB-cll-lve
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mecicama_pruebas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteinv`
--

CREATE TABLE `ajusteinv` (
  `codigo` int(11) NOT NULL,
  `tipo_ajuste` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `nota` varchar(200) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `codigo` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contacto` varchar(50) NOT NULL,
  `telefono` varchar(120) CHARACTER SET latin1 DEFAULT NULL,
  `tipo_contribuyente` varchar(50) CHARACTER SET latin1 NOT NULL,
  `retencion` double NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `codigo` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` varchar(50) NOT NULL,
  `cod_documento` varchar(50) DEFAULT NULL,
  `nun_control` varchar(50) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `fecha_documento` date DEFAULT NULL,
  `subtotal` double NOT NULL,
  `impuesto` double NOT NULL,
  `total` double NOT NULL,
  `nota` varchar(600) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `dolar` double DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conf_empresa`
--

CREATE TABLE `conf_empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `numero_fiscal` varchar(50) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `web` varchar(150) NOT NULL,
  `pago` varchar(250) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `eslogan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conf_factura`
--

CREATE TABLE `conf_factura` (
  `id` int(1) NOT NULL,
  `num_factura` int(11) NOT NULL,
  `tipo_papel` varchar(25) CHARACTER SET latin1 NOT NULL,
  `margen_sup` varchar(10) CHARACTER SET latin1 NOT NULL,
  `margen_inf` varchar(10) CHARACTER SET latin1 NOT NULL,
  `margen_izq` varchar(10) CHARACTER SET latin1 NOT NULL,
  `margen_der` varchar(10) CHARACTER SET latin1 NOT NULL,
  `inicial` tinyint(1) NOT NULL,
  `observacion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conf_region`
--

CREATE TABLE `conf_region` (
  `id` int(11) NOT NULL,
  `codigo_fiscal` varchar(50) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `impuesto` double(12,2) NOT NULL,
  `imp_esp` tinyint(1) NOT NULL,
  `impuesto1` double(12,2) NOT NULL,
  `monto1` double(12,2) NOT NULL,
  `impuesto2` double(12,2) NOT NULL,
  `monto2` double(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conf_venta`
--

CREATE TABLE `conf_venta` (
  `codigo` int(11) NOT NULL,
  `garantia` varchar(150) NOT NULL,
  `observacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `codigo` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `iva` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `forma_pago` varchar(120) NOT NULL,
  `tiempo_entrega` varchar(120) NOT NULL,
  `validez` varchar(120) NOT NULL,
  `nota` varchar(250) NOT NULL,
  `tasa` float DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL,
  `usuario` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_seguimiento`
--

CREATE TABLE `cotizacion_seguimiento` (
  `id` int(11) NOT NULL,
  `cod_cotizacion` int(6) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `codigo` varchar(4) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleajusteinv`
--

CREATE TABLE `detalleajusteinv` (
  `cod_ajuste` int(11) NOT NULL,
  `cod_producto` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `cod_compra` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` double NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecotizacion`
--

CREATE TABLE `detallecotizacion` (
  `codCotizacion` int(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` double NOT NULL,
  `monto` double NOT NULL,
  `comentario` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `codFactura` int(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` double NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleordencompra`
--

CREATE TABLE `detalleordencompra` (
  `cod_orden` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` varchar(20) NOT NULL,
  `precio_unit` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesEntrada`
--

CREATE TABLE `detallesEntrada` (
  `nota` int(10) NOT NULL,
  `producto` varchar(20) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesNotas`
--

CREATE TABLE `detallesNotas` (
  `nota` int(10) NOT NULL,
  `producto` varchar(20) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dolares`
--

CREATE TABLE `dolares` (
  `id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equilibrio`
--

CREATE TABLE `equilibrio` (
  `codigo` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `codigo` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` varchar(20) CHARACTER SET latin1 NOT NULL,
  `fecha` datetime NOT NULL,
  `condicion` varchar(20) CHARACTER SET latin1 NOT NULL,
  `porc_impuesto` double NOT NULL,
  `costo` double NOT NULL,
  `iva` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `observacion` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mejor_mes`
--

CREATE TABLE `mejor_mes` (
  `id` int(11) NOT NULL,
  `ventas` double NOT NULL,
  `mes` int(3) NOT NULL,
  `año` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `descripcion` varchar(5) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id`, `nombre`, `descripcion`, `estatus`) VALUES
(1, NULL, 'BS.F', 1),
(2, NULL, 'BS.S', 1),
(3, NULL, 'Bs.', 1),
(5, NULL, '=A=', 1),
(6, NULL, '฿', 1),
(7, NULL, '€', 1),
(8, NULL, '£', 1),
(9, NULL, 'm$n', 1),
(10, NULL, '₧', 1),
(11, NULL, 'R$', 1),
(12, NULL, '$', 1),
(13, NULL, 'EUR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notaentrada`
--

CREATE TABLE `notaentrada` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` double NOT NULL,
  `nota` varchar(600) NOT NULL,
  `estatus` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notasalida`
--

CREATE TABLE `notasalida` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` double NOT NULL,
  `nota` varchar(600) NOT NULL,
  `estatus` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordencompra`
--

CREATE TABLE `ordencompra` (
  `codigo` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `subtotal` double NOT NULL,
  `impuesto` double NOT NULL,
  `total` double NOT NULL,
  `forma_pago` varchar(120) NOT NULL,
  `tiempo_entrega` varchar(120) NOT NULL,
  `validez` varchar(120) NOT NULL,
  `nota` varchar(250) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_seguimiento`
--

CREATE TABLE `orden_seguimiento` (
  `id` int(11) NOT NULL,
  `cod_orden` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(1, 'CLIENTE'),
(2, 'COMPRA'),
(3, 'CONFIG'),
(4, 'COTIZACION'),
(5, 'DEPARTAMENTO'),
(6, 'DOLARES'),
(7, 'FACTURA'),
(8, 'NOTA'),
(9, 'ORDEN'),
(10, 'PRODUCTO'),
(11, 'PROVEEDOR'),
(12, 'REGION'),
(13, 'TIPO'),
(14, 'UNIDAD'),
(15, 'USUARIO'),
(16, 'AJUSTE'),
(17, 'MONEDA'),
(18, 'REPORTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_roles`
--

CREATE TABLE `permisos_roles` (
  `id_permiso` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos_roles`
--

INSERT INTO `permisos_roles` (`id_permiso`, `id_role`) VALUES
(1, 0),
(1, 6),
(2, 0),
(3, 0),
(4, 0),
(4, 6),
(5, 0),
(5, 1),
(6, 0),
(6, 6),
(7, 0),
(7, 6),
(8, 0),
(8, 6),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(18, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(20) CHARACTER SET latin1 NOT NULL,
  `departamento` varchar(4) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `tipo` varchar(2) CHARACTER SET latin1 NOT NULL,
  `enser` tinyint(1) NOT NULL,
  `unidad` varchar(2) CHARACTER SET latin1 NOT NULL,
  `costo` double NOT NULL,
  `precio1` double NOT NULL,
  `precio2` double NOT NULL,
  `precio3` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(200) CHARACTER SET latin1 NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `exento` tinyint(4) DEFAULT NULL,
  `dolar` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `contacto` varchar(50) NOT NULL,
  `telefono` varchar(120) DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resetclave`
--

CREATE TABLE `resetclave` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `token` varchar(250) NOT NULL,
  `creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `resetclave`
--

INSERT INTO `resetclave` (`id_usuario`, `nombre`, `token`, `creado`) VALUES
(10, 'CARLOS PERAZA', '0ad6b955020c80543e48ff004bca2f2f6636628a', '2018-01-23 10:02:01'),
(10, 'CARLOS PERAZA', '938a8e5fc6b1172bbae91e6904f893ae35dfea54', '2018-01-23 10:41:34'),
(10, 'CARLOS PERAZA', '4784c0e5eb248f430a601eb837a6f12210572efd', '2018-01-23 10:41:34'),
(10, 'CARLOS PERAZA', 'f027b647c6bd3ab46ec5c8bee0c392bdac1a0bf0', '2018-01-23 10:44:00'),
(10, 'CARLOS PERAZA', 'f025d07c0049d11a1ddbe04a00737ade697b3502', '2018-01-23 10:48:57'),
(10, 'CARLOS PERAZA', 'd34380d5a26e1d00719c509f466b6c1bfedbff8b', '2018-01-29 08:39:56'),
(10, 'CARLOS PERAZA', 'd9a333bbce3b29c2c3943c96c4de3803918b5db1', '2018-01-29 08:54:48'),
(12, 'NATALI HERNANDEZ', 'ce51d68b69f2dd04accad0ff0a3ded4780d77d4f', '2018-01-31 10:16:44'),
(22, 'ALEXIS GOYO', '4a33269ff96f3ae7b9ef7f69394e4d6320e72493', '2018-09-26 16:35:59'),
(22, 'ALEXIS GOYO', '7678b5da0dbbfc9ee7f23860a6d65241f7d0836b', '2018-09-27 13:49:49'),
(22, 'ALEXIS GOYO', 'fce612288974e072d9b9f1a99adc675b94c78d75', '2018-09-27 15:00:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(0, 'Administrador'),
(1, 'Soporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tempnotas`
--

CREATE TABLE `tempnotas` (
  `productor` varchar(20) NOT NULL,
  `catidad` float NOT NULL,
  `precio` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tempnotas`
--

INSERT INTO `tempnotas` (`productor`, `catidad`, `precio`, `usuario`) VALUES
('COMP142', 1, 4590000, 12),
('SER005', 1, 2160000, 12),
('SPTC19', 1, 12420000, 12),
('ACCE69', 1, 49595000, 2),
('RED21', 1, 297570000, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `codigo` int(3) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `inventario` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`codigo`, `descripcion`, `estatus`, `inventario`) VALUES
(1, 'PRODUCTO', 1, 3),
(2, 'SERVICIO', 1, 1),
(3, 'SOFTWARE', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_comp_prod`
--

CREATE TABLE `tmp_comp_prod` (
  `id_tmp` bigint(20) NOT NULL,
  `id_producto` varchar(10) DEFAULT NULL,
  `cantidad_tmp` int(50) DEFAULT NULL,
  `precio_tmp` double DEFAULT NULL,
  `descripcion_tmp` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_cotizacion`
--

CREATE TABLE `tmp_cotizacion` (
  `codigo` int(6) NOT NULL,
  `cod_cliente` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `iva` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `forma_pago` varchar(50) NOT NULL,
  `tiempo_entrega` varchar(50) NOT NULL,
  `validez` varchar(50) NOT NULL,
  `nota` varchar(250) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tmp_cotizacion`
--

INSERT INTO `tmp_cotizacion` (`codigo`, `cod_cliente`, `fecha`, `iva`, `subtotal`, `total`, `forma_pago`, `tiempo_entrega`, `validez`, `nota`, `estatus`, `usuario`) VALUES
(65, 'J-40431626-4', '2018-05-30 00:00:00', 300000.01, 2500000.1, 2800000.11, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(66, 'J-30807974-0', '2018-05-30 00:00:00', 66503733.6, 554197780, 620701513.6, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(69, 'J-40072709-0', '2018-06-01 00:00:00', 3114000, 25950000, 29064000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(80, 'J-31184248-9', '2018-06-07 00:00:00', 4836000, 40300000, 45136000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(82, 'J-00000000-0', '2018-06-11 00:00:00', 187823999.38, 1565199994.8, 1753023994.18, '', '', '', '', 1, 12),
(95, 'J-31463482-8', '2018-06-19 00:00:00', 306622127.76, 2555184398, 2861806525.76, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(99, 'J-00000000-0', '2018-07-18 00:00:00', 27855600, 232130000, 259985600, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'ATENCION JUAN RODRIGUEZ / ', 1, 19),
(100, 'J-00000000-0', '2018-07-18 00:00:00', 28323600, 236030000, 264353600, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'CONTACTO: JUAN RODRIGUEZ // TOTAL BS.S. 264.353,60', 1, 19),
(101, 'J-31726901-2', '2018-07-19 00:00:00', 15600000, 130000000, 145600000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'BS.S', 1, 19),
(102, 'J-30283424-4', '2018-07-19 00:00:00', 55692000, 464100000, 519792000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'BS.S 519.792,00', 1, 19),
(103, 'J-30283424-4', '2018-07-19 00:00:00', 25740000, 214500000, 240240000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', '', 1, 19),
(104, 'J-30283424-4', '2018-07-19 00:00:00', 25740000, 214500000, 240240000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'BS.S 240.240,00', 1, 19),
(106, 'J-00000000-0', '2018-07-19 00:00:00', 779040000, 6492000000, 7271040000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO', '1 DIA', 'CONTACTO: CRISTIAN MENDEZ // BS.S: 7.271.040,00', 1, 19),
(107, 'J-40337483-0', '2018-07-25 00:00:00', 311022000, 2591850000, 2902872000, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(108, 'J-41090051-2', '2018-10-31 00:00:00', 578897.52, 3618109.5, 4197007.02, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(117, 'J-30807974-0', '2019-02-05 00:00:00', 184550.4, 1153440, 1337990.4, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(118, 'J-30283424-4', '2019-02-11 00:00:00', 34000, 212500, 246500, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(120, 'J-40337483-0', '2019-02-21 00:00:00', 308160, 1926000, 2234160, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(121, 'J-40337483-0', '2019-02-21 00:00:00', 524499.46, 3278121.6, 3802621.06, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(125, 'G-20007343-8', '2019-08-19 00:00:00', 48677.38, 304233.6, 352910.98, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(126, 'J-09000043-7', '2019-08-21 00:00:00', 2323035.39, 14518971.2, 16842006.59, 'CONTADO', '3 DÍAS HÁBILES, CONTRA ORDEN DE COMPRA Y PAGO.', '1 DIA', '', 1, 12),
(128, 'J-30283424-4', '2021-07-11 11:54:04', 104832, 655200, 760032, '', '', '', '', 1, 2),
(129, 'J-30283424-4', '2021-07-11 11:54:30', 104832, 655200, 760032, '', '', '', '', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_cot_prod`
--

CREATE TABLE `tmp_cot_prod` (
  `id_tmp` bigint(20) NOT NULL,
  `id_producto` varchar(10) DEFAULT NULL,
  `cantidad_tmp` int(50) DEFAULT NULL,
  `precio_tmp` double DEFAULT NULL,
  `descripcion_tmp` varchar(250) DEFAULT NULL,
  `usuario_tmp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tmp_cot_prod`
--

INSERT INTO `tmp_cot_prod` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `descripcion_tmp`, `usuario_tmp`) VALUES
(22, 'CONS018', 2, 464100000, 'Costo: 352.000.000 (iva incluido), mas 5.000.000 envio // PROVEEDOR: https://goo.gl/yaSRS4', '20'),
(2093, 'IMPR53', 1, 366, '280$ /// flete local 2$ // DAKA', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_detalle_cotizacion`
--

CREATE TABLE `tmp_detalle_cotizacion` (
  `codCotizacion` int(6) NOT NULL,
  `codProducto` varchar(8) CHARACTER SET latin1 NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` double NOT NULL,
  `monto` double NOT NULL,
  `comentario` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tmp_detalle_cotizacion`
--

INSERT INTO `tmp_detalle_cotizacion` (`codCotizacion`, `codProducto`, `cantidad`, `precio_unit`, `monto`, `comentario`) VALUES
(0, 'ACCE578', 1, 28, 28, 'amazon cell locker 12 dlrs mas 8 envio'),
(0, 'ACCE579', 1, 145.8, 145.8, 'amazon cell locker 100 dlrs mas 8 envio'),
(0, 'SPTC17', 1, 45, 45, 'Venegroup 1 pie cubico 32 dlrs'),
(0, 'SPTC18', 1, 55, 55, 'Venegroup 8 lbs 32 dlrs'),
(2, 'COMP9', 1, 65650000, 65650000, 'COSTO: 47.500.000 IVA INCLUIDO\nENVIO: 2.500.000\nPROVEEDOR: https://goo.gl/dUYbuz'),
(2, 'RED0001', 1, 36400000, 36400000, 'COSTO: 25.000.000 MAS IVA\nPROVEEDOR: https://goo.gl/S9xGqv'),
(2, 'RED2', 1, 1761936.8, 1761936.8, 'COSTO: 1.031.550 MAS IVA / \nENVIO: 200.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'RED28', 1, 17486058.2, 17486058.2, 'COSTO: 10.223.941 MAS IVA / 13450814\nENVIO: 2000.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'RED29', 1, 123165161.6, 123165161.6, 'COSTO: 92.742.431,42 IVA INCLUIDO\nENVIO: 2.000.000\nPROVEEDOR: https://goo.gl/qsrHce'),
(2, 'SEGU18', 11, 15263994.2, 167903936.2, 'COSTO: 9.590.655 MAS IVA / \nENVIO: 1.000.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'SEGU20', 11, 19605952.6, 215665478.6, 'COSTO: 12.572.769 MAS IVA / \nENVIO: 1.000.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'SEGU23', 1, 109673616, 109673616, 'COSTO: 73.986.000,00 MAS IVA / \nEMVIO: 1.500.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'SEGU24', 22, 179614.5, 3951519, 'COSTO: 105.504 MAS IVA / 13450814\nENVIO: 20.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(2, 'UPS7', 11, 4379221.6, 48171437.6, 'COSTO: 2.114.850 MAS IVA / \nENVIO: 200.000\nPROVEEDOR: VIDEO HD TECNOLOGY'),
(4, 'ACCE2', 1, 12350000, 12350000, 'COSTO: 9.500.000 IVA INCLUIDO PROVEEDOR: https://goo.gl/LZc5AQ'),
(4, 'ACCE59', 1, 51324000, 51324000, 'COSTO: 39.480.000 INCLUYE IVA / PROVEEDOR: COPIKON https://goo.gl/eBL6mG'),
(4, 'COMP87', 1, 268297297, 268297297, 'CPU: 177.856.800  IVA INCLUIDO / COPIKON  jenny https://goo.gl/qKSABT \n\nDISCO 500 gb: 28.525.736,08 IVA INCLUIDO / https://goo.gl/8KngkU'),
(4, 'RED17', 1, 3831360, 3831360, 'COSTO: 1.560.000 mas iva /\nENVIO: 1.200.000\nPROVEEDOR: video hd tecnology'),
(4, 'SEGU17', 1, 27576394, 27576394, 'COSTO: 17.332.688 mas iva /\nENVIO: 1.800.000\nPROVEEDOR: video hd tecnology'),
(4, 'SEGU18', 1, 21413880, 21413880, 'COSTO: 13.100.192 mas iva /\nENVIO: 1.800.000\nPROVEEDOR: video hd tecnology'),
(4, 'UPS005', 1, 58370000, 58370000, 'precio 44.900.000 IVA INCLUIDO /\nPROVEEDOR: https://goo.gl/ZHDF44'),
(4, 'UPS1', 1, 4006080, 4006080, 'COSTO: 1.680.000 mas iva /\nENVIO: 1.200.000\nPROVEEDOR: video hd tecnology'),
(5, 'ACCE59', 1, 70827120, 70827120, 'COSTO: 54.482.400 INCLUYE IVA / PROVEEDOR: COPIKON https://goo.gl/eBL6mG'),
(5, 'COMP86', 1, 88400000, 88400000, 'Monitores: costo 68.000.000, proveedor Torre Mobile https://goo.gl/hKfWTB	\n'),
(5, 'COMP91', 1, 219700000, 219700000, 'CPU: 158.000.000 / TORRE MOBILE https://goo.gl/5Pa6fJ / COMBO TECLADO Y MOUSE: 11.000.000 IVA INCLUIDO / https://goo.gl/1Yj8Xo //// https://goo.gl/LZc5AQ'),
(5, 'COMP92', 1, 92300000, 92300000, 'CPU: 60.000.000 / TORRE MOBILE https://goo.gl/Ewg48p / COMBO TECLADO Y MOUSE: 11.000.000 IVA INCLUIDO / https://goo.gl/1Yj8Xo /// https://goo.gl/LZc5AQ'),
(7, 'ACCE89', 12, 6377917, 76535004, 'precio 4.906.091 con iva \nhttps://goo.gl/jJ6Mg4\n'),
(8, 'ACCE59', 1, 108411531.8, 108411531.8, 'COSTO:83.393.485,56 INCLUYE IVA / PROVEEDOR: COPIKON https://goo.gl/eBL6mG'),
(8, 'COMP015', 1, 166400000, 166400000, 'CPU: 106.999.999 IVA INCLUIDO https://goo.gl/CxBUWK TCL Y RATON: 21.000.000 https://goo.gl/ZEd1SJ'),
(8, 'COMP100', 1, 157300000, 157300000, 'CPU: 99.999.999 IVA INCLUIDO https://goo.gl/yaSYS7 TCL Y RATON: 21.000.000 https://goo.gl/ZEd1SJ'),
(8, 'COMP101', 1, 386100000, 386100000, 'CPU: 275.999.999 IVA INCLUIDO https://goo.gl/eqqp4P /  TCL Y RATON: 21.000.000 https://goo.gl/ZEd1SJ'),
(8, 'COMP23', 1, 413399998.7, 413399998.7, 'CPU: 296.999.999 https://goo.gl/PPxdwQ\nTECLADO Y MOUSE: 20.999.999 https://goo.gl/ZEd1SJ\nTORRE MOBILE\n'),
(8, 'COMP86', 1, 148200000, 148200000, 'Monitores: costo 113.999.999 proveedor Torre Mobile https://goo.gl/hKfWTB'),
(8, 'COMP91', 1, 369199998.7, 369199998.7, 'CPU: 262.999.999 https://goo.gl/eZVdEY\nTECLADO Y MOUSE: 20.999.999 https://goo.gl/ZEd1SJ\nTORRE MOBILE\n'),
(8, 'COMP95', 1, 120900000, 120900000, 'CPU 71.999.999 / PROV: TORRE MOBILE https://goo.gl/GJAXsH TECL Y MOUSE: 21.000.000 https://goo.gl/1Yj8Xo'),
(66, 'ACCE011', 11, 357500, 3932500, 'COSTO: 1.000.000 MAS IVA /\n PROVEEDOR: https://goo.gl/P69Mts ///// https://goo.gl/FYHB5o   ///// https://goo.gl/W23YPh'),
(66, 'ACCE019', 5, 19656000, 98280000, 'COSTO: 13.500.000 MAS IVA\nPROVEEDOR: https://goo.gl/pVhtks'),
(66, 'ACCE042', 12, 218400, 2620800, 'COSTO: 150.000 MAS IVA\nPROVEEDOR: https://goo.gl/V6BeCu'),
(66, 'ACCE64', 1, 46820480, 46820480, 'COSTO:  34.125.000 MAS IVA /\nENVIO: 3.500.000 / \nPROVEEDOR: https://goo.gl/D3uKmz //// https://goo.gl/EhQCqo   ////////    https://goo.gl/HFfC5x\n'),
(66, 'ACCE65', 1, 60606000, 60606000, 'COSTO:  13.980.000 MAS IVA /\nENVIO: 3.500.000 / \nPROVEEDOR: https://goo.gl/bdvaX8 ///// https://goo.gl/TLXJtT   \n'),
(66, 'ACCE68', 1, 81244800, 81244800, 'COSTO: 55.800.000 MAS IVA /\nPROVEEDOR: https://goo.gl/2Hd8EH'),
(66, 'ACCE69', 1, 30940000, 30940000, 'COSTO: 21.250.000 MAS IVA /\nPROVEEDOR: https://goo.gl/sPo8nZ  ///// https://goo.gl/bdEoFH'),
(66, 'ACCE71', 12, 2696200, 32354400, 'COSTO: 1700.000 SIN IVA\nENVIO: 170.000 C/U\nPROVEEDOR: https://goo.gl/TAcSRm'),
(66, 'ACCE72', 10, 3562000, 35620000, 'COSTO: 2.000.000 MAS IVA\nENVIO: 500.000 C/U\nPROVEEDOR: https://goo.gl/od19pP  ///// https://goo.gl/N5cs6N'),
(66, 'ACCE78', 3, 12000000, 36000000, 'COSTO: 6.000.000 MAS IVA\nENVIO 1.500.000\nROVEEDOR: https://goo.gl/MxokWC'),
(66, 'COM040', 3, 8060000, 24180000, 'COSTO:  4.800.000 MAS IVA /\nPROVEEDOR: https://goo.gl/kC5eZf  //////  https://goo.gl/hGrZeH   ///////   https://goo.gl/6GyjCx  /////// https://goo.gl/K6wne5  \n'),
(66, 'COM056', 6, 450000, 2700000, 'COSTO: 100.000 MAS IVA / GANANCIA 25% ////\nPROVEEDOR: https://goo.gl/4ihSvs'),
(66, 'RED21', 1, 98898800, 98898800, 'COSTO: 64.800.000 MAS IVA / ENVIO: 3.500.000 / PROVEEDOR: https://goo.gl/wKYb7s'),
(69, 'ACCE97', 3, 8650000, 25950000, 'COSTO: 5.150.000 SIN IVA NI FACTURA //// ENVÍO: 1.500.000 PROVEEDOR: (3) https://goo.gl/g137CJ ////// (3) https://goo.gl/iVGd15'),
(80, 'IMPR17', 1, 40300000, 40300000, 'COSTO: 25.000.000 MAS IVA\nENVIO: 3.000.000\nPROVEEDOR: https://goo.gl/sctQde'),
(82, 'COMP23', 2, 413399998.7, 826799997.4, 'CPU: 296.999.999 https://goo.gl/PPxdwQ\nTECLADO Y MOUSE: 20.999.999 https://goo.gl/ZEd1SJ\nTORRE MOBILE\n'),
(82, 'COMP91', 2, 369199998.7, 738399997.4, 'CPU: 262.999.999 https://goo.gl/eZVdEY\nTECLADO Y MOUSE: 20.999.999 https://goo.gl/ZEd1SJ\nTORRE MOBILE\n'),
(95, 'ACCE22', 20, 83481219.9, 1669624398, 'COSTO: 54.657.431 MAS IVA\nENVÍO: 3.000.000\nPROVEEDOR KODE (YELITZA)'),
(95, 'UPS9', 20, 44278000, 885560000, 'COSTO: 34.060.000 IVA INCLUIDO\nPROVEEDOR: https://goo.gl/RcAJMq'),
(99, 'COMP85', 1, 186760000, 186760000, 'COSTO: 115.000.000 MAS IVA (45%) PROVEEDOR: https://goo.gl/HHqFSN'),
(99, 'COMP97', 1, 45370000, 45370000, 'COSTO 39.400.000 // https://goo.gl/zQzNff'),
(100, 'COMP85', 1, 186760000, 186760000, 'COSTO: 115.000.000 MAS IVA (45%) PROVEEDOR: https://goo.gl/HHqFSN'),
(100, 'COMP97', 1, 49270000, 49270000, 'COSTO 39.400.000 // https://goo.gl/zQzNff'),
(101, 'COMP98', 1, 130000000, 130000000, 'Costo: 99.990.000 iva incluido. //// Proveedor: SOLUCIONES ELECTRONICAS W, CA https://goo.gl/1o5GZQ'),
(102, 'CONS018', 1, 464100000, 464100000, 'Costo: 352.000.000 (iva incluido), mas 5.000.000 envio // PROVEEDOR: https://goo.gl/yaSRS4'),
(103, 'CONS20', 1, 214500000, 214500000, 'COSTO: 160.000.000 (INCLUYE IVA), MAS ENVIO 5.000.000, PROVEEDOR: https://goo.gl/RxUi5e'),
(104, 'CONS20', 1, 214500000, 214500000, ''),
(106, 'RED30', 6, 473000000, 2838000000, 'COSTO:320.000.000, MAS IVA, ENVIO: 20.000.000 // PROVEEDOR: https://goo.gl/vYzuFi'),
(106, 'RED38', 7, 522000000, 3654000000, 'COSTO:355.000.000, MAS IVA, ENVIO: 20.000.000 // PROVEEDOR: https://goo.gl/vYzuFi'),
(107, 'COMP120', 1, 1835250000, 1835250000, 'CPU: 1.235.000.000 mas IVA  PROV: Globaltech Imperio Sistemas <jsistemaspc@gmail.com> (25%)  //// \nTECL Y MOUSE: 40.000.000 https://goo.gl/99QUb3 ////\nENVIO: 40.000.000 \n'),
(107, 'COMP93', 1, 756600000, 756600000, 'CPU: 546.999.999 https://goo.gl/HBEomn /// \nTECLADO Y MOUSE: 32.999.999 https://goo.gl/ZEd1SJ TORRE MOBILE ///\nCABLE: 1.500.000 STOCK'),
(108, 'ACCE012', 10, 226.2, 2262, '150 mas iva //// https://goo.gl/dTvadY'),
(108, 'ACCE140', 1, 1188715.9, 1188715.9, '872.075 mas iva //// envio 5.000 //// Suma Tecnologia y Servicio C.A / Ejecutiva: Maria Alejandra Rivas Ramirez'),
(108, 'COMP143', 6, 99921.6, 599529.6, 'cpu 49.138 / tecl y mouse 2.587 MAS IVA //// envio 2.500 //// LAPTOP EXPRESS, C.A. (lisbeth) 0212-5721011 (35%)'),
(108, 'COMP144', 6, 53125, 318750, '28.000 mas iva //// envio 2.500 //// https://goo.gl/a82AKk (25%)'),
(108, 'COMP146', 1, 693750, 693750, '517.160 mas iva //// envio 5.000 //// Gregory Castillo gcastillo@pcsuplidores.com'),
(108, 'RED021', 1, 28340, 28340, '17.500 mas iva //// envio 1.500 //// https://goo.gl/QcUGT5'),
(108, 'RED59', 1, 18200, 18200, '10.000 mas iva //// envio 500 //// Sr Francisco Mcbo. 0414-6417055 (30%)'),
(108, 'RED62', 1, 65312, 65312, '40.000 mas iva ////  envio 5000 //// https://goo.gl/Qamt8X'),
(108, 'RED63', 10, 325, 3250, '250 sin factura //// https://goo.gl/H89HRy'),
(108, 'UPS003', 7, 100000, 700000, '76.500 iva incluido //// envio 3500 //// https://goo.gl/ULYCs8 (25%)'),
(117, 'ACCE170', 12, 11050, 132600, '4.600 mas iva //// envio 3.000  https://bit.ly/2Sct9fd'),
(117, 'ACCE20', 4, 12090, 48360, '9.300 iva incluido https://bit.ly/2RGCc2T'),
(117, 'BACCE33', 18, 9360, 168480, '4.200 iva incluido //// envio 3.000 https://bit.ly/2S8dpdj'),
(117, 'TELF29', 2, 402000, 804000, '289.500 iva incluido /// envio 25.000 https://bit.ly/2GnW4Gf (20%)'),
(118, 'CONS34', 5, 42500, 212500, ''),
(120, 'IMPR28', 1, 676000, 676000, '520.000 IVA INCLUIDO //// https://bit.ly/2GEwYDL'),
(120, 'IMPR29', 1, 1250000, 1250000, '1.000.000 iva incluido //// https://bit.ly/2SP4dLp'),
(121, 'COMP30', 2, 342316, 684632, '227.000 MAS IVA / COPIKON (YENNY)'),
(121, 'RED0001', 3, 140168.6, 420505.8, ''),
(121, 'RED2', 24, 7150, 171600, '5.500 IVA INCLUIDO //// 0424-5647923 CIDMAR'),
(121, 'RED28', 3, 37583, 112749, '28.910 IVA INCLUIDO //// 0424-5647923 CIDMAR'),
(121, 'RED29', 1, 526500, 526500, '393.000 IVA INCLUIDO ///  ENVIO 120.000 //// https://bit.ly/2SS46i9'),
(121, 'SEGU16', 1, 465203.7, 465203.7, '308.490 mas iva //// EFA COMPUTACION '),
(121, 'SEGU24', 48, 2386.8, 114566.4, '1.582 mas iva //// EFA COMPUTACION '),
(121, 'UPS0', 1, 572557.7, 572557.7, '379.680 mas iva //// EFA COMPUTACION '),
(121, 'UPS28', 1, 34307, 34307, '22.750 MAS IVA / COPIKON (YENNY)'),
(121, 'UPS8', 1, 175500, 175500, '130.000 SIN FACTURA //// https://bit.ly/2Tc3oLG'),
(125, 'CONS37', 1, 222500, 222500, '155.000 iva incluido /// envio 30.000 /// https://bit.ly/2Tz3omZ'),
(125, 'CONS60', 1, 81733.6, 81733.6, '54.132 mas iva ////  https://bit.ly/2TxO0ax'),
(126, 'SEGU19', 5, 1269600, 6348000, '997.600  valencia flete 60mil //// carrecel https://bit.ly/33LgFxs (20%)'),
(126, 'SEGU34', 4, 98742.8, 394971.2, ''),
(126, 'SEGU35', 12, 648000, 7776000, '540.000 par iva incluido portumania  https://bit.ly/2ZjlFtQ ////\n288.000 par mas iva  masshopping  https://bit.ly/2Z9w3VN //// \n'),
(128, 'ACCE631', 0, 6552000, 655200, ''),
(129, 'ACCE631', 0, 6552000, 655200, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_fact_prod`
--

CREATE TABLE `tmp_fact_prod` (
  `id_tmp` bigint(20) NOT NULL,
  `id_producto` varchar(10) DEFAULT NULL,
  `cantidad_tmp` int(50) DEFAULT NULL,
  `precio_tmp` double DEFAULT NULL,
  `descripcion_tmp` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_ord_prod`
--

CREATE TABLE `tmp_ord_prod` (
  `id_tmp` bigint(20) NOT NULL,
  `id_producto` varchar(10) DEFAULT NULL,
  `cantidad_tmp` int(50) DEFAULT NULL,
  `precio_tmp` double DEFAULT NULL,
  `descripcion_tmp` varchar(250) DEFAULT NULL,
  `usuario_tmp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`codigo`, `descripcion`, `estatus`) VALUES
(1, 'UNIDAD', 1),
(2, 'PIEZA', 1),
(3, 'LITRO', 1),
(4, 'MILIMETRO', 1),
(5, 'CENTIMETRO', 1),
(6, 'METRO', 1),
(7, 'PIE', 1),
(8, 'GRAMO', 1),
(9, 'KILOMETRO', 1),
(10, 'COMBO', 1),
(11, 'S.G', 1),
(12, 'PULGADAS', 1),
(13, 'M2', 1),
(14, 'KGS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave` varchar(400) NOT NULL,
  `nivel` int(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codigo`, `nombre`, `correo`, `clave`, `nivel`, `estatus`) VALUES
(1, 'SOPORTE2', 'SOPORTEIT@AILANTHUS-SISTEMS.COM', '$6$VSjQkbuN$NojOl5EKcKjaBP3fqYl8DWFHIzpJ8oj.XJ8O3ll1eja02csJWh/YmmzDfA5GKJ13AKQ1ZdtrGWtiD88zFGe871', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajusteinv`
--
ALTER TABLE `ajusteinv`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_proveedor` (`cod_proveedor`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indices de la tabla `conf_empresa`
--
ALTER TABLE `conf_empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conf_factura`
--
ALTER TABLE `conf_factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conf_region`
--
ALTER TABLE `conf_region`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conf_venta`
--
ALTER TABLE `conf_venta`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_cotizacion` (`cod_cotizacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `detalleajusteinv`
--
ALTER TABLE `detalleajusteinv`
  ADD PRIMARY KEY (`cod_ajuste`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`cod_compra`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indices de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`codCotizacion`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codCotizacion`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`codFactura`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codFactura`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indices de la tabla `detalleordencompra`
--
ALTER TABLE `detalleordencompra`
  ADD PRIMARY KEY (`cod_orden`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indices de la tabla `dolares`
--
ALTER TABLE `dolares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equilibrio`
--
ALTER TABLE `equilibrio`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `mejor_mes`
--
ALTER TABLE `mejor_mes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notasalida`
--
ALTER TABLE `notasalida`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `orden_seguimiento`
--
ALTER TABLE `orden_seguimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tmp_comp_prod`
--
ALTER TABLE `tmp_comp_prod`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `tmp_cot_prod`
--
ALTER TABLE `tmp_cot_prod`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_detalle_cotizacion`
--
ALTER TABLE `tmp_detalle_cotizacion`
  ADD PRIMARY KEY (`codCotizacion`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codCotizacion`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indices de la tabla `tmp_fact_prod`
--
ALTER TABLE `tmp_fact_prod`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_ord_prod`
--
ALTER TABLE `tmp_ord_prod`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajusteinv`
--
ALTER TABLE `ajusteinv`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conf_empresa`
--
ALTER TABLE `conf_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conf_region`
--
ALTER TABLE `conf_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conf_venta`
--
ALTER TABLE `conf_venta`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dolares`
--
ALTER TABLE `dolares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equilibrio`
--
ALTER TABLE `equilibrio`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mejor_mes`
--
ALTER TABLE `mejor_mes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `notasalida`
--
ALTER TABLE `notasalida`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_seguimiento`
--
ALTER TABLE `orden_seguimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `codigo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tmp_comp_prod`
--
ALTER TABLE `tmp_comp_prod`
  MODIFY `id_tmp` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  MODIFY `codigo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `tmp_cot_prod`
--
ALTER TABLE `tmp_cot_prod`
  MODIFY `id_tmp` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2800;

--
-- AUTO_INCREMENT de la tabla `tmp_fact_prod`
--
ALTER TABLE `tmp_fact_prod`
  MODIFY `id_tmp` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tmp_ord_prod`
--
ALTER TABLE `tmp_ord_prod`
  MODIFY `id_tmp` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`codigo`);

--
-- Filtros para la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  ADD CONSTRAINT `cotizacion_seguimiento_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizacion_seguimiento_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);

--
-- Filtros para la tabla `detalleajusteinv`
--
ALTER TABLE `detalleajusteinv`
  ADD CONSTRAINT `detalleajusteinv_ibfk_1` FOREIGN KEY (`cod_ajuste`) REFERENCES `ajusteinv` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalleajusteinv_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detallecompra_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallecompra_ibfk_3` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD CONSTRAINT `detallecotizacion_ibfk_1` FOREIGN KEY (`codCotizacion`) REFERENCES `cotizacion` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallecotizacion_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codigo`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codigo`);

--
-- Filtros para la tabla `detalleordencompra`
--
ALTER TABLE `detalleordencompra`
  ADD CONSTRAINT `detalleordencompra_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalleordencompra_ibfk_3` FOREIGN KEY (`cod_orden`) REFERENCES `ordencompra` (`codigo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
