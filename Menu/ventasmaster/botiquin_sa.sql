-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-10-2023 a las 03:17:27
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `botiquin_sa`
--

DELIMITER $$
--
-- Funciones
--
DROP FUNCTION IF EXISTS `GetNextCorrelative`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `GetNextCorrelative` (`type` VARCHAR(20)) RETURNS INT  BEGIN
    DECLARE nextCorrelative INT;

    -- Obtener y actualizar el contador
    UPDATE CorrelativoCounters
    SET Counter = Counter + 1
    WHERE Type = type;

    -- Obtener el valor anterior del contador
    SELECT Counter INTO nextCorrelative
    FROM CorrelativoCounters
    WHERE Type = type;

    RETURN nextCorrelative;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `Code` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Entry_Date` date NOT NULL,
  `Exit_Date` date NOT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`Code`, `Name`, `Status`, `Entry_Date`, `Exit_Date`) VALUES
(1, 'Analgésicos y Antiinflamatorios', 'ACTIVO', '2018-02-15', '2022-03-15'),
(2, 'Antibióticos', 'RESERVADO', '2018-04-22', '2022-05-22'),
(3, 'Antivirales', 'VACIO', '2018-06-10', '2022-07-10'),
(4, 'Antifúngicos', 'ACTIVO', '2018-08-01', '2022-09-01'),
(5, 'Antipiréticos', 'RESERVADO', '2018-10-05', '2022-10-05'),
(6, 'Antidepresivos', 'VACIO', '2019-01-20', '2022-11-20'),
(7, 'Antiansiedad', 'ACTIVO', '2019-03-18', '2023-01-18'),
(8, 'Antipsicóticos', 'RESERVADO', '2019-05-14', '2023-02-14'),
(9, 'Antihipertensivos', 'VACIO', '2019-08-03', '2023-03-03'),
(10, 'Diuréticos', 'ACTIVO', '2019-11-11', '2023-04-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativocounters`
--

