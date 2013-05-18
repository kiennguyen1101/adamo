-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2012 at 07:48 AM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hybrid01_auctiontest`
--

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_abuses`
--

DROP TABLE IF EXISTS `myphpauction_abuses`;
CREATE TABLE IF NOT EXISTS `myphpauction_abuses` (
  `abuse_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `abuser_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `auction_id` int(11) NOT NULL,
  PRIMARY KEY (`abuse_id`),
  KEY `reg_date` (`reg_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with abuse reports' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_admins`
--

DROP TABLE IF EXISTS `myphpauction_admins`;
CREATE TABLE IF NOT EXISTS `myphpauction_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `date_lastlogin` int(11) NOT NULL DEFAULT '0',
  `level` enum('1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with admin info' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `myphpauction_admins`
--

INSERT INTO `myphpauction_admins` (`id`, `username`, `password`, `date_created`, `date_lastlogin`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1337852768, 1339678103, '1');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_admin_notes`
--

DROP TABLE IF EXISTS `myphpauction_admin_notes`;
CREATE TABLE IF NOT EXISTS `myphpauction_admin_notes` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_adverts`
--

DROP TABLE IF EXISTS `myphpauction_adverts`;
CREATE TABLE IF NOT EXISTS `myphpauction_adverts` (
  `advert_id` int(11) NOT NULL AUTO_INCREMENT,
  `advert_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `views` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `advert_img_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `advert_alt_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `advert_text_under` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `views_purchased` int(11) NOT NULL DEFAULT '0',
  `clicks_purchased` int(11) NOT NULL DEFAULT '0',
  `advert_categories` text COLLATE utf8_unicode_ci NOT NULL,
  `advert_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `advert_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `advert_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`advert_id`),
  KEY `views` (`views`,`clicks`,`views_purchased`,`clicks_purchased`,`advert_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with banners data' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auctions`
--

DROP TABLE IF EXISTS `myphpauction_auctions`;
CREATE TABLE IF NOT EXISTS `myphpauction_auctions` (
  `auction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `picpath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `quantity` smallint(6) NOT NULL DEFAULT '0',
  `auction_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_price` double(16,2) NOT NULL DEFAULT '0.00',
  `reserve_price` double(16,2) NOT NULL DEFAULT '0.00',
  `buyout_price` double(16,2) NOT NULL DEFAULT '0.00',
  `bid_increment_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `duration` smallint(6) NOT NULL DEFAULT '0',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shipping_method` tinyint(4) NOT NULL DEFAULT '0',
  `shipping_int` tinyint(4) NOT NULL DEFAULT '0',
  `payment_methods` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_time_old` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time_old` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `nb_bids` int(11) NOT NULL DEFAULT '0',
  `max_bid` double(16,2) NOT NULL DEFAULT '0.00',
  `nb_clicks` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `hpfeat` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat` tinyint(4) NOT NULL DEFAULT '0',
  `bold` tinyint(4) NOT NULL DEFAULT '0',
  `hl` tinyint(4) NOT NULL DEFAULT '0',
  `hidden_bidding` tinyint(4) NOT NULL DEFAULT '0',
  `currency` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `auction_swapped` tinyint(4) NOT NULL DEFAULT '0',
  `postage_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `insurance_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `type_service` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enable_swap` tinyint(4) NOT NULL DEFAULT '0',
  `direct_payment_paid` tinyint(4) NOT NULL DEFAULT '0',
  `addl_category_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shipping_details` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `hpfeat_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `reserve_offer` double(16,2) NOT NULL DEFAULT '0.00',
  `reserve_offer_winner_id` int(11) NOT NULL DEFAULT '0',
  `list_in` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'auction',
  `close_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `bid_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `bank_details` text COLLATE utf8_unicode_ci,
  `direct_payment` text COLLATE utf8_unicode_ci,
  `apply_tax` tinyint(4) NOT NULL DEFAULT '0',
  `auto_relist_bids` tinyint(4) NOT NULL DEFAULT '0',
  `end_time_type` enum('duration','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'duration',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `count_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `listing_type` enum('full','quick','buy_out') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'full',
  `is_offer` tinyint(4) NOT NULL DEFAULT '0',
  `offer_min` double(16,2) NOT NULL DEFAULT '0.00',
  `offer_max` double(16,2) NOT NULL DEFAULT '0.00',
  `auto_relist_nb` tinyint(4) NOT NULL DEFAULT '0',
  `is_relisted_item` tinyint(4) NOT NULL DEFAULT '0',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `creation_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `creation_date` int(11) NOT NULL DEFAULT '0',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_time_type` enum('now','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'now',
  `retract_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `notif_item_relisted` tinyint(4) NOT NULL,
  `is_draft` tinyint(4) NOT NULL,
  `nb_offers` int(11) NOT NULL,
  PRIMARY KEY (`auction_id`),
  KEY `stats_drafts` (`is_draft`,`owner_id`),
  KEY `user_auctions` (`owner_id`,`closed`,`deleted`,`creation_in_progress`,`is_draft`),
  KEY `mb_auctions_id` (`deleted`,`owner_id`,`closed`,`creation_in_progress`,`auction_id`),
  KEY `user_auctions_end_time` (`closed`,`owner_id`,`end_time`,`deleted`,`creation_in_progress`,`is_draft`),
  KEY `auctions_start_time` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`start_time`),
  KEY `auctions_nb_bids` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`nb_bids`),
  KEY `auctions_max_bid` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`max_bid`),
  KEY `auctions_start_price` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`start_price`),
  KEY `auctions_name` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`name`),
  KEY `auctions_end_time` (`active`,`approved`,`deleted`,`closed`,`creation_in_progress`,`end_time`),
  KEY `hp_featured` (`hpfeat`,`active`,`approved`,`closed`,`creation_in_progress`,`deleted`),
  KEY `cat_featured` (`catfeat`,`active`,`approved`,`closed`,`creation_in_progress`,`deleted`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `zip_code` (`zip_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 COMMENT='Table with auctions details' AUTO_INCREMENT=100004 ;

--
-- Dumping data for table `myphpauction_auctions`
--

INSERT INTO `myphpauction_auctions` (`auction_id`, `name`, `description`, `picpath`, `quantity`, `auction_type`, `start_price`, `reserve_price`, `buyout_price`, `bid_increment_amount`, `duration`, `country`, `zip_code`, `shipping_method`, `shipping_int`, `payment_methods`, `category_id`, `active`, `payment_status`, `start_time_old`, `end_time_old`, `closed`, `nb_bids`, `max_bid`, `nb_clicks`, `owner_id`, `hpfeat`, `catfeat`, `bold`, `hl`, `hidden_bidding`, `currency`, `auction_swapped`, `postage_amount`, `insurance_amount`, `type_service`, `enable_swap`, `direct_payment_paid`, `addl_category_id`, `deleted`, `live_pm_amount`, `live_pm_date`, `live_pm_processor`, `shipping_details`, `hpfeat_desc`, `reserve_offer`, `reserve_offer_winner_id`, `list_in`, `close_in_progress`, `bid_in_progress`, `bank_details`, `direct_payment`, `apply_tax`, `auto_relist_bids`, `end_time_type`, `approved`, `count_in_progress`, `listing_type`, `is_offer`, `offer_min`, `offer_max`, `auto_relist_nb`, `is_relisted_item`, `start_time`, `end_time`, `creation_in_progress`, `creation_date`, `state`, `start_time_type`, `retract_in_progress`, `notif_item_relisted`, `is_draft`, `nb_offers`) VALUES
(100001, 'Best Collection', 'The best collection for boys&lt;br&gt;', '', 1, 'standard', 1.00, 0.00, 0.00, 0.00, 1, '1966', '40115', 1, 1, '10', 490, 1, 'confirmed', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0.00, 34, 100001, 0, 0, 0, 0, 0, 'USD', 0, 0.00, 0.00, 'Airmail', 0, 0, 0, 0, 1.10, 1337854014, 'Test Mode', '', '', 0.00, 0, 'auction', 0, 0, NULL, '8', 0, 0, 'duration', 1, 0, 'full', 0, 0.00, 0.00, 0, 0, 1337853953, 1337940353, 0, 1337853672, 'Bandung', 'now', 0, 0, 0, 0),
(100002, 'Adsense website', 'Ready made adsense website, full script', '', 1, 'standard', 5.00, 0.00, 0.00, 0.00, 2, '2083', 'np264jp', 2, 1, '', 1778, 1, 'confirmed', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0.00, 6, 100002, 0, 0, 0, 0, 0, 'USD', 0, 0.00, 0.00, 'Other', 0, 0, 1032, 0, 2.38, 1338430592, 'Test Mode', 'free shipping , instant download', '', 0.00, 0, 'auction', 0, 0, NULL, '1', 0, 0, 'duration', 1, 0, 'quick', 0, 0.00, 0.00, 0, 0, 1338430530, 1338603330, 0, 1338430215, '2196', 'now', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auction_durations`
--

DROP TABLE IF EXISTS `myphpauction_auction_durations`;
CREATE TABLE IF NOT EXISTS `myphpauction_auction_durations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL DEFAULT '0',
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with auction durations' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `myphpauction_auction_durations`
--

INSERT INTO `myphpauction_auction_durations` (`id`, `days`, `description`) VALUES
(1, 1, '1 day'),
(2, 2, '2 days'),
(3, 7, '1 week'),
(4, 14, '2 weeks'),
(5, 28, '1 Month'),
(6, 56, '2 Months');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auction_media`
--

DROP TABLE IF EXISTS `myphpauction_auction_media`;
CREATE TABLE IF NOT EXISTS `myphpauction_auction_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `media_type` tinyint(4) NOT NULL DEFAULT '0',
  `upload_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `wanted_ad_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`media_id`),
  KEY `select_media_simple` (`auction_id`,`upload_in_progress`),
  KEY `select_wa_media_simple` (`wanted_ad_id`,`upload_in_progress`),
  KEY `select_media_advanced` (`auction_id`,`media_type`,`upload_in_progress`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with auction media details' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `myphpauction_auction_media`
--

INSERT INTO `myphpauction_auction_media` (`media_id`, `media_url`, `auction_id`, `media_type`, `upload_in_progress`, `wanted_ad_id`) VALUES
(1, 'uplimg/img_100001_f29dbe456af98c821d91d9a61ac4b4a0.jpg', 100001, 1, 0, 0),
(2, 'uplimg/img_100002_1496e764b048bfec3dd6c00fb2dad5dd.png', 100002, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auction_offers`
--

DROP TABLE IF EXISTS `myphpauction_auction_offers`;
CREATE TABLE IF NOT EXISTS `myphpauction_auction_offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `buyer_id` int(11) NOT NULL DEFAULT '0',
  `seller_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`offer_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auction_rollbacks`
--

DROP TABLE IF EXISTS `myphpauction_auction_rollbacks`;
CREATE TABLE IF NOT EXISTS `myphpauction_auction_rollbacks` (
  `rollback_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `start_price` double(16,2) NOT NULL DEFAULT '0.00',
  `reserve_price` double(16,2) NOT NULL DEFAULT '0.00',
  `buyout_price` double(16,2) NOT NULL DEFAULT '0.00',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hpfeat` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat` tinyint(4) NOT NULL DEFAULT '0',
  `bold` tinyint(4) NOT NULL DEFAULT '0',
  `hl` tinyint(4) NOT NULL DEFAULT '0',
  `addl_category_id` int(11) NOT NULL DEFAULT '0',
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  `nb_images` int(11) NOT NULL DEFAULT '0',
  `nb_videos` int(11) NOT NULL DEFAULT '0',
  `is_offer` tinyint(4) NOT NULL,
  PRIMARY KEY (`rollback_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_auction_watch`
--

DROP TABLE IF EXISTS `myphpauction_auction_watch`;
CREATE TABLE IF NOT EXISTS `myphpauction_auction_watch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `auction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table for Items Watching' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_banned`
--

DROP TABLE IF EXISTS `myphpauction_banned`;
CREATE TABLE IF NOT EXISTS `myphpauction_banned` (
  `banned_id` int(11) NOT NULL AUTO_INCREMENT,
  `banned_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banned_id`),
  KEY `address_type` (`address_type`),
  FULLTEXT KEY `banned_address` (`banned_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_bids`
--

DROP TABLE IF EXISTS `myphpauction_bids`;
CREATE TABLE IF NOT EXISTS `myphpauction_bids` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `bidder_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `bid_date` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `bid_proxy` double(16,2) NOT NULL DEFAULT '0.00',
  `bid_out` tinyint(4) NOT NULL DEFAULT '0',
  `bid_invalid` tinyint(4) NOT NULL DEFAULT '0',
  `email_sent` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `rp_winner` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid_id`),
  KEY `auction_id` (`auction_id`),
  KEY `high_bids` (`auction_id`,`bid_amount`),
  KEY `bid_types` (`auction_id`,`bid_out`,`bid_invalid`),
  KEY `auction_bids` (`auction_id`,`bidder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with bids' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_bid_increments`
--

DROP TABLE IF EXISTS `myphpauction_bid_increments`;
CREATE TABLE IF NOT EXISTS `myphpauction_bid_increments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_from` double(16,2) NOT NULL DEFAULT '0.00',
  `value_to` double(16,2) NOT NULL DEFAULT '0.00',
  `increment` double(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `value_from` (`value_from`,`value_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with bid increments' AUTO_INCREMENT=150 ;

--
-- Dumping data for table `myphpauction_bid_increments`
--

INSERT INTO `myphpauction_bid_increments` (`id`, `value_from`, `value_to`, `increment`) VALUES
(102, 0.00, 1.00, 0.02),
(103, 1.00, 3.00, 0.05),
(104, 3.00, 10.00, 2.00),
(105, 10.00, 50.00, 5.00),
(106, 50.00, 500.00, 15.00),
(107, 500.00, 10000.00, 50.00),
(108, 10000.00, 10000000.00, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_blocked_domains`
--

DROP TABLE IF EXISTS `myphpauction_blocked_domains`;
CREATE TABLE IF NOT EXISTS `myphpauction_blocked_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with blocked email domains' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_blocked_users`
--

DROP TABLE IF EXISTS `myphpauction_blocked_users`;
CREATE TABLE IF NOT EXISTS `myphpauction_blocked_users` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `block_reason` text COLLATE utf8_unicode_ci NOT NULL,
  `show_reason` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`block_id`),
  KEY `block_src` (`user_id`,`owner_id`),
  KEY `reg_src` (`owner_id`,`reg_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_bulktmp`
--

DROP TABLE IF EXISTS `myphpauction_bulktmp`;
CREATE TABLE IF NOT EXISTS `myphpauction_bulktmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `desc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `auctiontype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usereserve` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reserve` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usebuynow` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `buynow` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `useinc` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inc` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `duration` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `whopays` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shipinter` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `paymethods` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `homefeat` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `catfeat` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bold` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `highlight` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `private` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `currency` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `postcosts` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `insurance` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `service` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `allowswap` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `accdirect` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `directemail` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hasimage` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pictures` longtext COLLATE utf8_unicode_ci NOT NULL,
  `haswebimage` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `webimages` longtext COLLATE utf8_unicode_ci NOT NULL,
  `homefeatdesc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `postnote` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `areaid` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `voucher` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `auctionstore` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'auction',
  `paypalbuyers` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `catsubfieldid1` int(11) NOT NULL DEFAULT '0',
  `catsubfieldval1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `catsubfieldid2` int(11) NOT NULL DEFAULT '0',
  `catsubfieldval2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `catsubfieldid3` int(11) NOT NULL DEFAULT '0',
  `catsubfieldval3` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `catsubfieldid4` int(11) NOT NULL DEFAULT '0',
  `catsubfieldval4` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `catsubfieldid5` int(11) NOT NULL DEFAULT '0',
  `catsubfieldval5` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_categories`
--

DROP TABLE IF EXISTS `myphpauction_categories`;
CREATE TABLE IF NOT EXISTS `myphpauction_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `items_counter` int(11) NOT NULL DEFAULT '0',
  `hover_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wanted_counter` int(11) NOT NULL DEFAULT '0',
  `is_subcat` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `custom_fees` tinyint(4) NOT NULL DEFAULT '0',
  `minimum_age` tinyint(4) NOT NULL,
  `custom_skin` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`),
  KEY `parent_id_2` (`parent_id`,`order_id`,`name`),
  KEY `parent_id_3` (`parent_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with categories' AUTO_INCREMENT=1866 ;

--
-- Dumping data for table `myphpauction_categories`
--

INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(156, 57, 'PC Games', 10007, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(160, 156, 'Children&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(159, 156, 'Board Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(158, 156, 'Arcade', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(167, 156, 'Simulation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(166, 156, 'Shoot-Em-Up', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(165, 156, 'Roleplaying', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(164, 156, 'Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(163, 156, 'Puzzle', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(162, 156, 'Platform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(161, 156, 'Fighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(157, 156, 'Action/Adventure', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(57, 0, 'Gaming', 12, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(58, 57, 'Sony Playstation 2', 10010, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(59, 57, 'Sony Playstation 1', 10009, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(60, 59, 'Games', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(61, 59, 'Consoles', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(62, 59, 'Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(63, 58, 'Games', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(64, 58, 'Consoles', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(65, 58, 'Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(66, 63, 'Action', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(67, 63, 'Fighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(68, 63, 'Platform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(69, 63, 'Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(70, 63, 'Roleplaying', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(71, 63, 'Shoot-Em-Up', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(72, 63, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(73, 63, 'Strategy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(74, 63, 'Other Playstation 2 Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(75, 65, 'Magazines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(76, 65, 'Walkthrough/Guides', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(77, 65, 'Models/Figures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(78, 65, 'Other Playstation 2 Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(79, 64, 'PAL Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(80, 64, 'Japanese Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(81, 64, 'USA Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(82, 64, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(83, 62, 'Walkthrough/Guides', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(84, 62, 'Magazines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(85, 62, 'Other Playstation 1 Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(86, 62, 'Control Pads', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(87, 62, 'Memory Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(88, 62, 'Steering Wheels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(89, 62, 'Joysticks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(96, 60, 'Action', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(91, 62, 'Models Figures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(92, 65, 'Control Pads', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(93, 65, 'Memory Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(94, 65, 'Steering Wheels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(95, 65, 'Joysticks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(97, 60, 'Fighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(98, 60, 'Platform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(99, 60, 'Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(100, 60, 'Roleplaying', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(102, 60, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(103, 60, 'Strategy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(104, 60, 'Other Playstation 1 Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(105, 61, 'Pal Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(106, 61, 'Japanese Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(107, 61, 'USA Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(108, 61, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(109, 57, 'Arcade Machines', 10000, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(110, 109, 'Pinball Machines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(111, 109, 'Video Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(112, 109, 'Other Arcade Machines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(113, 57, 'Classic Gaming', 10001, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(114, 113, 'Atari Jaguar', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(115, 113, 'Atari Lynx', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(116, 113, 'NES', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(117, 113, 'SEGA Game Gear', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(118, 113, 'SEGA Mega Drive', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(119, 113, 'SEGA Master System', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(120, 113, 'SEGA Saturn', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(122, 113, 'Super Nintendo', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(123, 113, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(137, 57, 'Merchandise & Magazines', 10002, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(129, 57, 'Nintendo Gameboy Colour', 10005, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(130, 129, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(131, 129, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(132, 129, 'Systems', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(133, 57, 'Nintendo Gamecube', 10006, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(134, 133, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(135, 133, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(136, 133, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(138, 137, 'Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(139, 137, 'Guides', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(140, 137, 'Magazines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(141, 137, 'Models & Figures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(142, 137, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(143, 57, 'Nintendo 64', 10003, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(144, 143, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(145, 143, 'Games', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(146, 143, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(147, 145, 'Action', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(148, 145, 'Fighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(149, 145, 'Platform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(150, 145, 'Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(151, 145, 'Roleplaying', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(152, 145, 'Shoot-Em-Up', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(153, 145, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(154, 145, 'Strategy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(155, 145, 'Other Nintendo 64 Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(168, 156, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(169, 156, 'Strategy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(170, 156, 'Other PC Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(171, 114, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(172, 114, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(173, 114, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(174, 115, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(175, 115, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(176, 115, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(177, 116, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(178, 116, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(179, 116, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(180, 117, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(181, 117, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(182, 117, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(183, 119, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(184, 119, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(185, 119, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(186, 118, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(187, 118, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(188, 118, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(189, 120, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(190, 120, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(191, 120, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(195, 122, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(196, 122, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(197, 122, 'Consoles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(198, 57, 'SEGA Dreamcast', 10008, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(199, 198, 'Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(200, 198, 'Games', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(201, 198, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(202, 200, 'Action', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(203, 200, 'Fighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(204, 200, 'Platform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(205, 200, 'Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(206, 200, 'Roleplaying', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(207, 200, 'Shoot-Em-Up', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(208, 200, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(209, 200, 'Strategy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(210, 200, 'Other SEGA Dreamcast Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(211, 199, 'Control Pads', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(212, 199, 'VMU&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(213, 199, 'Other Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(215, 0, 'Antiques &amp; Art', 1, 0, 0, '', '', '', '', 1, '>', 0, 0, 0, ''),
(216, 215, '20th Century Antiques', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(217, 216, '1920&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(218, 216, '1930&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(219, 216, '1940&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(220, 216, '1950&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(221, 216, '1960&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(222, 216, '1970&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(223, 216, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(224, 216, 'Modern', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(225, 215, 'Antiquities', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(226, 215, 'Architectural', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(227, 226, 'Garden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(228, 226, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(229, 215, 'Art', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(230, 229, 'Contemporary Art', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(231, 229, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(232, 229, 'Drawings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(233, 229, 'Paintings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(234, 229, 'Photographic Images', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(235, 229, 'Prints', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(236, 229, 'Sculptures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(237, 229, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(238, 215, 'Books/Manuscripts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(239, 215, 'Ceramics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(240, 215, 'Clocks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(241, 215, 'Decorative Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(242, 215, 'Folk Art', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(243, 215, 'Furniture', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(244, 215, 'Maps/Atlases', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(245, 215, 'Metalware', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(246, 245, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(247, 245, 'Brass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(248, 245, 'Bronze', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(249, 245, 'Copper', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(250, 245, 'Gold', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(251, 245, 'Pewter', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(253, 245, 'Silver Plated', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(254, 245, 'Musical Instruments', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(255, 215, 'Foreign Art', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(256, 215, 'Textiles/Linens', 0, 0, 0, '', '', '', '', 1, '>', 0, 0, 0, ''),
(257, 256, 'Embroidery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(258, 256, 'Fabric', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(259, 256, 'Linens', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(260, 256, 'Quilts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(261, 256, 'Other', 0, 0, 0, '', '', '', '', 1, '', 0, 0, 0, ''),
(262, 215, 'Woodenware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(263, 0, 'Automobiles &amp; Bikes', 2, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(264, 263, 'Cars', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(265, 264, 'Alfa Romeo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(266, 264, 'Audi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(267, 264, 'BMW', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(268, 264, 'Citroen', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(269, 264, 'Chrysler & Jeep', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(270, 264, 'Daewoo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(271, 264, 'Fiat', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(272, 264, 'Ford', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(273, 264, 'Honda', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(274, 264, 'Hyundai', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(275, 264, 'Jaguar', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(276, 264, 'Land Rover', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(277, 264, 'Mazda', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(278, 264, 'Mercedes Benz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(279, 264, 'Nissan', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(280, 264, 'Mitsubishi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(281, 264, 'Porsche', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(282, 264, 'Peugeot', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(283, 264, 'Range Rover', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(284, 264, 'Renault', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(285, 264, 'Rover', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(286, 264, 'MG', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(287, 264, 'Saab', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(288, 264, 'Seat', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(289, 264, 'Subaru', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(290, 264, 'Suzuki', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(291, 264, 'Toyota', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(292, 264, 'Vauxhall & Opel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(293, 264, 'Volkswagen', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(294, 264, 'Volvo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(295, 264, 'Kit Cars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(296, 264, 'Import', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(297, 264, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(298, 263, 'Car Accessories', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(299, 298, 'Car Care', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(300, 298, 'Garage Equipment & Tools', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(301, 298, 'Exterior Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(302, 298, 'Interior Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(303, 298, 'Performance & Tuning Itmes', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(304, 298, 'Lights & Lighting Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(305, 298, 'Manuals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(306, 298, 'Security Itmes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(307, 298, 'Wheel, Tyres & Trims', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(308, 298, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(309, 263, 'Car Navigation/Electricals', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(310, 309, 'Satellite Navigation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(311, 309, 'In Car DVD', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(312, 309, 'In Car Gaming', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(313, 309, 'In Car TV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(314, 309, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(315, 263, 'Audio Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(316, 315, 'Amplifiers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(317, 315, 'Cassette Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(318, 315, 'CD Changers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(319, 315, 'CD Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(320, 315, 'Speakers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(321, 315, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(322, 263, 'Classic Cars', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(323, 322, 'Alfa Romeo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(324, 322, 'American', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(325, 322, 'Austin', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(326, 322, 'BMW', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(327, 322, 'Daimler', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(328, 322, 'Ford', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(329, 322, 'Jaguar', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(330, 322, 'Lotus', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(331, 322, 'Mercedes Benz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(332, 322, 'MG', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(333, 322, 'Porsche', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(334, 322, 'Rover', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(335, 322, 'Triumph', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(336, 322, 'Volkswagen', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(337, 322, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(338, 263, 'Motorbikes', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(339, 338, 'BMW', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(340, 338, 'Ducati', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(341, 338, 'Harley Davidson', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(342, 338, 'Honda', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(343, 338, 'Kawasaki', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(344, 338, 'Suzuki', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(345, 338, 'Yamaha', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(346, 338, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(347, 263, 'Car Numberplates', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(348, 263, 'Other Vehicles', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(349, 348, 'Boats & Watercraft', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(350, 348, 'Campers & Caravans', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(351, 348, 'Commercial Vehicles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(352, 348, 'Disabled Vehicles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(353, 348, 'Trailers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(354, 348, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(355, 0, 'Books', 3, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(356, 355, 'Annuals', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(357, 356, 'Beano', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(358, 356, 'Blue Peter', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(359, 356, 'Bunty', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(360, 356, 'Dandy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(361, 356, 'Dr Who', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(362, 356, 'Roy Of The Rovers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(363, 356, 'Shoot', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(364, 356, 'Star Trek', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(365, 356, 'TV & Film', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(366, 356, 'Viz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(367, 356, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(368, 355, 'Rare Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(369, 368, 'Exploration & Travel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(370, 368, 'Literature', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(371, 368, 'History', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(372, 368, 'Motoring', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(373, 368, 'Religion', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(374, 368, 'War/Military', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(375, 368, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(376, 355, 'Audio Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(377, 376, 'CD&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(378, 376, 'Tapes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(379, 355, 'Children Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(380, 379, 'Classics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(381, 379, 'Colouring Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(382, 379, 'Early Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(383, 379, 'Fairy Tales', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(384, 379, 'Ladybird', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(385, 379, 'Non Fiction', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(386, 379, 'Picture Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(387, 379, 'Pop-Up Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(388, 379, 'Teenage Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(389, 379, 'School Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(390, 379, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(391, 355, 'Cookery Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(392, 391, 'Baking', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(393, 391, 'Learning To Cook', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(394, 391, 'Healthy Cooking', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(395, 391, 'Traditional', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(396, 391, 'Vegetarian', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(397, 391, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(398, 355, 'Educational Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(399, 398, 'Business & Finance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(400, 398, 'Computing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(401, 398, 'Internet', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(402, 398, 'Design & Technology', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(403, 398, 'Drama & Media', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(404, 398, 'Health', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(405, 398, 'History', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(406, 398, 'Politics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(407, 398, 'Language', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(408, 398, 'Legal & Law', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(409, 398, 'Maths', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(410, 398, 'Psychology', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(411, 398, 'Self Help', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(412, 398, 'Sports Science', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(413, 398, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(414, 355, 'Fiction', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(415, 414, 'Adventure', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(416, 414, 'Fantasy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(417, 414, 'Horror', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(418, 414, 'Humour', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(419, 414, 'Military', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(420, 414, 'Mystery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(421, 414, 'Plays, Screen Plays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(422, 414, 'Romance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(423, 414, 'Sci-Fi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(424, 414, 'Thriller', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(425, 414, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(426, 355, 'Magazines', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(427, 426, 'Aviation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(428, 426, 'Boating & Sailing', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(429, 426, 'Cars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(430, 426, 'Celebrity', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(431, 426, 'Children', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(432, 426, 'Collector', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(433, 426, 'Computer', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(434, 426, 'Cooking', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(435, 426, 'Hobby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(436, 426, 'Health & Fitness', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(437, 426, 'Home & Garden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(438, 426, 'Horror', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(439, 426, 'Men', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(440, 426, 'Movies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(441, 426, 'TV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(442, 426, 'Music', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(443, 426, 'National Geographic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(444, 426, 'Nature', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(445, 426, 'News', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(446, 426, 'Photography', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(447, 426, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(448, 426, 'Travel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(449, 426, 'True Crime', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(450, 426, 'Women', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(451, 426, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(452, 355, 'Non Fiction', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(453, 452, 'Collectables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(454, 452, 'Entertainment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(455, 452, 'Gardening', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(456, 452, 'Feng Shui', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(457, 452, 'Geography', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(458, 452, 'History', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(459, 452, 'Home & Garden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(460, 452, 'Military', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(461, 452, 'Motoring', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(462, 452, 'Nature', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(463, 452, 'Paranormal', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(464, 452, 'Parenting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(465, 452, 'Pets & Pet Care', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(466, 452, 'Religon', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(467, 452, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(468, 452, 'Travel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(469, 452, 'Crime', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(470, 452, 'TV & Film', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(471, 452, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(472, 355, 'Poetry', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(473, 355, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(474, 0, 'Clothing &amp; Accessories', 5, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(475, 474, 'Fancy Dress', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(476, 475, 'Children', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(477, 475, 'Adult', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(478, 474, 'Boys', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(479, 478, '2-5 Year Olds', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(480, 479, 'Tops', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(481, 479, 'Bottoms', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(493, 491, '2-5 Year Olds', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(492, 478, '6-8 Year Olds', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(485, 478, '9+ Year Olds', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(486, 485, 'Tops', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(487, 485, 'Bottoms', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(488, 478, 'School Uniform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(489, 478, 'Shoes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(490, 478, 'Teenagers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(491, 474, 'Girls', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(494, 493, 'Bottoms', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(495, 493, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(496, 493, 'Skirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(497, 493, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(498, 491, '6-8 Year Olds', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(499, 498, 'Bottoms', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(500, 498, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(501, 498, 'Skirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(502, 498, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(503, 491, '9+ Years Old', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(504, 503, 'Bottoms', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(505, 503, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(506, 503, 'Skirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(507, 503, 'Others', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(508, 491, 'School Uniform', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(509, 491, 'Shoes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(510, 491, 'Teenagers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(511, 474, 'Men&#039;s Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(512, 511, 'Bags, Belts, Wallets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(513, 511, 'Hats', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(514, 511, 'Sunglasses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(515, 511, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(516, 474, 'Men&#039;s Casualwear', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(517, 516, 'Casual Shirts', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(518, 516, 'Denim', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(519, 517, 'Ben Sherman', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(520, 517, 'Burberry', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(521, 517, 'French Connection', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(522, 517, 'Ralph Lauren', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(523, 517, 'Ted Baker', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(524, 517, 'YSL', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(525, 517, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(526, 518, 'Armani', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(527, 518, 'Diesel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(528, 518, 'GAP', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(529, 518, 'Lee', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(530, 518, 'Levis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(531, 518, 'Wrangler', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(532, 518, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(533, 516, 'T-Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(534, 516, 'Trousers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(535, 516, 'Coats & Jackets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(539, 474, 'Men&#039;s Footwear', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(538, 516, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(540, 539, 'Boots', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(541, 539, 'Loafers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(542, 539, 'Formal Shoes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(543, 539, 'Sports Shoes', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(544, 539, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(545, 474, 'Men&#039;s Workwear', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(546, 545, 'Formal Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(547, 545, 'Suits', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(548, 545, 'Ties', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(549, 545, 'Trousers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(550, 474, 'Personal Care', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(551, 550, 'Body', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(552, 550, 'Face', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(553, 550, 'Hair', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(554, 550, 'Eyes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(555, 550, 'Lips', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(556, 550, 'Other Make Up Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(557, 550, 'Men&#039;s Fragrance', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(558, 550, 'Men&#039;s Personal Care', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(559, 550, 'Women&#039;s Fragrance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(561, 474, 'Women&#039;s Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(562, 561, 'Belts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(563, 561, 'Gloves', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(564, 561, 'Pashmina & Scarves', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(565, 561, 'Sunglasses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(566, 561, 'Wigs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(567, 561, 'Other Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(568, 474, 'Women&#039;s Bags', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(569, 568, 'Handbag', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(570, 569, 'Burberry', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(571, 569, 'Gucci', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(572, 569, 'Louis Vuitton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(573, 569, 'Prada', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(574, 569, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(575, 568, 'Shoulderbag', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(576, 575, 'Louis Vuitton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(577, 575, 'Burberry', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(578, 575, 'Gucci', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(579, 575, 'Prada', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(580, 575, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(581, 568, 'Shopping Bags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(582, 568, 'Wallets and Purses', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(583, 582, 'Burberry', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(584, 582, 'Accessorize', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(585, 582, 'Gucci', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(586, 582, 'Prada', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(587, 582, 'Next', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(588, 582, 'Louis Vuitton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(589, 582, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(590, 474, 'Women&#039;s Casualwear', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(591, 590, 'Denim', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(592, 591, 'Diesel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(593, 591, 'Calvin Klein', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(594, 591, 'Levis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(595, 591, 'Top Shop', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(596, 591, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(597, 590, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(598, 590, 'Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(599, 590, 'Shorts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(600, 590, 'Skirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(601, 590, 'T-Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(602, 590, 'Tops', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(603, 590, 'Trousers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(604, 590, 'Lingerie & Sleepwear', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(605, 590, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(606, 474, 'Women&#039;s Eveningwear', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(607, 606, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(608, 606, 'Skirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(609, 606, 'Suits', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(610, 606, 'Tops', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(611, 606, 'Trousers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(612, 606, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(613, 474, 'Women&#039;s Workwear', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(614, 613, 'Dresses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(615, 613, 'Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(616, 613, 'Tops', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(617, 613, 'Trousers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(618, 613, 'Suits', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(619, 613, 'Jackets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(620, 474, 'Women&#039;s Coats & Jackets', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(621, 620, 'Leather', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(622, 620, 'Suede', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(623, 620, 'Wool', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(624, 620, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(626, 474, 'Women&#039;s Shoes', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(627, 626, 'Sports Shoes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(628, 626, 'Boots', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(629, 626, 'Flats', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(630, 626, 'Heels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(631, 626, 'Mules', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(632, 626, 'Sandals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(633, 626, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(634, 0, 'Coins', 6, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(635, 634, 'British Coins', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(636, 634, 'World Coins', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(637, 634, 'UK Paper Money', 0, 0, 2, '', '', '', '', 0, '', 0, 0, 0, ''),
(638, 634, 'US Paper Money', 0, 0, 2, '', '', '', '', 0, '', 0, 0, 0, ''),
(639, 634, 'World Paper Money', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(640, 635, '1/2 Crown', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(641, 635, '1/2 Penny', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(642, 635, '2 Shilling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(643, 635, '2 Pence', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(644, 635, '3 Pence', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(645, 635, '4 Pence', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(646, 635, '6 Pence', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(647, 635, 'Collections', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(648, 635, 'Commemorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(649, 635, 'Gold', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(650, 635, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(651, 636, 'Ancient', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(652, 636, 'Europe', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(653, 636, 'Commemorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(654, 636, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(655, 639, 'Africa', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(656, 639, 'Asia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(657, 639, 'Australia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(658, 639, 'Canada', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(659, 639, 'China', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(660, 639, 'Europe', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(661, 639, 'France', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(662, 639, 'Germany', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(663, 639, 'Israel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(664, 639, 'Ireland', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(665, 639, 'Korea', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(666, 639, 'Mexico', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(667, 639, 'Russia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(668, 639, 'Sweeden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(669, 0, 'Collectables', 7, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(670, 669, 'Advertising', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(671, 670, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(672, 670, 'Aeronautica', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(673, 670, 'Bakery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(674, 670, 'Bus', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(675, 670, 'Confectionary', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(676, 670, 'Chemist', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(677, 670, 'Cigarette', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(678, 670, 'Dairy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(679, 670, 'Distillery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(680, 670, 'Fashion', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(681, 670, 'Food', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(682, 670, 'Labels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(683, 670, 'Petrol', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(684, 670, 'Radio', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(685, 670, 'Signs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(686, 670, 'Soft Drinks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(687, 670, 'Tins', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(688, 670, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(689, 669, 'Animals', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(690, 689, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(691, 689, 'Bird', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(692, 689, 'Cat', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(693, 689, 'Dog', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(694, 689, 'Dinosaur', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(695, 689, 'Fish', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(696, 689, 'Farm', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(697, 689, 'Horse', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(698, 689, 'Reptile', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(699, 689, 'Wildlife', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(700, 669, 'Art', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(701, 700, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(702, 700, 'Decorator/Designer', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(703, 700, 'Calendars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(704, 700, 'Paintings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(705, 700, 'Posters', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(706, 700, 'Prints', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(707, 669, 'Autographs', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(708, 707, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(709, 707, 'Political', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(710, 707, 'Sci-Fi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(711, 707, 'Space', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(712, 669, 'Badges', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(713, 669, 'Bears', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(714, 713, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(715, 713, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(716, 713, 'Antique', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(717, 713, 'Cherished Teddies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(718, 713, 'Merrythought', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(719, 713, 'Steiff', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(720, 669, 'Bottles', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(721, 720, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(722, 720, 'Household', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(723, 720, 'Inks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(724, 720, 'Medicines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(725, 720, 'Miniatures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(726, 720, 'Poisons', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(727, 720, 'Soft Drinks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(728, 720, 'Alcohol Bottles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(729, 669, 'Breweriana', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(730, 729, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(731, 729, 'Advertising', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(732, 729, 'Bottles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(733, 729, 'Beer Mats', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(734, 729, 'Openers, Corkscrews', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(735, 729, 'Trays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(736, 669, 'Casino', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(737, 736, 'Dice', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(738, 736, 'Chips', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(739, 736, 'Playing Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(740, 736, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(741, 736, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(742, 669, 'Clocks', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(743, 742, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(744, 742, 'Wall Clocks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(745, 742, 'Wristwatches', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(746, 742, 'Pocketwatches', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(747, 669, 'Clubs & Associations', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(748, 747, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(749, 747, 'Boy Scouts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(750, 747, 'Girl Scouts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(751, 747, 'Masonic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(752, 747, 'Salvation Army', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(753, 669, 'Plates', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(754, 753, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(755, 753, 'Danbury Mint', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(756, 753, 'Wedgwood', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(757, 753, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(758, 669, 'Comics', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(759, 758, 'Comic Figurines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(760, 758, 'Comic Magazines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(761, 758, 'Modern', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(762, 758, 'Newspaper Comics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(763, 758, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(764, 669, 'Decorative', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(765, 764, 'Hummel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(766, 764, 'Lilliput Lane', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(767, 764, 'Royal Doulton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(768, 764, 'Wedgwood', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(769, 764, 'Wade', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(770, 669, 'Flags', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(771, 770, 'Rest Of World Flags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(772, 770, 'UK Flags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(773, 770, 'European Flags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(774, 770, 'Club Flags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(775, 770, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(776, 669, 'Fridge Magnets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(777, 669, 'Jukeboxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(778, 669, 'Keyrings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(779, 669, 'Kitchenalia', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(780, 779, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(781, 779, 'Cookware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(782, 779, 'Egg Cups', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(783, 779, 'Salt & Pepper Pots', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(784, 779, 'Small Appliances', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(785, 779, 'Tableware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(786, 779, 'Utensils', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(787, 669, 'Knives', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(788, 787, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(789, 787, 'Commemorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(790, 787, 'Pocket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(791, 669, 'Limited Editions', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(792, 669, 'Memorabilia', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(793, 792, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(794, 792, 'Historical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(795, 792, 'Magic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(796, 792, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(797, 669, 'Metalware', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(798, 797, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(799, 797, 'Aluminium', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(800, 797, 'Brass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(801, 797, 'Bronze', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(802, 797, 'Cast Iron', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(803, 797, 'Copper', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(804, 797, 'Pewter', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(806, 797, 'Silver Plated', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(807, 669, 'Militaria', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(808, 807, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(809, 807, 'Ancient', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(810, 807, 'Pre World War 1', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(811, 807, 'World War 2', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(812, 807, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(813, 669, 'Moneyboxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(814, 669, 'Modern Maps & Atlases', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(815, 669, 'Music Boxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(816, 669, 'Political', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(817, 669, 'Religious', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(818, 669, 'Royal Commemoratives', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(819, 818, 'Coronation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(820, 818, 'Jubilee', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(821, 818, 'Prince William', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(822, 818, 'Weddings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(823, 818, 'Princess Diana', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(824, 818, 'Queen Mother', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(825, 818, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(826, 669, 'Science Fiction', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(827, 826, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(828, 826, 'Babylon 5', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(829, 826, 'Buffy the Vampire Slayer', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(830, 826, 'Dr. Who', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(831, 826, 'Planet of the Apes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(832, 826, 'Star Wars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(833, 826, 'Star Trek', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(834, 826, 'X Files', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(835, 826, 'Xena', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(836, 826, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(837, 669, 'Tobacco Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(838, 837, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(839, 837, 'Ashtrays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(840, 837, 'Cigarette Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(841, 837, 'Lighters and Vestas', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(842, 837, 'Pipes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(843, 669, 'Snowglobes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(844, 669, 'Souvenirs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(845, 669, 'Trading Cards & Stickers', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(846, 845, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(847, 845, 'Comic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(848, 845, 'Other Non Sport', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(849, 845, 'Phone Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(850, 845, 'Sci-Fi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(851, 845, 'Sports', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(852, 851, 'Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(853, 851, 'Rugby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(854, 851, 'American Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(855, 851, 'Basketball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(856, 851, 'Baseball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(857, 851, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(858, 669, 'Model Trains', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(859, 858, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(860, 858, 'Hornby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(861, 858, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(862, 669, 'Umbrellas', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(863, 669, 'Vanity Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(864, 863, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(865, 863, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(866, 863, 'Compacts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(867, 863, 'Perfumes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(868, 669, 'Wacky Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(869, 669, 'Writing Instruments', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(870, 869, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(871, 869, 'Pens', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(872, 869, 'Pencils', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(873, 869, 'Desktop Items', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(874, 869, 'Inkwells', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(875, 869, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(876, 869, 'Miscellaneous', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(877, 0, 'Computing', 8, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(878, 0, 'Services', 18, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(879, 878, 'Internet Services', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(880, 879, 'Domain Name Registration', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(881, 879, 'Web Hosting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(882, 879, 'Web Design', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(883, 878, 'Offline Service', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(884, 883, 'Printing Services', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(885, 883, 'Business Printing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(886, 883, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(887, 0, 'Businesses For Sale', 4, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(888, 887, 'Online Businesses', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(889, 887, 'Offline Businesses', 0, 0, 4, '', '', '', '', 0, '', 0, 0, 0, ''),
(890, 0, 'Properties', 17, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(891, 890, 'Private Houses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(892, 890, 'Commercial Property', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(893, 877, 'Books', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(894, 893, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(895, 893, 'Reference', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(896, 893, 'Software Manuals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(897, 877, 'Components', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(898, 897, 'Cables & Connectors', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(899, 897, 'CPU&#039;s', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(900, 899, 'AMD Athlon', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(901, 899, 'AMD Duron', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(902, 899, 'AMD K6', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(903, 899, 'AMD Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(904, 899, 'Intel Celeron', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(908, 899, 'Intel Pentium IV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(909, 899, 'Intel Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(910, 899, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(911, 897, 'Fans & Heatsinks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(912, 897, 'Graphics & Video Cards', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(913, 912, 'AGP Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(914, 912, 'PCI Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(915, 912, 'TV Cards', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(916, 915, 'AGP', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(917, 915, 'PCI', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(918, 912, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(919, 897, 'Input Peripherals', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(920, 919, 'Keyboards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(921, 919, 'Mice', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(922, 919, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(923, 919, 'Graphic Tablets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(924, 897, 'Memory', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(925, 924, 'EDO', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(926, 924, 'RAM', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(927, 924, 'SDRAM', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(928, 924, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(929, 897, 'Motherboards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(930, 897, 'Power Supplies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(931, 897, 'Storage Devices', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(932, 931, 'Hard Drives', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(933, 931, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(934, 897, 'Drives', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(936, 934, 'DVD-RW', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(937, 934, 'CD ROM', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(938, 934, 'Zip Drive', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(939, 934, 'Floppy Disk Drive', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(940, 934, 'CDRW', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(942, 934, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(943, 897, 'Sound Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(944, 897, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(960, 955, 'Dell', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(959, 955, 'HP', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(958, 955, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(957, 955, 'Advent', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(956, 955, 'Carry Cases & Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(955, 877, 'Laptops', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(961, 955, 'IBM', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(962, 955, 'Sony', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(963, 955, 'Compaq', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(964, 955, 'Toshiba', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(965, 877, 'Macintosh', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(966, 965, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(967, 965, 'i-Book', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(968, 965, '-Mac', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(969, 965, 'Powerbook', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(970, 965, 'Powermac', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(971, 965, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(972, 877, 'Networking', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(973, 972, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(974, 972, 'Mainframes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(975, 972, 'Networking', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(976, 972, 'Routers, Switches', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(977, 972, 'Servers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(978, 972, 'Racks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(979, 972, 'Terminals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(980, 972, 'Unix', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(981, 877, 'Other Hardware', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(982, 981, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(983, 877, 'PC Systems', 0, 0, 1, '', '', '', '', 0, '>', 0, 0, 0, ''),
(984, 983, 'AMD Athlon', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(985, 983, 'AMD Duron', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(986, 983, 'Intel 486', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(989, 983, 'Intel Pentium III', 0, 0, 1, '', '', '', '', 0, '', 0, 0, 0, ''),
(990, 983, 'Intel Pentium IV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(991, 983, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(992, 877, 'PDA&#039;s', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(993, 992, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(994, 992, 'Compaq', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(995, 992, 'Handspring', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(996, 992, 'Hewlett Packard', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(997, 992, 'Palm', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(998, 992, 'Psion', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(999, 992, 'Windows CE devices', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1000, 992, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1001, 877, 'Peripherals', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1002, 1001, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1003, 1001, 'Modems', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1004, 1003, 'External', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1005, 1003, 'Internal', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1006, 1001, 'Monitors', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1007, 1006, '16 Inch Or Smaller', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1008, 1006, '17 Inch', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1009, 1006, '19 Inch Or Larger', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1010, 1006, 'TFT', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1011, 1006, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1012, 1001, 'Multimedia Devices', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1013, 1012, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1014, 1012, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1015, 1012, 'Headphones & Microphones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1016, 1001, 'Printers', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1017, 1016, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1018, 1016, 'Inkjet', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1019, 1016, 'Laser', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1020, 1016, 'Supplies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1021, 1016, 'Multi Function', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1022, 1016, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1023, 1001, 'Scanners', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1024, 1001, 'Video', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1025, 1024, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1026, 1024, 'Webcams', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1027, 877, 'Software', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1028, 1027, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1029, 1027, 'Business', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1030, 1027, 'Children', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1031, 1027, 'Desktop Publishing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1032, 1027, 'Development Tools', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1033, 1027, 'Graphics & Multimedia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1034, 1027, 'Educational', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1035, 1027, 'Internet', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1036, 1027, 'Macintosh', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1037, 1027, 'Operating Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1038, 1027, 'Reference', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1039, 1027, 'Utilities', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1040, 0, 'Electronics', 10, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1041, 1040, 'Accessories', 10000, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1042, 1041, 'Batteries', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1043, 1041, 'Headphones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1044, 1041, 'Cables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1045, 1041, 'Remote Controls', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1046, 1041, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1047, 1040, 'Portable Audio', 10007, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1048, 1047, 'Cassette Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1049, 1047, 'CD Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1050, 1047, 'Minidisc', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1051, 1047, 'MP3 Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1052, 1047, 'Radio&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1053, 1047, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1054, 1040, 'Audio Systems', 10001, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1055, 1054, 'Amplifiers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1056, 1054, 'Cassette Decks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1057, 1054, 'CD Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1058, 1054, 'Home Theatre', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1059, 1054, 'MiniDisc', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1060, 1054, 'MP3 Players', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1061, 1054, 'Speakers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1062, 1054, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1063, 1054, 'Tuners', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1064, 1054, 'Turntables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1065, 1054, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1066, 1040, 'Camcorders', 10002, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1067, 1040, 'Home Phones', 10004, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1068, 1067, 'Analogue Phones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1069, 1067, 'Answer Phones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1070, 1067, 'Caller ID', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1071, 1067, 'Digital Phones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1072, 1067, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1073, 1040, 'Mobile Phones', 10006, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1074, 1073, 'Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1075, 1074, 'Batteries', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1076, 1074, 'Data Cables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1077, 1074, 'Handsfree', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1078, 1074, 'Pagers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1079, 1074, 'Boosters', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1080, 1074, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1081, 1073, 'Ericsson', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1082, 1073, 'Motorola', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1083, 1073, 'Nokia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1084, 1073, 'Siemens', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1085, 1073, 'Samsung', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1086, 1073, 'Sony Ericsson', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1087, 1073, 'Sim Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1088, 1086, 'BT Cellnet/O2', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1089, 1086, 'T-Mobile', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1090, 1086, 'Orange', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1091, 1086, 'Vodafone', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1092, 1086, 'Other Networks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1093, 1073, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1094, 1040, 'Mobile Phone Cases', 10005, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1095, 1094, 'For Ericsson', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1096, 1094, 'For Motorola', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1097, 1094, 'For Nokia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1098, 1094, 'All Other Phones', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1099, 1040, 'Televisions', 10009, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1100, 1099, 'Digial TV&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1101, 1099, 'Plasma TV&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1102, 1099, 'Portable TV&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1103, 1099, 'Widescreen TV&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1104, 1099, 'TV/VCR Combi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1105, 1099, 'TV/DVD Combi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1106, 1099, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1107, 1040, 'DVD Players', 10003, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1108, 1107, 'Region 2 DVD', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1109, 1107, 'Region Free DVD', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1110, 1040, 'VCR&#039;s', 10010, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1111, 1040, 'Satellite &amp; Digital TV', 10008, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1112, 1111, 'Dishes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1113, 1111, 'Old Receivers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1114, 1111, 'Digi Boxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1115, 1111, 'Handsets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1116, 1111, 'Cables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1117, 0, 'Dolls &amp; Dolls Houses', 9, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1118, 1117, 'Dolls', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1126, 1117, 'House & Miniatures', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1127, 1117, 'Sindy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1125, 1117, 'Figures', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1124, 1117, 'Barbie', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1128, 1126, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1129, 1126, 'Polly Pocket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1130, 1126, 'Houses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1131, 1126, 'Sylvanian Family', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1132, 1125, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1133, 1125, 'Trolls', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1134, 1118, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1135, 1118, 'American Character', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1136, 1118, 'Furniture', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1137, 1118, 'Porcelain', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1138, 1118, 'Modern', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1139, 0, 'TV &amp; Movies', 23, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1140, 1139, 'DVD&#039;s', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1141, 1139, 'Video&#039;s', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1142, 1139, 'Other Formats', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1143, 1139, 'Autographs', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1144, 1139, 'Posters', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1145, 1139, 'Memorabilia', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1146, 1143, 'Film', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1147, 1143, 'TV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1148, 1143, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1149, 1140, 'Action & Adventure', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1150, 1140, 'Animation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1151, 1140, 'Children & Family', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1152, 1140, 'Classics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1153, 1140, 'Comedy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1154, 1140, 'Cult', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1155, 1140, 'Drama', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1156, 1140, 'Fantasy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1157, 1140, 'Foreign', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1158, 1140, 'Documentary', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1159, 1140, 'Martial Arts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1160, 1140, 'Horror', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1162, 1140, 'Musicals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1163, 1140, 'Romance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1164, 1140, 'Sci-Fi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1165, 1140, 'Special Editions', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1166, 1140, 'Sports & Exercise', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1167, 1140, 'TV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1168, 1140, 'Crime', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1169, 1140, 'Mystery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1170, 1140, 'War', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1171, 1140, 'Westerns', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1172, 1140, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1173, 1145, 'Scripts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1174, 1145, 'Calendars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1175, 1145, 'Props', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1176, 1142, 'Beta', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1177, 1142, 'Celluloid', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1178, 1142, 'VCD', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1179, 1142, 'NTSC', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1180, 1142, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1181, 1144, 'Original UK', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1182, 1144, 'Original US', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1183, 1144, 'Origianl Worldwide', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1184, 1144, 'Reproductions', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1185, 1141, 'Action & Adventure', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1186, 1141, 'Animation', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1187, 1141, 'Box Sets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1188, 1141, 'Children & Family', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1189, 1141, 'Classics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1190, 1141, 'Comedy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1191, 1141, 'Deleted Video&#039;s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1192, 1141, 'Drama', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1193, 1141, 'Excercise', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1194, 1141, 'Fantasy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1195, 1141, 'Foreign', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1196, 1141, 'Horror', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1197, 1141, 'Documentary', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1198, 1141, 'Martial Arts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1200, 1141, 'Musical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1201, 1141, 'Romance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1202, 1141, 'Sci-Fi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1203, 1141, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1204, 1141, 'Television', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1205, 1141, 'Crime', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1206, 1141, 'Thriller', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1207, 1141, 'Mystery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1208, 1141, 'War', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1209, 1141, 'Westerns', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1210, 1141, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1211, 0, 'Jewelry &amp; Watches', 13, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1212, 1211, 'Beads', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1213, 1211, 'Costume Jewellery', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1214, 1211, 'Fine Jewellery', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1215, 1214, 'New', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1216, 1214, 'Antique', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1217, 1211, 'Gemstones', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1218, 1217, 'Amber', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1219, 1217, 'Amethyst', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1220, 1217, 'Aquamarine', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1221, 1217, 'Diamond', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1222, 1217, 'Emerald', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1223, 1217, 'Garnet', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1224, 1217, 'Jade', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1225, 1217, 'Opal', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1226, 1217, 'Pearl', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1227, 1217, 'Ruby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1228, 1217, 'Sapphire', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1229, 1217, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1230, 1211, 'Jewellery Boxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1231, 1211, 'Watches', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1232, 1231, 'Novelty', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1233, 1231, 'Pocket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1234, 1231, 'Rolex', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1235, 1231, 'Swatch', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1236, 1231, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1237, 1211, 'Men&#039;s Jewellery', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1238, 1237, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1239, 1237, 'Cufflinks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1242, 1237, 'Tiepins', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1243, 0, 'Music', 14, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1244, 1243, 'CD&#039;s', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1245, 1243, 'Tapes', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1246, 1244, 'Big Band', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1247, 1244, 'Blues', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1248, 1244, 'Childrens', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1249, 1244, 'Comedy', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1250, 1244, 'Classical & Opera', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1251, 1244, 'Compilations', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1252, 1244, 'Country', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1253, 1244, 'Dance', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1254, 1244, 'Disco', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1255, 1244, 'Folk', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1256, 1244, 'Garage', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1257, 1244, 'House', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1258, 1244, 'Indie', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1259, 1244, 'Instrumental', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1260, 1244, 'Jazz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1261, 1244, 'Karaoke', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1262, 1244, 'Punk', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1263, 1244, 'Pop', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1264, 1244, 'R&B', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1265, 1244, 'Rap', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1266, 1244, 'Reggae', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1267, 1244, 'Rock', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1268, 1244, 'Seasonal', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1269, 1244, 'Film Sountracks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1270, 1245, 'Blues', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1271, 1245, 'Childrens', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1272, 1245, 'Opera', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1273, 1245, 'Classical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1274, 1245, 'Country', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1275, 1245, 'Folk', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1276, 1245, 'Jazz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1277, 1245, 'Rap', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1278, 1245, 'Pop', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1279, 1245, 'Rock', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1280, 1245, 'Soundtracks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1281, 1243, 'Music Memorabilia', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1282, 1281, 'Magazines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1283, 1281, 'Books', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1284, 1281, 'Photos', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1285, 1281, 'Autographs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1286, 1281, 'Instruments', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1287, 1243, 'Musical Instruments', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1288, 1287, 'Brass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1289, 1287, 'Electronic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1290, 1287, 'Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1291, 1287, 'Guitars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1292, 1287, 'Keyboards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1293, 1287, 'Pianos', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1294, 1287, 'String', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1295, 1287, 'Woodwind', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1296, 1287, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1297, 1287, 'Percussion', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1317, 1316, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1316, 1311, 'Camcorders', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1315, 1312, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1314, 1312, 'Telescopes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1313, 1312, 'Binoculars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1318, 1316, '8MM', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1312, 1311, 'Binoculars & Telescopes', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1311, 0, 'Photography', 15, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1319, 1316, 'Digital Camcorders', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1320, 1316, 'Hi8', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1321, 1316, 'VHS', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1322, 1316, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1323, 1311, 'Darkroom Equipment', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1324, 1323, 'Paper & Chemicals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1325, 1323, 'Studio Equipment & Lighting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1326, 1323, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1327, 1311, 'Digital Cameras & Lenses', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1328, 1327, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1329, 1327, 'Digital Camera Lenses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1330, 1327, 'General Purpose (2.1 to 4 MP)', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1331, 1327, 'Serious (4.1 & Above)', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1332, 1327, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1333, 1311, 'Digital Memory', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1334, 1333, 'Compact Flash Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1335, 1333, 'Memory Card Readers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1336, 1333, 'Memory Sticks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1337, 1333, 'Smart Media', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1338, 1333, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1339, 1311, 'Film Cameras & Lenses', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1340, 1339, '35mm Compact/Zoom', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1341, 1339, 'APS', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1342, 1339, 'Film Camera Lenses', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1343, 1339, 'Movie', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1344, 1311, 'Photographic Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1345, 1344, 'Albums, Storage & Mounting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1346, 1344, 'Bags, Cases & Straps', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1347, 1344, 'Books, Magazines & Manuals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1348, 1344, 'Batteries & Chargers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1349, 1344, 'Flashes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1350, 1344, 'Tripods & Supports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1351, 0, 'Pottery &amp; Glass', 16, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1352, 1351, 'Glass', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1353, 1352, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1355, 1352, '40s, 50s, 60s', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1356, 1352, 'Contemporary Glass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1357, 1352, 'Cut Glass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1358, 1352, 'Paperweights', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1359, 1352, 'Pressed Glass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1360, 1352, 'Stained Glass', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1361, 1352, 'Waterford', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1362, 1352, 'Swarovski', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1363, 1351, 'Porcelain', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1364, 1363, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1365, 1363, 'Aynsley', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1366, 1363, 'Belleek', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1367, 1363, 'Cardew', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1368, 1363, 'Carlton Ware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1369, 1363, 'Chintz', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1370, 1363, 'Coalport', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1371, 1363, 'Decorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1372, 1363, 'Dinnerware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1374, 1363, 'Figurines: Animal', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1375, 1363, 'Hammersley', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1376, 1363, 'Hummel, Goebel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1377, 1363, 'Lladro', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1378, 1363, 'Royal Albert', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1379, 1363, 'Royal Copenhagen', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1380, 1363, 'Royal Doulton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1381, 1363, 'Royal Worcester', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1382, 1363, 'Shelley', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1383, 1363, 'Wade', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1384, 1363, 'Wedgwood', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1385, 1351, 'Pottery', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1386, 1385, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1387, 1385, 'Beswick', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1388, 1385, 'British Art', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1389, 1385, 'Carlton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1390, 1385, 'Ceramics', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1391, 1385, 'Clarice Cliff', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1392, 1385, 'Commemorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1393, 1385, 'Denby/Langley', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1394, 1385, 'Dinnerware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1395, 1385, 'Dresden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1396, 1385, 'Midwinter', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1397, 1385, 'Portmeirion', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1398, 1385, 'Staffordshire', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1399, 1385, 'Tablewares', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1400, 1385, 'Sylvac', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1401, 1385, 'Tea Pots, Tea Sets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1402, 1385, 'Wade', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1403, 1385, 'Stoneware', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1404, 0, 'Sports', 19, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1405, 1404, 'Autographs', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1406, 1405, 'Boxing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1407, 1405, 'Cricket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1408, 1405, 'Darts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1409, 1405, 'Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1410, 1405, 'Golf', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1411, 1405, 'Horse Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1412, 1405, 'Olympic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1413, 1405, 'Motor Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1414, 1405, 'Rugby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1415, 1405, 'Snooker', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1416, 1405, 'Tennis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1417, 1405, 'Wrestling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1418, 1405, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1419, 1404, 'Memorabilia', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1420, 1419, 'American Sports', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1421, 1420, 'American Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1422, 1420, 'Baseball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1423, 1420, 'Basketball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1424, 1420, 'Ice Hockey', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1425, 1419, 'Boxing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1426, 1419, 'Corinthians', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1427, 1419, 'Cricket', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1428, 1427, 'Cigarette Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1429, 1427, 'Programmes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1430, 1427, 'Scorecards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1431, 1427, 'Wisden', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1432, 1427, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1433, 1419, 'Cycling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1434, 1419, 'Darts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1435, 1419, 'Equestrian', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1436, 1419, 'Football', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1437, 1436, 'Badges/Pins', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1438, 1436, 'Jerseys/Shirts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1439, 1436, 'Programmes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1440, 1436, 'Scarves', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1441, 1436, 'Ticket/Stubs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1442, 1436, 'World Cup', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1443, 1436, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1444, 1419, 'Formula 1', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1445, 1444, 'Caps', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1446, 1444, 'Helmets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1447, 1444, 'Models', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1448, 1444, 'Prints & Photography', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1449, 1444, 'Programmes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1450, 1444, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1451, 1419, 'Golf', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1452, 1419, 'Horse Racing', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1453, 1452, 'Badges & Pins', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1454, 1452, 'Cigarette Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1455, 1452, 'Prints & Photography', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1456, 1452, 'Race Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1457, 1452, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1458, 1419, 'Motorsport', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1459, 1458, 'Le Mans', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1460, 1458, 'Superbikes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1461, 1458, 'NASCAR', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1462, 1458, 'Stock Car', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1463, 1458, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1464, 1419, 'Olympic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1465, 1419, 'Rally', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1466, 1419, 'Rugby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1467, 1419, 'Snooker', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1468, 1419, 'Speedway', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1469, 1419, 'Subbuteo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1470, 1419, 'Tennis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1471, 1419, 'Wrestling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1472, 1419, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1473, 1404, 'Sporting Items & Equipment', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1474, 1473, 'American Sports', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1475, 1474, 'American Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1476, 1474, 'Baseball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1477, 1474, 'Baksetball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1478, 1474, 'Ice Hockey', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1479, 1473, 'Beach Sports', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1480, 1479, 'Surfing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1481, 1479, 'Volleyball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1482, 1479, 'Windsurfing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1483, 1479, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1484, 1473, 'Bowling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1485, 1473, 'Camping', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1486, 1485, 'Tents', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1487, 1485, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1488, 1485, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1489, 1473, 'Cricket', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1490, 1489, 'Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1491, 1489, 'Clothing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1492, 1489, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1493, 1473, 'Cycling', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1494, 1493, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1495, 1493, 'BMX Bikes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1496, 1493, 'Cycling Apparel', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1497, 1493, 'Mountain Bikes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1498, 1493, 'Helmets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1499, 1493, 'Road JBikes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1500, 1493, 'Other Bikes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1502, 1473, 'Darts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1503, 1473, 'Equestrian Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1504, 1473, 'Exercise Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1505, 1473, 'Fishing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1506, 1473, 'Football', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1507, 1506, 'Boots', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1508, 1506, 'Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1509, 1506, 'Clothing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1510, 1506, 'Shinpads', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1511, 1473, 'Golf', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1512, 1511, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1513, 1511, 'Bags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1514, 1511, 'Clothing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1515, 1511, 'Drivers/Woods', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1516, 1511, 'Golf Balls', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1517, 1511, 'Irons', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1518, 1511, 'Putters', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1519, 1511, 'Training', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1520, 1511, 'Umbrellas', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1521, 1511, 'Wedges', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1522, 1511, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1523, 1473, 'Hiking', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1524, 1473, 'Hunting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1525, 1473, 'Martial Arts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1526, 1473, 'Rock Climbing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1527, 1473, 'Badminton', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1528, 1473, 'Tennis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1529, 1473, 'Squash', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1530, 1473, 'Rugby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1531, 1473, 'Running', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1532, 1473, 'Skiing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1533, 1473, 'Skating', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1534, 1473, 'Snooker', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1535, 1473, 'Snowboarding', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1536, 1473, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1537, 1534, 'Cues', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1538, 1534, 'Tables', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1539, 1534, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1540, 1404, 'Cards & Stickers', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1541, 1540, 'American Sports', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1542, 1541, 'American Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1543, 1541, 'Baseball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1544, 1541, 'Basketball', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1545, 1541, 'Ice Hockey', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1546, 1541, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1547, 1540, 'Boxing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1548, 1540, 'Cricket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1549, 1540, 'Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1550, 1540, 'Golf', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1551, 1540, 'Motor Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1552, 1540, 'Wrestling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1553, 1540, 'Other Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1554, 0, 'Stamps', 20, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1555, 1554, 'UK Stamps', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1556, 1555, 'Booklets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1557, 1555, 'Collections, Mixture', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1558, 1555, 'Commemorative', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1559, 1555, 'Covers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1561, 1555, 'Edward VIII', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1562, 1555, 'Elizabeth II', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1563, 1555, 'FDCs', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1565, 1555, 'George VI', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1566, 1555, 'PlateBlock/Multiples', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1567, 1555, 'Sheets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1568, 1555, 'Victoria', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1569, 1555, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1570, 1554, 'Australia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1571, 1554, 'Canada', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1572, 1554, 'Commonwealth', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1575, 1574, 'Benelux & Colonies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1574, 1554, 'Europe', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1576, 1574, 'France & Area', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1577, 1574, 'Germany & Area', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1578, 1574, 'Ireland', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1579, 1574, 'Italy & Area', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1580, 1574, 'Portugal & Colonies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1581, 1574, 'Russia & Area', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1582, 1574, 'Scandinavia', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1583, 1574, 'Spain & Colonies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1584, 1574, 'Eastern Europe', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1585, 1574, 'Western Europe', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1586, 1574, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1587, 1554, 'United States', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1588, 0, 'Tickets &amp; Travel', 21, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1589, 1588, 'Accessories', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1590, 1589, 'Adaptors & Electrical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1591, 1589, 'Luggage', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1592, 1589, 'Travel Guides', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1593, 1589, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1594, 1588, 'Tickets', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1595, 1594, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1596, 1594, 'Concert', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1597, 1594, 'Sporting Events', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1598, 1594, 'Theatre', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1599, 1596, 'Pop', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1600, 1596, 'Rock and Roll', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1601, 1596, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1602, 1597, 'Boxing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1603, 1597, 'Cricket', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1604, 1597, 'Golf', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1605, 1597, 'Motor Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1606, 1597, 'Football', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1607, 1597, 'Tennis', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1608, 1597, 'Rugby', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1609, 1597, 'Horse Racing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1610, 1597, 'Wrestling', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1611, 1597, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1612, 1598, 'Musicals', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1613, 1598, 'Plays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1614, 1598, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1615, 1588, 'Travel', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1616, 1615, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1617, 1615, 'Airline', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1618, 1615, 'Bed and Breakfast', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1619, 1615, 'Car Hire', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1620, 1615, 'Caravan & Camping', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1621, 1615, 'Coach Holidays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1622, 1615, 'Ferries & Cruises', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1623, 1615, 'Hotels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1624, 1615, 'Packages', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1625, 1615, 'Short Breaks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1626, 1615, 'Snow and Ski Holidays', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1627, 1615, 'Villas & Timeshare', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1628, 0, 'Toys &amp; Games', 22, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1629, 1628, 'Action Figures', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1630, 1629, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1631, 1629, 'Action Man', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1632, 1629, 'Dr Who', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1633, 1629, 'Movies/TV', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1634, 1629, 'Sports', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1635, 1629, 'Power Rangers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1636, 1629, 'Star Trek', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1637, 1629, 'Star Wars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1638, 1629, 'Transformers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1639, 1629, 'Xena', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1640, 1629, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1641, 1628, 'Bean Bag Plush', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1642, 1641, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1643, 1641, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1644, 1641, 'Coca Cola Bean Bags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1645, 1641, 'Disney', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1646, 1641, 'Ty Beanies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1647, 1641, 'Ty Other Products', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1648, 1641, 'Ty Retired Beanies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1649, 1641, 'Ty Teenie Beanies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1650, 1641, 'Warner Bros', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1651, 1628, 'Diecast', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1652, 1651, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1653, 1651, 'Burago', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1654, 1651, 'Corgi', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1655, 1651, 'Dinky', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1656, 1651, 'Hot Wheels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1657, 1651, 'Lledo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1658, 1651, 'Matchbox', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1659, 1628, 'Electronic Pets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1660, 1628, 'Fast Food Toys', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1661, 1660, 'Burger King', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1662, 1660, 'McDonalds', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1663, 1660, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1664, 1628, 'Games', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1665, 1664, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1666, 1664, 'Board Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1667, 1664, 'Dice Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1668, 1664, 'Electronic', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1669, 1664, 'Role Playing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1670, 1664, 'Tradtional', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1671, 1664, 'War Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1672, 1664, 'Vintage', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1673, 1628, 'Harry Potter', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1674, 1628, 'Hobbies', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1675, 1674, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1676, 1674, 'Radio Controlled', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1677, 1674, 'Science Playsets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1678, 1628, 'Kites', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1679, 1628, 'Modern Toys', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1680, 1679, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1681, 1679, 'Battery Operated', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1682, 1679, 'Lego', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1683, 1679, 'Meccano', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1684, 1628, 'My Little Pony', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1685, 1628, 'Plastic Models', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1686, 1685, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1687, 1685, 'Automotive', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1688, 1685, 'Air', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1689, 1685, 'Boats/Ships', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1690, 1685, 'Character Figures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1691, 1685, 'Military', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1692, 1685, 'Monsters', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1693, 1685, 'Science Fiction', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1694, 1685, 'Space', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1695, 1685, 'Super-Hero', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1696, 1628, 'Plush', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1697, 1696, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1698, 1696, 'Bears', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1699, 1696, 'Care Bears', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1700, 1696, 'Disney', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1701, 1696, 'Garfield', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1702, 1696, 'Steiff', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1703, 1628, 'Pokemon', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1704, 1703, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1705, 1703, 'Action Figures', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1706, 1703, 'Electronic Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1707, 1703, 'Plsuh', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1708, 1703, 'Trading Cards', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1709, 1628, 'Puzzles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1710, 1628, 'Scalextrics', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1711, 1710, 'Cars', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1712, 1710, 'Tracks', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1713, 1710, 'Sets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1714, 1710, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1715, 1628, 'Steam', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1716, 1628, 'Television Toys', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1717, 1716, 'Jim Henson', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1718, 1716, 'Rugrats', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1719, 1716, 'Teletubbies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1720, 1716, 'Thomas Tank Engine', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1721, 1628, 'Toy Soldiers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1722, 1628, 'Wooden Toys', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1723, 0, 'Wholesale Items', 24, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1724, 1723, 'Building Supplies', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1725, 1724, 'Electrical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1726, 1724, 'Plumbing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1727, 1724, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1728, 1723, 'Electrical Components', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1729, 1723, 'Medical Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1730, 1723, 'Office Equipment & Supplies', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1731, 1730, 'Copiers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1732, 1730, 'Fax Machines', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1733, 1730, 'Furniture', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1734, 1730, 'Supplies & Stationary', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1735, 1730, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1736, 1730, 'Type Writers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1737, 1730, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1738, 1723, 'Packing Supplies', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1739, 1738, 'Boxes', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1740, 1738, 'Bubble Wrap', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1741, 1738, 'Jiffy Bags', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1742, 1738, 'Tape', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1743, 1738, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1744, 1723, 'Restaurant & Catering', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1745, 1723, 'Retail and Shop Fitting', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1746, 1723, 'Hand Tools', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1760, 1723, 'Power Tools', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1747, 1723, 'Test and Measurement Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1748, 1746, 'Clamps, Vises', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1749, 1746, 'Files, Chisels', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1750, 1746, 'Hammers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1751, 1746, 'Knives, Cutters', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1752, 1746, 'Measuring Tools', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1753, 1746, 'Pliers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1754, 1746, 'Saws', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1755, 1746, 'Screwdrivers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1756, 1746, 'Wrenches', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1757, 1746, 'Tool Sets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1761, 1760, 'Combination Sets', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1762, 1760, 'Drills', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1763, 1760, 'Grinders', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1764, 1760, 'Rotary Tools', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1765, 1760, 'Routers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1766, 1760, 'Sanders', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1767, 1760, 'Saws', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1768, 1760, 'Screwdrivers', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1769, 1760, 'Other', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1770, 1723, 'Industrial  Tools', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1771, 1723, 'Wholesale Lots', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1772, 1771, 'Clothing, Jewellery & Watches', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1773, 1771, 'Computer, Electronics & Photo', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1774, 1771, 'Industrial & Office', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1775, 1771, 'Books, Film & Music', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1776, 1771, 'Other Wholesale Lots', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1777, 0, 'Everything Else', 11, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1778, 1777, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1779, 1777, 'Aviation', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1780, 1779, 'Aircraft Parts', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1781, 1779, 'Pilot Gear', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1782, 1779, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1783, 1777, 'Baby Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1784, 1783, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1785, 1783, 'Essentials', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1786, 1783, 'Clothing', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1787, 1783, 'Furniture', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1788, 1783, 'Maternity', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1789, 1783, 'Pushchairs & Prams', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1790, 1777, 'Crafts, Sewing', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1791, 1790, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1792, 1790, 'Cross Stitch', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1793, 1790, 'Fabric', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1794, 1790, 'Lace', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1795, 1790, 'Patterns', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1796, 1790, 'Textiles', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1797, 1777, 'Educational', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1798, 1777, 'Food & Drink', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1799, 1798, 'Food', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1800, 1798, 'Drink', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1801, 1777, 'Garden Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1802, 1801, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1803, 1801, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1804, 1801, 'Plants/Seeds', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1805, 1801, 'Tools, Equipment', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1806, 1801, 'Publications', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1807, 1777, 'Home Furnishings', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1808, 1777, 'Household Items', 0, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(1809, 1808, 'General', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1810, 1808, 'Feng Shui', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1811, 1808, 'Fitness', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1812, 1808, 'Health', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1813, 1808, 'Medical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1814, 1808, 'Safety, Security', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1815, 1777, 'Household Appliances', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, '');
INSERT INTO `myphpauction_categories` (`category_id`, `parent_id`, `name`, `order_id`, `hidden`, `items_counter`, `hover_title`, `meta_description`, `meta_keywords`, `image_path`, `wanted_counter`, `is_subcat`, `user_id`, `custom_fees`, `minimum_age`, `custom_skin`) VALUES
(1816, 1777, 'Metaphysical', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1817, 1777, 'Pet Supplies', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(125, 57, 'Nintendo Gameboy Classic', 10012, 0, 0, '', '', '', '', 0, '>', 0, 0, 0, ''),
(126, 125, 'Accessories', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(127, 125, 'Games', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(128, 125, 'Systems', 0, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(252, 245, 'Silver Color', 10017, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(560, 550, 'Other', 10013, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(805, 797, 'Silver Color', 10018, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(905, 899, 'Intel Pentium II', 10006, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(906, 899, 'Intel Pentium III', 10008, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(907, 899, 'Intel Pentium III', 10009, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(935, 934, 'DVD', 10001, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(941, 934, 'CDR', 10000, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(987, 983, 'Intel Pentium', 10005, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(988, 983, 'Intel Pentium II', 10007, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1161, 1140, 'Music', 10010, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1199, 1141, 'Music', 10011, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1373, 1363, 'Figurines', 10003, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1501, 1493, 'Other', 10014, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1560, 1555, 'Edward VII', 10002, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1564, 1555, 'George V', 10004, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1758, 1746, 'Other', 10015, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1759, 1746, 'Other Tools', 10016, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1835, 57, 'Sony PSP', 10012, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1855, 1852, 'b1', 0, 0, 0, '', '', '', '', 0, '', 10, 0, 0, ''),
(1841, 1040, 'HiFi &amp; TV', 10012, 0, 0, '', '', '', '', 0, '', 0, 0, 0, ''),
(1854, 1851, 'd', 3, 0, 0, '', '', '', '', 0, '', 10, 0, 0, ''),
(1853, 1851, 'c', 2, 0, 0, '', '', '', '', 0, '', 10, 0, 0, ''),
(1857, 1851, 'e', 0, 0, 0, '', '', '', '', 0, '', 10, 0, 0, ''),
(1852, 1851, 'b', 1, 0, 0, '', '', '', '', 0, '>', 10, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_content_pages`
--

DROP TABLE IF EXISTS `myphpauction_content_pages`;
CREATE TABLE IF NOT EXISTS `myphpauction_content_pages` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `topic_content` text COLLATE utf8_unicode_ci NOT NULL,
  `topic_lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `topic_order` int(11) NOT NULL DEFAULT '0',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_handle` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`topic_id`),
  KEY `topic_order` (`topic_order`,`reg_date`),
  FULLTEXT KEY `topic_lang` (`topic_lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `myphpauction_content_pages`
--

INSERT INTO `myphpauction_content_pages` (`topic_id`, `topic_name`, `topic_content`, `topic_lang`, `topic_order`, `reg_date`, `page_id`, `page_handle`) VALUES
(5, '', '&lt;P&gt;&amp;nbsp;About Us&lt;/P&gt;', 'english', 0, 1171888647, '', 'about_us'),
(15, '', '&lt;SPAN style=&quot;FONT-WEIGHT: bold&quot;&gt;General Terms and Conditions&lt;/SPAN&gt;&lt;BR&gt;This web-site is intended to be a friendly, enjoyable and useful experience, but as with anything concerning any kind of transactions there are risks involved and we strongly advise you to understand all of these terms before joining. If you spot a listing that you feel is violating the general terms and conditions of this web-site as stated below please let us know by contacting us.&lt;BR&gt;&lt;BR&gt;Rights To Suspend or Terminate.&lt;BR&gt;You agree that this web-site, in its own discretion, may terminate any auction or use of the service immediately and without notice if (a) We believe that you are not abiding by the general rules of this web-site&lt;BR&gt;(b) You have repeatedly broken a certain term (c) You have listed a suspicious item (d) We believe you to be a non paying bidder. In most cases when we suspect foul play we will suspend your account/listing whilst we investigate further. If our investigation is conclusive then your account with us will be terminated. &lt;BR&gt;&lt;BR&gt;Your Conduct.&lt;BR&gt;You are solely responsible for the contents of your actions through this web-site. You must ensure that your participation in the selling or buying of items does not violate any applicable laws or regulations. By this we mean that you must check that you entitled to sell or buy the relevant item and that you are not prohibited from doing so by any law or regulation. &lt;BR&gt;You must not transmit through the service any unlawful, harassing, libelous, abusive, threatening, harmful, vulgar, obscene or otherwise objectionable material. You must also not transmit any material that encourages conduct that could constitute a criminal offence, give rise to civil liability or otherwise violate any applicable law or regulation. &lt;BR&gt;&lt;BR&gt;Membership.&lt;BR&gt;Membership to this web-site is only available to those you can form a legally binding contract. This web-site does not permit minors (under&lt;BR&gt;16) to register. If any member fails to signup with their correct age the account will be terminated immediately. &lt;BR&gt;&lt;BR&gt;General Terms.&lt;BR&gt;This site acts as the window for sellers to conduct auctions and for bidders to bid on sellers&#039; auctions. We are not involved in the actual transaction between buyers and sellers. As a result, we have no control over the quality, safety or legality of the items listed the truth or accuracy of the listings, the ability of sellers to sell items or the ability of buyers to buy items. We cannot and do not control whether or not sellers will complete the sale of items they offer or buyers will complete the purchases of items they have bid on. &lt;BR&gt;In addition, note that there are risks of dealing with foreign nationals, underage persons or people acting under false pretence. &lt;BR&gt;This Web-site shall not be responsible for any items sold by Auction, for any damage to items during transit or during the inspection period, nor for misrepresentations and/or breaches of contract by either buyer and/or seller. This web-site shall not be responsible for the cost of procurement of substitute goods or any losses resulting form any goods purchased or obtained. &lt;BR&gt;This web-site assumes no liability for the content of the listings. &lt;BR&gt;However if you fall victim of a fraudulent transaction we will assist you as much as we can. &lt;BR&gt;&lt;BR&gt;Laws.&lt;BR&gt;These Terms of Service shall be governed by and constructed in accordance with the laws of England and Wales and any disputes will be decided only by the Courts of England and Wales.', 'english', 0, 1171961458, '', 'terms'),
(17, '', '&lt;P&gt;&amp;nbsp;Contact Us&lt;/P&gt;', 'english', 0, 1174555709, '', 'contact_us'),
(27, 'Registration', '&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;To create your account choose the â€œRegisterâ€ link on the header navigational bar or use any of the links available on the home page.&lt;?xml:namespace prefix = o ns = &quot;urn:schemas-microsoft-com:office:office&quot; /&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;When registering you will be asked to complete a short form which includes standard information such as your contact details, preferred login credentials etc.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Mandatory fields include:-&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Name&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;City&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;State/Province/county&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Zip/Post Code&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Phone Number&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Birthday&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Username &amp;amp; Password&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;E-Mail address&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt 36pt; TEXT-INDENT: -18pt; mso-list: l0 level1 lfo1; tab-stops: list 36.0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Symbol; mso-fareast-font-family: Symbol; mso-bidi-font-family: Symbol&quot;&gt;&lt;SPAN style=&quot;mso-list: Ignore&quot;&gt;Â·&lt;SPAN style=&quot;FONT: 7pt &#039;Times New Roman&#039;&quot;&gt;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp; &lt;/SPAN&gt;&lt;/SPAN&gt;&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Confirmation of terms an conditions acceptance&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Once registered you will receive E-Mail confirmation.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Should you encounter any registration difficulties please &lt;A href=&quot;content_pages.php?page=contact_us&quot;&gt;contact us&lt;/A&gt;.&lt;/SPAN&gt;&lt;/P&gt;', 'english', 1, 1181929004, 'b6a64374ace423504dc1b0076c8f6af9', 'help'),
(28, '', '&lt;P&gt;We believe your business is no one else&#039;s. Your privacy is important to youâ€¦and to us. So we&#039;ll protect the information you share with us. To protect your privacy, MyPHPAuction follows different principles in accordance with world-wide practices for customer privacy and data protection. &lt;/P&gt;\r\n&lt;UL&gt;\r\n&lt;LI&gt;We won&#039;t sell or give away your name, mail address, phone number, email address, credit card number or any other information to anyone. \r\n&lt;LI&gt;We&#039;ll use the latest security measures to protect your information from unauthorized users. &lt;/LI&gt;&lt;/UL&gt;\r\n&lt;P&gt;&lt;SPAN style=&quot;FONT-WEIGHT: bold&quot;&gt;NOTICE &lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P&gt;We will ask you when we need information that personally identifies you (personal information) or allows us to contact you. Generally this information is requested when you purchase our software packages. We use your Personal Information for four primary purposes:&lt;/P&gt;\r\n&lt;UL&gt;\r\n&lt;LI&gt;To process and activate your order &lt;BR&gt;\r\n&lt;LI&gt;To identify you \r\n&lt;LI&gt;To help us support you and/or your Business. \r\n&lt;LI&gt;To alert you to product upgrades, special offers, updated information and other new services from MyPHPAuction. &lt;/LI&gt;&lt;/UL&gt;\r\n&lt;P&gt;&lt;SPAN style=&quot;FONT-WEIGHT: bold&quot;&gt;ACCESS&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P&gt;&amp;nbsp;&lt;/P&gt;\r\n&lt;P&gt;We will provide you with the means to ensure that your personal information is correct and current. You may review and update this information at any time at the client area. There, you can view and edit personal information you have already given us. &lt;/P&gt;', 'english', 0, 1174903756, '', 'privacy'),
(29, 'Placing A Bid', '&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Placing a bid on an item you are interested in couldnâ€™t be easier, when viewing the item details page you will have two areas from where you can place your bid, one next to the item details and a second at the bottom of the page.&lt;?xml:namespace prefix = o ns = &quot;urn:schemas-microsoft-com:office:office&quot; /&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;To place your bid simply enter the amount you wish to bid e.g. 50.00. Please note no currency symbols are required.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;The bid will be placed in the auction currency. &lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Once done you will be asked to review your bid and you will also be able to view vital item details such as the shipping conditions before confirming your bid.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;To submit your bid simply press the â€œPlace Bidâ€ button.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;If your bid is high enough to take the lead in the auction a confirmation message will be displayed to you, however if your bid has not taken the lead be it due to a higher proxy bid or not meeting the reserve price you will be invited to make a further bid.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;Should you decide to retract your bid this can be done via the â€œCurrent Bidsâ€ section of the memberâ€™s area.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;You can also place a proxy bid, proxy bidding allows you to place your â€œHigh Bidâ€.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;At all times you will only pay the lowest required bid should you win the auction.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;For example, if the current bid on an auction is 500.00 you can place a proxy bid of 2,000.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;Should you remain the only bidder you will only pay 500.00.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;However should the item receive other bids the site will automatically re-bid for you (upto 2,000 in this scenario) to ensure you remain in the lead.&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;', 'english', 2, 1181929477, '90d7808ca6252b11dd03257fa9aaa75d', 'help'),
(31, 'Buy Out', '&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;If the option is available you can use â€œBuy Outâ€ to purchase the item immediately without having to place a bid.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;Some sellers offer such an option which can be used at any time until a bid has been placed over any applicable reserve price.&lt;?xml:namespace prefix = o ns = &quot;urn:schemas-microsoft-com:office:office&quot; /&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;&lt;o:p&gt;&amp;nbsp;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;\r\n&lt;P class=MsoNormal style=&quot;MARGIN: 0cm 0cm 0pt&quot;&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;The â€œBuy Outâ€ option will appear on the item details page, you will be asked to confirm your intention to buy out the item before the sale is concluded.&lt;SPAN style=&quot;mso-spacerun: yes&quot;&gt;&amp;nbsp; &lt;/SPAN&gt;Buy outâ€™s cannot be retracted. &lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;', 'english', 0, 1181929685, '3ecf34f0ad51c0f8aced1d1f8300b939', 'help'),
(33, 'Item Watching', '&lt;P&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; FONT-FAMILY: Verdana&quot;&gt;The item watch features lets you keep a close eye on any auction without having to place a bid on it. This feature means you can be kept up to date on how an auction is doing and prepares you to place a winning last minute bid. You can watch any auction by clicking on the â€œWatch this itemâ€ link on any auction page. &lt;?xml:namespace prefix = o ns = &quot;urn:schemas-microsoft-com:office:office&quot; /&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;', 'english', 0, 1181929750, '6ecd3688043a383ddd3ae838d0e3e379', 'help'),
(35, 'Auction Watch', '&lt;P&gt;&lt;SPAN style=&quot;FONT-SIZE: 8pt; COLOR: black; FONT-FAMILY: Verdana; mso-bidi-font-family: Arial&quot;&gt;The auction watch features notifies you of newly listed auctions which contain keywords you have chosen. For example if you are looking for a new Digital Camera you could enter in those keywords from within your members area area. Each time a new auction is listed containing those keywords you will be notified via email&lt;/SPAN&gt;&lt;SPAN style=&quot;FONT-SIZE: 8.5pt; COLOR: black; FONT-FAMILY: Arial&quot;&gt;. &lt;?xml:namespace prefix = o ns = &quot;urn:schemas-microsoft-com:office:office&quot; /&gt;&lt;o:p&gt;&lt;/o:p&gt;&lt;/SPAN&gt;&lt;/P&gt;', 'english', 0, 1181929826, 'b7091ff284ffff553bc6b18a8da436b7', 'help'),
(37, 'How To Sell', '&lt;P&gt;To list your item simply click on the â€œSellâ€ link found on the header navigational bar. The listing process is split up into several main sections, notably:-&lt;/P&gt;\r\n&lt;UL&gt;\r\n&lt;LI&gt;Category selection \r\n&lt;LI&gt;Item Details \r\n&lt;LI&gt;Auction Settings \r\n&lt;LI&gt;Shipping and Payment \r\n&lt;LI&gt;Listing preview \r\n&lt;LI&gt;Listing confirmation &lt;/LI&gt;&lt;/UL&gt;\r\n&lt;P&gt;The listing process is developed in such a way that you are guided through every step seamlessly. &lt;/P&gt;\r\n&lt;P&gt;The first part of the process is to choose the category you wish to list your item in, this can be revised at any time by using the â€œPrevious Stepâ€ navigation button. &lt;/P&gt;&lt;PIF available you can also select a secondary category for your item.&lt; p&gt;&lt;/PIF&gt;\r\n&lt;P&gt;Step two enables you to enter your item title and description, a full wysiwyg editor is in place to enable you to use HTML descriptions.&lt;/P&gt;\r\n&lt;P&gt;If you have a voucher code to redeem this can be entered just below the description field.&lt;/P&gt;\r\n&lt;P&gt;Moving on to step three, this is the biggest stage of the listing process. On this step you can set the following:-&lt;/P&gt;\r\n&lt;P&gt;Â· Auction type:-&lt;/P&gt;\r\n&lt;P&gt;Standard Auction&lt;/P&gt;\r\n&lt;P&gt;This is a single quantity auction&lt;/P&gt;\r\n&lt;P&gt;Dutch Auction&lt;/P&gt;\r\n&lt;P&gt;Dutch auction enables you to list a multiple quantity auction, for example if you have 100 pens to sell you can list all of these together in a single lot. Bidders will be able to select how many they wish to bid for.&lt;/P&gt;\r\n&lt;P&gt;Â· Currency:-&lt;/P&gt;\r\n&lt;P&gt;You can select your preferred auction currency using the drop down menu available&lt;/P&gt;\r\n&lt;P&gt;Â· Quantity:-&lt;/P&gt;\r\n&lt;P&gt;This field is only active if listing a Dutch auction, please see above for an explanation of this listing type&lt;/P&gt;\r\n&lt;P&gt;Â· Auction Starts At:-&lt;/P&gt;\r\n&lt;P&gt;This requires you to enter the minimum bid you are willing to accept, you can also set a reserve price to ensure you do not sell the item for this amount. Please see below for more information on this.&lt;/P&gt;\r\n&lt;P&gt;Â· Reserve Price:-&lt;/P&gt;\r\n&lt;P&gt;Enabling a reserve price affectively means you will not sell the item for less than the amount set, for example you can set the start price at 5.00 but only accept winning bids over 50.00, should a bid be placed for 49.99 the item will close without a winner.&lt;/P&gt;\r\n&lt;P&gt;Â· Buy out (if available):-&lt;/P&gt;\r\n&lt;P&gt;Buy out allows you to set an amount you are willing to sell the item for â€“ straight out. For example you can set the start price to 10.00 but offer interested parties the option to buy the item immediately for 100.00. &lt;/P&gt;\r\n&lt;P&gt;You can also list buy out only auctions, these auctions remove all bidding options meaning the listing can only be purchased for a set amount. To set a buy out only auction you need to set the buy out value to be exactly equal with the start bid.&lt;/P&gt;\r\n&lt;P&gt;Â· Offer-Range (if available):- &lt;/P&gt;\r\n&lt;P&gt;You can set a price bracket in which you are willing to listing to offer, for example if you set the price brackets from 15.00 to 100.00 interested parties will be able to offer you an amount within these brackets, you can opt whether to accept or decline these offers at any time via the members area.&lt;/P&gt;\r\n&lt;P&gt;Â· Bid increment:- &lt;/P&gt;\r\n&lt;P&gt;This option can be used to set your own custom bid increment if preferred.&lt;/P&gt;\r\n&lt;P&gt;Â· Item featuring (if available):-&lt;/P&gt;\r\n&lt;P&gt;The following options are available to you (fees may apply), these will highlight your item on site to ensure they reach more visitors:-&lt;/P&gt;\r\n&lt;P&gt;Â§ Home page featured&lt;/P&gt;\r\n&lt;P&gt;Â§ Category featured&lt;/P&gt;\r\n&lt;P&gt;Â§ Bold text&lt;/P&gt;\r\n&lt;P&gt;Â§ Highlighted background&lt;/P&gt;\r\n&lt;P&gt;Â· Set start/end time:- &lt;/P&gt;\r\n&lt;P&gt;You can either opt to list your item right away and set a defined number of days for it to be live for or you also have the option to define your own custom start/end time.&lt;/P&gt;\r\n&lt;P&gt;Â· Private Auction:-&lt;/P&gt;\r\n&lt;P&gt;Private auction will hide the bidders identity on the item details page&lt;/P&gt;\r\n&lt;P&gt;Â· Image upload:-&lt;/P&gt;\r\n&lt;P&gt;To accompany your item you can either upload images from your local computer or enter the URL of an image(s) hosted elsewhere&lt;/P&gt;\r\n&lt;P&gt;Â· Media upload:-&lt;/P&gt;\r\n&lt;P&gt;In addition to images you can also upload media files, please note only .avi/.mpeg/.mov are supported.&lt;/P&gt;\r\n&lt;P&gt;Â· Auto Re-List&lt;/P&gt;\r\n&lt;P&gt;For convenience you can opt to have your items automatically re-listed for you, options are available to allow you to select whether the item should be re-listed if sold and how many re-list attempts should be made.&lt;/P&gt;\r\n&lt;P&gt;On the next step you can set your shipping and payment preferences including your shipping rates and available methods of delivery. &lt;/P&gt;\r\n&lt;P&gt;Proceeding on, you can then review the listing and make changes if required, please note you can still edit your listing once live via the members area.&lt;/P&gt;The final step provides you with listing confirmation. ', 'english', 0, 1181931363, '8e920eed4cec08107b93d5cbdfc504a4', 'help');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_countries`
--

DROP TABLE IF EXISTS `myphpauction_countries`;
CREATE TABLE IF NOT EXISTS `myphpauction_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country_order` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `country_order` (`country_order`),
  KEY `parent_id` (`parent_id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with countries' AUTO_INCREMENT=2286 ;

--
-- Dumping data for table `myphpauction_countries`
--

INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(1865, 'Afghanistan', 1000, 0),
(1866, 'Albania', 1000, 0),
(1874, 'Argentina', 1000, 0),
(1875, 'Armenia', 1000, 0),
(1877, 'Australia', 1000, 0),
(1878, 'Austria', 1000, 0),
(1879, 'Azerbaijan', 1000, 0),
(1880, 'Bahamas', 1000, 0),
(1881, 'Bahrain', 1000, 0),
(1882, 'Bangladesh', 1000, 0),
(1883, 'Barbados', 1000, 0),
(1884, 'Belarus', 1000, 0),
(1885, 'Belgium', 1000, 0),
(1886, 'Belize', 1000, 0),
(1887, 'Benin', 1000, 0),
(1888, 'Bermuda', 1000, 0),
(1889, 'Bhutan', 1000, 0),
(1890, 'Bolivia', 1000, 0),
(1891, 'Bosnia and Herzegowina', 1000, 0),
(1892, 'Botswana', 1000, 0),
(1893, 'Bouvet Island', 1000, 0),
(1894, 'Brazil', 1000, 0),
(1895, 'British Indian Ocean Territory', 1000, 0),
(1896, 'Brunei Darussalam', 1000, 0),
(1897, 'Bulgaria', 1000, 0),
(1898, 'Burkina Faso', 1000, 0),
(1899, 'Burma', 1000, 0),
(1900, 'Burundi', 1000, 0),
(1901, 'Cambodia', 1000, 0),
(1902, 'Cameroon', 1000, 0);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(1903, 'Canada', 1000, 0),
(1904, 'Cape Verde', 1000, 0),
(1905, 'Cayman Islands', 1000, 0),
(1906, 'Central African Republic', 1000, 0),
(1907, 'Chad', 1000, 0),
(1908, 'Chile', 1000, 0),
(1909, 'China', 1000, 0),
(1910, 'Christmas Island', 1000, 0),
(1911, 'Cocos (Keeling) Islands', 1000, 0),
(1912, 'Colombia', 1000, 0),
(1913, 'Comoros', 1000, 0),
(1914, 'Congo', 1000, 0),
(1915, 'Congo, the Democratic Republic', 1000, 0),
(1916, 'Cook Islands', 1000, 0),
(1917, 'Costa Rica', 1000, 0),
(1918, 'Cote d&#039;Ivoire', 1000, 0),
(1919, 'Croatia', 1000, 0),
(1920, 'Cyprus', 1000, 0),
(1921, 'Czech Republic', 1000, 0),
(1922, 'Denmark', 1000, 0),
(1923, 'Djibouti', 1000, 0),
(1924, 'Dominica', 1000, 0),
(1925, 'Dominican Republic', 1000, 0),
(1926, 'East Timor', 1000, 0),
(1927, 'Ecuador', 1000, 0),
(1928, 'Egypt', 1000, 0),
(1929, 'El Salvador', 1000, 0),
(1931, 'Equatorial Guinea', 1000, 0),
(1932, 'Eritrea', 1000, 0),
(1933, 'Estonia', 1000, 0),
(1934, 'Ethiopia', 1000, 0),
(1935, 'Falkland Islands', 1000, 0),
(1936, 'Faroe Islands', 1000, 0),
(1937, 'Fiji', 1000, 0),
(1938, 'Finland', 1000, 0),
(1939, 'France', 1000, 0),
(1940, 'French Guiana', 1000, 0),
(1941, 'French Polynesia', 1000, 0),
(1942, 'French Southern Territories', 1000, 0),
(1943, 'Gabon', 1000, 0),
(1944, 'Gambia', 1000, 0),
(1945, 'Georgia', 1000, 0),
(1946, 'Germany', 1000, 0),
(1947, 'Ghana', 1000, 0),
(1948, 'Gibraltar', 1000, 0),
(1949, 'Greece', 1000, 0),
(1950, 'Greenland', 1000, 0),
(1951, 'Grenada', 1000, 0),
(1952, 'Guadeloupe', 1000, 0);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(1953, 'Guam', 1000, 0),
(1954, 'Guatemala', 1000, 0),
(1955, 'Guinea', 1000, 0),
(1956, 'Guinea-Bissau', 1000, 0),
(1957, 'Guyana', 1000, 0),
(1958, 'Haiti', 1000, 0),
(1959, 'Heard and Mc Donald Islands', 1000, 0),
(1960, 'Holy See (Vatican City State)', 1000, 0),
(1961, 'Honduras', 1000, 0),
(1962, 'Hong Kong', 1000, 0),
(1963, 'Hungary', 1000, 0),
(1964, 'Iceland', 1000, 0),
(1965, 'India', 1000, 0),
(1966, 'Indonesia', 1000, 0),
(1968, 'Israel', 1000, 0),
(1969, 'Italy', 1000, 0),
(1970, 'Jamaica', 1000, 0),
(1971, 'Japan', 1000, 0),
(1972, 'Jordan', 1000, 0),
(1973, 'Kazakhstan', 1000, 0),
(1974, 'Kenya', 1000, 0),
(1975, 'Kiribati', 1000, 0),
(1976, 'Korea (South)', 1000, 0),
(1977, 'Kuwait', 1000, 0),
(1978, 'Kyrgyzstan', 1000, 0),
(1980, 'Latvia', 1000, 0),
(1981, 'Lebanon', 1000, 0),
(1982, 'Lesotho', 1000, 0),
(1983, 'Liberia', 1000, 0),
(1984, 'Liechtenstein', 1000, 0),
(1985, 'Lithuania', 1000, 0),
(1986, 'Luxembourg', 1000, 0),
(1987, 'Macau', 1000, 0),
(1988, 'Macedonia', 1000, 0),
(1989, 'Madagascar', 1000, 0),
(1990, 'Malawi', 1000, 0),
(1991, 'Malaysia', 1000, 0),
(1992, 'Maldives', 1000, 0),
(1993, 'Mali', 1000, 0),
(1994, 'Malta', 1000, 0),
(1995, 'Marshall Islands', 1000, 0),
(1996, 'Martinique', 1000, 0),
(1997, 'Mauritania', 1000, 0),
(1998, 'Mauritius', 1000, 0),
(1999, 'Mayotte', 1000, 0),
(2000, 'Mexico', 1000, 0);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2001, 'Micronesia, Federated States o', 1000, 0),
(2002, 'Moldova, Republic of', 1000, 0),
(2003, 'Monaco', 1000, 0),
(2004, 'Mongolia', 1000, 0),
(2005, 'Montserrat', 1000, 0),
(2006, 'Morocco', 1000, 0),
(2007, 'Mozambique', 1000, 0),
(2008, 'Namibia', 1000, 0),
(2009, 'Nauru', 1000, 0),
(2010, 'Nepal', 1000, 0),
(2011, 'Netherlands', 1000, 0),
(2012, 'Netherlands Antilles', 1000, 0),
(2013, 'New Caledonia', 1000, 0),
(2014, 'New Zealand', 1000, 0),
(2015, 'Nicaragua', 1000, 0),
(2016, 'Niger', 1000, 0),
(2017, 'Nigeria', 1000, 0),
(2018, 'Niuev', 1000, 0),
(2019, 'Norfolk Island', 1000, 0),
(2020, 'Northern Ireland', 1000, 0),
(2021, 'Northern Mariana Islands', 1000, 0),
(2022, 'Norway', 1000, 0),
(2023, 'Oman', 1000, 0),
(2024, 'Pakistan', 1000, 0),
(2025, 'Palau', 1000, 0),
(2026, 'Panama', 1000, 0),
(2027, 'Papua New Guinea', 1000, 0),
(2028, 'Paraguay', 1000, 0),
(2029, 'Peru', 1000, 0),
(2030, 'Philippines', 1000, 0),
(2031, 'Pitcairn', 1000, 0),
(2032, 'Poland', 1000, 0),
(2033, 'Portugal', 1000, 0),
(2034, 'Puerto Rico', 1000, 0),
(2035, 'Qatar', 1000, 0),
(2098, 'Rep Of Ireland', 1000, 0),
(2036, 'Reunion', 1000, 0),
(2037, 'Romania', 1000, 0),
(2038, 'Russian Federation', 1000, 0),
(2039, 'Rwanda', 1000, 0),
(2040, 'Saint Kitts and Nevis', 1000, 0),
(2041, 'Saint Lucia', 1000, 0),
(2042, 'Saint Vincent and the Grenadin', 1000, 0),
(2043, 'Samoa (Independent)', 1000, 0),
(2044, 'San Marino', 1000, 0),
(2045, 'Sao Tome and Principe', 1000, 0),
(2046, 'Saudi Arabia', 1000, 0);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2048, 'Senegal', 1000, 0),
(2049, 'Seychelles', 1000, 0),
(2050, 'Sierra Leone', 1000, 0),
(2051, 'Singapore', 1000, 0),
(2052, 'Slovakia', 1000, 0),
(2053, 'Slovenia', 1000, 0),
(2054, 'Solomon Islands', 1000, 0),
(2055, 'Somalia', 1000, 0),
(2056, 'South Africa', 1000, 0),
(2057, 'South Georgia and the South Sa', 1000, 0),
(2058, 'Spain', 1000, 0),
(2059, 'Sri Lanka', 1000, 0),
(2060, 'St. Helena', 1000, 0),
(2061, 'St. Pierre and Miquelon', 1000, 0),
(2062, 'Suriname', 1000, 0),
(2063, 'Svalbard and Jan Mayen Islands', 1000, 0),
(2064, 'Swaziland', 1000, 0),
(2065, 'Sweden', 1000, 0),
(2066, 'Switzerland', 1000, 0),
(2067, 'Taiwan', 1000, 0),
(2068, 'Tajikistan', 1000, 0),
(2069, 'Tanzania', 1000, 0),
(2070, 'Thailand', 1000, 0),
(2071, 'Togo', 1000, 0),
(2072, 'Tokelau', 1000, 0),
(2073, 'Tonga', 1000, 0),
(2074, 'Trinidad and Tobago', 1000, 0),
(2075, 'Tunisia', 1000, 0),
(2076, 'Turkey', 1000, 0),
(2077, 'Turkmenistan', 1000, 0),
(2078, 'Turks and Caicos Islands', 1000, 0),
(2079, 'Tuvalu', 1000, 0),
(2080, 'Uganda', 1000, 0),
(2081, 'Ukraine', 1000, 0),
(2082, 'United Arab Emiratesv', 1000, 0);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2083, 'United Kingdom', 1, 0),
(2084, 'United States', 2, 0),
(2085, 'Uruguay', 1000, 0),
(2086, 'Uzbekistan', 1000, 0),
(2087, 'Vanuatu', 1000, 0),
(2088, 'Venezuela', 1000, 0),
(2089, 'Vietnam', 1000, 0),
(2090, 'Virgin Islands (British)', 1000, 0),
(2091, 'Virgin Islands (U.S.)', 1000, 0),
(2232, 'Australian Capital Territory', 1000, 1877),
(2093, 'Wallis and Futuna Islands', 1000, 0),
(2094, 'Western Sahara', 1000, 0),
(2095, 'Yemen', 1000, 0),
(2096, 'Zambia', 1000, 0),
(2097, 'Zimbabwe', 1000, 0),
(2109, 'Arizona', 1000, 2084),
(2108, 'Alaska', 1000, 2084),
(2107, 'Alabama', 1000, 2084),
(2104, 'Aberdeenshire', 1000, 2083),
(2105, 'Anglesey', 1000, 2083),
(2106, 'Alderney', 1000, 2083),
(2110, 'Arkansas', 1000, 2084),
(2111, 'California', 1000, 2084),
(2112, 'Colorado', 1000, 2084),
(2113, 'Connecticut', 1000, 2084),
(2114, 'Delaware', 1000, 2084),
(2115, 'Florida', 1000, 2084),
(2116, 'Georgia', 1000, 2084),
(2117, 'Hawaii', 1000, 2084),
(2118, 'Idaho', 1000, 2084),
(2119, 'Illinois', 1000, 2084),
(2120, 'Indiana', 1000, 2084),
(2121, 'Iowa', 1000, 2084);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2122, 'Kansas', 1000, 2084),
(2123, 'Kentucky', 1000, 2084),
(2124, 'Louisiana', 1000, 2084),
(2125, 'Maine', 1000, 2084),
(2126, 'Maryland', 1000, 2084),
(2127, 'Massachusetts', 1000, 2084),
(2128, 'Michigan', 1000, 2084),
(2129, 'Minnesota', 1000, 2084),
(2130, 'Mississippi', 1000, 2084),
(2131, 'Missouri', 1000, 2084),
(2132, 'Montana', 1000, 2084),
(2133, 'Nebraska', 1000, 2084),
(2134, 'Nevada', 1000, 2084),
(2135, 'New Hampshire', 1000, 2084),
(2136, 'New Jersey', 1000, 2084),
(2137, 'New Mexico', 1000, 2084),
(2138, 'New York', 1000, 2084),
(2139, 'North Carolina', 1000, 2084),
(2140, 'North Dakota', 1000, 2084),
(2141, 'Ohio', 1000, 2084),
(2142, 'Oklahoma', 1000, 2084),
(2143, 'Oregon', 1000, 2084),
(2144, 'Pennsylvania', 1000, 2084),
(2145, 'Rhode Island', 1000, 2084),
(2146, 'South Carolina', 1000, 2084),
(2147, 'South Dakota', 1000, 2084),
(2148, 'Tennessee', 1000, 2084);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2149, 'Texas', 1000, 2084),
(2150, 'Utah', 1000, 2084),
(2151, 'Vermont', 1000, 2084),
(2152, 'Virginia', 1000, 2084),
(2153, 'Washington', 1000, 2084),
(2154, 'West Virginia', 1000, 2084),
(2155, 'Wisconsin', 1000, 2084),
(2156, 'Wyoming', 1000, 2084),
(2157, 'Angus', 1000, 2083),
(2158, 'Co. Antrim', 1000, 2083),
(2159, 'Argyllshire', 1000, 2083),
(2160, 'Co. Armagh', 1000, 2083),
(2161, 'Avon', 1000, 2083),
(2162, 'Ayrshire', 1000, 2083),
(2163, 'Banffshire', 1000, 2083),
(2164, 'Bedfordshire', 1000, 2083),
(2165, 'Berwickshire', 1000, 2083),
(2166, 'Buckinghamshire', 1000, 2083),
(2167, 'Borders', 1000, 2083),
(2168, 'Breconshire', 1000, 2083),
(2169, 'Berkshire', 1000, 2083),
(2170, 'Bute', 1000, 2083),
(2171, 'Caernarvonshire', 1000, 2083),
(2172, 'Caithness', 1000, 2083),
(2173, 'Cambridgeshire', 1000, 2083),
(2174, 'Channel Islands', 1000, 2083),
(2175, 'Cheshire', 1000, 2083),
(2176, 'Cleveland', 1000, 2083),
(2177, 'Cumbria', 1000, 2083),
(2178, 'Carmarthenshire', 1000, 2083),
(2179, 'Cornwall', 1000, 2083),
(2180, 'Cumberland', 1000, 2083);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2181, 'Derbyshire', 1000, 2083),
(2182, 'Devon', 1000, 2083),
(2183, 'Dumfries-shire', 1000, 2083),
(2184, 'Dumfries and Galloway', 1000, 2083),
(2185, 'Dunbartonshire', 1000, 2083),
(2186, 'Dorset', 1000, 2083),
(2187, 'Durham', 1000, 2083),
(2188, 'Co. Down', 1000, 2083),
(2189, 'East Lothian', 1000, 2083),
(2190, 'Essex', 1000, 2083),
(2191, 'Fife', 1000, 2083),
(2192, 'Co. Fermanagh', 1000, 2083),
(2193, 'Glamorgan', 1000, 2083),
(2194, 'Gloucestershire', 1000, 2083),
(2195, 'Grampian', 1000, 2083),
(2196, 'Gwent', 1000, 2083),
(2197, 'Hampshire', 1000, 2083),
(2198, 'Herefordshire', 1000, 2083),
(2199, 'Hertfordshire', 1000, 2083),
(2200, 'Humberside', 1000, 2083),
(2201, 'Isle of Man', 1000, 2083),
(2202, 'Isle of Wight', 1000, 2083),
(2203, 'Kent', 1000, 2083),
(2204, 'Lancashire', 1000, 2083),
(2205, 'Leicestershire', 1000, 2083),
(2206, 'Lincolnshire', 1000, 2083),
(2207, 'Lanarkshire', 1000, 2083),
(2208, 'London', 1000, 2083),
(2209, 'Lothian', 1000, 2083),
(2210, 'Middlesex', 1000, 2083),
(2211, 'Merionethshire', 1000, 2083);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2212, 'Midlothian', 1000, 2083),
(2213, 'Northumberland', 1000, 2083),
(2214, 'Norfolk', 1000, 2083),
(2215, 'Northamptonshire', 1000, 2083),
(2216, 'Nottinghamshire', 1000, 2083),
(2217, 'Oxfordshire', 1000, 2083),
(2218, 'Orkney', 1000, 2083),
(2219, 'Pembrokeshire', 1000, 2083),
(2220, 'Perth', 1000, 2083),
(2221, 'Rutland', 1000, 2083),
(2222, 'Shropshire', 1000, 2083),
(2223, 'Suffolk', 1000, 2083),
(2224, 'Shetland', 1000, 2083),
(2225, 'Somerset', 1000, 2083),
(2226, 'Surrey', 1000, 2083),
(2227, 'Sussex', 1000, 2083),
(2228, 'Staffordshire', 1000, 2083),
(2229, 'Warwickshire', 1000, 2083),
(2230, 'Wiltshire', 1000, 2083),
(2231, 'Yorkshire', 1000, 2083),
(2233, 'New South Wales', 1000, 1877),
(2234, 'Victoria', 1000, 1877),
(2235, 'Queensland', 1000, 1877),
(2236, 'South Australia', 1000, 1877),
(2237, 'Western Australia', 1000, 1877),
(2238, 'Tasmania', 1000, 1877),
(2239, 'Northern Territory', 1000, 1877),
(2241, 'Dublin', 1000, 2098),
(2242, 'Wicklow', 1000, 2098),
(2243, 'Wexford', 1000, 2098);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2244, 'Carlow', 1000, 2098),
(2245, 'Kildare', 1000, 2098),
(2246, 'Meath', 1000, 2098),
(2247, 'Louth', 1000, 2098),
(2248, 'Monaghan', 1000, 2098),
(2249, 'Cavan', 1000, 2098),
(2250, 'Longford', 1000, 2098),
(2251, 'Westmeath', 1000, 2098),
(2252, 'Offaly', 1000, 2098),
(2253, 'Laois', 1000, 2098),
(2254, 'Kilkenny', 1000, 2098),
(2255, 'Waterford', 1000, 2098),
(2256, 'Cork', 1000, 2098),
(2257, 'Kerry', 1000, 2098),
(2258, 'Limerick', 1000, 2098),
(2259, 'Tipperary', 1000, 2098),
(2260, 'Clare', 1000, 2098),
(2261, 'Galway', 1000, 2098),
(2262, 'Mayo', 1000, 2098),
(2263, 'Roscommon', 1000, 2098);
INSERT INTO `myphpauction_countries` (`id`, `name`, `country_order`, `parent_id`) VALUES
(2264, 'Sligo', 1000, 2098),
(2265, 'Leitrim', 1000, 2098),
(2266, 'Donegal', 1000, 2098),
(2267, 'Ontario', 1000, 1903),
(2268, 'Quebec', 1000, 1903),
(2269, 'Nova Scotia', 1000, 1903),
(2270, 'New Brunswick', 1000, 1903),
(2271, 'Manitoba', 1000, 1903),
(2272, 'British Columbia', 1000, 1903),
(2273, 'Prince Edward Island', 1000, 1903),
(2274, 'Saskatchewan', 1000, 1903),
(2275, 'Alberta', 1000, 1903),
(2276, 'Newfoundland and Labrador', 1000, 1903),
(2277, 'Western Cape', 1000, 2056),
(2278, 'Northern Cape', 1000, 2056),
(2279, 'Eastern Cape', 1000, 2056),
(2280, 'KwaZulu-Natal', 1000, 2056),
(2281, 'Free State', 1000, 2056),
(2282, 'North West', 1000, 2056),
(2283, 'Gauteng', 1000, 2056),
(2284, 'Mpumalanga', 1000, 2056),
(2285, 'Limpopo', 1000, 2056);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_currencies`
--

DROP TABLE IF EXISTS `myphpauction_currencies`;
CREATE TABLE IF NOT EXISTS `myphpauction_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `caption` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `convert_rate` double(16,6) NOT NULL DEFAULT '1.000000',
  `convert_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with currency listings' AUTO_INCREMENT=47 ;

--
-- Dumping data for table `myphpauction_currencies`
--

INSERT INTO `myphpauction_currencies` (`id`, `symbol`, `caption`, `convert_rate`, `convert_date`) VALUES
(1, 'ARS', 'Argentina (Argentinian Peso)', 2.200000, 1176887658),
(2, 'AUD', 'Australia (Australian Dollar)', 1.000000, 1176887658),
(3, 'BRL', 'Brazil (Brazilian Real)', 1.000000, 1176887658),
(4, 'CLP', 'Chile (Chilean Peso)', 1.000000, 1176887658),
(5, 'CNY', 'China (Chinese Renminbi)', 1.000000, 1176887658),
(6, 'COP', 'Colombia (Colombian Peso)', 1.000000, 1176887658),
(7, 'CZK', 'Czech. Republic (Czech. Republic Koruna)', 1.000000, 1176887658),
(8, 'DKK', 'Denmark (Danish Krone)', 1.000000, 1176887658),
(9, 'EUR', 'European Union (EURO)', 1.478330, 1176887658),
(10, 'FJD', 'Fiji (Fiji Dollar)', 1.000000, 1176887658),
(11, 'GBP', 'Great Britain (Pound Sterling)', 1.000000, 1176887658),
(12, 'HKD', 'Hong Kong (Hong Kong Dollar)', 1.000000, 1176887658),
(13, 'INR', 'Iceland (Icelandic Krona)', 1.000000, 1176887658),
(14, 'INR', 'India (Indian Rupee)', 1.000000, 1176887658),
(15, 'IDR', 'Indonesia (Indonesian Rupiah)', 1.000000, 1176887658),
(16, 'ILS', 'Israel (Israeli New Shekel)', 1.000000, 1176887658),
(17, 'JPY', 'Japan (Japanese Yen)', 1.000000, 1176887658),
(18, 'MYR', 'Malaysia (Malaysian Ringgit)', 1.000000, 1176887658),
(19, 'MXN', 'Mexico (New Peso)', 1.000000, 1176887658),
(20, 'MAD', 'Morocco (Moroccan Dirham)', 1.000000, 1176887658),
(21, 'NZD', 'New Zealand (New Zealand Dollar)', 1.000000, 1176887658),
(22, 'NOK', 'Norway', 1.000000, 1176887658),
(23, 'PKR', 'Pakistan (Pakistan Rupee)', 1.000000, 1176887658),
(24, 'PAB', 'Panama (Panamanian Balboa)', 1.000000, 1176887658),
(25, 'PEN', 'Peru (Peruvian New Sol)', 1.000000, 1176887658),
(26, 'PHP', 'Philippine (Philippine Peso)', 1.000000, 1176887658),
(27, 'PLN', 'Poland (Polish Zloty)', 1.000000, 1176887658),
(46, 'RON', 'Romania (Romanian New Lei)', 4.924910, 1176887658),
(28, 'RUR', 'Russian (Russian Rouble)', 1.000000, 1176887658),
(29, 'SGD', 'Singapore (Singapore Dollar)', 1.000000, 1176887658),
(30, 'SKK', 'Slovakia (Koruna)', 1.000000, 1176887658),
(31, 'SIT', 'Slovenia (Slovenian Tolar)', 1.000000, 1176887658),
(32, 'ZAR', 'South Africa (South African Rand)', 1.000000, 1176887658),
(33, 'KRW', 'South Korea (South Korean Won)', 1.000000, 1176887658),
(34, 'LKR', 'Sri Lanka (Sri Lanka Rupee)', 1.000000, 1176887658),
(35, 'SEK', 'Sweden (Swedish Krona)', 1.000000, 1176887658),
(36, 'CHF', 'Switzerland (Swiss Franc)', 1.000000, 1176887658),
(37, 'TWD', 'Taiwan (Taiwanese New Dollar)', 1.000000, 1176887658),
(38, 'THB', 'Thailand (Thailand Thai Baht)', 1.000000, 1176887658),
(39, 'TND', 'Tunisia (Tunisisan Dinar)', 1.000000, 1176887658),
(40, 'TRL', 'Turkey (Turkish Lira)', 1.000000, 1176887658),
(41, 'USD', 'United States (U.S. Dollar)', 2.012370, 1176887658),
(42, 'VEB', 'Venezuela (Bolivar)', 1.000000, 1176887658);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `field_order` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `page_handle` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `section_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `field_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`field_id`),
  KEY `field_order` (`field_order`),
  KEY `active` (`active`),
  KEY `page_handle` (`page_handle`),
  KEY `section_id` (`section_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields_boxes`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields_boxes`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields_boxes` (
  `box_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL DEFAULT '0',
  `box_name` text COLLATE utf8_unicode_ci NOT NULL,
  `box_value` text COLLATE utf8_unicode_ci NOT NULL,
  `box_order` int(11) NOT NULL DEFAULT '0',
  `box_type` int(11) NOT NULL DEFAULT '0',
  `mandatory` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `box_type_special` int(11) NOT NULL DEFAULT '0',
  `formchecker_functions` text COLLATE utf8_unicode_ci NOT NULL,
  `box_searchable` tinyint(4) NOT NULL,
  PRIMARY KEY (`box_id`),
  KEY `field_id` (`field_id`),
  KEY `box_order` (`box_order`),
  KEY `box_type` (`box_type`),
  KEY `box_searchable` (`box_searchable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields_data`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields_data`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields_data` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `box_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `box_value` text COLLATE utf8_unicode_ci NOT NULL,
  `page_handle` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`data_id`),
  KEY `box_id` (`box_id`),
  FULLTEXT KEY `box_value` (`box_value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields_sections`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields_sections`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_handle` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`section_id`),
  KEY `page_handle` (`page_handle`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields_special`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields_special`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields_special` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `box_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `box_type` int(11) NOT NULL DEFAULT '0',
  `table_name_raw` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `box_value_code` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`),
  KEY `box_type` (`box_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_custom_fields_types`
--

DROP TABLE IF EXISTS `myphpauction_custom_fields_types`;
CREATE TABLE IF NOT EXISTS `myphpauction_custom_fields_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `box_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `maxfields` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `myphpauction_custom_fields_types`
--

INSERT INTO `myphpauction_custom_fields_types` (`type_id`, `box_type`, `maxfields`) VALUES
(1, 'text', 1),
(2, 'textarea', 1),
(3, 'list', 15),
(4, 'checkbox', 10),
(5, 'radio', 10),
(6, 'password', 1);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_dateformat`
--

DROP TABLE IF EXISTS `myphpauction_dateformat`;
CREATE TABLE IF NOT EXISTS `myphpauction_dateformat` (
  `id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with date format';

--
-- Dumping data for table `myphpauction_dateformat`
--

INSERT INTO `myphpauction_dateformat` (`id`, `type`, `value`, `name`, `active`) VALUES
(1, 'USA', 'M. d, Y H:i:s', 'mm/dd/yyyy', 'checked'),
(2, 'non-USA', 'd M. Y H:i:s', 'dd/mm/yyyy', '');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_favourite_stores`
--

DROP TABLE IF EXISTS `myphpauction_favourite_stores`;
CREATE TABLE IF NOT EXISTS `myphpauction_favourite_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `user_id` (`user_id`),
  KEY `store_id_2` (`store_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_fees`
--

DROP TABLE IF EXISTS `myphpauction_fees`;
CREATE TABLE IF NOT EXISTS `myphpauction_fees` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `signup_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `picture_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `hlitem_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `bolditem_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `hpfeat_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `catfeat_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `rp_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `swap_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `second_cat_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `buyout_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `wanted_ad_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `endauction_fee_applies` enum('s','b') COLLATE utf8_unicode_ci NOT NULL DEFAULT 's',
  `custom_start_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `relist_fee_reduction` double(16,2) NOT NULL DEFAULT '0.00',
  `video_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `makeoffer_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `verification_fee` double(16,2) NOT NULL,
  `verification_recurring` int(11) NOT NULL,
  `free_images` int(11) NOT NULL,
  `free_media` int(11) NOT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with fees' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `myphpauction_fees`
--

INSERT INTO `myphpauction_fees` (`fee_id`, `signup_fee`, `picture_fee`, `hlitem_fee`, `bolditem_fee`, `hpfeat_fee`, `catfeat_fee`, `rp_fee`, `swap_fee`, `second_cat_fee`, `buyout_fee`, `wanted_ad_fee`, `category_id`, `endauction_fee_applies`, `custom_start_fee`, `relist_fee_reduction`, `video_fee`, `makeoffer_fee`, `verification_fee`, `verification_recurring`, `free_images`, `free_media`) VALUES
(1, 0.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 4.00, 1.00, 1.00, 0.60, 0, 's', 1.00, 25.00, 2.00, 2.50, 2.00, 60, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_fees_tiers`
--

DROP TABLE IF EXISTS `myphpauction_fees_tiers`;
CREATE TABLE IF NOT EXISTS `myphpauction_fees_tiers` (
  `tier_id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_from` double(16,2) NOT NULL DEFAULT '0.00',
  `fee_to` double(16,2) NOT NULL DEFAULT '0.00',
  `fee_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `calc_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fee_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `store_nb_items` int(11) NOT NULL DEFAULT '0',
  `store_recurring` int(11) NOT NULL DEFAULT '0',
  `store_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `store_endauction_fee` double(16,2) NOT NULL DEFAULT '0.00',
  `store_featured` tinyint(4) NOT NULL,
  PRIMARY KEY (`tier_id`),
  KEY `category_id` (`category_id`),
  KEY `fee_type` (`fee_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `myphpauction_fees_tiers`
--

INSERT INTO `myphpauction_fees_tiers` (`tier_id`, `fee_from`, `fee_to`, `fee_amount`, `calc_type`, `fee_type`, `store_nb_items`, `store_recurring`, `store_name`, `category_id`, `store_endauction_fee`, `store_featured`) VALUES
(1, 0.01, 7.00, 2.00, 'flat', 'endauction', 0, 0, '', 0, 0.00, 0),
(2, 7.00, 10.00, 4.50, 'percent', 'endauction', 0, 0, '', 0, 0.00, 0),
(3, 10.00, 50.00, 4.00, 'percent', 'endauction', 0, 0, '', 0, 0.00, 0),
(4, 50.00, 250.00, 3.00, 'percent', 'endauction', 0, 0, '', 0, 0.00, 0),
(5, 250.00, 1000.00, 2.50, 'percent', 'endauction', 0, 0, '', 0, 0.00, 0),
(6, 1000.00, 99999999999.00, 2.20, 'percent', 'endauction', 0, 0, '', 0, 0.00, 0),
(8, 0.01, 1.00, 10.00, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(9, 1.00, 5.00, 7.50, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(10, 5.00, 25.00, 5.00, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(11, 25.00, 100.00, 4.00, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(12, 100.00, 500.00, 3.00, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(13, 500.00, 5000.00, 2.75, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(14, 5000.00, 99999999999.00, 2.40, 'percent', 'setup', 0, 0, '', 0, 0.00, 0),
(20, 0.00, 0.00, 10.00, 'flat', 'store', 50, 30, 'Advanced Store', 0, 0.00, 0),
(21, 0.00, 0.00, 2.00, 'flat', 'store', 2, 30, 'Basic Store', 0, 0.00, 0),
(18, 0.00, 0.00, 3.00, 'flat', 'store', 10, 30, 'Medium Store', 0, 0.00, 0),
(24, 0.00, 0.00, 30.00, 'flat', 'store', 200, 30, 'Expert Store', 0, 0.00, 1),
(26, 0.00, 0.00, 0.00, 'flat', 'store', 1, 0, 'Free Store', 0, 0.00, 0),
(28, 0.00, 0.00, 60.00, 'flat', 'store', 500, 30, 'Platinum Store', 0, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_gc_transactions`
--

DROP TABLE IF EXISTS `myphpauction_gc_transactions`;
CREATE TABLE IF NOT EXISTS `myphpauction_gc_transactions` (
  `trx_id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `google_order_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gc_custom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gc_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gc_price` double(16,2) NOT NULL,
  `gc_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `gc_payment_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reg_date` int(11) NOT NULL,
  PRIMARY KEY (`trx_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_gen_setts`
--

DROP TABLE IF EXISTS `myphpauction_gen_setts`;
CREATE TABLE IF NOT EXISTS `myphpauction_gen_setts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `site_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_worldpay_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_checkout_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_ikobo_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_ikobo_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_protx_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_protx_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_authnet_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pg_authnet_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` tinyint(4) NOT NULL DEFAULT '0',
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount_format` tinyint(4) NOT NULL DEFAULT '0',
  `amount_digits` tinyint(4) NOT NULL DEFAULT '0',
  `currency_position` tinyint(4) NOT NULL DEFAULT '0',
  `max_images` tinyint(4) NOT NULL DEFAULT '0',
  `images_max_size` int(11) NOT NULL DEFAULT '0',
  `enable_hpfeat` tinyint(4) NOT NULL DEFAULT '0',
  `enable_catfeat` tinyint(4) NOT NULL DEFAULT '0',
  `enable_bold` tinyint(4) NOT NULL DEFAULT '0',
  `enable_hl` tinyint(4) NOT NULL DEFAULT '0',
  `enable_swaps` tinyint(4) NOT NULL DEFAULT '0',
  `cron_job_type` tinyint(4) NOT NULL DEFAULT '1',
  `enable_header_counter` tinyint(4) NOT NULL DEFAULT '0',
  `is_ssl` tinyint(4) NOT NULL DEFAULT '0',
  `site_path_ssl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_mode` tinyint(4) NOT NULL DEFAULT '0',
  `max_credit` double(16,2) NOT NULL DEFAULT '0.00',
  `init_credit` double(16,2) NOT NULL DEFAULT '0.00',
  `closed_auction_deletion_days` smallint(6) NOT NULL DEFAULT '0',
  `enable_shipping_costs` tinyint(4) NOT NULL DEFAULT '0',
  `default_theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metatags` text COLLATE utf8_unicode_ci NOT NULL,
  `site_lang` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_lang` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `always_show_buyout` tinyint(4) NOT NULL DEFAULT '0',
  `enable_addl_category` tinyint(4) NOT NULL DEFAULT '0',
  `mailer` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sendmail_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_lang` tinyint(4) NOT NULL DEFAULT '0',
  `enable_sniping_feature` tinyint(4) NOT NULL DEFAULT '0',
  `sniping_duration` int(11) NOT NULL DEFAULT '20',
  `enable_private_site` tinyint(4) NOT NULL DEFAULT '0',
  `enable_pref_sellers` tinyint(4) NOT NULL DEFAULT '0',
  `pref_sellers_reduction` double(16,2) NOT NULL DEFAULT '0.00',
  `enable_bcc` tinyint(4) NOT NULL DEFAULT '0',
  `enable_asq` tinyint(4) NOT NULL DEFAULT '0',
  `enable_reg_approval` tinyint(4) NOT NULL DEFAULT '0',
  `enable_wanted_ads` tinyint(4) NOT NULL DEFAULT '0',
  `enable_hpfeat_desc` tinyint(4) NOT NULL DEFAULT '0',
  `auto_vat_exempt` tinyint(4) NOT NULL DEFAULT '0',
  `invoice_header` text COLLATE utf8_unicode_ci,
  `invoice_footer` text COLLATE utf8_unicode_ci,
  `vat_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `invoice_comments` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `enable_bid_retraction` tinyint(4) NOT NULL DEFAULT '0',
  `pg_mb_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `min_reg_age` smallint(6) NOT NULL DEFAULT '0',
  `birthdate_type` tinyint(4) NOT NULL DEFAULT '0',
  `nb_other_items_adp` tinyint(4) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(4) NOT NULL DEFAULT '0',
  `enable_stores` tinyint(4) NOT NULL DEFAULT '0',
  `account_mode_personal` tinyint(4) NOT NULL DEFAULT '0',
  `enable_bulk_lister` tinyint(4) NOT NULL DEFAULT '1',
  `suspend_over_bal_users` tinyint(4) NOT NULL DEFAULT '1',
  `activation_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `min_invoice_value` double(16,2) NOT NULL DEFAULT '0.00',
  `init_acc_type` tinyint(4) NOT NULL DEFAULT '0',
  `enable_tax` tinyint(4) DEFAULT '0',
  `enable_cat_counters` tinyint(4) NOT NULL DEFAULT '0',
  `enable_display_phone` tinyint(4) NOT NULL DEFAULT '0',
  `media_max_size` int(11) NOT NULL DEFAULT '0',
  `enable_auctions_approval` tinyint(4) NOT NULL DEFAULT '0',
  `approval_categories` text COLLATE utf8_unicode_ci NOT NULL,
  `is_mod_rewrite` tinyint(4) NOT NULL DEFAULT '0',
  `buyout_process` tinyint(4) NOT NULL DEFAULT '0',
  `sell_nav_position` tinyint(4) NOT NULL DEFAULT '1',
  `nb_autorelist_max` int(11) NOT NULL DEFAULT '0',
  `site_logo_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/myphpauction.gif',
  `time_offset` tinyint(4) NOT NULL DEFAULT '0',
  `max_media` tinyint(4) NOT NULL DEFAULT '1',
  `enable_other_items_adp` tinyint(4) NOT NULL DEFAULT '0',
  `debug_load_time` tinyint(4) NOT NULL DEFAULT '1',
  `debug_load_memory` tinyint(4) NOT NULL DEFAULT '0',
  `pg_nochex_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `signup_settings` tinyint(4) NOT NULL DEFAULT '0',
  `mcrypt_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `mcrypt_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `makeoffer_process` tinyint(4) NOT NULL,
  `enable_duration_change` tinyint(4) NOT NULL,
  `duration_change_days` int(11) NOT NULL,
  `enable_seller_verification` tinyint(4) NOT NULL,
  `makeoffer_private` tinyint(4) NOT NULL,
  `seller_verification_mandatory` tinyint(4) NOT NULL,
  `enable_profile_page` tinyint(4) NOT NULL,
  `enable_store_only_mode` tinyint(4) NOT NULL,
  `enable_enhanced_ssl` tinyint(4) NOT NULL,
  `watermark_text` text COLLATE utf8_unicode_ci NOT NULL,
  `watermark_size` int(11) NOT NULL DEFAULT '500',
  `watermark_pos` tinyint(4) NOT NULL,
  `enable_auto_relist` tinyint(4) NOT NULL DEFAULT '1',
  `pg_paymate_merchant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable_skin_change` tinyint(4) NOT NULL,
  `preferred_days` int(11) NOT NULL,
  `pg_gc_merchant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pg_gc_merchant_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable_second_chance` tinyint(4) NOT NULL,
  `second_chance_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with General Settings' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `myphpauction_gen_setts`
--

INSERT INTO `myphpauction_gen_setts` (`id`, `sitename`, `site_path`, `admin_email`, `pg_paypal_email`, `pg_worldpay_id`, `pg_checkout_id`, `pg_ikobo_username`, `pg_ikobo_password`, `pg_protx_username`, `pg_protx_password`, `pg_authnet_username`, `pg_authnet_password`, `language`, `currency`, `amount_format`, `amount_digits`, `currency_position`, `max_images`, `images_max_size`, `enable_hpfeat`, `enable_catfeat`, `enable_bold`, `enable_hl`, `enable_swaps`, `cron_job_type`, `enable_header_counter`, `is_ssl`, `site_path_ssl`, `account_mode`, `max_credit`, `init_credit`, `closed_auction_deletion_days`, `enable_shipping_costs`, `default_theme`, `metatags`, `site_lang`, `admin_lang`, `always_show_buyout`, `enable_addl_category`, `mailer`, `sendmail_path`, `user_lang`, `enable_sniping_feature`, `sniping_duration`, `enable_private_site`, `enable_pref_sellers`, `pref_sellers_reduction`, `enable_bcc`, `enable_asq`, `enable_reg_approval`, `enable_wanted_ads`, `enable_hpfeat_desc`, `auto_vat_exempt`, `invoice_header`, `invoice_footer`, `vat_number`, `invoice_comments`, `enable_bid_retraction`, `pg_mb_email`, `min_reg_age`, `birthdate_type`, `nb_other_items_adp`, `maintenance_mode`, `enable_stores`, `account_mode_personal`, `enable_bulk_lister`, `suspend_over_bal_users`, `activation_key`, `min_invoice_value`, `init_acc_type`, `enable_tax`, `enable_cat_counters`, `enable_display_phone`, `media_max_size`, `enable_auctions_approval`, `approval_categories`, `is_mod_rewrite`, `buyout_process`, `sell_nav_position`, `nb_autorelist_max`, `site_logo_path`, `time_offset`, `max_media`, `enable_other_items_adp`, `debug_load_time`, `debug_load_memory`, `pg_nochex_email`, `signup_settings`, `mcrypt_enabled`, `mcrypt_key`, `makeoffer_process`, `enable_duration_change`, `duration_change_days`, `enable_seller_verification`, `makeoffer_private`, `seller_verification_mandatory`, `enable_profile_page`, `enable_store_only_mode`, `enable_enhanced_ssl`, `watermark_text`, `watermark_size`, `watermark_pos`, `enable_auto_relist`, `pg_paymate_merchant_id`, `enable_skin_change`, `preferred_days`, `pg_gc_merchant_id`, `pg_gc_merchant_key`, `enable_second_chance`, `second_chance_days`) VALUES
(1, 'Ebay Auction', 'http://atomic-noodle.com/auction/', 'admin@atomic-noodle.com', '', '', '', '', '', '', '', '', '', 1, 'USD', 1, 2, 1, 4, 500, 1, 1, 1, 1, 1, 2, 1, 0, 'https://www.yoursite.com/', 2, 60.00, 3.00, 90, 1, 'red', '&lt;meta name=&quot;description&quot; content=&quot;enter general site description.&quot;&gt;\r\n&lt;meta name=&quot;keywords&quot; content=&quot;enter general site keywords&quot;&gt;', 'english', 'english', 1, 1, 'mail', '/usr/sbin/sendmail', 1, 1, 30, 0, 1, 25.00, 0, 1, 0, 1, 0, 0, 'Invoice Header', 'Invoice Footer', 'GB-0324982', 'Invoice Comments', 1, 'support@Clone Script Software.com', 16, 0, 4, 0, 1, 1, 1, 1, '', 5.00, 1, 1, 1, 0, 2048, 0, '0', 0, 1, 2, 15, 'images/myphpauction.gif', 0, 1, 1, 1, 0, '', 1, 0, '', 1, 1, 3, 0, 0, 0, 0, 0, 0, '', 500, 0, 1, '', 0, 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_invoices`
--

DROP TABLE IF EXISTS `myphpauction_invoices`;
CREATE TABLE IF NOT EXISTS `myphpauction_invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `invoice_date` int(11) NOT NULL DEFAULT '0',
  `current_balance` double(16,2) NOT NULL DEFAULT '0.00',
  `live_fee` tinyint(4) NOT NULL DEFAULT '0',
  `processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `can_rollback` tinyint(4) NOT NULL DEFAULT '0',
  `wanted_ad_id` int(11) NOT NULL DEFAULT '0',
  `credit_adjustment` tinyint(4) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `can_rollback` (`can_rollback`),
  KEY `account_history_item` (`user_id`,`item_id`,`invoice_date`,`live_fee`,`invoice_id`),
  KEY `account_history_wa` (`user_id`,`wanted_ad_id`,`invoice_date`,`live_fee`,`invoice_id`),
  KEY `account_history_live` (`user_id`,`invoice_date`,`live_fee`,`invoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `myphpauction_invoices`
--

INSERT INTO `myphpauction_invoices` (`invoice_id`, `user_id`, `item_id`, `name`, `amount`, `invoice_date`, `current_balance`, `live_fee`, `processor`, `can_rollback`, `wanted_ad_id`, `credit_adjustment`) VALUES
(1, 100001, 100001, 'Auction Setup Fee - Item number: 100001', 1.10, 1337854014, 0.00, 1, 'Test Mode', 0, 0, 0),
(2, 100002, 100002, 'Auction Setup Fee - Item number: 100002', 2.38, 1338430592, 0.00, 1, 'Test Mode', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_iphistory`
--

DROP TABLE IF EXISTS `myphpauction_iphistory`;
CREATE TABLE IF NOT EXISTS `myphpauction_iphistory` (
  `memberid` int(11) NOT NULL,
  `time1` int(11) NOT NULL,
  `time2` int(11) NOT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `myphpauction_iphistory`
--

INSERT INTO `myphpauction_iphistory` (`memberid`, `time1`, `time2`, `ip`) VALUES
(100001, 1337853308, 1337854033, '103.247.103.14'),
(100002, 1337859719, 1338431298, '180.180.205.30'),
(100001, 1339494361, 1339494539, '103.28.226.34');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_keywords_watch`
--

DROP TABLE IF EXISTS `myphpauction_keywords_watch`;
CREATE TABLE IF NOT EXISTS `myphpauction_keywords_watch` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`keyword_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with keywords for auction watch option' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_layout_setts`
--

DROP TABLE IF EXISTS `myphpauction_layout_setts`;
CREATE TABLE IF NOT EXISTS `myphpauction_layout_setts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hpfeat_nb` tinyint(4) NOT NULL DEFAULT '0',
  `hpfeat_width` smallint(6) NOT NULL DEFAULT '0',
  `hpfeat_max` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat_nb` tinyint(4) NOT NULL DEFAULT '0',
  `catfeat_width` smallint(6) NOT NULL DEFAULT '0',
  `catfeat_max` tinyint(4) NOT NULL DEFAULT '0',
  `nb_recent_auct` smallint(6) NOT NULL DEFAULT '0',
  `nb_popular_auct` smallint(6) NOT NULL DEFAULT '0',
  `nb_ending_auct` smallint(6) NOT NULL DEFAULT '0',
  `d_login_box` tinyint(4) NOT NULL DEFAULT '0',
  `d_news_box` tinyint(4) NOT NULL DEFAULT '0',
  `d_news_nb` tinyint(4) NOT NULL DEFAULT '0',
  `enable_buyout` tinyint(4) NOT NULL DEFAULT '0',
  `enable_reg_terms` tinyint(4) NOT NULL DEFAULT '0',
  `reg_terms_content` blob NOT NULL,
  `enable_auct_terms` tinyint(4) NOT NULL DEFAULT '0',
  `auct_terms_content` blob NOT NULL,
  `is_about` tinyint(4) NOT NULL DEFAULT '0',
  `is_terms` tinyint(4) NOT NULL DEFAULT '0',
  `is_contact` tinyint(4) NOT NULL DEFAULT '0',
  `is_pp` tinyint(4) NOT NULL DEFAULT '0',
  `nb_want_ads` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with the site''s general layout settings' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `myphpauction_layout_setts`
--

INSERT INTO `myphpauction_layout_setts` (`id`, `hpfeat_nb`, `hpfeat_width`, `hpfeat_max`, `catfeat_nb`, `catfeat_width`, `catfeat_max`, `nb_recent_auct`, `nb_popular_auct`, `nb_ending_auct`, `d_login_box`, `d_news_box`, `d_news_nb`, `enable_buyout`, `enable_reg_terms`, `reg_terms_content`, `enable_auct_terms`, `auct_terms_content`, `is_about`, `is_terms`, `is_contact`, `is_pp`, `nb_want_ads`) VALUES
(1, 3, 100, 3, 3, 150, 6, 6, 6, 6, 1, 1, 5, 1, 1, 0x47656e6572616c205465726d7320616e6420436f6e646974696f6e732028526567697374726174696f6e290d3c62723e0d3c62723e54686973207765622d7369746520697320696e74656e64656420746f206265206120667269656e646c792c20656e6a6f7961626c6520616e642075736566756c20657870657269656e63652c20627574206173207769746820616e797468696e6720636f6e6365726e696e6720616e79206b696e64206f66207472616e73616374696f6e7320746865726520617265207269736b7320696e766f6c76656420616e64207765207374726f6e676c792061647669736520796f7520746f20756e6465727374616e6420616c6c206f66207468657365207465726d73206265666f7265206a6f696e696e672e2020496620796f752073706f742061206c697374696e67207468617420796f75206665656c2069732076696f6c6174696e67207468652067656e6572616c207465726d7320616e6420636f6e646974696f6e73206f662074686973207765622d73697465206173207374617465642062656c6f7720706c65617365206c6574207573206b6e6f7720627920636f6e74616374696e672075732e0d3c62723e0d3c62723e52696768747320546f2053757370656e64206f72205465726d696e6174652e0d3c62723e596f7520616772656520746861742074686973207765622d736974652c20696e20697473206f776e2064697363726574696f6e2c206d6179207465726d696e61746520616e792061756374696f6e206f7220757365206f6620746865207365727669636520696d6d6564696174656c7920616e6420776974686f7574206e6f74696365206966202861292057652062656c69657665207468617420796f7520617265206e6f742061626964696e67206279207468652067656e6572616c2072756c6573206f662074686973207765622d736974652028622920596f7520686176652072657065617465646c792062726f6b656e2061206365727461696e207465726d2028632920596f752068617665206c6973746564206120737573706963696f7573206974656d202864292057652062656c6965766520796f7520746f2062652061206e6f6e20706179696e67206269646465722e2020496e206d6f7374206361736573207768656e207765207375737065637420666f756c20706c61792077652077696c6c2073757370656e6420796f7572206163636f756e742f6c697374696e67207768696c737420776520696e76657374696761746520667572746865722e20204966206f757220696e7665737469676174696f6e20697320636f6e636c7573697665207468656e20796f7572206163636f756e7420776974682075732077696c6c206265207465726d696e617465642e200d3c62723e0d3c62723e596f757220436f6e647563742e0d3c62723e596f752061726520736f6c656c7920726573706f6e7369626c6520666f722074686520636f6e74656e7473206f6620796f757220616374696f6e73207468726f7567682074686973207765622d736974652e20596f75206d75737420656e73757265207468617420796f75722070617274696369706174696f6e20696e207468652073656c6c696e67206f7220627579696e67206f66206974656d7320646f6573206e6f742076696f6c61746520616e79206170706c696361626c65206c617773206f7220726567756c6174696f6e732e2042792074686973207765206d65616e207468617420796f75206d75737420636865636b207468617420796f7520656e7469746c656420746f2073656c6c206f7220627579207468652072656c6576616e74206974656d20616e64207468617420796f7520617265206e6f742070726f686962697465642066726f6d20646f696e6720736f20627920616e79206c6177206f7220726567756c6174696f6e2e200d3c62723e596f75206d757374206e6f74207472616e736d6974207468726f75676820746865207365727669636520616e7920756e6c617766756c2c20686172617373696e672c206c6962656c6f75732c20616275736976652c20746872656174656e696e672c206861726d66756c2c2076756c6761722c206f627363656e65206f72206f7468657277697365206f626a656374696f6e61626c65206d6174657269616c2e20596f75206d75737420616c736f206e6f74207472616e736d697420616e79206d6174657269616c207468617420656e636f75726167657320636f6e64756374207468617420636f756c6420636f6e737469747574652061206372696d696e616c206f6666656e63652c2067697665207269736520746f20636976696c206c696162696c697479206f72206f74686572776973652076696f6c61746520616e79206170706c696361626c65206c6177206f7220726567756c6174696f6e2e200d3c62723e0d3c62723e4d656d626572736869702e0d3c62723e4d656d6265727368697020746f2074686973207765622d73697465206973206f6e6c7920617661696c61626c6520746f2074686f736520796f752063616e20666f726d2061206c6567616c6c792062696e64696e6720636f6e74726163742e202054686973207765622d7369746520646f6573206e6f74207065726d6974206d696e6f72732028756e6465722031362920746f2072656769737465722e2020496620616e79206d656d626572206661696c7320746f207369676e7570207769746820746865697220636f72726563742061676520746865206163636f756e742077696c6c206265207465726d696e6174656420696d6d6564696174656c792e0d3c62723e0d3c62723e47656e6572616c205465726d732e0d3c62723e5468697320736974652061637473206173207468652077696e646f7720666f722073656c6c65727320746f20636f6e647563742061756374696f6e7320616e6420666f72206269646465727320746f20626964206f6e2073656c6c65727326233033393b2061756374696f6e732e20576520617265206e6f7420696e766f6c76656420696e207468652061637475616c207472616e73616374696f6e206265747765656e2062757965727320616e642073656c6c6572732e204173206120726573756c742c2077652068617665206e6f20636f6e74726f6c206f76657220746865207175616c6974792c20736166657479206f72206c6567616c697479206f6620746865206974656d73206c697374656420746865207472757468206f72206163637572616379206f6620746865206c697374696e67732c20746865206162696c697479206f662073656c6c65727320746f2073656c6c206974656d73206f7220746865206162696c697479206f662062757965727320746f20627579206974656d732e2057652063616e6e6f7420616e6420646f206e6f7420636f6e74726f6c2077686574686572206f72206e6f742073656c6c6572732077696c6c20636f6d706c657465207468652073616c65206f66206974656d732074686579206f66666572206f72206275796572732077696c6c20636f6d706c6574652074686520707572636861736573206f66206974656d732074686579206861766520626964206f6e2e20496e206164646974696f6e2c206e6f7465207468617420746865726520617265207269736b73206f66206465616c696e67207769746820666f726569676e206e6174696f6e616c732c20756e64657261676520706572736f6e73206f722070656f706c6520616374696e6720756e6465722066616c73652070726574656e63652e20200d3c62723e54686973205765622d73697465207368616c6c206e6f7420626520726573706f6e7369626c6520666f7220616e79206974656d7320736f6c642062792041756374696f6e2c20666f7220616e792064616d61676520746f206974656d7320647572696e67207472616e736974206f7220647572696e672074686520696e7370656374696f6e20706572696f642c206e6f7220666f72206d6973726570726573656e746174696f6e7320616e642f6f72206272656163686573206f6620636f6e74726163742062792065697468657220627579657220616e642f6f722073656c6c65722e2054686973207765622d73697465207368616c6c206e6f7420626520726573706f6e7369626c6520666f722074686520636f7374206f662070726f637572656d656e74206f66207375627374697475746520676f6f6473206f7220616e79206c6f7373657320726573756c74696e6720666f726d20616e7920676f6f647320707572636861736564206f72206f627461696e65642e200d3c62723e54686973207765622d7369746520617373756d6573206e6f206c696162696c69747920666f722074686520636f6e74656e74206f6620746865206c697374696e67732e20486f776576657220696620796f752066616c6c2076696374696d206f662061206672617564756c656e74207472616e73616374696f6e2077652077696c6c2061737369737420796f75206173206d7563682061732077652063616e2e200d3c62723e0d3c62723e4c6177732e0d3c62723e5468657365205465726d73206f662053657276696365207368616c6c20626520676f7665726e656420627920616e6420636f6e737472756374656420696e206163636f7264616e6365207769746820746865206c617773206f6620456e676c616e6420616e642057616c657320616e6420616e792064697370757465732077696c6c2062652064656369646564206f6e6c792062792074686520436f75727473206f6620456e676c616e6420616e642057616c65732e200d3c62723e, 1, 0x47656e6572616c205465726d7320616e6420436f6e646974696f6e73202841756374696f6e205365747570290d3c62723e0d3c62723e54686973207765622d7369746520697320696e74656e64656420746f206265206120667269656e646c792c20656e6a6f7961626c6520616e642075736566756c20657870657269656e63652c20627574206173207769746820616e797468696e6720636f6e6365726e696e6720616e79206b696e64206f66207472616e73616374696f6e7320746865726520617265207269736b7320696e766f6c76656420616e64207765207374726f6e676c792061647669736520796f7520746f20756e6465727374616e6420616c6c206f66207468657365207465726d73206265666f7265206a6f696e696e672e2020496620796f752073706f742061206c697374696e67207468617420796f75206665656c2069732076696f6c6174696e67207468652067656e6572616c207465726d7320616e6420636f6e646974696f6e73206f662074686973207765622d73697465206173207374617465642062656c6f7720706c65617365206c6574207573206b6e6f7720627920636f6e74616374696e672075732e0d3c62723e0d3c62723e52696768747320546f2053757370656e64206f72205465726d696e6174652e0d3c62723e596f7520616772656520746861742074686973207765622d736974652c20696e20697473206f776e2064697363726574696f6e2c206d6179207465726d696e61746520616e792061756374696f6e206f7220757365206f6620746865207365727669636520696d6d6564696174656c7920616e6420776974686f7574206e6f74696365206966202861292057652062656c69657665207468617420796f7520617265206e6f742061626964696e67206279207468652067656e6572616c2072756c6573206f662074686973207765622d736974652028622920596f7520686176652072657065617465646c792062726f6b656e2061206365727461696e207465726d2028632920596f752068617665206c6973746564206120737573706963696f7573206974656d202864292057652062656c6965766520796f7520746f2062652061206e6f6e20706179696e67206269646465722e2020496e206d6f7374206361736573207768656e207765207375737065637420666f756c20706c61792077652077696c6c2073757370656e6420796f7572206163636f756e742f6c697374696e67207768696c737420776520696e76657374696761746520667572746865722e20204966206f757220696e7665737469676174696f6e20697320636f6e636c7573697665207468656e20796f7572206163636f756e7420776974682075732077696c6c206265207465726d696e617465642e200d3c62723e0d3c62723e596f757220436f6e647563742e0d3c62723e596f752061726520736f6c656c7920726573706f6e7369626c6520666f722074686520636f6e74656e7473206f6620796f757220616374696f6e73207468726f7567682074686973207765622d736974652e20596f75206d75737420656e73757265207468617420796f75722070617274696369706174696f6e20696e207468652073656c6c696e67206f7220627579696e67206f66206974656d7320646f6573206e6f742076696f6c61746520616e79206170706c696361626c65206c617773206f7220726567756c6174696f6e732e2042792074686973207765206d65616e207468617420796f75206d75737420636865636b207468617420796f7520656e7469746c656420746f2073656c6c206f7220627579207468652072656c6576616e74206974656d20616e64207468617420796f7520617265206e6f742070726f686962697465642066726f6d20646f696e6720736f20627920616e79206c6177206f7220726567756c6174696f6e2e200d3c62723e596f75206d757374206e6f74207472616e736d6974207468726f75676820746865207365727669636520616e7920756e6c617766756c2c20686172617373696e672c206c6962656c6f75732c20616275736976652c20746872656174656e696e672c206861726d66756c2c2076756c6761722c206f627363656e65206f72206f7468657277697365206f626a656374696f6e61626c65206d6174657269616c2e20596f75206d75737420616c736f206e6f74207472616e736d697420616e79206d6174657269616c207468617420656e636f75726167657320636f6e64756374207468617420636f756c6420636f6e737469747574652061206372696d696e616c206f6666656e63652c2067697665207269736520746f20636976696c206c696162696c697479206f72206f74686572776973652076696f6c61746520616e79206170706c696361626c65206c6177206f7220726567756c6174696f6e2e200d3c62723e0d3c62723e4d656d626572736869702e0d3c62723e4d656d6265727368697020746f2074686973207765622d73697465206973206f6e6c7920617661696c61626c6520746f2074686f736520796f752063616e20666f726d2061206c6567616c6c792062696e64696e6720636f6e74726163742e202054686973207765622d7369746520646f6573206e6f74207065726d6974206d696e6f72732028756e6465722031362920746f2072656769737465722e2020496620616e79206d656d626572206661696c7320746f207369676e7570207769746820746865697220636f72726563742061676520746865206163636f756e742077696c6c206265207465726d696e6174656420696d6d6564696174656c792e0d3c62723e0d3c62723e47656e6572616c205465726d732e0d3c62723e5468697320736974652061637473206173207468652077696e646f7720666f722073656c6c65727320746f20636f6e647563742061756374696f6e7320616e6420666f72206269646465727320746f20626964206f6e2073656c6c65727326233033393b2061756374696f6e732e20576520617265206e6f7420696e766f6c76656420696e207468652061637475616c207472616e73616374696f6e206265747765656e2062757965727320616e642073656c6c6572732e204173206120726573756c742c2077652068617665206e6f20636f6e74726f6c206f76657220746865207175616c6974792c20736166657479206f72206c6567616c697479206f6620746865206974656d73206c697374656420746865207472757468206f72206163637572616379206f6620746865206c697374696e67732c20746865206162696c697479206f662073656c6c65727320746f2073656c6c206974656d73206f7220746865206162696c697479206f662062757965727320746f20627579206974656d732e2057652063616e6e6f7420616e6420646f206e6f7420636f6e74726f6c2077686574686572206f72206e6f742073656c6c6572732077696c6c20636f6d706c657465207468652073616c65206f66206974656d732074686579206f66666572206f72206275796572732077696c6c20636f6d706c6574652074686520707572636861736573206f66206974656d732074686579206861766520626964206f6e2e20496e206164646974696f6e2c206e6f7465207468617420746865726520617265207269736b73206f66206465616c696e67207769746820666f726569676e206e6174696f6e616c732c20756e64657261676520706572736f6e73206f722070656f706c6520616374696e6720756e6465722066616c73652070726574656e63652e20200d3c62723e54686973205765622d73697465207368616c6c206e6f7420626520726573706f6e7369626c6520666f7220616e79206974656d7320736f6c642062792041756374696f6e2c20666f7220616e792064616d61676520746f206974656d7320647572696e67207472616e736974206f7220647572696e672074686520696e7370656374696f6e20706572696f642c206e6f7220666f72206d6973726570726573656e746174696f6e7320616e642f6f72206272656163686573206f6620636f6e74726163742062792065697468657220627579657220616e642f6f722073656c6c65722e2054686973207765622d73697465207368616c6c206e6f7420626520726573706f6e7369626c6520666f722074686520636f7374206f662070726f637572656d656e74206f66207375627374697475746520676f6f6473206f7220616e79206c6f7373657320726573756c74696e6720666f726d20616e7920676f6f647320707572636861736564206f72206f627461696e65642e200d3c62723e54686973207765622d7369746520617373756d6573206e6f206c696162696c69747920666f722074686520636f6e74656e74206f6620746865206c697374696e67732e20486f776576657220696620796f752066616c6c2076696374696d206f662061206672617564756c656e74207472616e73616374696f6e2077652077696c6c2061737369737420796f75206173206d7563682061732077652063616e2e200d3c62723e0d3c62723e4c6177732e0d3c62723e5468657365205465726d73206f662053657276696365207368616c6c20626520676f7665726e656420627920616e6420636f6e737472756374656420696e206163636f7264616e6365207769746820746865206c617773206f6620456e676c616e6420616e642057616c657320616e6420616e792064697370757465732077696c6c2062652064656369646564206f6e6c792062792074686520436f75727473206f6620456e676c616e6420616e642057616c65732e200d3c62723e, 1, 1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_messaging`
--

DROP TABLE IF EXISTS `myphpauction_messaging`;
CREATE TABLE IF NOT EXISTS `myphpauction_messaging` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `sender_id` int(11) NOT NULL DEFAULT '0',
  `receiver_id` int(11) NOT NULL DEFAULT '0',
  `is_question` int(11) NOT NULL DEFAULT '0',
  `message_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message_content` text COLLATE utf8_unicode_ci NOT NULL,
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `message_handle` tinyint(4) NOT NULL DEFAULT '1',
  `sender_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `receiver_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `winner_id` int(11) NOT NULL DEFAULT '0',
  `wanted_ad_id` int(11) NOT NULL,
  `admin_message` tinyint(4) NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `topic_id` (`topic_id`,`is_question`),
  KEY `public_questions` (`auction_id`,`message_handle`,`is_question`,`reg_date`),
  KEY `sent_messages` (`sender_id`,`reg_date`,`sender_deleted`),
  KEY `received_messages` (`receiver_id`,`receiver_deleted`,`reg_date`),
  KEY `is_read` (`is_read`),
  KEY `auction_read` (`auction_id`,`is_read`),
  KEY `topic_read` (`topic_id`,`is_read`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_newsletters`
--

DROP TABLE IF EXISTS `myphpauction_newsletters`;
CREATE TABLE IF NOT EXISTS `myphpauction_newsletters` (
  `newsletter_id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newsletter_content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`newsletter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_newsletter_recipients`
--

DROP TABLE IF EXISTS `myphpauction_newsletter_recipients`;
CREATE TABLE IF NOT EXISTS `myphpauction_newsletter_recipients` (
  `recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  PRIMARY KEY (`recipient_id`),
  KEY `newsletter_id` (`newsletter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_payment_gateways`
--

DROP TABLE IF EXISTS `myphpauction_payment_gateways`;
CREATE TABLE IF NOT EXISTS `myphpauction_payment_gateways` (
  `pg_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `checked` tinyint(4) NOT NULL DEFAULT '0',
  `dp_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `logo_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`pg_id`),
  KEY `checked` (`checked`),
  KEY `dp_enabled` (`dp_enabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with payment gateways' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `myphpauction_payment_gateways`
--

INSERT INTO `myphpauction_payment_gateways` (`pg_id`, `name`, `checked`, `dp_enabled`, `logo_url`) VALUES
(1, 'PayPal', 1, 1, 'img/paypal_logo.gif'),
(2, 'Worldpay', 0, 1, 'img/worldpay_logo.gif'),
(3, '2Checkout', 1, 0, 'img/checkout_logo.gif'),
(4, 'Nochex', 1, 0, 'img/nochex_logo.gif'),
(5, 'Ikobo', 0, 0, 'img/ikobo_logo.gif'),
(6, 'Protx', 0, 0, 'img/protx_logo.gif'),
(7, 'Authorize.net', 0, 0, 'img/authorize_logo.gif'),
(8, 'Test Mode', 1, 1, 'img/testmode_logo.gif'),
(9, 'Moneybookers', 1, 1, 'img/mb_logo.gif'),
(10, 'Paymate', 0, 0, 'img/paymate_logo.gif'),
(11, 'Google Checkout', 0, 0, 'img/google_checkout_logo.gif');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_payment_options`
--

DROP TABLE IF EXISTS `myphpauction_payment_options`;
CREATE TABLE IF NOT EXISTS `myphpauction_payment_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logo_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with payment methods' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `myphpauction_payment_options`
--

INSERT INTO `myphpauction_payment_options` (`id`, `name`, `logo_url`) VALUES
(4, 'American Express', 'uplimg/img_AmericanExpress_8da98d5db1e6391812709d282e36288d.jpg'),
(5, 'Diners Club', 'uplimg/img_DinersClub_34238e53cd51ed4c2906f13feea65e85.gif'),
(6, 'Solo', 'uplimg/img_Solo_cedafc81e85e3a8b95c5a4e619ba0d03.jpg'),
(7, 'Mastercard', 'uplimg/img_pmethod_logo_0358411434432d23e1812df959ce316d.jpg'),
(8, 'Switch', 'uplimg/img_pmethod_logo_0b6276f4103fe5fec3e66b222ab94326.jpg'),
(9, 'Visa', 'uplimg/img_pmethod_logo_e15ea68f3a592180b17dbbcdb8d33631.jpg'),
(10, 'Western Union', 'uplimg/img_WesternUnion_f88d27f54b3673cfbb739d47d4807bb3.gif');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_proxybid`
--

DROP TABLE IF EXISTS `myphpauction_proxybid`;
CREATE TABLE IF NOT EXISTS `myphpauction_proxybid` (
  `proxy_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `bidder_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` double(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`proxy_id`),
  KEY `auction_id` (`auction_id`),
  KEY `bidder_id` (`bidder_id`),
  KEY `select_bids` (`auction_id`,`bidder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with proxy bids' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_referrals`
--

DROP TABLE IF EXISTS `myphpauction_referrals`;
CREATE TABLE IF NOT EXISTS `myphpauction_referrals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `myphpauction_referrals`
--

INSERT INTO `myphpauction_referrals` (`id`, `name`) VALUES
(9, 'Google'),
(10, 'Yahoo'),
(11, 'Hot Scripts'),
(12, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_reputation`
--

DROP TABLE IF EXISTS `myphpauction_reputation`;
CREATE TABLE IF NOT EXISTS `myphpauction_reputation` (
  `reputation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `reputation_content` text COLLATE utf8_unicode_ci NOT NULL,
  `reputation_rate` int(11) NOT NULL DEFAULT '0',
  `reg_date` int(11) DEFAULT NULL,
  `from_id` int(11) NOT NULL DEFAULT '0',
  `submitted` tinyint(4) NOT NULL DEFAULT '0',
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `reputation_type` enum('sale','purchase') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sale',
  `winner_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reputation_id`),
  KEY `rep_sent` (`from_id`,`submitted`,`reg_date`),
  KEY `rep_received` (`submitted`,`user_id`,`reg_date`),
  KEY `rep_calculation` (`user_id`,`reputation_rate`,`submitted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with feedbacks' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_reserve_offers`
--

DROP TABLE IF EXISTS `myphpauction_reserve_offers`;
CREATE TABLE IF NOT EXISTS `myphpauction_reserve_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auctionid` int(11) NOT NULL DEFAULT '0',
  `bidderid` int(11) NOT NULL DEFAULT '0',
  `bidamount` double(16,2) NOT NULL DEFAULT '0.00',
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  `regdate` int(11) NOT NULL DEFAULT '0',
  `bidid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_shipping_options`
--

DROP TABLE IF EXISTS `myphpauction_shipping_options`;
CREATE TABLE IF NOT EXISTS `myphpauction_shipping_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `myphpauction_shipping_options`
--

INSERT INTO `myphpauction_shipping_options` (`id`, `name`) VALUES
(1, 'Recorded'),
(2, 'Special Delivery'),
(3, 'Airmail'),
(4, 'Surface Mail'),
(5, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_stores_accounting`
--

DROP TABLE IF EXISTS `myphpauction_stores_accounting`;
CREATE TABLE IF NOT EXISTS `myphpauction_stores_accounting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `amountpaid` double(16,2) NOT NULL DEFAULT '0.00',
  `paymentdate` int(11) NOT NULL DEFAULT '0',
  `processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_suggested_categories`
--

DROP TABLE IF EXISTS `myphpauction_suggested_categories`;
CREATE TABLE IF NOT EXISTS `myphpauction_suggested_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `regdate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_swaps`
--

DROP TABLE IF EXISTS `myphpauction_swaps`;
CREATE TABLE IF NOT EXISTS `myphpauction_swaps` (
  `swap_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `seller_id` int(11) NOT NULL DEFAULT '0',
  `buyer_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `accepted` tinyint(4) NOT NULL DEFAULT '0',
  `winner_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`swap_id`),
  KEY `auction_id` (`auction_id`,`seller_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_tax_settings`
--

DROP TABLE IF EXISTS `myphpauction_tax_settings`;
CREATE TABLE IF NOT EXISTS `myphpauction_tax_settings` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `countries_id` text COLLATE utf8_unicode_ci NOT NULL,
  `tax_user_types` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'a',
  `site_tax` tinyint(4) NOT NULL DEFAULT '0',
  `seller_countries_id` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_timesettings`
--

DROP TABLE IF EXISTS `myphpauction_timesettings`;
CREATE TABLE IF NOT EXISTS `myphpauction_timesettings` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `value` tinyint(4) NOT NULL DEFAULT '0',
  `caption` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with time settings' AUTO_INCREMENT=50 ;

--
-- Dumping data for table `myphpauction_timesettings`
--

INSERT INTO `myphpauction_timesettings` (`id`, `value`, `caption`, `active`) VALUES
(1, 0, 'Server Time', 0),
(2, -24, '-24 H', 0),
(3, -23, '-23 H', 0),
(4, -22, '-22 H', 0),
(5, -21, '-21 H', 0),
(6, -20, '-20 H', 0),
(7, -19, '-19 H', 0),
(8, -18, '-18 H', 0),
(9, -17, '-17 H', 0),
(10, -16, '-16 H', 0),
(11, -15, '-15 H', 0),
(12, -14, '-14 H', 0),
(13, -13, '-13 H', 0),
(14, -12, '-12 H', 0),
(15, -11, '-11 H', 0),
(16, -10, '-10 H', 0),
(17, -9, '-9 H', 0),
(18, -8, '-8 H', 0),
(19, -7, '-7 H', 0),
(20, -6, '-6 H', 0),
(21, -5, '-5 H', 0),
(22, -4, '-4 H', 0),
(23, -3, '-3 H', 0),
(24, -2, '-2 H', 0),
(25, -1, '-1 H', 0),
(26, 1, '+1 H', 0),
(27, 2, '+2 H', 0),
(28, 3, '+3 H', 0),
(29, 4, '+4 H', 0),
(30, 5, '+5 H', 0),
(31, 6, '+6 H', 0),
(32, 7, '+7 H', 0),
(33, 8, '+8 H', 0),
(34, 9, '+9 H', 0),
(35, 10, '+10 H', 0),
(36, 11, '+11 H', 0),
(37, 12, '+12 H', 0),
(38, 13, '+13 H', 0),
(39, 14, '+14 H', 0),
(40, 15, '+15 H', 0),
(41, 16, '+16 H', 0),
(42, 17, '+17 H', 0),
(43, 18, '+18 H', 0),
(44, 19, '+19 H', 0),
(45, 20, '+20 H', 0),
(46, 21, '+21 H', 0),
(47, 22, '+22 H', 0),
(48, 23, '+23 H', 0),
(49, 24, '+24 H', 0);

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_users`
--

DROP TABLE IF EXISTS `myphpauction_users`;
CREATE TABLE IF NOT EXISTS `myphpauction_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `birthdate` date NOT NULL DEFAULT '0000-00-00',
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `items_sold` int(11) NOT NULL DEFAULT '0',
  `items_bought` int(11) NOT NULL DEFAULT '0',
  `enable_aboutme_page` tinyint(4) NOT NULL DEFAULT '0',
  `aboutme_page_content` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_mainpage` mediumblob NOT NULL,
  `shop_mainpage_preview` mediumblob NOT NULL,
  `shop_logo_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `aboutme_page_type` tinyint(4) DEFAULT NULL,
  `newsletter` tinyint(4) NOT NULL DEFAULT '0',
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `mail_activated` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `is_seller` tinyint(4) NOT NULL DEFAULT '0',
  `preferred_seller` tinyint(4) NOT NULL DEFAULT '0',
  `tax_apply_exempt` tinyint(4) NOT NULL DEFAULT '0',
  `tax_reg_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_exempted` tinyint(4) NOT NULL DEFAULT '0',
  `shop_active` tinyint(4) NOT NULL DEFAULT '0',
  `shop_last_payment` int(11) NOT NULL DEFAULT '0',
  `birthdate_year` int(11) NOT NULL DEFAULT '0',
  `default_duration` smallint(6) NOT NULL DEFAULT '0',
  `default_hidden_bidding` tinyint(4) NOT NULL DEFAULT '0',
  `default_enable_swap` tinyint(4) NOT NULL DEFAULT '0',
  `default_shipping_method` tinyint(4) NOT NULL DEFAULT '0',
  `default_shipping_int` tinyint(4) NOT NULL DEFAULT '0',
  `default_payment_methods` text COLLATE utf8_unicode_ci NOT NULL,
  `default_postage_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `default_insurance_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `default_type_service` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `default_shipping_details` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `referred_by` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shop_account_id` int(11) NOT NULL DEFAULT '0',
  `shop_categories` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_next_payment` int(11) NOT NULL DEFAULT '0',
  `shop_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_mode` tinyint(1) DEFAULT '0',
  `max_credit` double(16,2) DEFAULT '0.00',
  `default_public_questions` tinyint(4) NOT NULL DEFAULT '0',
  `default_bid_placed_email` tinyint(4) NOT NULL DEFAULT '0',
  `mail_account_suspended` tinyint(4) NOT NULL DEFAULT '1',
  `mail_item_sold` tinyint(4) NOT NULL DEFAULT '1',
  `mail_item_won` tinyint(4) NOT NULL DEFAULT '1',
  `mail_buyer_details` tinyint(4) NOT NULL DEFAULT '1',
  `mail_seller_details` tinyint(4) NOT NULL DEFAULT '1',
  `mail_item_watch` tinyint(4) NOT NULL DEFAULT '1',
  `mail_item_closed` tinyint(4) NOT NULL DEFAULT '1',
  `mail_wanted_offer` tinyint(4) NOT NULL DEFAULT '1',
  `mail_outbid` tinyint(4) NOT NULL DEFAULT '1',
  `mail_keyword_match` tinyint(4) NOT NULL DEFAULT '1',
  `mail_confirm_to_seller` tinyint(4) NOT NULL DEFAULT '1',
  `shop_nb_items` int(11) NOT NULL DEFAULT '0',
  `shop_template_id` smallint(6) NOT NULL DEFAULT '0',
  `tax_company_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_paypal_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_worldpay_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_ikobo_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_ikobo_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_checkout_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_protx_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_protx_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_authnet_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_authnet_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pg_nochex_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shop_about` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_specials` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_shipping_info` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_company_policies` text COLLATE utf8_unicode_ci NOT NULL,
  `shop_nb_feat_items` int(11) NOT NULL DEFAULT '0',
  `shop_nb_ending_items` int(11) NOT NULL DEFAULT '0',
  `shop_nb_recent_items` int(11) NOT NULL DEFAULT '0',
  `shop_metatags` text COLLATE utf8_unicode_ci NOT NULL,
  `default_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `default_description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_admin_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `auction_approval` tinyint(4) NOT NULL DEFAULT '0',
  `tax_account_type` tinyint(4) NOT NULL DEFAULT '0',
  `salt` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `mail_messaging_received` tinyint(4) NOT NULL DEFAULT '1',
  `mail_messaging_sent` tinyint(4) NOT NULL DEFAULT '0',
  `pg_mb_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seller_verified` tinyint(4) NOT NULL,
  `seller_verif_last_payment` int(11) NOT NULL,
  `seller_verif_next_payment` int(11) NOT NULL,
  `enable_profile_page` tinyint(4) NOT NULL,
  `profile_www` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_msn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_icq` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_aim` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_yim` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_skype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_show_birthdate` tinyint(4) NOT NULL,
  `paypal_address_override` tinyint(4) NOT NULL,
  `paypal_first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_zip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_night_phone_a` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_night_phone_b` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_night_phone_c` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `default_currency` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `default_direct_payment` text COLLATE utf8_unicode_ci NOT NULL,
  `pg_paymate_merchant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `preferred_seller_exp_date` int(11) NOT NULL,
  `pg_gc_merchant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pg_gc_merchant_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `shop_active` (`active`,`shop_active`,`user_id`),
  KEY `stores_list` (`active`,`shop_active`,`shop_nb_items`),
  KEY `acc_overdue_users` (`payment_mode`,`reg_date`),
  KEY `active_users` (`active`,`reg_date`,`approved`),
  KEY `users_tax_acc_type` (`tax_account_type`,`reg_date`),
  KEY `users_tax_exempt` (`tax_apply_exempt`,`tax_exempted`,`reg_date`),
  KEY `active` (`active`),
  FULLTEXT KEY `shop_name` (`shop_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 COMMENT='Table with myphpauction users' AUTO_INCREMENT=100004 ;

--
-- Dumping data for table `myphpauction_users`
--

INSERT INTO `myphpauction_users` (`user_id`, `name`, `email`, `birthdate`, `address`, `city`, `state`, `country`, `zip_code`, `phone`, `username`, `password`, `active`, `payment_status`, `items_sold`, `items_bought`, `enable_aboutme_page`, `aboutme_page_content`, `shop_mainpage`, `shop_mainpage_preview`, `shop_logo_path`, `aboutme_page_type`, `newsletter`, `balance`, `reg_date`, `mail_activated`, `live_pm_amount`, `live_pm_date`, `live_pm_processor`, `lang`, `is_seller`, `preferred_seller`, `tax_apply_exempt`, `tax_reg_number`, `tax_exempted`, `shop_active`, `shop_last_payment`, `birthdate_year`, `default_duration`, `default_hidden_bidding`, `default_enable_swap`, `default_shipping_method`, `default_shipping_int`, `default_payment_methods`, `default_postage_amount`, `default_insurance_amount`, `default_type_service`, `default_shipping_details`, `referred_by`, `shop_account_id`, `shop_categories`, `shop_next_payment`, `shop_name`, `payment_mode`, `max_credit`, `default_public_questions`, `default_bid_placed_email`, `mail_account_suspended`, `mail_item_sold`, `mail_item_won`, `mail_buyer_details`, `mail_seller_details`, `mail_item_watch`, `mail_item_closed`, `mail_wanted_offer`, `mail_outbid`, `mail_keyword_match`, `mail_confirm_to_seller`, `shop_nb_items`, `shop_template_id`, `tax_company_name`, `pg_paypal_email`, `pg_worldpay_id`, `pg_ikobo_username`, `pg_ikobo_password`, `pg_checkout_id`, `pg_protx_username`, `pg_protx_password`, `pg_authnet_username`, `pg_authnet_password`, `pg_nochex_email`, `shop_about`, `shop_specials`, `shop_shipping_info`, `shop_company_policies`, `shop_nb_feat_items`, `shop_nb_ending_items`, `shop_nb_recent_items`, `shop_metatags`, `default_name`, `default_description`, `user_admin_notes`, `auction_approval`, `tax_account_type`, `salt`, `approved`, `mail_messaging_received`, `mail_messaging_sent`, `pg_mb_email`, `seller_verified`, `seller_verif_last_payment`, `seller_verif_next_payment`, `enable_profile_page`, `profile_www`, `profile_msn`, `profile_icq`, `profile_aim`, `profile_yim`, `profile_skype`, `profile_show_birthdate`, `paypal_address_override`, `paypal_first_name`, `paypal_last_name`, `paypal_address1`, `paypal_address2`, `paypal_city`, `paypal_state`, `paypal_zip`, `paypal_country`, `paypal_email`, `paypal_night_phone_a`, `paypal_night_phone_b`, `paypal_night_phone_c`, `default_currency`, `default_direct_payment`, `pg_paymate_merchant_id`, `preferred_seller_exp_date`, `pg_gc_merchant_id`, `pg_gc_merchant_key`) VALUES
(100001, 'Teguh Hermawan', 'tguhhermawan@yahoo.com', '1980-01-06', 'Jl. Jend. Sudirman 32', 'Bandung', 'Bandung', '1966', '40115', '(081) 61748524', 'tguhhermawan', '4b34faf712aa2d82b5188f4b35cf35b3', 1, 'confirmed', 0, 0, 0, '', '', '', '', NULL, 1, 0.00, 1337852998, 1, 0.00, 0, '', 'english', 0, 0, 0, '', 0, 0, 0, 1980, 0, 0, 0, 0, 0, '', 0.00, 0.00, '', '', '', 0, '', 0, '', 1, 0.00, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', '', '', '', 0, 0, '834', 1, 1, 0, '', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', ''),
(100002, 'dantestgseogold', 'dwhitemib@gmail.com', '1973-10-28', '9 dewstow close', 'newport', '2196', '2083', 'np264jp', '(01633) 283314', 'hybrid01', '8485adf2b7c6fd7f82135f65e84a3e08', 1, 'confirmed', 0, 0, 0, '', '', '', '', NULL, 0, 0.00, 1337859653, 1, 0.00, 0, '', 'english', 0, 0, 0, '', 0, 0, 0, 1973, 0, 0, 0, 0, 0, '', 0.00, 0.00, '', '', '', 0, '', 0, '', 1, 0.00, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, '', 'dwhite66@live.com', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', '', '', '', 0, 0, '843', 1, 1, 0, '', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', ''),
(100003, 'david pelayo soberano', 'audia6gris@hotmail.com', '1979-07-29', 'el tejo 78', 'valdaliga', 'camtabria', '2058', '39528', '(942) 722194', 'Layordr', 'c3edfb6f4d0893493ba15054f629665e', 1, 'confirmed', 0, 0, 0, '', '', '', '', NULL, 0, 0.00, 1338387137, 0, 0.00, 0, '', 'english', 0, 0, 1, '72131435p', 0, 0, 0, 1979, 0, 0, 0, 0, 0, '', 0.00, 0.00, '', '', '', 0, '', 0, '', 1, 0.00, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, '', 'admin@rdrshop.com', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', '', '', '', 0, 0, '1ca', 0, 1, 0, '', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_vat_rates`
--

DROP TABLE IF EXISTS `myphpauction_vat_rates`;
CREATE TABLE IF NOT EXISTS `myphpauction_vat_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vat_id` int(11) NOT NULL DEFAULT '0',
  `country` int(11) NOT NULL DEFAULT '0',
  `rate` double(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_vat_setts`
--

DROP TABLE IF EXISTS `myphpauction_vat_setts`;
CREATE TABLE IF NOT EXISTS `myphpauction_vat_setts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` float(9,2) DEFAULT '0.00',
  `countries` text COLLATE utf8_unicode_ci,
  `users_sale_vat` set('a','b','c','d') COLLATE utf8_unicode_ci DEFAULT NULL,
  `users_no_vat` set('a','b','c','d') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_vouchers`
--

DROP TABLE IF EXISTS `myphpauction_vouchers`;
CREATE TABLE IF NOT EXISTS `myphpauction_vouchers` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `voucher_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reg_date` int(11) NOT NULL DEFAULT '0',
  `exp_date` int(11) NOT NULL DEFAULT '0',
  `nb_uses` int(11) NOT NULL DEFAULT '0',
  `uses_left` int(11) NOT NULL DEFAULT '0',
  `voucher_reduction` double(16,2) NOT NULL DEFAULT '0.00',
  `assigned_users` text COLLATE utf8_unicode_ci NOT NULL,
  `assigned_fees` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `voucher_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `voucher_duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_wanted_ads`
--

DROP TABLE IF EXISTS `myphpauction_wanted_ads`;
CREATE TABLE IF NOT EXISTS `myphpauction_wanted_ads` (
  `wanted_ad_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `duration` smallint(6) NOT NULL DEFAULT '0',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_time_old` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time_old` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `nb_bids` int(11) NOT NULL DEFAULT '0',
  `nb_clicks` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `addl_category_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `picpath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `creation_in_progress` tinyint(4) NOT NULL DEFAULT '0',
  `creation_date` int(11) NOT NULL DEFAULT '0',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`wanted_ad_id`),
  KEY `wa_start_time` (`owner_id`,`closed`,`deleted`,`creation_in_progress`,`start_time`),
  KEY `wa_end_time` (`owner_id`,`closed`,`deleted`,`creation_in_progress`,`end_time`),
  KEY `wa_nb_bids` (`owner_id`,`closed`,`deleted`,`creation_in_progress`,`nb_bids`),
  KEY `wa_id` (`owner_id`,`closed`,`deleted`,`creation_in_progress`,`wanted_ad_id`),
  KEY `wa_admin_id` (`creation_in_progress`,`active`,`closed`,`wanted_ad_id`),
  KEY `wa_browse_end_time` (`active`,`closed`,`deleted`,`wanted_ad_id`,`end_time`),
  KEY `wa_browse_nb_bids` (`active`,`closed`,`deleted`,`wanted_ad_id`,`nb_bids`),
  KEY `wa_mainpage` (`closed`,`active`,`deleted`,`creation_in_progress`,`start_time`),
  FULLTEXT KEY `wa_keywords` (`name`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 COMMENT='Table with wanted ads details' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_wanted_offers`
--

DROP TABLE IF EXISTS `myphpauction_wanted_offers`;
CREATE TABLE IF NOT EXISTS `myphpauction_wanted_offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `wanted_ad_id` int(11) NOT NULL DEFAULT '0',
  `auction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`offer_id`),
  KEY `wanted_ad_id` (`wanted_ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_winners`
--

DROP TABLE IF EXISTS `myphpauction_winners`;
CREATE TABLE IF NOT EXISTS `myphpauction_winners` (
  `winner_id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL DEFAULT '0',
  `buyer_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `quantity_requested` int(11) NOT NULL DEFAULT '0',
  `quantity_offered` int(11) NOT NULL DEFAULT '0',
  `auction_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `live_pm_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `email_sent` tinyint(4) NOT NULL DEFAULT '0',
  `live_pm_date` int(11) NOT NULL DEFAULT '0',
  `live_pm_processor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `s_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `b_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `flag_paid` tinyint(4) NOT NULL DEFAULT '0',
  `flag_status` tinyint(4) NOT NULL DEFAULT '0',
  `direct_payment_paid` tinyint(4) NOT NULL DEFAULT '0',
  `buyout_purchase` tinyint(4) NOT NULL DEFAULT '0',
  `invoice_sent` tinyint(4) NOT NULL DEFAULT '0',
  `vat_included` tinyint(4) NOT NULL DEFAULT '0',
  `postage_included` tinyint(4) NOT NULL DEFAULT '0',
  `insurance_included` tinyint(4) NOT NULL DEFAULT '0',
  `insurance_amount` double(10,2) DEFAULT '0.00',
  `purchase_date` int(11) NOT NULL DEFAULT '0',
  `messaging_topic_id` int(11) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL,
  `combined_postage` double(16,2) NOT NULL,
  `combined_insurance` double(16,2) NOT NULL,
  `postage_amount` double(16,2) NOT NULL,
  PRIMARY KEY (`winner_id`),
  KEY `auction_id` (`auction_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `won_items_auction` (`buyer_id`,`b_deleted`,`invoice_id`,`auction_id`),
  KEY `won_items_bid` (`buyer_id`,`b_deleted`,`invoice_id`,`bid_amount`),
  KEY `won_items_quantity` (`buyer_id`,`b_deleted`,`invoice_id`,`quantity_offered`),
  KEY `won_items_purchase_date` (`buyer_id`,`b_deleted`,`invoice_id`,`purchase_date`),
  KEY `sold_items_auction` (`seller_id`,`s_deleted`,`invoice_id`,`auction_id`),
  KEY `sold_items_bid` (`seller_id`,`s_deleted`,`invoice_id`,`bid_amount`),
  KEY `sold_items_quantity` (`seller_id`,`s_deleted`,`invoice_id`,`quantity_offered`),
  KEY `sold_items_purchase_date` (`seller_id`,`s_deleted`,`invoice_id`,`purchase_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with the auction''s declared winners' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `myphpauction_wordfilter`
--

DROP TABLE IF EXISTS `myphpauction_wordfilter`;
CREATE TABLE IF NOT EXISTS `myphpauction_wordfilter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `word` (`word`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table with words that are filtered' AUTO_INCREMENT=5 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;