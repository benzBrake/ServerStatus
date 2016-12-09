SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
CREATE TABLE IF NOT EXISTS `ss_status` (
  `id` int(11) NOT NULL,
  `hostname` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `ram` varchar(128) NOT NULL,
  `ram_used` varchar(128) NOT NULL,
  `disk` varchar(128) NOT NULL,
  `uptime` varchar(128) NOT NULL,
  `aload` varchar(128) NOT NULL,
  `atime` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ss_location` (
	`id` int(11) NOT NULL,
	`ip` varchar(128) NOT NULL,
	`country` varchar(64),
	`province` varchar(64),
	`city` varchar(64),
	`isp` varchar(128)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `ss_status` (`id`, `hostname`, `ip`, `ram`, `ram_used`, `disk` ,`uptime`, `aload`, `atime`) VALUES
(1, 'ATT.USA', '12.12.5.10', '512', '265', '1100|8976',' 1 days, 20 hours, 32minutes.', ' 0.01', 1480463986);
ALTER TABLE `ss_status`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `ss_location`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ss_status`
--
ALTER TABLE `ss_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ss_location`
--
ALTER TABLE `ss_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
