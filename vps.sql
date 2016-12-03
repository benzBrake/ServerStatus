-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-11-30 14:46:01
-- 服务器版本： 5.5.48-log
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vps`
--

-- --------------------------------------------------------

--
-- 表的结构 `vps`
--

CREATE TABLE IF NOT EXISTS `vps` (
  `id` int(11) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ram` varchar(128) NOT NULL,
  `used` varchar(128) NOT NULL,
  `uptime` varchar(128) NOT NULL,
  `aload` varchar(128) NOT NULL,
  `atime` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `vps`
--

INSERT INTO `vps` (`id`, `ip`, `ram`, `used`, `uptime`, `aload`, `atime`) VALUES
(1, '12.12.5.10', '512', '265', ' 1 day, 20:32', ' 0.00, 0.00, 0.00', 1480463986),
(2, '12.36.20.23', '1024', '536', '1 day, 20:32', '0.00, 0.00, 0.00', 1480464286),
(14, '192.210.241.230', '2343', '234', '1day', '0.23, 1.00, 0.46', 1480476266);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vps`
--
ALTER TABLE `vps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vps`
--
ALTER TABLE `vps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
