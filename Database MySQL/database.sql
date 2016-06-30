# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: amazon_ec2_free (MySQL 5.5.49-0ubuntu0.14.04.1)
# Database: iot_tesi
# Generation Time: 2016-06-30 21:52:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table gateways
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gateways`;

CREATE TABLE `gateways` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table rules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rules`;

CREATE TABLE `rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_topic` int(11) unsigned NOT NULL,
  `id_key` int(11) unsigned NOT NULL,
  `condition_type` enum('none','<','>','=') NOT NULL DEFAULT 'none',
  `condition_value` int(11) unsigned DEFAULT NULL,
  `hold_timer` int(11) NOT NULL DEFAULT '0',
  `id_topic_result` int(11) unsigned NOT NULL,
  `id_key_result` int(11) unsigned NOT NULL,
  `key_type_result` enum('none','value') NOT NULL DEFAULT 'none',
  `key_value_result` varchar(30) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `gps_checked` tinyint(1) NOT NULL DEFAULT '0',
  `gps_value` varchar(50) NOT NULL DEFAULT '''''',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_topic` (`id_topic`),
  KEY `id_key` (`id_key`),
  KEY `id_topic_result` (`id_topic_result`),
  KEY `id_key_result` (`id_key_result`),
  CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`id_topic`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rules_ibfk_2` FOREIGN KEY (`id_key`) REFERENCES `table_keys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rules_ibfk_3` FOREIGN KEY (`id_topic_result`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rules_ibfk_4` FOREIGN KEY (`id_key_result`) REFERENCES `table_keys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sensors_actuators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sensors_actuators`;

CREATE TABLE `sensors_actuators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `id_gateway` int(11) unsigned NOT NULL,
  `type` enum('sensor','actuator') NOT NULL DEFAULT 'sensor',
  PRIMARY KEY (`id`),
  KEY `id_gateway` (`id_gateway`),
  CONSTRAINT `sensors_actuators_ibfk_1` FOREIGN KEY (`id_gateway`) REFERENCES `gateways` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sensors_actuators_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sensors_actuators_data`;

CREATE TABLE `sensors_actuators_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_key` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `key_data_fk` (`id_key`),
  CONSTRAINT `key_data_fk` FOREIGN KEY (`id_key`) REFERENCES `table_keys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table table_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `table_keys`;

CREATE TABLE `table_keys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `id_topic` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_keys_fk` (`id_topic`),
  CONSTRAINT `topic_keys_fk` FOREIGN KEY (`id_topic`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `id_sensor_actuator` int(11) unsigned NOT NULL,
  `type` enum('subscribe','publish') NOT NULL DEFAULT 'subscribe',
  `widget_view` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sensor_actuator_topic_fk` (`id_sensor_actuator`),
  CONSTRAINT `sensor_actuator_topic_fk` FOREIGN KEY (`id_sensor_actuator`) REFERENCES `sensors_actuators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `uuid` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `surname` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `encrypted_password` varchar(80) NOT NULL DEFAULT '',
  `salt` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
