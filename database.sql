-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2019 at 02:08 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

CREATE DATABASE IF NOT EXISTS lottery;
USE lottery;

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
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `fname`, `lname`, `money`, `gender`, `birthday`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'yok', '12345', 'yok123@gmail.com', 'Satthabut', 'loungsanam', 3950, 'male', '0000-00-00', '', 'admin', '2019-05-16 19:15:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_banking`
--

CREATE TABLE `admin_banking` (
  `id` int(10) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อธนาคาร',
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'บัญชีธนาคาร',
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_banking`
--

INSERT INTO `admin_banking` (`id`, `bank_name`, `account_number`, `picture`) VALUES
(1, 'ไทยพาณิชย์', '1234-1233-22', 'resources/images/scb.png');

-- --------------------------------------------------------

--
-- Table structure for table `banking`
--

CREATE TABLE `banking` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banking`
--

INSERT INTO `banking` (`id`, `name`, `picture`) VALUES
(1, 'ไทยพาณิชย์', 'resources/images/scb.png'),
(2, 'กสิกรไทย', 'resources/images/kkb.png'),
(3, 'กรุงไทย', 'resources/images/kthai.png'),
(4, 'กรุงเทพ', 'resources/images/bankok.png');

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `id` int(10) NOT NULL,
  `accId` int(11) NOT NULL COMMENT 'ไอดีผู้ใช้งาน',
  `type` int(11) NOT NULL COMMENT 'ไอดีธนาคาร',
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เลขบัญชี'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bank_account`
--

INSERT INTO `bank_account` (`id`, `accId`, `type`, `number`) VALUES
(1, 1, 1, '322-313');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_detail`
--

CREATE TABLE `deposit_detail` (
  `id` int(10) NOT NULL,
  `accId` int(10) NOT NULL COMMENT 'ไอดีผู้ใช้งาน',
  `bankId` int(10) NOT NULL COMMENT 'ไอดีธนาคารแอดมิน',
  `amount` float NOT NULL COMMENT 'จำนวนเงินฝาก',
  `tranfersDate` date NOT NULL COMMENT 'วันที่โอน',
  `tranferTime` time NOT NULL COMMENT 'เวลาโอน',
  `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'รายละเอียด',
  `status` int(1) NOT NULL COMMENT 'ุสถานะ',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deposit_detail`
--

INSERT INTO `deposit_detail` (`id`, `accId`, `bankId`, `amount`, `tranfersDate`, `tranferTime`, `detail`, `status`, `create_date`) VALUES
(1, 1, 1, 200, '0000-00-00', '10:30:00', '', 1, '2019-05-17 04:51:09'),
(2, 1, 1, 300, '2018-01-01', '11:39:00', 'test', 1, '2019-05-17 05:12:23'),
(3, 1, 1, 300, '2019-02-01', '01:00:00', '', 1, '2019-05-17 07:31:04'),
(4, 1, 1, 200, '2019-04-01', '01:00:00', '', 1, '2019-05-17 07:31:39'),
(5, 1, 1, 100, '2019-03-05', '01:00:00', '', 1, '2019-05-17 07:55:14'),
(6, 1, 1, 400, '2017-02-04', '14:01:00', '', 1, '2019-05-17 09:14:43'),
(7, 1, 1, 1122, '2019-01-01', '01:00:00', '', 1, '2019-05-17 09:19:17'),
(8, 1, 1, 300, '2020-01-02', '02:01:00', '', 1, '2019-05-17 10:52:43'),
(9, 1, 1, 400, '2018-02-03', '14:01:00', '', 1, '2019-05-18 08:56:26');

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
  `status` int(1) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `withdraw_detail`
--

INSERT INTO `withdraw_detail` (`id`, `accId`, `amount`, `bankId`, `status`, `create_date`) VALUES
(7, 1, 123, 1, 1, '2019-05-17 10:07:57'),
(8, 1, 3333, 1, 1, '2019-05-17 10:14:07'),
(9, 1, 333, 1, 1, '2019-05-17 10:52:19'),
(10, 1, 50, 1, 1, '2019-05-17 11:09:36');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_banking`
--
ALTER TABLE `admin_banking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banking`
--
ALTER TABLE `banking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `status_transfer`
--
ALTER TABLE `status_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  ADD CONSTRAINT `withdraw_detail_ibfk_1` FOREIGN KEY (`bankId`) REFERENCES `bank_account` (`id`),
  ADD CONSTRAINT `withdraw_detail_ibfk_2` FOREIGN KEY (`accId`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;