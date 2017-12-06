-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: mic-kaiyangnews-api-mysql:3306
-- Generation Time: Dec 06, 2017 at 07:12 AM
-- Server version: 5.5.58
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mic_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `detail` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `app_show` enum('customer','business') DEFAULT NULL,
  `position` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `name`, `detail`, `thumbnail`, `image`, `app_show`, `position`, `start_date`, `end_date`, `created_at`, `updated_at`, `status`) VALUES
(1, 'aaaa', 'ccc', 'dea5b3e3f8eb325a205b2c7afdee17e6_thumbnail.png', 'b2655192013176a77c6a35f89ea8eba9_image.png', 'customer', 0, '2017-10-05 00:00:00', '2017-10-06 00:00:00', '2017-10-23 21:32:47', '2017-10-23 21:40:44', 'active'),
(2, 'cccccc', '5555', 'b08194d00e872f64c80cf7085faf4f20_thumbnail.png', 'b08194d00e872f64c80cf7085faf4f20_image.png', 'business', 0, '2017-10-26 00:00:00', '2017-10-30 00:00:00', '2017-10-23 21:40:23', '2017-10-24 10:10:46', 'active'),
(3, 'aaaaa', 'ddd', '5aaeceec3d5ec311148ba34f5fb53c56_thumbnail.png', '5aaeceec3d5ec311148ba34f5fb53c56_image.png', 'customer', 0, '2017-10-25 00:00:00', '2017-10-27 00:00:00', '2017-10-24 10:11:48', '2017-10-24 10:11:48', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
