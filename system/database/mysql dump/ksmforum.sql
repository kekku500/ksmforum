-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2015 at 03:14 PM
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
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('bd85b5079ed737c9d1abbe1fe16d4812', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 1425219070, 'a:3:{s:9:"user_data";s:0:"";s:1:"t";a:1:{i:0;s:2:"25";}s:12:"google_email";s:27:"kevin.nemerzitski@gmail.com";}'),
('c6e5ce711b5d54700b14270a2c0855a6', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 1425218999, 'a:3:{s:12:"access_token";s:1126:"{"access_token":"ya29.KQGhjrzfXRcQWTbMSjCBY0-coNIJCdTUunuREjAbadKAXkQ8XaJh-VbLYi74IBrwjVVRtwhQLminNg","token_type":"Bearer","expires_in":3600,"id_token":"eyJhbGciOiJSUzI1NiIsImtpZCI6ImQwYjFlMTFjZWZmM2Q2MzVjYjkyYjcxZTdiOGJlZmRkODdhMmM2OWEifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiaWQiOiIxMDk2ODg4NTkzMjQzNDk2MjE0NzAiLCJzdWIiOiIxMDk2ODg4NTkzMjQzNDk2MjE0NzAiLCJhenAiOiI4MzE0NTA0MjIzNTMtc29ocHAxanU1ZGJkM2p2MTJlcGRwYmFwYXJoMXI3MTEuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJlbWFpbCI6ImhhcHB5Ymx1ZWJlYXN0QGdtYWlsLmNvbSIsImF0X2hhc2giOiJKc2hkdUhIR2N1bTVzUTJsVjBZd0t3IiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF1ZCI6IjgzMTQ1MDQyMjM1My1zb2hwcDFqdTVkYmQzanYxMmVwZHBiYXBhcmgxcjcxMS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInRva2VuX2hhc2giOiJKc2hkdUhIR2N1bTVzUTJsVjBZd0t3IiwidmVyaWZpZWRfZW1haWwiOnRydWUsImNpZCI6IjgzMTQ1MDQyMjM1My1zb2hwcDFqdTVkYmQzanYxMmVwZHBiYXBhcmgxcjcxMS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTQyNTIxODcwNiwiZXhwIjoxNDI1MjIyNjA2fQ.TI9fdl0pdW-msSUjiZUyzD9JRCN0I3Ykw7w9fDZUx3ZTJWOyFV0pxzXrnS1fthnVbU2KMeQqpkBdyBT7iirFgeIIvdLwNA56K_BzYQIiJn1eXgBSDEOtLP1lzmoRWU1SVigS1WTXuKuFxJHcUX9mgU1hlEG5EXuxO29tAP9iYLQ","created":1425219006}";s:12:"google_email";s:24:"happybluebeast@gmail.com";s:7:"user_id";s:2:"49";}');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
`id` int(10) unsigned NOT NULL,
  `p_fid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `topic_count` int(10) unsigned NOT NULL,
  `post_count` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `p_fid`, `name`, `uid`, `topic_count`, `post_count`) VALUES
(10, 14, 'Uudised', 8, 9, 23),
(14, NULL, 'Pealehe foorum', 8, 0, 0),
(15, NULL, 'KSM Foorum', 8, 0, 0),
(16, NULL, 'Muu', 8, 0, 0),
(17, 10, 'Uudiste sub', 8, 0, 0),
(19, NULL, 'Täiesti uus foorum', 8, 0, 0),
(20, 10, 'Yipee', 8, 1, 6),
(21, 19, 'Alam', 8, 0, 0),
(22, 21, 'Epic shizz', 8, 0, 0),
(23, NULL, 'Kategooria', 8, 0, 0),
(24, 23, 'On kah', 8, 0, 0),
(25, NULL, 'KategooriaKaks', 8, 0, 0),
(26, 25, 'KategooriaKaksAlam', 8, 0, 0),
(27, NULL, 'eaeadadf', 8, 0, 0),
(28, NULL, 'test', 8, 0, 0),
(29, NULL, 'ddddd', 8, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `googleusers`
--

CREATE TABLE IF NOT EXISTS `googleusers` (
  `id` varchar(30) NOT NULL,
  `uid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`id` int(10) unsigned NOT NULL,
  `p_pid` int(10) unsigned DEFAULT NULL,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `depth` int(10) unsigned NOT NULL DEFAULT '0',
  `pos` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9831 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `p_pid`, `tid`, `content`, `create_time`, `edit_time`, `depth`, `pos`, `uid`) VALUES
