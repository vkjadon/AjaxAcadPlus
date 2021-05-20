-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2021 at 10:20 AM
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
-- Table structure for table `leave_year`
--

CREATE TABLE `leave_year` (
  `ly_id` int(5) NOT NULL,
  `ly_from` date DEFAULT NULL,
  `ly_to` date DEFAULT NULL,
  `ly_status` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_year`
--

INSERT INTO `leave_year` (`ly_id`, `ly_from`, `ly_to`, `ly_status`) VALUES
(1, '2021-05-20', '2021-05-05', 'A'),
(2, '2021-05-27', '2021-05-04', 'A'),
(3, '2021-05-18', '2022-04-26', 'C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_year`
--
ALTER TABLE `leave_year`
  ADD PRIMARY KEY (`ly_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_year`
--
ALTER TABLE `leave_year`
  MODIFY `ly_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
