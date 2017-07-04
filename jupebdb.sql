-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2017 at 04:00 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jupebdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `gradestb`
--

CREATE TABLE `gradestb` (
  `gradesid` int(11) NOT NULL,
  `stdid` int(3) NOT NULL,
  `progid` int(3) NOT NULL,
  `subid` int(3) NOT NULL,
  `sem_id` int(3) NOT NULL,
  `attendance` double NOT NULL,
  `quiz` double NOT NULL,
  `assignment` double NOT NULL,
  `mid_semester` double NOT NULL,
  `exam` double NOT NULL,
  `total` double NOT NULL,
  `percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `programtb`
--

CREATE TABLE `programtb` (
  `pid` int(11) NOT NULL,
  `program_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semestertb`
--

CREATE TABLE `semestertb` (
  `semid` int(11) NOT NULL,
  `semester_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessiontb`
--

CREATE TABLE `sessiontb` (
  `sid` int(11) NOT NULL,
  `session_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studenttb`
--

CREATE TABLE `studenttb` (
  `stdid` int(11) NOT NULL,
  `matric_no` varchar(25) NOT NULL,
  `student_name` varchar(200) NOT NULL,
  `session_id` int(3) NOT NULL,
  `program_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjecttb`
--

CREATE TABLE `subjecttb` (
  `subid` int(11) NOT NULL,
  `subject_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject_combtb`
--

CREATE TABLE `subject_combtb` (
  `sub_combid` int(11) NOT NULL,
  `pid` int(3) NOT NULL,
  `sid` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradestb`
--
ALTER TABLE `gradestb`
  ADD PRIMARY KEY (`gradesid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `programtb`
--
ALTER TABLE `programtb`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `semestertb`
--
ALTER TABLE `semestertb`
  ADD PRIMARY KEY (`semid`);

--
-- Indexes for table `sessiontb`
--
ALTER TABLE `sessiontb`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `studenttb`
--
ALTER TABLE `studenttb`
  ADD PRIMARY KEY (`stdid`);

--
-- Indexes for table `subjecttb`
--
ALTER TABLE `subjecttb`
  ADD PRIMARY KEY (`subid`);

--
-- Indexes for table `subject_combtb`
--
ALTER TABLE `subject_combtb`
  ADD PRIMARY KEY (`sub_combid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gradestb`
--
ALTER TABLE `gradestb`
  MODIFY `gradesid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `programtb`
--
ALTER TABLE `programtb`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `semestertb`
--
ALTER TABLE `semestertb`
  MODIFY `semid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sessiontb`
--
ALTER TABLE `sessiontb`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `studenttb`
--
ALTER TABLE `studenttb`
  MODIFY `stdid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `subjecttb`
--
ALTER TABLE `subjecttb`
  MODIFY `subid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `subject_combtb`
--
ALTER TABLE `subject_combtb`
  MODIFY `sub_combid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