DROP TABLE IF EXISTS `correlativocounters`;
CREATE TABLE IF NOT EXISTS `correlativocounters` (
  `Type` varchar(20) NOT NULL,
  `Counter` int NOT NULL,
  PRIMARY KEY (`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `correlativocounters`
--

INSERT INTO `correlativocounters` (`Type`, `Counter`) VALUES
('Invoice_Number', 1),
('Order_Number', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `Code` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `Address` varchar(180) NOT NULL,
  `Nit` varchar(20) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `entry_date` date NOT NULL,
  `exit_date` date DEFAULT NULL,
  `customer_type` varchar(100) NOT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`Code`, `Name`, `Status`, `Address`, `Nit`, `Phone`, `entry_date`, `exit_date`, `customer_type`) VALUES
(1, 'Juan Pérez', 'Activo', 'Calle 123, Ciudad de Guatemala', '123456789', '502-12345678', '2015-01-01', '2017-05-15', 'Frecuente'),
(2, 'María Rodríguez', 'Inactivo', 'Avenida 456, Quetzaltenango', '987654321', '502-23456789', '2016-03-12', '2019-11-30', 'Volumen'),
(3, 'Carlos García', 'Activo', 'Carrera 789, Escuintla', '456789012', '502-34567890', '2015-05-22', '2018-09-20', 'VIP'),
(4, 'Ana Gómez', 'Activo', 'Avenida 101, Mixco', '345678901', '502-45678901', '2017-07-10', '2021-01-30', 'Calidad'),
(5, 'Luisa Martínez', 'Inactivo', 'Calle 112, San Juan Sacatepéquez', '210987654', '502-56789012', '2016-11-15', '2019-08-05', 'Estratégico'),
(6, 'Pedro Sánchez', 'Activo', 'Carrera 131, Villa Nueva', '543210987', '502-67890123', '2018-02-18', '2020-10-31', 'Frecuente'),
(7, 'Carmen López', 'Activo', 'Avenida 314, Petén', '678901234', '502-78901234', '2017-04-25', '2020-03-15', 'Volumen'),
(8, 'Jorge Ramírez', 'Inactivo', 'Calle 151, Cobán', '789012345', '502-89012345', '2016-06-30', '2018-12-20', 'VIP'),
(9, 'Silvia Castro', 'Activo', 'Carrera 617, Chimaltenango', '890123456', '502-90123456', '2019-08-10', '2022-02-28', 'Calidad'),
(10, 'Martín Vargas', 'Activo', 'Avenida 818, Huehuetenango', '123450987', '502-01234567', '2018-10-12', '2021-05-31', 'Estratégico'),
(11, 'Laura Mendoza', 'Inactivo', 'Calle 919, Chiquimula', '234567890', '502-12345678', '2017-12-01', '2020-09-30', 'Frecuente'),
(12, 'Héctor Núñez', 'Activo', 'Carrera 220, Retalhuleu', '345678901', '502-23456789', '2019-02-05', '2022-07-15', 'Volumen'),
(13, 'Sofía Delgado', 'Activo', 'Avenida 421, Zacapa', '456789012', '502-34567890', '2018-04-15', '2021-11-30', 'VIP'),
(14, 'Eduardo Torres', 'Inactivo', 'Calle 622, Jutiapa', '567890123', '502-45678901', '2019-06-20', '2022-03-10', 'Calidad'),
(15, 'Isabel Cruz', 'Activo', 'Carrera 823, Jalapa', '678901234', '502-56789012', '2017-08-25', '2020-12-15', 'Estratégico'),
(16, 'Raúl Díaz', 'Activo', 'Avenida 124, Santa Lucía Cotzumalguapa', '789012345', '502-67890123', '2016-10-30', '2019-07-31', 'Frecuente'),
(17, 'Patricia Herrera', 'Inactivo', 'Calle 325, Puerto Barrios', '890123456', '502-78901234', '2018-01-12', '2020-09-30', 'Volumen'),
(18, 'Fernando Jiménez', 'Activo', 'Carrera 526, Mazatenango', '901234567', '502-90123456', '2019-03-20', '2022-01-28', 'VIP'),
(19, 'Natalia Ríos', 'Activo', 'Avenida 727, Coatepeque', '012345678', '502-01234567', '2018-05-25', '2021-11-15', 'Calidad'),
(20, 'Roberto Silva', 'Inactivo', 'Calle 828, Santa Catarina Pinula', '123450987', '502-12345678', '2017-07-01', '2020-08-31', 'Estratégico'),
(21, 'Gabriela Bravo', 'Activo', 'Carrera 929, Antigua Guatemala', '234567890', '502-23456789', '2019-09-10', '2022-04-30', 'Frecuente'),
(22, 'Hugo Medina', 'Activo', 'Avenida 030, Sololá', '345678901', '502-34567890', '2018-11-15', '2021-10-31', 'Volumen'),
(23, 'Valeria Castro', 'Inactivo', 'Calle 131, San Miguel Petapa', '456789012', '502-45678901', '2020-01-20', '2023-02-28', 'VIP'),
(24, 'Andrés Martínez', 'Activo', 'Carrera 232, Amatitlán', '567890123', '502-56789012', '2019-03-25', '2022-06-30', 'Calidad'),
(25, 'Camila Gómez', 'Activo', 'Avenida 333, Totonicapán', '678901234', '502-67890123', '2020-05-30', '2023-08-31', 'Estratégico'),
(26, 'Daniel Sánchez', 'Inactivo', 'Calle 434, San Pedro Sacatepéquez', '789012345', '502-78901234', '2018-07-10', '2021-10-15', 'Frecuente'),
(27, 'Alicia Rodríguez', 'Activo', 'Carrera 535, San Marcos', '890123456', '502-90123456', '2019-09-15', '2022-12-20', 'Volumen'),
(28, 'Ricardo García', 'Activo', 'Avenida 636, Esquipulas', '012345678', '502-01234567', '2018-11-20', '2022-03-31', 'VIP'),
(29, 'Mariana López', 'Inactivo', 'Calle 737, Sanarate', '123450987', '502-12345678', '2019-01-02', '2021-08-15', 'Calidad'),
(30, 'Santiago López', 'Activo', 'Avenida 838, Salamá', '987654321', '502-23456789', '2017-02-15', '2020-09-30', 'Estratégico'),
(31, 'Gabriel Pérez', 'Activo', 'Carrera 939, Jocotenango', '456789012', '502-34567890', '2020-04-20', '2023-06-30', 'Frecuente'),
(32, 'Lucía Ramírez', 'Inactivo', 'Calle 040, Patzún', '210987654', '502-45678901', '2018-06-25', '2021-09-15', 'Volumen'),
(33, 'Diego González', 'Activo', 'Avenida 141, San Francisco El Alto', '543210987', '502-56789012', '2016-08-30', '2019-11-30', 'VIP'),
(34, 'Valentina Ruiz', 'Activo', 'Carrera 242, Comalapa', '678901234', '502-67890123', '2019-10-05', '2022-01-31', 'Calidad'),
(35, 'Miguel Gómez', 'Inactivo', 'Calle 343, Tecpán Guatemala', '890123456', '502-78901234', '2017-12-10', '2020-08-31', 'Estratégico'),
(36, 'Isabella Flores', 'Activo', 'Avenida 444, Santa Cruz del Quiché', '123450987', '502-90123456', '2018-02-15', '2021-07-15', 'Frecuente'),
(37, 'Alejandro Méndez', 'Activo', 'Carrera 545, Flores', '234567890', '502-01234567', '2019-04-20', '2022-09-30', 'Volumen'),
(38, 'Camilo Herrera', 'Inactivo', 'Calle 646, Momostenango', '345678901', '502-12345678', '2016-06-25', '2018-12-15', 'VIP'),
(39, 'Sara Castro', 'Activo', 'Avenida 747, Santa Rosa de Lima', '456789012', '502-23456789', '2018-09-30', '2021-04-30', 'Calidad'),
(40, 'Maximiliano Pérez', 'Activo', 'Carrera 848, San Benito', '567890123', '502-34567890', '2017-11-05', '2020-10-31', 'Estratégico'),
(41, 'Luciana Ramírez', 'Inactivo', 'Calle 949, La Gomera', '678901234', '502-45678901', '2019-01-10', '2022-02-28', 'Frecuente'),
(42, 'Carlos González', 'Activo', 'Avenida 050, San Pedro Ayampuc', '789012345', '502-56789012', '2018-03-15', '2021-08-15', 'Volumen'),
(43, 'Emma Ruiz', 'Activo', 'Carrera 151, Poptún', '890123456', '502-67890123', '2019-05-20', '2022-10-31', 'VIP'),
(44, 'Daniel López', 'Inactivo', 'Calle 252, San José Pinula', '012345678', '502-78901234', '2017-07-25', '2020-09-30', 'Calidad'),
(45, 'Valeria García', 'Activo', 'Avenida 353, Santiago Atitlán', '123450987', '502-90123456', '2018-10-30', '2021-12-31', 'Estratégico'),
(46, 'José Soto', 'Activo', 'Carrera 454, Pajapita', '234567890', '502-01234567', '2019-01-05', '2022-04-30', 'Frecuente'),
(47, 'María Morales', 'Inactivo', 'Calle 555, El Tejar', '345678901', '502-12345678', '2017-03-10', '2020-07-15', 'Volumen'),
(48, 'Javier Ruiz', 'Activo', 'Avenida 656, Chicacao', '456789012', '502-23456789', '2020-06-15', '2023-01-31', 'VIP'),
(49, 'Isabel Sánchez', 'Activo', 'Carrera 757, Malacatán', '567890123', '502-34567890', '2018-08-20', '2021-11-30', 'Calidad'),
(50, 'Mateo Torres', 'Inactivo', 'Calle 858, San José', '678901234', '502-45678901', '2017-10-25', '2020-12-15', 'Estratégico'),
(51, 'Valentina Flores', 'Activo', 'Avenida 959, San Lucas Sacatepéquez', '890123456', '502-56789012', '2019-12-01', '2023-03-31', 'Frecuente'),
(52, 'Lucas Herrera', 'Activo', 'Carrera 060, Santo Domingo Xenacoj', '012345678', '502-67890123', '2018-02-05', '2021-05-15', 'Volumen'),
(53, 'Ana García', 'Inactivo', 'Calle 161, Asunción Mita', '123450987', '502-78901234', '2019-04-10', '2022-07-15', 'VIP'),
(54, 'Juan Sánchez', 'Activo', 'Avenida 262, Nueva Concepción', '234567890', '502-90123456', '2020-07-15', '2023-02-28', 'Calidad'),
(55, 'Valeria Martínez', 'Activo', 'Carrera 363, San Antonio La Paz', '345678901', '502-01234567', '2018-09-20', '2021-11-30', 'Estratégico'),
(56, 'Gabriel Ramírez', 'Inactivo', 'Calle 464, Nahualá', '456789012', '502-12345678', '2017-11-25', '2020-12-15', 'Frecuente'),
(57, 'Sofía López', 'Activo', 'Avenida 565, San Cristóbal Verapaz', '567890123', '502-23456789', '2019-01-30', '2022-05-31', 'Volumen'),
(58, 'Miguel Soto', 'Activo', 'Carrera 666, Barberena', '678901234', '502-34567890', '2018-04-05', '2021-08-15', 'VIP'),
(59, 'Luciana Rodríguez', 'Inactivo', 'Calle 767, Ciudad Vieja', '890123456', '502-56789012', '2020-05-10', '2023-01-31', 'Calidad'),
(60, 'Diego García', 'Activo', 'Avenida 868, Melchor de Mencos', '012345678', '502-90123456', '2018-06-15', '2021-09-30', 'Estratégico'),
(61, 'Valentina Martínez', 'Activo', 'Carrera 969, El Estor', '123450987', '502-01234567', '2019-08-20', '2022-12-20', 'Frecuente'),
(62, 'Miguel López', 'Inactivo', 'Calle 070, San Pedro Carchá', '234567890', '502-12345678', '2017-09-25', '2020-11-30', 'Volumen'),
(63, 'Lucía Torres', 'Activo', 'Avenida 171, San Pablo Jocopilas', '345678901', '502-23456789', '2019-11-30', '2023-03-31', 'VIP'),
(64, 'Santiago Soto', 'Activo', 'Carrera 272, Santa Cruz Verapaz', '456789012', '502-34567890', '2018-01-05', '2021-04-15', 'Calidad'),
(65, 'Sofía Martínez', 'Inactivo', 'Calle 373, San Andrés Itzapa', '567890123', '502-56789012', '2017-03-10', '2019-12-15', 'Estratégico'),
(66, 'Mateo García', 'Activo', 'Avenida 474, San Bartolomé Milpas Altas', '678901234', '502-67890123', '2018-05-15', '2021-08-31', 'Frecuente'),
(67, 'Valentina Ramírez', 'Activo', 'Carrera 575, San Juan Chamelco', '890123456', '502-90123456', '2019-07-20', '2022-10-15', 'Volumen'),
(68, 'Lucas Soto', 'Inactivo', 'Calle 676, Sumpango', '012345678', '502-01234567', '2017-09-25', '2020-11-30', 'VIP'),
(69, 'Luciana López', 'Activo', 'Avenida 777, San Pedro La Laguna', '123450987', '502-12345678', '2018-12-01', '2022-02-15', 'Calidad'),
(70, 'Santiago García', 'Activo', 'Carrera 878, San Juan Comalapa', '234567890', '502-23456789', '2020-01-15', '2023-04-30', 'Estratégico'),
(71, 'Sofía Rodríguez', 'Inactivo', 'Calle 979, Concepción Chiquirichapa', '345678901', '502-34567890', '2017-03-20', '2020-07-15', 'Frecuente'),
(72, 'Mateo Ramírez', 'Activo', 'Avenida 080, San Sebastián', '456789012', '502-45678901', '2019-05-25', '2022-09-30', 'Volumen'),
(73, 'Valentina Soto', 'Activo', 'Carrera 181, San Pedro Pinula', '567890123', '502-56789012', '2018-08-30', '2021-12-15', 'VIP'),
(74, 'Lucas Martínez', 'Inactivo', 'Calle 282, Gualán', '678901234', '502-67890123', '2017-11-04', '2021-02-28', 'Calidad'),
(75, 'Sofía López', 'Activo', 'Avenida 383, San Lucas Tolimán', '890123456', '502-90123456', '2019-01-10', '2022-04-30', 'Estratégico'),
(76, 'Luciano Soto', 'Activo', 'Carrera 484, San Pedro Mártir', '012345678', '502-01234567', '2018-03-15', '2021-06-30', 'Frecuente'),
(77, 'Valentina Ramírez', 'Inactivo', 'Calle 585, Santa María de Jesús', '123450987', '502-12345678', '2019-05-20', '2022-08-15', 'Volumen'),
(78, 'Lucía García', 'Activo', 'Avenida 686, San Martín Jilotepeque', '234567890', '502-23456789', '2020-07-25', '2023-01-31', 'VIP'),
(79, 'Mateo Soto', 'Activo', 'Carrera 787, Jerez', '345678901', '502-34567890', '2018-09-30', '2021-12-15', 'Calidad'),
(80, 'Valentina Ramírez', 'Inactivo', 'Calle 888, San Antonio Suchitepéquez', '456789012', '502-45678901', '2017-12-05', '2021-02-28', 'Estratégico'),
(81, 'Lucas Rodríguez', 'Activo', 'Avenida 989, San Pablo', '567890123', '502-56789012', '2019-02-10', '2022-05-31', 'Frecuente'),
(82, 'Sofía Soto', 'Activo', 'Carrera 090, Palin', '678901234', '502-67890123', '2020-04-15', '2023-07-15', 'Volumen'),
(83, 'Luciano Martínez', 'Inactivo', 'Calle 191, Santiago Sacatepéquez', '890123456', '502-90123456', '2018-05-20', '2021-08-15', 'VIP'),
(84, 'Valentina López', 'Activo', 'Avenida 292, San Jerónimo', '012345678', '502-01234567', '2019-08-25', '2022-12-20', 'Calidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

DROP TABLE IF EXISTS `medicamentos`;
CREATE TABLE IF NOT EXISTS `medicamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Codigo` int NOT NULL,
  `Descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Lote` varchar(110) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Existencia` int NOT NULL,
  `Precio_compra` decimal(30,2) NOT NULL,
  `Precio_venta` decimal(30,2) NOT NULL,
  `Estado` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Codigo_categoria` int DEFAULT NULL,
  `Codigo_proveedor` int DEFAULT NULL,
  `Fecha_entrada` date NOT NULL,
  `Fecha_salida` date NOT NULL,
  `Unidad_medida` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Numero_estante` int NOT NULL,
  `Nivel_estante` int NOT NULL,
  `Posicion` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Category` (`Codigo_categoria`),
  KEY `FK_Supplier` (`Codigo_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `Codigo`, `Descripcion`, `Lote`, `Existencia`, `Precio_compra`, `Precio_venta`, `Estado`, `Codigo_categoria`, `Codigo_proveedor`, `Fecha_entrada`, `Fecha_salida`, `Unidad_medida`, `Numero_estante`, `Nivel_estante`, `Posicion`) VALUES
(1, 1, 'Medicamento 1', 'L123', 100, '10.50', '15.75', 'ACTIVO', 1, 1, '2020-02-20', '2023-02-20', 'Unidad', 1, 2, 3),
(2, 2, 'Medicamento 2', 'L456', 100, '8.25', '12.50', 'RESERVADO', 2, 2, '2019-05-15', '2023-05-15', 'Caja', 2, 3, 1),
(3, 3, 'Medicamento 3', 'L789', 80, '12.75', '18.25', 'VACIO', 3, 3, '2018-07-10', '2023-07-10', 'Unidad', 3, 1, 2),
(4, 4, 'Medicamento 4', 'L101', 120, '15.00', '22.50', 'ACTIVO', 4, 4, '2020-08-05', '2023-08-05', 'Frasco', 4, 2, 3),
(5, 5, 'Medicamento 5', 'L202', 90, '9.00', '13.50', 'RESERVADO', 5, 5, '2019-10-10', '2023-10-10', 'Unidad', 1, 3, 1),
(6, 6, 'Medicamento 6', 'L303', 110, '14.25', '20.50', 'VACIO', 6, 6, '2018-12-15', '2023-12-15', 'Caja', 2, 1, 2),
(7, 7, 'Medicamento 7', 'L404', 70, '18.75', '26.00', 'ACTIVO', 7, 7, '2020-01-20', '2024-01-20', 'Frasco', 3, 2, 3),
(8, 8, 'Medicamento 8', 'L505', 130, '11.50', '16.75', 'RESERVADO', 8, 8, '2019-03-25', '2024-03-25', 'Unidad', 4, 3, 1),
(9, 9, 'Medicamento 9', 'L606', 100, '13.00', '18.50', 'VACIO', 9, 9, '2018-05-30', '2024-05-30', 'Caja', 1, 1, 2),
(10, 10, 'Medicamento 10', 'L707', 160, '16.75', '24.25', 'ACTIVO', 10, 10, '2020-07-05', '2024-07-05', 'Frasco', 2, 2, 3),
(11, 11, 'Medicamento 11', 'L808', 75, '10.00', '15.25', 'RESERVADO', 1, 1, '2019-09-10', '2024-09-10', 'Unidad', 3, 3, 1),
(12, 12, 'Medicamento 12', 'L909', 140, '13.25', '19.50', 'VACIO', 2, 2, '2018-11-15', '2024-11-15', 'Caja', 4, 1, 2),
(13, 13, 'Medicamento 13', 'L1010', 95, '17.50', '24.75', 'ACTIVO', 3, 3, '2020-01-20', '2025-01-20', 'Unidad', 1, 2, 3),
(14, 14, 'Medicamento 14', 'L1111', 120, '11.00', '16.25', 'RESERVADO', 4, 4, '2019-03-25', '2025-03-25', 'Frasco', 2, 3, 1),
(15, 15, 'Medicamento 15', 'L1212', 85, '14.75', '21.00', 'VACIO', 5, 5, '2018-05-30', '2025-05-30', 'Unidad', 3, 1, 2),
(16, 16, 'Medicamento 16', 'L1313', 110, '18.00', '26.25', 'ACTIVO', 6, 6, '2020-07-05', '2025-07-05', 'Caja', 4, 2, 3),
(17, 17, 'Medicamento 17', 'L1414', 65, '12.25', '17.50', 'RESERVADO', 7, 7, '2019-09-10', '2025-09-10', 'Unidad', 1, 3, 1),
(18, 18, 'Medicamento 18', 'L1515', 125, '15.50', '22.75', 'VACIO', 8, 8, '2018-11-15', '2025-11-15', 'Frasco', 2, 1, 2),
(19, 19, 'Medicamento 19', 'L1616', 90, '20.00', '28.25', 'ACTIVO', 9, 9, '2020-01-20', '2026-01-20', 'Unidad', 3, 2, 3),
(20, 20, 'Medicamento 20', 'L1717', 135, '13.75', '20.00', 'RESERVADO', 10, 10, '2019-03-25', '2026-03-25', 'Caja', 4, 3, 1),
(21, 21, 'Medicamento 21', 'L1818', 80, '16.25', '23.50', 'VACIO', 1, 1, '2018-05-30', '2026-05-30', 'Frasco', 1, 1, 2),
(22, 22, 'Medicamento 22', 'L1919', 105, '19.50', '27.75', 'ACTIVO', 2, 2, '2020-07-05', '2026-07-05', 'Unidad', 2, 2, 3),
(23, 23, 'Medicamento 23', 'L2020', 70, '14.00', '20.25', 'RESERVADO', 3, 3, '2019-09-10', '2026-09-10', 'Caja', 3, 3, 1),
(24, 24, 'Medicamento 24', 'L2121', 130, '17.25', '24.50', 'VACIO', 4, 4, '2018-11-15', '2026-11-15', 'Frasco', 4, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_vendidos`
--

DROP TABLE IF EXISTS `productos_vendidos`;
CREATE TABLE IF NOT EXISTS `productos_vendidos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `Cantidad` bigint UNSIGNED NOT NULL,
  `id_venta` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto` (`id_producto`),
  KEY `id_venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `Code` int NOT NULL AUTO_INCREMENT,
  `Nit` varchar(20) NOT NULL,
  `Quantity` int NOT NULL,
  `Client_Code` int NOT NULL,
  `Client_Name` varchar(150) NOT NULL,
  `Sale_Date` date NOT NULL,
  `Product` varchar(150) NOT NULL,
  `Unit_of_Measure` varchar(20) NOT NULL,
  `Payment_Type` varchar(100) NOT NULL,
  `Order_Number` int DEFAULT NULL,
  `Invoice_Number` int DEFAULT NULL,
  `Unit_Price` decimal(30,2) NOT NULL,
  `IVA` decimal(30,2) NOT NULL,
  `Discount` decimal(30,2) NOT NULL,
  `Subtotal` decimal(30,2) NOT NULL,
  `Total_Price` decimal(40,2) NOT NULL,
  PRIMARY KEY (`Code`),
  KEY `Sales` (`Client_Code`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`Code`, `Nit`, `Quantity`, `Client_Code`, `Client_Name`, `Sale_Date`, `Product`, `Unit_of_Measure`, `Payment_Type`, `Order_Number`, `Invoice_Number`, `Unit_Price`, `IVA`, `Discount`, `Subtotal`, `Total_Price`) VALUES
(1, '3334445555', 8, 16, 'Santiago Pérez', '2023-10-16', 'Producto P', 'Litros', 'Efectivo', 16, 16, '9.99', '1.50', '1.00', '69.93', '81.42'),
(2, '6667778888', 14, 17, 'Alicia Mendoza', '2023-10-17', 'Producto Q', 'Unidades', 'Tarjeta de Crédito', 17, 17, '12.50', '2.25', '1.75', '105.00', '124.50'),
(3, '1112223333', 5, 18, 'Gustavo Soto', '2023-10-18', 'Producto R', 'Kilogramos', 'Tarjeta de Débito', 18, 18, '6.75', '1.00', '0.50', '30.38', '38.63'),
(4, '9998887777', 9, 19, 'Adriana Guzmán', '2023-10-19', 'Producto S', 'Cajas', 'Efectivo', 19, 19, '14.99', '2.50', '2.00', '112.41', '129.90'),
(5, '4445556666', 11, 20, 'Rodrigo Torres', '2023-10-20', 'Producto T', 'Unidades', 'Tarjeta de Crédito', 20, 20, '7.25', '1.25', '1.25', '75.75', '88.50'),
(6, '7776665555', 7, 21, 'Verónica Ramírez', '2023-10-21', 'Producto U', 'Litros', 'Efectivo', 21, 21, '11.50', '2.00', '1.50', '80.50', '95.50'),
(7, '2223334444', 12, 22, 'Martín López', '2023-10-22', 'Producto V', 'Cajas', 'Tarjeta de Débito', 22, 22, '15.75', '2.75', '2.25', '131.58', '152.58'),
(8, '5556667777', 6, 23, 'Susana Ortiz', '2023-10-23', 'Producto W', 'Kilogramos', 'Tarjeta de Crédito', 23, 23, '8.99', '1.75', '1.00', '57.69', '68.44'),
(9, '8889990000', 10, 24, 'Javier Sánchez', '2023-10-24', 'Producto X', 'Unidades', 'Efectivo', 24, 24, '13.25', '2.50', '2.00', '118.75', '134.00'),
(10, '3334445550', 13, 25, 'Valeria Márquez', '2023-10-25', 'Producto Y', 'Cajas', 'Tarjeta de Débito', 25, 25, '9.50', '1.50', '1.25', '108.50', '121.25'),
(11, '6667778880', 8, 26, 'Esteban Cruz', '2023-10-26', 'Producto Z', 'Litros', 'Tarjeta de Crédito', 26, 26, '12.99', '2.25', '1.75', '93.38', '110.12'),
(12, '1112223331', 15, 27, 'Camila González', '2023-10-27', 'Producto AA', 'Kilogramos', 'Efectivo', 27, 27, '6.25', '1.00', '0.75', '90.94', '105.44'),
(13, '9998887770', 7, 28, 'Diego Rodríguez', '2023-10-28', 'Producto BB', 'Unidades', 'Tarjeta de Débito', 28, 28, '14.50', '2.75', '2.25', '101.50', '118.25'),
(14, '4445556660', 10, 29, 'Natalia Sánchez', '2023-10-29', 'Producto CC', 'Cajas', 'Tarjeta de Crédito', 29, 29, '10.75', '2.00', '1.50', '94.50', '110.75'),
(15, '7776665550', 12, 30, 'Gabriel López', '2023-10-30', 'Producto DD', 'Litros', 'Efectivo', 30, 30, '8.25', '1.25', '1.00', '88.38', '98.63'),
(16, '3334445551', 6, 1, 'Juan Pérez', '2023-11-01', 'Producto A', 'Unidades', 'Tarjeta de Crédito', 31, 31, '11.99', '2.50', '1.75', '64.45', '79.69'),
(17, '6667778882', 9, 2, 'María Rodríguez', '2023-11-02', 'Producto B', 'Cajas', 'Efectivo', 32, 32, '18.50', '3.75', '2.25', '87.25', '111.50'),
(18, '1112223333', 7, 3, 'Carlos García', '2023-11-03', 'Producto C', 'Kilogramos', 'Tarjeta de Débito', 33, 33, '7.25', '1.50', '1.00', '58.25', '66.75'),
(19, '9998887774', 11, 4, 'Ana Gómez', '2023-11-04', 'Producto D', 'Litros', 'Tarjeta de Crédito', 34, 34, '10.99', '2.25', '1.50', '80.68', '94.17'),
(20, '4445556665', 8, 5, 'Luisa Martínez', '2023-11-05', 'Producto E', 'Unidades', 'Efectivo', 35, 35, '14.75', '3.00', '2.00', '95.00', '114.00'),
(21, '7776665556', 13, 6, 'Pedro Sánchez', '2023-11-06', 'Producto F', 'Cajas', 'Tarjeta de Débito', 36, 36, '12.50', '2.75', '2.25', '101.25', '116.00'),
(22, '2223334447', 5, 7, 'Carmen López', '2023-11-07', 'Producto G', 'Kilogramos', 'Tarjeta de Crédito', 37, 37, '6.99', '1.25', '1.00', '39.94', '47.19'),
(23, '5556667778', 10, 8, 'Pedro Hernández', '2023-11-08', 'Producto H', 'Litros', 'Efectivo', 38, 38, '11.25', '2.00', '1.50', '78.75', '92.50'),
(24, '8889990003', 12, 9, 'Laura Gómez', '2023-11-09', 'Producto I', 'Unidades', 'Tarjeta de Débito', 39, 39, '9.50', '1.50', '1.00', '84.50', '95.00'),
(25, '3334445554', 6, 10, 'Javier Fernández', '2023-11-10', 'Producto J', 'Cajas', 'Tarjeta de Crédito', 40, 40, '15.50', '2.75', '2.25', '62.00', '80.75'),
(26, '6667778885', 11, 11, 'Carmen Morales', '2023-11-11', 'Producto K', 'Kilogramos', 'Efectivo', 41, 41, '7.75', '1.00', '0.50', '42.75', '51.25'),
(27, '1112223336', 8, 12, 'Ricardo Castro', '2023-11-12', 'Producto L', 'Litros', 'Tarjeta de Débito', 42, 42, '10.50', '2.00', '1.25', '60.00', '71.75'),
(28, '9998887773', 6, 13, 'Isabel Vega', '2023-11-13', 'Producto M', 'Unidades', 'Tarjeta de Crédito', 43, 43, '13.99', '2.50', '2.00', '58.45', '74.94'),
(29, '4445556666', 10, 14, 'Fernando Torres', '2023-11-14', 'Producto N', 'Cajas', 'Efectivo', 44, 44, '9.25', '1.75', '1.00', '75.75', '86.00'),
(30, '7776665559', 13, 15, 'Natalia Soto', '2023-11-15', 'Producto O', 'Kilogramos', 'Tarjeta de Crédito', 45, 45, '12.50', '2.25', '1.75', '98.75', '113.00'),
(31, '2223334440', 7, 16, 'Santiago Pérez', '2023-11-16', 'Producto P', 'Litros', 'Efectivo', 46, 46, '8.99', '1.50', '1.00', '62.93', '74.42'),
(32, '5556667771', 9, 17, 'Alicia Mendoza', '2023-11-17', 'Producto Q', 'Unidades', 'Tarjeta de Crédito', 47, 47, '11.50', '2.25', '1.75', '87.50', '101.25'),
(33, '8889990006', 14, 18, 'Gustavo Soto', '2023-11-18', 'Producto R', 'Kilogramos', 'Tarjeta de Débito', 48, 48, '14.75', '2.00', '1.50', '124.38', '140.12'),
(34, '3334445557', 8, 19, 'Adriana Guzmán', '2023-11-19', 'Producto S', 'Cajas', 'Efectivo', 49, 49, '11.99', '2.50', '2.00', '78.41', '91.90'),
(35, '6667778888', 12, 20, 'Rodrigo Torres', '2023-11-20', 'Producto T', 'Unidades', 'Tarjeta de Crédito', 50, 50, '7.25', '1.25', '1.25', '96.75', '112.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `Code` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `Address` varchar(180) NOT NULL,
  `Nit` varchar(20) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `Entry_Date` date NOT NULL,
  `Exit_Date` date NOT NULL,
  `Supplier_Type` varchar(100) NOT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`Code`, `Name`, `Status`, `Address`, `Nit`, `Phone`, `Entry_Date`, `Exit_Date`, `Supplier_Type`) VALUES
(1, 'Diego', 'Activo', 'Coatepeque', '876543210', '50287654321', '2015-03-08', '2021-07-07', 'Regulares'),
(2, 'Fabiola', 'Inactivo', 'Santa Catarina Pinula', '543210987', '50254321098', '2016-04-21', '2020-12-31', 'Nacionales'),
(3, 'Jorge', 'Activo', 'Antigua Guatemala', '7890123456', '50278901234', '2017-05-30', '2021-07-07', 'Locales'),
(4, 'Gabriela', 'Inactivo', 'Sololá', '2345678901', '50223456789', '2018-06-14', '2020-11-25', 'Internacionales'),
(5, 'Oscar', 'Activo', 'San Miguel Petapa', '6543210987', '50265432109', '2019-07-17', '2021-07-07', 'Servicios'),
(6, 'Mónica', 'Inactivo', 'Amatitlán', '7890123456', '50278901234', '2020-08-22', '2020-12-31', 'Bienes o Productos'),
(7, 'Ricardo', 'Activo', 'Totonicapán', '1234567890', '50212345678', '2021-09-07', '2021-07-07', 'Regulares'),
(8, 'Elena', 'Inactivo', 'San Andrés Itzapa', '8901234567', '50289012345', '2015-11-14', '2019-11-25', 'Nacionales'),
(9, 'César', 'Activo', 'San Bartolomé Milpas Altas', '2345678901', '50223456789', '2016-12-30', '2021-07-07', 'Locales'),
(10, 'Luisa', 'Inactivo', 'San Miguel Chicaj', '5678901234', '50256789012', '2019-04-05', '2020-11-25', 'Esporádicos'),
(11, 'Rafael', 'Activo', 'El Jícaro', '2109876543', '50221098765', '2020-05-10', '2021-07-07', 'Nacionales'),
(12, 'Sofía', 'Inactivo', 'San Marcos La Laguna', '4321098765', '50243210987', '2021-06-15', '2020-12-31', 'Locales'),
(13, 'Martín', 'Activo', 'Teculután', '9876543210', '50298765432', '2018-07-20', '2021-07-07', 'Internacionales'),
(14, 'Laura', 'Inactivo', 'La Democracia', '8765432109', '50287654321', '2019-08-25', '2020-11-25', 'Bienes o Productos'),
(15, 'Daniel', 'Activo', 'San Antonio Ilotenango', '5432109876', '50254321098', '2020-09-30', '2021-07-07', 'Esporádicos'),
(16, 'Carla', 'Inactivo', 'San Sebastián Coatán', '2109876543', '50221098765', '2017-11-04', '2020-12-31', 'Regulares'),
(17, 'Javier', 'Activo', 'Santa Bárbara', '1234567890', '50212345678', '2018-12-09', '2021-07-07', 'Servicios'),
(18, 'Natalia', 'Inactivo', 'San Miguel Dueñas', '9876543210', '50298765432', '2016-01-14', '2020-11-25', 'Bienes o Productos'),
(19, 'Miguel', 'Activo', 'Rabinal', '6543210987', '50265432109', '2015-02-19', '2021-07-07', 'Regulares'),
(20, 'Ana', 'Inactivo', 'Tiquisate', '8901234567', '50289012345', '2021-03-26', '2020-12-31', 'Internacionales'),
(21, 'Cristina', 'Activo', 'Santa Catarina Ixtahuacán', '2345678901', '50223456789', '2021-04-30', '2021-07-07', 'Locales'),
(22, 'Rodrigo', 'Inactivo', 'San Andrés Xecul', '5678901234', '50256789012', '2015-06-04', '2020-11-25', 'Esporádicos'),
(23, 'Sara', 'Activo', 'San Cristóbal Acasaguastlán', '2109876543', '50221098765', '2016-07-09', '2021-07-07', 'Servicios'),
(24, 'Alejandro', 'Inactivo', 'San Juan Ostuncalco', '1234567890', '50212345678', '2017-08-14', '2020-12-31', 'Bienes o Productos'),
(25, 'Valeria', 'Activo', 'San Lucas Sacatepéquez', '9876543210', '50298765432', '2018-09-18', '2021-07-07', 'Regulares'),
(26, 'Andrés', 'Inactivo', 'Santa Clara La Laguna', '6543210987', '50265432109', '2019-10-23', '2020-11-25', 'Internacionales'),
(27, 'Monica', 'Activo', 'Santa María Visitación', '8901234567', '50289012345', '2020-11-27', '2021-07-07', 'Locales'),
(28, 'Hugo', 'Inactivo', 'Santiago Chimaltenango', '2345678901', '50223456789', '2017-01-01', '2020-12-31', 'Internacionales'),
(29, 'Carmen', 'Activo', 'Santa María Visitación', '123456789', '50212345678', '2019-02-28', '2021-07-07', 'Bienes o Productos'),
(30, 'Martín', 'Inactivo', 'Santiago Chimaltenango', '987654321', '50298765432', '2020-03-15', '2020-12-31', 'Servicios'),
(31, 'Liliana', 'Activo', 'San Lorenzo', '567890123', '50256789012', '2016-04-25', '2021-07-07', 'Locales'),
(32, 'Rafael', 'Inactivo', 'San Juan Bautista', '2345678901', '50223456789', '2017-05-30', '2020-11-25', 'Regulares'),
(33, 'Patricia', 'Activo', 'San Juan Sacatepéquez', '8901234567', '50289012345', '2018-06-14', '2021-07-07', 'Esporádicos'),
(34, 'José', 'Inactivo', 'Panajachel', '210987654', '50221098765', '2019-07-29', '2020-12-31', 'Internacionales'),
(35, 'Mariana', 'Activo', 'San Lorenzo', '1234567890', '50212345678', '2020-09-03', '2021-07-07', 'Locales'),
(36, 'Pedro', 'Inactivo', 'San Felipe', '9876543210', '50298765432', '2021-10-08', '2020-12-31', 'Bienes o Productos'),
(37, 'Gabriel', 'Activo', 'San Miguel Chicaj', '5432109876', '50254321098', '2018-11-13', '2021-07-07', 'Servicios'),
(38, 'Daniela', 'Inactivo', 'El Jícaro', '2109876543', '50221098765', '2019-12-18', '2020-11-25', 'Regulares'),
(39, 'Víctor', 'Activo', 'San Juan Comalapa', '543210987', '50254321098', '2015-02-14', '2021-07-07', 'Locales'),
(40, 'Alicia', 'Inactivo', 'Concepción Chiquirichapa', '2345678901', '50223456789', '2016-03-20', '2020-12-31', 'Nacionales'),
(41, 'Manuel', 'Activo', 'San Sebastián', '8901234567', '50289012345', '2017-04-25', '2021-07-07', 'Bienes o Productos'),
(42, 'Rosa', 'Inactivo', 'San Pedro Pinula', '1234567890', '50212345678', '2018-05-30', '2020-11-25', 'Esporádicos'),
(43, 'Felipe', 'Activo', 'Gualán', '9876543210', '50298765432', '2019-07-04', '2021-07-07', 'Servicios'),
(44, 'Lorena', 'Inactivo', 'San Lucas Tolimán', '5432109876', '50254321098', '2020-08-09', '2020-12-31', 'Internacionales'),
(45, 'Alberto', 'Activo', 'San Pedro Mártir', '2109876543', '50221098765', '2021-09-14', '2021-07-07', 'Locales'),
(46, 'Cecilia', 'Inactivo', 'Santa María de Jesús', '2345678901', '50223456789', '2015-10-19', '2019-11-25', 'Servicios'),
(47, 'Francisco', 'Activo', 'San Martín Jilotepeque', '8901234567', '50289012345', '2016-11-24', '2021-07-07', 'Esporádicos'),
(48, 'Valentina', 'Inactivo', 'Jerez', '1234567890', '50212345678', '2017-12-29', '2020-12-31', 'Regulares'),
(49, 'Joaquín', 'Activo', 'San Antonio Suchitepéquez', '9876543210', '50298765432', '2019-02-02', '2021-07-07', 'Bienes o Productos'),
(50, 'Camila', 'Inactivo', 'San Pablo', '5432109876', '50254321098', '2020-03-08', '2020-11-25', 'Locales'),
(51, 'Andrea', 'Activo', 'Palin', '2109876543', '50221098765', '2021-04-13', '2021-07-07', 'Servicios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `permissions` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `permissions`, `password`, `status`) VALUES
(1, 'Anderson', 'anderson@gmail.com', 'admin', 'root', 'active'),
(2, 'Edward', 'edward@gmail.com', 'admin', 'root', 'active'),
(3, 'Anthoni', 'anthoni@gmail.com', 'admin', 'root', 'active'),
(4, 'Ana', 'ana@gmail.com', 'admin', 'root', 'active'),
(5, 'pablo', 'pablo@gmail.com', 'admin', 'root', 'active'),
(6, 'rose', 'rose@gmail.com', 'user', 'root', 'inactive'),
(7, 'Elizabet', 'eli@gmail.com', 'editor', 'root', 'inactive'),
(8, 'RandomUser1', 'random1@gmail.com', 'user', '84870', 'inactive'),
(9, 'RandomUser2', 'random2@gmail.com', 'editor', '12344', 'inactive');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `total` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `FK_Category` FOREIGN KEY (`Codigo_categoria`) REFERENCES `categories` (`Code`),
  ADD CONSTRAINT `FK_Supplier` FOREIGN KEY (`Codigo_proveedor`) REFERENCES `suppliers` (`Code`);

--
-- Filtros para la tabla `productos_vendidos`
--
ALTER TABLE `productos_vendidos`
  ADD CONSTRAINT `productos_vendidos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_vendidos_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `Sales` FOREIGN KEY (`Client_Code`) REFERENCES `customers` (`Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
