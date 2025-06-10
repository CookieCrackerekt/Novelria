-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 03:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `novel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `novel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `novel_id`) VALUES
(33, 1, 29),
(34, 1, 30),
(36, 18, 32);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(111) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES
(1, 'Adventure'),
(2, 'Mystery'),
(3, 'Fantasy'),
(4, 'Sci-Fi'),
(5, 'Horror'),
(6, 'Thriller'),
(7, 'Historical'),
(8, 'Romance'),
(9, 'Comedy');

-- --------------------------------------------------------

--
-- Table structure for table `novels`
--

CREATE TABLE `novels` (
  `novel_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `genre_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `pdf_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `novels`
--

INSERT INTO `novels` (`novel_id`, `user_id`, `genre_id`, `title`, `image_path`, `pdf_path`) VALUES
(29, 1, 1, 'Adventures of Huckleberry Finn', 'uploads/bookcover1.jpg', 'uploads/Adventures-of-Huckleberry-Finn.pdf'),
(30, 1, 8, 'A-Romantic-Young-Lady', 'uploads/bookcover2.jpg', 'uploads/A-Romantic-Young-Lady.pdf'),
(32, 1, 3, 'Emma', 'uploads/bookcover4.jpg', 'uploads/Emma.pdf'),
(33, 1, 5, 'Ghostly-Guardian', 'uploads/bookcover5.jpg', 'uploads/Ghostly-Guardian.pdf'),
(34, 1, 1, 'Hunted-by-the-Past', 'uploads/bookcover6.jpg', 'uploads/Hunted-by-the-Past.pdf'),
(36, 1, 3, 'Lady-Tanglewood', 'uploads/bookcover7.jpg', 'uploads/Lady-Tanglewood.pdf'),
(37, 1, 2, 'The-Count-of-Monte-Cristo', 'uploads/bookcover12.jpg', 'uploads/The-Count-of-Monte-Cristo.pdf'),
(40, 19, 4, 'HG Well Time Machines', 'uploads/bookcover14.jpg', 'uploads/The-Time-Machine.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`) VALUES
(1, 'afif', 'afif', '12345678'),
(2, 'afkaar', 'afkaar', 'nuuriafkaar'),
(4, 'anna', 'anna', '12345678'),
(9, 'Dede', 'Dede', '12345678'),
(17, 'aa', 'aa', 'aa'),
(18, 'laila nur', 'laila', '12345678'),
(19, 'andre taulani', 'andre', '12345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `favorites_novel_id_fr` (`novel_id`),
  ADD KEY `favorites_user_id_fr` (`user_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `novels`
--
ALTER TABLE `novels`
  ADD PRIMARY KEY (`novel_id`),
  ADD KEY `novels_genre_id_fr` (`genre_id`),
  ADD KEY `novels_user_id_fr` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `novels`
--
ALTER TABLE `novels`
  MODIFY `novel_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_novel_id_fr` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`novel_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_user_id_fr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `novels`
--
ALTER TABLE `novels`
  ADD CONSTRAINT `novels_genre_id_fr` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `novels_user_id_fr` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
