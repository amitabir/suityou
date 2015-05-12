-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2015 at 03:18 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Items table' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `gender`, `type`, `description`, `price`, `designer_id`, `creation_time`, `picture`) VALUES
(3, 'Bezz Women Shirt', 'MALE', 'TOP', 'A bezz shirt', 16.7, 1, '2015-05-05 12:57:08', 'images1.jpeg'),
(4, 'Pink Skirt', 'FEMALE', 'BOTTOM', 'A pink skirt', 14.5, 1, '2015-05-05 12:57:55', 'images4.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `items_stock`
--

CREATE TABLE IF NOT EXISTS `items_stock` (
  `item_stock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `size` enum('LARGE','MEDIUM','SMALL') NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`item_stock_id`),
  UNIQUE KEY `id` (`item_stock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='The sizes and quantities of each size' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `items_stock`
--

INSERT INTO `items_stock` (`item_stock_id`, `item_id`, `size`, `quantity`) VALUES
(1, 3, 'LARGE', 10),
(2, 3, 'MEDIUM', 20),
(3, 3, 'SMALL', 50),
(4, 4, 'MEDIUM', 55),
(5, 4, 'LARGE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_attributes`
--

CREATE TABLE IF NOT EXISTS `item_attributes` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_matchings`
--

CREATE TABLE IF NOT EXISTS `item_matchings` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `top_item_id` int(11) NOT NULL,
  `buttom_item_id` int(11) NOT NULL,
  `match_precent` int(11) NOT NULL DEFAULT '0',
  `match_count` int(11) NOT NULL DEFAULT '0',
  `match_type` tinyint(1) NOT NULL DEFAULT '1',
  `model_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
