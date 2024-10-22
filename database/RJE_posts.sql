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
-- Database: `RJE_posts`
--

-- --------------------------------------------------------

--
-- Table structure for table `rating_posts`
--

CREATE TABLE `rating_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_posts`
--

INSERT INTO `rating_posts` (`id`, `title`, `image`, `date_added`) VALUES
(1, '01 example post title', 'post_1.webp', '2024-09-14 23:31:30'),
(8, '02 example', 'post_2.webp', '2024-09-18 19:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `rating_reviews`
--

CREATE TABLE `rating_reviews` (
  `id` int(11) NOT NULL,
  `post_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `rating` int(7) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_reviews`
--

INSERT INTO `rating_reviews` (`id`, `post_id`, `user_id`, `rating`, `title`, `description`, `date`) VALUES
(2, 1, 3, 1, 'test', 'this is just a test test', '2024-09-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rating_posts`
--
ALTER TABLE `rating_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_reviews`
--
ALTER TABLE `rating_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rating_posts`
--
ALTER TABLE `rating_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rating_reviews`
--
ALTER TABLE `rating_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
