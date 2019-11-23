-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. Sep 2013 um 10:57
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `fitnessportal`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fitnesskurse`
--

CREATE TABLE IF NOT EXISTS `fitnesskurse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `startdate` datetime NOT NULL,
  `duration` int(3) NOT NULL,
  `trainer` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` float NOT NULL,
  `numberOfPeople` int(2) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `fitnesskurse`
--

INSERT INTO `fitnesskurse` (`id`, `title`, `notes`, `startdate`, `duration`, `trainer`, `price`, `numberOfPeople`, `version`) VALUES
(1, 'Kurs 1', 'Yoga', '2019-04-08', '90', 'Stefan', '50', '10', 1),
(2, 'Kurs 2', 'Power Yoga', '2019-04-08', '60', 'Deniz', '30', '5', 1),
(3, 'Kurs 3', 'Body Combat', '2019-04-08', '67', 'Nadine', '90', '6', 1),
(4, 'Kurs 4', 'Stretching', '2019-04-08', '30', 'Deniz', '100', '2', 1),
(5, 'Kurs 5', 'Body Combat', '2019-04-08', '45', 'Nadine', '150', '99', 1),
(6, 'Kurs 6', 'Bauch, Beine, Po', '2019-04-08', '70', 'Stefan', '50', '10', 1),
(7, 'Kurs 7', 'Achtsamkeit', '2019-04-08', '90', 'Nadine', '15', '99', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
