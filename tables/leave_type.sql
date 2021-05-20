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
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `leave_typeid` int(2) NOT NULL,
  `leave_abbri` varchar(4) NOT NULL,
  `leave_type` varchar(23) NOT NULL,
  `leave_iscr_check` varchar(1) NOT NULL DEFAULT 'N',
  `leave_iota_name` varchar(20) NOT NULL,
  `leave_male_max` int(3) NOT NULL,
  `leave_female_max` int(3) NOT NULL,
  `leave_carry_forward` varchar(1) NOT NULL,
  `leave_male_ceiling` int(3) NOT NULL,
  `leave_female_ceiling` int(3) NOT NULL,
  `leave_max` int(3) NOT NULL,
  `monthly_restriction` int(3) NOT NULL,
  `leave_min` float NOT NULL,
  `min_duration` int(3) NOT NULL,
  `max_duration` int(2) NOT NULL,
  `approve_type` int(1) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`leave_typeid`, `leave_abbri`, `leave_type`, `leave_iscr_check`, `leave_iota_name`, `leave_male_max`, `leave_female_max`, `leave_carry_forward`, `leave_male_ceiling`, `leave_female_ceiling`, `leave_max`, `monthly_restriction`, `leave_min`, `min_duration`, `max_duration`, `approve_type`, `status`) VALUES
(1, 'CL', 'CASUAL', 'Y', 'Casual Leave', 10, 10, 'N', 0, 0, 5, 1, 1, 180, 6, 0, 'A'),
(3, 'AL', 'ACADEMIC', 'Y', 'Academic Leave', 6, 6, 'N', 0, 0, 2, 1, 1, 540, 15, 0, 'A'),
(4, 'ML', 'MEDICAL/UNAPPROVED', 'Y', 'Medical Leave', 5, 5, 'Y', 15, 15, 5, 5, 1, 540, 15, 0, 'A'),
(5, 'CO', 'COMPENSATORY', 'N', 'Compensatory', 0, 0, '', 0, 0, 365, 1, 1, 180, 6, 0, 'A'),
(6, 'OD', 'ON DUTY', 'N', 'On Duty Leave', 0, 0, '', 0, 0, 365, 365, 1, 180, 30, 0, 'D'),
(7, 'LWP', 'WITHOUT PAY', 'N', 'Without Pay', 0, 0, '', 0, 0, 365, 30, 1, 180, 15, 0, 'A'),
(8, 'EL', 'EARLY LEAVE', 'N', '', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 'A'),
(9, 'UWL', 'UNIVERSITY WORK LEAVE', 'N', '', 0, 0, 'N', 0, 0, 0, 0, 0, 0, 0, 0, 'A'),
(10, 'SL', 'SUMMER LEAVE', 'Y', '', 15, 15, 'N', 0, 0, 0, 0, 0, 0, 0, 0, 'A'),
(11, 'OD', 'ON DUTY', 'N', '', 2, 2, 'N', 1, 1, 0, 1, 1, 0, 0, 0, 'A'),
(12, 'FERL', 'Festival Early Leave', 'N', 'Festival Early Leave', 1, 1, 'N', 5, 5, 5, 5, 1, 5, 5, 0, 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`leave_typeid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `leave_typeid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
