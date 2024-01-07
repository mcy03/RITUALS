-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2024 a las 23:29:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rituals`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `CATEGORIA_ID` int(11) NOT NULL,
  `NOMBRE_CATEGORIA` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`CATEGORIA_ID`, `NOMBRE_CATEGORIA`) VALUES
(1, 'BreezeBills'),
(2, 'Fruit essence cocktail'),
(3, 'Café fusion'),
(4, 'Seasonal Sips Collection'),
(6, 'Zero-Proof Mixology Colle'),
(7, 'Global Mix Collection'),
(8, 'Craft Mixology Collection');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `PEDIDO_ID` int(11) NOT NULL,
  `USUARIO_ID` int(11) NOT NULL,
  `ESTADO` varchar(25) NOT NULL,
  `FECHA_PEDIDO` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`PEDIDO_ID`, `USUARIO_ID`, `ESTADO`, `FECHA_PEDIDO`) VALUES
(51, 1, 'EN PREPARACIÓN', '2024-01-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `ARTICULO_ID` int(11) NOT NULL,
  `PEDIDO_ID` int(11) NOT NULL,
  `PRODUCTO_ID` int(11) NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO_UNIDAD` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_productos`
--

INSERT INTO `pedidos_productos` (`ARTICULO_ID`, `PEDIDO_ID`, `PRODUCTO_ID`, `CANTIDAD`, `PRECIO_UNIDAD`) VALUES
(85, 51, 7, 1, 8.85),
(86, 51, 17, 1, 7.80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `PRODUCTO_ID` int(11) NOT NULL,
  `NOMBRE_PRODUCTO` varchar(25) NOT NULL,
  `IMG` varchar(100) NOT NULL,
  `DESCRIPCION` varchar(254) NOT NULL,
  `PRECIO_UNIDAD` double(5,2) NOT NULL,
  `CATEGORIA_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`PRODUCTO_ID`, `NOMBRE_PRODUCTO`, `IMG`, `DESCRIPCION`, `PRECIO_UNIDAD`, `CATEGORIA_ID`) VALUES
