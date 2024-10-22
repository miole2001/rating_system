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
-- Database: `RJE_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `action_type` varchar(40) NOT NULL,
  `userType` varchar(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `email`, `action_type`, `userType`, `date`) VALUES
(6, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-19 00:29:10'),
(7, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-20 11:13:37'),
(8, 'admin@gmail.com', 'Logout', 'rating_admin', '2024-09-20 11:14:13'),
(9, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-20 14:20:02'),
(10, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-20 14:53:16'),
(11, 'admin@gmail.com', 'Logout', 'rating_admin', '2024-09-20 15:34:45'),
(12, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-20 15:34:53'),
(13, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-21 10:50:43'),
(14, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-21 10:54:03'),
(15, 'admin@gmail.com', 'Login', 'rating_admin', '2024-09-21 10:59:12'),
(16, 'admin@gmail.com', 'Logout', 'rating_admin', '2024-09-21 11:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `userType` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`ID`, `email`, `action_type`, `userType`, `date`) VALUES
(1, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-18 23:32:29'),
(2, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-18 23:32:38'),
(4, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-18 23:45:14'),
(5, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-18 23:45:20'),
(6, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-19 00:02:36'),
(7, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-19 00:15:08'),
(8, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-19 21:13:57'),
(9, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-20 11:12:48'),
(10, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-20 11:13:21'),
(11, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-21 10:50:09'),
(12, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-21 10:50:32'),
(13, 'user2@gmail.com', 'Login', 'rating_user', '2024-09-21 11:04:58'),
(14, 'user2@gmail.com', 'Logout', 'rating_user', '2024-09-21 11:05:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
