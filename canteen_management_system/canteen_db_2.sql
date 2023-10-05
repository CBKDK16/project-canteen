-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2023 at 06:18 AM
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
  `image` varchar(100) NOT NULL,
  `salePrice` double NOT NULL,
  `Quantity` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additem`
--

INSERT INTO `additem` (`itemId`, `itemName`, `itemDesc`, `itemKeywords`, `image`, `salePrice`, `Quantity`) VALUES
(12, 'momo', 'Momos are a type of steamed filled dumpling in Tibetan and Nepali cuisine that is also popular in neighbouring Bhutan and India.', 'carb,happy,nonveg,hot', 'momo.jpg', 100, 3),
(13, 'chowmein', 'it was spicy food items.', 'happy,calorie,fats,veg', 'chowmein.jpg', 100, 5),
(14, 'Dew cold Drink', 'cold drink', 'cold,happy,sugar', 'Mountain_dew.jpg', 80, 5),
(15, 'Happy Dent', 'chewing gum mint flavour', 'sad,happy,fats', 'happydent white mint chewing gum.jpg', 2, 50),
(16, 'Milk Tea', 'Milk tea', 'hot,sugar,excitement,happy,anger', 'milk tea.jpg', 25, 20),
(17, 'Parle_G', 'biscuit', 'fats,carb,sugar,calorie', 'parle_g.jpg', 10, 10),
(18, 'Pepsi ', 'cold drink', 'cold,sugar,calorie,happy,sad,excitement', 'pepsi.jpg', 50, 20),
(19, 'Black tea', 'tea', 'hot,sugar,fat,carb', 'cup-of-black-tea.jpg', 15, 20),
(20, 'Tiger', 'Biscuit', 'carb,fat,sugar,happy,sad', 'tiger.jpg', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin@username', 'admin@gmail.com', '392cbd9d8a28cf9be1a9941e55e650f2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `itemId` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `itemId`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(1, 12, 9, 'momo', 100, 1, 'momo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `compare_tbl`
--

CREATE TABLE `compare_tbl` (
  `cmp_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `table_no` int(11) NOT NULL,
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

INSERT INTO `orders` (`id`, `user_id`, `table_no`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(20, 9, 4, 'manish', '9856327404', 'qwerty@gmail.com', 'cash on delivery', 'thaiba', ', tiger biscuit (1) , momo (1) ', 120, '30-Sep-2023', 'completed'),
(21, 9, 5, 'manish', '9874563210', 'manish@gmail.com', 'cash on delivery', 'thaiba', ', momo (1) ', 100, '30-Sep-2023', 'pending'),
(22, 9, 5, 'qwerty', '9874563210', 'admin@gmail.com', 'cash on delivery', 'thaiba', ', chowmein (6) ', 600, '30-Sep-2023', 'pending'),
(23, 9, 1, 'manish', '9863860038', 'admin@gmail.com', 'cash on delivery', 'thaiba', ', momo (1) , chowmein (1) ', 200, '30-Sep-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(9, 'manish12', 'manish@gmail.com', '392cbd9d8a28cf9be1a9941e55e650f2'),
(11, 'user@username', 'user@gmail.com', '392cbd9d8a28cf9be1a9941e55e650f2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additem`
--
ALTER TABLE `additem`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `itemId` (`itemId`);

--
-- Indexes for table `compare_tbl`
--
ALTER TABLE `compare_tbl`
  ADD PRIMARY KEY (`cmp_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compare_tbl`
--
ALTER TABLE `compare_tbl`
  MODIFY `cmp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=516;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `additem` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `compare_tbl`
--
ALTER TABLE `compare_tbl`
  ADD CONSTRAINT `compare_tbl_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `additem` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
