-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Jul 2023 um 01:11
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be19_cr5_animal_adoption_marvinvandyck`
--
CREATE DATABASE IF NOT EXISTS `be19_cr5_animal_adoption_marvinvandyck` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be19_cr5_animal_adoption_marvinvandyck`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `description` varchar(510) NOT NULL,
  `vaccinated` tinyint(1) DEFAULT NULL,
  `adopted` tinyint(1) DEFAULT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `animals`
--

INSERT INTO `animals` (`id`, `name`, `picture`, `location`, `size`, `age`, `description`, `vaccinated`, `adopted`, `gender`) VALUES
(1, 'Vincent', 'cat1.jpg', 'Praterstrasse 24', 'small', '5', 'Vincent is a cute 5 year old Cat.', 1, 0, 'Male'),
(2, 'Balou', 'dog1.jpg', 'Waldgasse 7', 'default', '8', 'Balou is a beautiful 8 year old white dog.', 1, 0, 'Male'),
(3, 'Flipper', 'dolphin1.jpg', 'Oceanstreet 90', 'large', '4', ' Flipper enjoys swimming and playing golf.', 0, 0, 'Male'),
(4, 'Benisha', 'elephant1.jpg', 'Schönbrunnerstraße 144', 'large', '34', 'Benisha likes to play football.', 1, 0, 'Female'),
(5, 'Kira', 'fox1.jpg', 'Waldgasse 39', 'small', '3', 'Kira is a 3 year old fox', 1, 1, 'Female'),
(6, 'Simba', 'lion1.jpg', 'Schönbrunnerstraße 67', 'large', '7', 'The old owner thought he was a little kitten, but then Simba grew up.', 0, 0, 'Male'),
(7, 'Pigi ion', 'pigeon1.jpg', 'Airstreet 7', 'small', '1', 'coming soon...', 0, 0, 'Female'),
(8, 'Tortue', 'turtle1.jpg', 'Zebrastraße 12', 'default', '79', 'Tortue enjoys running marathons, but only in her spare time.', 0, 0, 'Female'),
(9, 'Mia', 'cat2.jpg', 'Praterstrasse 24', 'small', '0.2', 'Mia is a very young cat.', 1, 0, 'Female'),
(10, 'Rocky', 'dog2.jpg', 'Rathausstraße 54', 'small', '9', 'Look at his face!', 1, 0, 'Male'),
(13, 'Emma', '64c41e067c3ef.jpg', 'Emmastreet 5', 'small', '5', 'Emma is just a cute corgi looking for a new home.', 1, 0, 'Female');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adoption_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'user',
  `phone_number` int(15) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_id` FOREIGN KEY (`pet_id`) REFERENCES `animals` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
