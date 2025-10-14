-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 14, 2025 at 08:43 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memory`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int NOT NULL,
  `emoji` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `emoji`) VALUES
(1, '🍕'),
(2, '🐱'),
(3, '🚀'),
(4, '🍩'),
(5, '🐶'),
(6, '🎮'),
(7, '🌟'),
(8, '🍔'),
(9, '👾'),
(10, '🦄'),
(11, '🎲'),
(12, '🧠');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pairs` int NOT NULL,
  `moves` int NOT NULL,
  `score` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `pairs`, `moves`, `score`, `created_at`) VALUES
(2, 2, 3, 23, 8, '2025-10-13 12:59:21'),
(3, 2, 3, 23, 8, '2025-10-13 13:01:42'),
(4, 2, 6, 13, 2, '2025-10-13 19:49:59'),
(5, 6, 3, 7, 2, '2025-10-13 19:54:27'),
(6, 6, 5, 13, 3, '2025-10-13 20:00:45'),
(7, 7, 3, 4, 1, '2025-10-14 07:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(2, 'tito@yahoo.com', '$2y$10$WRmP/KzSdiowBWYwzrYWOuZ9R7hp3Ja5NmLpF/GtYmbddNTRFfFCC', '2025-10-12 11:32:18'),
(6, 'starship@yahoo.com', '$2y$10$S1FgquQ94Oce0d32l0XHg.QtlCjyJw9s8mTZo03Tn3ejrM2ocVawW', '2025-10-13 19:53:38'),
(7, 'kokoriko200@yahoo.com', '$2y$10$g.jCmVsG9xOpBzye/LvUs.BRza1pcR.N4vApz4ftO6aER8tL0LsZe', '2025-10-14 07:28:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
