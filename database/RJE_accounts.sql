-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2024 at 05:06 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `RJE_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `peso_accounts`
--

CREATE TABLE `peso_accounts` (
  `id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peso_accounts`
--

INSERT INTO `peso_accounts` (`id`, `image`, `name`, `email`, `password`, `user_type`, `date_registered`) VALUES
(1, 'profile1.png', 'administrator', 'admin@gmail.com', '1234', 'admin', '2024-09-19 17:36:42'),
(3, 'profile1.png', 'test', 'test@gmail.com', '12345678', 'user', '2024-09-19 17:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `rating_accounts`
--

CREATE TABLE `rating_accounts` (
  `id` int(11) NOT NULL,
  `image` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(20) NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_accounts`
--

INSERT INTO `rating_accounts` (`id`, `image`, `name`, `email`, `password`, `userType`, `date_registered`) VALUES
(1, 'profile.jpeg', 'admin', 'admin@gmail.com', '$2y$10$l.yf3TkwqwDRyWDWhSR0peX3jm6AUlc/5FBT5Tsuu2ZyRuXbf9PnK', 'rating_admin', '2024-09-14 23:22:35'),
(3, 'profile.jpeg', 'user3', 'user2@gmail.com', '$2y$10$wcOjhCgmUrpeJq14/1dcbubadYZ.SdCKzNZs/3Oktg5nbO9SDOT9K', 'rating_user', '2024-09-14 23:29:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peso_accounts`
--
ALTER TABLE `peso_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_accounts`
--
ALTER TABLE `rating_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peso_accounts`
--
ALTER TABLE `peso_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rating_accounts`
--
ALTER TABLE `rating_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
