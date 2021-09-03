-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2021 at 12:46 PM
-- Server version: 5.7.35
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classcon_aryan`
--

-- --------------------------------------------------------

--
-- Table structure for table `fee_structure`
--

CREATE TABLE `fee_structure` (
  `school_id` int(3) DEFAULT NULL,
  `program_id` int(3) DEFAULT NULL,
  `batch_id` int(3) DEFAULT NULL,
  `fee_category` int(3) DEFAULT NULL,
  `fee_type` int(3) DEFAULT NULL,
  `fee_component` int(3) DEFAULT NULL,
  `fee_semester` int(3) DEFAULT NULL,
  `fc_amount` varchar(6) DEFAULT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_id` int(5) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee_structure`
--

INSERT INTO `fee_structure` (`school_id`, `program_id`, `batch_id`, `fee_category`, `fee_type`, `fee_component`, `fee_semester`, `fc_amount`, `update_ts`, `update_id`, `status`) VALUES
(1, 1, 12, 13, 37, 38, 1, '4', '2021-08-28 15:32:17', 1, 0),
(1, 1, 12, 13, 37, 38, 4, '4', '2021-08-28 15:32:22', 1, 0),
(7, 20, 12, 13, 37, 38, 4, '4', '2021-08-28 15:32:26', 1, 0),
(7, 21, 12, 13, 37, 38, 4, '4', '2021-08-28 15:32:29', 1, 0),
(7, 21, 12, 13, 35, 38, 4, '4', '2021-08-28 15:32:32', 1, 0),
(4, 11, 12, 30, 32, 33, 1, '21', '2021-08-28 15:36:58', 1, 0),
(2, 4, 12, 30, 32, 33, 1, '25', '2021-08-28 15:37:17', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fee_structure`
--
ALTER TABLE `fee_structure`
  ADD UNIQUE KEY `school_id` (`school_id`,`program_id`,`batch_id`,`fee_category`,`fee_type`,`fee_semester`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
