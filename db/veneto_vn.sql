-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Host: 127.3.54.2:3306
-- Generation Time: Aug 24, 2016 at 05:02 AM
-- Server version: 5.5.50
-- PHP Version: 5.3.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `veneto_vn`
--
CREATE DATABASE IF NOT EXISTS `veneto` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `veneto`;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `content` text COLLATE utf8_unicode_ci,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `page_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `view_count` int(11) DEFAULT '0',
  `like_count` int(11) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `share_count` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `long_description` text COLLATE utf8_unicode_ci,
  `published_at` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=899 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE IF NOT EXISTS `article_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `parent_id` int(11) DEFAULT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `long_description` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `page_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `banner` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `status` tinyint(2) DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_parent_idx` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=178 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_to_article_category`
--

CREATE TABLE IF NOT EXISTS `article_to_article_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`article_id`,`article_category_id`),
  KEY `fk_article_category_id_idx` (`article_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=660 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_to_tag`
--

CREATE TABLE IF NOT EXISTS `article_to_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`article_id`,`tag_id`),
  KEY `fk_tag_id_idx` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` varchar(2023) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(4) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `status` smallint(4) DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `h1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_description` text COLLATE utf8_unicode_ci,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE2` (`slug`,`is_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `price` int(11) DEFAULT '0',
  `original_price` int(11) DEFAULT '0',
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `banner` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `long_description` text COLLATE utf8_unicode_ci,
  `details` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `page_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `is_hot` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `view_count` int(11) DEFAULT '0',
  `like_count` int(11) DEFAULT '0',
  `share_count` int(11) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `published_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `available_quantity` int(11) DEFAULT '0',
  `order_quantity` int(11) DEFAULT '0',
  `sold_quantity` int(11) DEFAULT '0',
  `total_quantity` int(11) DEFAULT '0',
  `total_revenue` int(11) DEFAULT '0',
  `review_score` int(11) DEFAULT '0',
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `malterial` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `style` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `use_duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `manufacturing_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `size` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `weight` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `ingredient` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `parent_id` int(11) DEFAULT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `long_description` text COLLATE utf8_unicode_ci,
  `page_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `banner` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `is_hot` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk2_parent_idx` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_id_idx` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_to_product_category`
--

CREATE TABLE IF NOT EXISTS `product_to_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`product_category_id`,`product_id`),
  KEY `fk_product_category_id_idx` (`product_category_id`),
  KEY `fk2_product_id_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_to_tag`
--

CREATE TABLE IF NOT EXISTS `product_to_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `product_category_id` (`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address_2` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_note` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_note` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_fee` int(11) DEFAULT NULL,
  `shipping_duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_order_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_style` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_size` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_weight` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_price` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_detail_ibfk_1` (`purchase_order_id`),
  KEY `purchase_order_detail_ibfk_2` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `redirect_url`
--

CREATE TABLE IF NOT EXISTS `redirect_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_urls` text COLLATE utf8_unicode_ci NOT NULL,
  `to_url` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `status` smallint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seo_info`
--

CREATE TABLE IF NOT EXISTS `seo_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` tinyint(2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `meta_title` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_title` varchar(511) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `long_description` text COLLATE utf8_unicode_ci,
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `created_at` int(11) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `site_param`
--

CREATE TABLE IF NOT EXISTS `site_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshow_item`
--

CREATE TABLE IF NOT EXISTS `slideshow_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotline` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `old_slugs` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `page_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `h1` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_title` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `sort_order` int(11) DEFAULT NULL,
  `long_description` text COLLATE utf8_unicode_ci,
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT '',
  `is_active` tinyint(1) DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT NULL,
  `status` smallint(2) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `is_success` tinyint(1) DEFAULT '0',
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `object_pk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2429 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `article_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `article_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `article_to_article_category`
--
ALTER TABLE `article_to_article_category`
  ADD CONSTRAINT `fk_article_category_id` FOREIGN KEY (`article_category_id`) REFERENCES `article_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `article_to_tag`
--
ALTER TABLE `article_to_tag`
  ADD CONSTRAINT `fk2_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `fk2_parent` FOREIGN KEY (`parent_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_to_product_category`
--
ALTER TABLE `product_to_product_category`
  ADD CONSTRAINT `fk2_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_to_tag`
--
ALTER TABLE `product_to_tag`
  ADD CONSTRAINT `product_to_tag_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_to_tag_ibfk_2` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
  ADD CONSTRAINT `purchase_order_detail_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
