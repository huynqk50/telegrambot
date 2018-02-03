/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - honglamhuong_com
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`veneto` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `veneto`;

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
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
  KEY `category_id` (`category_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `article_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=892 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `article` */

insert  into `article`(`id`,`category_id`,`name`,`label`,`slug`,`old_slugs`,`content`,`description`,`image`,`image_path`,`page_title`,`meta_title`,`meta_keywords`,`meta_description`,`h1`,`view_count`,`like_count`,`comment_count`,`share_count`,`created_at`,`updated_at`,`created_by`,`updated_by`,`auth_alias`,`is_hot`,`sort_order`,`status`,`long_description`,`published_at`,`is_active`,`type`) values (891,173,'Phú Quốc đẹp ngỡ ngàng qua góc máy Tâm Bùi','','phu-quoc-dep-ngo-ngang-qua-goc-may-tam-bui','','<p><strong>1. Campuchia</strong></p>\r\n\r\n<p>Đất nước l&aacute;ng giềng của Việt Nam kh&ocirc;ng chỉ nổi tiếng với Angkor Wat - một trong bảy kỳ quan của thế giới hiện đại, m&agrave; c&ograve;n nổi tiếng l&agrave; một đất nước du lịch với gi&aacute; rẻ. Ở Campuchia, du kh&aacute;ch c&oacute; thể chỉ mất 1 bảng anh (34.000 đồng) cho một đ&ecirc;m ngủ tại kh&aacute;ch sạn b&igrave;nh d&acirc;n v&agrave; 1 đ&ocirc;la (20.000 đồng) cho một bữa ăn. Chi ph&iacute; đi lại ở Campuchia cũng rất rẻ với đầy đủ c&aacute;c loại phương tiện c&aacute; nh&acirc;n v&agrave; c&ocirc;ng cộng.</p>\r\n\r\n<p style=\"text-align:center\"><img src=\"http://localhost/traveltovietnam/frontend/web/images/2016-07/du_lich_campuchia_6_-_du_lich_sen_vang_6.jpg\" style=\"border:medium none; box-sizing:border-box; max-width:100%; outline:0px; vertical-align:baseline; word-wrap:break-word\" /></p>\r\n\r\n<p><strong>2. Th&aacute;i Lan</strong></p>\r\n\r\n<p>Th&aacute;i Lan l&agrave; đất nước du lịch h&agrave;ng đầu của Đ&ocirc;ng Nam &Aacute;. Đất nước ch&ugrave;a v&agrave;ng n&agrave;y cũng c&oacute; rất nhiều ch&iacute;nh s&aacute;ch tốt để ph&aacute;t triển du lịch, tạo điều kiện thuận lợi cho du kh&aacute;ch đến kh&aacute;m ph&aacute; n&eacute;t đặc sắc văn h&oacute;a v&agrave; ẩm thực của m&igrave;nh.</p>\r\n\r\n<p>Hiện nay đi từ Việt Nam c&oacute; rất nhiều h&atilde;ng h&agrave;ng kh&ocirc;ng khai th&aacute;c chuyến bay gi&aacute; rẻ tới Th&aacute;i Lan, c&aacute;c đợt khuyến m&atilde;i được mở thường xuy&ecirc;n n&ecirc;n c&aacute;c bạn h&atilde;y chuẩn bị để đặt cho m&igrave;nh chuyến bay với kinh ph&iacute; thấp nhất.</p>\r\n\r\n<p>Ở Th&aacute;i Lan, chi ph&iacute; đi lại rất rẻ với nhiều loại h&igrave;nh như xe bus, tuk tuk, skytrain. Đặc biệt gi&aacute; taxi ở Th&aacute;i Lan rẻ hơn Việt Nam rất nhiều, chỉ v&agrave;o khoảng 8.000 &ndash; 10.000 đồng/km. Tại Th&aacute;i Lan, bạn chỉ phải tốn khoảng 100.000 đồng cho mỗi đ&ecirc;m tại dorm, mỗi bữa ăn c&oacute; gi&aacute; khoảng 30.000 đồng.</p>\r\n\r\n<p><strong>3. Myanmar</strong></p>\r\n\r\n<p>Một quốc gia kh&aacute;c nằm trong khu vực Đ&ocirc;ng Nam &Aacute; cũng rất nổi tiếng với những n&eacute;t độc đ&aacute;o trong văn ho&aacute; t&ocirc;n gi&aacute;o l&agrave; đất nước Myanmar. Myanmar l&agrave; đất nước của những ng&ocirc;i ch&ugrave;a v&agrave; những cảnh đẹp rất nhiệt đới.</p>\r\n\r\n<p>Chi ph&iacute; du lịch ở Myanmar đặc biệt rẻ. Nếu kh&ocirc;ng thử c&aacute;c dịch vụ độc đ&aacute;o như đi khinh kh&iacute; cầu ở Bagan th&igrave; chi ph&iacute; du lịch bao gồm cả ăn uống từ 30.000 - 40.000 đồng/ bữa, kh&aacute;ch sạn 300.000 - 400.000 đồng/ đ&ecirc;m/ 2 người, v&eacute; xe bu&yacute;t giữa 2 tỉnh th&agrave;nh c&oacute; gi&aacute; từ 150.000 - 250.000 đồng. Nếu c&oacute; sức khoẻ tốt v&agrave; c&oacute; nhiều thời gian để kh&aacute;m ph&aacute; th&igrave; bạn n&ecirc;n thu&ecirc; xe đạp chỉ với gi&aacute; 35.000 đồng/ ng&agrave;y, rẻ hơn đi t&agrave;u v&agrave; xe bus.</p>\r\n\r\n<p><strong>4. Ấn độ</strong></p>\r\n\r\n<p>Ấn Độ l&agrave; quốc gia c&oacute; nền văn ho&aacute; đặc sắc, người Ấn Độ kh&aacute; hiếu kh&aacute;ch. Ở Ấn Độ, chi ph&iacute; kh&aacute;ch sạn v&agrave;o khoảng 200.000 đồng/ đ&ecirc;m ở những khu du lịch lớn. Phương tiện giao th&ocirc;ng gi&aacute; rẻ giữa c&aacute;c tỉnh th&agrave;nh Ấn Độ l&agrave; t&agrave;u, c&ograve;n nội th&agrave;nh l&agrave; xe người k&eacute;o với gi&aacute; khoảng 40.000 đồng cho 5-6 km. Như vậy, để kh&aacute;m ph&aacute; đất nước xinh đẹp n&agrave;y, mỗi ng&agrave;y bạn bỏ ra chưa đến 400.000 đồng nếu chi ti&ecirc;u tiết kiệm.</p>\r\n\r\n<p style=\"text-align:center\"><img src=\"http://localhost/traveltovietnam/frontend/web/images/2016-07/4_1.jpg\" style=\"border:medium none; box-sizing:border-box; max-width:100%; outline:0px; vertical-align:baseline; word-wrap:break-word\" /></p>\r\n\r\n<p><strong>5. Nepal</strong></p>\r\n\r\n<p>Nepal l&agrave; đất nước nhỏ b&eacute; nhưng v&ocirc; c&ugrave;ng xinh đẹp, đặc biệt lại l&agrave; nơi c&oacute; đỉnh n&uacute;i Everest - n&oacute;c nh&agrave; thế giới. V&eacute; m&aacute;y bay gi&aacute; rẻ đến Nepal từ Việt Nam c&oacute; gi&aacute; khoảng 300 - 400$ cho hai chiều, chi ph&iacute; ăn ở sinh hoạt ở Nepal chưa đến 200.000 đồng/ ng&agrave;y. Ri&ecirc;ng c&aacute;c dịch vụ leo n&uacute;i ở Nepal th&igrave; c&oacute; gi&aacute; kh&aacute; cao (tr&ecirc;n 3 triệu đồng/ tour), nhưng hầu như ai đến Nepal cũng để leo n&uacute;i, v&agrave; khi đ&atilde; đi rồi th&igrave; thấy số tiền bỏ ra ho&agrave;n to&agrave;n xứng đ&aacute;ng.</p>\r\n','Đất nước láng giềng của Việt Nam không chỉ nổi tiếng với Angkor Wat - một trong bảy kỳ quan của thế giới hiện đại, mà còn nổi tiếng là một đất nước du lịch với giá r','1-hoi-an_resize.jpg','/2016-07/','Phú Quốc đẹp ngỡ ngàng qua góc máy Tâm Bùi','Phú Quốc đẹp ngỡ ngàng qua góc máy Tâm Bùi','','Đất nước láng giềng của Việt Nam không chỉ nổi tiếng với Angkor Wat - một trong bảy kỳ quan của thế giới hiện đại, mà còn nổi tiếng là một đất nước du lịch với giá r','Phú Quốc đẹp ngỡ ngàng qua góc máy Tâm Bùi',10,0,0,0,1469441541,NULL,'quyettv',NULL,'',0,0,0,NULL,1469441473,1,NULL);

/*Table structure for table `article_category` */

DROP TABLE IF EXISTS `article_category`;

CREATE TABLE `article_category` (
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
  KEY `fk_parent_idx` (`parent_id`),
  CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `article_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `article_category` */

insert  into `article_category`(`id`,`name`,`label`,`slug`,`old_slugs`,`parent_id`,`description`,`long_description`,`meta_title`,`meta_description`,`meta_keywords`,`h1`,`page_title`,`image`,`banner`,`image_path`,`status`,`is_hot`,`sort_order`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_active`,`type`) values (173,'Du lịch trong nước','','du-lich-trong-nuoc','',NULL,'','<p>welcome to vietnam</p>\r\n','Du lịch trong nước','','','Du lịch trong nước','Du lịch trong nước','','','/2016-07/',0,0,1,1469440849,1469443892,'quyettv','quyettv',1,NULL),(174,'Du lịch nước ngoài','','du-lich-nuoc-ngoai','',NULL,'','','Du lịch nước ngoài','','','Du lịch nước ngoài','Du lịch nước ngoài','','','/2016-07/',0,0,2,1469440864,NULL,'quyettv',NULL,1,NULL),(175,'Cẩm nang du lịch','','cam-nang-du-lich','',NULL,'','','Cẩm nang du lịch','','','Cẩm nang du lịch','Cẩm nang du lịch','','','/2016-07/',0,0,3,1469440879,1469441269,'quyettv','quyettv',1,NULL);

/*Table structure for table `article_to_article_category` */

DROP TABLE IF EXISTS `article_to_article_category`;

CREATE TABLE `article_to_article_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`article_id`,`article_category_id`),
  KEY `fk_article_category_id_idx` (`article_category_id`),
  CONSTRAINT `fk_article_category_id` FOREIGN KEY (`article_category_id`) REFERENCES `article_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=660 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `article_to_article_category` */

insert  into `article_to_article_category`(`id`,`article_id`,`article_category_id`) values (64,265,133),(65,266,169),(66,267,169),(67,268,133),(68,269,169),(69,270,133),(70,271,169),(71,272,133),(72,273,169),(73,274,133),(74,275,169),(75,276,133),(76,277,169),(77,278,133),(78,279,133),(79,280,169),(80,281,133),(81,282,169),(82,283,133),(83,284,169),(84,285,169),(85,286,133),(86,287,169),(87,288,133),(88,289,133),(89,290,169),(90,291,169),(91,292,133),(92,293,169),(93,294,133),(94,296,133),(95,297,133),(96,298,169),(97,299,169),(98,300,133),(99,301,133),(100,302,169),(101,303,133),(102,304,169),(103,305,169),(104,306,133),(105,307,133),(106,308,169),(107,309,133),(108,310,169),(109,311,169),(110,312,133),(111,313,169),(112,314,169),(113,315,133),(114,316,133),(115,317,133),(116,318,169),(117,319,133),(118,320,169),(119,321,133),(120,322,169),(121,323,133),(122,324,169),(123,325,133),(124,326,169),(125,327,169),(126,328,133),(127,329,169),(128,330,133),(129,331,133),(130,332,169),(131,333,169),(132,334,133),(133,335,169),(134,336,133),(135,337,169),(136,338,133),(137,339,133),(138,340,169),(139,341,133),(140,342,169),(141,343,169),(142,344,133),(143,345,169),(144,346,133),(145,347,169),(146,348,133),(147,349,169),(148,350,133),(149,351,133),(150,352,169),(151,353,133),(152,354,169),(153,355,133),(154,356,169),(155,357,169),(156,358,133),(157,359,169),(158,360,133),(159,361,169),(160,362,133),(161,363,169),(162,364,133),(163,365,133),(164,366,169),(165,367,169),(166,368,133),(167,369,133),(168,370,169),(169,371,169),(170,372,133),(171,373,133),(172,374,169),(173,375,169),(174,376,133),(175,377,133),(176,378,169),(177,379,169),(178,380,133),(179,381,133),(180,382,169),(181,383,169),(182,384,133),(183,385,169),(184,386,133),(185,387,133),(186,388,169),(187,389,169),(188,390,133),(189,391,133),(190,392,169),(191,393,169),(192,394,133),(193,395,169),(194,396,133),(195,397,133),(196,398,169),(197,399,169),(198,400,133),(199,401,133),(200,402,169),(201,403,133),(202,404,169),(203,405,169),(204,406,133),(205,407,133),(206,408,169),(207,409,133),(208,410,169),(209,411,133),(210,412,169),(211,413,133),(212,414,169),(214,416,169),(215,417,133),(216,418,169),(217,419,133),(218,420,133),(219,421,169),(220,422,133),(221,423,169),(222,424,169),(223,425,133),(224,426,169),(225,427,133),(226,428,133),(227,429,169),(228,430,133),(229,431,169),(230,432,169),(231,433,133),(232,434,169),(233,435,133),(234,436,169),(235,437,133),(236,438,133),(237,439,169),(238,440,169),(239,441,133),(240,442,133),(241,443,169),(242,444,133),(243,445,169),(244,446,169),(245,447,133),(246,448,133),(247,449,169),(248,450,169),(249,451,133),(250,452,133),(251,453,169),(252,454,169),(253,455,133),(254,456,133),(255,457,169),(256,458,169),(257,459,133),(258,460,133),(259,461,169),(260,462,169),(261,463,133),(262,464,133),(263,465,169),(264,466,169),(265,467,133),(266,468,133),(267,469,169),(268,470,169),(269,471,133),(270,472,133),(271,473,169),(272,474,169),(273,475,133),(274,476,133),(275,477,169),(276,478,169),(277,479,133),(278,480,133),(279,481,169),(280,482,169),(281,483,133),(282,484,133),(283,485,169),(348,486,169),(285,487,133),(286,488,133),(287,489,169),(288,490,169),(289,491,133),(290,492,133),(291,493,169),(292,494,169),(293,495,133),(294,496,133),(295,497,169),(296,498,169),(297,499,133),(298,500,133),(299,501,169),(300,502,169),(301,503,133),(302,504,169),(303,505,133),(304,506,133),(305,507,169),(350,508,169),(307,509,133),(308,510,133),(309,511,169),(310,512,171),(311,513,172),(312,514,133),(313,515,169),(314,516,171),(315,517,172),(316,518,133),(317,519,169),(318,520,171),(319,521,172),(320,523,172),(321,524,171),(322,525,169),(323,526,133),(324,527,133),(325,528,169),(326,529,171),(327,530,172),(328,531,172),(329,532,171),(330,533,169),(331,534,133),(332,535,133),(333,536,169),(334,537,171),(335,538,172),(336,539,172),(337,540,171),(338,541,169),(339,542,133),(340,543,133),(349,544,169),(342,545,171),(343,546,172),(344,547,172),(345,548,171),(346,549,169),(347,550,133),(351,551,133),(352,552,169),(353,553,171),(354,554,172),(355,555,172),(356,556,171),(357,557,169),(358,558,133),(359,559,133),(360,560,169),(361,561,171),(362,562,172),(363,563,172),(364,564,171),(365,565,169),(366,566,133),(367,567,133),(368,568,169),(369,569,171),(370,570,172),(371,571,172),(372,572,171),(403,573,169),(374,574,133),(375,575,133),(376,576,169),(377,577,171),(378,578,172),(379,579,172),(380,580,171),(381,581,169),(382,582,133),(383,583,133),(384,584,169),(385,585,171),(386,586,172),(387,587,172),(388,588,171),(389,589,169),(390,590,133),(391,591,133),(392,592,169),(393,593,171),(394,594,172),(395,595,172),(396,596,171),(397,597,169),(398,598,133),(399,599,133),(400,600,169),(401,601,171),(402,602,172),(404,603,172),(405,604,171),(406,605,169),(407,606,133),(408,607,133),(409,608,169),(410,609,171),(411,610,172),(412,611,172),(413,612,171),(414,613,169),(415,614,133),(416,615,133),(417,616,169),(418,617,171),(419,618,172),(420,619,172),(421,620,171),(422,621,169),(423,622,133),(424,623,133),(425,624,169),(426,625,171),(427,626,172),(428,627,133),(429,628,169),(430,629,171),(431,630,172),(432,631,172),(433,632,171),(434,633,169),(435,634,133),(436,635,133),(437,636,169),(438,637,171),(439,638,172),(440,639,169),(441,640,133),(442,641,172),(443,642,171),(444,643,133),(445,644,169),(446,645,171),(447,646,172),(448,647,133),(449,648,169),(450,649,172),(451,650,171),(452,651,169),(453,652,133),(454,653,172),(455,654,171),(456,655,169),(457,656,133),(458,657,171),(459,658,172),(460,659,169),(461,660,133),(462,661,172),(463,662,171),(464,663,169),(465,664,133),(466,665,171),(467,666,172),(468,667,169),(472,671,133),(473,672,172),(474,673,171),(475,674,169),(476,675,133),(477,676,171),(478,677,172),(479,678,169),(480,679,133),(481,680,172),(482,681,171),(483,682,169),(484,683,133),(485,684,172),(486,685,171),(487,686,169),(488,687,133),(489,688,171),(490,689,172),(491,690,169),(492,691,133),(493,692,172),(494,693,171),(495,694,169),(496,695,133),(497,696,171),(498,697,172),(499,698,169),(500,699,133),(501,700,172),(502,701,171),(503,702,169),(504,703,133),(505,704,172),(506,705,171),(507,706,169),(508,707,133),(509,708,172),(510,709,171),(515,710,169),(512,711,133),(513,712,172),(514,713,171),(516,714,169),(517,715,133),(518,716,171),(519,717,172),(520,718,169),(521,719,133),(522,720,172),(523,721,171),(524,722,169),(525,723,133),(526,724,171),(527,725,172),(528,726,169),(529,727,133),(530,728,172),(531,729,171),(532,730,169),(533,731,133),(534,732,172),(535,733,171),(536,734,169),(537,735,133),(538,736,172),(539,737,171),(540,738,169),(541,739,133),(542,740,172),(543,741,171),(544,742,169),(545,743,133),(546,744,171),(547,745,172),(548,746,169),(549,747,133),(550,748,172),(551,749,171),(552,750,169),(553,751,133),(554,752,171),(555,753,172),(556,754,169),(557,755,133),(558,756,172),(559,757,171),(560,758,169),(561,759,133),(562,760,172),(563,761,171),(564,762,169),(565,763,133),(566,764,171),(567,765,171),(568,766,169),(569,767,133),(570,768,172),(571,769,171),(572,770,169),(573,771,133),(574,772,171),(575,773,172),(576,774,169),(577,775,133),(578,776,172),(579,777,171),(580,778,169),(581,779,133),(582,780,171),(583,781,172),(584,782,169),(585,783,133),(586,784,172),(587,785,171),(588,786,169),(589,787,133),(590,788,172),(591,789,171),(592,790,169),(593,791,133),(594,792,172),(595,793,171),(596,794,169),(597,795,133),(598,796,172),(599,797,171),(600,798,169),(601,799,133),(602,800,171),(603,801,172),(604,802,169),(605,803,133),(606,804,172),(607,805,171),(608,806,169),(609,807,133),(610,808,171),(611,809,172),(612,810,169),(613,811,133),(614,812,172),(615,813,171),(616,814,169),(617,815,133),(618,816,171),(619,817,172),(620,818,169),(621,819,133),(622,820,172),(623,821,171),(624,822,169),(625,823,133),(626,824,172),(627,825,171),(628,826,133),(629,827,169),(630,828,171),(631,829,172),(632,830,133),(633,831,169),(634,832,172),(635,833,171),(636,834,133),(637,835,169),(638,836,171),(639,837,172),(640,838,133),(641,839,169),(642,840,172),(643,841,171),(644,842,133),(645,843,169),(646,844,171),(647,845,172),(648,846,133),(649,847,169),(650,848,172),(651,849,171),(652,850,133),(653,851,169),(654,852,172),(655,853,171),(656,854,133),(657,855,169),(658,856,171),(659,857,172);

/*Table structure for table `article_to_tag` */

DROP TABLE IF EXISTS `article_to_tag`;

CREATE TABLE `article_to_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`article_id`,`tag_id`),
  KEY `fk_tag_id_idx` (`tag_id`),
  CONSTRAINT `fk2_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `article_to_tag` */

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_assignment` */

insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('ADMIN','1',1452756262),('ADMIN','2',1458818801),('ADMIN','8',1458818771),('WRITTER','10',1458818757),('WRITTER','3',1458818790),('WRITTER','4',1458818786),('WRITTER','6',1458818781),('WRITTER','7',1458818775),('WRITTER','9',1458818764);

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item` */

insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/*',2,NULL,NULL,NULL,1452681631,1452681631),('/admin/*',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/assignment/*',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/assignment/assign',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/assignment/index',2,NULL,NULL,NULL,1452755712,1452755712),('/admin/assignment/revoke',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/assignment/search',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/assignment/view',2,NULL,NULL,NULL,1452756200,1452756200),('/admin/default/*',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/default/index',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/*',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/create',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/delete',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/index',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/update',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/menu/view',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/permission/*',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/permission/assign',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/permission/create',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/permission/delete',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/permission/index',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/permission/remove',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/permission/search',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/permission/update',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/permission/view',2,NULL,NULL,NULL,1452756219,1452756219),('/admin/role/*',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/assign',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/create',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/delete',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/index',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/remove',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/role/search',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/update',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/role/view',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/route/*',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/route/assign',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/route/create',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/route/index',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/route/refresh',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/route/remove',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/route/search',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/*',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/create',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/delete',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/index',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/update',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/rule/view',2,NULL,NULL,NULL,1452756220,1452756220),('/admin/user/*',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/activate',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/change-password',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/delete',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/user/index',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/user/login',2,NULL,NULL,NULL,1458818669,1458818669),('/admin/user/logout',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/reset-password',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/signup',2,NULL,NULL,NULL,1458818670,1458818670),('/admin/user/view',2,NULL,NULL,NULL,1458818669,1458818669),('/article-category/*',2,NULL,NULL,NULL,1458818670,1458818670),('/article-category/create',2,NULL,NULL,NULL,1458818670,1458818670),('/article-category/delete',2,NULL,NULL,NULL,1458818670,1458818670),('/article-category/index',2,NULL,NULL,NULL,1458818670,1458818670),('/article-category/update',2,NULL,NULL,NULL,1458818670,1458818670),('/article-category/view',2,NULL,NULL,NULL,1458818670,1458818670),('/article/*',2,NULL,NULL,NULL,1452762763,1452762763),('/article/create',2,NULL,NULL,NULL,1452762763,1452762763),('/article/delete',2,NULL,NULL,NULL,1452762763,1452762763),('/article/index',2,NULL,NULL,NULL,1452762763,1452762763),('/article/update',2,NULL,NULL,NULL,1452762763,1452762763),('/article/view',2,NULL,NULL,NULL,1452762763,1452762763),('/base/*',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/*',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/*',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/db-explain',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/download-mail',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/index',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/toolbar',2,NULL,NULL,NULL,1452756221,1452756221),('/debug/default/view',2,NULL,NULL,NULL,1452756221,1452756221),('/file/*',2,NULL,NULL,NULL,1458818670,1458818670),('/file/ckeditor-upload-image',2,NULL,NULL,NULL,1458818670,1458818670),('/gii/*',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/*',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/action',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/diff',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/index',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/preview',2,NULL,NULL,NULL,1452756221,1452756221),('/gii/default/view',2,NULL,NULL,NULL,1452756221,1452756221),('/redirect-url/*',2,NULL,NULL,NULL,1458818670,1458818670),('/redirect-url/create',2,NULL,NULL,NULL,1458818670,1458818670),('/redirect-url/delete',2,NULL,NULL,NULL,1458818670,1458818670),('/redirect-url/index',2,NULL,NULL,NULL,1458818670,1458818670),('/redirect-url/update',2,NULL,NULL,NULL,1458818670,1458818670),('/redirect-url/view',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/*',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/create',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/delete',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/index',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/update',2,NULL,NULL,NULL,1458818670,1458818670),('/seo-info/view',2,NULL,NULL,NULL,1458818670,1458818670),('/site/*',2,NULL,NULL,NULL,1452756221,1452756221),('/site/error',2,NULL,NULL,NULL,1452756221,1452756221),('/site/index',2,NULL,NULL,NULL,1452756221,1452756221),('/site/login',2,NULL,NULL,NULL,1452756221,1452756221),('/site/logout',2,NULL,NULL,NULL,1452756221,1452756221),('/tag/*',2,NULL,NULL,NULL,1458818670,1458818670),('/tag/create',2,NULL,NULL,NULL,1458818670,1458818670),('/tag/delete',2,NULL,NULL,NULL,1458818670,1458818670),('/tag/index',2,NULL,NULL,NULL,1458818670,1458818670),('/tag/update',2,NULL,NULL,NULL,1458818670,1458818670),('/tag/view',2,NULL,NULL,NULL,1458818670,1458818670),('/test/*',2,NULL,NULL,NULL,1458818670,1458818670),('/user-action-log/*',2,NULL,NULL,NULL,1452756221,1452756221),('/user-action-log/create',2,NULL,NULL,NULL,1452756221,1452756221),('/user-action-log/delete',2,NULL,NULL,NULL,1452756221,1452756221),('/user-action-log/index',2,NULL,NULL,NULL,1452756221,1452756221),('/user-action-log/update',2,NULL,NULL,NULL,1452756221,1452756221),('/user-action-log/view',2,NULL,NULL,NULL,1452756221,1452756221),('/user-log/*',2,NULL,NULL,NULL,1458818670,1458818670),('/user-log/create',2,NULL,NULL,NULL,1458818670,1458818670),('/user-log/delete',2,NULL,NULL,NULL,1458818670,1458818670),('/user-log/index',2,NULL,NULL,NULL,1458818670,1458818670),('/user-log/update',2,NULL,NULL,NULL,1458818670,1458818670),('/user-log/view',2,NULL,NULL,NULL,1458818670,1458818670),('/user/*',2,NULL,NULL,NULL,1452756221,1452756221),('/user/create',2,NULL,NULL,NULL,1452756221,1452756221),('/user/delete',2,NULL,NULL,NULL,1452756221,1452756221),('/user/index',2,NULL,NULL,NULL,1452756221,1452756221),('/user/update',2,NULL,NULL,NULL,1452756221,1452756221),('/user/view',2,NULL,NULL,NULL,1452756221,1452756221),('ADMIN',2,NULL,NULL,NULL,1452681715,1452762771),('WRITTER',2,NULL,NULL,NULL,1458818621,1459495594);

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item_child` */

insert  into `auth_item_child`(`parent`,`child`) values ('ADMIN','/*'),('ADMIN','/admin/*'),('ADMIN','/admin/assignment/*'),('ADMIN','/admin/assignment/assign'),('ADMIN','/admin/assignment/index'),('ADMIN','/admin/assignment/search'),('ADMIN','/admin/assignment/view'),('ADMIN','/admin/default/*'),('ADMIN','/admin/default/index'),('ADMIN','/admin/menu/*'),('ADMIN','/admin/menu/create'),('ADMIN','/admin/menu/delete'),('ADMIN','/admin/menu/index'),('ADMIN','/admin/menu/update'),('ADMIN','/admin/menu/view'),('ADMIN','/admin/permission/*'),('ADMIN','/admin/permission/assign'),('ADMIN','/admin/permission/create'),('ADMIN','/admin/permission/delete'),('ADMIN','/admin/permission/index'),('ADMIN','/admin/permission/search'),('ADMIN','/admin/permission/update'),('ADMIN','/admin/permission/view'),('ADMIN','/admin/role/*'),('ADMIN','/admin/role/assign'),('ADMIN','/admin/role/create'),('ADMIN','/admin/role/delete'),('ADMIN','/admin/role/index'),('ADMIN','/admin/role/search'),('ADMIN','/admin/role/update'),('ADMIN','/admin/role/view'),('ADMIN','/admin/route/*'),('ADMIN','/admin/route/assign'),('ADMIN','/admin/route/create'),('ADMIN','/admin/route/index'),('ADMIN','/admin/route/search'),('ADMIN','/admin/rule/*'),('ADMIN','/admin/rule/create'),('ADMIN','/admin/rule/delete'),('ADMIN','/admin/rule/index'),('ADMIN','/admin/rule/update'),('ADMIN','/admin/rule/view'),('ADMIN','/article/*'),('ADMIN','/article/create'),('ADMIN','/article/delete'),('ADMIN','/article/index'),('ADMIN','/article/update'),('ADMIN','/article/view'),('ADMIN','/base/*'),('ADMIN','/debug/*'),('ADMIN','/debug/default/*'),('ADMIN','/debug/default/db-explain'),('ADMIN','/debug/default/download-mail'),('ADMIN','/debug/default/index'),('ADMIN','/debug/default/toolbar'),('ADMIN','/debug/default/view'),('ADMIN','/gii/*'),('ADMIN','/gii/default/*'),('ADMIN','/gii/default/action'),('ADMIN','/gii/default/diff'),('ADMIN','/gii/default/index'),('ADMIN','/gii/default/preview'),('ADMIN','/gii/default/view'),('ADMIN','/site/*'),('ADMIN','/site/error'),('ADMIN','/site/index'),('ADMIN','/site/login'),('ADMIN','/site/logout'),('ADMIN','/user-action-log/*'),('ADMIN','/user-action-log/create'),('ADMIN','/user-action-log/delete'),('ADMIN','/user-action-log/index'),('ADMIN','/user-action-log/update'),('ADMIN','/user-action-log/view'),('ADMIN','/user/*'),('ADMIN','/user/create'),('ADMIN','/user/delete'),('ADMIN','/user/index'),('ADMIN','/user/update'),('ADMIN','/user/view'),('WRITTER','/article-category/index'),('WRITTER','/article-category/view'),('WRITTER','/article/*'),('WRITTER','/article/create'),('WRITTER','/article/delete'),('WRITTER','/article/index'),('WRITTER','/article/update'),('WRITTER','/article/view'),('WRITTER','/base/*'),('WRITTER','/file/*'),('WRITTER','/file/ckeditor-upload-image'),('WRITTER','/redirect-url/*'),('WRITTER','/redirect-url/create'),('WRITTER','/redirect-url/delete'),('WRITTER','/redirect-url/index'),('WRITTER','/redirect-url/update'),('WRITTER','/redirect-url/view'),('WRITTER','/seo-info/*'),('WRITTER','/seo-info/create'),('WRITTER','/seo-info/delete'),('WRITTER','/seo-info/index'),('WRITTER','/seo-info/update'),('WRITTER','/seo-info/view'),('WRITTER','/site/*'),('WRITTER','/site/error'),('WRITTER','/site/index'),('WRITTER','/site/login'),('WRITTER','/site/logout'),('WRITTER','/tag/*'),('WRITTER','/tag/create'),('WRITTER','/tag/delete'),('WRITTER','/tag/index'),('WRITTER','/tag/update'),('WRITTER','/tag/view'),('WRITTER','/user-log/*'),('WRITTER','/user-log/create'),('WRITTER','/user-log/index'),('WRITTER','/user-log/update'),('WRITTER','/user-log/view'),('WRITTER','/user/index'),('WRITTER','/user/update'),('WRITTER','/user/view');

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_rule` */

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1452583193),('m130524_201442_init',1452583674);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
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
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`category_id`,`name`,`label`,`slug`,`code`,`old_slugs`,`price`,`original_price`,`image`,`banner`,`image_path`,`description`,`long_description`,`details`,`content`,`page_title`,`h1`,`meta_title`,`meta_description`,`meta_keywords`,`is_hot`,`is_active`,`status`,`sort_order`,`view_count`,`like_count`,`share_count`,`comment_count`,`published_at`,`created_at`,`updated_at`,`created_by`,`updated_by`,`auth_alias`,`available_quantity`,`order_quantity`,`sold_quantity`,`total_quantity`,`total_revenue`,`review_score`,`manufacturer`,`color`,`malterial`,`style`,`use_duration`,`manufacturing_date`,`size`,`weight`,`ingredient`,`model`,`type`) values (1,NULL,'đồ gỗ mỹ nghệ','','do-go-my-nghe','dgmn',NULL,500000,600000,'10-[2].jpg','12825497_10153970457889609_1189245057_n.jpg','/2016/03/14/QD/','đồ gỗ mỹ nghệ','<p>ffgfggf</p>\r\n','<p>fgfgfg<img alt=\"\" src=\"http://localhost/tdhome.vn/frontend/web/images/2016/03/14/QD/13-[--8].jpg\" style=\"height:593px; width:1000px\" /></p>\r\n',NULL,'đồ gỗ mỹ nghệ','đồ gỗ mỹ nghệ','đồ gỗ mỹ nghệ','đồ gỗ mỹ nghệ','đồ gỗ mỹ nghệ, do go my nghe',0,1,NULL,NULL,NULL,NULL,NULL,NULL,1457945172,1457945266,NULL,'quyettv',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','','',NULL),(2,NULL,'Chè vằng công nghệ cao','','che-vang-cong-nghe-cao','','',NULL,NULL,'','','/201608/','','','',NULL,'Chè vằng công nghệ cao','Chè vằng công nghệ cao','Chè vằng công nghệ cao','','',0,0,NULL,NULL,0,0,0,0,1470026322,1470026342,NULL,'quyettv',NULL,NULL,0,0,0,0,0,0,'','','','','','','','','','',NULL),(3,NULL,'Cao chè vằng công nghệ cao','','cao-che-vang-cong-nghe-cao','','',NULL,NULL,'cao-che-vang-cong-nghe-cao-1.jpg','','/201608/','Cao chè vằng công nghệ cao giúp lợi sữa, giảm cân, da mịn màng, thanh nhiệt thải độc. Là loại cao được sản xuất trên hệ thống dây chuyền đạt tiêu chuẩn Quốc tế GMP-WHO đồng thời được BYT chứng nhận chất lượng sản phẩm.','<p><span style=\"color:rgb(29, 33, 41); font-family:helvetica,arial,sans-serif\">Ch&egrave; vằng được sử dụng từ rất l&acirc;u tại c&aacute;c tỉnh Miền Trung nhưng c&oacute; lẽ nhiều người vẫn chưa biết được t&aacute;c dụng của loại c&acirc;y được mệnh danh l&agrave; &quot;thần dược cho phụ nữ sau sinh n&agrave;y&quot;</span></p>\r\n\r\n<p style=\"text-align:justify\"><strong>L&aacute; ch&egrave; vằng c&oacute; một số t&aacute;c dụng sau đ&acirc;y:</strong></p>\r\n\r\n<p style=\"text-align:justify\">- Lợi sữa, tăng tiết sữa</p>\r\n\r\n<p style=\"text-align:justify\">- T&aacute;c&nbsp;dụng kh&aacute;ng khuẩn, chống vi&ecirc;m, l&agrave;m tăng nhanh t&aacute;i tạo tổ chức, l&agrave;m vết thương mau l&agrave;nh, th&ocirc;ng huyết, điều kinh, cải thiện sự lưu th&ocirc;ng m&aacute;u. V&igrave; vậy được sử dụng ph&ograve;ng chống,&nbsp;chữa trị c&aacute;c bệnh&nbsp;cho phụ nữ sau khi sinh như vi&ecirc;m nhiễm...</p>\r\n\r\n<p style=\"text-align:justify\">- Thanh nhiệt, giải&nbsp;độc, m&aacute;t gan,&nbsp;l&atilde;o ho&aacute;, tho&aacute;i ho&aacute; gan, gan nhiễm mỡ, m&aacute;u nhiễm mỡ,&nbsp;tổn thương do bức xạ</p>\r\n\r\n<p style=\"text-align:justify\">- Ngăn ngừa c&aacute;c bệnh về&nbsp;tim mạch, ngăn ngừa xơ vữa động mạch, tai biến mạch,&nbsp;cao huyết &aacute;p. Hỗ trợ qu&aacute; tr&igrave;nh&nbsp;điều trị cho c&aacute;c bệnh nh&acirc;n tiểu&nbsp;đường.&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\">- Glucozit đắng t&aacute;c&nbsp;dụng tr&ecirc;n dạ d&agrave;y v&agrave; ruột l&agrave;m tăng hưng phấn, l&agrave;m cho dạ d&agrave;y v&agrave; ruột chuyển động mạnh l&ecirc;n gi&uacute;p sự ti&ecirc;u h&oacute;a được tăng cường, ph&acirc;n mềm m&agrave; lỏng, kh&ocirc;ng g&acirc;y đau bụng n&ecirc;n được d&ugrave;ng trong trường hợp dạ d&agrave;y, gan k&eacute;m hoạt động, t&aacute;o b&oacute;n, ăn uống kh&ocirc;ng ti&ecirc;u.</p>\r\n\r\n<p style=\"text-align:justify\">- Ph&ograve;ng chống ung thư.</p>\r\n\r\n<p style=\"text-align:justify\">Biết được lợi &iacute;ch to lớn v&agrave; tầm quan trọng của c&acirc;y Ch&egrave; vằng n&agrave;y, Hồng Lam Hương cho ra đời sản phẩm&nbsp;Cao ch&egrave; vằng c&ocirc;ng nghệ cao.&nbsp;Đ&acirc;y l&agrave; sản phẩm gi&uacute;p lọc được hết những tinh t&uacute;y của Ch&egrave; vằng, đồng thời loại bỏ cặn b&atilde;, quy tr&igrave;nh đ&oacute;ng g&oacute;i ti&ecirc;u chuẩn gi&uacute;p người d&ugrave;ng dễ d&agrave;ng sử dụng v&agrave; bảo quản.</p>\r\n\r\n<p style=\"text-align:justify\"><a href=\"http://honglamhuong.com/san-pham/cao-che-vang.html\" style=\"box-sizing: border-box; text-decoration: none; color: rgb(0, 122, 207);\"><strong>Cao ch&egrave; Vằng c&ocirc;ng nghệ cao</strong></a>&nbsp;l&agrave; sản phẩm cao ch&egrave; vằng duy nhất tr&ecirc;n thị trường chiết xuất được tối đa&nbsp;hoạt chất Flavonoid.&nbsp;Đ&acirc;y l&agrave; hợp chất oxy h&oacute;a mạnh c&oacute;&nbsp;t&aacute;c dụng ph&ograve;ng chống ung thư.</p>\r\n\r\n<p style=\"text-align:center\"><img alt=\"\" src=\"http://localhost/honglamhuong.com/frontend/web/images/201608/cao-che-vang-cong-nghe-cao-Hong-Lam-Huong(1).jpg\" style=\"box-sizing:border-box; height:350px; max-width:100%; width:500px\" /></p>\r\n\r\n<p style=\"text-align:center\"><em>Quy c&aacute;ch đ&oacute;ng hộp đạt ti&ecirc;u chuẩn chất lượng đ&oacute;ng g&oacute;i của Bộ Y Tế</em></p>\r\n\r\n<p>Hiện nay c&aacute;c sản phẩm từ ch&egrave; vằng rất đa dạng: l&aacute; c&agrave;nh, tr&agrave; t&uacute;i lọc, cao hay vi&ecirc;n nang nhưng d&ograve;ng cao chiết xuất từ ch&egrave; vằng vẫn được nhiều người sử dụng nhất, bởi sự tiện dụng.<br />\r\nNhưng &nbsp;c&ocirc;ng nghệ chiết cao tr&ecirc;n thị trường c&ograve;n th&ocirc; sơ, chủ yếu l&agrave; nấu theo phương ph&aacute;p thủ c&ocirc;ng. H&igrave;nh thức chiết n&agrave;y thời gian l&acirc;u, lửa v&agrave; nhiệt độ kh&ocirc;ng đều dẫn đến c&aacute;c th&agrave;nh phần ch&iacute;nh trong c&acirc;y ch&egrave; vằng như Flavonoid, Ancaloid, Glycozit đắng bị ph&acirc;n hủy với nhiệt độ. Nồi chứa ch&egrave; vằng th&ocirc;ng thường n&ecirc;n kh&ocirc;ng giữ được hương, c&aacute;ch nhiệt k&eacute;m dẫn đến qu&aacute; tr&igrave;nh c&ocirc; cao bị ch&aacute;y n&ecirc;n khi uống cao thường đắng gắt . Mặt kh&aacute;c quy tr&igrave;nh sản xuất kh&ocirc;ng kh&eacute;p k&iacute;n, mang t&iacute;nh tự ph&aacute;t n&ecirc;n chất lượng cao kh&ocirc;ng đảm bảo bởi nguồn nước, vệ sinh&hellip;.. N&ecirc;n sản phẩm cao ch&egrave; vằng tr&ecirc;n thị trường c&oacute; nhiều tạp chất, nước đục, đắng gắt v&agrave; kh&ocirc;ng thơm.</p>\r\n\r\n<p>Với c&ocirc;ng nghệ chiết cao đạt ti&ecirc;u chuẩn Quốc tế GMP-WHO, quy tr&igrave;nh sản xuất kh&eacute;p k&iacute;n, thời gian chiết v&agrave; sấy nhanh n&ecirc;n c&aacute;c th&agrave;nh phần Flavonoid, Ancaloid, Glucozit đắng kh&ocirc;ng bị ph&acirc;n hủy trong nhiệt. Bởi vậy sản phẩm Cao ch&egrave; vằng C&ocirc;ng nghệ cao của Cty TNHH Hồng Lam Hương cho ra sản phẩm chứa nhiều hoạt dược trong ch&egrave; vằng nhất đồng thời loại bỏ tối đa tạp chất n&ecirc;n hiệu quả ngay sau từng lần sử dụng.</p>\r\n\r\n<p style=\"text-align:justify\">Hồng Lam Hương cam kết&nbsp;<strong>100% chiết xuất từ&nbsp;<a href=\"http://honglamhuong.com/\" style=\"box-sizing: border-box; text-decoration: none; color: rgb(0, 122, 207);\">ch&egrave; vằng</a></strong>.&nbsp;Sản phẩm kh&ocirc;ng pha trộn chất tạo hương, tạo đắng, c&aacute;c loại bột để nhằm tăng số lượng n&ecirc;n khi uống vị đắng kh&ocirc;ng gắt, hương thơm tự nhi&ecirc;n v&agrave; đặc biệt nước trong.&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><img alt=\"\" src=\"http://localhost/honglamhuong.com/frontend/web/images/201608/cao-che-vang-cong-nghe-cao-hong-lam-huon.jpg\" style=\"box-sizing:border-box; height:380px; max-width:100%; width:500px\" /></p>\r\n\r\n<p style=\"text-align:center\"><em>Sản phẩm Cao ch&egrave; vằng C&ocirc;ng nghệ cao cho ra nước trong, kh&ocirc;ng c&oacute; cặn, tạp chất đồng thời hương thơm tự nhi&ecirc;n v&agrave; kh&ocirc;ng đắng gắt</em></p>\r\n\r\n<p style=\"text-align:justify\"><strong>Cao ch&egrave; vằng c&ocirc;ng nghệ cao rất tốt cho:</strong></p>\r\n\r\n<p style=\"text-align:justify\"><strong>-&nbsp;</strong>Phụ nữ sau khi sinh gi&uacute;p lợi sữa, tắc tia sữa, nhanh lấy lại v&oacute;c d&aacute;ng.</p>\r\n\r\n<p style=\"text-align:justify\">- Người muốn giảm c&acirc;n.</p>\r\n\r\n<p style=\"text-align:justify\">- Người&nbsp;c&oacute; chức năng gan hoạt động k&eacute;m như:&nbsp;n&oacute;ng trong, thường xuy&ecirc;n nổi mẩn ngứa mụn nhọt. Người uống nhiều&nbsp;rượu bia. Người c&oacute; men gan cao, gan bị nhiễm mỡ</p>\r\n\r\n<p style=\"text-align:justify\">- Người bị tim mạnh, huyết &aacute;o cao</p>\r\n\r\n<p style=\"text-align:justify\">- Người kh&oacute; ăn, ăn uống kh&ocirc;ng ti&ecirc;u, bị đầy bụng.</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Chống chỉ định với</strong></p>\r\n\r\n<p style=\"text-align:justify\">- Phụ nữ đang mang thai</p>\r\n\r\n<p style=\"text-align:justify\">- Người huyết &aacute;p thấp</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Hướng dẫn sử dụng:</strong></p>\r\n\r\n<p style=\"text-align:justify\">Cho 0,5gr khoảng 1/4 th&igrave;a cao kh&ocirc; v&agrave;o 100ml n&oacute;ng (80oC &ndash; 100oC) hoặc tỷ lệ kh&aacute;c t&ugrave;y thuộc v&agrave;o nhu cầu v&agrave; sở th&iacute;ch sử dụng của từng người. Sử dụng l&agrave;m nước uống hằng ng&agrave;y cho gia đ&igrave;nh. C&oacute; thể uống n&oacute;ng hoặc lạnh. Ngon hơn khi sử dụng với đường Ph&egrave;n.</p>\r\n\r\n<p style=\"text-align:justify\"><strong>Ch&uacute; &yacute;:</strong>&nbsp;Đối với phụ nữ sau sinh c&oacute; thể sử dụng từ 1,5gr-3gr/ng&agrave;y c&ograve;n lại c&aacute;c đối tượng sử dụng n&ecirc;n 1,5gr/ng&agrave;y.</p>\r\n','',NULL,'Cao chè vằng công nghệ cao','Cao chè vằng công nghệ cao','Cao chè vằng công nghệ cao','Cao chè vằng công nghệ cao giúp lợi sữa, giảm cân, da mịn màng, thanh nhiệt thải độc. Là loại cao được sản xuất trên hệ thống dây chuyền đạt tiêu chuẩn Quốc tế GMP-WHO đồng thời được BYT chứng nhận chất lượng sản phẩm.',' Cao chè vằng lợi sữa giảm cân thanh nhiệt giải độc mát gan trị mụn, Cao che vang loi sua giam can thanh nhiet giai doc mat gan tri mun ',0,1,NULL,NULL,0,0,0,0,1470448295,1470448367,NULL,'quyettv',NULL,NULL,0,0,0,0,0,0,'','','','','','','','','','',NULL);

/*Table structure for table `product_category` */

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category` (
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
  KEY `fk2_parent_idx` (`parent_id`),
  CONSTRAINT `fk2_parent` FOREIGN KEY (`parent_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_category` */

/*Table structure for table `product_image` */

DROP TABLE IF EXISTS `product_image`;

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_id_idx` (`product_id`),
  CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_image` */

insert  into `product_image`(`id`,`product_id`,`image`,`image_path`,`color`,`sort_order`) values (9,1,'11.jpg','/2016/03/14/BL/','#ff9900',NULL),(10,1,'14.jpg','/2016/03/14/wM/','#ff9900',NULL),(11,1,'10-[2].jpg','/2016/03/14/Ug/','#ff0000',NULL),(12,2,'3.jpg','/201608/',NULL,NULL),(13,2,'4.jpg','/201608/',NULL,NULL);

/*Table structure for table `product_to_product_category` */

DROP TABLE IF EXISTS `product_to_product_category`;

CREATE TABLE `product_to_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`product_category_id`,`product_id`),
  KEY `fk_product_category_id_idx` (`product_category_id`),
  KEY `fk2_product_id_idx` (`product_id`),
  CONSTRAINT `fk2_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_to_product_category` */

/*Table structure for table `product_to_tag` */

DROP TABLE IF EXISTS `product_to_tag`;

CREATE TABLE `product_to_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `product_category_id` (`product_category_id`),
  CONSTRAINT `product_to_tag_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_to_tag_ibfk_2` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_to_tag` */

/*Table structure for table `purchase_order` */

DROP TABLE IF EXISTS `purchase_order`;

CREATE TABLE `purchase_order` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase_order` */

insert  into `purchase_order`(`id`,`code`,`status`,`created_at`,`customer_name`,`customer_email`,`customer_phone_number`,`customer_address`,`customer_address_2`,`customer_city`,`customer_note`,`user_note`,`updated_at`,`updated_by`,`shipping_fee`,`shipping_duration`) values (1,'000010816',NULL,1470360298,'','','','','','','','',NULL,NULL,NULL,'');

/*Table structure for table `purchase_order_detail` */

DROP TABLE IF EXISTS `purchase_order_detail`;

CREATE TABLE `purchase_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_order_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  KEY `purchase_order_detail_ibfk_2` (`product_id`),
  CONSTRAINT `purchase_order_detail_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `purchase_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase_order_detail` */

/*Table structure for table `redirect_url` */

DROP TABLE IF EXISTS `redirect_url`;

CREATE TABLE `redirect_url` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `redirect_url` */

/*Table structure for table `seo_info` */

DROP TABLE IF EXISTS `seo_info`;

CREATE TABLE `seo_info` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `seo_info` */

/*Table structure for table `slideshow_item` */

DROP TABLE IF EXISTS `slideshow_item`;

CREATE TABLE `slideshow_item` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `slideshow_item` */

/*Table structure for table `tag` */

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tag` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`firstname`,`lastname`,`dob`,`alias`,`gender`,`image`,`image_path`) values (1,'quyettv','IgdlVKLk-jCMNiJWMU0b4PVs7p90ZKqx','$2y$13$gvo7VgiMIeC.Z7KXu8L5uuQaaad/fLraOQHwbrFz4upGay5VbhpGO',NULL,'quyettv@hdcgroup.vn',10,0,1469442220,'Quyết','',748130400,'Văn Quyết',0,'13.jpg','/2016-07/'),(2,'huynq','OROst3vfD0dCx4SXB6EbTURZfnxdRsGp','$2y$13$gvo7VgiMIeC.Z7KXu8L5uuQaaad/fLraOQHwbrFz4upGay5VbhpGO',NULL,'huynqk50@gmail.com',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'tuvn','wvqBZxBu9XhD93jbZwZqX7HX8gYavkTy','$2y$13$FWEjHmSEY9.Zwa9iDGT67uhGf77nn0MTHz.moWbRvCLPHNxqhIRl.',NULL,'vungoctu1511@gmail.com',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'huyenvt','XfbCk7ed-q-pvYdVMV6akCsOb8r_q2g6','$2y$13$bSjMYqhspM.NlZy9KbYEEuDlkrO0bC0W0A0/yZvFO6/9OSNw/pc.6',NULL,'huyenvu88@gmail.com',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'cuongdn','DNaVI0jN_FVSxKewy2C0M-YOVqzdFcTd','$2y$13$yiAV7WdNVVMV.UIDpDFyu.uJyeYnt4r4vvzSyomPVQPDRvaq0W3Qi',NULL,'ngoccuonghdc@gmail.com',10,1458810620,1459653810,'Ngọc','Cường',725648400,'cuongdn',0,'12938123_1721724354779262_4794820678457340323_n.jpg','/2016/04/03/YD/'),(8,'cuongnm','bd_VXZpEprvBzmKGweWcMUyoaRGu1cG6','$2y$13$gvo7VgiMIeC.Z7KXu8L5uuQaaad/fLraOQHwbrFz4upGay5VbhpGO',NULL,'cuongnm@hdcgroup.vn',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'ctvxosome','xWWOE3oI6ydbCyalDUA1bC6fZsHuyXyj','$2y$13$VPciX9iG8kwDNFg89/1hhOytw5WU3OIsJJi.HAehQj1FWEwMPG0w6',NULL,'xosokt.me@gmail.com',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'sonnv','4xyAEBCKnPo-Bjc1dZDgi-MnyWttN7Y_','$2y$13$J3KYJAeOXVVcVetvhQgkLer4Oen/6ur7gNaJC/IODkXzmWCPQ2EZi',NULL,'sonnv@gmail.com',10,1458810620,1458810620,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `user_log` */

DROP TABLE IF EXISTS `user_log`;

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `is_success` tinyint(1) DEFAULT '0',
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `object_pk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_username` (`username`),
  CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2313 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_log` */

insert  into `user_log`(`id`,`username`,`action`,`created_at`,`is_success`,`object_class`,`object_pk`) values (2297,'quyettv','Create',1469440849,1,'ArticleCategory',173),(2298,'quyettv','Create',1469440864,1,'ArticleCategory',174),(2299,'quyettv','Create',1469440879,1,'ArticleCategory',175),(2300,'quyettv','Update',1469440886,1,'ArticleCategory',173),(2301,'quyettv','Update',1469440890,1,'ArticleCategory',175),(2302,'quyettv','Update',1469441264,1,'ArticleCategory',173),(2303,'quyettv','Update',1469441269,1,'ArticleCategory',175),(2304,'quyettv','Create',1469441541,1,'Article',891),(2305,'quyettv','Update',1469442194,0,'User',1),(2306,'quyettv','Update',1469442219,1,'User',1),(2307,'quyettv','Update',1469443892,1,'ArticleCategory',173),(2308,'quyettv','Create',1470026342,1,'Product',2),(2309,'quyettv','Create',1470190018,1,'ProductImage',12),(2310,'quyettv','Create',1470190139,1,'ProductImage',13),(2311,'quyettv','Create',1470360298,1,'PurchaseOrder',1),(2312,'quyettv','Create',1470448367,1,'Product',3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
