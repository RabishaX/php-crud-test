-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 12:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_image`, `name`, `price`, `quantity`) VALUES
(1, 'wired-usb-mouse.webp', 'Wired USB Mouse', 700.00, 20),
(2, 'Lenovo-idealpad.webp', 'Lenovo IdeaPad 1 Laptop Intel Core i5', 148990.00, 10),
(3, 'Hp-Laptop1.webp', 'HP 250 G10 Laptop', 139900.00, 2),
(4, 'Hp-Laptop2.webp', 'HP Laptop 15-FD1311TU Laptop', 168.00, 10),
(5, 'Hp-Laptop3.webp', 'HP 250 G10 Laptop', 139900.00, 20),
(6, 'mouse1.webp', ' Logitech B100 Optical USB Mouse Logitech B100 Optical USB Mouse', 1000.00, 5),
(7, 'mouse2.webp', 'Wired Silent Mouse', 1500.00, 10),
(8, 'mouse3.webp', 'M930 Wired Gaming Mouse', 1600.00, 20),
(9, 'mouse4.webp', 'Amaze Probus A704 Wired Mouse', 1430.00, 10),
(10, 'keyboard1.webp', 'Multimedia SmartKey FN Keyboard', 1850.00, 5),
(11, 'keyboard2.webp', 'ComfortKey RoundEdge Keycaps', 1950.00, 10),
(13, 'keyboard2.webp', 'LED Bulb', 120.00, 10),
(14, 'fan.jpg', 'Ceiling Fan', 4500.00, 5),
(15, 'geyser.jpg', 'Geyser', 12000.00, 2),
(16, 'light.jpg', 'USB Light', 300.00, 15),
(17, 'tube.jpg', 'Tube Light', 250.00, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
