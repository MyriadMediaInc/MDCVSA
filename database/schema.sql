-- This script is designed for MySQL 8+
-- It creates the database, tables, and relationships for the MDCVSA project.

-- Create the database if it doesn't exist and set it as the current database
CREATE DATABASE IF NOT EXISTS `mdcvsa` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mdcvsa`;

--
-- Table structure for table `persons`
--
CREATE TABLE `persons` (
  `person_id` int NOT NULL AUTO_INCREMENT,
  `identity_verified_indicator` tinyint(1) NOT NULL DEFAULT '0',
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip5` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip4` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `cell_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `leagues`
--
CREATE TABLE `leagues` (
  `league_id` int NOT NULL AUTO_INCREMENT,
  `league_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_formed` date DEFAULT NULL,
  `date_disbanded` date DEFAULT NULL,
  `street_address_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip5` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip4` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`league_id`),
  UNIQUE KEY `league_name` (`league_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `teams`
--
CREATE TABLE `teams` (
  `team_id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `league_id` int NOT NULL,
  `date_formed` date DEFAULT NULL,
  `date_disbanded` date DEFAULT NULL,
  `primary_jersey_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_shorts_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_socks_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_jersey_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_shorts_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_socks_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_name_league_id` (`team_name`, `league_id`),
  KEY `league_id` (`league_id`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`league_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `team_players`
--
CREATE TABLE `team_players` (
    `team_player_id` INT NOT NULL AUTO_INCREMENT,
    `person_id` INT NOT NULL,
    `team_id` INT NOT NULL,
    `jersey_number` INT NULL,
    PRIMARY KEY (`team_player_id`),
    UNIQUE (`person_id`, `team_id`),
    FOREIGN KEY (`person_id`) REFERENCES `persons`(`person_id`) ON DELETE CASCADE,
    FOREIGN KEY (`team_id`) REFERENCES `teams`(`team_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `player_registrations`
--
CREATE TABLE `player_registrations` (
  `registration_id` int NOT NULL AUTO_INCREMENT,
  `person_id` int NOT NULL,
  `league_id` int NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`registration_id`),
  UNIQUE KEY `person_id_league_id` (`person_id`,`league_id`),
  KEY `league_id` (`league_id`),
  CONSTRAINT `player_registrations_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`),
  CONSTRAINT `player_registrations_ibfk_2` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`league_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
