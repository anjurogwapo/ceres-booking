-- phpMyAdmin SQL Dump
-- Version: 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 08:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

-- Database: `ceres_liner_db`

-- --------------------------------------------------------

-- Table structure for table `admin_user`
CREATE TABLE IF NOT EXISTS `admin_user` (
  `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_username` VARCHAR(50) NOT NULL,
  `admin_password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `admin_user`
INSERT INTO `admin_user` (`admin_id`, `admin_username`, `admin_password`) VALUES
(7, 'art', 'paul123');

-- --------------------------------------------------------

-- Table structure for table `buses`
CREATE TABLE IF NOT EXISTS `buses` (
  `bus_id` INT(11) NOT NULL AUTO_INCREMENT,
  `bus_name` VARCHAR(255) NOT NULL,
  `available` INT(11) NOT NULL,
  PRIMARY KEY (`bus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `buses`
INSERT INTO `buses` (`bus_id`, `bus_name`, `available`) VALUES
(1, 'Silay', 34),
(2, 'Victorias', 43),
(3, 'Talisay', 34);

-- --------------------------------------------------------

-- Table structure for table `seat_reservations`
CREATE TABLE IF NOT EXISTS `seat_reservations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `seat_number` INT(11) NOT NULL,
  `status` VARCHAR(10) NOT NULL,
  `destination` VARCHAR(50) DEFAULT NULL,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `booking_id` VARCHAR(50) DEFAULT NULL,
  `user_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seat_number` (`seat_number`,`destination`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `profile_picture` VARCHAR(255) DEFAULT NULL,
  `age` INT(11) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `phone_number` VARCHAR(255) DEFAULT NULL,
  `emergency_contact_name` VARCHAR(255) DEFAULT NULL,
  `emergency_contact_address` VARCHAR(255) DEFAULT NULL,
  `emergency_contact_phone` VARCHAR(255) DEFAULT NULL,
  `emergency_contact_relationship` ENUM('Mother','Father','Grandparents','Siblings','Guardian') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `age`, `address`, `phone_number`, `emergency_contact_name`, `emergency_contact_address`, `emergency_contact_phone`, `emergency_contact_relationship`) VALUES
(6, 'chim', 'andrew08paul@gmail.com', '$2y$10$Wo5qjzK5DUFPy6/shdJHD.GDQy1a0ZFgzgPurpGl/xGRxCScOIJ0O', 'dfasfasdf.png', 16, 'city', '0909090909', 'pol', 'popo', '09245435', 'Guardian'),
(7, 'paul', 'andrew08paul@gmail.com', '$2y$10$tpVtZ2Frdqjs2fzA2Chhne3U9GbsjH4BLP7Os0YBK2Ev12KuyIY92', '', 10, 'city', '0909090909', 'chim', 'popo', '09245435', 'Guardian'),
(13, 'qweasd', 'andrewnemous08@gmail.com', '$2y$10$a5GV8hAa5DGFY./a2QBhcOYIYxaMeWJKnDDizp3OXwDU0.MYhno9i', '', 10, 'city', '0909090909', 'pol', 'popo', '09245435', 'Grandparents');

-- --------------------------------------------------------

-- Table structure for table `user_locations`
CREATE TABLE IF NOT EXISTS `user_locations` (
  `location_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `latitude` DECIMAL(10,8) NOT NULL,
  `longitude` DECIMAL(11,8) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`location_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `user_locations`
INSERT INTO `user_locations` (`location_id`, `user_id`, `latitude`, `longitude`, `timestamp`) VALUES
(1, 7, 10.73807360, 123.12248320, '2024-03-10 07:31:02');

-- --------------------------------------------------------
