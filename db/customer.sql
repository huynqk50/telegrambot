/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.26 : Database - veneto_vn_v2
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

USE `veneto`;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `dob` int(11) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `zip_postal_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `total_purchase_orders` int(11) DEFAULT '0',
  `total_purchase_products` int(11) DEFAULT '0',
  `total_purchase_value` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `password_reset_token_UNIQUE` (`password_reset_token`),
  KEY `fk7_language_id_idx` (`language_id`),
  CONSTRAINT `fk7_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `customer_log` */

DROP TABLE IF EXISTS `customer_log`;

CREATE TABLE `customer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_pk` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `is_success` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_customer_id` (`customer_id`),
  CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
