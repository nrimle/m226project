-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Dez 2018 um 07:35
-- Server-Version: 10.1.32-MariaDB
-- PHP-Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `travelr`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `request`
--

CREATE TABLE `request` (
  `request_id` bigint(20) NOT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `departure` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `from_to` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id__fk` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `request`
--

INSERT INTO `request` (`request_id`, `destination`, `departure`, `datetime`, `from_to`, `created`, `user_id__fk`) VALUES
(1, 'Zürich HB', 'Zürich Hardbrücke', '2028-11-05 14:58:27', 0, '2018-11-22 19:20:06', 1),
(2, 'Zürich HB', 'Museum für Gestaltung', '2018-10-02 14:59:32', 1, '2018-11-22 19:20:06', 1),
(3, 'Bern', 'Winterthur', '2000-11-02 14:59:55', 0, '2018-11-22 19:20:06', 2),
(4, 'Appenzell', 'Bonstetten, Isenbach', '2021-11-02 15:03:38', 0, '2018-11-22 19:20:06', 3),
(5, 'Genf', 'St. Gallen', '2013-11-02 15:03:55', 0, '2018-11-22 19:20:06', NULL),
(6, 'Ostermundigen', 'Zug', '2118-05-07 15:04:45', 1, '2018-11-22 19:20:06', NULL),
(7, 'Zürich HB', 'Zürich Hardbrücke', '2024-11-05 14:58:27', 0, '2018-11-22 19:20:06', 1),
(8, 'Zuzwil Schulhaus', 'Zuzwil, Industrie', '2018-11-02 14:59:32', 1, '2018-11-22 19:20:06', 1),
(9, 'Bern', 'Liebefeld', '2000-11-02 11:59:55', 0, '2018-11-22 19:20:06', 12),
(10, 'Museum für Gestaltung', 'Zug, Isenbach', '2020-11-02 15:03:38', 0, '2018-11-22 19:20:06', 3),
(11, 'Genf', 'St. Gallen', '2013-11-02 15:03:55', 0, '2018-11-22 19:20:06', NULL),
(12, 'Appenzell', 'Ditwil am See', '2118-05-07 15:00:45', 0, '2018-11-22 19:20:06', NULL),
(13, 'Zürich HB', 'Zürich Hardbrücke', '2024-11-05 14:48:27', 1, '2018-11-22 19:20:06', 1),
(14, 'Zürich HB', 'Limmatplatz', '2018-11-02 04:59:32', 0, '2018-11-22 19:20:06', 1),
(15, 'Luzern', 'Winterthur', '2000-11-02 14:59:01', 0, '2018-11-22 19:20:06', 22),
(16, 'Museum für Gestaltung', 'Bonstetten, Isenbach', '2018-11-02 15:03:38', 1, '2018-11-22 19:20:06', 3),
(17, 'Zuzwil, Industrie', 'St. Gallen', '2013-12-02 15:03:55', 0, '2018-11-22 19:20:06', NULL),
(18, 'Ostermundigen', 'Liebefeld', '2119-05-07 15:04:45', 0, '2018-11-22 19:20:06', NULL),
(19, 'Zürich HB', 'Museum für Gestaltung', '2018-11-03 14:59:32', 1, '2018-11-22 19:20:06', 1),
(20, 'Bern', 'Winterthur', '2000-11-02 10:59:55', 0, '2018-11-22 19:20:06', 5),
(21, 'Museum für Gestaltung', 'Luzern, Isenbach', '2020-11-02 15:03:38', 1, '2018-11-22 19:20:06', 3),
(22, 'Genf', 'St. Gallen', '2013-11-02 19:03:55', 0, '2018-11-22 19:20:06', NULL),
(23, 'Zug', 'Ditwil am See', '2118-05-07 18:04:45', 0, '2018-11-22 19:20:06', NULL),
(24, 'Limmatplatz', 'Museum für Gestaltung', '2018-11-09 14:59:32', 0, '2018-11-22 19:20:06', 1),
(25, 'Bern', 'Winterthur', '2000-01-02 14:59:55', 0, '2018-11-22 19:20:06', 9),
(26, 'Appenzell', 'Luzern, Isenbach', '2021-11-30 15:03:38', 1, '2018-11-22 19:20:06', 3),
(27, 'Genf', 'St. Gallen', '2013-11-22 15:03:55', 0, '2018-11-22 19:20:06', NULL),
(28, 'Ostermundigen', 'Ditwil am See', '2118-05-01 15:04:45', 1, '2018-11-22 19:20:06', NULL),
(29, 'Zuzwil Schulhaus', 'Zürich Hardbrücke', '2024-11-05 01:58:27', 0, '2018-11-22 19:20:06', 1),
(30, 'Zürich HB', 'Zuzwil, Industrie', '2018-11-02 14:59:00', 0, '2018-11-22 19:20:06', 1),
(31, 'Bern', 'Basel', '2000-10-02 14:59:55', 0, '2018-11-22 19:20:06', 18),
(32, 'Museum für Gestaltung', 'Bonstetten, Isenbach', '2001-11-02 15:03:38', 1, '2018-11-22 19:20:06', 3),
(33, 'Genf', 'St. Gallen', '2013-11-02 15:07:55', 0, '2018-11-22 19:20:06', NULL),
(34, 'Ostermundigen', 'Regensdorf', '2118-05-07 10:04:45', 0, '2018-11-22 19:20:06', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `created`) VALUES
(1, 'pmeter@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'peter', 'meter', '2018-12-04 05:33:29'),
(2, 'reto@schnudi.com', '098f6bcd4621d373cade4e832627b4f6', 'reto', 'schnudi', '2018-12-04 05:33:29'),
(3, 'knutgut@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'knut', 'gut', '2018-12-04 05:33:29'),
(4, 'walter@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'walter', 'müller', '2018-12-04 05:33:29'),
(5, 'maria@meier.com', '098f6bcd4621d373cade4e832627b4f6', 'maria', 'meier', '2018-12-04 05:33:29'),
(6, 'helenekeller@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'helene', 'keller', '2018-12-04 05:33:29'),
(7, 'ralf@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'ralf', 'metzger', '2018-12-04 05:33:29'),
(8, 'simon@blocher.com', '098f6bcd4621d373cade4e832627b4f6', 'simon', 'blocher', '2018-12-04 05:33:29'),
(9, 'pascalmerkel@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'pascal', 'merkel', '2018-12-04 05:33:29'),
(10, 'franziska@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'franziska', 'somoruga', '2018-12-04 05:33:29'),
(11, 'urs@voser.com', '098f6bcd4621d373cade4e832627b4f6', 'urs', 'voser', '2018-12-04 05:33:29'),
(12, 'janbrunner@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'jan', 'brunner', '2018-12-04 05:33:29'),
(13, 'yanick@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'yanick', 'fiserer', '2018-12-04 05:33:29'),
(14, 'mike@kamm.com', '098f6bcd4621d373cade4e832627b4f6', 'mike', 'kamm', '2018-12-04 05:33:29'),
(15, 'michaelmeiers@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'michael', 'meiers', '2018-12-04 05:33:29'),
(16, 'susanne@locher.com', '098f6bcd4621d373cade4e832627b4f6', 'susanne', 'locher', '2018-12-04 05:33:29'),
(17, 'biancawidmer@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'bianca', 'widmer', '2018-12-04 05:33:29'),
(18, 'svenja@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'svenja', 'brunner', '2018-12-04 05:33:29'),
(19, 'katarina@schlegel.com', '098f6bcd4621d373cade4e832627b4f6', 'katarina', 'schlegel', '2018-12-04 05:33:29'),
(20, 'manuelmanifest@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'manuel', 'manifest', '2018-12-04 05:33:29'),
(21, 'manuela@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'manuela', 'gradle', '2018-12-04 05:33:29'),
(22, 'kurt@hibernate.com', '098f6bcd4621d373cade4e832627b4f6', 'kurt', 'hibernate', '2018-12-04 05:33:29'),
(23, 'hansausca@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'hans', 'ausca', '2018-12-04 05:33:29'),
(24, 'ueli@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'ueli', 'spring', '2018-12-04 05:33:29'),
(25, 'christof@php.com', '098f6bcd4621d373cade4e832627b4f6', 'christof', 'php', '2018-12-04 05:33:29'),
(26, 'cederichtml@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'cederic', 'html', '2018-12-04 05:33:29'),
(27, 'thomas@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'thomas', 'java', '2018-12-04 05:33:29'),
(28, 'norbert@notter.com', '098f6bcd4621d373cade4e832627b4f6', 'norbert', 'notter', '2018-12-04 05:33:29'),
(29, 'hermannheinrich@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'hermann', 'heinrich', '2018-12-04 05:33:29'),
(30, 'olaf@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'olaf', 'olaf', '2018-12-04 05:33:29'),
(31, 'patrick@weiler.com', '098f6bcd4621d373cade4e832627b4f6', 'patrick', 'weiler', '2018-12-04 05:33:29'),
(32, 'klausholzner@bluewin.ch', '098f6bcd4621d373cade4e832627b4f6', 'klaus', 'holzner', '2018-12-04 05:33:29');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `request_request_id_uindex` (`request_id`),
  ADD KEY `user_id__fk` (`user_id__fk`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_user_id_uindex` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `request`
--
ALTER TABLE `request`
  MODIFY `request_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `user_id__fk` FOREIGN KEY (`user_id__fk`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
