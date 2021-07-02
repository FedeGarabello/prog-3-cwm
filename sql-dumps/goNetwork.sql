-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-07-2021 a las 05:51:02
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `goNetwork`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Snowboard'),
(2, 'Ski'),
(3, 'Pistas'),
(4, 'Equipos'),
(5, 'Competencias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `owner_id`, `content`, `created_at`) VALUES
(11, 60, 1, 'Excelente Foto!!!! ', '2021-07-02 00:42:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gender`
--

INSERT INTO `gender` (`id`, `type`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `post_pic` varchar(100) NOT NULL DEFAULT 'post_pic.jpg',
  `owner_id` int(11) NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `post_pic`, `owner_id`, `likes`, `category_id`, `created_at`, `is_active`) VALUES
(58, 'Las mejores pistas de Europa', 'En nuestro recorrido por los Alpes les mostramos las mejores pistas que pueden recorrer en esta temporada de invierno. \n', '1625196797.jpg', 1, 0, 3, '2021-07-02 00:33:17', 1),
(59, 'Opinión de tablas ', 'Comenten que opinan de esta nueva tabla Burton.', '1625196898.jpg', 2, 0, 4, '2021-07-02 00:34:58', 1),
(60, 'Salimos a las pistas con Travis Rice', 'Te mostramos el backstage de las fotos y videos tomadas en Aspen', '1625197021.jpg', 2, 0, 1, '2021-07-02 00:37:01', 1),
(61, 'Nuevo medio de elevación en Chapelco', 'El famoso \"huevito\" se renueva y nos ofrece un espacio más amplio y una velocidad de ascenso 2 veces superior.', '1625197226.jpg', 1, 0, 3, '2021-07-02 00:40:26', 1),
(62, 'Se abre la competencia de Ski 2021', 'Los X-Games se mudan a Caviahue. Seguí la competencia por ESPN ', '1625197321.jpg', 1, 0, 5, '2021-07-02 00:42:01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `profile_pic` varchar(200) DEFAULT 'profile.jpg',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `last_name`, `email`, `password`, `gender_id`, `birth_date`, `profile_pic`, `created_at`) VALUES
(1, 'Gastón', 'Marino', 'gmarino86@hotmail.com', '$2y$10$kbc23k96poRJ9VK4bnxI4O1FgvB5Hklj8Dwo3wvxcy5Qolx.IX1U.', 1, '1986-09-20', 'profile.jpg', '2021-06-17 00:40:31'),
(2, 'Fede', 'Garabello', 'fgarabello@gmail.com', '$2y$10$kbc23k96poRJ9VK4bnxI4O1FgvB5Hklj8Dwo3wvxcy5Qolx.IX1U.', 1, '1986-09-20', 'profile.jpg', '2021-06-19 23:25:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id_idx` (`post_id`),
  ADD KEY `owner_id_FK_idx` (`owner_id`);

--
-- Indices de la tabla `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id_FK_idx` (`category_id`),
  ADD KEY `owner_id_FK_idx` (`owner_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender_id_FK_idx` (`gender_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `owner_id_FK1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_id_FK` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `category_id_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `owner_id_FK` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `gender_id_FK` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
