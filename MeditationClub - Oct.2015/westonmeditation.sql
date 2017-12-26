-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2015 at 10:41 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `westonmeditation`
--

-- --------------------------------------------------------

--
-- Table structure for table `info_table`
--

CREATE TABLE IF NOT EXISTS `info_table` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logTime` int(11) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info_table`
--

INSERT INTO `info_table` (`id`, `username`, `password`, `email`, `logTime`, `admin`) VALUES
(1, 'meditator1', 'c36fd0b8a34b83380cb15f59fb91e149', 'nanylagoon@hotmail.com', 75, 1);

-- --------------------------------------------------------

--
-- Table structure for table `link_table`
--

CREATE TABLE IF NOT EXISTS `link_table` (
`id` int(11) NOT NULL,
  `label` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs_table`
--

CREATE TABLE IF NOT EXISTS `logs_table` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `session` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info_table`
--
ALTER TABLE `info_table`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_table`
--
ALTER TABLE `link_table`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_table`
--
ALTER TABLE `logs_table`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info_table`
--
ALTER TABLE `info_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `link_table`
--
ALTER TABLE `link_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `logs_table`
--
ALTER TABLE `logs_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
