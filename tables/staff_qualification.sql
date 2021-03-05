-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2021 at 02:53 PM
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
-- Table structure for table `staff_qualification`
--

CREATE TABLE `staff_qualification` (
  `stq_id` int(5) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `qualification_id` int(10) NOT NULL,
  `stq_institute` varchar(100) NOT NULL,
  `stq_board` varchar(10) NOT NULL,
  `stq_year` int(4) NOT NULL DEFAULT 0,
  `stq_marksObtained` int(10) NOT NULL DEFAULT 0,
  `stq_marksMax` int(10) NOT NULL DEFAULT 0,
  `stq_percentage` decimal(10,0) NOT NULL DEFAULT 0,
  `stq_fn` varchar(100) NOT NULL DEFAULT '--',
  `stq_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_qualification`
--

INSERT INTO `staff_qualification` (`stq_id`, `staff_id`, `qualification_id`, `stq_institute`, `stq_board`, `stq_year`, `stq_marksObtained`, `stq_marksMax`, `stq_percentage`, `stq_fn`, `stq_status`) VALUES
(1, 3, 3, 'Ryan', 'CBSE', 1996, 90, 67, '90', '', 0),
(2, 3, 6, 'Ryan', 'ICSE', 1996, 33, 67, '90', '', 0),
(3, 4, 1, 'Ryan', 'ICSE', 1996, 90, 90, '90', '../../demo/qualification/3.pdf', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff_qualification`
--
ALTER TABLE `staff_qualification`
  ADD PRIMARY KEY (`stq_id`),
  ADD UNIQUE KEY `student_id` (`staff_id`,`qualification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff_qualification`
--
ALTER TABLE `staff_qualification`
  MODIFY `stq_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
