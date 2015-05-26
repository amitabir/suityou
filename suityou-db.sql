-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2015 at 12:39 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `suityou`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE IF NOT EXISTS `attributes` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`attribute_id`, `category_id`, `name`) VALUES
(1, 1, 'Blue'),
(2, 1, 'Red'),
(3, 1, 'Pink'),
(4, 1, 'Green'),
(5, 1, 'Yellow'),
(6, 1, 'White'),
(7, 1, 'Beige'),
(8, 1, 'Brown'),
(9, 1, 'Light Blue'),
(10, 2, 'Cotton'),
(11, 2, 'Cashmere'),
(12, 2, 'Denim'),
(13, 2, 'Wool'),
(14, 2, 'Tricot'),
(15, 3, 'Polka Dots'),
(16, 3, 'Solid'),
(17, 3, 'Horizontal Stripes'),
(18, 3, 'Vertical Stripes'),
(19, 3, 'Flowery'),
(20, 3, 'Argyle'),
(21, 3, 'Geometric'),
(22, 4, 'Tight'),
(23, 4, 'Medium'),
(24, 4, 'Loose'),
(25, 5, 'Elegant'),
(26, 5, 'Sport Elegant'),
(27, 5, 'Formal'),
(28, 5, 'Party'),
(29, 5, 'Casual'),
(30, 5, 'Sports'),
(31, 6, 'Exposed'),
(32, 6, 'Covered'),
(33, 6, 'Slightly Exposed'),
(41, 1, 'Black'),
(42, 1, 'Khaki'),
(43, 1, 'Khaki'),
(44, 1, 'Khaki'),
(45, 1, 'Dark Blue'),
(46, 1, 'Cyan');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_scores`
--

CREATE TABLE IF NOT EXISTS `attribute_scores` (
  `attribute1_id` int(11) NOT NULL,
  `attribute2_id` int(11) NOT NULL,
  `score` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` double NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `weight`) VALUES
