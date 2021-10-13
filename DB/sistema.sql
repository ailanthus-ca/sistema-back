-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2021 at 07:27 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajusteinv`
--

CREATE TABLE `ajusteinv` (
  `codigo` int(11) UNSIGNED ZEROFILL NOT NULL,
  `tipo_ajuste` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `nota` varchar(200) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
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
-- Table structure for table `compra`
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
  `nota` varchar(600) NOT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `dolar` double NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion`
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
-- Table structure for table `cotizacion_seguimiento`
--

CREATE TABLE `cotizacion_seguimiento` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `cod_cotizacion` int(6) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `creditosemitidos`
--

CREATE TABLE `creditosemitidos` (
  `codigo` int(11) NOT NULL,
  `cod_factura` int(10) UNSIGNED ZEROFILL NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` text NOT NULL,
  `monto` double NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `creditosrecibidos`
--

CREATE TABLE `creditosrecibidos` (
  `codigo` int(11) NOT NULL,
  `cod_compra` int(10) UNSIGNED ZEROFILL NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` text NOT NULL,
  `monto` double NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `debitosemitidos`
--

CREATE TABLE `debitosemitidos` (
  `codigo` int(11) NOT NULL,
  `cod_factura` int(10) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` text NOT NULL,
  `monto` double NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `debitosrecibidos`
--

CREATE TABLE `debitosrecibidos` (
  `codigo` int(11) NOT NULL,
  `cod_compra` int(10) UNSIGNED ZEROFILL NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` text NOT NULL,
  `monto` double NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `codigo` varchar(4) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detalleajusteinv`
--

CREATE TABLE `detalleajusteinv` (
  `cod_ajuste` int(11) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detallecompra`
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
-- Table structure for table `detallecotizacion`
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
-- Table structure for table `detallefactura`
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
-- Table structure for table `detalleordencompra`
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
-- Table structure for table `detallescreditosemitidos`
--

CREATE TABLE `detallescreditosemitidos` (
  `nota` int(11) NOT NULL,
  `producto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detallescreditosrecibidos`
--

CREATE TABLE `detallescreditosrecibidos` (
  `nota` int(11) NOT NULL,
  `producto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detallesdebitosemitidos`
--

CREATE TABLE `detallesdebitosemitidos` (
  `nota` int(11) NOT NULL,
  `producto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detallesdebitosrecibidos`
--

CREATE TABLE `detallesdebitosrecibidos` (
  `nota` int(11) NOT NULL,
  `producto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detallesnotas`
--

CREATE TABLE `detallesnotas` (
  `nota` int(10) UNSIGNED ZEROFILL NOT NULL,
  `producto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `cantidad` float NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dolares`
--

CREATE TABLE `dolares` (
  `id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equilibrio`
--

CREATE TABLE `equilibrio` (
  `codigo` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `factura`
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
-- Table structure for table `mejor_mes`
--

CREATE TABLE `mejor_mes` (
  `id` int(11) NOT NULL,
  `ventas` double NOT NULL,
  `mes` int(3) NOT NULL,
  `año` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `descripcion` varchar(5) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notasalida`
--

CREATE TABLE `notasalida` (
  `codigo` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` varchar(20) CHARACTER SET latin1 NOT NULL,
  `fecha` datetime NOT NULL,
  `total` double NOT NULL,
  `nota` varchar(600) NOT NULL,
  `estatus` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ordencompra`
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
-- Table structure for table `orden_seguimiento`
--

CREATE TABLE `orden_seguimiento` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `cod_orden` int(11) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permisos_roles`
--

CREATE TABLE `permisos_roles` (
  `id_permiso` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(20) CHARACTER SET latin1 NOT NULL,
  `departamento` varchar(4) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `tipo` int(3) NOT NULL,
  `enser` tinyint(1) NOT NULL,
  `unidad` int(11) NOT NULL,
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
-- Table structure for table `proveedor`
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
-- Table structure for table `resetclave`
--

CREATE TABLE `resetclave` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `token` varchar(250) NOT NULL,
  `creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `codigo` int(3) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `inventario` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_cotizacion`
--

CREATE TABLE `tmp_cotizacion` (
  `codigo` int(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` varchar(20) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tmp_detalle_cotizacion`
--

CREATE TABLE `tmp_detalle_cotizacion` (
  `codCotizacion` int(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` varchar(8) CHARACTER SET latin1 NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unit` double NOT NULL,
  `monto` double NOT NULL,
  `comentario` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

CREATE TABLE `unidad` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave` varchar(400) NOT NULL,
  `nivel` int(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
