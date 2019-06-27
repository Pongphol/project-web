-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2019 at 10:11 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buy_lotto`
--
ALTER TABLE `buy_lotto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buy_lotto`
--
ALTER TABLE `buy_lotto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
