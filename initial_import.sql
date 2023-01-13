-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2023 at 03:27 PM
-- Server version: 8.0.26
-- PHP Version: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `post_cooking` tinyint(1) NOT NULL DEFAULT '0',
  `frozen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `post_cooking`, `frozen`) VALUES
(1, 'Pomodoro', 0, 0),
(2, 'Aglio', 0, 0),
(3, 'Prezzemolo', 0, 0),
(4, 'Mozzarella', 0, 0),
(5, 'Funghi Freschi', 0, 0),
(6, 'Funghi Trifolati', 0, 0),
(7, 'Wurstel', 0, 0),
(8, 'Patatine Fritte', 1, 0),
(9, 'Olive', 0, 0),
(10, 'Salame Piccante', 0, 0),
(11, 'Basilico', 0, 0),
(12, 'Tonno', 0, 0),
(13, 'Cipolla', 0, 0),
(14, 'Gorgonzola', 0, 0),
(15, 'Scamorza', 0, 0),
(16, 'Parmigiano', 0, 0),
(17, 'Acciughe', 0, 0),
(18, 'Capperi', 0, 0),
(19, 'Origano', 0, 0),
(20, 'Salsiccia', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients_in_products`
--

CREATE TABLE `ingredients_in_products` (
  `id_ingredient` int NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `ingredients_in_products`
--

INSERT INTO `ingredients_in_products` (`id_ingredient`, `id_product`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(4, 2),
(1, 3),
(4, 3),
(5, 3),
(1, 4),
(4, 4),
(6, 4),
(1, 5),
(4, 5),
(7, 5),
(8, 5),
(1, 6),
(4, 6),
(7, 6),
(1, 7),
(4, 7),
(9, 7),
(10, 7),
(11, 7),
(1, 8),
(4, 8),
(12, 8),
(13, 8),
(1, 9),
(4, 9),
(14, 9),
(15, 9),
(16, 9),
(1, 10),
(4, 10),
(17, 10),
(18, 10),
(19, 10),
(1, 11),
(4, 11),
(20, 11),
(1, 12),
(4, 12),
(10, 12),
(1, 13),
(4, 13),
(1, 14),
(4, 14),
(6, 14),
(20, 14);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `number` int NOT NULL,
  `id_user` int NOT NULL,
  `date` date NOT NULL,
  `total_price` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `id_type` int NOT NULL,
  `publication_date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `frozen` tinyint(1) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `id_type`, `publication_date`, `name`, `price`, `image`, `frozen`, `is_available`) VALUES
(1, 1, '2021-04-10', 'Marinara', '3.00', 'marinara.jpg', 0, 1),
(2, 1, '2021-04-10', 'Margherita', '3.50', 'margherita.jpg', 0, 1),
(3, 1, '2021-04-10', 'Funghi Freschi', '4.00', 'funghi-freschi.jpg', 0, 1),
(4, 1, '2021-04-10', 'Funghi Trifolati', '5.00', 'funghi-trifolati.jpg', 0, 1),
(5, 1, '2021-04-21', 'Tedesca', '5.50', 'tedesca.jpg', 0, 1),
(6, 1, '2021-04-21', 'W&uuml;rstel', '4.50', 'wurstel.jpg', 0, 1),
(7, 1, '2021-04-21', 'Diavola', '5.50', 'diavola.jpg', 0, 1),
(8, 1, '2021-04-21', 'Tonno e Cipolla', '6.00', 'tonno-cipolla.jpg', 0, 1),
(9, 1, '2021-04-21', 'Quattro Formaggi', '6.00', 'quattro-formaggi.jpg', 0, 0),
(10, 1, '2021-04-23', 'Romana', '5.00', 'romana.jpg', 0, 1),
(11, 1, '2021-04-23', 'Salsiccia', '4.50', 'salsiccia.jpg', 0, 1),
(12, 2, '2021-04-23', 'Calzone Piccante', '2.30', 'calzone-piccante.jpg', 0, 1),
(13, 2, '2021-04-23', 'Calzone Classico', '2.00', 'calzone-classico.jpg', 0, 1),
(14, 3, '2021-04-23', 'Montanara', '6.80', 'montanara.jpg', 0, 1),
(15, 4, '2021-05-17', 'Acqua Naturale 0.5l', '1.00', 'acqua-naturale.jpg', 0, 1),
(16, 4, '2021-05-17', 'Acqua Frizzante 0.5l', '1.00', 'acqua-frizzante.jpg', 0, 1),
(17, 5, '2021-05-28', 'Crema di mascarpone', '1.50', 'crema-mascarpone.jpg', 0, 1),
(18, 5, '2021-05-28', 'Tiramisu', '2.50', 'tiramisu.jpg', 0, 1),
(19, 6, '2021-05-28', 'Patatine Fritte', '2.50', 'patatine-fritte.jpg', 1, 1),
(20, 6, '2021-05-28', 'Anelli di Cipolla', '2.50', 'anelli-di-cipolla.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_in_orders`
--

CREATE TABLE `products_in_orders` (
  `id_product` int NOT NULL,
  `id_order` int NOT NULL,
  `number` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`) VALUES
(1, 'Pizza'),
(2, 'Calzone'),
(3, 'Pizza Speciale'),
(4, 'Bevanda'),
(5, 'Dolce'),
(6, 'Fritto');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `birth_date`, `admin`) VALUES
(1, 'test', 'test', 'test', 'test', '$2y$10$5svIty/5bQkuZ/4CkO2dguSqe.yJ9Hk84GBmEQoBbY/QI5o0dL99e', '2000-01-01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE NAME` (`name`) USING BTREE,
  ADD UNIQUE KEY `UNIQUE ID` (`id`) USING BTREE;

--
-- Indexes for table `ingredients_in_products`
--
ALTER TABLE `ingredients_in_products`
  ADD PRIMARY KEY (`id_ingredient`,`id_product`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `INDEX` (`id_ingredient`,`id_product`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`number`),
  ADD UNIQUE KEY `number` (`number`),
  ADD UNIQUE KEY `USER_UNIQUE` (`id_user`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`id`) USING BTREE,
  ADD KEY `INDEX ID_TYPE` (`id_type`),
  ADD KEY `INDEX NAME` (`name`) USING BTREE;

--
-- Indexes for table `products_in_orders`
--
ALTER TABLE `products_in_orders`
  ADD PRIMARY KEY (`id_product`,`id_order`),
  ADD UNIQUE KEY `UNIQUE` (`id_product`,`id_order`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `number` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients_in_products`
--
ALTER TABLE `ingredients_in_products`
  ADD CONSTRAINT `ingredients_in_products_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `ingredients_in_products_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredients` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `product_types` (`id`);

--
-- Constraints for table `products_in_orders`
--
ALTER TABLE `products_in_orders`
  ADD CONSTRAINT `products_in_orders_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`number`),
  ADD CONSTRAINT `products_in_orders_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
