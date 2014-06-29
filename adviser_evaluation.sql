-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2014 at 06:36 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fashionshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_evaluation`
--
DROP TABLE IF EXISTS `fs_adviser_evaluation`;
CREATE TABLE IF NOT EXISTS `fs_adviser_evaluation` (
  `evaluationId` varchar(10) NOT NULL DEFAULT '0',
  `evaluationSelected` text NOT NULL,
  `evaluationConclusion` text DEFAULT NULL,
  `evaluationRate` double DEFAULT NULL,
  PRIMARY KEY (`evaluationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Triggers `fs_adviser_evaluation`
--
DROP TRIGGER IF EXISTS `tg_fs_adviser_evaluation`;
DELIMITER //
CREATE TRIGGER `tg_fs_adviser_evaluation` BEFORE INSERT ON `fs_adviser_evaluation`
 FOR EACH ROW BEGIN
  INSERT INTO fs_adviser_evaluation_seq VALUES (NULL);
  SET NEW.evaluationId = CONCAT('EVAL', LPAD(LAST_INSERT_ID(), 6, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_evaluation_seq`
--
DROP TABLE IF EXISTS `fs_adviser_evaluation_seq`;

CREATE TABLE IF NOT EXISTS `fs_adviser_evaluation_seq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
