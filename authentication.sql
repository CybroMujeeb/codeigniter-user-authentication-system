-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2019 at 05:12 PM
-- Server version: 10.0.38-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.2.16-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `authentication`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_reg_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`user_id`, `user_email`, `user_fullname`, `user_phone`, `user_password`, `user_reg_time`) VALUES
(1, 'mujeeb.mx@gmx.com', 'Mujeeb Rahman', '9744156727', '$2y$10$/cHrgUW52.ZSKT0YH0NbUedqO1/LvtKTZqWwslRtMfQW/M1b6J3GK', '2019-04-29 15:23:11'),
(2, 'mujeeb.mx@yahoo.com', 'dsfsdf', '1236547890', '$2y$10$IoDYyrPiGuIlj1rEhhGweOMCRTau8vtXhe2QOO0qNJDWMp3qUHIIe', '2019-04-29 16:14:37'),
(3, 'test@test.com', 'test', '9876543212', '$2y$10$ZugQtiDqHsEcpmopidiNKeSSnuTMI/95nuXMj263IBrlz3IIcGjda', '2019-04-29 16:36:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
