-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 01:03:59
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
-- Base de datos: `catalogo_bf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `ID` int(100) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `CORREO` varchar(200) NOT NULL,
  `PW` text NOT NULL,
  `ROLL` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `car`
--

CREATE TABLE `car` (
  `ID` int(100) NOT NULL,
  `ID_CESTA` int(100) NOT NULL,
  `ID_PRODUCT` int(100) NOT NULL,
  `CANTIDAD` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `ID` int(100) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

CREATE TABLE `cesta` (
  `ID` int(100) NOT NULL,
  `ID_USER` int(100) NOT NULL,
  `ESTADO` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `ID` int(100) NOT NULL,
  `ID_USER` int(100) NOT NULL,
  `DIR_1` text NOT NULL,
  `DIR_2` text DEFAULT NULL,
  `NUM_INT` tinytext DEFAULT NULL,
  `NUM_EXT` tinytext DEFAULT NULL,
  `CP` int(10) NOT NULL,
  `CIUDAD` tinytext DEFAULT NULL,
  `ESTADO` tinytext DEFAULT NULL,
  `COLONIA` tinytext DEFAULT NULL,
  `REFERENCIA` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID` int(100) NOT NULL,
  `ID_USER` int(100) NOT NULL,
  `FECHA_PEDIDO` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_product`
--

CREATE TABLE `pedido_product` (
  `ID` int(100) NOT NULL,
  `ID_PEDIDO` int(100) NOT NULL,
  `ID_PRODUCT` int(100) NOT NULL,
  `CANTIDAD` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_product`
--

CREATE TABLE `precio_product` (
  `ID` int(100) NOT NULL,
  `ID_PRODUCT` int(100) NOT NULL,
  `TIPO_USER` int(5) NOT NULL,
  `PRECIO` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `ID` int(100) NOT NULL,
  `SKU` int(10) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `SUSTANCIA` tinytext NOT NULL,
  `PRESENTACION` text NOT NULL,
  `REGISTRO_SANITARIO` tinytext NOT NULL,
  `STOCK` int(100) NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `IMAGEN_URL` text NOT NULL,
  `CODIGO_BARRAS` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category`
--

CREATE TABLE `product_category` (
  `ID_PRODUCT` int(100) NOT NULL,
  `ID_CATEGORY` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `ID` int(100) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `APELLIDO` varchar(100) NOT NULL,
  `CORREO` varchar(200) NOT NULL,
  `TELEFONO` varchar(20) NOT NULL,
  `NUMERO_CLIENTE` int(100) NOT NULL,
  `TIPO_CLIENTE` int(5) NOT NULL,
  `RESET_PW` int(1) NOT NULL DEFAULT 0,
  `CREATE_PW` int(1) NOT NULL DEFAULT 0,
  `PW` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wish_list`
--

CREATE TABLE `wish_list` (
  `ID` int(100) NOT NULL,
  `ID_USER` int(100) NOT NULL,
  `ID_PRODUCT` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_CESTA` (`ID_CESTA`),
  ADD KEY `ID_PRODUCT` (`ID_PRODUCT`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

--
-- Indices de la tabla `pedido_product`
--
ALTER TABLE `pedido_product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PEDIDO` (`ID_PEDIDO`),
  ADD KEY `ID_PRODUCT` (`ID_PRODUCT`);

--
-- Indices de la tabla `precio_product`
--
ALTER TABLE `precio_product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PRODUCT` (`ID_PRODUCT`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`ID_PRODUCT`,`ID_CATEGORY`),
  ADD KEY `ID_CATEGORY` (`ID_CATEGORY`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`),
  ADD KEY `ID_PRODUCT` (`ID_PRODUCT`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `car`
--
ALTER TABLE `car`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cesta`
--
ALTER TABLE `cesta`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido_product`
--
ALTER TABLE `pedido_product`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precio_product`
--
ALTER TABLE `precio_product`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`ID_CESTA`) REFERENCES `cesta` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_ibfk_2` FOREIGN KEY (`ID_PRODUCT`) REFERENCES `product` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD CONSTRAINT `cesta_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido_product`
--
ALTER TABLE `pedido_product`
  ADD CONSTRAINT `pedido_product_ibfk_1` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `pedido` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_product_ibfk_2` FOREIGN KEY (`ID_PRODUCT`) REFERENCES `product` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `precio_product`
--
ALTER TABLE `precio_product`
  ADD CONSTRAINT `precio_product_ibfk_1` FOREIGN KEY (`ID_PRODUCT`) REFERENCES `product` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`ID_PRODUCT`) REFERENCES `product` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`ID_CATEGORY`) REFERENCES `category` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `wish_list`
--
ALTER TABLE `wish_list`
  ADD CONSTRAINT `wish_list_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `wish_list_ibfk_2` FOREIGN KEY (`ID_PRODUCT`) REFERENCES `product` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
