-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2015 at 06:06 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

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
(46, 1, 'Cyan'),
(47, 3, 'Blotted'),
(48, 3, 'Drawings?'),
(49, 2, 'Nylon'),
(50, 5, 'IGiveUp'),
(51, 1, 'Grey'),
(52, 3, 'Print'),
(53, 1, 'Orange'),
(54, 2, 'Flannel'),
(55, 1, 'Colorful'),
(56, 3, 'Jake The Dog');

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
('VOTES_LIMIT_FOR_ACCEPT_NEW_VOTE', 'Any rating is accepted for a match if the total number of ratings for that match is lower than this brand new constant.', 10),
('TREND_MIN_COUNT', 'The minimum number of ratings for two attributes to become a trend', 3);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Items table' AUTO_INCREMENT=75 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `gender`, `type`, `description`, `price`, `designer_id`, `creation_time`, `picture`) VALUES
(30, 'Red pants with black blotts', 'FEMALE', 'BOTTOM', 'Red And Black pants', 23.9, 1, '2015-06-08 19:24:52', '3428.jpg'),
(33, 'White skirt with cat pattern', 'FEMALE', 'BOTTOM', 'Adorable short white skirt with cute black cats pattern', 25, 9, '2015-06-09 01:13:05', '52905.jpg'),
(34, 'White Skirt with owls', 'FEMALE', 'BOTTOM', 'We Bring you another wonderfull creation by the great Umberto- another adorable white dress with the cutest owl pattern you have ever seen!', 20, 2, '2015-06-09 01:15:35', '16849.jpg'),
(35, 'Elegant black skirt', 'FEMALE', 'BOTTOM', 'An elegant black skirt. perfect for IDK. stuff I guess..', 10, 9, '2015-06-09 01:17:23', '47998.jpg'),
(36, 'Pants', 'MALE', 'BOTTOM', 'these are definetly pants. the kind you wear.', 100, 1, '2015-06-09 01:19:17', '10126.jpg'),
(37, 'Black Jeans', 'FEMALE', 'BOTTOM', 'These are hideous! don''t get caught wearing this atrocity ;) we promise to never make anything like this again. Umberto was blind drunk.', 1, 2, '2015-06-09 01:21:57', '44043.jpg'),
(38, 'Denim shorts', 'FEMALE', 'BOTTOM', 'These are nice. you should buy them. come on. they work with errrrryyything!', 20, 9, '2015-06-09 01:24:33', '88357.jpg'),
(39, 'Denim shorts for dudes', 'MALE', 'BOTTOM', 'name says it all. gotta love the belt buckle.', 35.99, 1, '2015-06-09 01:39:03', '32004.jpg'),
(40, 'Gym teacher shorts (sorry Ofer..)', 'MALE', 'BOTTOM', 'NOT for running! check out that cool bright blue stripe, saying to your students: Im tough, but also elegant!.\r\n\r\n disclaimer: Umberto de Cazale will not be held liable for people being lonley forever after choosing to be a gym teacher. It''s YOUR responsibilty. Just do anything else.\r\n\r\nnote: I have NO unresolved issues with my former gym teacher, may he burn in hell.', 15.98, 1, '2015-06-09 01:47:47', '95739.jpg'),
(41, 'Gym Shorts', 'MALE', 'BOTTOM', 'great for a run in the park.', 10, 2, '2015-06-09 01:49:42', '4557.jpg'),
(42, 'golden Elephant patterned black pants', 'FEMALE', 'BOTTOM', 'chill, bro..', 5, 9, '2015-06-09 01:56:08', '13996.jpg'),
(43, 'Colorful shorts', 'MALE', 'BOTTOM', 'yeah.', 15.99, 9, '2015-06-09 02:00:25', '22544.jpg'),
(44, 'Metallica-and justice for all... shirt', 'MALE', 'TOP', '...and justice for all album cover shirt. wear it so other people will know what kind of music you like.', 10, 1, '2015-06-09 02:10:51', '77649.jpg'),
(45, 'black denim vest', 'MALE', 'TOP', 'don''t do it.', 15, 9, '2015-06-09 02:14:22', '40210.jpg'),
(46, 'grey tank top 2', 'FEMALE', 'TOP', 'umm..hmm..', 10, 9, '2015-06-09 02:16:16', '33060.jpg'),
(47, 'black tank top', 'FEMALE', 'TOP', 'what the name says', 10, 2, '2015-06-09 02:17:54', '77118.jpg'),
(48, 'grey shirt', 'MALE', 'TOP', 'cool cars.', 17.99, 2, '2015-06-09 02:19:58', '34152.jpg'),
(49, 'yellow shirt', 'MALE', 'TOP', 'like the red one but yellow', 11.11, 1, '2015-06-09 02:21:56', '11829.jpg'),
(50, 'red shirt', 'MALE', 'TOP', 'it''s like the red one but yellow', 11.09, 1, '2015-06-09 02:24:10', '20743.jpg'),
(51, 'Hippie undershirt', 'FEMALE', 'TOP', 'ugh..why..', 9.1101, 2, '2015-06-09 02:26:29', '90826.jpg'),
(52, 'white shirt', 'FEMALE', 'TOP', 'a white shirt.', 15, 2, '2015-06-11 04:17:49', '94461.jpg'),
(53, 'black coat', 'MALE', 'TOP', 'a warm black coat. tons of pockets.', 120, 2, '2015-06-11 04:19:00', '32367.jpg'),
(54, 'a striped white shirt', 'MALE', 'TOP', '', 10, 9, '2015-06-11 04:20:03', '68796.jpg'),
(55, 'grey tank top', 'FEMALE', 'TOP', '', 13.45, 2, '2015-06-11 04:21:10', '50476.jpg'),
(56, 'blue shirt', 'FEMALE', 'TOP', 'bright blue shirt with white lace', 17.89, 8, '2015-06-11 04:22:30', '45816.jpg'),
(57, 'white shirt with cool circle thing', 'FEMALE', 'TOP', 'awesome white shirt with cool circle thing. its great?', 12.11, 8, '2015-06-11 04:24:01', '86309.jpg'),
(58, 'orange', 'MALE', 'TOP', 'orange shirt. great for golfing with your buddies', 150, 2, '2015-06-11 04:25:22', '79818.jpg'),
(59, 'white tank top w/ feather pattern', 'FEMALE', 'TOP', 'yup', 11.1111, 1, '2015-06-11 04:26:36', '58227.jpg'),
(60, 'flannel 90s shirt', 'FEMALE', 'TOP', 'smells like awesome', 45.9, 9, '2015-06-11 04:28:28', '71975.jpg'),
(61, 'pink/red shirt?', 'MALE', 'TOP', 'its pink? is it red? what?', 10.21, 2, '2015-06-11 04:29:37', '93963.jpg'),
(63, 'red V neck shirt', 'MALE', 'TOP', '', 50, 9, '2015-06-11 04:31:16', '17102.jpg'),
(64, 'colorful hippie shirt', 'FEMALE', 'TOP', 'whaaa', 99.99, 8, '2015-06-11 04:32:44', '95547.jpg'),
(65, 'kawaii yellow jake the dog kigurumi- just top part', 'MALE', 'TOP', 'kawaiiiii', 10, 8, '2015-06-11 04:34:38', '44537.jpg'),
(67, 'Flowery Denim shorts ', 'FEMALE', 'BOTTOM', 'flowerssss', 10, 8, '2015-06-11 04:37:12', '44037.jpg'),
(68, 'Blue jeans', 'MALE', 'BOTTOM', '', 11.1, 2, '2015-06-11 04:38:06', '65817.jpg'),
(69, 'bright blue jeans for the gals', 'FEMALE', 'BOTTOM', '', 1, 8, '2015-06-11 04:39:00', '50818.jpg'),
(70, 'black training shorts', 'MALE', 'BOTTOM', 'cool', 101, 1, '2015-06-11 04:39:58', '8072.jpg'),
(71, 'kawaii', 'FEMALE', 'BOTTOM', 'beautiful skirt. so cute. much awesome.', 32, 8, '2015-06-11 04:41:21', '97198.jpg'),
(72, 'Black Jeans for the dudes', 'MALE', 'BOTTOM', 'better then the other pair', 190, 9, '2015-06-11 04:42:34', '91684.jpg'),
(73, 'yellow shorts', 'MALE', 'BOTTOM', '', 150, 2, '2015-06-11 04:43:37', '76538.jpg'),
(74, 'another black skirt', 'FEMALE', 'BOTTOM', 'it''s different. totes diff. believe us.', 131, 8, '2015-06-11 04:45:07', '92825.jpg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='The sizes and quantities of each size' AUTO_INCREMENT=120 ;

--
-- Dumping data for table `items_stock`
--

INSERT INTO `items_stock` (`item_stock_id`, `item_id`, `size`, `quantity`) VALUES
(32, 30, 'Large', 15),
(33, 30, 'Medium', 10),
(34, 30, 'XLarge', 10),
(35, 30, 'Small', 5),
(38, 33, 'Medium', 10),
(39, 33, 'Small', 5),
(40, 33, 'Large', 5),
(41, 34, 'Medium', 10),
(42, 34, 'Small', 5),
(43, 34, 'Large', 4),
(44, 35, 'Medium', 20),
(45, 36, 'Medium', 10),
(46, 36, 'Large', 10),
(47, 36, 'Small', 10),
(48, 37, 'Medium', 2),
(49, 38, 'Medium', 100),
(50, 38, 'Large', 120),
(51, 38, 'Small', 110),
(52, 39, 'Medium', 100),
(53, 40, 'XXXL', 48),
(54, 41, 'Large', 10),
(55, 41, 'Medium', 10),
(56, 42, 'One Size', 19),
(57, 43, 'Medium', 10),
(58, 43, 'Large', 5),
(59, 44, 'Medium', 10),
(60, 44, 'small', 5),
(61, 44, 'large', 10),
(62, 45, 'Medium', 10),
(63, 45, 'XL', 10),
(64, 45, 'XS', 10),
(65, 46, 'Medium', 10),
(66, 46, 'small', 10),
(67, 46, 'XS', 10),
(68, 46, 'Large', 10),
(69, 47, 'Medium', 10),
(70, 47, 'XS', 10),
(71, 47, 'small', 10),
(72, 47, 'Large', 10),
(73, 48, 'Medium', 10),
(74, 48, 'XL', 10),
(75, 49, 'Medium', 10),
(76, 49, 'Large', 10),
(77, 49, 'xL', 10),
(78, 50, 'Large', 10),
(79, 50, 'xl', 10),
(80, 50, 'Medium', 10),
(81, 51, 'Medium', 10),
(82, 51, 'Large', 10),
(83, 51, 'Small', 10),
(84, 52, 'Medium', 10),
(85, 52, 'Large', 10),
(86, 52, 'small', 10),
(87, 53, 'Medium', 10),
(88, 54, 'Medium', 10),
(89, 55, 'Medium', 10),
(90, 55, 'small', 10),
(91, 55, 'Large', 10),
(92, 56, 'Medium', 10),
(93, 57, 'Medium', 10),
(94, 58, 'Medium', 10),
(95, 59, 'Medium', 10),
(96, 59, 'Large', 10),
(97, 60, 'One Size', 10),
(98, 61, 'Medium', 10),
(99, 61, 'Small', 10),
(100, 62, 'Medium', 10),
(101, 62, 'Small', 10),
(102, 63, 'Medium', 10),
(103, 64, 'Big and Baggy', 10),
(104, 65, 'Small', 10),
(105, 66, 'Small', 10),
(106, 66, 'Japan Large(medium)', 10),
(107, 66, 'Large (Japan XXXL)', 10),
(108, 67, 'Small', 10),
(109, 67, 'Medium', 10),
(110, 68, 'Medium', 111),
(111, 69, 'Medium', 11),
(112, 70, 'Medium', 10),
(113, 70, 'Large', 10),
(114, 71, 'Medium', 10),
(115, 71, 'Large', 10),
(116, 72, 'Medium', 10),
(117, 72, 'Small', 10),
(118, 73, 'Medium', 10),
(119, 74, 'Medium', 10);

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
(28, 32),
(29, 41),
(29, 10),
(29, 16),
(29, 24),
(29, 27),
(29, 32),
(30, 2),
(30, 12),
(30, 48),
(30, 23),
(30, 29),
(30, 32),
(33, 6),
(33, 10),
(33, 48),
(33, 24),
(33, 28),
(33, 33),
(34, 6),
(34, 10),
(34, 48),
(34, 24),
(34, 28),
(34, 33),
(35, 41),
(35, 10),
(35, 16),
(35, 24),
(35, 25),
(35, 33),
(36, 45),
(36, 12),
(36, 16),
(36, 23),
(36, 28),
(36, 32),
(37, 41),
(37, 12),
(37, 16),
(37, 23),
(37, 29),
(37, 32),
(38, 45),
(38, 12),
(38, 48),
(38, 22),
(38, 28),
(38, 33),
(39, 1),
(39, 12),
(39, 16),
(39, 23),
(39, 28),
(39, 33),
(40, 45),
(40, 49),
(40, 18),
(40, 24),
(40, 30),
(40, 31),
(41, 41),
(41, 49),
(41, 16),
(41, 24),
(41, 30),
(41, 33),
(42, 41),
(42, 10),
(42, 48),
(42, 24),
(42, 50),
(42, 33),
(43, 51),
(43, 10),
(43, 20),
(43, 23),
(43, 28),
(43, 33),
(44, 41),
(44, 10),
(44, 52),
(44, 23),
(44, 29),
(44, 33),
(45, 41),
(45, 12),
(45, 16),
(45, 23),
(45, 27),
(45, 31),
(46, 51),
(46, 14),
(46, 16),
(46, 22),
(46, 25),
(46, 33),
(47, 41),
(47, 14),
(47, 16),
(47, 22),
(47, 25),
(47, 33),
(48, 51),
(48, 14),
(48, 52),
(48, 23),
(48, 29),
(48, 33),
(49, 5),
(49, 10),
(49, 52),
(49, 23),
(49, 29),
(49, 33),
(50, 2),
(50, 10),
(50, 52),
(50, 23),
(50, 29),
(50, 33),
(51, 3),
(51, 10),
(51, 48),
(51, 24),
(51, 50),
(51, 33),
(52, 6),
(52, 11),
(52, 16),
(52, 23),
(52, 27),
(52, 33),
(53, 41),
(53, 10),
(53, 16),
(53, 24),
(53, 25),
(53, 32),
(54, 6),
(54, 10),
(54, 17),
(54, 23),
(54, 28),
(54, 33),
(55, 51),
(55, 10),
(55, 16),
(55, 22),
(55, 29),
(55, 33),
(56, 1),
(56, 10),
(56, 16),
(56, 23),
(56, 25),
(56, 31),
(57, 6),
(57, 10),
(57, 48),
(57, 22),
(57, 29),
(57, 33),
(58, 53),
(58, 10),
(58, 16),
(58, 23),
(58, 25),
(58, 33),
(59, 6),
(59, 14),
(59, 48),
(59, 23),
(59, 29),
(59, 33),
(60, 4),
(60, 54),
(60, 20),
(60, 24),
(60, 29),
(60, 32),
(61, 3),
(61, 14),
(61, 52),
(61, 23),
(61, 29),
(61, 33),
(62, 3),
(62, 14),
(62, 52),
(62, 23),
(62, 29),
(62, 33),
(63, 2),
(63, 14),
(63, 52),
(63, 23),
(63, 29),
(63, 33),
(64, 55),
(64, 14),
(64, 48),
(64, 24),
(64, 28),
(64, 32),
(65, 5),
(65, 13),
(65, 56),
(65, 24),
(65, 27),
(65, 31),
(66, 5),
(66, 13),
(66, 56),
(66, 24),
(66, 27),
(66, 31),
(67, 9),
(67, 12),
(67, 19),
(67, 22),
(67, 28),
(67, 31),
(68, 1),
(68, 12),
(68, 16),
(68, 23),
(68, 29),
(68, 32),
(69, 9),
(69, 12),
(69, 16),
(69, 22),
(69, 29),
(69, 32),
(70, 41),
(70, 10),
(70, 16),
(70, 24),
(70, 26),
(70, 33),
(71, 7),
(71, 10),
(71, 20),
(71, 24),
(71, 25),
(71, 31),
(72, 41),
(72, 12),
(72, 16),
(72, 23),
(72, 29),
(72, 32),
(73, 5),
(73, 12),
(73, 16),
(73, 23),
(73, 29),
(73, 33),
(74, 41),
(74, 10),
(74, 16),
(74, 24),
(74, 25),
(74, 31);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Dumping data for table `item_matchings`
--

INSERT INTO `item_matchings` (`match_id`, `top_item_id`, `bottom_item_id`, `match_percent`, `match_count`, `trend_percent`, `match_type`, `model_picture`, `ignored_match_percent`, `ignored_match_count`) VALUES
(6, 46, 42, 66.666666666667, 3, NULL, 1, '61108.jpg', 0, 0),
(7, 49, 43, 50, 2, NULL, 1, '62732.jpg', 0, 0),
(8, 50, 41, 82.5, 4, NULL, 1, '95156.jpg', 0, 0),
(9, 47, 33, 55, 2, NULL, 1, '1960.jpg', 0, 0),
(10, 47, 30, 56.666666666667, 3, NULL, 1, '73105.jpg', 0, 0),
(11, 44, 39, 66, 5, NULL, 1, '6705.jpg', 0, 0),
(12, 49, 40, 70, 4, NULL, 1, '10990.jpg', 0, 0),
(13, 51, 30, 40, 3, NULL, 1, '71454.jpg', 0, 0),
(14, 51, 37, 65, 2, NULL, 1, '48175.jpg', 0, 0),
(15, 61, 39, 60, 5, NULL, 1, '63916.jpg', 0, 0),
(16, 45, 70, 50, 3, NULL, 1, '79519.jpg', 0, 0),
(17, 58, 72, 60, 2, NULL, 1, '53754.jpg', 0, 0),
(18, 65, 70, 60, 2, NULL, 1, '49948.jpg', 0, 0),
(19, 63, 68, 64, 5, NULL, 1, '91571.jpg', 0, 0),
(20, 54, 36, 50, 2, NULL, 1, '9543.jpg', 0, 0),
(21, 57, 38, 20, 2, NULL, 1, '46082.jpg', 0, 0),
(22, 53, 36, 45, 2, NULL, 1, '16812.jpg', 0, 0),
(23, 48, 73, 65, 4, NULL, 1, '74884.jpg', 0, 0),
(24, 59, 74, 75, 2, NULL, 1, '84408.jpg', 0, 0),
(25, 52, 71, 45, 4, NULL, 1, '8521.jpg', 0, 0),
(26, 49, 73, 42, 5, NULL, 1, '3910.jpg', 0, 0),
(27, 55, 34, 50, 2, NULL, 1, '29407.jpg', 0, 0),
(28, 60, 69, 75, 2, NULL, 1, '36759.jpg', 0, 0),
(29, 64, 69, 78, 5, NULL, 1, '24726.jpg', 0, 0),
(30, 61, 40, 76.666666666667, 3, NULL, 1, '48361.jpg', 0, 0),
(31, 57, 67, 65, 2, NULL, 1, '85608.jpg', 0, 0),
(32, 56, 35, 40, 3, NULL, 1, '87686.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` double NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `is_spammer_time` int(11) DEFAULT NULL,
  `time_tracking_ctr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `first_name`, `last_name`, `address`, `gender`, `birth_date`, `is_designer`, `is_admin`, `avatar`, `coupon_meter`, `description`, `website_link`, `is_spammer`, `is_spammer_time`, `time_tracking_ctr`) VALUES
(1, 'charlotte@suityou.fr', 'Charlotte', 'd''Avignon', 'adsa, République française', 'FEMALE', '1988-12-31', 1, 0, '8576.jpg', 0, 'Je suis le meilleur designer en europe!', 'abcd', 0, NULL, 0),
(2, 'gabagaba@info.com', 'Umberto', 'de Cazale', '123 shapopo', 'MALE', '0001-01-01', 1, 0, '54770.png', 0, ' designing the best and most cutting edge clothing in all of west Mordor ', 'http://www.google.com', 0, NULL, 0),
(3, 'boss@Boss.com', 'Boss', 'Bossss', 'Boss lane boss city', 'FEMALE', '1990-01-01', 0, 1, '', 100, '', '', 0, NULL, 0),
(4, 'user1@suityou.com', 'user', 'one', 'aa', 'MALE', '2015-06-01', 0, 0, '', 0, NULL, NULL, 0, NULL, 0),
(5, 'user2@suityou.com', 'user', 'two', 'agf 2', 'FEMALE', '0001-01-01', 0, 0, '', 10, NULL, NULL, 0, NULL, 0),
(6, 'user3@suityou.com', 'user', 'three', 'aa', 'MALE', '2015-06-01', 0, 0, '', 0, NULL, NULL, 0, NULL, 0),
(7, 'user4@suityou.com', 'user', 'four', 'agf 2', 'FEMALE', '0000-00-00', 0, 0, '', 0, NULL, NULL, 0, NULL, 0),
(8, 'hishi@suityou.jp', 'Hideko', 'Shinji', 'waka 14 JP', 'MALE', '0000-00-00', 1, 0, '', 0, NULL, 'http://japan.com', 0, NULL, 0),
(9, 'clarasmith@suityou.co.uk', 'Clara', 'Smith', 'blabla 14 London, UK', 'FEMALE', '0000-00-00', 1, 0, '', 0, NULL, 'http://www.gmail.com', 0, NULL, 0),
(10, 'mzaltzman@gmail.com', 'Riku', 'Zaltzman', 'TAU, Tel-Aviv', 'MALE', '0000-00-00', 0, 1, '', 0, NULL, 'http://japan.com', 0, NULL, 0),
(11, 'amabir@gmail.com', 'Amit', 'Abir', 'TAU, Tel-Aviv', 'MALE', '0000-00-00', 0, 1, '', 0, NULL, 'http://www.gmail.com', 0, NULL, 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
