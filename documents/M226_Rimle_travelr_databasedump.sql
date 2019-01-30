-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jan 2019 um 12:56
-- Server-Version: 10.1.32-MariaDB
-- PHP-Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `travelr`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `request`
--

CREATE TABLE `request` (
  `request_id`  bigint(20) NOT NULL,
  `destination` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `departure`   varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date`        date                         DEFAULT NULL,
  `time`        time                         DEFAULT NULL,
  `created`     timestamp  NOT NULL          DEFAULT CURRENT_TIMESTAMP,
  `user_id__fk` bigint(20)                   DEFAULT NULL,
  `from_to`     tinyint(1)                   DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id`    bigint(20) NOT NULL,
  `email`      varchar(50) COLLATE utf8_bin  DEFAULT NULL,
  `password`   varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8_bin  DEFAULT NULL,
  `last_name`  varchar(30) COLLATE utf8_bin  DEFAULT NULL,
  `created`    timestamp  NULL               DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `created`) VALUES
  (40, 'hans@peter.com', '$2y$10$/SuM/.iUqev1a6mIdJzBVODhbiIRTHPirD6YU6Wpy5nLDuplUlyOO', 'Hans', 'Peter',
   '2019-01-25 21:18:53');

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
  MODIFY `request_id` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 88;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 41;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `user_id__fk` FOREIGN KEY (`user_id__fk`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
