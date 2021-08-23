-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 23, 2021 at 05:56 AM
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
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(5) NOT NULL,
  `batch_id` int(3) DEFAULT NULL,
  `program_id` int(3) DEFAULT NULL,
  `ay_id` int(2) DEFAULT NULL,
  `student_lateral` int(1) NOT NULL DEFAULT '0',
  `student_regular` int(1) NOT NULL DEFAULT '0',
  `student_semester` int(2) DEFAULT NULL,
  `user_id` varchar(12) DEFAULT NULL,
  `student_name` varchar(50) DEFAULT NULL,
  `student_rollno` varchar(20) DEFAULT NULL,
  `student_mobile` varchar(10) DEFAULT NULL,
  `student_email` varchar(50) DEFAULT NULL,
  `student_dob` date DEFAULT NULL,
  `student_gender` varchar(1) DEFAULT NULL,
  `student_category` varchar(10) DEFAULT NULL,
  `student_whatsapp` varchar(10) DEFAULT NULL,
  `student_bg` varchar(4) DEFAULT NULL,
  `student_religion` varchar(20) DEFAULT NULL,
  `student_adhaar` varchar(16) DEFAULT NULL,
  `student_fee_category` varchar(20) DEFAULT NULL,
  `student_admission` date DEFAULT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_id` int(4) DEFAULT NULL,
  `student_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `batch_id`, `program_id`, `ay_id`, `student_lateral`, `student_regular`, `student_semester`, `user_id`, `student_name`, `student_rollno`, `student_mobile`, `student_email`, `student_dob`, `student_gender`, `student_category`, `student_whatsapp`, `student_bg`, `student_religion`, `student_adhaar`, `student_fee_category`, `student_admission`, `update_ts`, `update_id`, `student_status`) VALUES
