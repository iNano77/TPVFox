-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-09-2018 a las 20:15:34
-- Versión del servidor: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpvfox`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albclifac`
--

DROP TABLE IF EXISTS `albclifac`;
CREATE TABLE `albclifac` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `numFactura` int(11) DEFAULT NULL,
  `idAlbaran` int(11) DEFAULT NULL,
  `numAlbaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albcliIva`
--

DROP TABLE IF EXISTS `albcliIva`;
CREATE TABLE `albcliIva` (
  `id` int(11) NOT NULL,
  `idalbcli` int(11) NOT NULL,
  `Numalbcli` int(11) NOT NULL,
  `iva` int(11) DEFAULT NULL,
  `importeIva` decimal(17,2) DEFAULT NULL,
  `totalbase` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albclilinea`
--

DROP TABLE IF EXISTS `albclilinea`;
CREATE TABLE `albclilinea` (
  `id` int(11) NOT NULL,
  `idalbcli` int(11) NOT NULL,
  `Numalbcli` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) DEFAULT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `precioCiva` decimal(17,2) DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `nfila` int(11) DEFAULT NULL,
  `estadoLinea` varchar(12) DEFAULT NULL,
  `NumpedCli` int(100) DEFAULT NULL,
  `pvpSiva` decimal(17,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albcliltemporales`
--

DROP TABLE IF EXISTS `albcliltemporales`;
CREATE TABLE `albcliltemporales` (
  `id` int(11) NOT NULL,
  `numalbcli` int(11) DEFAULT NULL,
  `estadoAlbCli` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idClientes` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `Pedidos` varbinary(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albclit`
--

DROP TABLE IF EXISTS `albclit`;
CREATE TABLE `albclit` (
  `id` int(11) NOT NULL,
  `Numalbcli` int(11) NOT NULL,
  `Numtemp_albcli` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `entregado` decimal(17,2) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albprofac`
--

DROP TABLE IF EXISTS `albprofac`;
CREATE TABLE `albprofac` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `numFactura` int(11) DEFAULT NULL,
  `idAlbaran` int(11) DEFAULT NULL,
  `numAlbaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albproIva`
--

DROP TABLE IF EXISTS `albproIva`;
CREATE TABLE `albproIva` (
  `id` int(11) NOT NULL,
  `idalbpro` int(11) NOT NULL,
  `Numalbpro` int(11) NOT NULL,
  `iva` int(11) DEFAULT NULL,
  `importeIva` decimal(17,2) DEFAULT NULL,
  `totalbase` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albprolinea`
--

DROP TABLE IF EXISTS `albprolinea`;
CREATE TABLE `albprolinea` (
  `id` int(11) NOT NULL,
  `idalbpro` int(11) NOT NULL,
  `Numalbpro` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) DEFAULT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `costeSiva` decimal(17,4) DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `nfila` int(11) DEFAULT NULL,
  `estadoLinea` varchar(12) DEFAULT NULL,
  `ref_prov` varchar(18) NOT NULL,
  `Numpedpro` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albproltemporales`
--

DROP TABLE IF EXISTS `albproltemporales`;
CREATE TABLE `albproltemporales` (
  `id` int(11) NOT NULL,
  `numalbpro` int(11) DEFAULT NULL,
  `Su_numero` varchar(20) NOT NULL,
  `estadoAlbPro` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `Pedidos` varbinary(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albprot`
--

DROP TABLE IF EXISTS `albprot`;
CREATE TABLE `albprot` (
  `id` int(11) NOT NULL,
  `Numalbpro` int(11) NOT NULL,
  `Numtemp_albpro` int(11) DEFAULT NULL,
  `Su_numero` varchar(20) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `entregado` decimal(17,2) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL,
  `FechaVencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

DROP TABLE IF EXISTS `articulos`;
CREATE TABLE `articulos` (
  `idArticulo` int(11) NOT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `idProveedor` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `articulo_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `beneficio` decimal(5,2) DEFAULT NULL,
  `costepromedio` decimal(17,6) DEFAULT NULL,
  `estado` varchar(12) CHARACTER SET utf8 NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `fecha_modificado` datetime NOT NULL,
  `ultimoCoste` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `articulos` CHANGE `fecha_creado` `fecha_creado` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `articulos` CHANGE `fecha_modificado` `fecha_modificado` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosClientes`
--

DROP TABLE IF EXISTS `articulosClientes`;
CREATE TABLE `articulosClientes` (
  `idArticulo` int(11) NOT NULL,
  `idClientes` int(11) NOT NULL,
  `pvpSiva` decimal(17,6) NOT NULL,
  `pvpCiva` decimal(17,6) NOT NULL,
  `fechaActualizacion` datetime NOT NULL,
  `estado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosCodigoBarras`
--

DROP TABLE IF EXISTS `articulosCodigoBarras`;
CREATE TABLE `articulosCodigoBarras` (
  `idArticulo` int(11) NOT NULL,
  `codBarras` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosFamilias`
--

DROP TABLE IF EXISTS `articulosFamilias`;
CREATE TABLE `articulosFamilias` (
  `idArticulo` int(11) NOT NULL,
  `idFamilia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosPrecios`
--

DROP TABLE IF EXISTS `articulosPrecios`;
CREATE TABLE `articulosPrecios` (
  `idArticulo` int(11) NOT NULL,
  `pvpCiva` decimal(17,6) NOT NULL,
  `pvpSiva` decimal(17,6) NOT NULL,
  `idTienda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosProveedores`
--

DROP TABLE IF EXISTS `articulosProveedores`;
CREATE TABLE `articulosProveedores` (
  `idArticulo` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `crefProveedor` varchar(24) DEFAULT NULL,
  `coste` decimal(17,6) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `estado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosStocks`
--

DROP TABLE IF EXISTS `articulosStocks`;
CREATE TABLE `articulosStocks` (
  `id` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `stockMin` decimal(17,6) NOT NULL,
  `stockMax` decimal(17,6) NOT NULL,
  `stockOn` decimal(17,6) NOT NULL,
  `fecha_modificado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaRegularizacion` datetime DEFAULT NULL,
  `usuarioRegularizacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulosTiendas`
--

DROP TABLE IF EXISTS `articulosTiendas`;
CREATE TABLE `articulosTiendas` (
  `idArticulo` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `crefTienda` varchar(18) NOT NULL,
  `idVirtuemart` int(11) NOT NULL,
  `estado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres`
--

DROP TABLE IF EXISTS `cierres`;
CREATE TABLE `cierres` (
  `idCierre` int(11) NOT NULL,
  `FechaCierre` date NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFinal` datetime NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Total` decimal(17,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_ivas`
--

DROP TABLE IF EXISTS `cierres_ivas`;
CREATE TABLE `cierres_ivas` (
  `id` int(11) NOT NULL,
  `idCierre` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `tipo_iva` int(11) NOT NULL,
  `importe_base` decimal(17,4) NOT NULL,
  `importe_iva` decimal(17,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_usuariosFormasPago`
--

DROP TABLE IF EXISTS `cierres_usuariosFormasPago`;
CREATE TABLE `cierres_usuariosFormasPago` (
  `id` int(11) NOT NULL,
  `idCierre` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `FormasPago` varchar(100) NOT NULL,
  `importe` decimal(17,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_usuarios_tickets`
--

DROP TABLE IF EXISTS `cierres_usuarios_tickets`;
CREATE TABLE `cierres_usuarios_tickets` (
  `id` int(11) NOT NULL,
  `idCierre` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `Importe` decimal(17,4) NOT NULL,
  `Num_ticket_inicial` int(11) NOT NULL,
  `Num_ticket_final` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `idClientes` int(11) NOT NULL,
  `Nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `razonsocial` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nif` varchar(10) CHARACTER SET utf8 NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 NOT NULL,
  `codpostal` varchar(32) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `movil` varchar(11) NOT NULL,
  `fax` varchar(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `estado` varchar(12) CHARACTER SET utf8 NOT NULL,
  `fomasVenci` varchar(250) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idClientes`, `Nombre`, `razonsocial`, `nif`, `direccion`, `codpostal`, `telefono`, `movil`, `fax`, `email`, `estado`, `fomasVenci`, `fecha_creado`) VALUES
(1, 'Sin identificar', 'Sin identificar', '', '', '', '', '', '', '', '', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cli_FroPa_TipoVen`
--

DROP TABLE IF EXISTS `Cli_FroPa_TipoVen`;
CREATE TABLE `Cli_FroPa_TipoVen` (
  `id` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idFormasPago` int(11) NOT NULL,
  `idTiposVencimiento` int(11) NOT NULL,
  `Predeterminado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faccliIva`
--

DROP TABLE IF EXISTS `faccliIva`;
CREATE TABLE `faccliIva` (
  `id` int(11) NOT NULL,
  `idfaccli` int(11) NOT NULL,
  `Numfaccli` int(11) NOT NULL,
  `iva` int(11) DEFAULT NULL,
  `importeIva` decimal(17,2) DEFAULT NULL,
  `totalbase` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facclilinea`
--

DROP TABLE IF EXISTS `facclilinea`;
CREATE TABLE `facclilinea` (
  `id` int(11) NOT NULL,
  `idfaccli` int(11) NOT NULL,
  `Numfaccli` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) DEFAULT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `precioCiva` decimal(17,2) DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `nfila` int(11) DEFAULT NULL,
  `estadoLinea` varchar(12) DEFAULT NULL,
  `NumalbCli` int(100) DEFAULT NULL,
  `pvpSiva` decimal(17,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faccliltemporales`
--

DROP TABLE IF EXISTS `faccliltemporales`;
CREATE TABLE `faccliltemporales` (
  `id` int(11) NOT NULL,
  `numfaccli` int(11) DEFAULT NULL,
  `estadoFacCli` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idClientes` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `Albaranes` varbinary(5000) DEFAULT NULL,
  `FacCobros` varbinary(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facclit`
--

DROP TABLE IF EXISTS `facclit`;
CREATE TABLE `facclit` (
  `id` int(11) NOT NULL,
  `Numfaccli` int(11) NOT NULL,
  `Numtemp_faccli` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaVencimiento` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facProCobros`
--

DROP TABLE IF EXISTS `facProCobros`;
CREATE TABLE `facProCobros` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idFormasPago` int(11) NOT NULL,
  `FechaPago` date NOT NULL,
  `importe` float NOT NULL,
  `Referencia` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facproIva`
--

DROP TABLE IF EXISTS `facproIva`;
CREATE TABLE `facproIva` (
  `id` int(11) NOT NULL,
  `idfacpro` int(11) NOT NULL,
  `Numfacpro` int(11) NOT NULL,
  `iva` int(11) DEFAULT NULL,
  `importeIva` decimal(17,2) DEFAULT NULL,
  `totalbase` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facprolinea`
--

DROP TABLE IF EXISTS `facprolinea`;
CREATE TABLE `facprolinea` (
  `id` int(11) NOT NULL,
  `idfacpro` int(11) NOT NULL,
  `Numfacpro` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) DEFAULT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `costeSiva` decimal(17,4) DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `nfila` int(11) DEFAULT NULL,
  `estadoLinea` varchar(12) DEFAULT NULL,
  `ref_prov` varchar(250) DEFAULT NULL,
  `Numalbpro` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facproltemporales`
--

DROP TABLE IF EXISTS `facproltemporales`;
CREATE TABLE `facproltemporales` (
  `id` int(11) NOT NULL,
  `numfacpro` int(11) DEFAULT NULL,
  `estadoFacPro` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `Albaranes` varbinary(50000) DEFAULT NULL,
  `Su_numero` varchar(20) DEFAULT NULL,
  `FacCobros` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facprot`
--

DROP TABLE IF EXISTS `facprot`;
CREATE TABLE `facprot` (
  `id` int(11) NOT NULL,
  `Numfacpro` int(11) NOT NULL,
  `Numtemp_facpro` int(11) DEFAULT NULL,
  `Su_num_factura` varchar(20) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `entregado` decimal(17,2) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fac_cobros`
--

DROP TABLE IF EXISTS `fac_cobros`;
CREATE TABLE `fac_cobros` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idFormasPago` int(11) NOT NULL,
  `FechaPago` date NOT NULL,
  `importe` float NOT NULL,
  `Referencia` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

DROP TABLE IF EXISTS `familias`;
CREATE TABLE `familias` (
  `idFamilia` int(11) NOT NULL,
  `familiaNombre` varchar(100) NOT NULL DEFAULT '',
  `familiaPadre` int(11) NOT NULL,
  `beneficiomedio` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiasTienda`
--

DROP TABLE IF EXISTS `familiasTienda`;
CREATE TABLE `familiasTienda` (
  `idFamilia` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `ref_familia_tienda` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formasPago`
--

DROP TABLE IF EXISTS `formasPago`;
CREATE TABLE `formasPago` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `formasPago`
--

INSERT INTO `formasPago` (`id`, `descripcion`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta'),
(3, 'Recibo bancario'),
(4, 'Transferencia bancaria'),
(5, 'Talón');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_precios`
--

DROP TABLE IF EXISTS `historico_precios`;
CREATE TABLE `historico_precios` (
  `id` int(11) NOT NULL,
  `idArticulo` int(10) NOT NULL,
  `Antes` decimal(17,4) NOT NULL,
  `Nuevo` decimal(17,4) NOT NULL,
  `Fecha_Creacion` datetime NOT NULL,
  `NumDoc` int(11) NOT NULL,
  `Dedonde` varchar(50) NOT NULL,
  `Tipo` varchar(50) NOT NULL,
  `idUsuario` int(5) DEFAULT NULL,
  `estado` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importar_virtuemart_tickets`
--

DROP TABLE IF EXISTS `importar_virtuemart_tickets`;
CREATE TABLE `importar_virtuemart_tickets` (
  `id` int(11) NOT NULL,
  `idTicketst` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `estado` varchar(12) NOT NULL,
  `respuesta` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indices`
--

DROP TABLE IF EXISTS `indices`;
CREATE TABLE `indices` (
  `id` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `numticket` int(11) NOT NULL,
  `tempticket` int(11) NOT NULL COMMENT 'Es el numero con guardo temporal ticket'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

DROP TABLE IF EXISTS `iva`;
CREATE TABLE `iva` (
  `idIva` int(11) NOT NULL,
  `descripcionIva` varchar(25) DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `recargo` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migraciones`
--

DROP TABLE IF EXISTS `migraciones`;
CREATE TABLE `migraciones` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_configuracion`
--

DROP TABLE IF EXISTS `modulos_configuracion`;
CREATE TABLE `modulos_configuracion` (
  `idusuario` int(11) NOT NULL,
  `nombre_modulo` varchar(50) NOT NULL,
  `configuracion` varbinary(50000) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_etiquetado`
--

DROP TABLE IF EXISTS `modulo_etiquetado`;
CREATE TABLE `modulo_etiquetado` (
  `id` int(11) NOT NULL,
  `num_lote` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `fecha_env` datetime NOT NULL,
  `fecha_cad` date NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `numAlb` int(11) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `productos` varbinary(50000) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_etiquetado_temporal`
--

DROP TABLE IF EXISTS `modulo_etiquetado_temporal`;
CREATE TABLE `modulo_etiquetado_temporal` (
  `id` int(11) NOT NULL,
  `num_lote` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `fecha_env` datetime NOT NULL,
  `fecha_cad` date NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `numAlb` int(11) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `productos` varbinary(50000) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_incidencia`
--

DROP TABLE IF EXISTS `modulo_incidencia`;
CREATE TABLE `modulo_incidencia` (
  `id` int(11) NOT NULL,
  `num_incidencia` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `dedonde` varchar(15) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `datos` varbinary(10000) NOT NULL,
  `estado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedcliAlb`
--

DROP TABLE IF EXISTS `pedcliAlb`;
CREATE TABLE `pedcliAlb` (
  `id` int(11) NOT NULL,
  `idAlbaran` int(11) DEFAULT NULL,
  `numAlbaran` int(11) DEFAULT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `numPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedcliIva`
--

DROP TABLE IF EXISTS `pedcliIva`;
CREATE TABLE `pedcliIva` (
  `id` int(11) NOT NULL,
  `idpedcli` int(11) NOT NULL,
  `Numpedcli` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `importeIva` decimal(17,2) NOT NULL,
  `totalbase` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedclilinea`
--

DROP TABLE IF EXISTS `pedclilinea`;
CREATE TABLE `pedclilinea` (
  `id` int(11) NOT NULL,
  `idpedcli` int(11) NOT NULL,
  `Numpedcli` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) NOT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `precioCiva` decimal(17,2) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `nfila` int(11) NOT NULL,
  `estadoLinea` varchar(12) NOT NULL,
  `pvpSiva` decimal(17,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedcliltemporales`
--

DROP TABLE IF EXISTS `pedcliltemporales`;
CREATE TABLE `pedcliltemporales` (
  `id` int(11) NOT NULL,
  `estadoPedCli` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idClientes` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `idPedcli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedclit`
--

DROP TABLE IF EXISTS `pedclit`;
CREATE TABLE `pedclit` (
  `id` int(11) NOT NULL,
  `Numpedcli` int(11) DEFAULT NULL,
  `Numtemp_pedcli` int(11) NOT NULL,
  `FechaPedido` date NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `entregado` decimal(17,2) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedproAlb`
--

DROP TABLE IF EXISTS `pedproAlb`;
CREATE TABLE `pedproAlb` (
  `id` int(11) NOT NULL,
  `idAlbaran` int(11) DEFAULT NULL,
  `numAlbaran` int(11) DEFAULT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `numPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedproIva`
--

DROP TABLE IF EXISTS `pedproIva`;
CREATE TABLE `pedproIva` (
  `id` int(11) NOT NULL,
  `idpedpro` int(11) NOT NULL,
  `Numpedpro` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `importeIva` decimal(17,2) NOT NULL,
  `totalbase` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedprolinea`
--

DROP TABLE IF EXISTS `pedprolinea`;
CREATE TABLE `pedprolinea` (
  `id` int(11) NOT NULL,
  `idpedpro` int(11) NOT NULL,
  `Numpedpro` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) DEFAULT NULL,
  `ref_prov` varchar(18) NOT NULL,
  `ccodbar` varchar(18) DEFAULT NULL,
  `cdetalle` varchar(100) NOT NULL,
  `ncant` decimal(17,6) DEFAULT NULL,
  `nunidades` decimal(17,6) DEFAULT NULL,
  `costeSiva` decimal(17,4) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `nfila` int(11) NOT NULL,
  `estadoLinea` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedprot`
--

DROP TABLE IF EXISTS `pedprot`;
CREATE TABLE `pedprot` (
  `id` int(11) NOT NULL,
  `Numpedpro` int(11) DEFAULT NULL,
  `Numtemp_pedpro` int(11) NOT NULL,
  `FechaPedido` date NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `formaPago` varchar(12) DEFAULT NULL,
  `entregado` decimal(17,2) DEFAULT NULL,
  `total` decimal(17,2) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedprotemporales`
--

DROP TABLE IF EXISTS `pedprotemporales`;
CREATE TABLE `pedprotemporales` (
  `id` int(11) NOT NULL,
  `estadoPedPro` varchar(12) DEFAULT NULL,
  `idTienda` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFinal` datetime DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `total` decimal(17,6) DEFAULT NULL,
  `total_ivas` varchar(250) DEFAULT NULL,
  `Productos` mediumblob,
  `idPedpro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `modulo` varchar(50) DEFAULT NULL,
  `vista` varchar(50) DEFAULT NULL,
  `accion` varchar(50) DEFAULT NULL,
  `permiso` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombrecomercial` varchar(100) DEFAULT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `fax` varchar(11) NOT NULL,
  `movil` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `estado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stocksRegularizacion`
--

DROP TABLE IF EXISTS `stocksRegularizacion`;
CREATE TABLE `stocksRegularizacion` (
  `id` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `idTienda` int(11) NOT NULL DEFAULT '1',
  `fechaRegularizacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stockActual` decimal(17,6) NOT NULL,
  `stockModif` decimal(17,6) NOT NULL,
  `stockFinal` decimal(17,6) NOT NULL,
  `stockOperacion` int(1) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `idAlbaran` int(11) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '1',
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketslinea`
--

DROP TABLE IF EXISTS `ticketslinea`;
CREATE TABLE `ticketslinea` (
  `id` int(11) NOT NULL,
  `idticketst` int(11) NOT NULL,
  `Numticket` int(11) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `cref` varchar(18) NOT NULL,
  `ccodbar` varchar(18) NOT NULL,
  `cdetalle` varchar(100) NOT NULL,
  `ncant` decimal(17,6) NOT NULL,
  `nunidades` decimal(17,6) NOT NULL,
  `precioCiva` decimal(17,2) NOT NULL,
  `iva` decimal(4,2) NOT NULL,
  `nfila` int(11) NOT NULL,
  `estadoLinea` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketst`
--

DROP TABLE IF EXISTS `ticketst`;
CREATE TABLE `ticketst` (
  `id` int(11) NOT NULL,
  `Numticket` int(11) NOT NULL,
  `Numtempticket` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `formaPago` varchar(12) NOT NULL,
  `entregado` decimal(17,2) NOT NULL,
  `total` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketstemporales`
--

DROP TABLE IF EXISTS `ticketstemporales`;
CREATE TABLE `ticketstemporales` (
  `id` int(11) NOT NULL,
  `numticket` int(11) NOT NULL,
  `estadoTicket` varchar(12) NOT NULL,
  `idTienda` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFinal` datetime NOT NULL,
  `idClientes` int(11) NOT NULL,
  `total` decimal(17,6) NOT NULL,
  `total_ivas` varchar(250) NOT NULL,
  `Productos` mediumblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketstIva`
--

DROP TABLE IF EXISTS `ticketstIva`;
CREATE TABLE `ticketstIva` (
  `id` int(11) NOT NULL,
  `idticketst` int(11) NOT NULL,
  `Numticket` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `importeIva` decimal(17,2) NOT NULL,
  `totalbase` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

DROP TABLE IF EXISTS `tiendas`;
CREATE TABLE `tiendas` (
  `idTienda` int(2) NOT NULL,
  `tipoTienda` varchar(10) NOT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `estado` varchar(12) DEFAULT NULL,
  `NombreComercial` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `dominio` varchar(100) NOT NULL,
  `key_api` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiendas`
--

INSERT INTO `tiendas` (`idTienda`, `tipoTienda`, `razonsocial`, `nif`, `telefono`, `estado`, `NombreComercial`, `direccion`, `ano`, `dominio`, `key_api`) VALUES
(1, 'principal', 'Tienda física', 'B36000000', '986000000', 'activo', 'Super TpvFox', 'Emilia Pardo Bazan, 52 -bajo', '2018', '', ''),
(2, 'web', 'Tienda Web', 'B36111111', '600000000 ', 'cerrado', NULL, '', NULL, 'www.tpvfox.es', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposVencimiento`
--

DROP TABLE IF EXISTS `tiposVencimiento`;
CREATE TABLE `tiposVencimiento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  `dias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `group_id` int(11) NOT NULL COMMENT 'id grupo permisos',
  `estado` varchar(12) NOT NULL COMMENT 'estado',
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `fecha`, `group_id`, `estado`, `nombre`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2017-09-06', 9, 'activo', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albclifac`
--
ALTER TABLE `albclifac`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albcliIva`
--
ALTER TABLE `albcliIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albclilinea`
--
ALTER TABLE `albclilinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albcliltemporales`
--
ALTER TABLE `albcliltemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albclit`
--
ALTER TABLE `albclit`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albprofac`
--
ALTER TABLE `albprofac`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albproIva`
--
ALTER TABLE `albproIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albprolinea`
--
ALTER TABLE `albprolinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albproltemporales`
--
ALTER TABLE `albproltemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `albprot`
--
ALTER TABLE `albprot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idArticulo`),
  ADD KEY `idProveedor` (`idProveedor`);

--
-- Indices de la tabla `articulosClientes`
--
ALTER TABLE `articulosClientes`
  ADD PRIMARY KEY (`idArticulo`,`idClientes`);

--
-- Indices de la tabla `articulosFamilias`
--
ALTER TABLE `articulosFamilias`
  ADD PRIMARY KEY (`idArticulo`,`idFamilia`),
  ADD KEY `fk_categoriaFamilias` (`idFamilia`),
  ADD KEY `fk_articulos` (`idArticulo`);

--
-- Indices de la tabla `articulosProveedores`
--
ALTER TABLE `articulosProveedores`
  ADD PRIMARY KEY (`idArticulo`,`idProveedor`);

--
-- Indices de la tabla `articulosStocks`
--
ALTER TABLE `articulosStocks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `articulosTiendas`
--
ALTER TABLE `articulosTiendas`
  ADD PRIMARY KEY (`idArticulo`,`idTienda`),
  ADD KEY `idTienda` (`idTienda`);

--
-- Indices de la tabla `cierres`
--
ALTER TABLE `cierres`
  ADD PRIMARY KEY (`idCierre`);

--
-- Indices de la tabla `cierres_ivas`
--
ALTER TABLE `cierres_ivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierres_usuariosFormasPago`
--
ALTER TABLE `cierres_usuariosFormasPago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierres_usuarios_tickets`
--
ALTER TABLE `cierres_usuarios_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idClientes`);

--
-- Indices de la tabla `Cli_FroPa_TipoVen`
--
ALTER TABLE `Cli_FroPa_TipoVen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `faccliIva`
--
ALTER TABLE `faccliIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facclilinea`
--
ALTER TABLE `facclilinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `faccliltemporales`
--
ALTER TABLE `faccliltemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facclit`
--
ALTER TABLE `facclit`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facProCobros`
--
ALTER TABLE `facProCobros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facproIva`
--
ALTER TABLE `facproIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facprolinea`
--
ALTER TABLE `facprolinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facproltemporales`
--
ALTER TABLE `facproltemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facprot`
--
ALTER TABLE `facprot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fac_cobros`
--
ALTER TABLE `fac_cobros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`idFamilia`);

--
-- Indices de la tabla `formasPago`
--
ALTER TABLE `formasPago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historico_precios`
--
ALTER TABLE `historico_precios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `importar_virtuemart_tickets`
--
ALTER TABLE `importar_virtuemart_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `indices`
--
ALTER TABLE `indices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`idIva`);

--
-- Indices de la tabla `migraciones`
--
ALTER TABLE `migraciones`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `modulo_etiquetado`
--
ALTER TABLE `modulo_etiquetado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo_etiquetado_temporal`
--
ALTER TABLE `modulo_etiquetado_temporal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo_incidencia`
--
ALTER TABLE `modulo_incidencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedcliAlb`
--
ALTER TABLE `pedcliAlb`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedcliIva`
--
ALTER TABLE `pedcliIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedclilinea`
--
ALTER TABLE `pedclilinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedcliltemporales`
--
ALTER TABLE `pedcliltemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedclit`
--
ALTER TABLE `pedclit`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedproAlb`
--
ALTER TABLE `pedproAlb`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedproIva`
--
ALTER TABLE `pedproIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedprolinea`
--
ALTER TABLE `pedprolinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedprot`
--
ALTER TABLE `pedprot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedprotemporales`
--
ALTER TABLE `pedprotemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`);
ALTER TABLE `proveedores` ADD FULLTEXT KEY `nombrecomercial` (`nombrecomercial`);

--
-- Indices de la tabla `stocksRegularizacion`
--
ALTER TABLE `stocksRegularizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketslinea`
--
ALTER TABLE `ticketslinea`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketst`
--
ALTER TABLE `ticketst`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketstemporales`
--
ALTER TABLE `ticketstemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticketstIva`
--
ALTER TABLE `ticketstIva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`idTienda`);

--
-- Indices de la tabla `tiposVencimiento`
--
ALTER TABLE `tiposVencimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albclifac`
--
ALTER TABLE `albclifac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albcliIva`
--
ALTER TABLE `albcliIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albclilinea`
--
ALTER TABLE `albclilinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albcliltemporales`
--
ALTER TABLE `albcliltemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albclit`
--
ALTER TABLE `albclit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albprofac`
--
ALTER TABLE `albprofac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albproIva`
--
ALTER TABLE `albproIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albprolinea`
--
ALTER TABLE `albprolinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albproltemporales`
--
ALTER TABLE `albproltemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `albprot`
--
ALTER TABLE `albprot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `idArticulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulosStocks`
--
ALTER TABLE `articulosStocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres`
--
ALTER TABLE `cierres`
  MODIFY `idCierre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres_ivas`
--
ALTER TABLE `cierres_ivas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres_usuariosFormasPago`
--
ALTER TABLE `cierres_usuariosFormasPago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierres_usuarios_tickets`
--
ALTER TABLE `cierres_usuarios_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idClientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Cli_FroPa_TipoVen`
--
ALTER TABLE `Cli_FroPa_TipoVen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faccliIva`
--
ALTER TABLE `faccliIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facclilinea`
--
ALTER TABLE `facclilinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faccliltemporales`
--
ALTER TABLE `faccliltemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facclit`
--
ALTER TABLE `facclit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facProCobros`
--
ALTER TABLE `facProCobros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facproIva`
--
ALTER TABLE `facproIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facprolinea`
--
ALTER TABLE `facprolinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facproltemporales`
--
ALTER TABLE `facproltemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facprot`
--
ALTER TABLE `facprot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fac_cobros`
--
ALTER TABLE `fac_cobros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `idFamilia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formasPago`
--
ALTER TABLE `formasPago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historico_precios`
--
ALTER TABLE `historico_precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `importar_virtuemart_tickets`
--
ALTER TABLE `importar_virtuemart_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indices`
--
ALTER TABLE `indices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `iva`
--
ALTER TABLE `iva`
  MODIFY `idIva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo_etiquetado`
--
ALTER TABLE `modulo_etiquetado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo_etiquetado_temporal`
--
ALTER TABLE `modulo_etiquetado_temporal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo_incidencia`
--
ALTER TABLE `modulo_incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedcliAlb`
--
ALTER TABLE `pedcliAlb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedcliIva`
--
ALTER TABLE `pedcliIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedclilinea`
--
ALTER TABLE `pedclilinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedcliltemporales`
--
ALTER TABLE `pedcliltemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedclit`
--
ALTER TABLE `pedclit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedproAlb`
--
ALTER TABLE `pedproAlb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedproIva`
--
ALTER TABLE `pedproIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedprolinea`
--
ALTER TABLE `pedprolinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedprot`
--
ALTER TABLE `pedprot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedprotemporales`
--
ALTER TABLE `pedprotemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stocksRegularizacion`
--
ALTER TABLE `stocksRegularizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticketslinea`
--
ALTER TABLE `ticketslinea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticketst`
--
ALTER TABLE `ticketst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticketstemporales`
--
ALTER TABLE `ticketstemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticketstIva`
--
ALTER TABLE `ticketstIva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `idTienda` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposVencimiento`
--
ALTER TABLE `tiposVencimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


INSERT INTO `indices` (`id`, `idTienda`, `idUsuario`, `numticket`, `tempticket`) VALUES (NULL, '1', '1', '1', '1');




COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `familiasTienda` CHANGE `ref_familia_tienda` `idFamilia_tienda` INT(11) NOT NULL;
ALTER TABLE `articulos` ADD `tipo` VARCHAR(10) NULL AFTER `ultimoCoste`;

DROP TABLE IF EXISTS `modulo_balanza`;
CREATE TABLE `modulo_balanza` ( `idBalanza` INT NOT NULL AUTO_INCREMENT , `nombreBalanza` VARCHAR(100) NOT NULL , `modelo` VARCHAR(100) NOT NULL , `conTecla` VARCHAR(3) NOT NULL , PRIMARY KEY (`idBalanza`)) ENGINE = InnoDB;
DROP TABLE IF EXISTS `modulo_balanza_plus`;
CREATE TABLE `modulo_balanza_plus` ( `idBalanza` INT NOT NULL , `plu` INT(10) NOT NULL , `tecla` INT(100) NOT NULL , `idArticulo` INT NOT NULL ) ENGINE = InnoDB;
