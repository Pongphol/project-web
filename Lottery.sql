-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2019 at 11:03 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lottery`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(10) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` float NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_banking`
--

CREATE TABLE `admin_banking` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banking`
--

CREATE TABLE `banking` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `id` int(10) NOT NULL,
  `accId` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_detail`
--

CREATE TABLE `deposit_detail` (
  `id` int(10) NOT NULL,
  `accId` int(10) NOT NULL,
  `bankId` int(10) NOT NULL,
  `amount` float NOT NULL,
  `tranfersDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tranfersOption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_detail`
--

CREATE TABLE `history_detail` (
  `id` int(11) NOT NULL,
  `deposit_id` int(11) NOT NULL,
  `withdraw_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_transfer`
--

CREATE TABLE `status_transfer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_transfer`
--

INSERT INTO `status_transfer` (`id`, `name`) VALUES
(1, 'กำลังดำเนินการ'),
(2, 'ทำรายการสำเร็จ');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_detail`
--

CREATE TABLE `withdraw_detail` (
  `id` int(10) NOT NULL,
  `accId` int(10) NOT NULL,
  `amount` float NOT NULL,
  `bankId` int(10) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_banking`
--
ALTER TABLE `admin_banking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banking`
--
ALTER TABLE `banking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accId` (`accId`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accId` (`accId`),
  ADD KEY `bankId` (`bankId`);

--
-- Indexes for table `history_detail`
--
ALTER TABLE `history_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposit_id` (`deposit_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `withdraw_id` (`withdraw_id`);

--
-- Indexes for table `status_transfer`
--
ALTER TABLE `status_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bankId` (`bankId`),
  ADD KEY `accId` (`accId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_banking`
--
ALTER TABLE `admin_banking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banking`
--
ALTER TABLE `banking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_detail`
--
ALTER TABLE `history_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_transfer`
--
ALTER TABLE `status_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD CONSTRAINT `bank_account_ibfk_1` FOREIGN KEY (`accId`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `bank_account_ibfk_2` FOREIGN KEY (`type`) REFERENCES `banking` (`id`);

--
-- Constraints for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  ADD CONSTRAINT `deposit_detail_ibfk_1` FOREIGN KEY (`accId`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `deposit_detail_ibfk_2` FOREIGN KEY (`bankId`) REFERENCES `admin_banking` (`id`);

--
-- Constraints for table `history_detail`
--
ALTER TABLE `history_detail`
  ADD CONSTRAINT `history_detail_ibfk_1` FOREIGN KEY (`deposit_id`) REFERENCES `deposit_detail` (`id`),
  ADD CONSTRAINT `history_detail_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_transfer` (`id`),
  ADD CONSTRAINT `history_detail_ibfk_3` FOREIGN KEY (`withdraw_id`) REFERENCES `withdraw_detail` (`id`);

--
-- Constraints for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  ADD CONSTRAINT `withdraw_detail_ibfk_1` FOREIGN KEY (`bankId`) REFERENCES `bank_account` (`id`),
  ADD CONSTRAINT `withdraw_detail_ibfk_2` FOREIGN KEY (`accId`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