(1, 12, 1, 12, 0, 1, 1, '9421010001', 'Shivam Mittal', NULL, '7009565589', 'shivammittal0928@gmail.com', '2000-03-28', NULL, 'Genera', '7009565589', NULL, 'Hindu', '873811655658', 'Gen', '2021-02-22', '2021-08-21 05:41:19', 1, 0),
(2, 12, 1, 12, 0, 1, 1, '9421010002', 'Safiya Bin Bashir', NULL, '8427400988', '', '1994-02-10', 'F', 'Genera', NULL, NULL, 'Muslim', '813802123503', 'Gen', '2020-12-15', '2021-08-21 07:14:08', 1, 0),
(3, 12, 1, 12, 0, 1, 1, '9421010003', 'Suraj Prakash Ghosh', NULL, '8427400988', NULL, '2000-07-27', NULL, 'Genera', NULL, NULL, 'Hindu', '919793262763', 'Gen', '2021-04-28', '2021-08-21 07:18:54', 1, 0),
(4, 12, 1, 12, 0, 1, 1, '9421010004', 'Rajinder Singh', NULL, '8427400988', NULL, '1998-10-21', NULL, 'Genera', NULL, NULL, 'Hindu', '218220453801', 'Gen', '2021-04-29', '2021-08-21 07:27:17', 1, 0),
(5, 12, 1, 12, 0, 1, 1, '9421010005', 'Prakhar Singh', NULL, '8427400988', NULL, '1998-03-17', NULL, 'Genera', NULL, NULL, 'Hindu', '926206797980', 'Gen', '2021-05-10', '2021-08-21 07:30:03', 1, 0),
(6, 12, 1, 12, 0, 1, 1, '9421010006', 'Akash Arora', NULL, '8427400988', NULL, '1999-10-27', NULL, 'Genera', NULL, NULL, 'Hindu', '932518286044', 'Gen', '2021-05-11', '2021-08-21 07:32:45', 1, 0),
(7, 12, 1, 12, 0, 1, 1, '9421010007', 'Harsimran Singh ', NULL, '8427400988', NULL, '2000-05-06', NULL, 'Genera', NULL, NULL, 'Sikh', '634943281377', 'Gen', '2021-05-12', '2021-08-21 07:35:35', 1, 0),
(8, 12, 1, 12, 0, 1, 1, '9421010008', 'Digvijay Singh', NULL, '8427400988', NULL, '2000-02-26', NULL, 'Genera', NULL, NULL, 'Hindu', '907203925065', 'OBC', '2021-05-24', '2021-08-21 07:37:40', 1, 0),
(9, 12, 1, 12, 0, 0, 1, '9421010009', 'Nishant Jain', NULL, '8427400988', NULL, '1998-09-11', NULL, 'Genera', NULL, NULL, 'Hindu', '805322170486', 'Gen', '2021-06-05', '2021-08-21 07:40:02', 1, 0),
(10, 12, 1, 12, 0, 0, 1, '9421010010', 'Vineet Sikand', NULL, '8427400988', NULL, '1996-01-31', NULL, 'Genera', NULL, NULL, 'Hindu', '611687691395', 'Gen', '2021-06-08', '2021-08-21 08:02:06', 1, 0),
(11, 12, 1, 12, 0, 0, 1, '9421010011', 'Vinay Rathi', NULL, '8427400988', NULL, '1996-08-15', NULL, 'Genera', '', NULL, 'Hindu', NULL, 'Gen', '1996-08-15', '2021-08-21 08:05:01', 1, 0),
(12, 12, 1, 12, 0, 0, 1, '9421010012', 'Birendra Karki', NULL, '8427400988', NULL, '2000-03-02', NULL, 'Genera', NULL, NULL, 'Hindu', '952832644579', 'Gen', '2021-08-21', '2021-08-21 08:09:10', 1, 0),
(13, 12, 1, 12, 0, 0, 1, '9421010013', 'Ajay Kumar', NULL, '8427400988', NULL, '1999-08-01', NULL, 'Genera', NULL, NULL, NULL, '451566680595', 'Gen', '2021-06-11', '2021-08-21 08:13:04', 1, 0),
(14, 12, 1, 12, 0, 0, 1, '9421010014', 'Kashika Jyoti', NULL, '8427400988', NULL, '1994-04-08', 'F', 'Genera', NULL, NULL, 'Hindu', '260120805505', 'Gen', '2021-12-06', '2021-08-21 08:16:54', 1, 0),
(15, 12, 1, 12, 0, 0, 1, '9421010015', 'Monika', NULL, '8427400988', NULL, '1998-03-12', 'F', 'Genera', NULL, NULL, 'Hindu', '344538623356', 'Gen', '2021-06-05', '2021-08-21 08:25:18', 1, 0),
(16, 12, 1, 12, 0, 1, 1, '9421010016', 'Yasir Nazir Chalkoo', NULL, '8427400988', NULL, '1996-02-15', NULL, 'Genera', NULL, NULL, 'Muslim', '508819685535', 'OBC', '2021-06-12', '2021-08-21 08:32:03', 1, 0),
(17, 12, 1, 12, 0, 0, 1, '9421010017', 'Arman Gupta', NULL, '8427400988', NULL, '2000-06-05', NULL, 'Genera', NULL, NULL, 'Hindu', '581423430672', 'Gen', '2021-06-14', '2021-08-21 08:33:56', 1, 0),
(18, 12, 1, 12, 0, 0, 1, '9421010018', 'Abhishake Jindal', NULL, '8427400988', NULL, '2001-10-05', NULL, 'Genera', NULL, NULL, 'Hindu', '781356307739', 'Gen', '2021-06-14', '2021-08-21 08:37:14', 1, 0),
(19, 12, 1, 12, 0, 1, 1, '9421010019', 'Shahid Nazir Dar', NULL, '8427400988', NULL, '1999-08-03', NULL, 'RBA', NULL, NULL, 'Muslim', '48053957729', 'Gen', '2021-06-24', '2021-08-21 08:44:00', 1, 0),
(20, 12, 1, 12, 0, 0, 1, '9421010020', 'Umer Farooq Sheikh', NULL, '8427400988', NULL, '2000-04-04', NULL, 'Genera', NULL, NULL, 'Muslim', '383471561121', 'Gen', '2021-06-25', '2021-08-21 08:47:01', 1, 0),
(21, 12, 1, 12, 0, 0, 1, '9421010021', 'Bilal Rashid Hajam', NULL, '8427400988', NULL, '1999-10-05', NULL, 'SC', NULL, NULL, 'Muslim', NULL, 'Gen', '2021-06-29', '2021-08-21 08:49:37', 1, 0),
(22, 12, 1, 12, 0, 0, 1, '9421010022', 'Mohammad Iqbal Ahanger', NULL, '8427400988', '', '1999-04-07', NULL, 'SC', NULL, NULL, 'Muslim', NULL, 'Gen', '2021-06-29', '2021-08-21 08:51:49', 1, 0),
(23, 12, 1, 12, 0, 0, 1, '9421010023', 'Nirmal Singh', NULL, '8427400988', NULL, '2000-02-18', NULL, 'Genera', NULL, NULL, 'Hindu', '632286064511', 'Gen', '2021-06-30', '2021-08-21 08:54:04', 1, 0),
(24, 12, 1, 12, 0, 0, 1, '9421010024', 'Rajesh Singh', NULL, '8427400988', NULL, '1998-09-24', NULL, 'Genera', NULL, NULL, 'Hindu', '678451312589', 'Gen', '2021-06-30', '2021-08-21 08:57:40', 1, 0),
(25, 12, 1, 12, 0, 0, 1, '9421010025', 'Gurdeep Singh', NULL, '8427400988', NULL, '2001-02-24', NULL, 'Genera', NULL, NULL, 'Sikh', '494398519039', 'Gen', '2021-06-30', '2021-08-21 09:00:05', 1, 0),
(26, 12, 1, 12, 0, 0, 1, '9421010026', 'Vishal Singh', NULL, '8427400988', NULL, '2001-01-07', NULL, 'Genera', NULL, NULL, 'Hindu', '556898150483', 'Gen', '2021-06-30', '2021-08-21 09:02:39', 1, 0),
(27, 12, 1, 12, 0, 1, 1, '9421010027', 'Mohd Arshad', NULL, '8427400988', NULL, '1998-09-03', NULL, 'Genera', NULL, NULL, 'Muslim', '758071339134', 'Gen', '2021-07-09', '2021-08-21 09:07:50', 1, 0),
(28, 12, 1, 12, 0, 0, 1, '9421010028', 'Ishika Raina', NULL, '8427400988', NULL, '2000-07-09', NULL, 'Genera', NULL, NULL, 'Muslim', '968272549547', 'Gen', '2021-07-10', '2021-08-21 09:14:30', 1, 0),
(29, 12, 1, 12, 0, 0, 1, '9421010029', 'Md Saquib', NULL, '8427400988', NULL, '1997-02-25', NULL, 'Genera', NULL, NULL, 'Muslim', '452805727600', 'Gen', '2021-07-12', '2021-08-21 09:17:08', 1, 0),
(30, 12, 1, 12, 0, 0, 1, '9421010030', 'Simranpreet Kaur', NULL, '8427400988', NULL, '1995-12-31', 'F', 'SC', NULL, NULL, 'Sikh', NULL, 'Gen', '2021-06-12', '2021-08-21 09:19:41', 1, 0),
(31, 12, 1, 12, 0, 0, 1, '9421010031', 'Sadia Ayash', NULL, '8427400988', NULL, '1992-04-04', NULL, 'Genera', NULL, NULL, 'Muslim', '232192389699', 'Gen', '2021-07-14', '2021-08-21 09:21:45', 1, 0),
(32, 12, 1, 12, 0, 1, 1, '9421010032', 'Ishfaq Manzoor Baba Peerzada', NULL, '8427400988', NULL, '1998-04-15', NULL, 'Genera', NULL, NULL, 'Muslim', '816331587287', 'Gen', '2021-07-16', '2021-08-21 09:24:23', 1, 0),
(33, 12, 1, 12, 0, 0, 1, '9421010033', 'Rashul Gupta ', NULL, '8427400988', NULL, '1998-04-01', NULL, 'Genera', NULL, NULL, 'Hindu', '286091511682', 'Gen', '2021-07-17', '2021-08-21 09:37:28', 1, 0),
(34, 12, 1, 12, 0, 0, 1, '9421010034', 'Talha Aijaz Ganaie', NULL, '8427400988', NULL, '1998-11-05', NULL, 'Genera', NULL, NULL, 'Muslim', '267561163984', 'Gen', '2021-07-17', '2021-08-21 09:40:09', 1, 0),
(35, 12, 1, 12, 0, 1, 1, '9421010035', 'Sajjan yadav', NULL, '8427400988', NULL, '1998-08-06', NULL, 'Genera', NULL, NULL, 'Hindu', '349356663822', 'Gen', '2021-09-17', '2021-08-21 09:46:58', 1, 0),
(36, 12, 1, 12, 0, 0, 1, '9421010036', 'Sandeep', NULL, '8427400988', NULL, '1998-02-11', NULL, 'SC', NULL, NULL, 'Hindu', '473441765482', 'Gen', '2021-07-21', '2021-08-21 09:50:29', 1, 0),
(37, 12, 1, 12, 0, 0, 1, '9421010037', 'Kunal Sharma', NULL, '8427400988', NULL, '1997-11-10', NULL, 'Genera', NULL, NULL, 'Hindu', '397157514888', 'Gen', '2021-07-21', '2021-08-21 09:53:07', 1, 0),
(38, 12, 1, 12, 0, 0, 1, '9421010038', 'Ayush Dhadwal', NULL, '8427400988', NULL, '2001-03-28', NULL, 'Genera', NULL, NULL, 'Hindu', NULL, 'Gen', '2021-07-29', '2021-08-21 09:56:41', 1, 0),
(39, 12, 1, 12, 0, 1, 1, '9421010039', 'Ranvir Singh', NULL, '8427400988', NULL, '1995-11-13', NULL, 'Genera', NULL, NULL, 'Sikh', '683581471018', 'Gen', '2021-08-04', '2021-08-21 09:58:48', 1, 0),
(40, 12, 1, 12, 0, 0, 1, '9421010040', 'Simran Chahal', NULL, '8427400988', NULL, '2000-12-24', NULL, 'Genera', NULL, NULL, 'Hindu', '493294397690', 'Gen', '2021-08-03', '2021-08-21 10:00:41', 1, 0),
(41, 12, 1, 12, 0, 0, 1, '9421010041', 'ikhlas ahmad das', NULL, '8427400988', NULL, '1999-03-01', NULL, 'Genera', NULL, NULL, 'Muslim', '595726125227', 'Gen', '2021-08-09', '2021-08-21 10:02:48', 1, 0),
(42, 12, 1, 12, 0, 0, 1, '9421010042', 'Sandeep Kumar', NULL, '8427400988', NULL, '2001-02-10', NULL, 'Genera', NULL, NULL, 'Hindu', '206767933247', 'Gen', '2021-08-13', '2021-08-21 10:06:34', 1, 0),
(43, 12, 1, 12, 0, 0, 1, '9421010043', 'Teshlal Ram', NULL, '8427400988', NULL, '1992-08-31', NULL, 'SC', NULL, NULL, 'Muslim', NULL, 'SC', '2021-08-13', '2021-08-21 10:11:08', 1, 0),
(44, 12, 1, 12, 0, 1, 1, '9421010044', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-13', '2021-08-21 10:15:01', 1, 0),
(45, 12, 1, 12, 0, 0, 1, '9421010045', 'Lochna jain', NULL, '8427400988', NULL, '1995-11-07', NULL, 'Genera', NULL, NULL, 'Hindu', '693017653469', 'Gen', '2021-08-16', '2021-08-21 10:16:13', 1, 0),
(46, 12, 1, 12, 0, 1, 1, '9421010046', 'Rahul Kumar', NULL, '8427400988', NULL, '1999-08-11', NULL, 'Genera', NULL, NULL, 'Hindu', '349169138115', 'Gen', '2021-08-16', '2021-08-21 10:18:23', 1, 0),
(47, 12, 5, 12, 0, 1, 1, '9121020001', 'Kishore Kumar Choudhary', NULL, '8427400988', NULL, '1998-07-28', NULL, 'Genera', NULL, NULL, 'Hindu', NULL, 'Gen', '2021-06-21', '2021-08-21 11:03:20', 1, 0),
(48, 12, 5, 12, 0, 1, 1, '9121020002', 'devendra kumar thakur', NULL, '8427400988', '', '2004-02-17', NULL, 'Genera', NULL, NULL, 'Hindu', '16017700891', 'Gen', '2021-08-12', '2021-08-21 11:07:55', 1, 0),
(49, 12, 3, 12, 0, 0, 1, '9921010001', 'Kiran Kumari', NULL, '8427400988', NULL, '1996-04-28', 'F', 'Genera', NULL, NULL, 'Hindu', NULL, 'Gen', '2021-04-02', '2021-08-23 08:02:49', 1, 0),
(50, 12, 3, 12, 0, 0, 1, '9921010002', 'Kiran Kumari', NULL, '8427400988', NULL, '1996-04-28', 'M', 'Genera', '8427400988', NULL, 'Hindu', '255144862072', 'Gen', '2021-04-02', '2021-08-23 08:07:10', 1, 0),
(51, 12, 6, 12, 0, 1, 1, '9121010001', 'Navdeep Kaur', NULL, '8427400988', NULL, '2004-07-11', 'F', 'SC', '8427400988', NULL, 'Sikh', NULL, 'SC', '2021-05-11', '2021-08-23 08:25:16', 1, 0),
(52, 12, 6, 12, 0, 1, 1, '9121010002', 'Nitika Devi ', NULL, '8427400988', NULL, '2003-01-27', 'F', 'OBC', '8427400988', NULL, 'Hindu', '497462071321', 'Gen', '2021-06-16', '2021-08-23 09:18:13', 1, 0),
(53, 12, 6, 12, 0, 1, 1, '9121010003', 'Neeraj Kumar', NULL, '8427400988', NULL, '1998-11-15', 'M', 'OBC', '8427400988', NULL, 'Hindu', '9966359432281', 'OBC', '2021-06-18', '2021-08-23 09:25:40', 1, 0),
(54, 12, 6, 12, 0, 0, 1, '9121010004', 'Md Dilshad Alam', NULL, '8427400988', NULL, '2004-01-01', 'M', 'BC', '8427400988', NULL, 'Muslim', '441690032994', 'Gen', '2021-07-31', '2021-08-23 09:29:03', 1, 0),
(55, 12, 6, 12, 0, 1, 1, '9121010005', 'Kifayat Hussain Sofi', NULL, '8427400988', NULL, '2004-01-10', 'M', 'Genera', '8427400988', NULL, 'Muslim', '237732437746', 'Gen', '2021-08-02', '2021-08-23 09:33:35', 1, 0),
(56, 12, 6, 12, 0, 0, 1, '9121010006', 'Charanjeet Kaur', NULL, '8427400988', NULL, '2004-04-20', 'F', 'BC', '8427400988', NULL, 'Sikh', '683890568784', 'Gen', '2021-07-07', '2021-08-23 09:40:53', 1, 0),
(57, 12, 8, 12, 0, 1, 1, '9121080001', 'Ajay Kumar Mahto ', NULL, '8427400988', NULL, '1998-03-12', 'M', 'Genera', '8427400988', NULL, 'Hindu', '771695774757', 'Gen', '2021-06-21', '2021-08-23 09:46:08', 1, 0),
(58, 12, 10, 12, 0, 1, 1, '9121060001', 'Rohit Kumar', NULL, '8427400988', NULL, '2003-05-29', 'M', 'OBC', '8427400988', NULL, 'Cres', '899054236983', 'OBC', '2021-04-12', '2021-08-23 09:49:45', 1, 0),
(59, 12, 10, 12, 0, 1, 1, '9121060002', 'Bipin Kumar Sah', NULL, '8427400988', NULL, NULL, 'M', NULL, '8427400988', NULL, NULL, NULL, NULL, '2021-07-14', '2021-08-23 09:52:09', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_address`
--

CREATE TABLE `student_address` (
  `student_id` int(10) DEFAULT NULL,
  `permanent_address` tinytext,
  `correspondence_address` tinytext,
  `city` varchar(100) DEFAULT NULL,
  `district_id` int(4) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `pincode` int(6) DEFAULT NULL,
  `update_id` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_address`
--

INSERT INTO `student_address` (`student_id`, `permanent_address`, `correspondence_address`, `city`, `district_id`, `state_id`, `pincode`, `update_id`) VALUES
(1, 'House No.-867 Street No.-1 Vear Circular, Road Abohar\n', '', 'Abohar', 450, 28, NULL, 1),
(2, 'Solinabazar Srinagar, Jammu and KAshmir Pin Code-190009\n', '', 'Solin bazar', 218, 15, 190009, 1),
(3, 'Khara, Mohali, Punjab.Pincode:, 140301\n', NULL, 'Kharar', 462, 28, 140301, 1),
(4, 'Sector 70, Mohali. Pincode: 160071\n', NULL, 'Mohali', 462, 28, 160071, 1),
(5, 'Kalka, Panchkula. Pincode 133302\n', NULL, 'Panchkula', 179, 13, 133302, 1),
(6, 'Zirakpur, Punjab. 140603\n', NULL, 'Zirakpur', 462, 28, 140603, 1),
(7, '46 Sharma Estate Zirakpur Sas Nagar , Mohali Punjab.140603\n', NULL, 'Mohali', 462, 28, 140603, 1),
(8, '168 Behlana, chandigarh 160003\n', '', 'Chandigarh', 106, 6, 160003, 1),
(9, 'Ward No. 6, Jain Mohalla, banur\n', NULL, 'Banur', 462, 28, 140601, 1),
(10, 'Near Shriram Sharnam Loghuts, hp\n', NULL, 'himachal pradesh', 0, 14, NULL, 1),
(11, 'Sector 21D House No. 3333, chandigarh\n', NULL, 'Chandigarh', 106, 6, 0, 1),
(12, '54 Phase 2 Mohali\n', NULL, 'Mohali', 462, 28, NULL, 1),
(13, 'Vpo Malookpur, Abohar, fazilka\n', NULL, 'Fazilka', 450, 28, 0, 1),
(14, 'Danoh, Bilaspur, Hp\n', NULL, 'Bilaspur', 186, 14, NULL, 1),
(15, 'House No. 59, Tower Enclave, Phase 2, jalandhar\n', NULL, 'Jalandhar', NULL, 28, NULL, 1),
(16, 'Amlook Colony, Uri, Baramulla, srinagar JK\n', NULL, 'Srinagar', 201, 15, 0, 1),
(17, 'Bhucho Mandi, bathida, Punjab\n', NULL, 'Bathinda', NULL, 28, NULL, 1),
(18, 'Kalan Wali , Sirsa, haryana\n', NULL, 'Sirsa', 183, 13, NULL, 1),
(19, 'Village- Nathussa, Po Handwara, Kupwara, J&K, 193221\n', NULL, 'Handwara', 208, 15, 193221, 1),
(20, 'Qalam Abad, Kupwara,J&K, Pincode: 193302\n', NULL, 'Kupwara', 208, 15, 193302, 1),
(21, 'Botingu, Po Sopore Baramulla, 193201\n', NULL, 'Sopore', 201, 15, 193201, 1),
(22, 'Botingu Baramulla Botingoo Jk, 193201\n', NULL, 'Botingu', 201, 15, 193201, 1),
(23, 'Village Kheri Gurna, , Teh- Rajpura, Distt Patiala,140417\n', NULL, 'Rajpura', 460, 28, 140417, 1),
(24, 'Village Behli, Teh Nalagarh, Distt Solan, Himachal Pradesh, 174101\n', NULL, 'Solan', 196, 14, 174101, 1),
(25, 'Vpo Bhatian, Teh Nalagarh, Distt Solan, HP, 174101\n', NULL, 'Solan', 196, 14, 174101, 1),
(26, 'Village Jagatpur, Po Joghon, Teh Nalagarh, Solan, HP , 174101\n', NULL, 'Joghon', 196, 14, 174101, 1),
(27, 'Rajouri, Thothali, J7k. Pincode:185151\n', NULL, 'Rajouri', 213, 15, 185151, 1),
(28, 'Lahe No. 21,Block No. 119,Flat No.21,Jag, ti Colony,Jammu. Pincode:181221\n', NULL, 'Jammu', 204, 15, 181221, 1),
(29, 'Village-Kathmaliya,Ps-Shikarganj,Dhaka,, East Champaran,Bihar. 845418\n', NULL, 'Bihar', 79, 5, 845418, 1),
(30, 'H.No.43,Old Matagujri Enclave,Mundi,Kharar,Mohali.Pincode-140301\n', NULL, 'Mohali', 462, 28, 140301, 1),
(31, 'A-57,Budshah Nagar,Near Old Rto, Srinagar,J&K\n', NULL, 'Srinagar', 218, 15, 0, 1),
(32, 'District-Kupwara Drugmulla , Jammu and Kashmir Pin Code-193222\n', NULL, 'Drugmulla', 208, 15, 193222, 1),
(33, '138, Sector-25 Panchkula Haryana , Pin Code-134116 \n', NULL, 'Panchkula', 179, 13, 134116, 1),
(34, 'Botinagar District-Baramulla, Jammu and Kashmir Pin Code-193201 \n', NULL, 'Botinagar', 201, 15, 193201, 1),
(35, 'Naban Mohalla, Rajouri, J&K.Pincode:, 185131\n', NULL, 'Rajouri', 213, 15, 185131, 1),
(36, 'V.P.O.-Sulehra District-Jind , Tehsil-Narwana Haryana Pin Code-126116\n', NULL, 'Narwana', 172, 13, 126116, 1),
(37, 'Village-Sayar Tehsil-Arki, P.O.-Darla Ghat Solan,Himachal Pradesh , Pin Code-171102\n', NULL, 'Darla Ghat', 196, 14, 171102, 1),
(38, 'Vpo-Rumehr Monsimbal Bhawarana, Pin Code-176083 Kangra, Himachal Pradesh Pin Code-176083\n', NULL, 'Kangra', 189, 14, 176083, 1),
(39, 'VPO-Khedi Gurna Tehsil-Rajpura District-Patiala Pin Code-140417\n', NULL, 'Rajpura', 460, 28, 140417, 1),
(40, 'Village-Rollan P.O.-Rampur Sursheri Ambala Cantt Pin Code-133001 Haryana\n', NULL, 'Ambala', 165, 13, 133001, 1),
(41, 'Tikipora lolab Kupwara Pin Code-193223 jammu and Kashmir\n', NULL, 'Kupwara', 208, 15, 0, 1),
(42, 'Village-Nuho P.O.Lodhimajra District-Ropar Rupnagar Punjab Pin Code-140113\n', NULL, 'Rupnagar', 461, 28, 140113, 1),
(43, 'vill-niranjanpur sakala bazar District-rohtas  bihar pin code-802214\n', NULL, 'Rohtas', 97, 5, 802214, 1),
(44, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(45, 'jain Mohalla Near Shani Dev Mandir Banur Pin Code 140601\n', NULL, 'Banur', 462, 28, 140601, 1),
(46, 'Ambuja Colony Daburji H.No.-A 39 Rupnagar Punjab Pin Code-140113\n', NULL, 'Rupnagar', 461, 28, 140113, 1),
(47, 'Sapaul Nepal \n', NULL, '', NULL, 0, 0, 1),
(48, 'Rajbiraj Saptari Nepal Pin Code-56400\n', NULL, 'Rajbiraj', 0, 25, 56400, 1),
(49, 'Udaipur, Rajasthan. Pincode- 313211\n', NULL, 'Udaipur', NULL, NULL, 313211, 1),
(50, 'Udaipur, Rajasthan. Pincode- 313211\n', NULL, 'Udaipur', NULL, NULL, 313211, 1),
(51, 'Village-Kalomajra, Rajpura, Patiala\n', NULL, 'Rajpura', NULL, NULL, 0, 1),
(52, 'V/O Narot Mehra Pathankot, PIN code 145025\n', NULL, 'Pathankot', NULL, NULL, 145025, 1),
(53, 'Ward No. 6 Bhaluahi Madhepura, bihar Saharsa\n', NULL, 'Madhepur', NULL, NULL, 852113, 1),
(54, 'Sheikh Mohalla Bihar, District-Nalanda Pin Code-803101\n', NULL, 'Nalanda', NULL, NULL, 803101, 1),
(55, 'mirgund pattan District-Baramulla Pin Code-193121 Jammu and Kashmir\n', NULL, 'Pattan', NULL, NULL, 193121, 1),
(56, 'Vill-Nathu Majra P.O.-Narru Tehsil-Rajpura District-Patiala\n', NULL, 'Rajpura', NULL, NULL, 148021, 1),
(57, 'Vill-Malpatti Pokanour Distt-, Darbhanga (Bihar) 847306 \n', NULL, 'Pokanour', NULL, NULL, 847306, 1),
(58, 'Khagaria, Bihar.Pincode: 851215\n', NULL, 'Khagaria', NULL, NULL, 851215, 1),
(59, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_detail`
--

CREATE TABLE `student_detail` (
  `student_id` int(5) DEFAULT NULL,
  `student_fname` varchar(50) DEFAULT NULL,
  `student_mname` varchar(50) DEFAULT NULL,
  `student_fmobile` varchar(10) DEFAULT NULL,
  `student_mmobile` varchar(10) DEFAULT NULL,
  `student_femail` varchar(50) DEFAULT NULL,
  `student_memail` varchar(50) DEFAULT NULL,
  `student_foccupation` varchar(50) DEFAULT NULL,
  `student_moccupation` varchar(50) DEFAULT NULL,
  `student_fdesignation` varchar(50) DEFAULT NULL,
  `student_mdesignation` varchar(50) DEFAULT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_detail`
--

INSERT INTO `student_detail` (`student_id`, `student_fname`, `student_mname`, `student_fmobile`, `student_mmobile`, `student_femail`, `student_memail`, `student_foccupation`, `student_moccupation`, `student_fdesignation`, `student_mdesignation`, `update_ts`, `update_id`) VALUES
(1, 'Suman Kumar', 'Manisha', '9463234132', 'mmobile', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 05:41:19', 1),
(2, 'Bashir Ahmd Sopore', 'Mehmooda', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:14:08', 1),
(3, 'Subrota Ghosh', 'Nilima Ghosh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:18:54', 1),
(4, 'Jarnail Singh', 'Sona Rani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:27:17', 1),
(5, 'Ajay Kishore Singh', 'Pretti Singh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:30:03', 1),
(6, 'Jatinder Arora', 'Neelam Arora', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:32:45', 1),
(7, 'Rupinder Singh ', 'Gurjit Kaur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:35:35', 1),
(8, 'Jitendra Singh', 'Poonam Singh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:37:40', 1),
(9, 'Mukesh Kumar', 'Neelu Jain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 07:40:02', 1),
(10, 'Ram Lal Sikand', 'Asha Sikand', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:02:06', 1),
(11, 'Rajender Rathi', 'Mukesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:05:01', 1),
(12, 'Netar Bahadur', 'Durga Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:09:10', 1),
(13, 'Som Parkash', 'Veena Rani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:13:04', 1),
(14, 'Suresh Kumar', NULL, 'Anita Pati', NULL, NULL, NULL, '', NULL, NULL, NULL, '2021-08-21 08:16:54', 1),
(15, 'Dalip Chand', 'Sunita Rani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:25:18', 1),
(16, 'Nazir Ahmad Chalkoo', 'Mehmooda Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:32:03', 1),
(17, 'Rajesh Kumar Gupta', 'Kiran Bala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:33:56', 1),
(18, 'Om Parkash Jindal', 'Kamlesh Rani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:37:14', 1),
(19, 'Nazir Ahmad Dar', 'Zareena Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:44:00', 1),
(20, 'Farooq Ahmad Sheikh', 'Masrata Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:47:01', 1),
(21, 'Abdul Rashid Hajam', 'Saleema Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:49:37', 1),
(22, 'Showket Ahmad Ahanger', 'Misra Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:51:49', 1),
(23, 'Daljeet Singh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:54:04', 1),
(24, 'Jarnail Singh', 'Usha Kiran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 08:57:40', 1),
(25, 'Surender Singh', 'Dharamjeet Kaur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:00:05', 1),
(26, 'Rupinder Singh', 'Raj Kumari', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:02:39', 1),
(27, 'Mohd Aziz', 'Shamim Akhtar', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2021-08-21 09:07:50', 1),
(28, 'Shrawan Kumar Raina', 'Karuna Raina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:14:30', 1),
(29, 'Md Quamrul Hoda', 'Raziya Khatoon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:17:08', 1),
(30, 'Kulwinder Singh', 'Sarabjit Kaur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:19:41', 1),
(31, 'Mohd Ayash Khan', 'Irshada Khan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:21:45', 1),
(32, 'Manzoor Ahmad Baba Peerzada', 'Sarwa Baigum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:24:23', 1),
(33, 'Rajeev Gupta', 'Ritu Gupta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:37:28', 1),
(34, 'Aijaz Ahmad Ganaie', 'Masooda Begum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:40:09', 1),
(35, 'Munijar Yadav', 'Anita Yadav', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:46:58', 1),
(36, 'Sewa Singh', 'Sunita', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:50:29', 1),
(37, 'Bhuvneshwar Sharma', 'Meena Sharma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:53:07', 1),
(38, 'Anil Kumar', 'Rita Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:56:41', 1),
(39, 'Bahadur Singh', 'Harpal Kaur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 09:58:48', 1),
(40, 'Malkit Singh', 'Gurjinder Kaur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:00:41', 1),
(41, 'mohmmad jamal rather', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:02:48', 1),
(42, 'Ram Kumar Prasad', 'Kanti devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:06:34', 1),
(43, 'baban Ram', 'Vimla Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:11:08', 1),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:15:01', 1),
(45, 'Subash Jain', 'Sunita Jain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:16:13', 1),
(46, 'Baban Singh', 'Kunti Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 10:18:23', 1),
(47, 'Chandar Narayan Choudhary ', 'Saraswati Naryan Choudrary ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 11:03:20', 1),
(48, 'ram sebak thakur', 'radha thakur', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2021-08-21 11:07:55', 1),
(49, 'Prabhulal Jat', 'Kanchan Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 08:02:49', 1),
(50, 'Prabhulal Jat', 'Kanchan Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 08:07:10', 1),
(51, 'Manga Singh', 'Amarjit Kaur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 08:25:16', 1),
(52, 'Darshan Singh ', 'Indu Bala ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:18:13', 1),
(53, 'Hulo Mandal', 'Savitree Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:25:40', 1),
(54, 'Md Kaisar Alam', 'Mussarat Parveen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:29:03', 1),
(55, 'Bashir Ahmad Sofi', 'Mysara Bano', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:33:35', 1),
(56, 'Didar Singh', 'Sunita Devi', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:40:53', 1),
(57, 'Narsh Mahto ', 'Sunita Devi ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:46:08', 1),
(58, 'Kapildev Pandit', 'Lalita Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:49:45', 1),
(59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-23 09:52:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_qualification`
--

CREATE TABLE `student_qualification` (
  `sq_id` int(5) NOT NULL,
  `student_id` int(5) DEFAULT NULL,
  `mn_id` int(3) DEFAULT NULL,
  `sq_institute` varchar(100) DEFAULT NULL,
  `sq_board` varchar(50) DEFAULT NULL,
  `sq_year` int(4) DEFAULT NULL,
  `sq_mo` int(4) DEFAULT NULL,
  `sq_mm` int(4) DEFAULT NULL,
  `sq_percentage` float DEFAULT NULL,
  `sq_cgpa` float DEFAULT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_id` int(4) DEFAULT NULL,
  `sq_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_qualification`
--

INSERT INTO `student_qualification` (`sq_id`, `student_id`, `mn_id`, `sq_institute`, `sq_board`, `sq_year`, `sq_mo`, `sq_mm`, `sq_percentage`, `sq_cgpa`, `update_ts`, `update_id`, `sq_status`) VALUES
(1, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-21 05:46:51', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_reference`
--

CREATE TABLE `student_reference` (
  `student_id` int(5) NOT NULL,
  `reference_name` varchar(100) DEFAULT NULL,
  `reference_designation` varchar(20) DEFAULT NULL,
  `reference_mobile` varchar(10) DEFAULT NULL,
  `reference_incentive` int(5) DEFAULT NULL,
  `reference_type` int(1) DEFAULT NULL,
  `remarks` tinytext,
  `update_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_reference`
--

INSERT INTO `student_reference` (`student_id`, `reference_name`, `reference_designation`, `reference_mobile`, `reference_incentive`, `reference_type`, `remarks`, `update_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(9, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(10, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(11, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(12, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(13, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(14, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(15, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(16, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(17, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(18, NULL, NULL, NULL, NULL, NULL, '', 1),
(19, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(20, NULL, NULL, NULL, NULL, NULL, '', 1),
(21, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(22, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(23, NULL, NULL, NULL, NULL, NULL, '', 1),
(24, NULL, NULL, NULL, NULL, NULL, '', 1),
(25, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(26, NULL, NULL, NULL, NULL, NULL, '', 1),
(27, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(28, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(29, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(30, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(31, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(32, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(33, NULL, NULL, NULL, NULL, NULL, '', 1),
(34, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(35, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(36, NULL, NULL, NULL, NULL, NULL, '', 1),
(37, NULL, NULL, NULL, NULL, NULL, '', 1),
(38, NULL, NULL, NULL, NULL, NULL, '', 1),
(39, NULL, NULL, NULL, NULL, NULL, '', 1),
(40, NULL, NULL, NULL, NULL, NULL, '', 1),
(41, NULL, NULL, NULL, NULL, NULL, '', 1),
(42, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(43, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(44, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(45, NULL, NULL, NULL, NULL, NULL, '', 1),
(46, NULL, NULL, NULL, NULL, NULL, '', 1),
(47, NULL, NULL, NULL, NULL, NULL, '', 1),
(48, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(49, '', 'Coordinator', NULL, NULL, NULL, NULL, 1),
(50, '', 'Coordinator', NULL, NULL, NULL, NULL, 1),
(51, 'Chanpreet', 'Assistant Professor', '', 0, NULL, '', 1),
(52, 'Kanika', 'Assistant Professor', NULL, NULL, NULL, NULL, 1),
(53, 'Amarjot', 'Assistant Professor', NULL, NULL, NULL, NULL, 1),
(54, 'Kusum ', 'Assistant Professor', '', NULL, NULL, NULL, 1),
(55, 'Mudasir', 'Assistant Professor', NULL, NULL, NULL, NULL, 1),
(56, 'Dhamika', 'Assistant Professor', NULL, NULL, NULL, NULL, 1),
(57, 'Ishu Mam', 'Assistant Professor', '', NULL, NULL, '', 1),
(58, 'Sanjeev Arora', 'Coordinator', NULL, NULL, NULL, NULL, 1),
(59, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_rollno` (`student_rollno`);

--
-- Indexes for table `student_address`
--
ALTER TABLE `student_address`
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `student_detail`
--
ALTER TABLE `student_detail`
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `student_qualification`
--
ALTER TABLE `student_qualification`
  ADD PRIMARY KEY (`sq_id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`mn_id`);

--
-- Indexes for table `student_reference`
--
ALTER TABLE `student_reference`
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `student_qualification`
--
ALTER TABLE `student_qualification`
  MODIFY `sq_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
