-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2016 a las 06:43:16
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE IF NOT EXISTS `cotizacion` (
  `ID` int(11) NOT NULL,
  `cliente_ID` int(11) DEFAULT NULL,
  `representante_cliente_ID` int(11) DEFAULT '0',
  `operador_ID` int(11) DEFAULT NULL,
  `periodo` int(11) NOT NULL DEFAULT '0',
  `numero` int(11) DEFAULT NULL,
  `numero_concatenado` varchar(20) DEFAULT NULL,
  `moneda_ID` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `descripcion` text,
  `igv` decimal(9,2) DEFAULT NULL,
  `vigv_soles` decimal(10,2) DEFAULT NULL,
  `vigv_dolares` decimal(10,2) DEFAULT NULL,
  `precio_venta_neto_soles` decimal(10,2) DEFAULT NULL,
  `precio_venta_total_soles` decimal(10,2) DEFAULT NULL,
  `precio_venta_neto_dolares` decimal(10,2) DEFAULT NULL,
  `precio_venta_total_dolares` decimal(10,2) DEFAULT NULL,
  `forma_pago_ID` int(11) DEFAULT NULL,
  `tiempo_credito` int(11) DEFAULT '0',
  `numero_cuenta` varchar(200) DEFAULT NULL,
  `cuenta_interbancaria` varchar(200) DEFAULT NULL,
  `banco` varchar(200) DEFAULT NULL,
  `tardanza` time DEFAULT NULL,
  `plazo_entrega` int(11) DEFAULT NULL,
  `estado_ID` int(11) DEFAULT NULL,
  `tipo_cambio` decimal(10,4) DEFAULT NULL,
  `lugar_entrega` varchar(200) DEFAULT NULL,
  `validez_oferta` varchar(50) DEFAULT NULL,
  `garantia` varchar(50) DEFAULT NULL,
  `observacion` varchar(500) DEFAULT NULL,
  `area_texto` text,
  `usuario_id` int(11) DEFAULT NULL,
  `fdc` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_mod_id` int(11) DEFAULT NULL,
  `fdm` datetime DEFAULT NULL,
  `del` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`ID`, `cliente_ID`, `representante_cliente_ID`, `operador_ID`, `periodo`, `numero`, `numero_concatenado`, `moneda_ID`, `fecha`, `descripcion`, `igv`, `vigv_soles`, `vigv_dolares`, `precio_venta_neto_soles`, `precio_venta_total_soles`, `precio_venta_neto_dolares`, `precio_venta_total_dolares`, `forma_pago_ID`, `tiempo_credito`, `numero_cuenta`, `cuenta_interbancaria`, `banco`, `tardanza`, `plazo_entrega`, `estado_ID`, `tipo_cambio`, `lugar_entrega`, `validez_oferta`, `garantia`, `observacion`, `area_texto`, `usuario_id`, `fdc`, `usuario_mod_id`, `fdm`, `del`) VALUES
(1, 3, 1, 6, 2016, 1, '0000001-2016', 1, '2016-08-07 00:00:00', NULL, '0.18', '72.00', '21.49', '400.00', '472.00', '119.40', '140.89', 1, 30, '191-2225677-1-94', '00219100222567719454', 'Banco de Crédito del Perú (S/.)', '00:01:00', 20, 1, '3.3500', 'Av. lo pepitos', '20', '20', 'Las cantidades y montos ofrecidos en la presente cotizaciÃ³n,son para el total de la compra; La compra mÃ­nima para crÃ©dito es de 150 dÃ³lare', NULL, 0, '2016-08-06 22:36:59', 0, '2016-08-06 22:37:42', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
 ADD PRIMARY KEY (`ID`), ADD KEY `R_27` (`moneda_ID`), ADD KEY `R_45` (`estado_ID`), ADD KEY `R_26` (`cliente_ID`), ADD KEY `R_74` (`forma_pago_ID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
ADD CONSTRAINT `cotizacion_ibfk_2` FOREIGN KEY (`moneda_ID`) REFERENCES `moneda` (`ID`),
ADD CONSTRAINT `cotizacion_ibfk_3` FOREIGN KEY (`estado_ID`) REFERENCES `estado` (`ID`),
ADD CONSTRAINT `cotizacion_ibfk_4` FOREIGN KEY (`cliente_ID`) REFERENCES `cliente` (`ID`),
ADD CONSTRAINT `cotizacion_ibfk_5` FOREIGN KEY (`forma_pago_ID`) REFERENCES `forma_pago` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
