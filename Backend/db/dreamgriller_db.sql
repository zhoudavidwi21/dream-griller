-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Jun 2023 um 08:05
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
(1, 'admin', 'admin@admin.com', '$2y$10$sBiZ8m2XuwbBBA97owD3UOPY5e00raQd8LS6XYWxCO0cUcZepBfyi', 'admin', 'admin', 'aaa', 'Herr', 'Ringstraße 1', 1010, 'Wien', 'Vorkasse', 1, 'admin', '2023-06-14 02:19:50'),
(2, 'test', 'test@test.com', '$2y$10$ifQ7ViSkXFNWTT8Cv3EjYOmOOyxYAdNNkAzya0cexZfZzgzmOjLoG', 'test', 'test', 'sss', 'Frau', 'Hochstädtplatz 1', 1200, 'Wien', 'Kreditkarte', 1, 'user', '2023-06-14 00:43:13'),
(3, 'as', 'ma@ma.ar', '$2y$10$R4S9OpNT4S7mjWtwpebvpOLhz..X/my84jOw.U5Q6WuPz/smFtY9y', 'ASD', 'a', 'sfa', 'Herr', 'asd', 2, 'Wien', 'Vorkasse', 1, 'user', '2023-06-12 11:07:33'),
(4, 'asadfsdfsd', 'a@a.wein', '$2y$10$EY3VQbBf27U1LKlVOmFkc.49klt.ZYaTcS7xna.rER35qNq9XWhiK', 'asdf', 'asdf', 'asdf', 'Herr', 'asdf', 222, 'asdf', 'Kreditkarte', 1, 'user', '2023-06-14 00:41:55'),
(22, 'MF', 'ma@ma.at', '$2y$10$qffvnQVvxur2IYqI6r0sEuLlrPREzfc/MZedRkawGGEles/3GQrba', 'Martin', 'Frischmann', 'Martin EU', 'Firma', 'Ra 23', 2222, 'Wien', 'Kreditkarte', 1, 'user', '2023-06-12 17:11:21'),
(24, 'sd', 'a@a.asdfsdf', '$2y$10$2c3/NnKH0Jle1mlDCv4.tunDzemwrOQ8dUaceufJpQDoPAI4svCta', 'Martin', 'Frischmann', 'Martin EU', 'Firma', 'asdf 34', 2222, 'Wien', 'Rechnung', 1, 'user', '2023-06-12 10:04:47'),
(25, 'MJF', 'ma@master.at', '$2y$10$nNlRYNMoc2Ur5eQ9bA7Z.uhNDlmO6hNOSYJ8e2zjwxDkJ3qho13.m', 'Martin', 'Frischmann', 'Martin EU', 'Firma', 'asdf 34', 2222, 'Wien', 'Vorkasse', 1, 'user', '2023-06-11 19:34:00');

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
(1, 234.00, '2023-06-11', 25, NULL);

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
(1, 'Orlando XXL', 'Erfüllen Sie sich jeden Wunsch beim Grillen mit dem Rost in Rost System des Grillwagens, das nahezu unbegrenzt erweitert werden kann. Auf diese Weise lassen sich leckere Wok-, Gemüse-, und Kartoffelgerichte zubereiten.', 249.99, 4.48, '../Frontend/res/img/products/Orlande XXL.jpg', 0, 1, 0, 0),
(2, 'Traeger Timberline XL', 'Entdecken Sie die Perfektion des Kochens im Freien mit dem brandneuen Traeger Timberline® Holzpelletgrill -- leistungsstark und extrem vielseitig.', 4399.99, 4.78, '../Frontend/res/img/products/Traeger Timberline XL.jpg', 0, 0, 1, 0),
(3, 'Rogue SE 525', 'Das limitierte Sondermodell, da bei uns exkl. in Österreich erhältlich ist, ist technisch komplett identisch mit dem Napoleon Rogue SE 525, sieht aber dank seines edlen, Mattschwarzen Designs aus wie ein Phantom. Und das zu einem phantastischen Preis!', 999, 4.50, '../Frontend/res/img/products/Rogue SE 525.jpg', 1, 0, 0, 1),
(4, 'Crown Pellet 500', 'Von low-and-slow Anbraten bis hin zu high-heat Braten – machen Sie sich bereit für erstaunliche Ergebnisse mit der Bequemlichkeit, der Technologie, der Leistung und dem Geschmack, den Sie mit der Broil King Pellet Grill Serie erhalten.', 1249, 4.90, '../Frontend/res/img/products/Crown Pellet 500.jpg', 0, 0, 1, 0),
(5, 'Freestyle 365', 'Die neueste Errungenschaft von Napoleon®, der Freestyle! Klein, fein, aber voller Power. Die rechte Seitenablage des Freestyle 365 SIB ist klappbar, so dass dieser Gasgrill extrem kompakt daherkommt. ', 679, 4.25, '../Frontend/res/img/products/Freestyle 365.jpg', 1, 0, 0, 0),
(6, 'Holzkohle Kugelgrill Ø 57cm', 'Napoleons Holzkohlegrill NK22CK-L mit geschraubten Beinen setzt alles auf die Komfort-Karte: Dank des drehbaren Deckels mit Eckscharnier kann der Grillmeister sicher über der Grillfläche hantieren. Ein großer Aschebehälter aus Stahl und der roboste Kohlerost sind nur weitere Annehmlichkeiten. Auf seinen großen, wetterbeständigen Rädern und mit seinen geschraubten Beinen lässt sich der Rodeo NK22CK-L einfach durchs Gelände ziehen. So ist er immer genau dort, wo Sie grillen wollen! Holzkohle Kugelgrill Ø 57cm', 199, 3.90, '../Frontend/res/img/products/Napoleon Holzkohle Kugelgrill 57cm.jpg', 0, 1, 0, 1),
(7, 'Moesta Sheriff 6', 'ein Wahnsinns-Griller', 999.99, 4.68, '../Frontend/res/img/products/Moesta Sheriff_6.jpg', 0, 0, 1, 0),
(8, 'Great Griller', 'Top-Gerät mit allem was das Herz begehrt!!!', 1235.48, 5.00, '../Frontend/res/img/products/6486e3b44fa3e_Griller Fun Pic.jpg', 0, 1, 0, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
