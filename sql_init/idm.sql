-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: Jan 12, 2023 at 03:24 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE USER 'keyrock'@'localhost' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'localhost' WITH GRANT OPTION;
CREATE USER 'keyrock'@'%' IDENTIFIED BY 'keyrock';
GRANT ALL PRIVILEGES ON *.* TO 'keyrock'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
