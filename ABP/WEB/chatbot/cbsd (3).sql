-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 08 Mai 2016 à 15:04
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cbsd`
--

-- --------------------------------------------------------

--
-- Structure de la table `aimlsets`
--

CREATE TABLE IF NOT EXISTS `aimlsets` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `AimlFile` longtext,
  `Load` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `BotId` (`BotId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `aimlsets`
--

INSERT INTO `aimlsets` (`Id`, `BotId`, `AimlFile`, `Load`) VALUES
(1, 1, 'ai.aiml', 1);

-- --------------------------------------------------------

--
-- Structure de la table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Start` datetime NOT NULL,
  `Name` longtext,
  `Description` longtext,
  `PointsPerWin` bigint(20) NOT NULL,
  `Prize` bigint(20) NOT NULL,
  `ParticipantNumber` bigint(20) NOT NULL,
  `Status` int(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `competitions`
--

INSERT INTO `competitions` (`Id`, `Start`, `Name`, `Description`, `PointsPerWin`, `Prize`, `ParticipantNumber`, `Status`) VALUES
(1, '2016-05-03 00:00:00', 'TEST', 'TOURNOI', 10, 100, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `RoundId` bigint(20) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `Start` datetime NOT NULL,
  `Duration` time NOT NULL,
  `WinnerId` int(11) NOT NULL,
  `ChatHistoryFile` text NOT NULL,
  `PlayerSleepTime` time NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `RoundId` (`RoundId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`Id`, `RoundId`, `Status`, `Start`, `Duration`, `WinnerId`, `ChatHistoryFile`, `PlayerSleepTime`) VALUES
(36, 28, 3, '2016-05-03 00:00:00', '00:00:15', 2, '131069494317868207.dat', '00:00:02');

-- --------------------------------------------------------

--
-- Structure de la table `participations`
--

CREATE TABLE IF NOT EXISTS `participations` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `CompetitionId` bigint(20) DEFAULT NULL,
  `JoinDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `CompetitionId` (`CompetitionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `participations`
--

INSERT INTO `participations` (`Id`, `BotId`, `CompetitionId`, `JoinDate`) VALUES
(1, 1, 1, '2016-05-03 00:00:00'),
(2, 2, 1, '2016-05-03 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `personalities`
--

CREATE TABLE IF NOT EXISTS `personalities` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `PersonalityFile` longtext,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `personalities`
--

INSERT INTO `personalities` (`Id`, `BotId`, `PersonalityFile`, `Active`) VALUES
(1, 1, 'Settings.xml', 1),
(2, 2, 'Settings.xml', 1),
(3, 3, 'Settings.xml', 1),
(4, 4, 'Settings.xml', 1);

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `GameId` bigint(20) DEFAULT NULL,
  `BotId` bigint(20) DEFAULT NULL,
  `Score` double NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `GameId` (`GameId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Contenu de la table `players`
--

INSERT INTO `players` (`Id`, `GameId`, `BotId`, `Score`) VALUES
(71, 36, 2, 10),
(72, 36, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rankings`
--

CREATE TABLE IF NOT EXISTS `rankings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `BotId` int(11) NOT NULL,
  `CompetitionId` int(11) NOT NULL,
  `Rank` double NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `rankings`
--

INSERT INTO `rankings` (`Id`, `BotId`, `CompetitionId`, `Rank`) VALUES
(12, 1, 1, 2),
(13, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `rounds`
--

CREATE TABLE IF NOT EXISTS `rounds` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `CompetitionId` bigint(20) DEFAULT NULL,
  `Number` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `CompetitionId` (`CompetitionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `rounds`
--

INSERT INTO `rounds` (`Id`, `CompetitionId`, `Number`) VALUES
(28, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Username` longtext,
  `Password` longtext,
  `Email` longtext,
  `FirstName` longtext,
  `LastName` longtext,
  `Role` int(11) NOT NULL,
  `BotName` longtext,
  `BotDescription` longtext,
  `BotScore` bigint(20) NOT NULL,
  `BotActive` tinyint(1) NOT NULL,
  `Salt` varchar(100) NOT NULL,
  `Activity` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `Role`, `BotName`, `BotDescription`, `BotScore`, `BotActive`, `Salt`, `Activity`) VALUES
(1, 'arsslen', '123456', 'arsslens021@gmail.com', 'Arsslen', 'Idadi', 1, 'Jane', 'Jane is an AI', 0, 1, '', '0000-00-00 00:00:00'),
(2, 'amine', '123456', NULL, 'Amine', 'Troudi', 1, 'AmineBot', 'Amine bot', 980, 1, '', '0000-00-00 00:00:00'),
(3, 'ahmed', '123456', NULL, 'Ahmed', 'Laouini', 1, 'AhmedBot', NULL, 200, 1, '', '0000-00-00 00:00:00'),
(4, 'khaled', '123456', NULL, 'Khaled', 'Ferjani', 1, 'KhaledBot', NULL, 100, 1, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `VisitorIdentifier` longtext,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `visitors`
--

INSERT INTO `visitors` (`Id`, `BotId`, `VisitorIdentifier`) VALUES
(1, 1, 'Arsslen'),
(2, 1, 'Amine'),
(3, 1, 'Ghassen'),
(4, 2, 'Ghassen'),
(5, 3, 'Ghassen'),
(6, 4, 'Ghassen'),
(7, 1, 'Unknown');

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `GameId` bigint(20) DEFAULT NULL,
  `BotId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `GameId` (`GameId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
