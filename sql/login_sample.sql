-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2021 at 05:10 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `casedetails`
--

CREATE TABLE `casedetails` (
  `case_id` int(11) NOT NULL,
  `client_fk` int(11) NOT NULL,
  `case_name` varchar(500) NOT NULL,
  `case_number` varchar(500) NOT NULL,
  `case_sectionNumber` varchar(500) NOT NULL,
  `case_court` varchar(500) NOT NULL,
  `case_decision` varchar(500) NOT NULL,
  `case_type` varchar(500) NOT NULL,
  `case_isDelete` tinyint(1) NOT NULL DEFAULT 0,
  `case_date` date NOT NULL,
  `case_dateupdateted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `casedetails`
--

INSERT INTO `casedetails` (`case_id`, `client_fk`, `case_name`, `case_number`, `case_sectionNumber`, `case_court`, `case_decision`, `case_type`, `case_isDelete`, `case_date`, `case_dateupdateted`) VALUES
(1, 3, 'bhhjb', '678678', '67678', '7678', '76876', 'DEED', 1, '2021-03-26', '2021-03-02 16:06:34'),
(2, 4, '787687', '678868', '8767', '7867', '7687', 'DEED', 0, '2021-06-23', '2021-03-02 16:02:31'),
(3, 4, 'iuh', 'fsahfuiash', 'huih', 'uhihui', 'huih', 'DEED', 0, '2021-04-18', '2021-03-18 06:45:21'),
(4, 3, 'iuh', 'vcxvc', 'huihiu', 'uih', 'iuhuh', 'DEED', 0, '2021-03-02', '2021-03-18 08:06:59'),
(5, 5, 'jkhkjh', '34234', 'hjhjk', 'jjk', 'jkhj', 'ESTATE CASE', 0, '2021-01-04', '2021-03-18 07:45:00'),
(6, 6, '123', '2131', '54', '565', '56', 'ESTATE CASE', 0, '0000-00-00', '2021-03-18 07:43:57'),
(7, 7, '6969', '001', '25', 'ban', 'jhij', 'DEED', 0, '0000-00-00', '2021-03-28 13:16:13'),
(8, 8, '112312', '123', '312', '12311', '2131', 'DEED', 0, '0000-00-00', '2021-03-28 13:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `clientdetails`
--

CREATE TABLE `clientdetails` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(500) NOT NULL,
  `client_address` varchar(500) NOT NULL,
  `client_email` varchar(500) DEFAULT NULL,
  `client_nic` varchar(13) NOT NULL,
  `client_isDelete` tinyint(1) NOT NULL,
  `client_dateCreated` date NOT NULL DEFAULT current_timestamp(),
  `client_tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clientdetails`
--

INSERT INTO `clientdetails` (`client_id`, `client_name`, `client_address`, `client_email`, `client_nic`, `client_isDelete`, `client_dateCreated`, `client_tel`) VALUES
(3, 'ravien', '768', '', '76868', 0, '2021-03-02', 78687),
(4, 'sanath', '7687', '', '6678', 0, '2021-03-02', 76879),
(5, 'test ', 'dsahdj', '', '5676', 0, '2021-03-18', 8978987),
(6, 'test1', 'hgjh', '', '6786876', 0, '2021-03-18', 7867),
(7, 'me ura', 'iwegiu', '', '85555', 0, '2021-03-28', 0),
(8, 'djksfh', 'ghghgh', '', '6786', 0, '2021-03-28', 678678);

-- --------------------------------------------------------

--
-- Table structure for table `datedetails`
--

CREATE TABLE `datedetails` (
  `client_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `date_now` date NOT NULL,
  `date_1` date NOT NULL,
  `date_2` date NOT NULL,
  `date_3` date NOT NULL,
  `date_4` date NOT NULL,
  `date_5` date NOT NULL,
  `date_6` date NOT NULL,
  `date_7` date NOT NULL,
  `date_8` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `datedetails`
--

INSERT INTO `datedetails` (`client_id`, `case_id`, `date_now`, `date_1`, `date_2`, `date_3`, `date_4`, `date_5`, `date_6`, `date_7`, `date_8`) VALUES
(3, 1, '2021-03-26', '2021-03-24', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(3, 4, '2021-03-02', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(4, 2, '2021-06-23', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(4, 3, '2021-04-18', '2021-03-18', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(5, 5, '2021-01-04', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `user_id` int(11) NOT NULL,
  `user_NIC` varchar(13) NOT NULL,
  `user_name` text NOT NULL,
  `user_email` text NOT NULL,
  `user_address` varchar(500) NOT NULL,
  `user_password` text NOT NULL,
  `user_tel` int(13) NOT NULL,
  `user_type` text NOT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`user_id`, `user_NIC`, `user_name`, `user_email`, `user_address`, `user_password`, `user_tel`, `user_type`, `last_login`, `date_created`) VALUES
(1, '21313', 'akon', 'akon@gm.com', 'jsjdalkdj', 'bfbfcc9642b71f791069b8e544fff6eb0ffbf16a', 1234, 'USER', '2021-02-22 20:38:24', '2020-12-10 23:30:20'),
(2, '84189729', 'admin', 'admin@gm.com', 'jnfajksa', 'd033e22ae348aeb5660fc2140aec35850c4da997', 123, 'ADMIN', '2021-06-01 23:22:18', '2020-12-11 21:58:52'),
(17, '6', 'admin1', 'admin1@gm.com', 'banan', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 7887687, 'USER', '2021-03-02 15:33:22', '2021-03-02 15:33:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `casedetails`
--
ALTER TABLE `casedetails`
  ADD PRIMARY KEY (`case_id`),
  ADD UNIQUE KEY `case_number` (`case_number`),
  ADD KEY `client_fk` (`client_fk`);

--
-- Indexes for table `clientdetails`
--
ALTER TABLE `clientdetails`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_nic` (`client_nic`);

--
-- Indexes for table `datedetails`
--
ALTER TABLE `datedetails`
  ADD PRIMARY KEY (`client_id`,`case_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `casedetails`
--
ALTER TABLE `casedetails`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clientdetails`
--
ALTER TABLE `clientdetails`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `casedetails`
--
ALTER TABLE `casedetails`
  ADD CONSTRAINT `casedetails_ibfk_1` FOREIGN KEY (`client_fk`) REFERENCES `clientdetails` (`client_id`);

--
-- Constraints for table `datedetails`
--
ALTER TABLE `datedetails`
  ADD CONSTRAINT `datedetails_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `casedetails` (`case_id`),
  ADD CONSTRAINT `datedetails_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clientdetails` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
