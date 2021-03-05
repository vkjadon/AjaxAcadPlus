-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2021 at 02:52 PM
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
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(5) NOT NULL,
  `dept_id` int(2) NOT NULL,
  `designation_id` int(2) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_dob` date NOT NULL,
  `staff_fname` varchar(50) NOT NULL,
  `staff_mname` varchar(50) NOT NULL,
  `staff_doj` date NOT NULL,
  `staff_mobile` varchar(10) NOT NULL,
  `staff_email` varchar(50) NOT NULL,
  `staff_adhaar` varchar(19) DEFAULT NULL,
  `staff_address` text NOT NULL,
  `staff_type` varchar(1) NOT NULL,
  `staff_teaching` varchar(1) NOT NULL,
  `staff_gender` varchar(1) NOT NULL,
  `staff_abbri` varchar(4) NOT NULL,
  `submit_id` int(5) NOT NULL,
  `submit_date` date NOT NULL,
  `staff_status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `dept_id`, `designation_id`, `staff_name`, `staff_dob`, `staff_fname`, `staff_mname`, `staff_doj`, `staff_mobile`, `staff_email`, `staff_adhaar`, `staff_address`, `staff_type`, `staff_teaching`, `staff_gender`, `staff_abbri`, `submit_id`, `submit_date`, `staff_status`) VALUES
