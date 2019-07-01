-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2019 at 07:34 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

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
  `idcard` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bookbank` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('disable','enable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disable',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `fname`, `lname`, `money`, `gender`, `birthday`, `phone`, `idcard`, `bookbank`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'yok', '1121', 'yok123@gmail.com', 'Satthabut', 'Loungsanam', 1604, 'male', '0000-00-00', '0830131416', '', '', 'admin', 'enable', '2019-05-16 19:15:28', '2019-06-06 05:17:58'),
(2, 'fluk', '1121', 'fluk@gmail.com', 'พงศ์พล', 'มาธิดา', 84234, 'male', '2018-07-13', '0864091932', '', '', 'user', 'enable', '2019-06-03 03:13:22', '2019-06-03 03:20:55'),
(3, 'test', '1234', 'dasda@dsa.com', 'จอห์น', 'วิค', 19483, 'male', '2019-03-08', '0123456789', '', '', 'user', 'enable', '2019-06-05 01:21:15', '0000-00-00 00:00:00');

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
(4, 'กรุงเทพ', 'resources/images/bangkok.jpg');

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
(2, 1, 2, '1234567890'),
(4, 2, 2, '1234567890-d'),
(5, 3, 3, '1234567890-d');

-- --------------------------------------------------------

--
-- Table structure for table `bill_lotto`
--

CREATE TABLE `bill_lotto` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_lotto`
--

