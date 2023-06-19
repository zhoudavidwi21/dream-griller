-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Jun 2023 um 13:25
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
-- Datenbank: `dreamgriller_db`
--
DROP DATABASE IF EXISTS `dreamgriller_db`;
CREATE DATABASE IF NOT EXISTS `dreamgriller_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dreamgriller_db`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `amount` double NOT NULL DEFAULT 10,
  `residual_value` double NOT NULL,
  `expirydate` date NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `amount`, `residual_value`, `expirydate`, `expired`) VALUES
(1, 'testcode123', 10, 10, '2023-06-30', 0),
(2, '123456', 50, 50, '2023-06-27', 0),
(3, 'uC65D', 1000, 1000, '2024-06-01', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `gender` enum('Firma','Herr','Frau','Divers') NOT NULL,
  `adress` varchar(256) NOT NULL,
  `postcode` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `paymethod` enum('Kreditkarte','Vorkasse','Rechnung') NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `logintime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `company`, `gender`, `adress`, `postcode`, `city`, `paymethod`, `enabled`, `role`, `logintime`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$sBiZ8m2XuwbBBA97owD3UOPY5e00raQd8LS6XYWxCO0cUcZepBfyi', 'admin', 'admin', 'aaa', 'Herr', 'Ringstraße 1', 1010, 'Wien', 'Vorkasse', 1, 'admin', '2023-06-19 11:19:22'),
(2, 'test', 'test@test.com', '$2y$10$ifQ7ViSkXFNWTT8Cv3EjYOmOOyxYAdNNkAzya0cexZfZzgzmOjLoG', 'test', 'test', 'sss', 'Frau', 'Hochstädtplatz 1', 1200, 'Wien', 'Kreditkarte', 1, 'user', '2023-06-16 20:23:23'),
(3, 'AM', 'alfred.milch@milch.at', '$2y$10$VHcrGoOwyI2O11j9.f7E8OxgiX5GqQCmdW8.JCdZwZUeR9HRkMweu', 'Alfred ', 'Milch', 'Milch GmbH', 'Firma', 'Milchstraße 23-23/23', 2230, 'Milchstadt', 'Vorkasse', 1, 'user', '2023-06-19 11:10:35'),
(4, 'MJF', 'ma@mas.at', '$2y$10$blBLz7lKfqrib2G5qQKmu.evdJei0Jz6.qM.tERb63KO3pXOUf6wu', 'Martin', 'Frischmann', 'Martin EU', 'Firma', 'asdf 34', 2222, 'Wien', 'Vorkasse', 1, 'user', '2023-06-19 11:23:01'),
(5, 'JE', 'josef.ei@gmail.com', '$2y$10$K8akaAR21N8R4dXPicu8PusIqmoO6U0pmbKZTOlO9TBKG1DJdjgEe', 'Josef', 'Ei', 'Landeier GmbH', 'Firma', 'Eierhof 23', 1111, 'Eierdorf', 'Kreditkarte', 1, 'user', '2023-06-15 12:23:46'),
(6, 'MF', 'ma@ma.at', '$2y$10$qffvnQVvxur2IYqI6r0sEuLlrPREzfc/MZedRkawGGEles/3GQrba', 'Martin', 'Frischmann', 'Martin EU', 'Firma', 'Ra 23', 2222, 'Wien', 'Kreditkarte', 1, 'user', '2023-06-15 13:11:05'),
(7, 'AR', 'anna.reiss@outlook.com', '$2y$10$G1.11Ih9yyA6v8YcaiL0QOkAKbL3Z6Rt1iuq1WkkGnwCbGKW1.J0.', 'Anna', 'Reis', '', 'Frau', 'Radgasse 23/2', 1220, 'Wien', 'Rechnung', 1, 'user', '2023-06-15 13:11:26'),
(8, 'JR', 'jasmin.ross@hallo.at', '$2y$10$AGlk0.fNdAiJBJrRTxxg/Oe1gtClqYwnfAzoKQcFDO.ub.FGvRuly', 'Jasmin', 'Roß', '', 'Divers', 'Roßgasse 22-23/2/1a', 1100, 'Wien', 'Vorkasse', 1, 'user', '2023-06-15 13:11:52');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` double(7,2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `fk_customerId` int(11) NOT NULL,
  `fk_couponId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `total`, `date`, `fk_customerId`, `fk_couponId`) VALUES
(2, 199.00, '2023-06-15', 1, NULL),
(3, 7083.47, '2023-06-15', 1, NULL),
(4, 8281.47, '2023-06-15', 1, NULL),
(5, 1235.48, '2023-06-16', 2, NULL),
(6, 23235.43, '2023-06-16', 1, NULL),
(7, 199.00, '2023-06-17', 1, NULL),
(8, 249.99, '2023-06-19', 4, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `rating` float(3,2) NOT NULL DEFAULT 5.00,
  `image` varchar(256) DEFAULT NULL,
  `gas` tinyint(1) NOT NULL,
  `charcoal` tinyint(1) NOT NULL,
  `pellet` tinyint(1) NOT NULL,
  `sale` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `rating`, `image`, `gas`, `charcoal`, `pellet`, `sale`) VALUES
(1, 'Orlando XXL', 'Erfüllen Sie sich jeden Wunsch beim Grillen mit dem Rost in Rost System des Grillwagens, das nahezu unbegrenzt erweitert werden kann. Auf diese Weise lassen sich leckere Wok-, Gemüse-, und Kartoffelgerichte zubereiten.', 249.99, 4.40, '../Frontend/res/img/products/Orlande XXL.jpg', 0, 1, 0, 1),
(2, 'Traeger Timberline XL', 'Entdecken Sie die Perfektion des Kochens im Freien mit dem brandneuen Traeger Timberline® Holzpelletgrill -- leistungsstark und extrem vielseitig.', 4399.99, 4.70, '../Frontend/res/img/products/Traeger Timberline XL.jpg', 0, 0, 1, 1),
(3, 'Rogue SE 525', 'Das limitierte Sondermodell, da bei uns exkl. in Österreich erhältlich ist, ist technisch komplett identisch mit dem Napoleon Rogue SE 525, sieht aber dank seines edlen, Mattschwarzen Designs aus wie ein Phantom. Und das zu einem phantastischen Preis!', 999, 4.50, '../Frontend/res/img/products/Rogue SE 525.jpg', 1, 0, 0, 1),
(4, 'Crown Pellet 500', 'Von low-and-slow Anbraten bis hin zu high-heat Braten – machen Sie sich bereit für erstaunliche Ergebnisse mit der Bequemlichkeit, der Technologie, der Leistung und dem Geschmack, den Sie mit der Broil King Pellet Grill Serie erhalten.', 1249, 4.90, '../Frontend/res/img/products/Crown Pellet 500.jpg', 0, 0, 1, 1),
(5, 'Freestyle 365', 'Die neueste Errungenschaft von Napoleon®, der Freestyle! Klein, fein, aber voller Power. Die rechte Seitenablage des Freestyle 365 SIB ist klappbar, so dass dieser Gasgrill extrem kompakt daherkommt. ', 679, 4.20, '../Frontend/res/img/products/Freestyle 365.jpg', 1, 0, 0, 1),
(6, 'Holzkohle Kugelgrill Ø 57cm', 'Napoleons Holzkohlegrill NK22CK-L mit geschraubten Beinen setzt alles auf die Komfort-Karte: Dank des drehbaren Deckels mit Eckscharnier kann der Grillmeister sicher über der Grillfläche hantieren. Ein großer Aschebehälter aus Stahl und der roboste Kohlerost sind nur weitere Annehmlichkeiten. Auf seinen großen, wetterbeständigen Rädern und mit seinen geschraubten Beinen lässt sich der Rodeo NK22CK-L einfach durchs Gelände ziehen. So ist er immer genau dort, wo Sie grillen wollen! Holzkohle Kugelgrill Ø 57cm', 199, 3.90, '../Frontend/res/img/products/Napoleon Holzkohle Kugelgrill 57cm.jpg', 0, 1, 0, 1),
(7, 'Moesta Sheriff 6', 'ein Wahnsinns-Griller', 999.99, 4.60, '../Frontend/res/img/products/Moesta Sheriff_6.jpg', 0, 0, 1, 1),
(8, 'Great Griller', 'Top-Gerät mit allem was das Herz begehrt!!!', 1235.48, 5.00, '../Frontend/res/img/products/6486e3b44fa3e_Griller Fun Pic.jpg', 0, 1, 0, 1),
(9, 'Royal Series 4-Brenner Gasgrill ', 'Robuste Verarbeitung durch massive Seitenwände von Deckel und Brennkammer aus Aluminiumdruckguss, sowie einem Unterschrank aus hochwertigem Edelstahl.\r\nDrei Schubladen mit extra-weitem Auszug.\r\nBBQ-Equipment und Zubehör finden in 3 geräumigen Edelstahl-Schubladen mit extra-weitem Auszug Platz – für mehr Ordnung am Grill.\r\nEARLs emaillierte Gusseisenroste sorgen für fette Grillstreifen und beste Hitzeverteilung in der Grillkammer.', 1499.23, 4.80, '../Frontend/res/img/products/648b11b13d6a2_Royal Series 4-Brenner Gasgrill.jpg', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products_orders`
--

CREATE TABLE `products_orders` (
  `fk_orderId` int(11) NOT NULL,
  `fk_productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `products_orders`
--

INSERT INTO `products_orders` (`fk_orderId`, `fk_productId`, `quantity`) VALUES
(2, 6, 1),
(3, 6, 1),
(3, 8, 1),
(3, 2, 1),
(3, 4, 1),
(4, 8, 1),
(4, 6, 2),
(4, 4, 1),
(4, 2, 1),
(4, 3, 1),
(5, 8, 1),
(6, 2, 5),
(6, 8, 1),
(7, 6, 1),
(8, 1, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_couponId` (`fk_couponId`),
  ADD KEY `fk_customerId` (`fk_customerId`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products_orders`
--
ALTER TABLE `products_orders`
  ADD KEY `fk_orderId` (`fk_orderId`),
  ADD KEY `fk_productId` (`fk_productId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customerId` FOREIGN KEY (`fk_customerId`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
