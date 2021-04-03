-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 02:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

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
-- Table structure for table `session_school`
--

CREATE TABLE `session_school` (
  `session_id` int(5) NOT NULL,
  `school_id` int(2) NOT NULL,
  `session_start` date NOT NULL,
  `session_end` date NOT NULL,
  `session_remarks` tinytext NOT NULL,
  `session_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_school`
--

INSERT INTO `session_school` (`session_id`, `school_id`, `session_start`, `session_end`, `session_remarks`, `session_status`) VALUES
(1, 1, '2021-04-01', '2021-04-30', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `session_school`
--
ALTER TABLE `session_school`
  ADD UNIQUE KEY `session_id` (`session_id`,`school_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