INSERT INTO `bill_lotto` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 1, '2019-06-27 15:05:56', NULL),
(2, 'test', 1, '2019-06-27 15:06:06', NULL),
(3, 'test', 1, '2019-06-27 15:06:55', NULL),
(4, 'test', 1, '2019-06-27 15:08:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buy_lotto`
--

CREATE TABLE `buy_lotto` (
  `id` int(10) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `accId` int(10) NOT NULL,
  `number` varchar(10) NOT NULL,
  `criteria_id` varchar(3) NOT NULL,
  `pay` varchar(255) NOT NULL,
  `status` enum('wait','win','lose') NOT NULL DEFAULT 'wait',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy_lotto`
--

INSERT INTO `buy_lotto` (`id`, `bill_id`, `accId`, `number`, `criteria_id`, `pay`, `status`, `created_at`, `updated_at`) VALUES
(41, 0, 2, '61', '5', '200', 'win', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(42, 0, 2, '12', '4', '500', 'lose', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(43, 0, 2, '12', '6', '300', 'lose', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(44, 0, 2, '21', '5', '200', 'lose', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(45, 0, 2, '21', '4', '500', 'lose', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(46, 0, 2, '21', '6', '300', 'lose', '2019-06-03 14:38:47', '2019-06-07 06:38:46'),
(47, 4, 3, '233', '1', '133', 'wait', '2019-06-27 15:08:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(3) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `name`, `discount`, `pay`) VALUES
(1, '3 ตัวบน', '35', 550),
(2, '3 ตัวโต๊ด', '35', 100),
(3, '3 ตัวล่าง', '26', 100),
(4, '2 ตัวโต๊ด', '35', 550),
(5, '2 ตัวบน', '28', 70),
(6, '2 ตัวล่าง', '28', 70);

-- --------------------------------------------------------

--
-- Table structure for table `criteria_user`
--

CREATE TABLE `criteria_user` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `criteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `criteria_user`
--

INSERT INTO `criteria_user` (`id`, `user_id`, `criteria`) VALUES
(1, 2, 'YTo2OntpOjA7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiIxIjtzOjQ6Im5hbWUiO3M6MTc6IjMg4LiV4Lix4Lin4Lia4LiZIjtzOjg6ImRpc2NvdW50IjtzOjI6IjM1IjtzOjM6InBheSI7czoxOiIwIjt9aToxO086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiaWQiO3M6MToiMiI7czo0OiJuYW1lIjtzOjIzOiIzIOC4leC4seC4p+C5guC4leC5iuC4lCI7czo4OiJkaXNjb3VudCI7czoyOiIzNSI7czozOiJwYXkiO3M6NDoiMTE1MCI7fWk6MjtPOjg6InN0ZENsYXNzIjo0OntzOjI6ImlkIjtzOjE6IjMiO3M6NDoibmFtZSI7czoyMzoiMyDguJXguLHguKfguKXguYjguLLguIciO3M6ODoiZGlzY291bnQiO3M6MjoiNTAiO3M6MzoicGF5IjtzOjQ6IjExMjEiO31pOjM7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiI0IjtzOjQ6Im5hbWUiO3M6MjM6IjIg4LiV4Lix4Lin4LmC4LiV4LmK4LiUIjtzOjg6ImRpc2NvdW50IjtzOjM6IjEwMCI7czozOiJwYXkiO3M6MzoiNTU1Ijt9aTo0O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiaWQiO3M6MToiNSI7czo0OiJuYW1lIjtzOjE3OiIyIOC4leC4seC4p+C4muC4mSI7czo4OiJkaXNjb3VudCI7czozOiIxMDAiO3M6MzoicGF5IjtzOjI6IjcwIjt9aTo1O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiaWQiO3M6MToiNiI7czo0OiJuYW1lIjtzOjIzOiIyIOC4leC4seC4p+C4peC5iOC4suC4hyI7czo4OiJkaXNjb3VudCI7czoyOiIxNCI7czozOiJwYXkiO3M6MjoiMzAiO319'),
(2, 3, 'YTo2OntpOjA7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiIxIjtzOjQ6Im5hbWUiO3M6MTc6IjMg4LiV4Lix4Lin4Lia4LiZIjtzOjg6ImRpc2NvdW50IjtzOjI6IjM1IjtzOjM6InBheSI7czozOiI1NTAiO31pOjE7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiIyIjtzOjQ6Im5hbWUiO3M6MjM6IjMg4LiV4Lix4Lin4LmC4LiV4LmK4LiUIjtzOjg6ImRpc2NvdW50IjtzOjI6IjM1IjtzOjM6InBheSI7czozOiIxMDAiO31pOjI7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiIzIjtzOjQ6Im5hbWUiO3M6MjM6IjMg4LiV4Lix4Lin4Lil4LmI4Liy4LiHIjtzOjg6ImRpc2NvdW50IjtzOjI6IjI2IjtzOjM6InBheSI7czozOiIxMDAiO31pOjM7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiI0IjtzOjQ6Im5hbWUiO3M6MjM6IjIg4LiV4Lix4Lin4LmC4LiV4LmK4LiUIjtzOjg6ImRpc2NvdW50IjtzOjI6IjM1IjtzOjM6InBheSI7czozOiI1NTAiO31pOjQ7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJpZCI7czoxOiI1IjtzOjQ6Im5hbWUiO3M6MTc6IjIg4LiV4Lix4Lin4Lia4LiZIjtzOjg6ImRpc2NvdW50IjtzOjI6IjI4IjtzOjM6InBheSI7czoyOiI3MCI7fWk6NTtPOjg6InN0ZENsYXNzIjo0OntzOjI6ImlkIjtzOjE6IjYiO3M6NDoibmFtZSI7czoyMzoiMiDguJXguLHguKfguKXguYjguLLguIciO3M6ODoiZGlzY291bnQiO3M6MjoiMjgiO3M6MzoicGF5IjtzOjI6IjcwIjt9fQ==');

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
(30, 1, 1, 1100, '2019-02-03', '02:02:00', '', '', 2, '2019-05-24 13:49:56', '2019-05-25 07:38:18'),
(31, 3, 1, 1000, '2019-04-04', '02:03:00', '', '', 2, '2019-07-01 15:01:42', '2019-07-01 22:14:30'),
(32, 3, 1, 3000, '2019-03-03', '05:04:00', '', '', 2, '2019-07-01 15:02:04', '2019-07-01 22:17:48'),
(33, 3, 1, 1000, '2019-01-01', '00:00:00', '', '', 2, '2019-07-01 15:18:27', '2019-07-01 22:21:43'),
(34, 3, 1, 2200, '2019-01-01', '01:01:00', '', '', 2, '2019-07-01 15:18:40', '2019-07-01 22:21:43'),
(35, 3, 1, 1199, '2019-02-02', '03:02:00', '', '', 2, '2019-07-01 15:47:02', '2019-07-01 22:48:26'),
(36, 3, 1, 1000, '2020-02-02', '01:02:00', '', '', 2, '2019-07-01 15:47:13', '2019-07-01 22:48:26'),
(37, 3, 1, 500, '2021-04-03', '03:03:00', '', '', 2, '2019-07-01 15:47:29', '2019-07-01 22:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `lottery_result`
--

CREATE TABLE `lottery_result` (
  `id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `criteria_name` varchar(50) NOT NULL,
  `payfull` varchar(20) NOT NULL,
  `discount` varchar(20) NOT NULL,
  `realplay` varchar(20) NOT NULL,
  `pay_rate` varchar(10) NOT NULL,
  `reward` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(16, '2019-05-16', 'a:1:{i:0;s:6:\"962526\";}', 'a:2:{i:0;s:3:\"018\";i:1;s:3:\"828\";}', 'a:1:{i:0;s:2:\"71\";}'),
(21, '2019-06-03', 'a:1:{i:0;s:6:\"516461\";}', 'a:2:{i:0;s:3:\"215\";i:1;s:3:\"560\";}', 'a:1:{i:0;s:2:\"46\";}'),
(22, '0000-00-00', 'N;', 'N;', 'N;'),
(23, '2019-06-01', 'a:1:{i:0;s:6:\"516461\";}', 'a:2:{i:0;s:3:\"215\";i:1;s:3:\"560\";}', 'a:1:{i:0;s:2:\"46\";}');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
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
(12, 1, 12000, 1, 2, '', '2019-05-27 18:50:19', '2019-07-01 22:48:16'),
(13, 3, 200, 5, 2, '', '2019-07-01 15:47:53', '2019-07-01 22:48:16');

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
-- Indexes for table `bill_lotto`
--
ALTER TABLE `bill_lotto`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `criteria_user`
--
ALTER TABLE `criteria_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accId` (`accId`),
  ADD KEY `bankId` (`bankId`);

--
-- Indexes for table `lottery_result`
--
ALTER TABLE `lottery_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lotto`
--
ALTER TABLE `lotto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bill_lotto`
--
ALTER TABLE `bill_lotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buy_lotto`
--
ALTER TABLE `buy_lotto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `criteria_user`
--
ALTER TABLE `criteria_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deposit_detail`
--
ALTER TABLE `deposit_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `lottery_result`
--
ALTER TABLE `lottery_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lotto`
--
ALTER TABLE `lotto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdraw_detail`
--
ALTER TABLE `withdraw_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
