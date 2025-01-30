-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 jan 2025 om 13:05
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centrumduurzaam`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs_ex_btw` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `categorie_id`, `naam`, `prijs_ex_btw`) VALUES
(5, 5, 'Comfy+', '200.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`id`, `categorie`) VALUES
(3, 'Kleding'),
(4, 'Meubels'),
(5, 'Bedden'),
(6, 'Spiegels'),
(7, 'Kapstokken'),
(8, 'Garderobekasten'),
(9, 'Schoenenkasten'),
(10, 'Witgoed'),
(11, 'Kledingkasten'),
(12, 'Bruingoed'),
(13, 'Grijsgoed'),
(14, 'Niet toegestane artikelen'),
(15, 'Glazen, Borden en Bestek'),
(16, 'Boeken');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `rollen` text NOT NULL,
  `is_geverifieerd` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`id`, `gebruikersnaam`, `wachtwoord`, `rollen`, `is_geverifieerd`) VALUES
(3, 'anna bos', '$2y$10$FpauRTZNsVm/UcotoWCrwOtwLCPFCDoq3usu.dM.uVqPSLZ2kqevC', 'directie', 0),
(4, 'jan bos', '$2y$10$SfSgr.z8A4gIk8CPXTXB9eXzCxtG292iThVXRYr89g2IYzlp3bMZ6', 'magazijn', 0),
(5, 'johan belg', '$2y$10$ZI6BGqUeqzT98/WcuNeauezSv/1i3ll2THVr0zGInR763USFL8pGq', 'winkelpersoneel', 0),
(6, 'barry bos', '$2y$10$NqH06FvFtzT7gf3RE6IH7O6242GF3bLAxhvxH1bUwCHxMmVG3gBlK', 'chauffeur', 0),
(7, 'zembo', '$2y$10$xGmOf0fWY3OTCdXy.agHm.NLKlI6EtmTad70508bNOG/P2nNml5MK', 'winkelpersoneel', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`id`, `naam`, `adres`, `plaats`, `telefoon`, `email`) VALUES
(1, 'Jan Jansen', 'Straat 1', 'Amsterdam', '0612345678', 'jan.jansen@example.com'),
(2, 'Piet Pietersen', 'Straat 2', 'Rotterdam', '0687654321', 'piet.pietersen@example.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `klant_id` int(11) NOT NULL,
  `kenteken` varchar(255) NOT NULL,
  `ophalen_of_bezorgen` enum('ophalen','bezorgen') NOT NULL,
  `afspraak_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `planning`
--

INSERT INTO `planning` (`id`, `artikel_id`, `klant_id`, `kenteken`, `ophalen_of_bezorgen`, `afspraak_op`) VALUES
(1, 5, 1, '2223', 'ophalen', '2025-01-15 13:40:00'),
(6, 5, 1, '232323', 'bezorgen', '2025-01-29 11:41:33'),
(14, 5, 2, 'qweqwe', 'ophalen', '2025-01-15 12:58:00'),
(25, 5, 2, 'qweqwe', 'ophalen', '2025-01-08 09:45:00'),
(27, 5, 1, 'qweqwe', 'ophalen', '2025-01-01 10:02:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ritten`
--

CREATE TABLE `ritten` (
  `id` int(11) NOT NULL,
  `planning_id` int(11) NOT NULL,
  `vertek` datetime(6) NOT NULL,
  `aankomst` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ritten`
--

INSERT INTO `ritten` (`id`, `planning_id`, `vertek`, `aankomst`) VALUES
(2, 1, '2025-01-03 12:25:00.000000', '2025-01-31 12:25:00.000000');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status_naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `status`
--

INSERT INTO `status` (`id`, `status_naam`) VALUES
(1, 'In Voorraad'),
(2, 'Uitverkocht');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verkopen`
--

CREATE TABLE `verkopen` (
  `id` int(11) NOT NULL,
  `klant_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `verkocht_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `verkopen`
--

INSERT INTO `verkopen` (`id`, `klant_id`, `artikel_id`, `verkocht_op`) VALUES
(2, 2, 5, '2025-01-07 08:59:00'),
(3, 2, 5, '2025-02-04 08:59:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorraad`
--

CREATE TABLE `voorraad` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `locatie` varchar(255) NOT NULL,
  `aantal` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `ingeboekt_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `voorraad`
--

INSERT INTO `voorraad` (`id`, `artikel_id`, `locatie`, `aantal`, `status_id`, `ingeboekt_op`) VALUES
(6, 5, 'qwe', 2, 1, '2025-01-01 13:15:00'),
(7, 5, 'qwe', 2, 1, '2025-01-15 13:18:00'),
(8, 5, 'qwe', 2, 1, '2025-01-02 13:19:00');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `klant_id` (`klant_id`);

--
-- Indexen voor tabel `ritten`
--
ALTER TABLE `ritten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `planning_id` (`planning_id`) USING BTREE;

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verkopen`
--
ALTER TABLE `verkopen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klant_id` (`klant_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT voor een tabel `ritten`
--
ALTER TABLE `ritten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `verkopen`
--
ALTER TABLE `verkopen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `voorraad`
--
ALTER TABLE `voorraad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Beperkingen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`),
  ADD CONSTRAINT `planning_ibfk_3` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`);

--
-- Beperkingen voor tabel `ritten`
--
ALTER TABLE `ritten`
  ADD CONSTRAINT `ritten_ibfk_1` FOREIGN KEY (`planning_id`) REFERENCES `planning` (`id`);

--
-- Beperkingen voor tabel `verkopen`
--
ALTER TABLE `verkopen`
  ADD CONSTRAINT `verkopen_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`),
  ADD CONSTRAINT `verkopen_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`);

--
-- Beperkingen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD CONSTRAINT `voorraad_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `voorraad_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
