-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2017 at 05:03 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tapdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignmentid` bigint(12) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `courseid` int(12) NOT NULL,
  `duedate` datetime NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignmentid`, `title`, `description`, `courseid`, `duedate`, `createdt`, `userid`) VALUES
(1, 'L.4 Test Due on Wednesday', 'Please find this assignment in your Supersite Calendar.', 3, '2016-06-29 23:59:00', '2016-06-27 18:44:00', 2),
(4, 'wqeerd', 'asdasd', 2, '2017-06-29 23:59:00', '2017-11-25 08:06:42', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chatid` int(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `sender` int(12) NOT NULL,
  `receiver` int(12) NOT NULL,
  `threadid` int(12) NOT NULL,
  `type` int(1) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='type, 1= text, 2 = video';

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentid` int(12) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `postid` int(12) NOT NULL,
  `userid` int(12) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentid`, `comment`, `postid`, `userid`, `createdt`, `status`) VALUES
(1, 'Thank you', 1, 1, '2016-06-21 11:06:17', 1),
(2, 'Hola, Pankaj! De nada. ðŸ˜Š', 1, 2, '2016-06-21 11:12:39', 1),
(3, 'Hola Zulay', 2, 2, '2016-06-21 11:34:51', 1),
(4, ':)', 2, 2, '2016-06-21 11:38:17', 1),
(5, 'Hola, Profesora Lane!', 1, 10, '2016-06-22 04:43:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int(12) NOT NULL,
  `threadid` int(12) NOT NULL,
  `msg` varchar(2000) NOT NULL,
  `sender` int(12) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `threadid`, `msg`, `sender`, `createdt`) VALUES
(1, 1, 'Hi Ashley', 1, '2016-06-21 11:27:57'),
(2, 1, 'Test', 1, '2016-06-21 11:31:36'),
(3, 1, 'Test', 2, '2016-06-21 11:36:31'),
(4, 1, 'Testing', 2, '2016-06-21 11:38:34'),
(5, 1, 'Yay!!!', 2, '2016-06-21 11:38:45'),
(6, 1, 'test', 1, '2016-06-25 07:24:48'),
(7, 1, 'Testing', 2, '2016-06-27 16:10:00'),
(8, 2, 'Hi, Zulay! Are you receiving notifications?', 2, '2016-06-27 16:11:04'),
(9, 1, 'Are you receiving notifications?', 2, '2016-06-27 16:11:28'),
(10, 1, 'Test', 2, '2016-06-27 16:48:15'),
(11, 1, 'Test again', 2, '2016-06-27 16:51:44'),
(12, 1, 'Test again 123', 2, '2016-06-27 16:52:46'),
(13, 1, 'hi Ashley', 1, '2016-06-27 16:53:18'),
(14, 1, 'Testing 1', 2, '2016-06-27 16:57:20'),
(15, 1, 'hi Ashley', 1, '2016-06-27 16:58:15'),
(16, 1, 'hi', 1, '2016-06-27 16:58:34'),
(17, 1, 'hello', 1, '2016-06-27 16:58:47'),
(18, 1, 'testing again', 1, '2016-06-27 17:02:03'),
(19, 1, 'Hi, Pankaj!', 2, '2016-06-27 17:04:45'),
(20, 1, '', 2, '2016-06-27 17:04:47'),
(21, 1, 'Hello', 2, '2016-06-27 17:05:31'),
(22, 1, '', 1, '2016-06-27 17:11:53'),
(23, 1, 'notification for ashley', 1, '2016-06-27 17:17:14'),
(24, 1, 'Hi, Pankaj!', 2, '2016-07-06 13:51:55'),
(25, 1, 'I see the comment section is still visible in the Profile.', 2, '2016-07-06 13:53:16'),
(26, 1, 'Hola Ashley', 1, '2016-07-11 07:16:14'),
(27, 1, 'Hi, Pankaj', 2, '2016-07-11 16:23:23'),
(28, 1, 'Hola', 2, '2016-07-11 17:22:35'),
(29, 1, 'Hola Ashley', 1, '2016-07-11 17:24:31'),
(30, 1, 'Got it!', 2, '2016-07-11 17:24:58'),
(31, 1, 'I got your notification.', 2, '2016-07-11 17:25:51'),
(32, 1, 'Are you receiving my notifications', 2, '2016-07-11 17:26:25'),
(33, 1, 'Yes', 1, '2016-07-11 17:26:58'),
(34, 1, 'YAY!', 2, '2016-07-11 17:27:36'),
(35, 1, ' Dear Pankaj,', 2, '2016-08-19 12:27:22'),
(36, 1, 'Thank you for updating TAP IOS', 2, '2016-08-19 12:27:57'),
(37, 1, 'Hello\n', 2, '2016-09-08 18:22:47'),
(38, 1, 'Hi AL', 1, '2016-09-08 18:23:12'),
(39, 3, 'Hi', 2, '2017-11-26 05:11:38'),
(40, 3, 'Hi', 2, '2017-11-26 05:17:27'),
(41, 3, 'Hi', 2, '2017-11-26 05:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postid` bigint(12) NOT NULL,
  `post` varchar(2000) NOT NULL,
  `type` int(1) NOT NULL,
  `userid` int(12) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `createdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `post`, `type`, `userid`, `status`, `createdt`) VALUES
(1, 'Welcome! ðŸ˜ƒ', 1, 2, 1, '2016-06-19 22:02:05'),
(2, 'Thanks for the invite!  ', 1, 6, 1, '2016-06-20 18:10:00'),
(3, 'Hola! I will post an updated list of assignment deadlines to the calendar this week, so please be on the lookout. Gracias!', 1, 2, 1, '2016-06-27 18:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `schoolid` int(12) NOT NULL,
  `school_name` varchar(400) NOT NULL,
  `school_code` varchar(50) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`schoolid`, `school_name`, `school_code`, `createdt`) VALUES
(1, 'Harvard University', 'HAVU', '2015-11-04 18:54:13'),
(2, 'University of California, Berkeley', 'CABU', '2015-11-04 18:54:13'),
(3, 'Columbia University', 'COLU', '2015-11-04 18:55:32'),
(4, 'Stanford University', 'STAU', '2015-11-04 18:55:32'),
(5, 'Yale University', 'YALU', '2015-11-04 19:13:23'),
(6, 'Princeton University', 'PRIU', '2015-11-04 19:13:23'),
(7, 'University of Texas at Austin', 'AUSU', '2015-11-04 19:14:26'),
(8, 'University of Florida', 'FLOU', '2015-11-04 19:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `scid` int(12) NOT NULL,
  `userid` int(12) NOT NULL,
  `ucid` int(12) NOT NULL,
  `createdttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`scid`, `userid`, `ucid`, `createdttm`) VALUES
