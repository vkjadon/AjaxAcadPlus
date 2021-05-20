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
-- Table structure for table `leave_ledger`
--

CREATE TABLE `leave_ledger` (
  `ll_id` int(4) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `leave_typeid` int(2) NOT NULL,
  `submit_date` date NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `leave_from` date NOT NULL,
  `leave_to` date NOT NULL,
  `leave_timeFrom` time NOT NULL,
  `leave_timeTo` time NOT NULL,
  `leave_reason` text NOT NULL,
  `leave_status` varchar(1) NOT NULL DEFAULT '0',
  `approve_id` varchar(12) DEFAULT NULL,
  `approve_date` date DEFAULT NULL,
  `leave_duration` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_ledger`
--

INSERT INTO `leave_ledger` (`ll_id`, `staff_id`, `leave_typeid`, `submit_date`, `submit_time`, `leave_from`, `leave_to`, `leave_timeFrom`, `leave_timeTo`, `leave_reason`, `leave_status`, `approve_id`, `approve_date`, `leave_duration`) VALUES
(1, 1, 1, '2021-05-19', '2021-05-19 08:17:48', '2021-04-30', '2021-05-11', '13:47:00', '13:46:00', 'fd', '0', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_ledger`
--
ALTER TABLE `leave_ledger`
  ADD PRIMARY KEY (`ll_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_ledger`
--
ALTER TABLE `leave_ledger`
  MODIFY `ll_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
