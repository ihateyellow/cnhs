-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2016 at 06:28 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `db_cnhs`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chatid` int(11) NOT NULL,
  `messageid` varchar(50) NOT NULL,
  `message` longtext NOT NULL,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `datechat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chatid`, `messageid`, `message`, `sender`, `receiver`, `datechat`) VALUES
(1, '23', 'hello po..', 'mark', 'jun', '2016-07-17 01:06:40'),
(2, '23', 'Ok lng po', 'jun', 'mark', '2016-07-17 01:10:20'),
(3, '23', 'kamusta ka jan', 'mark', 'jun', '2016-07-17 01:18:24'),
(4, '23', 'ano balita', 'mark', 'jun', '2016-07-17 01:20:25'),
(5, '23', 'hello', 'mark', 'jun', '2016-07-17 01:41:26'),
(6, '23', 'hi', 'jun', 'mark', '2016-07-17 01:43:18'),
(7, '23', 'hi', 'mark', 'jun', '2016-07-17 01:43:24'),
(8, '23', 'a', 'jun', 'mark', '2016-07-17 01:44:28'),
(9, '23', 'qweqweqwe', 'jun', 'mark', '2016-07-17 01:44:39'),
(10, '23', 'q', 'jun', 'mark', '2016-07-17 01:44:47'),
(11, '23', 'hello', 'mark', 'jun', '2016-07-17 01:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userrole` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `age` varchar(10) NOT NULL,
  `yearlevel` varchar(20) DEFAULT NULL,
  `section` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contactno` text NOT NULL,
  `schoolyear` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `datecreation` datetime NOT NULL,
  `datemodified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `userrole`, `name`, `gender`, `age`, `yearlevel`, `section`, `address`, `contactno`, `schoolyear`, `status`, `datecreation`, `datemodified`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Mica Ayala', 'Male', '19', 'Third Year', 'Yellow', 'Bacoor, Cavite', '09261191542', '2016-2017', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(2, 'teacher', '21232f297a57a5a743894a0e4a801fc3', 'teacher', 'Teacher Sample', 'Male', '22', 'faculty', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(3, 'student', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Student Sample', 'Male', '22', 'first year', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(4, 'student2', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Mica', 'Male', '22', 'first year', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(5, 'student3', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Juana', 'Female', '22', 'second year', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(6, 'student4', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Princess Mae', 'Female', '22', 'third year', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(7, 'student7', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Mhelbermay', 'Female', '22', 'fourth year', 'Yellow', 'Bacoor, Cavite', '09123456789', '2015-2016', 'active', '2016-07-16 00:00:00', '2016-07-16 00:00:00'),
(8, 'kanashii', '80f4d57ac2b0d2bc1a4d54225ad95223', 'student', 'junerick  duzon', 'Male', '19', '', 'yellow', '', '09261101542', '2016-2017', 'active', '0000-00-00 00:00:00', '2016-07-17 00:51:21'),
(9, 'anonymous', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Princes Sarah', 'Male', '22', 'First Year', 'red', 'any', '123123', '2016-2017', 'active', '0000-00-00 00:00:00', '2016-07-17 00:54:11'),
(10, 'anonymous2', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Sherilyn', 'Male', '22', 'First Year', 'red', 'any', '123123', '2016-2017', 'active', '2016-07-17 00:54:44', '2016-07-17 00:54:44'),
(11, 'anon', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Angie Mae', 'Female', '22', 'First Year', 'red', 'any', '123123', '2016-2017', 'active', '2016-07-17 00:55:54', '2016-07-17 00:55:54'),
(12, 'anonx', '21232f297a57a5a743894a0e4a801fc3', 'student', 'Princes Sarah', 'Male', '22', 'First Year', 'red', 'any', '123123', '2016-2017', 'active', '2016-07-17 01:00:30', '2016-07-17 01:00:30'),
(13, 'anona', '21232f297a57a5a743894a0e4a801fc3', 'student', 'qwe', 'Male', '12', 'First Year', '123', 'qwe', '1we', '2016-2017', 'active', '2016-07-17 01:03:58', '2016-07-17 01:03:58'),
(14, 'qweqwe', 'efe6398127928f1b2e9ef3207fb82663', 'student', 'qweqeqe', 'Male', 'qwe', 'First Year', 'qweqwe', 'qweq', 'qwe', '2016-2017', 'active', '2016-07-17 01:05:33', '2016-07-17 01:05:33'),
(15, 'mark', 'c95f555d9524592d9c0a4942c25c9bb9', 'student', 'mark', 'Male', '19', 'First Year', 'Yellow', 'TMC, Cavite', '0912345678', '2016-2017', 'active', '2016-07-17 01:54:07', '2016-07-17 01:54:07'),
(16, 'kirshner', 'c95f555d9524592d9c0a4942c25c9bb9', 'student', 'kirshner', 'Male', '20', 'First Year', 'Yellow', 'Makati City', '0987654321', '2016-2017', 'active', '2016-07-17 01:55:07', '2016-07-17 01:55:07'),
(17, 'yellow', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'myoshirlo', 'Male', '18', 'Third Year', 'rwd', 'Ba lanb', 'tuii', '2016-2017', 'active', '2016-07-17 04:09:03', '2016-07-17 04:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_active`
--

CREATE TABLE `user_active` (
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `username` (`username`),
  ADD KEY `userrole` (`userrole`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `user_active`
--
ALTER TABLE `user_active`
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;