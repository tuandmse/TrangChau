-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2014 at 10:23 AM
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
-- Table structure for table `fs_adviser_nodes`
--

CREATE TABLE IF NOT EXISTS `fs_adviser_nodes` (
  `nodesNode` varchar(20) NOT NULL,
  `nodesContent` text NOT NULL,
  `questionNode` varchar(20) NULL,
  PRIMARY KEY (`nodesNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_nodes`
--

INSERT INTO `fs_adviser_nodes` (`nodesNode`, `nodesContent`, `questionNode`) VALUES
('a1', 'Bạn muốn thể hiện sự nghiêm túc của mình trong công việc ?', 'c1'),
('a2', 'Bạn muốn diện những bộ đồ thanh lịch ?', 'c1'),
('a3', 'Bạn muốn gây vẻ quyến rũ của mình tới mọi người ?', 'c1'),
('a4', 'Bạn muốn thể hiện cá tính của mình ?', 'c1'),
('a5', 'Bạn muốn diện bộ đồ mang tính nhẹ nhàng ?', 'c1'),
('a6', 'Bạn muốn mình trở nên trẻ trung hơn trong bộ đồ ?', 'c1'),
('a7', 'Bạn muốn thể hiện mình là người sành điệu?', 'c1'),
('a8', 'Bạn muốn diện bộ đồ có thể dễ dàng tham gia các hoạt động?', 'c1');

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_question`
--

CREATE TABLE IF NOT EXISTS `fs_adviser_question` (
  `questionNode` varchar(20) NOT NULL,
  `questionContent` text NOT NULL,
  `questionType` varchar(2) NOT NULL,
  PRIMARY KEY (`questionNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_question`
--

INSERT INTO `fs_adviser_question` (`questionNode`, `questionContent`, `questionType`) VALUES
('c1', 'Chọn kiểu trang phục', 'CF'),
('c2', 'Bạn thuộc giới tính nào ?', 'YN'),
('c3', 'Bạn thuộc nhóm tuổi nào ?', 'YN'),
('c4', 'Bạn có chiều cao, cân nặng là bao nhiêu ?', 'YN'),
('c5', 'Bạn có nước da trắng hay ngăm đen ?', 'YN');

-- --------------------------------------------------------

--
-- Table structure for table `fs_adviser_rules`
--

CREATE TABLE IF NOT EXISTS `fs_adviser_rules` (
  `rulesId` varchar(20) NOT NULL,
  `rulesContent` text NOT NULL,
  `rulesCF` double NOT NULL,
  PRIMARY KEY (`rulesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_adviser_rules`
--

INSERT INTO `fs_adviser_rules` (`rulesId`, `rulesContent`, `rulesCF`) VALUES
('r1', 'a1^a2=>f1', 0.7),
('r11', 'a4^a6^a8=>f11', 0.8),
('r12', 'a1^a8=>f12', 0.67),
('r13', 'a3^a6^e2=>f13', 0.76),
('r14', 'a6^a8=>f14', 0.8),
('r15', 'a8=>f15', 0.79),
('r16', 'd1=>g1', 0.6),
('r17', 'd1=>g3', 0.5),
('r18', 'd3=>g5', 0.56),
('r19', 'd3=>g2', 0.66),
('r2', 'a3^a4^e2=>f2', 0.78),
('r20', 'b1=>g8', 0.6),
('r21', 'b1=>g1', 0.7),
('r22', 'b1=>g10', 0.65),
('r23', 'b1=>g3', 0.8),
('r24', 'b1=>g7', 0.56),
('r25', 'b2=>g9', 0.67),
('r26', 'b2=>g10', 0.7),
('r27', 'b2=>g4', 0.76);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
