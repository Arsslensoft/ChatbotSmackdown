-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 12 Mai 2016 à 22:20
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
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `BotId` (`BotId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `aimlsets`
--

INSERT INTO `aimlsets` (`Id`, `BotId`, `AimlFile`) VALUES
(9, 1, 'ai.aiml'),
(10, 1, 'ai.aiml'),
(11, 1, 'ai.aiml'),
(12, 1, 'ai.aiml'),
(13, 1, 'ai.aiml'),
(14, 1, 'bot.aiml'),
(15, 1, 'alice.aiml'),
(16, 1, 'bot_profile.aiml'),
(17, 1, 'science.aiml');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `competitions`
--

INSERT INTO `competitions` (`Id`, `Start`, `Name`, `Description`, `PointsPerWin`, `Prize`, `ParticipantNumber`, `Status`) VALUES
(1, '2016-05-03 00:00:00', 'TEST', 'TOURNOI', 10, 100, 2, 2),
(2, '2016-05-09 11:22:00', 'HELLO', 'A', 15, 200, 4, 2),
(6, '2016-05-24 00:00:00', 'ARSS', 'FERERZ', 20, 152, 2, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`Id`, `RoundId`, `Status`, `Start`, `Duration`, `WinnerId`, `ChatHistoryFile`, `PlayerSleepTime`) VALUES
(36, 28, 3, '2016-05-13 13:00:00', '00:00:15', 2, '131069494317868207.dat', '00:00:02'),
(37, 29, 2, '2016-05-09 11:22:00', '00:00:15', 1, '131072710004657111.dat', '00:00:02'),
(38, 29, 2, '2016-05-09 11:27:00', '00:00:15', 1, '131072710190143410.dat', '00:00:02'),
(39, 30, 3, '2016-05-09 11:22:00', '00:00:15', 2, '131072715092619466.dat', '00:00:02'),
(40, 30, 3, '2016-05-09 11:27:00', '00:00:15', 3, '131072715276663515.dat', '00:00:02'),
(41, 31, 3, '2016-05-10 11:22:00', '00:00:15', 2, '131072715787436943.dat', '00:00:02');

-- --------------------------------------------------------

--
-- Structure de la table `participations`
--

CREATE TABLE IF NOT EXISTS `participations` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `CompetitionId` bigint(20) DEFAULT NULL,
  `JoinDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `CompetitionId` (`CompetitionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `participations`
--

INSERT INTO `participations` (`Id`, `BotId`, `CompetitionId`, `JoinDate`) VALUES
(1, 1, 1, '2016-05-02 23:00:00'),
(2, 2, 1, '2016-05-02 23:00:00'),
(3, 1, 2, '2016-05-09 10:19:50'),
(4, 2, 2, '2016-05-09 10:19:50'),
(5, 3, 2, '2016-05-09 10:20:03'),
(6, 4, 2, '2016-05-09 10:20:03'),
(9, 1, 6, '2016-05-12 17:20:52');

-- --------------------------------------------------------

--
-- Structure de la table `personalities`
--

CREATE TABLE IF NOT EXISTS `personalities` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BotId` bigint(20) DEFAULT NULL,
  `PersonalityFile` longtext,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `personalities`
--

INSERT INTO `personalities` (`Id`, `BotId`, `PersonalityFile`) VALUES
(1, 1, 'Settings.xml'),
(2, 2, 'Settings.xml'),
(3, 3, 'Settings.xml'),
(4, 4, 'Settings.xml');

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `GameId` bigint(20) DEFAULT NULL,
  `BotId` bigint(20) DEFAULT NULL,
  `Score` double NOT NULL,
  `Votes` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `GameId` (`GameId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Contenu de la table `players`
--

INSERT INTO `players` (`Id`, `GameId`, `BotId`, `Score`, `Votes`) VALUES
(71, 36, 2, 10, 0),
(72, 36, 1, 0, 3),
(77, 39, 2, 15, 0),
(78, 39, 4, 0, 0),
(79, 40, 3, 15, 0),
(80, 40, 1, 0, 0),
(81, 41, 2, 15, 0),
(82, 41, 3, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `rankings`
--

INSERT INTO `rankings` (`Id`, `BotId`, `CompetitionId`, `Rank`) VALUES
(12, 1, 1, 2),
(13, 2, 1, 1),
(14, 4, 2, 4),
(15, 1, 2, 3),
(16, 3, 2, 2),
(17, 2, 2, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `rounds`
--

INSERT INTO `rounds` (`Id`, `CompetitionId`, `Number`) VALUES
(28, 1, 0),
(30, 2, 0),
(31, 2, 1);

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
  `Salt` longtext NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `Role`, `BotName`, `BotDescription`, `BotScore`, `BotActive`, `Salt`) VALUES
(1, 'arsslen', '906d2b500830ad30aaeb7d4a21ceca8da01e50c1', 'arsslens021@gmail.com', 'Arsslen', 'Idadi', 1, 'Jane', 'Jane is an AI', 0, 1, '573179813b4861.72670814573179813b4ae0.85200450573179813b4c80.20165751573179813b4e18.94260116573179813b4f91.51601108573179813b511'),
(2, 'amine', 'b8d322d898ad29b912892d10b2f636860fbe5e39', NULL, 'Amine', 'Troudi', 1, 'AmineBot', 'Amine bot', 1210, 1, '572e015bd71215.94836345572e015bd71496.19972114572e015bd71639.26706922572e015bd717b6.75656877572e015bd71938.20758471572e015bd71ab'),
(3, 'ahmed', 'b8d322d898ad29b912892d10b2f636860fbe5e39', NULL, 'Ahmed', 'Laouini', 1, 'AhmedBot', NULL, 215, 1, '572e015bd71215.94836345572e015bd71496.19972114572e015bd71639.26706922572e015bd717b6.75656877572e015bd71938.20758471572e015bd71ab'),
(4, 'khaled', 'b8d322d898ad29b912892d10b2f636860fbe5e39', NULL, 'Khaled', 'Ferjani', 1, 'KhaledBot', NULL, 100, 1, '572e015bd71215.94836345572e015bd71496.19972114572e015bd71639.26706922572e015bd717b6.75656877572e015bd71938.20758471572e015bd71ab'),
(10, 'Ghassen', '2dcefcc2371073d0e9c7867a4888334762a69a71', 'arsslens021@gmail.com', 'Ghassen', 'Manai', 0, 'GASTON', NULL, 0, 1, '5731a65d5ceed5.408459725731a65d5cf167.557277535731a65d5cf302.687581505731a65d5cf492.228205925731a65d5cf602.028188555731a65d5cf7a');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
(7, 1, 'Unknown'),
(8, 10, 'Ghassen'),
(9, 10, 'arsslen');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
