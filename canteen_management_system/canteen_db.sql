-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2023 at 08:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canteen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additem`
--

CREATE TABLE `additem` (
  `itemId` int(11) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `itemDesc` varchar(1000) NOT NULL,
  `itemKeywords` varchar(1000) NOT NULL,
  `image` text NOT NULL,
  `salePrice` double NOT NULL,
  `Quantity` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(59, 1, 'Free Fall', 6, 1, 'freefall.jpg'),
(62, 1, 'Economic', 5, 2, 'economic.jpg'),
(63, 4, 'Economic', 5, 2, 'economic.jpg'),
(64, 4, 'Free Fall', 6, 3, 'freefall.jpg'),
(76, 8, 'Free Fall', 550, 1, 'freefall.jpg'),
(83, 6, 'Red Queen', 450, 1, 'red_queen.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(11, 3, 'Ramesh Paudel', '9856423654', 'ramesh123@gmail.com', 'cash on delivery', 'flat no. 103, kamaltar, Pokhara, Nepal - 43234', ', Economic (2) , Free Fall (1) ', 16, '17-Jul-2023', 'completed'),
(14, 7, 'Manish', '2356478965', 'manish123@gmail.com', 'cash on delivery', 'flat no. 12, Belauri, Kathmandu, Nepal - 1234', ', Economic (1) , Free Fall (2) ', 17, '10-Aug-2023', 'completed'),
(15, 8, 'Sita Kumari', '987598541', 'sita123@gmail.com', 'cash on delivery', 'flat no. 102, kumari galli, kathmandu, Nepal - 12345', ', Economic (2) , Free Fall (3) ', 28, '13-Aug-2023', 'completed'),
(16, 8, 'Sita Kumari', '9745869658', 'sita123@gmail.com', 'cash on delivery', 'flat no. 101, hhgj, kathmandu, Nepal - 1234578', ', Free Fall (6) ', 36, '13-Aug-2023', 'pending'),
(17, 6, 'Rohit', '9875648975', 'rohit@gmail.com', 'cash on delivery', 'flat no. 102, sita galli, kathmandu, Nepal - 14563', ', DarkNet (1) , Red Queen (1) , Night Shade (1) , Holly Ghosts (1) , Shattered (1) ', 2475, '19-Aug-2023', 'completed'),
(18, 6, 'Ram', '6895689745', 'ram@gmail.com', 'cash on delivery', 'flat no. 103, ram galli, kathmandu, nepal - 14568', ', DarkNet (2) ', 1100, '19-Aug-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(7, 'Red Queen', 450, 'red_queen.jpg'),
(8, 'Night Shade', 425, 'nightshade.jpg'),
(9, 'Holly Ghosts', 620, 'holy_ghosts.jpg'),
(10, 'Shattered', 430, 'shattered.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(5, 'Manoj Adhikari', 'manoj123@gmail.com', '977c0156d7403e2bebba75cdf5652678', 'admin'),
(6, 'Rakesh Sharma', 'rakesh123@gmail.com', '32da0f5520e7edba6fb80d34db349cc6', 'user'),
(7, 'Manish Shrestha', 'manish123@gmail.com', 'b2fd8301040ce1dae22f4bfcd54017b0', 'user'),
(8, 'Sita Kumari', 'sita123@gmail.com', '22eb6d573a7bdfd019b97909cbe36141', 'user'),
(9, 'manish12', 'manish@gmail.com', '392cbd9d8a28cf9be1a9941e55e650f2', 'user'),
(10, 'admin123', 'admin@gmail.com', '392cbd9d8a28cf9be1a9941e55e650f2', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additem`
--
ALTER TABLE `additem`
  ADD PRIMARY KEY (`itemId`),
  ADD UNIQUE KEY `itemId` (`itemId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additem`
--
ALTER TABLE `additem`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
