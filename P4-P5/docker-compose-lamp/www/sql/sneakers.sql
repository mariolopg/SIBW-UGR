-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Jun 13, 2022 at 03:05 PM
-- Server version: 8.0.28
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- User: `admin`
--
CREATE USER 'admin'@'%' IDENTIFIED BY 'SIBW2022';
GRANT create, delete, drop, index, insert, select, update ON sneakers.* TO ''@'%';

--
-- Database: `sneakers`
--
CREATE DATABASE IF NOT EXISTS `sneakers` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `sneakers`;

-- --------------------------------------------------------

--
-- Table structure for table `badWords`
--

CREATE TABLE `badWords` (
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `badWords`
--

INSERT INTO `badWords` (`word`) VALUES
('capullo'),
('cipote'),
('gilipollas'),
('mierda'),
('puta'),
('tonto');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`nombre`) VALUES
('default'),
('gestor'),
('moderador'),
('superuser');

-- --------------------------------------------------------

--
-- Table structure for table `sneakersComments`
--

CREATE TABLE `sneakersComments` (
  `id` int NOT NULL,
  `id_sneaker` int NOT NULL,
  `user_id` int NOT NULL,
  `fecha` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comment` longtext NOT NULL,
  `editado` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sneakersComments`
--

INSERT INTO `sneakersComments` (`id`, `id_sneaker`, `user_id`, `fecha`, `comment`, `editado`) VALUES
(41, 2, 9, '02-06-2022', 'Me encantan', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `sneakersImages`
--

CREATE TABLE `sneakersImages` (
  `id` int NOT NULL,
  `id_sneaker` int NOT NULL,
  `image_name` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sneakersImages`
--

INSERT INTO `sneakersImages` (`id`, `id_sneaker`, `image_name`) VALUES
(1, 1, 'jordan_1.png'),
(2, 2, 'jordan_2.png'),
(3, 1, 'jordan_1_2.png'),
(4, 3, 'jordan_3.png'),
(5, 4, 'jordan_4.png'),
(6, 5, 'jordan_5.png'),
(7, 6, 'jordan_6.png'),
(8, 7, 'af1_1.png'),
(9, 8, 'af1_2.png'),
(10, 9, 'af1_3.png'),
(11, 10, 'dunk_1.png'),
(12, 11, 'dunk_2.png'),
(13, 12, 'dunk_3.png'),
(25, 1, 'jordan_1_3.png');

-- --------------------------------------------------------

--
-- Table structure for table `sneakersInfo`
--

CREATE TABLE `sneakersInfo` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT 'no_name',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `precio` int NOT NULL,
  `valoraciones` int NOT NULL,
  `estado` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'publicado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sneakersInfo`
--

INSERT INTO `sneakersInfo` (`id`, `name`, `description`, `precio`, `valoraciones`, `estado`) VALUES
(1, 'Jordan X Dior', 'La Air Jordan 1 X Dior son unas de las colaboraciones más exclusivas dentro del mundo de la moda.', 7485, 150, 'sin publicar'),
(2, 'Jordan Mid Lanen', 'La zapatilla Air Jordan 1 Mid está inspirada en la primera AJ1 y supone toda una oportunidad para los aficionados de las zapatillas Jordan clásicas de seguir los grandiosos pasos de su ídolo. El color vivo hace relucir los materiales elegantemente clásicos y aporta todo un toque innovador al conocido diseño.', 193, 58, 'publicado'),
(3, 'Jordan Light Blue', 'Zapatillas Jordan 1 en color azul claro.', 120, 243, 'publicado'),
(4, 'Jordan Tie Dye', 'Jordan 1 con estampado TieDye', 256, 12, 'publicado'),
(5, 'Jordan X A Ma Maniére', 'La tienda de James Whitner en Atlanta A Ma Maniére es conocida por combinar el lujo de la alta costura con un gran sentido de la finalidad. En esta versión de las Air Jordan 1, la tienda se adentra en los mitos sobre MJ para crear un modelo a la altura de la leyenda.', 532, 24, 'publicado'),
(6, 'Jordan Light Iron Ore', 'Las Air Jordan 1 Mid SE Light Iron Ore presentan una base de cuero blanco granulado con superposiciones de lona gruesa de color gris. Un swoosh de cuero rosa adorna los paneles y proporciona contraste a la silueta neutra. Las marcas de la firma, como el logotipo Jumpman y Wings, presentan un tono plateado que combina cuidadosamente con la entresuela blanca y la suela gris.', 125, 89, 'publicado'),
(7, 'AF1 Classic', 'El fulgor sigue vivo con las Nike Air Force 1 \'07, un icono del baloncesto que aporta un nuevo toque a su ya característica piel impecable, sus colores llamativos y la cantidad perfecta de reflectante.', 100, 1329, 'publicado'),
(8, 'AF1 University Blue', 'El clásico modelo AF1 con unos unos tonos azules.', 150, 512, 'publicado'),
(9, 'AF1 Psychic Blue', 'El clásico modelo AF1 con unos unos tonos azules claros.', 150, 183, 'publicado'),
(10, 'Dunk Low Essential Paisley', 'Dunk Low en tonos verdes.', 281, 238, 'publicado'),
(11, 'Dunk Low StrangeLove', 'Dunk Low en tonos rojos', 678, 239, 'publicado'),
(12, 'Dunk Low Green Glow', 'Dunk Low en tonos verde neón.', 248, 67, 'publicado');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `tag` varchar(255) NOT NULL,
  `id_sneaker` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `id_sneaker`) VALUES
(1, 'nike', 1),
(3, 'dior', 1),
(4, 'baloncesto', 1),
(8, 'basket', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nickname` varchar(16) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nickname`, `email`, `password`, `rol`) VALUES
(1, 'mariolopg', 'mariolopg@gmail.com', '$2y$10$38tuxnFgFTzlBScsD6dxSOhdy7rTKBU8bw9PrzSRj05i/69C43VOO', 'superuser'),
(9, 'admin', 'administrador@gmail.com', '$2y$10$UwaE4cN/BYwK50BOI16jCOSzQD2wDfUhEK5vn8ZthXVH1qxZDfg72', 'superuser'),
(16, 'moderador', 'moderador@moderador.com', '$2y$10$CjMtjfTfIkb3ZkiE61FLleOdzHd1VLvvXS/eILOUn1.9Hfu1D3NZS', 'moderador'),
(17, 'gestor', 'gestor@gestor.com', '$2y$10$oS1V3qButAD4JZ7jENXY/O8ogUAqWPSF7hDpP/460OTQpyjB3JRlG', 'gestor'),
(18, 'default', 'default@default.com', '$2y$10$Z4ZpZXt.3mn79QM3bH54Mu2BSRaveVtiP587qFXgiyzSvwoxDjxt2', 'default');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `badWords`
--
ALTER TABLE `badWords`
  ADD PRIMARY KEY (`word`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`nombre`);

--
-- Indexes for table `sneakersComments`
--
ALTER TABLE `sneakersComments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sneaker_fk` (`id_sneaker`),
  ADD KEY `user_fk` (`user_id`);

--
-- Indexes for table `sneakersImages`
--
ALTER TABLE `sneakersImages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sneaker` (`id_sneaker`);

--
-- Indexes for table `sneakersInfo`
--
ALTER TABLE `sneakersInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sneaker_fk_tags` (`id_sneaker`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_fk` (`rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sneakersComments`
--
ALTER TABLE `sneakersComments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sneakersImages`
--
ALTER TABLE `sneakersImages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sneakersInfo`
--
ALTER TABLE `sneakersInfo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sneakersComments`
--
ALTER TABLE `sneakersComments`
  ADD CONSTRAINT `sneaker_fk` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakersInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sneakersImages`
--
ALTER TABLE `sneakersImages`
  ADD CONSTRAINT `sneaker_images_fk` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakersInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `sneaker_fk_tags` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakersInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `rol_fk` FOREIGN KEY (`rol`) REFERENCES `roles` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
