-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2021 at 04:06 PM
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
-- Table structure for table `institution`
--

CREATE TABLE `institution` (
  `inst_id` int(2) NOT NULL,
  `inst_name` varchar(200) DEFAULT NULL,
  `inst_approval` varchar(150) DEFAULT NULL,
  `inst_affiliation` varchar(100) DEFAULT NULL,
  `inst_abbri` varchar(20) DEFAULT NULL,
  `inst_logo` blob DEFAULT NULL,
  `inst_address` text DEFAULT NULL,
  `inst_city` varchar(20) DEFAULT NULL,
  `inst_pincode` int(7) DEFAULT NULL,
  `inst_state` varchar(20) DEFAULT NULL,
  `inst_type` varchar(10) DEFAULT NULL,
  `inst_url` varchar(100) DEFAULT NULL,
  `inst_doi` date DEFAULT NULL,
  `inst_email` varchar(50) DEFAULT NULL,
  `inst_phone_1` int(10) DEFAULT NULL,
  `inst_phone_2` int(10) DEFAULT NULL,
  `inst_contact` text DEFAULT NULL,
  `submit_id` int(5) DEFAULT NULL,
  `inst_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institution`
--

INSERT INTO `institution` (`inst_id`, `inst_name`, `inst_approval`, `inst_affiliation`, `inst_abbri`, `inst_logo`, `inst_address`, `inst_city`, `inst_pincode`, `inst_state`, `inst_type`, `inst_url`, `inst_doi`, `inst_email`, `inst_phone_1`, `inst_phone_2`, `inst_contact`, `submit_id`, `inst_status`) VALUES
(1, 'Academic University', '', '', 'AU', '', '', NULL, NULL, NULL, NULL, 'https://www.classconnect.in/', '2001-12-03', '', 0, 0, '', 15, 0),
(2, 'Chitkara', NULL, NULL, 'CHITKARA', NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.chitkara.edu.in', '2021-03-27', NULL, NULL, NULL, NULL, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `institution`
--
ALTER TABLE `institution`
  ADD PRIMARY KEY (`inst_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `institution`
--
ALTER TABLE `institution`
  MODIFY `inst_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
