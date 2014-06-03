-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2014 at 08:27 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fashionshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_nodes`
--

DROP TABLE IF EXISTS `fs_adviser_nodes`;
CREATE TABLE IF NOT EXISTS `fs_adviser_nodes` (
  `nodesNode` varchar(10) NOT NULL DEFAULT '0',
  `nodesContent` text NOT NULL,
  `questionNode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`nodesNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_nodes`
--

INSERT INTO `fs_adviser_nodes` (`nodesNode`, `nodesContent`, `questionNode`) VALUES
('NODE000011', 'Bạn muốn thể hiện sự nghiêm túc của mình trong công việc?', 'QUES000007'),
('NODE000012', 'Bạn muốn diện những bộ đồ thanh lịch?', 'QUES000007'),
('NODE000013', 'Bạn muốn gây vẻ quyến rũ của mình tới mọi người?', 'QUES000007'),
('NODE000014', 'Đồ công sở', NULL),
('NODE000015', 'Bạn muốn thể hiện cá tính của mình?', 'QUES000007'),
('NODE000016', 'Bạn muốn diện bộ đồ mang tính nhẹ nhàng?', 'QUES000007'),
('NODE000017', 'Bạn muốn mình trở nên trẻ trung hơn trong bộ đồ?', 'QUES000007'),
('NODE000018', 'Bạn muốn thể hiện mình là người sành điệu?', 'QUES000007'),
('NODE000019', 'Bạn muốn diện bộ đồ có thể dễ dàng tham gia các hoạt động?', 'QUES000007'),
('NODE000026', '1213213', 'QUES000009'),
('NODE000027', '32132131', 'QUES000009');

--
-- Triggers `fs_adviser_nodes`
--
DROP TRIGGER IF EXISTS `tg_fs_adviser_nodes_insert`;
DELIMITER //
CREATE TRIGGER `tg_fs_adviser_nodes_insert` BEFORE INSERT ON `fs_adviser_nodes`
 FOR EACH ROW BEGIN
  INSERT INTO fs_adviser_nodes_seq VALUES (NULL);
  SET NEW.nodesNode = CONCAT('NODE', LPAD(LAST_INSERT_ID(), 6, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_nodes_seq`
--

DROP TABLE IF EXISTS `fs_adviser_nodes_seq`;
CREATE TABLE IF NOT EXISTS `fs_adviser_nodes_seq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `fs_adviser_nodes_seq`
--

INSERT INTO `fs_adviser_nodes_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27);

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_question`
--

DROP TABLE IF EXISTS `fs_adviser_question`;
CREATE TABLE IF NOT EXISTS `fs_adviser_question` (
  `questionNode` varchar(10) NOT NULL DEFAULT '0',
  `questionContent` text NOT NULL,
  `questionType` varchar(2) NOT NULL,
  PRIMARY KEY (`questionNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_question`
--

INSERT INTO `fs_adviser_question` (`questionNode`, `questionContent`, `questionType`) VALUES
('QUES000007', 'Chọn kiểu trang phục', 'CF');

--
-- Triggers `fs_adviser_question`
--
DROP TRIGGER IF EXISTS `tg_fs_adviser_question_insert`;
DELIMITER //
CREATE TRIGGER `tg_fs_adviser_question_insert` BEFORE INSERT ON `fs_adviser_question`
 FOR EACH ROW BEGIN
  INSERT INTO fs_adviser_question_seq VALUES (NULL);
  SET NEW.questionNode = CONCAT('QUES', LPAD(LAST_INSERT_ID(), 6, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_question_seq`
--

DROP TABLE IF EXISTS `fs_adviser_question_seq`;
CREATE TABLE IF NOT EXISTS `fs_adviser_question_seq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `fs_adviser_question_seq`
--

INSERT INTO `fs_adviser_question_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9);

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_rules`
--

DROP TABLE IF EXISTS `fs_adviser_rules`;
CREATE TABLE IF NOT EXISTS `fs_adviser_rules` (
  `rulesId` varchar(10) NOT NULL DEFAULT '0',
  `rulesContent` text NOT NULL,
  `rulesCF` double NOT NULL,
  PRIMARY KEY (`rulesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_rules`
--

INSERT INTO `fs_adviser_rules` (`rulesId`, `rulesContent`, `rulesCF`) VALUES
('RULE000001', 'NODE000011^NODE000012=>NODE000014', 0.5),
('RULE000002', 'NODE000011^NODE000012^NODE000013=>NODE000014', 0.9),
('RULE000003', 'NODE000011^NODE000012^NODE000013^NODE000015^NODE000016^NODE000017^NODE000018^NODE000019=>NODE000014', 0.99);

--
-- Triggers `fs_adviser_rules`
--
DROP TRIGGER IF EXISTS `tg_fs_adviser_rules_insert`;
DELIMITER //
CREATE TRIGGER `tg_fs_adviser_rules_insert` BEFORE INSERT ON `fs_adviser_rules`
 FOR EACH ROW BEGIN
  INSERT INTO fs_adviser_rules_seq VALUES (NULL);
  SET NEW.rulesId = CONCAT('RULE', LPAD(LAST_INSERT_ID(), 6, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_rules_seq`
--

DROP TABLE IF EXISTS `fs_adviser_rules_seq`;
CREATE TABLE IF NOT EXISTS `fs_adviser_rules_seq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fs_adviser_rules_seq`
--

INSERT INTO `fs_adviser_rules_seq` (`id`) VALUES
(1),
(2),
(3);