(1, 'Color', 1),
(2, 'Fabric', 1),
(3, 'Pattern', 1),
(4, 'Tightness', 1),
(5, 'Atmosphere', 1),
(6, 'Exposure', 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL DEFAULT 'MALE',
  `type` enum('TOP','BOTTOM') NOT NULL DEFAULT 'TOP',
  `description` text,
  `price` double NOT NULL,
  `designer_id` int(11) unsigned NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `id` (`item_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Items table' AUTO_INCREMENT=29 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `gender`, `type`, `description`, `price`, `designer_id`, `creation_time`, `picture`) VALUES
(3, 'Bezz Women Shirt', 'MALE', 'TOP', 'A bezz shirt', 16.7, 1, '2015-05-05 12:57:08', 'images1.jpeg'),
(4, 'Pink Skirt', 'FEMALE', 'BOTTOM', 'A pink skirt', 14.5, 1, '2015-05-05 12:57:55', 'images4.jpeg'),
(6, 'Red Shirt', 'FEMALE', 'TOP', 'Red Shirt Description', 34.2, 1, '2015-05-23 20:58:48', '64476.jpeg'),
(7, 'Black Pants', 'MALE', 'BOTTOM', 'Men''s black pants', 45, 1, '2015-05-23 21:02:57', '81571.jpeg'),
(8, 'Green Pants', 'FEMALE', 'BOTTOM', 'desc', 10.9, 1, '2015-05-23 21:12:06', '2372.jpeg'),
(10, 'Black Long Pants', 'MALE', 'TOP', 'Black Long Pants Description', 50.4, 1, '2015-05-23 21:25:15', '52216.jpeg'),
(11, 'dsad', 'FEMALE', 'TOP', 'dsad', 12, 1, '2015-05-23 21:25:37', '40613.jpeg'),
(12, 'dsad', 'FEMALE', 'TOP', 'dsad', 12, 1, '2015-05-23 21:26:27', '58312.jpeg'),
(13, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:27:03', '33826.jpeg'),
(14, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:27:52', '49000.jpeg'),
(15, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:28:19', '59513.jpeg'),
(16, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:28:33', '41076.jpeg'),
(17, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:30:26', '24847.jpeg'),
(18, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:31:44', '79910.jpeg'),
(19, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:32:36', '46831.jpeg'),
(20, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-23 21:38:54', '70473.jpeg'),
(21, 'dsa', 'FEMALE', 'BOTTOM', 'dsa', 12.3, 1, '2015-05-23 21:40:30', '53418.jpeg'),
(22, 'Khaki Pants', 'MALE', 'BOTTOM', 'desc', 56.7, 1, '2015-05-23 22:32:38', '28840.jpeg'),
(23, 'Khaki Pants', 'MALE', 'BOTTOM', 'desc', 56.7, 1, '2015-05-23 22:33:11', '1244.jpeg'),
(24, 'Khaki Pants', 'MALE', 'BOTTOM', 'desc', 56.7, 1, '2015-05-23 22:33:53', '49227.jpeg'),
(25, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-24 16:21:55', ''),
(26, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-24 17:18:09', ''),
(27, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-24 17:18:36', ''),
(28, 'Ofer', 'MALE', 'BOTTOM', 'Ofer', 12.9, 1, '2015-05-26 10:47:25', '19233.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `items_stock`
--

CREATE TABLE IF NOT EXISTS `items_stock` (
  `item_stock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`item_stock_id`),
  UNIQUE KEY `id` (`item_stock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The sizes and quantities of each size' AUTO_INCREMENT=28 ;

--
-- Dumping data for table `items_stock`
--

INSERT INTO `items_stock` (`item_stock_id`, `item_id`, `size`, `quantity`) VALUES
(1, 3, 'LARGE', 10),
(2, 3, 'MEDIUM', 20),
(3, 3, 'SMALL', 50),
(4, 4, 'MEDIUM', 55),
(5, 4, 'LARGE', 0),
(8, 23, 'LARGE', 30),
(9, 24, 'LARGE', 30),
(10, 24, 'MEDIUM', 15),
(11, 24, 'SMALL', 0),
(12, 25, 'LARGE', 30),
(13, 26, 'LARGE', 30),
(14, 27, 'LARGE', 30),
(15, 27, 'SMALL', 24),
(26, 21, 'large', 6),
(27, 28, 'LARGE', 12);

-- --------------------------------------------------------

--
-- Table structure for table `item_attributes`
--

CREATE TABLE IF NOT EXISTS `item_attributes` (
  `item_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_attributes`
--

INSERT INTO `item_attributes` (`item_id`, `attribute_id`) VALUES
(3, 7),
(3, 10),
(3, 16),
(3, 24),
(3, 25),
(3, 32),
(6, 2),
(6, 11),
(6, 16),
(6, 23),
(6, 25),
(6, 33),
(7, 4),
(7, 10),
(7, 16),
(7, 23),
(7, 26),
(7, 32),
(8, 4),
(8, 12),
(8, 16),
(8, 22),
(8, 29),
(8, 32),
(19, 34),
(19, 10),
(19, 35),
(19, 15),
(19, 36),
(19, 22),
(19, 37),
(19, 25),
(19, 38),
(19, 31),
(19, 39),
(20, 40),
(20, 10),
(20, 15),
(20, 22),
(20, 25),
(20, 31),
(21, 10),
(21, 15),
(21, 22),
(21, 25),
(21, 31),
(22, 42),
(22, 14),
(22, 16),
(22, 24),
(22, 29),
(22, 32),
(23, 43),
(23, 11),
(23, 16),
(23, 24),
(23, 29),
(23, 32),
(24, 44),
(24, 14),
(24, 16),
(24, 24),
(24, 29),
(24, 32),
(25, 41),
(25, 14),
(25, 15),
(25, 22),
(25, 25),
(25, 31),
(26, 41),
(26, 10),
(26, 15),
(26, 22),
(26, 25),
(26, 31),
(27, 41),
(27, 10),
(27, 15),
(27, 22),
(27, 25),
(27, 31),
(21, 1),
(21, 45),
(21, 46),
(21, 46),
(21, 46),
(28, 2),
(28, 12),
(28, 16),
(28, 23),
(28, 26),
(28, 32);

-- --------------------------------------------------------

--
-- Table structure for table `item_matchings`
--

CREATE TABLE IF NOT EXISTS `item_matchings` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `top_item_id` int(11) NOT NULL,
  `bottom_item_id` int(11) NOT NULL,
  `match_percent` double NOT NULL DEFAULT '0',
  `match_count` int(11) NOT NULL DEFAULT '0',
  `match_type` tinyint(1) NOT NULL DEFAULT '1',
  `model_picture` varchar(255) DEFAULT NULL,
  `ignored_match_percent` double NOT NULL DEFAULT '0',
  `ignored_match_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `item_matchings`
--

INSERT INTO `item_matchings` (`match_id`, `top_item_id`, `bottom_item_id`, `match_percent`, `match_count`, `match_type`, `model_picture`, `ignored_match_percent`, `ignored_match_count`) VALUES
(1, 3, 4, 50, 2, 1, 'model1.jpg', 0, 0),
(2, 25, 23, 5, 2, 1, 'model2.jpg', 0, 0),
(3, 24, 6, 80, 1, 1, '36418.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` double NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE IF NOT EXISTS `purchase_items` (
  `purchase_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_stock_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`purchase_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(500) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `birth_date` date NOT NULL,
  `is_designer` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL,
  `coupon_meter` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `website_link` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `first_name`, `last_name`, `address`, `gender`, `birth_date`, `is_designer`, `avatar`, `coupon_meter`, `description`, `website_link`) VALUES
(1, 'amabir@gmail.com', 'Amit', 'Abir', 'adsa', 'MALE', '1988-12-31', 0, '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_matchings`
--

CREATE TABLE IF NOT EXISTS `user_matchings` (
  `user_match_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `rating` double DEFAULT NULL,
  `rating_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `skipped` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_matchings`
--

INSERT INTO `user_matchings` (`user_match_id`, `user_id`, `match_id`, `rating`, `rating_time`, `skipped`) VALUES
(1, 1, 3, NULL, '2015-05-24 12:16:09', 1),
(2, 1, 3, 5, '2015-05-26 07:37:31', 0),
(3, 1, 3, 10, '2015-05-26 07:37:31', 0),
(4, 1, 3, 8, '2015-05-26 07:37:31', 0),
(5, 1, 3, 4, '2015-05-26 07:37:31', 0),
(6, 1, 3, 2, '2015-05-26 07:37:31', 0),
(7, 1, 2, 10, '2015-05-26 07:44:49', 0),
(8, 1, 2, 10, '2015-05-26 07:44:49', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
