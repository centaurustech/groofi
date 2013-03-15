

Welcome to CakePHP v1.3.2 Console
---------------------------------------------------------------
App : app
Path: E:\works\dev\2011\groofi\app
---------------------------------------------------------------
Cake Schema Shell
---------------------------------------------------------------
#App sql generated on: 2011-04-07 14:39:00 : 1302197940

DROP TABLE IF EXISTS `links`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `proposals`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `users_projects`;
DROP TABLE IF EXISTS `users_proposals`;


CREATE TABLE `links` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`model` varchar(50) NOT NULL,
	`model_id` int(11) NOT NULL,
	`link` varchar(3000) NOT NULL,
	`title` varchar(140) DEFAULT NULL,
	`description` varchar(140) DEFAULT NULL,
	`media_id` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `projects` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` int(11) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `proposals` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` int(11) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) DEFAULT NULL,
	`lastname` varchar(128) DEFAULT NULL,
	`display_name` varchar(256) DEFAULT NULL,
	`email` varchar(255) NOT NULL,
	`username` varchar(255) DEFAULT NULL,
	`password` varchar(128) NOT NULL,
	`password_confirmation` varchar(128) NOT NULL,
	`fbid` varchar(50) DEFAULT NULL,
	`twid` varchar(50) DEFAULT NULL,
	`location` varchar(255) DEFAULT NULL,
	`biography` text DEFAULT NULL,
	`slug` varchar(50) DEFAULT NULL,
	`confirmed` int(1) DEFAULT 0 NOT NULL,
	`active` int(1) DEFAULT 0 NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	`dirname` varchar(255) NOT NULL,
	`basename` varchar(255) NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `users_projects` (
	`user_id` int(11) NOT NULL,
	`project_id` int(11) NOT NULL,	PRIMARY KEY  (`user_id`, `project_id`),
	KEY `user_id` (`user_id`),
	KEY `project_id` (`project_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;

CREATE TABLE `users_proposals` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`proposal_id` int(11) NOT NULL AUTO_INCREMENT,	PRIMARY KEY  (`user_id`, `proposal_id`),
	KEY `user_id` (`user_id`),
	KEY `proposal_id` (`proposal_id`))	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=MyISAM;