(1, 4, 2, '2016-06-20 03:54:53'),
(2, 6, 1, '2016-06-20 18:09:34'),
(5, 9, 2, '2016-06-20 22:44:42'),
(6, 1, 1, '2016-06-21 10:12:29'),
(10, 1, 2, '2016-06-21 11:00:24'),
(12, 22, 1, '2016-06-28 12:58:00'),
(13, 22, 2, '2016-06-28 12:58:00'),
(16, 1, 4, '2016-09-08 18:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `threadid` int(12) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `sender` int(12) NOT NULL,
  `receiver` int(12) NOT NULL,
  `updatedttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`threadid`, `message`, `sender`, `receiver`, `updatedttm`) VALUES
(1, 'Hi AL', 1, 2, '2016-09-08 18:23:12'),
(2, 'Hi, Zulay! Are you receiving notifications?', 2, 6, '2016-06-27 16:11:04'),
(3, 'Hi', 2, 2, '2017-11-26 05:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `deviceid` varchar(200) NOT NULL,
  `os` varchar(50) NOT NULL,
  `siteid` varchar(50) NOT NULL,
  `userid` int(12) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  `tkid` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT 'dev',
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(300) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL,
  `imageStatus` int(1) NOT NULL DEFAULT '0',
  `image` varchar(500) DEFAULT NULL,
  `userType` int(2) NOT NULL DEFAULT '1',
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `lastlogindttm` timestamp NULL DEFAULT NULL,
  `pushkey` varchar(200) NOT NULL,
  `os` varchar(50) NOT NULL,
  `device` varchar(50) NOT NULL,
  `permissionAccepted` int(1) NOT NULL DEFAULT '1',
  `forgotPassword` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `title`, `firstname`, `lastname`, `email`, `password`, `imageStatus`, `image`, `userType`, `status`, `created_at`, `updated_at`, `lastlogindttm`, `pushkey`, `os`, `device`, `permissionAccepted`, `forgotPassword`) VALUES
(1, '', 'Pankaj', 'Sachdeva', 'dearestpankaj@gmail.com', 'pankajs', 1, '', 1, 1, '2016-06-19 22:31:54', NULL, '2016-09-13 22:29:35', '', '9', 'ios', 1, 'Dx2cTeJr'),
(2, 'Professor', 'Ashley', 'Lane', 'lane.ash.liz@gmail.com', '1988Turquena', 1, '', 2, 1, '2016-06-20 03:28:56', NULL, '2016-12-16 16:46:38', '', '9', 'ios', 1, ''),
(3, '', 'Kinnon', 'Wildes', 'wwildes@wildcat.fvsu.edu', 'UgaDawgs15', 0, '', 1, 1, '2016-06-20 04:28:12', NULL, '2016-06-21 21:57:15', '7C001C0B3072E9EB70DA564E0C3B522732F7D3E7017E7B14804B0F87FDE5A105', '9', 'ios', 1, ''),
(4, '', 'Alexis', 'Crawford', 'acrawf16@wildcat.fvsu.edu', 'cosondra', 0, '', 1, 1, '2016-06-20 09:24:26', NULL, '2016-06-22 04:05:39', 'E1638DEDFB732664AB9E57D75FDA91322A7A273FC0644AC2945F0643B80BD764', '9', 'ios', 1, ''),
(5, '', 'kentavious', 'king', 'kking21@wildcat.fvsu.edu', 'Canegang1', 0, '', 1, 1, '2016-06-20 20:51:10', NULL, NULL, 'E688D05AE401789A715A061248D621CDF50FF300C65E5C4361DFF4BC6F4596ED', '9', 'ios', 1, ''),
(6, '', 'Zulay', 'Kerr-Pantoja', 'zulay1003@yahoo.com', 'Princess10', 0, '', 1, 1, '2016-06-20 23:39:27', NULL, '2016-06-28 23:25:12', '96C5F86A3DA9CF2003734252CF68873835D382CA90BE7B6376FB89A53A7993A6', '9', 'ios', 1, ''),
(7, '', 'kentavious', 'king', 'kentaviousking@gmail.com', 'Canegang1', 0, '', 1, 1, '2016-06-21 00:03:49', NULL, '2016-06-27 11:54:58', '415563351CE3AB32189EF16D46E99F82CF7420A9EC8C753BEF452C576C23AF84', '9', 'ios', 1, ''),
(8, '', 'Antoinette', 'Hart', 'jjjczthart6@gmail.com', 'hart2hart', 0, '', 1, 1, '2016-06-21 04:00:26', NULL, '2016-06-29 11:06:38', '5D8F4E6DA573B426EF6C59673080E6F79541EF3BA165F4504BA3B59ACAE6C7A5', '9', 'ios', 1, ''),
(9, '', 'Antoinette', 'Hart', 'ahart4@wildcat.fvsu.edu', 'hsrt2hart', 0, '', 1, 1, '2016-06-21 04:13:58', NULL, NULL, '5D8F4E6DA573B426EF6C59673080E6F79541EF3BA165F4504BA3B59ACAE6C7A5', '9', 'ios', 1, ''),
(10, '', 'Latasha', 'Porter', 'lporte10@wildcat.fvsu.edu', 'jppunker1', 0, '', 1, 1, '2016-06-22 10:08:29', NULL, NULL, '414C312B72CB5084CDB19D90CEB8A6DFADE367E98E7919A070AD89B2BC088330', '9', 'ios', 1, ''),
(31, '', 'Ashley ', 'Bot', 'ashleylaturca@gmail.com', '123Bot', 0, '', 1, 1, '2017-02-01 22:14:08', NULL, NULL, 'E84A907B074FEF3BCC00B07AD961691E1A44609AC9E085473B48768A3FA665B3', '9', 'ios', 1, ''),
(22, '', 'pankaj', 'sachdeva', 'pankaj.sachdeva@niit-tech.com', 'pankajs', 0, '', 1, 1, '2016-06-28 18:27:51', NULL, NULL, 'testkey', '21', 'android', 1, ''),
(23, '', 'Nicholas', 'Pope', 'popenicholaa21@yahoo.com', 'Nicholasp93', 0, '', 1, 1, '2016-06-29 01:26:04', NULL, NULL, '496BAAA7D0231B4B5883735211DBD30A7CEFE9E5DBEB789DC9049B3B6DC2DE7F', '9', 'ios', 1, ''),
(33, '', 'H.', 'Kaan', 'acarhuseyin@msn.com', '4623722', 0, '', 1, 1, '2017-06-05 23:44:44', NULL, NULL, 'FF9B491215BBD9E6C7B63ADA1DF3024894D094C331FF14B87D3D1733BB52B216', '10', 'ios', 1, ''),
(32, '', 'Ashley', 'Lane', 'theacademicpointonline@gmail.com', 'Testing123', 0, '', 1, 1, '2017-03-07 09:03:05', NULL, NULL, 'E84A907B074FEF3BCC00B07AD961691E1A44609AC9E085473B48768A3FA665B3', '9', 'ios', 1, ''),
(37, 'dev', 'amey', 'jagtap', 'amey@gmail.com', '$2y$10$YON5UwXfjXdkKRb4JYxqPeGKKNL4Z1UK6cZVhYwmwF9XOAdxj78qe', 0, NULL, 1, 1, '2017-11-27 15:02:21', '2017-11-27 15:02:21', NULL, 'asdet', 'iOS', 'moto', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_course`
--

CREATE TABLE `user_course` (
  `ucid` int(12) NOT NULL,
  `course` varchar(100) NOT NULL,
  `userid` int(12) NOT NULL,
  `schoolid` int(12) NOT NULL DEFAULT '0',
  `expirydate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_course`
--

INSERT INTO `user_course` (`ucid`, `course`, `userid`, `schoolid`, `expirydate`) VALUES
(1, 'SPA 101', 2, 0, '2016-08-19'),
(2, 'SPA 102', 2, 0, '2016-08-19'),
(3, 'SPAN 1001', 2, 0, '2016-09-07'),
(4, 'SPAN 1002', 2, 0, '2016-09-27'),
(8, '1', 2, 0, '2017-06-20'),
(9, '2', 2, 0, '2017-06-20'),
(10, '3', 2, 0, '2017-06-20'),
(11, '4', 2, 0, '2017-06-20'),
(12, 'CA', 2, 0, '2017-06-20'),
(13, 'PA', 2, 0, '2017-06-20'),
(14, 'SA', 2, 0, '2017-06-20'),
(15, 'DA', 2, 0, '2017-06-20'),
(16, 'CA', 2, 0, '2017-06-20'),
(17, 'PA', 2, 0, '2017-06-20'),
(18, 'SA', 2, 0, '2017-06-20'),
(19, 'DA', 2, 0, '2017-06-20'),
(20, 'CA', 2, 0, '2017-06-20'),
(21, 'PA', 2, 0, '2017-06-20'),
(22, 'SA', 2, 0, '2017-06-20'),
(23, 'DA', 2, 0, '2017-06-20'),
(24, 'CA', 2, 0, '2017-06-20'),
(25, 'PA', 2, 0, '2017-06-20'),
(26, 'SA', 2, 0, '2017-06-20'),
(27, 'DA', 2, 0, '2017-06-20'),
(28, 'CA', 2, 0, '2017-06-20'),
(29, 'PA', 2, 0, '2017-06-20'),
(30, 'SA', 2, 0, '2017-06-20'),
(31, 'DA', 2, 0, '2017-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `user_school`
--

CREATE TABLE `user_school` (
  `usid` int(12) NOT NULL,
  `userid` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `course` varchar(200) NOT NULL,
  `passcode` int(11) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignmentid`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`schoolid`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`scid`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`threadid`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`tkid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `user_course`
--
ALTER TABLE `user_course`
  ADD PRIMARY KEY (`ucid`);

--
-- Indexes for table `user_school`
--
ALTER TABLE `user_school`
  ADD PRIMARY KEY (`usid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignmentid` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chatid` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `schoolid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `student_course`
--
ALTER TABLE `student_course`
  MODIFY `scid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `threadid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `tkid` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `user_course`
--
ALTER TABLE `user_course`
  MODIFY `ucid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `user_school`
--
ALTER TABLE `user_school`
  MODIFY `usid` int(12) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
