-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2015 at 05:00 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `weight` double NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
-- Table structure for table `constants`
--

CREATE TABLE IF NOT EXISTS `constants` (
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `value` float NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `constants`
--

INSERT INTO `constants` (`name`, `description`, `value`) VALUES
('AVERAGE_LIMIT', 'The average rating of a couple of attributes needs to be greater or equal to this constant in order to be considered a trend.', 8),
('BAD_RATING_REPEAT_LIMIT', 'A user rating the exact same rating this constant times in a row is to be considered as a spammer.', 3),
('BAD_TIME_REPEAT_LIMIT', 'A user rating faster than the allowed time this constant times in a row is to be considered as a spammer.', 2),
('COUPON_PRIZE', 'The coupon meter gets bigger by this constant every time the user rates a match.', 10),
('DIFF_FOR_ACCEPT_NEW_VOTE', 'A new rating is to be taken to account for a match avereage if it is not different more than this constant from the current average.', 10),
('IGNORED_VOTES_LIMIT_FOR_ACCEPT', 'The number of ignored ratings needs to be greater than this constant in order for all the ignored ratings to be taken for the match average.', 10),
('MATCH_CONSTANT', 'The weight of the users opinion of a trend is given by this lovely constant.', 0.5),
('MATCH_SCORE_LIMIT', 'A trend''s users'' opinion must be greater than or equal to this constant in order to be considered a trend.', 50),
('MAX_COUPON', 'The coupon meter max value is defined by this wonderful constant. ', 100),
('MINIMAL_TIME', 'A vote made faster than this constant is suspicious for being too fast and the user might be a spammer.', 100),
('NUMBER_OF_CATEGORIES', 'The number of categories is given to you here and now by this beautiful constant.', 6),
('STDEV_LIMIT', 'The STDEV of ratings of a couple of attributes needs to be smaller or equal to this constant in order to be considered a trend.', 1),
('TREND_CONSTANT', 'The weight of the our prediction of a trend is given by this once in a lifetime constant.', 0.5),
('TREND_SCORE_LIMIT', 'A trend''s prediction by us must be greater than or equal to this constant in order to be considered a trend.', 50),
('VOTES_LIMIT_FOR_ACCEPT_NEW_VOTE', 'Any rating is accepted for a match if the total number of ratings for that match is lower than this brand new constant.', 10);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Items table' AUTO_INCREMENT=33 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `gender`, `type`, `description`, `price`, `designer_id`, `creation_time`, `picture`) VALUES
(3, 'Bezz Women Shirt', 'MALE', 'TOP', 'A pink shirt', 16.7, 1, '2015-05-05 12:57:08', '64476.jpeg'),
(4, 'Pink Skirt', 'FEMALE', 'BOTTOM', 'A pink skirt', 14.5, 1, '2015-05-05 12:57:55', '69315.jpeg'),
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
(25, 'dsa', 'FEMALE', 'TOP', 'dsa', 12.3, 1, '2015-05-24 16:21:55', '49227.jpeg'),
(28, 'Ofer', 'MALE', 'BOTTOM', 'Ofer', 12.9, 1, '2015-05-26 10:47:25', '19233.jpeg'),
(29, 'Black Jacket', 'MALE', 'TOP', 'Black Black 2', 80, 1, '2015-05-29 15:23:56', '88384.jpeg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='The sizes and quantities of each size' AUTO_INCREMENT=35 ;

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
(26, 21, 'large', 6),
(27, 28, 'LARGE', 12),
(28, 7, 'SMALL', 13),
(29, 10, 'LARGE', 6),
(30, 29, 'LARGE', 13),
(31, 29, 'MEDIUM', 10);

-- --------------------------------------------------------

--
-- Table structure for table `item_attributes`
--

CREATE TABLE IF NOT EXISTS `item_attributes` (
  `item_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(28, 32),
(29, 41),
(29, 10),
(29, 16),
(29, 24),
(29, 27),
(29, 32);

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
  `trend_percent` double DEFAULT NULL,
  `match_type` tinyint(1) NOT NULL DEFAULT '1',
  `model_picture` varchar(255) DEFAULT NULL,
  `ignored_match_percent` double NOT NULL DEFAULT '0',
  `ignored_match_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`match_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `item_matchings`
--

INSERT INTO `item_matchings` (`match_id`, `top_item_id`, `bottom_item_id`, `match_percent`, `match_count`, `trend_percent`, `match_type`, `model_picture`, `ignored_match_percent`, `ignored_match_count`) VALUES
(1, 3, 4, 50.307692307692, 65, NULL, 1, 'model1.jpg', 48, 5),
(2, 25, 23, 39.344262295081, 61, NULL, 1, '63007.jpg', 67.777777777778, 9),
(3, 6, 24, 43.28125, 64, NULL, 1, '36418.jpg', 0, 0),
(4, 19, 22, 52.5, 8, 76.111111111111, 0, NULL, 0, 0),
(5, 29, 22, 54.333333333332, 60, NULL, 1, '74200.jpg', 53.333333333333, 6);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` double NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `user_id`, `total_price`) VALUES
(1, 1, 302.4),
(4, 1, 390.6),
(5, 1, 334),
(6, 1, 26.1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE IF NOT EXISTS `purchase_items` (
  `purchase_id` int(11) NOT NULL,
  `item_stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  UNIQUE KEY `purchase_id` (`purchase_id`,`item_stock_id`),
  UNIQUE KEY `purchase_id_2` (`purchase_id`,`item_stock_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`purchase_id`, `item_stock_id`, `quantity`) VALUES
(1, 29, 6),
(2, 29, 1),
(3, 29, 1),
(4, 8, 6),
(4, 29, 1),
(5, 2, 20),
(6, 4, 2);

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
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL,
  `coupon_meter` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `website_link` varchar(500) DEFAULT NULL,
  `is_spammer` tinyint(1) NOT NULL DEFAULT '0',
  `is_spammer_time` timestamp NULL DEFAULT NULL,
  `time_tracking_ctr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `first_name`, `last_name`, `address`, `gender`, `birth_date`, `is_designer`, `is_admin`, `avatar`, `coupon_meter`, `description`, `website_link`, `is_spammer`, `is_spammer_time`, `time_tracking_ctr`) VALUES
(1, 'amabir@gmail.com', 'Amit', 'Abir', 'BBB', 'MALE', '1988-12-31', 1, 1, '14325.jpeg', 60, ' Bootstrap 3 Flat Web Kit is a useful package that contains PSD+HTML/CSS of the all controls designed based on latest Twitter bootstrap 3 a flat look to the user interface elements. There are no gradients, shadows, or rounded corners - everything looks clean and simple. The package will be especially useful for programmers who do not want to waste time & budget on custom design but still require trendy style to their products. Also it can be useful for everyone who requires flat design for their product based on easy-to-use bootstrap 3 code.\r\n ', 'http://google.com', 1, '2015-06-10 16:18:07', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `user_matchings`
--

INSERT INTO `user_matchings` (`user_match_id`, `user_id`, `match_id`, `rating`, `rating_time`, `skipped`) VALUES
(24, 1, 3, 3, '2015-06-06 08:49:31', 0),
(25, 1, 3, 5, '2015-06-06 08:49:34', 0),
(26, 1, 3, 6, '2015-06-06 08:49:35', 0),
(27, 1, 3, 8, '2015-06-06 08:49:37', 0),
(28, 1, 3, 9, '2015-06-06 08:49:39', 0),
(35, 1, 4, 4, '2015-06-06 10:42:48', 0),
(36, 1, 3, 3, '2015-06-07 19:37:30', 0),
(37, 1, 3, 6, '2015-06-07 19:37:33', 0),
(38, 1, 3, 8, '2015-06-07 19:37:36', 0),
(39, 1, 3, 9, '2015-06-07 19:37:38', 0),
(40, 1, 3, 6, '2015-06-09 09:38:26', 0),
(41, 1, 3, 3, '2015-06-09 09:38:27', 0),
(42, 1, 2, 1, '2015-06-10 07:34:18', 0),
(43, 1, 5, 1, '2015-06-10 07:34:18', 0),
(44, 1, 3, 6, '2015-06-10 13:41:31', 0),
(45, 1, 2, 8, '2015-06-10 13:41:32', 0),
(46, 1, 2, 4, '2015-06-10 13:48:14', 0),
(47, 1, 2, 6, '2015-06-10 13:48:15', 0),
(48, 1, 2, 3, '2015-06-10 13:56:54', 0),
(49, 1, 2, 5, '2015-06-10 13:56:59', 0),
(50, 1, 2, NULL, '2015-06-10 13:57:13', 1),
(51, 1, 2, NULL, '2015-06-10 13:57:14', 1),
(52, 1, 2, NULL, '2015-06-10 13:57:18', 1),
(53, 1, 2, 3, '2015-06-10 13:57:20', 0),
(54, 1, 2, 7, '2015-06-10 13:57:23', 0),
(55, 1, 2, 4, '2015-06-10 13:57:24', 0),
(56, 1, 2, 4, '2015-06-10 13:57:26', 0),
(57, 1, 2, 7, '2015-06-10 13:57:27', 0),
(58, 1, 2, 8, '2015-06-10 13:57:33', 0),
(59, 1, 2, 7, '2015-06-10 13:59:10', 0),
(60, 1, 2, 8, '2015-06-10 13:59:12', 0),
(61, 1, 2, 5, '2015-06-10 13:59:15', 0),
(62, 1, 2, 4, '2015-06-10 13:59:25', 0),
(63, 1, 5, 7, '2015-06-10 13:59:26', 0),
(64, 1, 5, 10, '2015-06-10 13:59:28', 0),
(65, 1, 5, 3, '2015-06-10 15:35:14', 0),
(66, 1, 5, 8, '2015-06-10 15:35:16', 0),
(67, 1, 5, 2, '2015-06-10 16:14:54', 0),
(68, 1, 5, 2, '2015-06-10 16:14:56', 0),
(69, 1, 5, 2, '2015-06-10 16:14:58', 0),
(70, 1, 5, 2, '2015-06-10 16:18:07', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
