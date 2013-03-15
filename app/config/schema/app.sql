#App sql generated on: 2011-06-21 17:35:09 : 1308688509

DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `sponsorships`;
DROP TABLE IF EXISTS `cities`;
DROP TABLE IF EXISTS `links`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `follows`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `offers`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `prizes`;
DROP TABLE IF EXISTS `users_projects`;
DROP TABLE IF EXISTS `users_offers`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `notificationtypes`;
DROP TABLE IF EXISTS `notificationtype_users`;
DROP TABLE IF EXISTS `staticpages`;


CREATE TABLE `comments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) DEFAULT 0 NOT NULL,
	`model` varchar(250) DEFAULT '' NOT NULL,
	`model_id` int(11) DEFAULT 0 NOT NULL,
	`comment` text DEFAULT '' NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`reports_count` int(11) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `model` (`model`, `model_id`),
	KEY `created` (`created`),
	KEY `reports_count` (`reports_count`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `sponsorships` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`project_id` int(11) NOT NULL,
	`prize_id` int(11) NOT NULL,
	`contribution` int(11) NOT NULL,
	`status` int(11) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `created` (`created`),
	KEY `status` (`status`),
	KEY `upp_ids` (`user_id`, `project_id`, `prize_id`),
	KEY `up_ids` (`user_id`, `project_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;



