-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 06:31 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5
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
(1, 'yok', '1121', 'yok123@gmail.com', 'Satthabut', 'Loungsanam', 3898, 'male', '0000-00-00', '0830131416', 'admin', '2019-05-16 19:15:28', '2019-05-25 19:17:00');

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
(1, 1, 2, '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `buy_lotto`
--

CREATE TABLE `buy_lotto` (
  `id` int(10) NOT NULL,
  `accId` int(10) NOT NULL,
  `number` varchar(10) NOT NULL,
  `lotto` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy_lotto`
--

INSERT INTO `buy_lotto` (`id`, `accId`, `number`, `lotto`, `created_at`, `updated_at`) VALUES
(1, 1, '10', 'a:3:{s:11:\"number2_top\";s:2:\"10\";s:11:\"number2_tod\";s:2:\"10\";s:14:\"number2_button\";s:2:\"10\";}', '2019-05-28 06:17:15', '0000-00-00 00:00:00'),
(2, 1, '01', 'a:3:{s:11:\"number2_top\";s:2:\"10\";s:11:\"number2_tod\";s:2:\"10\";s:14:\"number2_button\";s:2:\"10\";}', '2019-05-28 06:17:15', '0000-00-00 00:00:00'),
(3, 1, '100', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:17:15', '0000-00-00 00:00:00'),
(4, 1, '010', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:17:15', '0000-00-00 00:00:00'),
(5, 1, '001', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:17:15', '0000-00-00 00:00:00'),
(6, 1, '10', 'a:3:{s:11:\"number2_top\";s:2:\"10\";s:11:\"number2_tod\";s:2:\"10\";s:14:\"number2_button\";s:2:\"10\";}', '2019-05-28 06:18:32', '0000-00-00 00:00:00'),
(7, 1, '01', 'a:3:{s:11:\"number2_top\";s:2:\"10\";s:11:\"number2_tod\";s:2:\"10\";s:14:\"number2_button\";s:2:\"10\";}', '2019-05-28 06:18:32', '0000-00-00 00:00:00'),
(8, 1, '100', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:18:32', '0000-00-00 00:00:00'),
(9, 1, '010', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:18:32', '0000-00-00 00:00:00'),
(10, 1, '001', 'a:3:{s:11:\"number3_top\";s:2:\"10\";s:11:\"number3_tod\";s:2:\"10\";s:14:\"number3_button\";s:2:\"10\";}', '2019-05-28 06:18:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(3) NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `number`, `discount`, `pay`) VALUES
(1, '3 ตัวบน', '35', 550),
(2, '3 ตัวบนโต๊ด', '35', 100),
(3, '3 ตัวล่าง', '26', 100),
(4, '2 ตัวบนโต๊ด', '35', 550),
(5, '2 ตัวบน', '28', 70),
(6, '2 ตัวล่าง', '28', 70);

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
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL COMMENT 'ุสถานะ',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deposit_detail`
--

INSERT INTO `deposit_detail` (`id`, `accId`, `bankId`, `amount`, `tranfersDate`, `tranferTime`, `detail`, `description`, `status`, `create_date`, `updated_at`) VALUES
(27, 1, 1, 400, '2019-01-02', '02:01:00', '', 'dd', 3, '2019-05-24 13:28:45', '2019-05-25 07:38:09'),
(28, 1, 1, 300, '2019-10-05', '03:00:00', '', '', 2, '2019-05-24 13:49:11', '2019-05-25 07:38:18'),
(29, 1, 1, 500, '2019-01-03', '03:01:00', '', '', 2, '2019-05-24 13:49:44', '2019-05-25 07:38:18'),
(30, 1, 1, 1100, '2019-02-03', '02:02:00', '', '', 2, '2019-05-24 13:49:56', '2019-05-25 07:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `lotto`
--

CREATE TABLE `lotto` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL COMMENT 'วันที่หวยออก',
  `prize_first` varchar(255) NOT NULL COMMENT 'เลขรางวัลที่ 1',
  `number_back_three` varchar(255) NOT NULL COMMENT 'เลขท้าย 3 ตัว',
  `number_back_two` varchar(255) NOT NULL COMMENT 'เลขท้าย 2 ตัว'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lotto`
--

INSERT INTO `lotto` (`id`, `date`, `prize_first`, `number_back_three`, `number_back_two`) VALUES
(12, '2019-05-16', 'a:1:{i:0;s:6:\"962526\";}', 'a:2:{i:0;s:3:\"018\";i:1;s:3:\"828\";}', 'a:1:{i:0;s:2:\"71\";}');

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
(2, 'ทำรายการสำเร็จ'),
(3, 'ไม่อนุมัติ');

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
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `withdraw_detail`
--

INSERT INTO `withdraw_detail` (`id`, `accId`, `amount`, `bankId`, `status`, `description`, `create_date`, `updated_at`) VALUES
(11, 1, 100, 1, 3, 'ฟหกฟ', '2019-05-24 16:31:56', '2019-05-25 07:39:07'),
(12, 1, 12000, 1, 1, '', '2019-05-27 18:50:19', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

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
-- Indexes for table `buy_lotto`
--
ALTER TABLE `buy_lotto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accId` (`accId`),
  ADD KEY `bankId` (`bankId`);

--
-- Indexes for table `lotto`
--
ALTER TABLE `lotto`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `buy_lotto`
--
ALTER TABLE `buy_lotto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `lotto`
--
ALTER TABLE `lotto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `status_transfer`
--
ALTER TABLE `status_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `withdraw_detail_ibfk_2` FOREIGN KEY (`accId`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