(9802, NULL, 13, 'The sisu 2a', '2015-02-22 14:27:14', '2015-02-28 22:32:12', 0, 1, 8),
(9803, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-22 17:42:11', '2015-02-22 17:42:11', 1, 2, 8),
(9804, 9802, 13, 'Yep', '2015-02-23 14:41:10', '2015-02-23 14:41:10', 1, 3, 8),
(9805, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-23 16:26:42', '2015-02-23 16:26:43', 1, 4, 8),
(9806, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-23 18:06:40', '2015-02-23 18:13:29', 1, 6, 8),
(9807, NULL, 14, 'The sisu', '2015-02-23 18:11:17', '2015-02-23 18:11:17', 0, 1, 8),
(9808, NULL, 15, 'The sisu', '2015-02-23 18:11:23', '2015-02-23 18:11:23', 0, 1, 8),
(9809, 9805, 13, 'Kirjuta kommentaar siia', '2015-02-23 18:13:29', '2015-02-23 18:13:29', 2, 5, 8),
(9810, NULL, 17, 'rickroll', '2015-02-23 22:55:34', '2015-02-23 22:55:34', 0, 1, 8),
(9811, 9810, 17, 'fun', '2015-02-23 23:01:04', '2015-02-23 23:01:04', 1, 2, 3),
(9812, 9810, 17, 'epic', '2015-02-23 23:01:09', '2015-02-23 23:01:43', 1, 5, 3),
(9813, 9811, 17, '???', '2015-02-23 23:01:14', '2015-02-23 23:01:14', 2, 3, 3),
(9814, 9813, 17, 'veel', '2015-02-23 23:01:43', '2015-02-23 23:01:43', 3, 4, 3),
(9815, 9810, 17, 'Kirjuta kommentaar siia', '2015-02-23 23:54:55', '2015-02-23 23:54:55', 1, 6, 8),
(9816, 9806, 13, 'Kirjuta kommentaar siia', '2015-02-25 16:34:43', '2015-02-25 16:34:43', 2, 7, 8),
(9817, NULL, 19, 'The sisu', '2015-02-25 16:38:02', '2015-02-25 16:38:02', 0, 1, 8),
(9818, 9816, 13, 'Kirjuta kommentaar siia', '2015-02-25 16:44:29', '2015-02-25 16:44:29', 3, 8, 8),
(9819, NULL, 20, 'The sisu', '2015-02-25 16:44:44', '2015-02-25 16:44:44', 0, 1, 8),
(9820, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-26 08:58:59', '2015-02-26 08:58:59', 1, 9, 8),
(9826, NULL, 22, 'The sisu', '2015-02-28 21:50:32', '2015-02-28 21:50:32', 0, 1, 8),
(9827, NULL, 23, 'fdsgfsdgdfsdfs', '2015-02-28 21:55:25', '2015-02-28 21:55:26', 0, 1, 8),
(9828, NULL, 24, 'sfafsdfsdf', '2015-02-28 22:13:34', '2015-02-28 22:13:34', 0, 1, 8),
(9829, NULL, 25, 'fdsfdssdfsfd', '2015-02-28 22:15:56', '2015-02-28 22:15:56', 0, 1, 8),
(9830, 9829, 25, 'Kirjuta kommentaar siiaaaaa', '2015-03-01 11:33:58', '2015-03-01 11:34:02', 1, 2, 3);

--
-- Triggers `posts`
--
DELIMITER //
CREATE TRIGGER `tr_dec_topic_and_forum_post_count` BEFORE DELETE ON `posts`
 FOR EACH ROW begin
	update topics set post_count = post_count - 1 where id = OLD.tid;
    update forums set post_count = post_count - 1 where id = (select fid from topics where id = OLD.tid);
    
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tr_inc_topic_and_forum_post_count` AFTER INSERT ON `posts`
 FOR EACH ROW begin
	update topics set post_count = post_count + 1 where id = NEW.tid;
    update forums set post_count = post_count + 1 where id = (select fid from topics where id = NEW.tid);
    
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tr_set_depth_from_parent_post` BEFORE INSERT ON `posts`
 FOR EACH ROW BEGIN
    IF NEW.p_pid IS NOT NULL THEN
        SET NEW.depth = 1+(SELECT depth from posts WHERE id=NEW.p_pid);
    END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessionbinds`
--

CREATE TABLE IF NOT EXISTS `sessionbinds` (
  `uid` int(10) unsigned NOT NULL,
  `session_id` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
`id` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  `post_count` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `fid`, `name`, `content`, `create_time`, `edit_time`, `uid`, `views`, `post_count`) VALUES
(13, 10, 'Olulised uudised', '', '2015-02-22 14:27:14', '2015-02-28 20:03:20', 8, 41, 14),
(14, 10, 'Pealkiri', '', '2015-02-23 18:11:17', '2015-02-28 20:03:24', 8, 16, 1),
(15, 10, 'Pealkiri 2', '', '2015-02-23 18:11:23', '2015-02-28 20:03:30', 8, 10, 1),
(17, 20, 'Väga oluline: help!', '', '2015-02-23 22:55:34', '2015-02-25 17:47:12', 8, 4, 6),
(19, 10, 'Pealkiri new', '', '2015-02-25 16:38:02', '2015-02-27 11:30:26', 8, 11, 1),
(20, 10, 'Pealkirifdsafs', '', '2015-02-25 16:44:44', '2015-02-28 20:03:32', 8, 2, 1),
(22, 10, 'Pealkirifdsdfssdfsdf', '', '2015-02-28 21:50:32', '2015-02-28 21:50:32', 8, 1, 1),
(23, 10, 'asdfssdf', '', '2015-02-28 21:55:25', '2015-02-28 21:55:26', 8, 1, 1),
(24, 10, 'Pealkiriasdsdasda', '', '2015-02-28 22:13:34', '2015-02-28 22:13:34', 8, 1, 1),
(25, 10, 'saa', '', '2015-02-28 22:15:55', '2015-03-01 11:33:58', 8, 2, 2);

--
-- Triggers `topics`
--
DELIMITER //
CREATE TRIGGER `tr_dec_forum_topic_count` BEFORE DELETE ON `topics`
 FOR EACH ROW begin
	update forums set topic_count = topic_count - 1 where id = OLD.fid;
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tr_inc_forum_topic_count` AFTER INSERT ON `topics`
 FOR EACH ROW begin
	update forums set topic_count = topic_count + 1 where id = NEW.fid;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `addforum` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`id`, `name`, `addforum`) VALUES
(1, 'default', 0),
(2, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `usergroup` int(10) unsigned NOT NULL DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `email`, `create_time`, `edit_time`, `usergroup`) VALUES
(3, 'user1', 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a', 'email@meh.com', '2015-02-23 15:08:09', '2015-03-01 13:30:04', 1),
(4, 'user', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'Email', '2015-02-23 15:20:32', '2015-03-01 13:20:02', 1),
(7, 'Kasutajanimi2', '354b7d6a59251940bd3f6b49e029f2d043cc6e77', 'Email', '2015-02-23 15:23:25', '2015-03-01 13:20:02', 1),
(8, 'Kasutajanimi', '354b7d6a59251940bd3f6b49e029f2d043cc6e77', 'Email', '2015-02-23 17:55:31', '2015-03-01 13:20:02', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD KEY `p_fid` (`p_fid`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `googleusers`
--
ALTER TABLE `googleusers`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`id`), ADD KEY `tid` (`tid`), ADD KEY `p_pid` (`p_pid`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `sessionbinds`
--
ALTER TABLE `sessionbinds`
 ADD KEY `uid` (`uid`), ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `fid_title` (`fid`,`name`), ADD KEY `fid` (`fid`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_name` (`name`), ADD KEY `usergroup` (`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9831;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
ADD CONSTRAINT `fk_forum_2_forum` FOREIGN KEY (`p_fid`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_forum_2_user` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `googleusers`
--
ALTER TABLE `googleusers`
ADD CONSTRAINT `fk_googleusers_2_users` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `fk_post_2_post` FOREIGN KEY (`p_pid`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_post_2_topic` FOREIGN KEY (`tid`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_post_2_user` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessionbinds`
--
ALTER TABLE `sessionbinds`
ADD CONSTRAINT `fk_session_bind_2_ci_session` FOREIGN KEY (`session_id`) REFERENCES `ci_sessions` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_session_bind_2_user` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
ADD CONSTRAINT `fk_topic_2_forum` FOREIGN KEY (`fid`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_topic_2_user` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `fk_user_2_usergroup` FOREIGN KEY (`usergroup`) REFERENCES `usergroups` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
