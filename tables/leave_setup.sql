-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2021 at 10:19 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classcon_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `leave_setup`
--

CREATE TABLE `leave_setup` (
  `ls_id` int(4) NOT NULL,
  `leave_typeid` int(5) NOT NULL,
  `ls_month` int(2) NOT NULL,
  `ls_gender` varchar(10) NOT NULL,
  `ly_id` int(4) DEFAULT NULL,
  `ls_value` float NOT NULL,
  `ls_status` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_setup`
--

INSERT INTO `leave_setup` (`ls_id`, `leave_typeid`, `ls_month`, `ls_gender`, `ly_id`, `ls_value`, `ls_status`) VALUES
(1, 4, 12, '0', NULL, 6, '0'),
(2, 7, 8, '0', 3, 7, '0'),
(3, 5, 6, '0', 3, 6, '0'),
(4, 9, 12, '0', 3, 7, '0'),
(5, 5, 6, '0', 3, 6, '0'),
(6, 6, 5, '0', 3, 8, '0'),
(7, 5, 8, 'F', 3, 6, '0'),
(8, 7, 8, 'F', 3, 8, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_setup`
--
ALTER TABLE `leave_setup`
  ADD PRIMARY KEY (`ls_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_setup`
--
ALTER TABLE `leave_setup`
  MODIFY `ls_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