CREATE TABLE `links` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(50) NOT NULL,
	`model_id` int(11) NOT NULL,
	`link` varchar(3000) NOT NULL,
	`title` varchar(140) DEFAULT NULL,
	`description` varchar(140) DEFAULT NULL,
	`media_id` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `model` (`model`, `model_id`),
	KEY `media_id` (`media_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`model` varchar(70) NOT NULL,
	`model_id` int(11) NOT NULL,
	`title` varchar(140) NOT NULL,
	`slug` varchar(200) NOT NULL,
	`description` text NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`published` datetime NOT NULL,
	`public` int(1) DEFAULT 0 NOT NULL,
	`enabled` int(1) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `model` (`model`, `model_id`),
	KEY `created` (`created`),
	KEY `slug` (`slug`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `follows` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`model` varchar(70) NOT NULL,
	`model_id` int(11) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `model` (`model`, `model_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `projects` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	`offer_id` int(11) NOT NULL,
	`title` varchar(140) NOT NULL,
	`slug` varchar(200) NOT NULL,
	`short_description` varchar(140) NOT NULL,
	`motivation` varchar(512) NOT NULL,
	`reason` varchar(512) NOT NULL,
	`description` text NOT NULL,
	`video_url` varchar(255) NOT NULL,
	`video` text NOT NULL,
	`funding_goal` int(11) NOT NULL,
	`project_duration` int(11) NOT NULL,
	`minimal_pledge` int(11) NOT NULL,
	`city_id` int(22) NOT NULL,
	`city` varchar(50) NOT NULL,
	`country` varchar(50) NOT NULL,
	`country_id` varchar(2) NOT NULL,
	`dirname` varchar(255) NOT NULL,
	`basename` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`publish_date` date NOT NULL,
	`end_date` date NOT NULL,
	`post_count` int(11) DEFAULT 0 NOT NULL,
	`comment_count` int(11) DEFAULT 0 NOT NULL,
	`follow_count` int(11) DEFAULT 0 NOT NULL,
	`public` int(1) DEFAULT 0 NOT NULL,
	`enabled` int(1) DEFAULT 0 NOT NULL,
	`status` int(2) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `category_id` (`category_id`),
	KEY `offer_id` (`offer_id`),
	KEY `city_id` (`city_id`),
	KEY `created` (`created`),
	KEY `slug` (`slug`),
	KEY `status` (`public`, `enabled`, `status`),
	KEY `status_2` (`public`, `enabled`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `offers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	`title` varchar(140) NOT NULL,
	`slug` varchar(200) NOT NULL,
	`short_description` varchar(512) NOT NULL,
	`description` text NOT NULL,
	`video_url` varchar(255) NOT NULL,
	`funds_available` int(11) NOT NULL,
	`offer_duration` int(11) NOT NULL,
	`funding_sponsorships_founds` int(11) NOT NULL,
	`offer_sponsorships` int(11) NOT NULL,
	`offer_public` int(11) NOT NULL,
	`city_id` int(22) NOT NULL,
	`city` varchar(50) NOT NULL,
	`country` varchar(50) NOT NULL,
	`country_id` varchar(2) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`publish_date` date NOT NULL,
	`end_date` date NOT NULL,
	`post_count` int(11) DEFAULT 0 NOT NULL,
	`comment_count` int(11) DEFAULT 0 NOT NULL,
	`project_count` int(11) DEFAULT 0 NOT NULL,
	`follow_count` int(11) DEFAULT 0 NOT NULL,
	`public` int(1) DEFAULT 0 NOT NULL,
	`enabled` int(1) DEFAULT 0 NOT NULL,
	`status` int(2) DEFAULT 0 NOT NULL,
	`dirname` varchar(255) NOT NULL,
	`basename` varchar(255) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `user_id` (`user_id`),
	KEY `category_id` (`category_id`),
	KEY `city_id` (`city_id`),
	KEY `created` (`created`),
	KEY `slug` (`slug`),
	KEY `status` (`public`, `enabled`, `status`),
	KEY `status_2` (`public`, `enabled`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`slug` varchar(50) DEFAULT NULL,
	`display_name` varchar(256) DEFAULT NULL,
	`biography` text DEFAULT NULL,
	`birthday` date DEFAULT NULL,
	`gender` varchar(255) DEFAULT NULL,
	`timezone` int(11) DEFAULT NULL,
	`dirname` varchar(1024) NOT NULL,
	`basename` varchar(1024) NOT NULL,
	`city_id` int(22) NOT NULL,
	`city` varchar(50) NOT NULL,
	`country` varchar(50) NOT NULL,
	`country_id` varchar(2) NOT NULL,
	`facebook_id` varchar(50) DEFAULT NULL,
	`email` varchar(255) NOT NULL,
	`password` varchar(128) NOT NULL,
	`password_confirmation` varchar(128) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`project_count` int(11) DEFAULT 0 NOT NULL,
	`project_proposal_count` int(11) DEFAULT 0 NOT NULL,
	`offer_count` int(11) DEFAULT 0 NOT NULL,
	`offer_proposal_count` int(11) DEFAULT 0 NOT NULL,
	`confirmed` int(1) DEFAULT 0 NOT NULL,
	`active` int(1) DEFAULT 0 NOT NULL,
	`enabled` int(1) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`),
	KEY `city_id` (`city_id`),
	KEY `created` (`created`),
	KEY `slug` (`slug`),
	KEY `status` (`confirmed`, `active`, `enabled`),
	KEY `status_2` (`confirmed`, `enabled`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `prizes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(50) NOT NULL,
	`model_id` int(11) NOT NULL,
	`value` int(11) DEFAULT NULL,
	`description` varchar(140) DEFAULT NULL,
	`bakes_count` int(11) DEFAULT 0,	PRIMARY KEY  (`id`),
	KEY `model` (`model`, `model_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users_projects` (
	`user_id` int(11) NOT NULL,
	`project_id` int(11) NOT NULL,	PRIMARY KEY  (`user_id`, `project_id`),
	KEY `user_id` (`user_id`),
	KEY `project_id` (`project_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users_offers` (
	`user_id` int(11) NOT NULL,
	`offer_id` int(11) NOT NULL,	PRIMARY KEY  (`user_id`, `offer_id`),
	KEY `user_id` (`user_id`),
	KEY `offer_id` (`offer_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `categories` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`slug` varchar(255) NOT NULL,
	`parent_id` int(11) DEFAULT NULL,
	`lft` int(11) DEFAULT NULL,
	`rght` int(11) DEFAULT NULL,
	`project_count` int(11) NOT NULL,
	`offer_count` int(22) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `slug` (`slug`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `notifications` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`notificationtype_id` int(11) NOT NULL,
	`model` varchar(50) NOT NULL,
	`model_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`data` text NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`user_status` int(11) NOT NULL,
	`activity_status` int(11) NOT NULL,
	`message_status` int(11) NOT NULL,
	`email_status` int(11) NOT NULL,
	`email_attempts` int(11) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `notificationtypes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(255) NOT NULL,
	`name` varchar(255) NOT NULL,
	`description` varchar(255) NOT NULL,
	`user_feed` int(1) NOT NULL,
	`activity_feed` int(1) NOT NULL,
	`notification` int(1) NOT NULL,
	`email` int(1) NOT NULL,
	`disableable` int(1) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `notificationtype_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(1) NOT NULL,
	`notificationtype_id` int(1) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `staticpages` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(140) NOT NULL,
	`slug` varchar(200) NOT NULL,
	`subtitle` varchar(280) NOT NULL,
	`content` text NOT NULL,
	`section` varchar(50) DEFAULT 'footer' NOT NULL,
	`template` varchar(50) DEFAULT 'default' NOT NULL,	PRIMARY KEY  (`id`),
	KEY `slug` (`slug`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2011 at 05:41 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `groofi`
--

-- --------------------------------------------------------

--
-- Table structure for table `seo_blacklists`
--

CREATE TABLE IF NOT EXISTS `seo_blacklists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_range_start` int(11) NOT NULL,
  `ip_range_end` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `note` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_range_start` (`ip_range_start`),
  KEY `ip_range_end` (`ip_range_end`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_blacklists`
--


-- --------------------------------------------------------

--
-- Table structure for table `seo_honeypot_visits`
--

CREATE TABLE IF NOT EXISTS `seo_honeypot_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_honeypot_visits`
--


-- --------------------------------------------------------

--
-- Table structure for table `seo_meta_tags`
--

CREATE TABLE IF NOT EXISTS `seo_meta_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_uri_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `is_http_equiv` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seo_uri_id` (`seo_uri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_meta_tags`
--


-- --------------------------------------------------------

--
-- Table structure for table `seo_redirects`
--

CREATE TABLE IF NOT EXISTS `seo_redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_uri_id` int(11) NOT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `callback` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seo_uri_id` (`seo_uri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_redirects`
--


-- --------------------------------------------------------

--
-- Table structure for table `seo_titles`
--

CREATE TABLE IF NOT EXISTS `seo_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_uri_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seo_uri_id` (`seo_uri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_titles`
--


-- --------------------------------------------------------

--
-- Table structure for table `seo_uris`
--

CREATE TABLE IF NOT EXISTS `seo_uris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uri` (`uri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seo_uris`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL,
  `search_text` text NOT NULL,
  `city` varchar(250) NOT NULL,
  `city_name` varchar(250) NOT NULL,
  `admin_code` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `city_full_name` varchar(500) NOT NULL,
  `city_soundex` varchar(4) NOT NULL,
  `population` double NOT NULL,
  `search_text_other` text NOT NULL,
  `project_count` int(11) NOT NULL DEFAULT '0',
  `offer_count` int(11) NOT NULL DEFAULT '0',
  `user_count` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  KEY `city` (`city`),
  KEY `admin_code` (`admin_code`),
  KEY `country` (`country`),
  KEY `country_code` (`country_code`),
  KEY `city_soundex` (`city_soundex`),
  KEY `city_2` (`city`,`city_soundex`),
  KEY `population` (`population`),
  FULLTEXT KEY `search_text` (`search_text`,`search_text_other`),
  FULLTEXT KEY `search_text_2` (`search_text`),
  FULLTEXT KEY `search_text_other` (`search_text_other`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `lft`, `rght`, `project_count`, `offer_count`) VALUES
(1, 'art', 'art', NULL, 1, 6, 4, 0),
(5, 'solidarity campaigns', 'solidarity-campaigns', 0, 9, 10, 0, 0),
(4, 'architecture', 'architecture', 0, 7, 8, 0, 0),
(6, 'film & video', 'film-video', 0, 11, 12, 1, 0),
(7, 'cooking', 'cooking', 0, 13, 14, 0, 0),
(8, 'dance', 'dance', 0, 15, 16, 0, 0),
(9, 'sports', 'sports', 0, 17, 18, 0, 0),
(10, 'challenges', 'challenges', 0, 19, 20, 0, 1),
(11, 'design', 'design', 0, 21, 22, 0, 0),
(12, 'games', 'games', 0, 23, 24, 0, 0),
(13, 'books & literature', 'books-literature', 0, 25, 26, 0, 0),
(14, 'fashion', 'fashion', 0, 27, 28, 0, 0),
(16, 'music', 'music', 0, 29, 30, 0, 0),
(17, 'theatre', 'theatre', 0, 31, 32, 0, 0),
(18, 'technology', 'technology', 0, 33, 34, 0, 0);



INSERT INTO `notificationtypes` (`id`, `model`, `name`, `description`, `notification`, `email`, `disableable`, `user_feed`, `activity_feed`) VALUES
(1, 'Offer', 'OFFER_PENDING_APPROVE', 'Your financing offer proposal has been recived (pending approve).', 1, 1, 0, 0, 0),
(2, 'Offer', 'OFFER_APPROVED', 'Your financing offer has been approved.', 1, 1, 0, 0, 0),
(3, 'Offer', 'OFFER_REJECTED', 'Your financing offer has been rejected.', 1, 1, 0, 0, 0),
(4, 'Offer', 'OFFER_NEW_PROJECT', 'New project appling your financing offer.', 1, 1, 1, 1, 0),
(5, 'Offer', 'OFFER_NEW_USER', 'User joined Your financing offer.', 1, 1, 1, 1, 0),
(6, 'Offer', 'OFFER_OWN_FINISH', 'Your financing offer is about to finish.', 1, 1, 0, 0, 0),
(7, 'Offer', 'OFFER_UPDATE', 'Actualización en un ofrecimiento al que te uniste o que aceptaste', 1, 1, 1, 1, 0),
(8, 'Offer', 'OFFER_OWN_FINISHED', 'Your financing offer has finished.', 1, 1, 0, 0, 1),
(9, 'Project', 'PROJECT_PENDING_APPROVE', 'Your project proposal has been recived (pending approve).', 1, 1, 0, 0, 0),
(10, 'Project', 'PROJECT_APPROVED', 'Your project has been approved.', 1, 1, 0, 0, 0),
(11, 'Project', 'PROJECT_REJECTED', 'Your project has been rejected.', 1, 1, 0, 0, 0),
(12, 'Project', 'PROJECT_NEW_BACKER', 'New backer for your project.', 1, 1, 1, 1, 0),
(13, 'Project', 'PROJECT_NEW_UPDATE', 'New update in a project you are backing. / follow', 1, 1, 1, 1, 0),
(14, 'Project', 'PROJECT_FINISH', 'A project you are backing/following is about to finish.', 1, 1, 1, 1, 0),
(15, 'Project', 'PROJECT_FOUNDED', 'A finished project you were backing/following has been founded.', 1, 1, 1, 1, 0),
(16, 'Project', 'PROJECT_DONT_FOUNDED', 'A finished project you were backing/following didn’t reach its goal and won’t be founded.', 1, 1, 1, 1, 0),
(17, 'Project', 'PROJECT_OWN_FINISH', 'Your project is about to finish.', 1, 1, 0, 0, 0),
(18, 'Project', 'PROJECT_OWN_FOUNDED', 'Your finished project has been founded.', 1, 1, 0, 0, 1),
(19, 'Project', 'PROJECT_OWN_NOT_FOUNDED', 'Your finished project didn’t reach its goal and won’t be founded.', 1, 1, 0, 0, 1),
(20, 'User', 'USER_WELCOME_MAIL', 'Welcome message with activation link.', 0, 1, 0, 0, 0),
(21, 'User', 'PASSWORD_RECOVERY', 'Password recovery.', 0, 1, 0, 0, 0);




INSERT INTO `staticpages` (`id`, `title`, `section`, `slug`, `content`, `template`, `subtitle`) VALUES
(1, 'a title', 'footer', 'register-info', '<div id="lipsum">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam at purus imperdiet tortor eleifend molestie. Nunc ultricies feugiat tempor :link . In nunc arcu, condimentum a consequat ac, posuere in urna. Proin tempus sapien vitae mi mollis gravida sodales a odio. Nulla aliquet aliquam elit, eget egestas metus iaculis eu. Nullam at dolor id ipsum posuere laoreet eu vitae justo. Mauris viverra elementum hendrerit. Cras sed purus ut sapien lobortis semper ut vitae libero. Aenean molestie facilisis risus, vitae rhoncus mauris ornare suscipit. Nulla consectetur mauris non quam convallis fringilla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec bibendum eleifend enim, varius faucibus risus tristique et. Etiam nisl sem, aliquet eget bibendum eget, tincidunt ac elit. Suspendisse porta purus quis sapien dictum at mollis risus mattis. Donec auctor dignissim nisl, sit amet vulputate massa suscipit quis. Nulla dictum vulputate ante, vel mattis lorem tempor eu. Vestibulum tempus blandit erat id placerat.</p>\r\n<p>Nam sollicitudin auctor pretium. Curabitur nibh ligula, vestibulum at pulvinar non, tristique nec lorem. Mauris mauris mi, lobortis ac interdum ac, tincidunt nec dui. Sed eget lectus eget erat iaculis dapibus imperdiet vitae arcu. Ut eget dui eu eros malesuada vulputate et at ipsum. Integer iaculis mattis neque, sed rhoncus metus iaculis nec. Nulla egestas accumsan magna, vel pretium nibh faucibus sit amet. Pellentesque nec tempus tortor. Vivamus urna mi, vestibulum consectetur venenatis ultricies, suscipit ut dui. Sed mollis nisi quis metus pharetra pulvinar consequat nisi elementum. Suspendisse enim nulla, porta non lacinia ut, pharetra non urna. Suspendisse potenti. In gravida sollicitudin ante auctor vulputate. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec in ligula risus. In blandit rutrum ipsum eu elementum.</p>\r\n<p>Nam in massa purus, eu laoreet elit. Nulla eu quam at magna congue pulvinar ac ut sapien. Morbi consequat arcu eget leo facilisis rutrum. Aliquam laoreet augue vel justo lacinia nec aliquet purus viverra. Cras elit enim, consequat ut blandit a, sagittis eu ante. Donec egestas sapien id diam posuere malesuada. Integer nec turpis leo, eget vestibulum nisl. Nullam condimentum commodo interdum. Phasellus at bibendum dolor. Integer tempus pulvinar velit a imperdiet. Cras iaculis, lectus at laoreet vestibulum, enim nunc feugiat purus, sed sagittis arcu magna in libero.</p>\r\n<p>Praesent erat metus, egestas quis auctor volutpat, ornare nec mi. Quisque at lorem lacus. Nunc rhoncus mattis rhoncus. Nullam varius accumsan sapien quis ultrices. Aenean at mauris at libero fringilla auctor sit amet quis turpis. Maecenas eget elit vitae diam viverra ornare. Aliquam erat volutpat. Maecenas nisl orci, rhoncus id facilisis eget, adipiscing vitae nibh. Duis cursus urna ut massa porta a semper lectus mattis. Quisque augue erat, tempus vitae commodo eu, tincidunt sit amet orci. Cras sed lectus quis quam aliquam aliquet. Nam sit amet lacus dignissim risus laoreet elementum sit amet a massa. Integer eu iaculis sem. Cras nisl massa, consectetur tincidunt consectetur a, mattis eget augue. Nunc scelerisque ante vitae magna auctor iaculis.</p>\r\n<p>Nulla magna justo, sodales eget sodales non, mollis non eros. Mauris mollis metus at lorem laoreet tincidunt. Nam venenatis elementum feugiat. Mauris tincidunt feugiat viverra. In a libero enim, a lobortis velit. Quisque quis nulla augue, at gravida sem. Suspendisse et massa odio, sollicitudin consequat risus. Nunc et elit libero, a fringilla tellus. Aliquam est nisi, tincidunt ut ultrices vel, dignissim eget risus. Morbi non lectus libero, ut iaculis magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent rutrum lobortis ullamcorper.</p>\r\n</div>', 'message', 'page subtitle'),
(2, 'terms of use', 'footer', 'terms', 'asdasdasdasdasdasdasdasdasd', 'default', ''),
(3, 'privacy policies', 'footer', 'privacy', 'privacy policies', 'default', ''),
(4, 'faq', 'header', 'faq', 'faq', 'default', ''),
(5, 'contact', 'footer', 'contact', 'contact', 'default', '');
