-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2022 at 10:54 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*the above 4 lines created by me in order to solve a problem in initiallization */
/* sometimes is needed and sometimes not */
/* drop user 'keyrock'@'localhost';
FLUSH PRIVILEGES;
drop user 'keyrock'@'%';
FLUSH PRIVILEGES; */
CREATE USER 'keyrock'@'localhost' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'localhost' WITH GRANT OPTION;
CREATE USER 'keyrock'@'%' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS `cloud_eshop_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cloud_eshop_db`;

--
-- Database: `cloud_eshop_db`
--

-- --------------------------------------------------------



--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Surname` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` enum('Admin','ProductSeller','User') NOT NULL,
  `Confirmed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Surname`, `Username`, `Password`, `Email`, `Role`, `Confirmed`) VALUES
(1, 'Leonidas', 'Bakopoulos', 'leo', '1234', 'l@tuc.gr', 'Admin', 1),
(14, 'Stelios', 'Salvador', 'Mwra', '1234', 'mwra@mwra', 'ProductSeller', 1),
(15, 'Dimitris', 'Mitsotakis', 'Mitsos', '1234', 'mitsos@endelexeia.com', 'ProductSeller', 1),
(16, 'Kapa Vita', 'Vita', 'K B', '1234', 'KB@stereonova', 'ProductSeller', 1),
(19, 'Michael', 'Scott', 'mscott', '1111', 'mscott@dunder.com', 'ProductSeller', 1),
(22, 'Jo', 'Bako', 'Joanna Blue', '1234', 'Joanna@j', 'User', 1);

--
-- Indexes for dumped tables
--

--
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--



ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
