-- vkNgine v3.0.125
--
-- Fresh Install SQL Queries
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `gym`
--

--
-- Table structure for table `daily_exercises`
--

DROP TABLE IF EXISTS `daily_exercises`;
CREATE TABLE `daily_exercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `workoutId` int(11) NOT NULL,
  `workoutDay` int(11) NOT NULL,
  `activity` varchar(17) NOT NULL,
  `moreDetails` text NOT NULL,
  `type` enum('Running','Swimming','Rope Jumping','Cycling','Weight Lifting','Football') NOT NULL,
  `date` date NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

--
-- Dumping data for table `daily_exercises`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_details`
--

DROP TABLE IF EXISTS `daily_details`;
CREATE TABLE IF NOT EXISTS `daily_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `type` enum('COLOR','SUPPLEMENT') NOT NULL,
  `value` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `daily_details`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_intake`
--

CREATE TABLE `daily_intake` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `mealId` int(11) NOT NULL,
  `foodId` int(11) NOT NULL,
  `howMuch` varchar(25) NOT NULL,
  `foodServing` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
CREATE TABLE IF NOT EXISTS `exercises` (
  `exerciseId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `instructions` text NOT NULL,
  `primaryMuscle` varchar(100) NOT NULL,
  `secondaryMuscle` varchar(100) NOT NULL,
  `mechanics` varchar(100) NOT NULL,
  `equipmentUsed` varchar(100) NOT NULL,
  `dateInserted` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`exerciseId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exercises`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises_assets`
--

DROP TABLE IF EXISTS `exercises_assets`;
CREATE TABLE IF NOT EXISTS `exercises_assets` (
  `assetId` int(11) NOT NULL AUTO_INCREMENT,
  `exerciseId` int(11) NOT NULL,
  `file` varchar(50) NOT NULL,
  `type` enum('VIDEO','PICTURE') DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `dateInserted` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`assetId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exercises_assets`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `foodId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `servingSize` varchar(255) DEFAULT NULL,
  `calories` varchar(255) DEFAULT NULL,
  `fat` varchar(255) DEFAULT NULL,
  `cholesterol` varchar(255) DEFAULT NULL,
  `sodium` varchar(255) DEFAULT NULL,
  `carbs` varchar(255) DEFAULT NULL,
  `fiber` varchar(255) DEFAULT NULL,
  `protein` varchar(255) DEFAULT NULL,
  `sugar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`foodId`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referrer` varchar(200) DEFAULT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `dateInserted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `priority` smallint(6) NOT NULL DEFAULT '0',
  `url` varchar(200) NOT NULL DEFAULT '',
  `userAgent` varchar(200) NOT NULL DEFAULT '',
  `info` mediumtext NOT NULL,
  `userId` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log`
--


-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

DROP TABLE IF EXISTS `log_activity`;
CREATE TABLE IF NOT EXISTS `log_activity` (
  `activityId` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userId` mediumint(9) NOT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `permission` enum('PUBLIC','PRIVATE') NOT NULL DEFAULT 'PRIVATE',
  PRIMARY KEY (`activityId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log_activity`
--


-- --------------------------------------------------------

--
-- Table structure for table `log_logins`
--

DROP TABLE IF EXISTS `log_logins`;
CREATE TABLE IF NOT EXISTS `log_logins` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userId` mediumint(8) DEFAULT NULL,
  `userType` enum('ADMIN','STANDARD','LIMITED') NOT NULL,
  `ip` varchar(20) NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log_logins`
--

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `mealId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `dateInserted` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`mealId`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

-- --------------------------------------------------------

--
-- Table structure for table `meals_foods`
--

CREATE TABLE `meals_foods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mealId` int(11) NOT NULL,
  `foodId` int(11) NOT NULL,
  `servingSize` varchar(25) NOT NULL,
  `servingSizeType` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

DROP TABLE IF EXISTS `measurements`;
CREATE TABLE IF NOT EXISTS `measurements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `value` text NOT NULL,
  `type` enum('WEIGHT') NOT NULL,
  `date` date NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Dumping data for table `measurements`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `sessionId` char(32) NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`sessionId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `companyName` varchar(25) NOT NULL,
  `mailingAddress` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  `zip` mediumint(5) DEFAULT NULL,
  `calendarView` enum('Weekly','Monthly') NOT NULL DEFAULT 'Monthly',
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `dateInserted` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `lastLogin` datetime NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`, `firstName`, `lastName`, `companyName`, `mailingAddress`, `phone`, `city`, `state`, `zip`, `password`, `active`, `dateInserted`, `dateUpdated`, `lastLogin`) VALUES
(1, 'vkn@vknyvz.com', 'Volkan', 'Yavuz', 'Google', '220 5th avenue', '6463717023', 'New York', 'NY', 10031, 'c4ca4238a0b923820dcc509a6f75849b', 'Y', '0000-00-00 00:00:00', '2011-09-24 14:17:17', '2011-09-24 14:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_admins`
--

DROP TABLE IF EXISTS `users_admins`;
CREATE TABLE IF NOT EXISTS `users_admins` (
  `userId` mediumint(8) unsigned NOT NULL,
  `level` enum('ADMIN','STANDARD','LIMITED') NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_admins`
--

INSERT INTO `users_admins` (`userId`, `level`) VALUES
(1, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `users_tokens`
--

DROP TABLE IF EXISTS `users_tokens`;
CREATE TABLE IF NOT EXISTS `users_tokens` (
  `tokenId` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userId` mediumint(8) unsigned NOT NULL,
  `token` varchar(50) NOT NULL,
  `dateInserted` datetime NOT NULL,
  PRIMARY KEY (`tokenId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users_tokens`
--

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

DROP TABLE IF EXISTS `workouts`;
CREATE TABLE IF NOT EXISTS `workouts` (
  `workoutId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `day` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `source` text NOT NULL,
  `dateInserted` datetime NOT NULL,
  `dateUpdated` datetime NOT NULL,
  PRIMARY KEY (`workoutId`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1

-- --------------------------------------------------------

--
-- Table structure for table `workouts_exercises`
--

DROP TABLE IF EXISTS `workouts_exercises`;
CREATE TABLE `workouts_exercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workoutId` int(11) NOT NULL,
  `exerciseId` int(11) NOT NULL,
  `day` enum('1','2','3','4','5','6','7') NOT NULL,
  `sets` tinyint(4) NOT NULL,
  `reps` varchar(25) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1