(1, 'Apfelwein', 'img/products/Apfelwein.png', 'BreezeBills, Digestivos, Long drinks, Collins, 270 ml', 9.85, 1),
(2, 'Martini Royale', 'img/products/MartiniRoyale.png', 'BreezeBills, Martini, Long drinks, Collins, 330 ml', 11.95, 1),
(3, 'Daiquiri de Frambuesa', 'img/products/DaiquiriFrambuesa.png', 'Fruit essence cocktail, limitado, Long drinks, Collins, 270 ml', 8.85, 2),
(4, 'San Francisco', 'img/products/SanFrancisco.png', 'Fruit essence cocktail, limitado, Sin alcohol, Long drinks, 300 ml', 6.85, 2),
(5, 'Orange Crush', 'img/products/OrangeCrush.png', 'Fruit essence cocktail, limitado, Long drinks, Collins, 250 ml', 10.50, 2),
(6, 'Spritz de Pepino', 'img/products/SpritzPepino.png', 'BreezeBills, aperitivos, Long drinks, Collins, 200 ml', 7.80, 1),
(7, 'Café Irlandés', 'img/products/cafeIrlandes.png', 'Café fusion, Long drinks, Collins, 150 ml', 8.85, 3),
(8, 'Squeaky Wheel', 'img/products/squeakyWheel.png', 'Café fusion, Long drinks, Collins, 250 ml', 5.85, 3),
(9, 'Biscoff Latte', 'img/products/biscoffLatte.png', 'Café fusion, Long drinks, Collins, 270 ml', 8.45, 3),
(10, 'Baileys con Hielo', 'img/products/beileys.png', 'Café fusion, Baileys, Cups, 100 ml', 3.50, 3),
(11, 'Gin Tonic Rosa', 'img/products/ginTonicRosa.png', 'Global Mix Collection, Long drinks, Collins, 330ml ', 5.00, 7),
(12, 'Piña Colada Coctel', 'img/products/piñaColada.png', 'Fruit essence cocktail, limitado, Long drinks', 7.50, 2),
(13, 'Coctel Brisa Marina Mai T', 'img/products/maiTai.png', 'Zero-Proof Mixology Collection, Long drinks, Collins, 270 ml', 12.75, 6),
(14, 'Gin Tonic con Pepino', 'img/products/ginTonicPepino.png', 'Gin Tonic, Long drinks, Collins, 270 ml', 6.85, 2),
(15, 'Cóctel Aguanieve Margarit', 'img/products/coctelAguanieveMargarita.png', 'Zero-Proof Mixology Collection, Long drinks, Collins, 330 ml', 13.50, 6),
(16, 'Martini Clasico', 'img/products/martiniClasico.png', 'Global Mix Collection, limitado, Long drinks, 330ml', 6.50, 7),
(17, 'limonada martini mai tai', 'img/products/limonadaMaiTai.png', 'Seasonal Sips Collection, Long drinks, Collins, 250 ml', 7.80, 4),
(18, 'Mai Tai Woo Woo', 'img/products/maiTaiWooWoo.png', 'Global Mix Collection, Long drinks, Collins, 250 ml', 8.65, 7),
(19, 'Mojito Cola', 'img/products/mojitoCola.png', 'Seasonal Sips Collection, limitado, Long drinks, 250 ml', 9.50, 4),
(20, 'Daiquiri de Fresa', 'img/products/daiquiriFresa.png', 'Seasonal Sips Collection, Collins, 270ml', 5.50, 4),
(21, 'Martini de Pastel', 'img/products/martiniPastel.png', 'Martini, Long drinks, Collins, 200 ml', 7.95, 6),
(22, 'Red Hot Chili Love', 'img/products/redHotChiliLove.png', 'picante, Long drinks, Collins, 250 ml', 9.85, 8),
(23, 'Rosé Summer Punch', 'img/products/roseSummerPunch.png', 'Dulce, Long drinks, Collins, 200 ml', 6.85, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_cambios`
--

CREATE TABLE `registro_cambios` (
  `REGISTRO_ID` int(11) NOT NULL,
  `USUARIO_ID` int(11) NOT NULL,
  `ACCION` varchar(25) NOT NULL,
  `TIPO_SUJETO` varchar(25) NOT NULL,
  `SUJETO` varchar(25) NOT NULL,
  `FECHA_CAMBIO` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_cambios`
--

INSERT INTO `registro_cambios` (`REGISTRO_ID`, `USUARIO_ID`, `ACCION`, `TIPO_SUJETO`, `SUJETO`, `FECHA_CAMBIO`) VALUES
(63, 1, 'Insert', 'Pedido', '50', '2024-01-07'),
(64, 1, 'Insert', 'Product', 'Roberto', '2024-01-07'),
(65, 1, 'Update', 'Pedido', '50', '2024-01-07'),
(66, 1, 'Delete', 'Pedido', '50', '2024-01-07'),
(67, 1, 'Del', 'User', '28', '2024-01-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `USUARIO_ID` int(11) NOT NULL,
  `EMAIL` varchar(250) DEFAULT NULL,
  `SALUDO` varchar(25) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `APELLIDOS` varchar(50) DEFAULT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `PASSWORD` varchar(254) DEFAULT NULL,
  `TELEFONO` varchar(15) DEFAULT NULL,
  `DIRECCION` varchar(254) DEFAULT NULL,
  `PERMISO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`USUARIO_ID`, `EMAIL`, `SALUDO`, `NOMBRE`, `APELLIDOS`, `FECHA_NACIMIENTO`, `PASSWORD`, `TELEFONO`, `DIRECCION`, `PERMISO`) VALUES
(1, 'manuelcaler2003@gmail.com', 'otros', 'Manuel', 'Caler', '2024-01-01', '$2y$10$uik6YJiJv.oS.vjZF.3hJOIfbJp2vn/U08zCaDEZN5dY.KQ32tT6S', '65352642', 'calle admin3', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`CATEGORIA_ID`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`PEDIDO_ID`),
  ADD KEY `FK_USUARIO_ID` (`USUARIO_ID`);

--
-- Indices de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD PRIMARY KEY (`ARTICULO_ID`,`PEDIDO_ID`,`PRODUCTO_ID`),
  ADD KEY `FK_PEDIDO_ID` (`PEDIDO_ID`),
  ADD KEY `FK_PRODUCTO_ID` (`PRODUCTO_ID`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`PRODUCTO_ID`),
  ADD KEY `FK_CATEGORIA_ID` (`CATEGORIA_ID`);

--
-- Indices de la tabla `registro_cambios`
--
ALTER TABLE `registro_cambios`
  ADD PRIMARY KEY (`REGISTRO_ID`),
  ADD KEY `fk2_usuario_id` (`USUARIO_ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`USUARIO_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `CATEGORIA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `PEDIDO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  MODIFY `ARTICULO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `PRODUCTO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `registro_cambios`
--
ALTER TABLE `registro_cambios`
  MODIFY `REGISTRO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `USUARIO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_USUARIO_ID` FOREIGN KEY (`USUARIO_ID`) REFERENCES `usuarios` (`USUARIO_ID`);

--
-- Filtros para la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD CONSTRAINT `FK_PEDIDO_ID` FOREIGN KEY (`PEDIDO_ID`) REFERENCES `pedidos` (`PEDIDO_ID`),
  ADD CONSTRAINT `FK_PRODUCTO_ID` FOREIGN KEY (`PRODUCTO_ID`) REFERENCES `productos` (`PRODUCTO_ID`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_CATEGORIA_ID` FOREIGN KEY (`CATEGORIA_ID`) REFERENCES `categorias` (`CATEGORIA_ID`);

--
-- Filtros para la tabla `registro_cambios`
--
ALTER TABLE `registro_cambios`
  ADD CONSTRAINT `fk2_usuario_id` FOREIGN KEY (`USUARIO_ID`) REFERENCES `usuarios` (`USUARIO_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
