-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2015 at 03:02 PM
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
('bb14acd51ddf4103e1924d0b187205c4', '::1', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0', 1425564077, 'a:3:{s:9:"user_data";s:0:"";s:1:"t";a:13:{i:0;s:2:"13";i:1;s:15:"%3Cdiv%20style=";i:2;N;i:3;s:2:"27";i:4;s:2:"26";i:5;s:2:"25";i:6;s:2:"24";i:7;s:2:"28";i:8;s:2:"29";i:9;s:2:"30";i:10;s:2:"31";i:11;s:2:"32";i:12;s:2:"33";}s:7:"user_id";s:1:"3";}');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `p_fid`, `name`, `uid`, `topic_count`, `post_count`) VALUES
(10, 14, 'Uudised', 8, 13, 23),
(14, NULL, 'Pealehe foorum', 8, 0, 0),
(15, NULL, 'KSM Foorum', 8, 0, 0),
(16, NULL, 'Muu', 8, 0, 0),
(17, 10, 'Perekond ja sõbrad', 8, 0, 0),
(19, NULL, 'Narkootikumide sõltuvus ja taastusravi', 8, 0, 0),
(20, 10, 'Psühholoogiline ja sotsiaalne abi', 8, 1, 6),
(21, 19, 'Üldine arutlus sõltuvusest', 8, 0, 0),
(39, 19, 'Alkoholi sõltuvus', 8, 0, 0),
(40, 19, 'Amfetamiini sõltuvus', 8, 0, 0),
(41, 19, 'Kanepisõltuvus', 8, 0, 0),
(42, 19, 'Kokaiinisõltuvus', 8, 0, 0),
(43, 19, 'Rahustite sõltuvus', 8, 0, 0),
(44, 19, 'GHB sõltuvus', 8, 0, 0),
(45, 19, 'Opiaatide sõltuvus', 8, 0, 0),
(46, 19, 'Muude uimastite sõltuvus', 8, 0, 0),
(22, 21, 'Reeglid', 8, 0, 0),
(23, NULL, 'Sõltuvusvastased abivõtted', 8, 0, 0),
(47, 23, 'Taastumisteemalised artiklid', 8, 0, 0),
(48, 23, 'Oma sõltuvuse hindamine', 8, 0, 0),
(49, 23, 'Taastumiskeskuste nimekiri', 8, 0, 0),
(25, NULL, 'Taastumispäevikud', 8, 0, 0),
(26, 25, 'Alkoloholi taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(34, 25, 'Amfetamiini taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(35, 25, 'Kannabinoidide taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(36, 25, 'Rahustite taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(37, 25, 'Opiaatide taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(38, 25, 'Muude uimastite taastumis- ja sõltuvuspäevikud', 8, 0, 0),
(31, 10, 'Reeglid', 8, 0, 0),
(32, 10, 'Uudiste sub', 8, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `googleusers`
--

CREATE TABLE IF NOT EXISTS `googleusers` (
  `id` varchar(30) NOT NULL,
  `uid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `googleusers`
--

INSERT INTO `googleusers` (`id`, `uid`) VALUES
('115820462347538642989', 51);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`id` int(10) unsigned NOT NULL,
  `p_pid` int(10) unsigned DEFAULT NULL,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `depth` int(10) unsigned NOT NULL DEFAULT '0',
  `pos` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9871 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `p_pid`, `tid`, `content`, `create_time`, `edit_time`, `depth`, `pos`, `uid`, `deleted`) VALUES
(9802, NULL, 13, 'Alates veebruarist on meie sait siin.', '2015-02-22 14:27:14', '2015-02-28 22:32:12', 0, 1, 8, 0),
(9803, 9802, 13, 'Ülikõv', '2015-02-22 17:42:11', '2015-02-22 17:42:11', 1, 2, 8, 0),
(9804, 9802, 13, 'Yep', '2015-02-23 14:41:10', '2015-02-23 14:41:10', 1, 3, 8, 0),
(9805, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-23 16:26:42', '2015-02-23 16:26:43', 1, 4, 8, 0),
(9806, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-23 18:06:40', '2015-02-23 18:13:29', 1, 6, 8, 0),
(9807, NULL, 14, 'The sisu', '2015-02-23 18:11:17', '2015-02-23 18:11:17', 0, 1, 8, 0),
(9808, NULL, 15, 'The sisu', '2015-02-23 18:11:23', '2015-02-23 18:11:23', 0, 1, 8, 0),
(9809, 9805, 13, 'Kirjuta kommentaar siia', '2015-02-23 18:13:29', '2015-02-23 18:13:29', 2, 5, 8, 0),
(9810, NULL, 17, 'rickroll', '2015-02-23 22:55:34', '2015-02-23 22:55:34', 0, 1, 8, 0),
(9811, 9810, 17, 'fun', '2015-02-23 23:01:04', '2015-02-23 23:01:04', 1, 2, 3, 0),
(9812, 9810, 17, 'epic', '2015-02-23 23:01:09', '2015-02-23 23:01:43', 1, 5, 3, 0),
(9813, 9811, 17, '???', '2015-02-23 23:01:14', '2015-02-23 23:01:14', 2, 3, 3, 0),
(9814, 9813, 17, 'veel', '2015-02-23 23:01:43', '2015-02-23 23:01:43', 3, 4, 3, 0),
(9815, 9810, 17, 'Kirjuta kommentaar siia', '2015-02-23 23:54:55', '2015-02-23 23:54:55', 1, 6, 8, 0),
(9816, 9806, 13, 'Kirjuta kommentaar siia', '2015-02-25 16:34:43', '2015-02-25 16:34:43', 2, 7, 8, 0),
(9817, NULL, 19, 'The sisu', '2015-02-25 16:38:02', '2015-02-25 16:38:02', 0, 1, 8, 0),
(9818, 9816, 13, 'Kirjuta kommentaar siia', '2015-02-25 16:44:29', '2015-02-25 16:44:29', 3, 8, 8, 0),
(9819, NULL, 20, 'The sisu', '2015-02-25 16:44:44', '2015-02-25 16:44:44', 0, 1, 8, 0),
(9820, 9802, 13, 'Kirjuta kommentaar siia', '2015-02-26 08:58:59', '2015-02-26 08:58:59', 1, 9, 8, 0),
(9826, NULL, 22, 'The sisu', '2015-02-28 21:50:32', '2015-02-28 21:50:32', 0, 1, 8, 0),
(9827, NULL, 23, 'fdsgfsdgdfsdfs', '2015-02-28 21:55:25', '2015-02-28 21:55:26', 0, 1, 8, 0),
(9828, NULL, 24, 'sfafsdfsdf', '2015-02-28 22:13:34', '2015-02-28 22:13:34', 0, 1, 8, 0),
(9829, NULL, 25, 'fdsfdssdfsfd', '2015-02-28 22:15:56', '2015-02-28 22:15:56', 0, 1, 8, 0),
(9830, 9829, 25, 'Kirjuta kommentaar siiaaaaa', '2015-03-01 11:33:58', '2015-03-01 11:34:02', 1, 2, 3, 0),
(999, NULL, 35, '','2015-05-09 11:33:58', '2015-05-09 11:34:02', 1, 2, 3, 0);

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

--
-- Dumping data for table `sessionbinds`
--

INSERT INTO `sessionbinds` (`uid`, `session_id`) VALUES
(3, 'bb14acd51ddf4103e1924d0b187205c4');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
`id` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  `post_count` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `fid`, `name`, `create_time`, `edit_time`, `uid`, `views`, `post_count`) VALUES
(13, 10, 'Olulised uudised', '2015-02-22 14:27:14', '2015-03-05 13:47:41', 8, 48, 14),
(14, 10, 'Uimastite taastusravikeskused: mida nende juures hindate?', '2015-02-23 18:11:17', '2015-02-28 20:03:24', 8, 16, 1),
(15, 10, 'Anonüümsed narkomaanid', '2015-02-23 18:11:23', '2015-02-28 20:03:30', 8, 10, 1),
(17, 20, 'Reeglid', '2015-02-23 22:55:34', '2015-03-05 07:51:28', 8, 5, 6),
(19, 10, 'Uudis1', '2015-02-25 16:38:02', '2015-03-03 14:42:52', 8, 12, 1),
(20, 10, 'Uudis2', '2015-02-25 16:44:44', '2015-02-28 20:03:32', 8, 2, 1),
(22, 10, 'Uudis3', '2015-02-28 21:50:32', '2015-02-28 21:50:32', 8, 1, 1),
(23, 10, 'Uudis4', '2015-02-28 21:55:25', '2015-02-28 21:55:26', 8, 1, 1),
(24, 10, 'Uudis5', '2015-02-28 22:13:34', '2015-03-05 13:49:36', 8, 2, 1),
(25, 10, 'saa', '2015-02-28 22:15:55', '2015-03-05 13:49:31', 8, 3, 2),
(26, 26, 'Päevik - Ma ei saa kunagi kuivaks', '2015-05-01 15:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(27, 26, 'Minu võitlus sõltuvusega', '2015-05-01 15:32:17', '2015-05-01 23:32:16', 3, 2, 0),
(28, 26, 'Aidake võitu saada alkoholist ja kokaiinist', '2015-05-01 15:32:18', '2015-05-01 23:32:16', 3, 2, 0),
(29, 26, 'Päevik - Vaja toetust, tahan elada kainet elu', '2015-05-01 15:32:19', '2015-05-01 23:32:16', 3, 2, 0),
(30, 26, 'tagasi kaine pärast 4 nädalast tsüklit', '2015-05-01 15:32:20', '2015-05-01 23:32:16', 3, 2, 0),
(31, 26, 'Päevik - Joodiku lugu väikestest asjadest', '2015-05-01 15:32:21', '2015-05-01 23:32:16', 3, 2, 0),
(32, 34, 'Päevik - Lõpuks tunnistan oma abikaasale kõik üles(Saime just lapse) 4 päeva kaine', '2015-05-01 15:32:22', '2015-05-01 23:32:16', 3, 2, 0),
(33, 34, 'Iha - Olen kaine viimased 30 päeva. Kuidas vastu panna uuesti tarvitamise ihale?', '2015-05-01 15:32:23', '2015-05-01 23:32:16', 3, 2, 0),
(34, 34, 'Päevik - Ta on olnud kaine juba pea pool aastat ja ma olen hirmul', '2015-05-01 15:33:16', '2015-05-01 23:32:16', 3, 2, 0),
(35, 34, 'Päevik - Kadumas', '2015-05-01 15:34:16', '2015-05-01 23:32:16', 3, 2, 0),
(36, 34, 'Päevik - Luuletus mu vaenlasele', '2015-05-01 15:35:16', '2015-05-01 23:32:16', 3, 2, 0),
(37, 35, 'Päevik - Üle 20 aasta kanepit', '2015-05-01 15:36:16', '2015-05-01 23:32:16', 3, 2, 0),
(38, 35, 'Minu lugu', '2015-05-01 15:37:16', '2015-05-01 23:32:16', 3, 2, 0),
(39, 35, 'Viimaks kaine pärast 12 aastat', '2015-05-01 15:38:16', '2015-05-01 23:32:16', 3, 2, 0),
(40, 35, 'Sünteetilise kanepi head ja pahed...võitlus sõltuvusega', '2015-05-01 15:39:16', '2015-05-01 23:32:16', 3, 2, 0),
(41, 35, 'Minu päevik: 22 a. mees, esimene suits 7-aastaselt.', '2015-05-01 15:39:17', '2015-05-01 23:32:16', 3, 2, 0),
(42, 36, 'Lootust kaotamas: aidake mind', '2015-05-01 15:39:18', '2015-05-01 23:32:16', 3, 2, 0),
(43, 36, 'Olen peamiselt vaaliumi peal pärast 20 aastat Xanax-it', '2015-05-01 15:39:19', '2015-05-01 23:32:16', 3, 2, 0),
(44, 36, 'Olen täiesti puhas olnud see aasta, v.a. 1 ja 2 jaanuar, kuni praeguseni', '2015-05-01 15:42:16', '2015-05-01 23:32:16', 3, 2, 0),
(45, 37, 'Ma ei suuda enam rahulikult mõelda: kirjutan kõik enda meelelt', '2015-05-01 15:22:16', '2015-05-01 23:32:16', 3, 2, 0),
(46, 37, 'Loperamiidi võõrutusravi, vajan teie toetust', '2015-05-01 15:11:16', '2015-05-01 23:32:16', 3, 2, 0),
(47, 37, 'Peaaegu 40 päeva - kas ma ennast kunagi okeilt tunnen?', '2015-05-01 16:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(48, 38, 'ravi - kui sa vajad abi, aita teisi: teiste aitamiseks lase ennast aidata', '2015-05-01 17:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(49, 38, 'Proovisin Kratonit', '2015-05-01 18:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(50, 38, 'Toidu ja nikotiini sõltuvus - vajan abi', '2015-05-01 19:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(51, 47, '12 sammu programm', '2015-05-01 20:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(52, 47, 'Opioidide võõrutus', '2015-05-01 21:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(53, 47, 'Jõuluaja üleelamis trikid ja nipid', '2015-05-01 22:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(54, 47, 'Uneaja kontrolli alla saamine', '2015-05-01 23:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(55, 48, 'Anna oma sõltuvusele hinnang(inglise keelne test)', '2015-05-01 23:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(56, 21, 'Kas keegi teist on öelnud oma partnerile (või üldse kellelegi) oma salajasest sõltuvusest', '2015-05-01 15:39:17', '2015-05-01 23:32:16', 3, 2, 0),
(57, 21, 'Pidev tung urineerida öösiti ja lämbumistunne', '2015-05-01 15:39:18', '2015-05-01 23:32:16', 3, 2, 0),
(58, 21, 'Legaalsed uimastid, olen kuid puhas olnud, kuid vaja edasi toime tulla', '2015-05-01 15:39:19', '2015-05-01 23:32:16', 3, 2, 0),
(59, 21, 'Kuidas ilma uimastiteta ennast mitte tühjana tunda?', '2015-05-01 15:42:16', '2015-05-01 23:32:16', 3, 2, 0),
(60, 39, 'Joomine ärevushäirega toimetulemiseks', '2015-05-01 15:22:16', '2015-05-01 23:32:16', 3, 2, 0),
(61, 40, 'Mitu korda olete metamfetamiinile tagasi langenud?', '2015-05-01 15:11:16', '2015-05-01 23:32:16', 3, 2, 0),
(62, 41, 'Tugevad peavalud pärast kanepi lõpetamist, mida teha?', '2015-05-01 16:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(63, 41, 'Kas ma saan oma narkotestist läbi?', '2015-05-01 17:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(64, 41, 'Kuidas mitte enda suurim vaenlane olla', '2015-05-01 18:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(65, 41, 'Kõige kummalisem high, mis ma kunagi saanud olen', '2015-05-01 19:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(66, 41, 'Valgustage mind pls - miks ma ei peaks kanepit tegema?', '2015-05-01 20:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(67, 42, 'Kokaiin ja mina', '2015-05-01 21:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(68, 42, 'Elan kahte elu samal ajal', '2015-05-01 22:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(69, 43, 'Kas ma peaks järjest doose vähendama või korraga lõpparve tegema?', '2015-05-01 23:32:16', '2015-05-01 23:32:16', 3, 2, 0),
(70, 44, 'Lõpparve GHB-ga, abi vaja', '2015-05-01 23:32:16', '2015-05-01 23:32:16', 3, 2, 0);



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
  `name` varchar(25) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edit_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usergroup` int(10) unsigned NOT NULL DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `email`, `create_time`, `edit_time`, `usergroup`) VALUES
(3, 'user1', 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a', 'email@meh.com', '2015-02-23 15:08:09', '2015-03-02 18:32:13', 1),
(4, 'user', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'Email', '2015-02-23 15:20:32', '2015-03-01 13:20:02', 1),
(7, 'Kasutajanimi2', '354b7d6a59251940bd3f6b49e029f2d043cc6e77', 'Email', '2015-02-23 15:23:25', '2015-03-01 13:20:02', 1),
(8, 'Kasutajanimi', '354b7d6a59251940bd3f6b49e029f2d043cc6e77', 'Email', '2015-02-23 17:55:31', '2015-03-01 13:20:02', 2),
(50, 'Mihkel', 'deb7cf8a77de1a90d8f93216bb95525c7fea7d0d', 'mihkel1994@gmail.com', '2015-03-01 15:34:38', '2015-03-01 15:34:38', 2),
(51, 'Kevin', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'kevin.nemerzitski@gmail.com', '2015-03-03 14:42:28', '2015-03-03 14:44:02', 2);

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
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9871;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
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
