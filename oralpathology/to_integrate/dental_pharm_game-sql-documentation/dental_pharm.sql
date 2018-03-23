-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2017 at 09:54 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dental_pharm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_email_addresses`
--

DROP TABLE IF EXISTS `admin_email_addresses`;
CREATE TABLE IF NOT EXISTS `admin_email_addresses` (
  `email_type` varchar(20) NOT NULL,
  `emai_address` varchar(256) NOT NULL,
  PRIMARY KEY (`email_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answerlog`
--

DROP TABLE IF EXISTS `answerlog`;
CREATE TABLE IF NOT EXISTS `answerlog` (
  `answerlog_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `attempt_number` int(10) UNSIGNED NOT NULL,
  `correct_flag` enum('Y','N') DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '100',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attempt_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `answer_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`answerlog_id`),
  KEY `question_id` (`question_id`),
  KEY `answer_id` (`answer_id`),
  KEY `username` (`username`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `answer_text` varchar(256) NOT NULL,
  `correct_flag` enum('Y','N') DEFAULT NULL,
  `times_chosen` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_id` int(10) UNSIGNED NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `question_id` (`question_id`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bug_report`
--

DROP TABLE IF EXISTS `bug_report`;
CREATE TABLE IF NOT EXISTS `bug_report` (
  `report_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_text` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`report_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  `verified_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `active_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(20) NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `created_by` (`created_by`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_user`
--

DROP TABLE IF EXISTS `deleted_user`;
CREATE TABLE IF NOT EXISTS `deleted_user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email_address` varchar(256) NOT NULL,
  `score` int(11) NOT NULL,
  `admin_flag` int(11) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_user_profile`
--

DROP TABLE IF EXISTS `deleted_user_profile`;
CREATE TABLE IF NOT EXISTS `deleted_user_profile` (
  `username` varchar(20) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `employer` varchar(50) NOT NULL,
  `interest` varchar(256) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `image_url` varchar(256) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_updated_Date` datetime NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  `deleted_date` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `distractors`
--

DROP TABLE IF EXISTS `distractors`;
CREATE TABLE IF NOT EXISTS `distractors` (
  `distractor_id` int(11) NOT NULL AUTO_INCREMENT,
  `for_question_id` int(10) UNSIGNED NOT NULL,
  `distractor_question_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`distractor_id`),
  KEY `for_question_id` (`for_question_id`),
  KEY `distractor_question_id` (`distractor_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flagged_questions`
--

DROP TABLE IF EXISTS `flagged_questions`;
CREATE TABLE IF NOT EXISTS `flagged_questions` (
  `flagged_question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `problem_text` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question_id` int(10) UNSIGNED NOT NULL,
  `flagged_by_user` varchar(20) NOT NULL,
  PRIMARY KEY (`flagged_question_id`),
  KEY `question_id` (`question_id`),
  KEY `flagged_by_user` (`flagged_by_user`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL,
  `image_folder` varchar(100) NOT NULL,
  `image_name` varchar(200) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pageaccess`
--

DROP TABLE IF EXISTS `pageaccess`;
CREATE TABLE IF NOT EXISTS `pageaccess` (
  `pageaccess_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `attempt_id` int(11) DEFAULT NULL,
  `level_access` int(11) DEFAULT NULL,
  `access_date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pageaccess_id`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_title` varchar(500) NOT NULL,
  `hint` varchar(100) DEFAULT NULL,
  `number_of_images` int(11) NOT NULL,
  `score` int(10) UNSIGNED NOT NULL DEFAULT '100',
  `times_correctly_answered` int(10) UNSIGNED NOT NULL DEFAULT '100',
  `times_answered` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `explanation` varchar(500) DEFAULT NULL,
  `verified_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `active_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `removed_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `removed_date` datetime DEFAULT NULL,
  `image_url` varchar(256) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  `diagnosis_name` varchar(50) NOT NULL,
  `hint` varchar(100) NOT NULL,
  `number_of_images` int(10) NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `category_id` (`category_id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `created_by` (`created_by`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_images`
--

DROP TABLE IF EXISTS `question_images`;
CREATE TABLE IF NOT EXISTS `question_images` (
  `question_id` int(10) UNSIGNED NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`image_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_levels`
--

DROP TABLE IF EXISTS `question_levels`;
CREATE TABLE IF NOT EXISTS `question_levels` (
  `level_id` int(11) NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`level_id`,`question_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_review_history`
--

DROP TABLE IF EXISTS `question_review_history`;
CREATE TABLE IF NOT EXISTS `question_review_history` (
  `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `review_outcome` varchar(500) DEFAULT NULL,
  `review_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question_id` int(10) UNSIGNED NOT NULL,
  `reviewed_by` varchar(20) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `question_id` (`question_id`),
  KEY `reviewed_by` (`reviewed_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `quiz_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quiz_name` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  `active_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `removed_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `removed_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  PRIMARY KEY (`quiz_id`),
  KEY `category_id` (`category_id`),
  KEY `created_by` (`created_by`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answerlog`
--

DROP TABLE IF EXISTS `quiz_answerlog`;
CREATE TABLE IF NOT EXISTS `quiz_answerlog` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `correct_flag` tinyint(4) NOT NULL,
  `date_time_answered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(20) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `username` (`username`),
  KEY `quiz_id` (`quiz_id`),
  KEY `choice_id` (`choice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_choices`
--

DROP TABLE IF EXISTS `quiz_question_choices`;
CREATE TABLE IF NOT EXISTS `quiz_question_choices` (
  `choice_id` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL,
  `correct_flag` char(1) NOT NULL DEFAULT 'N',
  `quiz_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`choice_id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scorelog`
--

DROP TABLE IF EXISTS `scorelog`;
CREATE TABLE IF NOT EXISTS `scorelog` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `attempt_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `log_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level_attempt_number` int(11) NOT NULL DEFAULT '1',
  `is_level_complete` tinyint(4) NOT NULL DEFAULT '0',
  `final_level_score` int(11) NOT NULL DEFAULT '0',
  `number_question_ansered` int(11) NOT NULL DEFAULT '0',
  `number_correct` int(11) NOT NULL DEFAULT '0',
  `number_incorrect` int(11) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_classification`
--

DROP TABLE IF EXISTS `sub_classification`;
CREATE TABLE IF NOT EXISTS `sub_classification` (
  `qustion_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `used_question_log`
--

DROP TABLE IF EXISTS `used_question_log`;
CREATE TABLE IF NOT EXISTS `used_question_log` (
  `attempt_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`attempt_id`,`level_id`,`question_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email_address` varchar(256) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `admin_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `owner_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `active_flag` enum('Y','N') NOT NULL DEFAULT 'N',
  `registered_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `full_name` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `employer` varchar(50) DEFAULT NULL,
  `interests` varchar(256) DEFAULT NULL,
  `bio` varchar(500) DEFAULT NULL,
  `image_url` varchar(256) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(20) NOT NULL,
  `last_updated_by` varchar(20) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `last_updated_by` (`last_updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vm_questionvotevalue`
--

DROP TABLE IF EXISTS `vm_questionvotevalue`;
CREATE TABLE IF NOT EXISTS `vm_questionvotevalue` (
  `question_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `value` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`question_id`,`username`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vw_correctanswers_v1`
--

DROP TABLE IF EXISTS `vw_correctanswers_v1`;
CREATE TABLE IF NOT EXISTS `vw_correctanswers_v1` (
  `question_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempt_number` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vw_correctanswers_v2`
--

DROP TABLE IF EXISTS `vw_correctanswers_v2`;
CREATE TABLE IF NOT EXISTS `vw_correctanswers_v2` (
  `question_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `attempt_number` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vw_correctanswers_v3`
--

DROP TABLE IF EXISTS `vw_correctanswers_v3`;
CREATE TABLE IF NOT EXISTS `vw_correctanswers_v3` (
  `question_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `attempt_number` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answerlog`
--
ALTER TABLE `answerlog`
  ADD CONSTRAINT `answerlog_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `answerlog_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`),
  ADD CONSTRAINT `answerlog_ibfk_3` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `answerlog_ibfk_4` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`);

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `bug_report`
--
ALTER TABLE `bug_report`
  ADD CONSTRAINT `bug_report_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `distractors`
--
ALTER TABLE `distractors`
  ADD CONSTRAINT `distractors_ibfk_1` FOREIGN KEY (`for_question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `distractors_ibfk_2` FOREIGN KEY (`distractor_question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `flagged_questions`
--
ALTER TABLE `flagged_questions`
  ADD CONSTRAINT `flagged_questions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `flagged_questions_ibfk_2` FOREIGN KEY (`flagged_by_user`) REFERENCES `users` (`username`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`),
  ADD CONSTRAINT `question_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `question_ibfk_4` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `question_images`
--
ALTER TABLE `question_images`
  ADD CONSTRAINT `question_images_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`);

--
-- Constraints for table `question_levels`
--
ALTER TABLE `question_levels`
  ADD CONSTRAINT `question_levels_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `question_review_history`
--
ALTER TABLE `question_review_history`
  ADD CONSTRAINT `question_review_history_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_review_history_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `quizzes_ibfk_3` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `quiz_question_choices`
--
ALTER TABLE `quiz_question_choices`
  ADD CONSTRAINT `quiz_question_choices_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`);

--
-- Constraints for table `scorelog`
--
ALTER TABLE `scorelog`
  ADD CONSTRAINT `scorelog_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `used_question_log`
--
ALTER TABLE `used_question_log`
  ADD CONSTRAINT `used_question_log_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `user_profiles_ibfk_2` FOREIGN KEY (`last_updated_by`) REFERENCES `users` (`username`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