(1, 1, 41, 'MASTER USER', '2016-06-01', 'SASASA', '', '2016-06-06', '9872993230', 'vijay.jadon@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(2, 1, 29, ' MEENAKSHI NARULA', '2016-06-07', 'SS', '', '2016-05-31', '9878990217', 'demo@gmail.comy', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(3, 3, 23, 'DR. RASHMI BHATIA', '0000-00-00', 'NAN', '', '2011-07-18', '9873354581', 'hodbba.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(4, 2, 23, 'PREETI SINGH', '1949-03-15', 'LATE PRITAM SINGH', '', '2014-06-25', '9811365009', 'hod.pgdmib@ jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(5, 2, 23, 'SEEMA AGARWAL', '1962-09-10', 'DR V P GOEL', '', '2009-07-21', '9873300904', 'dyregistrar.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(6, 4, 6, 'GARIMA SACHDEVA', '1981-06-11', 'MR. LALIT KUMAR SACH', '', '2012-07-23', '9997772681', 'garima.sachdeva@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(7, 3, 6, 'DR. RUCHI SINGHAL ', '1975-12-27', 'LATE SH. O. P. TAYAL', '', '2011-01-03', '9810236048', 'ruchi.singhal@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(8, 3, 5, 'PRIYANKA OSTWAL', '1985-05-18', 'SH. MAHABIR SINGH', '', '2012-08-01', '', 'priyanka.ostwal@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(9, 3, 6, 'NITI SAXENA', '1982-01-10', 'MR. SC ARORA', '', '2011-09-28', '9871337503', 'niti.saxena@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(10, 4, 5, 'PALLAVI AHUJA', '0000-00-00', 'MK NAKRA', '', '2012-01-23', '9654403984', 'pallavi.ahuja@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(11, 3, 5, 'SHRADHA GOYAL', '1984-05-29', 'SH. JAI GOPAL BANSAL', '', '2012-01-05', '9711085456', 'shradha.goyal@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(12, 4, 5, 'MUGDHA SEHGAL', '1985-12-09', 'RAVI SEHGAL', '', '1985-01-05', '', 'mugdha.sehgal@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(13, 3, 5, 'TANVI GUPTA ', '1986-02-03', 'MR.KAILASH GUPTA', '', '0000-00-00', '9999987999', 'tanvi.gupta@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(14, 4, 5, 'PRABHJOT KAUR', '1987-02-02', 'MR. TIRLOCHAN SINGH', '', '2012-08-28', '', 'Prabhjot.kaur@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(15, 4, 5, 'MANJEET SINGH', '1976-06-25', 'NAN', '', '2013-03-02', '', 'manjeet.singh@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(16, 4, 5, 'DEEKSHA SUNEJA', '1991-02-17', 'MR. TEJENDER SUNEJA', '', '2014-07-14', '9971670546', 'deeksha.suneja@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(17, 4, 5, 'DIVYA GUPTA', '1986-06-12', '', '', '2018-07-27', '', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(18, 4, 5, 'RUPSHA BURMAN', '1985-09-27', 'MR. SUBHASHIS BURMAN', '', '2014-11-24', '', 'rupsha.burman@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(19, 4, 5, 'POOJA RANA', '0000-00-00', 'NAN', '', '0000-00-00', '', 'pooja.rana@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(20, 4, 5, 'ARUSHI', '1988-12-31', 'MR Y.P.SHARMA', '', '2015-07-20', '', 'arushi.gaur@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(21, 4, 5, 'SHWETA KHANDELWAL', '1982-02-02', 'MR.J.S.P PRASAD', '', '2010-08-01', '9958117132', 'shweta.khandelwal@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(22, 3, 5, 'JASLEEN RANA', '1990-02-17', 'SUKHDEEP SINGH RANA', '', '2015-08-20', '9899151017', 'jasleen.rana@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(23, 4, 5, 'PUNEET KAUR DHINGRA', '1991-11-08', 'PRIT PAL SINGH', '', '2016-02-18', '9999721010', 'puneet.dhingra@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(24, 4, 43, 'SUJEET KUMAR JHA', '1980-11-27', 'DINESH JHA', '', '2010-08-01', '9958171702', 'staffbba.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(25, 3, 43, 'MOHAMMAD ERFAN', '1981-01-15', 'S M NIYAZUDDIN', '', '2011-07-11', '9718618493', 'staffbba.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(26, 15, 44, 'POOJA GUPTA', '1984-02-08', 'DR. AJAY KUMAR GUPTA', '', '2013-12-07', '9811742698', 'pooja.gupta@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(27, 15, 43, 'SANJAY NAYAK', '1984-05-26', 'NAN', '', '2016-07-01', '9958670768', 'exambbabcom.kj@jagannath.org ', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(28, 6, 42, 'SATISH SETH', '0000-00-00', 'NAN', '', '0000-00-00', '9873474300', 'directorgeneral.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(29, 1, 11, 'J K BATRA', '1968-06-26', 'SH. C.D.BATRA', '', '2011-01-07', '981014', 'director.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(30, 1, 15, 'SEEMA AGGARWALL', '0000-00-00', 'NAN', '', '0000-00-00', '88888888', 'dyregistrar.kj@jagannath.orj', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(31, 1, 5, 'PREETI SINGH', '0000-00-00', 'NAN', '', '0000-00-00', '', 'hodbcom.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(32, 1, 23, 'NEELAM TANDON', '1968-02-11', 'D.S. SAREEN ', '', '2010-04-26', '9811670099', 'neelam.tandon@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(33, 1, 6, 'RUDRESH PANDEY', '0000-00-00', 'SHRI V.P.PANDEY', '', '0000-00-00', '8527788429', 'rudresh.pandey@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(34, 1, 6, 'Dr. SANJEELA MATHUR', '1968-11-16', 'MR K.C. SINHA', '', '2007-07-16', '9910073082', 'sanjeela.mathur@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(35, 2, 6, 'DR. MUKUL MISHRA', '1970-06-10', 'PROF.R.B.MISHRA', '', '2015-06-28', '9810481202', 'mukul.mishra@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(36, 1, 5, 'PALAK GUPTA', '1980-12-29', 'MR. MAHESH KUMAR VAI', '', '2010-01-04', '9650012542', 'palak.gupta@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(37, 1, 5, 'GURMEET SODHI', '0000-00-00', 'NAN', '', '0000-00-00', '9810783520', 'gurmeet.sodhi@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(38, 1, 5, 'DR. SANIYA CHAWLA', '1987-02-19', 'VINEET CHAWLA', '', '2015-07-14', '8476003628', 'saniya.chawla@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(39, 2, 5, 'DR. SAMRIDHI CHADHA', '1983-12-22', 'NAN', '', '0000-00-00', '9999925533', 'samridhi.tiwari@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(40, 1, 5, 'JYOTI KUKREJA', '1984-07-13', 'Amar Kukreja', '', '2014-07-01', '9911673783', 'jyoti.kukreja@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(41, 1, 23, 'TIMIRA SHUKLA', '1963-03-06', '', '', '2015-06-29', '9811853967', 'hod.pgdmib@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(42, 1, 5, 'V P ARORA', '0000-00-00', 'NAN', '', '0000-00-00', '9810238408', 'vparora06@yahoo.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(43, 1, 23, 'AKSHAT DUBEY', '0000-00-00', 'NAN', '', '0000-00-00', '9910188120', 'akshat.dubey@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(44, 1, 5, 'DR. ANJU SHUKLA', '1982-02-12', 'Sh. D P DWIVEDI', '', '2008-05-10', '8860634372', 'anju.shukla@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(45, 1, 5, 'BARKHA NARANG', '1981-01-17', 'DR. P.R NARANG', '', '2011-01-03', '9971253940', 'barkha.narang@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(46, 2, 5, 'GOPIKA KUMAR', '1980-04-01', 'NAN', '', '2014-07-01', '9810387841', 'gopika.kumar@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(47, 1, 5, 'A K SENGUPTA', '0000-00-00', 'NAN', '', '0000-00-00', '0', 'sengupta65@rediffmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(48, 1, 5, 'HARI PARMESHWAR', '0000-00-00', 'NAN', '', '0000-00-00', '9810210381', 'hari.parmeshwar@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(49, 1, 5, 'AMIT BAGGA', '0000-00-00', 'NAN', '', '0000-00-00', '9811264821', 'amitbaggaus@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(50, 1, 5, 'L. RAGHAVAN IYER', '0000-00-00', 'NAN', '', '0000-00-00', '9818619053', 'raghaviborn2003@yahoo.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(51, 1, 5, 'MANINDER SINGH', '0000-00-00', 'NAN', '', '0000-00-00', '9811352666', 'mvasir@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(52, 1, 5, 'M. P. SINGH', '0000-00-00', 'NAN', '', '0000-00-00', '9810310085', 'puneetmpsingh@yahoo.co.in', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(53, 1, 5, 'SANJAY MEHROTRA', '0000-00-00', 'NAN', '', '0000-00-00', '9810469587', 'sanjaymehrotra9@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(54, 1, 5, 'JYOTSNA RAJAN', '0000-00-00', 'NAN', '', '0000-00-00', '9810326266', 'jyotsnalsr@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(55, 1, 5, 'ANKUR WAHAL', '0000-00-00', 'NAN', '', '0000-00-00', '8527019339', 'post2ankur@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(56, 1, 5, 'ZAFAR', '0000-00-00', 'NAN', '', '0000-00-00', '9899171681', 'mashkurzafar@yahoo.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(57, 1, 5, 'MAYANK BANSAL', '0000-00-00', 'NAN', '', '0000-00-00', '9899223830', 'mayankbansal.du@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(58, 1, 5, 'BRINDA BALAKRISHNAN', '0000-00-00', 'NAN', '', '0000-00-00', '9868032194', 'brindabalakrishnan61@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(59, 1, 43, 'CHARAN SINGH BISHT', '1976-04-02', 'NAN', '', '0000-00-00', '9625398607', 'staffpgdm.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(60, 1, 43, 'RAJESH GOSWAMI', '1982-12-08', 'MR. SHIV GIRI GOSWAM', '', '2012-01-02', '9971012324', 'staffpgdm1.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(61, 2, 43, 'N K JOSHI', '1986-03-09', 'SHRI. N.D. JOSHI', '', '2013-05-27', '8527405827', 'staffpgdmib.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(62, 1, 5, 'SHUKLA CHAKROBORTY', '0000-00-00', 'NAN', '', '0000-00-00', '1717171717', 'examination.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(63, 5, 5, 'SUNIL KUMAR', '0000-00-00', 'NAN', '', '0000-00-00', '9811830883', 'examination.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(64, 4, 5, ' ANKITA MANAKTALA', '2016-07-11', 'NA', '', '2016-07-11', '9810403991', 'ankitamanktalacs@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(65, 3, 5, ' SHILPA LALWANI', '1991-09-07', 'SURESH LALWANI', '', '2016-07-18', '9999007224', 'Shilpalalwani7@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(66, 4, 5, 'HIMANSHI ARUN KUMAR', '1988-02-03', 'PARVENDRA SINGH SISO', '', '2016-07-18', '', 'sisodia.himanshi@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(67, 4, 5, 'JASLEEN KAUR', '1988-10-13', 'AVTAR SINGH', '', '2016-07-18', '', 'demo@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(68, 4, 43, 'JITESH KUMAR', '2016-08-04', 'SDR', '', '2016-08-04', '', 'demo@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(69, 3, 5, 'REETA NAGARI  ', '1970-06-19', 'MR T.K RAINA', '', '2016-08-10', '9971719845', 'demo@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(70, 4, 5, 'RUPALI VASHISHT', '2016-08-10', 'S', '', '2016-08-10', '', 'demo@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(71, 6, 1, 'MEENAKSHI ', '1984-01-16', 'ASHOK KUMAR', '', '2016-07-25', '9650714066', 'academic.coordinator@jagganath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(72, 6, 35, 'AMIT GUPTA', '2016-09-01', 'JAGANNATH GUPTA', '', '2016-09-01', '6280219165', 'amit.gupta@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(73, 4, 5, 'ADITI JOSHI', '2016-01-04', 'A', '', '2016-01-01', '9717933846', 'ajoshihr@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(74, 1, 5, 'G KRISHNAMURTY', '1959-05-24', 'K GOPALAKRISHNAN', '', '2016-09-26', '9818619267', 'DEMO@HSFSA', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(75, 5, 44, 'SUNIL KUMAR', '2016-10-13', 'SGHFS', '', '2016-10-13', '9911830883', 'examination.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(76, 1, 5, ' RACHNA KATHURIA', '2016-07-17', 'S', '', '2016-12-29', '9810145865', 'csrachna.kathuria@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(77, 1, 5, 'JOSE LAM', '2017-06-27', 'X', '', '2017-06-27', '9971237148', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(78, 1, 5, 'RAJ KARAN GUPTA', '2017-06-27', 'X', '', '2017-06-27', '9971307357', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(79, 1, 6, 'DR. KOMAL J KHATTAR ', '1977-01-04', 'SRI RAMESH CHANDER', '', '2017-06-27', '9811397100', 'Komal.khatter@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(80, 1, 6, 'SWAPANA SEN ', '2017-07-02', 'XYZ', '', '2017-07-02', '4596455248', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(81, 1, 5, 'RAHUL MAGAN', '2017-07-12', 'X', '', '2017-07-12', '9899242978', 'deMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(82, 3, 5, 'ANNU MISHRA', '1988-03-18', 'X', '', '2017-07-22', '7530910387', 'annu.mishra@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(83, 4, 5, 'ARUSHEE GROVER ', '1993-01-30', 'X', '', '2017-07-24', '9818158190', 'arushee.grover@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(84, 4, 5, 'ASHIMA SAXENA', '2017-07-22', 'X', '', '2017-07-22', '', 'ashima.saxena@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(85, 2, 5, ' DR. VANDANA', '1984-10-14', 'ABC', '', '2017-08-03', '9673790022', 'vandana.mehta@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(86, 1, 5, 'RASHNEEK KHER', '2017-01-01', 'ABC', '', '2017-01-01', '9810049979', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(87, 3, 43, ' UMESH CHAND', '1985-03-26', 'SHRI PREM KISHORE', '', '2017-08-17', '9650272778', 'staffbba.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(88, 14, 47, 'SMRITI DHAR', '1973-02-11', 'ABC', '', '2007-09-04', '9811683573', 'secretary.chairman@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(89, 1, 6, 'SAMIRAN JANA', '2017-09-29', 'ABC', '', '2017-09-29', '9818616293', 'janasamiran123@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(90, 1, 6, 'TAMANNA CHATURVIDE', '2017-11-01', 'ABC', '', '2017-11-03', '9818005789', 'demo@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(91, 4, 44, 'EXAMINATION UG', '2017-11-10', 'ABC', '', '2017-12-14', '1289182178', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(92, 8, 43, 'PRADEEP RAWAT', '2017-11-10', 'ABC', '', '2017-02-01', '9718401062', 'cmc.jims@jagannath.org ', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(93, 4, 6, 'UJALA KUMARI ', '2017-12-27', 'ABC', '', '2017-12-28', '', 'deMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(94, 4, 5, 'SONALISEN GUPTA', '2017-11-02', 'ABC', '', '2017-12-28', '', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(95, 4, 5, ' DIKSHITA KATHURIA', '1992-07-21', 'MR. SANJAY KATHURIA', '', '2018-02-07', '9899355578', 'dikshita.kathuria@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(96, 4, 5, 'ADJUSTMENT TEACHER ', '2018-02-09', 'ABC', '', '2018-02-10', '1920192810', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(97, 4, 6, ' HAKIMUDDIN KHAN', '2018-04-08', 'ABC', '', '2018-04-08', '0', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(98, 1, 43, 'MUGDHA JHA', '2018-05-17', 'ABC', '', '2018-05-18', '1289182212', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(99, 1, 43, 'ANUPA SEN ', '2018-05-17', 'ABC', '', '2018-05-18', '2910212919', 'DEMO@GMAIL.COM', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(100, 10, 27, ' MANVENDRA SINGH', '1991-01-15', 'SHRI RANVIR SINGH', '', '2013-09-23', '7053585549', 'singhm49@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(101, 1, 6, 'MALLIKA MATHEW', '2018-06-27', 'P.V.Kumar', '', '2018-06-28', '8879124117', 'mallikamathew@hotmail.com ', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(102, 1, 6, 'ANIL KANWA', '2018-06-27', 'ABC', '', '2018-06-28', '9416942696', 'anil.kanwa@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(103, 10, 27, 'DEEPAK KUMAR ROY', '1980-09-12', 'SHRI JAYHIND ROY', '', '2018-06-28', '9810702161', 'it.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(104, 1, 5, 'R. P. RUSTAGI', '2018-06-27', 'ABC', '', '2018-06-28', '9810717149', 'rpr16155@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(105, 10, 27, 'PRAVIN KUMAR RAY', '1973-07-07', 'SHRI SUGREEV RAY', '', '2010-01-04', '9717349728', 'it.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(106, 11, 48, 'PUSHPA KANDWAL', '1975-11-08', 'SH. INDER MANI SEMWA', '', '2011-09-02', '9953500775', 'secydirector.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(107, 7, 53, 'SHEETAL KUMRA', '1979-09-29', 'SH. SHIV KR SHARMA', '', '2010-01-12', '9899809745', 'admission.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(108, 7, 53, 'RASHMI BISHT', '1977-08-30', 'SHRI C S PAWAR', '', '2012-12-06', '9871117158', 'info.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(109, 7, 54, 'MUKUL KUMAR', '1985-08-17', 'MR MAHENDER SINGH', '', '2015-01-11', '9999078888', 'marketing.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(110, 7, 53, 'MEGHA KAUSHIK', '2018-06-28', '', '', '1989-02-20', '7838550448', 'info@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(111, 9, 55, 'MAYANK', '1985-08-06', 'SH. SUBHASH MATHUR', '', '2018-06-28', '8800114544', 'accounts.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(112, 9, 45, 'SHIVJI RAI', '1976-06-22', 'SHRI K S RAI', '', '2002-01-04', '9899443501', 'accounts.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(113, 6, 46, 'AMIT KAMRA', '1976-05-09', 'SHRI D.R. KAMRA', '', '2011-01-10', '9350478562', 'manager.admin@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(114, 8, 49, 'ANUPA SEN', '1970-02-07', 'SHRI B.K. CHOPRA', '', '2010-12-06', '9811881852', 'anupa.sen@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(115, 8, 50, 'MUGDHA JHA', '1983-05-10', 'SHRI RAJIV SHANKAR', '', '2015-09-29', '9958435599', 'placements.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(116, 9, 55, 'ANJALI', '1993-11-23', 'MR. MURLI SHARMA', '', '2017-12-08', '7838790298', 'accounts.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(117, 12, 19, 'SHALINI NEGI', '1980-06-17', 'SHRI HEERA LAL', '', '2014-06-26', '9911758283', 'library.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(118, 5, 44, 'DIGPAL SINGH', '1982-04-10', 'SHRI GOVIND SINGH BI', '', '2017-08-28', '9810739796', 'examination.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(119, 7, 3, 'MANISHA SINGH', '1984-12-24', 'SHRI B.P. SINGH', '', '2015-01-04', '9811004833', 'admission.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(120, 13, 57, 'AMITA SHARMA', '1990-04-01', 'SHRI ANUP KUMAR SHAR', '', '2013-10-22', '7838241553', 'reception.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(121, 13, 57, 'REENA ROY', '1974-08-01', 'SHRI NIRANJAN SINHA ', '', '2011-09-05', '9999968560', 'royreena0108@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(122, 6, 56, 'VIKRAM SINGH RAWAT', '1982-12-03', 'LATE SH. TRILOK SING', '', '2011-06-29', '9990104970', 'admin.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(133, 7, 53, 'AAKRITI ARORA', '1988-11-18', 'SHRI ANIL CHOPRA', '', '2019-01-07', '9999602818', 'aakritivaibhavarora@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(136, 7, 53, 'LEENA ARORA', '1988-11-21', '', '', '2019-01-28', '8585931943', 'marketing.kj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(131, 1, 23, 'DR. SATYENDRA KUMAR BREJA', '1958-10-24', 'LATE SH. K.K. BREJA', '', '2019-01-07', '9818604898', 'skbreja2006@yahoo.co.in', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(130, 2, 43, 'SHANKAR', '1995-02-08', 'MR. INDER THAPA', '', '2018-11-12', '9560912458', 'demoTha@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(139, 1, 5, 'MS. ATISHA JUNEJA', '2019-07-12', '', '', '2019-07-12', '7045660820', 'atishajuneja@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(123, 1, 5, 'ASHOK ADVANI', '2018-07-07', '', '', '2018-07-07', '9810333002', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(124, 3, 5, 'DR. AMRUTA JAJOO', '1986-06-12', 'SANJAY DAMANI', '', '2018-07-27', '7600029188', 'amruta.jajoo@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(125, 3, 5, 'GURMANI CHADHA', '1993-09-20', '', '', '2018-07-23', '9811770053', 'gurmanichadha@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(126, 12, 4, 'SNEHA GUPTA', '1992-09-04', 'SHRI ARUN KUMAR GUPT', '', '2018-03-07', '9899924908', 'snehagupta.ice91@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(127, 9, 55, 'NISHA CHUGH', '1985-06-21', 'SHRI ASHOK VINAYAK', '', '2020-11-09', '9654942440', 'nvenaik@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(128, 15, 51, 'rajender rana', '1986-12-08', '', '', '2019-07-29', '9540515388', 'rajender.rsr1977@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(129, 1, 5, 'MR. KAUSIK SEN', '2018-09-28', '', '', '2018-09-28', '6545892565', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(132, 1, 43, 'NARESH KUMAR', '1982-08-27', 'SHRI MAAN SINGH', '', '2018-12-17', '9899236494', 'nareshkumar271982@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(134, 12, 43, 'RDSFDSGSAFSAF', '2019-01-10', '', '', '2019-01-10', '1878050616', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(135, 1, 5, 'ASHISH YADAV', '1987-02-11', '', '', '2019-01-12', '9968262900', 'ashish.yadav87@yahoo.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(137, 7, 53, 'RASHMI DATTA', '1987-02-01', 'SHRI B.G. DATTA', '', '2019-02-26', '9354054948', 'rashmi.datta87@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(138, 7, 54, 'K. GIRI', '1968-07-18', 'SH. R. KRISHNASWAMI', '', '2019-01-15', '9650097752', 'marketing.manager@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(140, 3, 5, 'Dr. NITYA KHURANA', '1986-08-21', 'D K CHAWLA', '', '2019-07-15', '9871336740', 'nityakhurana86@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(141, 9, 55, 'MEGHA ', '2019-07-13', '', '', '2019-06-03', '1140619200', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(142, 4, 5, 'DR. AKASHA SANDHU', '1988-11-28', '', '', '2019-07-22', '9878726788', 'sandhu_ashu28@yahoo.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(146, 9, 55, 'DIVYE RUSTUGI', '1989-07-23', '-', '', '2019-07-29', '8920916382', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(148, 4, 23, 'PROF. (DR) DAVINDER K. VAID', '1952-04-13', 'SHRI  MANOHAR  LAL', '', '2019-10-14', '9811341199', 'dkvaid@gmail.com ', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(143, 4, 5, 'SAHIBA SAHNY', '1990-06-04', '', '', '2019-07-26', '8826690777', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(144, 3, 43, 'RAJENDER SINGH RANA', '1977-06-15', 'LATE SHRI SHYAM SING', '', '2019-07-29', '9540515388', 'rajender.rsr1977@gmail,com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(145, 15, 51, 'PAYAL BANERJEE', '1989-02-09', 'PARTHA BANERJEE', '', '2019-07-29', '9971775859', 'payalcrp@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(147, 4, 56, 'AKASH RAO', '2019-09-12', '', '', '2019-09-12', '9912895600', 'ownitit2@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(149, 1, 5, 'NEHA ISSAR', '1988-05-07', 'Mr. Mahinder Sharma', '', '2019-10-12', '9650095155', 'nehaissar88@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(150, 1, 5, 'Tirth Kumar', '2019-10-12', '', '', '2019-10-12', '9999984171', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(151, 1, 5, 'ASHISH DUA', '2019-11-15', '', '', '2019-11-15', '9899573717', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(152, 3, 5, 'SUNITA TOMAR', '1982-11-27', 'ISHWAR SINGH', '', '2020-01-20', '9810717605', 'mscsunita@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(153, 3, 5, 'BHAWNA THAKRAN', '1995-05-17', 'VINOD KUMAR', '', '2020-02-03', '9643906124', 'bhawnathakran17@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(154, 1, 43, 'MANISH KUMAR', '1991-05-13', 'MR. GAURI SHANKAR', '', '2020-02-24', '7838701087', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(155, 7, 53, 'ANINDITA CHOUDHURY', '1990-12-30', 'ARUNODAY CHOUDHURY', '', '2020-02-17', '9902769657', 'anie.ch30@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(156, 2, 11, 'ASHOK SHARMA', '1973-05-20', 'S P SHARMA', '', '2020-05-15', '9810168546', 'ashok.sharmakj@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(157, 2, 23, 'CHANDER SHEKHAR SHARMA', '2020-07-20', 'SHREE', '', '2020-07-20', '9311333303', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(158, 3, 5, 'AASTHA BEHL', '1992-10-16', 'SURESH BEHL', '', '2020-08-10', '8808063336', 'aasthabehl1610@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(159, 3, 5, 'RAJVINDER SINGH JOHAL', '1990-10-08', 'Santokh Singh Johal', '', '2020-08-17', '9718241462', 'rajvinderjohal@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(160, 1, 5, 'TANUJA PURI', '2020-11-02', 'HARISH PURI', '', '2020-11-02', '8375883332', 'tanuja.puri@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(161, 1, 6, 'DR. SANDEEPA KAUR', '1982-12-09', 'Kulwant Singh', '', '2020-11-02', '9899884196', 'sandeepa.kaur@jagannath.org', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(162, 1, 5, 'SHILPI YADAV', '2020-11-02', '', '', '2020-11-02', '9711020576', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(163, 1, 6, 'MADAN LAL', '2020-11-05', '', '', '2020-11-05', '9911721500', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(164, 1, 23, 'VIJAYA KATTI', '2020-11-05', '', '', '2020-11-05', '9818090538', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(165, 12, 19, 'NEELAM VISHWAKARMA', '1984-07-03', 'RAM DAVAR VISHWAKARM', '', '2020-11-02', '9555418366', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(166, 3, 5, 'MS. DEEKSHA', '1993-07-19', '', '', '2020-12-01', '8588933207', '19.deeksha@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(168, 7, 53, 'CHANPREET KAUR', '1995-06-11', 'JAGJIT SINGH ', '', '2020-12-14', '9717418828', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(167, 1, 43, 'DEVAKINANDAN BHARDWAJ', '2020-12-09', 'Shri Chandramani Bha', '', '2020-12-02', '8130255864', 'dev.bhardwaj0021@gmail.com', NULL, '', '', '', '', '', 1, '0000-00-00', 0),
(169, 7, 53, 'RESHO', '1986-08-03', 'RAM KISHORE BARERIA', '', '2021-01-04', '7683010933', '', NULL, '', '', '', '', '', 1, '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
