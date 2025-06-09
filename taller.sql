-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-06-2013 a las 19:36:46
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `taller`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `nrodoc` int(11) NOT NULL,
  `clinombre` varchar(150) NOT NULL,
  `cliapellido` varchar(150) NOT NULL,
  PRIMARY KEY (`nrodoc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`nrodoc`, `clinombre`, `cliapellido`) VALUES
(4, 'ppppp', 'pppp'),
(123, 'pepe', 'suarez'),
(888, 'ppppp', 'pppp'),
(12120674, 'Ruben', 'Jo'),
(12123650, 'Nicolas', 'Pi'),
(12123674, 'Pepe', 'Luti'),
(12123675, 'Luna', 'Li');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE IF NOT EXISTS `turnos` (
  `idturno` int(11) NOT NULL AUTO_INCREMENT,
  `vepatente` varchar(8) NOT NULL,
  `tufecha` date NOT NULL,
  `tuhora` time NOT NULL,
  `tucancelado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idturno`),
  KEY `vepatente` (`vepatente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`idturno`, `vepatente`, `tufecha`, `tuhora`, `tucancelado`) VALUES
(10, 'KKK 678', '2012-07-20', '08:10:00', NULL),
(11, 'KKK 678', '2012-07-20', '08:40:00', 0),
(12, 'KKK 678', '2012-07-20', '08:10:00', 0),
(13, 'KKK 678', '2012-07-20', '08:40:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE IF NOT EXISTS `vehiculo` (
  `nrodoc` int(11) NOT NULL,
  `vemodelo` int(11) NOT NULL,
  `vemarca` varchar(100) NOT NULL,
  `vepatente` varchar(8) NOT NULL,
  PRIMARY KEY (`vepatente`),
  KEY `nrodoc` (`nrodoc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`nrodoc`, `vemodelo`, `vemarca`, `vepatente`) VALUES
(12123675, 2011, 'Ford', 'KDI 776'),
(12123674, 1980, 'Peugeot', 'KKK 678'),
(12123674, 1979, 'Ford', 'OTP 600'),
(12123675, 2000, 'Ford', 'VVV 789');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`vepatente`) REFERENCES `vehiculo` (`vepatente`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`nrodoc`) REFERENCES `cliente` (`nrodoc`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
