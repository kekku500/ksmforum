-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2015 at 09:22 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ksmforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'KSM Foorum'),
(3, 'Muu'),
(1, 'Pealehe foorum');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
`id` int(10) unsigned NOT NULL,
  `p_fid` int(10) unsigned DEFAULT NULL,
  `cid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `p_fid`, `cid`, `name`) VALUES
(10, NULL, 1, 'Uudised'),
(12, 10, NULL, 'Tähtsad Uudised'),
(13, 10, NULL, 'Uudiste sub 2');

--
-- Triggers `forum`
--
DELIMITER //
CREATE TRIGGER `tr_forum_before_insert_rules` BEFORE INSERT ON `forum`
 FOR EACH ROW BEGIN
	IF NEW.p_fid IS NOT NULL AND NEW.cid IS NOT NULL THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum category id and parent forum id cannot be set simultaneously.';
	ELSEIF NEW.id = NEW.p_fid THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum parent forum id cannot be itself.';
	ELSEIF NEW.p_fid IS NULL AND NEW.cid IS NULL THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum must be in a category or a suboforum';
	END IF;
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tr_forum_before_update_rules` BEFORE UPDATE ON `forum`
 FOR EACH ROW BEGIN
	IF NEW.p_fid IS NOT NULL AND NEW.cid IS NOT NULL THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum category and parent forum cannot be set simultaneously.';
    ELSEIF NEW.id = NEW.p_fid THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum parent forum id cannot be itself.';
	ELSEIF NEW.p_fid IS NULL AND NEW.cid IS NULL THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Forum must be in a category or a suboforum';
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`id` int(10) unsigned NOT NULL,
  `p_pid` int(10) unsigned DEFAULT NULL,
  `tid` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `p_pid`, `tid`, `content`, `create_time`, `edit_time`) VALUES
(1, NULL, 1, 'Ei usu. Kas oli tõesti valget värvi?', '2015-02-17 19:48:16', '2015-02-17 19:48:16'),
(2, 1, 1, 'Usu ikka. Kõike peab uskuma, mida uudistes kirjutatakse.', '2015-02-17 19:48:16', '2015-02-17 19:48:16'),
(3, NULL, 1, 'Epic comment reply to thread. Updated!', '2015-02-17 19:49:30', '2015-02-17 19:51:32'),
(4, NULL, 1, 'Changed!!!', '2015-02-17 19:51:55', '2015-02-17 19:52:06'),
(5, NULL, 1, 'New comment.', '2015-02-17 19:52:27', '2015-02-17 19:53:45'),
(6, NULL, 1, 'NEw comment 2 edited eddsa', '2015-02-17 19:52:39', '2015-02-17 19:53:54'),
(7, NULL, 1, 'Yeah!ds', '2015-02-17 19:54:05', '2015-02-17 19:54:11');

--
-- Triggers `post`
--
DELIMITER //
CREATE TRIGGER `tr_post_before_insert_rules` BEFORE INSERT ON `post`
 FOR EACH ROW BEGIN
	IF NEW.id = NEW.p_pid THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Post parent post id cannot be itself.';
	END IF;
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tr_post_before_update_rules` BEFORE UPDATE ON `post`
 FOR EACH ROW BEGIN
	IF NEW.id = NEW.p_pid THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Post parent post id cannot be itself.';
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
`id` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `fid`, `title`, `content`, `create_time`, `edit_time`) VALUES
(1, 10, 'Jänes on valge, epic', 'Ühes kohas nägin jänest, kes oli valge. KUUM UUDIS! Yep!', '2015-02-17 19:40:25', '2015-02-17 19:47:27'),
(2, 10, 'Must jänes on ka olemas!', 'Yep.', '2015-02-17 19:54:59', '0000-00-00 00:00:00'),
(3, 10, 'Jänes on valge', 'fdsf', '2015-02-18 07:10:04', '0000-00-00 00:00:00'),
(5, 10, 'Jänes on valge ye', 'dsa', '2015-02-18 17:16:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `pass`, `email`, `create_time`, `edit_time`) VALUES
(1, 'admin', 'pass', 'admin@ksmforum.com', '2015-02-17 19:56:02', '0000-00-00 00:00:00'),
(2, 'admin2', 'pass', 'admin2@ksmforum.com', '2015-02-17 19:56:02', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD KEY `p_fid` (`p_fid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`), ADD KEY `tid` (`tid`), ADD KEY `p_pid` (`p_pid`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `fid_title` (`fid`,`title`), ADD KEY `fid` (`fid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user` (`name`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
ADD CONSTRAINT `fk_forum_2_category` FOREIGN KEY (`cid`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_forum_2_forum` FOREIGN KEY (`p_fid`) REFERENCES `forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `fk_post_2_post` FOREIGN KEY (`p_pid`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_post_2_topic` FOREIGN KEY (`tid`) REFERENCES `topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
ADD CONSTRAINT `fk_topic_2_forum` FOREIGN KEY (`fid`) REFERENCES `forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
