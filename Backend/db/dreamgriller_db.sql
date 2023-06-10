-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Jun 2023 um 18:27
-- Server-Version: 10.4.24-MariaDB
-- PHP-Version: 8.1.6

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

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `amount` double NOT NULL DEFAULT 10,
  `expirydate` date NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- TRUNCATE Tabelle vor dem Einfügen `coupons`
--

TRUNCATE TABLE `coupons`;
--
-- Daten für Tabelle `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `amount`, `expirydate`, `expired`) VALUES
(1, 'testcode123', 10, '2023-06-30', 0),
(2, '123456', 50, '2023-06-27', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `adress` varchar(256) NOT NULL,
  `postcode` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT 1,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- TRUNCATE Tabelle vor dem Einfügen `customers`
--

TRUNCATE TABLE `customers`;
--
-- Daten für Tabelle `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `gender`, `adress`, `postcode`, `city`, `enabled`, `role`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$o66aklQJ8bmX7kMeWJatR./KQxFCbdvloZb4DXtP.wwnG6bpk2ahW', 'admin', 'admin', 'female', 'Ringstraße 1', 1010, 'Wien', 1, 'admin'),
(2, 'test', 'test@test.com', '$2y$10$tRfDxbaJFHyX5cSQfzQRYuV3EVqhP4/QeJsthKul47HNnTG11HcWO', 'test', 'test', 'female', 'Hochstädtplatz 1', 1200, 'Wien', 1, 'user');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` double(7,2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `fk_customerId` int(11) NOT NULL,
  `fk_couponId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- TRUNCATE Tabelle vor dem Einfügen `orders`
--

TRUNCATE TABLE `orders`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

DROP TABLE IF EXISTS `products`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- TRUNCATE Tabelle vor dem Einfügen `products`
--

TRUNCATE TABLE `products`;
--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `rating`, `image`, `gas`, `charcoal`, `pellet`, `sale`) VALUES
(1, 'Orlando XXL', 'Erfüllen Sie sich jeden Wunsch beim Grillen mit dem Rost in Rost System des Grillwagens, das nahezu unbegrenzt erweitert werden kann. Auf diese Weise lassen sich leckere Wok-, Gemüse-, und Kartoffelgerichte zubereiten.', 249.99, 4.48, NULL, 0, 1, 0, 0),
(2, 'Traeger Timberline XL', 'Entdecken Sie die Perfektion des Kochens im Freien mit dem brandneuen Traeger Timberline® Holzpelletgrill -- leistungsstark und extrem vielseitig.', 4399.99, 5.00, NULL, 0, 0, 1, 0),
(3, 'Rogue SE 525', 'Das limitierte Sondermodell, da bei uns exkl. in Österreich erhältlich ist, ist technisch komplett identisch mit dem Napoleon Rogue SE 525, sieht aber dank seines edlen, Mattschwarzen Designs aus wie ein Phantom. Und das zu einem phantastischen Preis!', 999, 4.50, NULL, 1, 0, 0, 1),
(4, 'Crown Pellet 500', 'Von low-and-slow Anbraten bis hin zu high-heat Braten – machen Sie sich bereit für erstaunliche Ergebnisse mit der Bequemlichkeit, der Technologie, der Leistung und dem Geschmack, den Sie mit der Broil King Pellet Grill Serie erhalten.', 1249, 5.00, NULL, 0, 0, 1, 0),
(5, 'Freestyle 365', 'Die neueste Errungenschaft von Napoleon®, der Freestyle! Klein, fein, aber voller Power. Die rechte Seitenablage des Freestyle 365 SIB ist klappbar, so dass dieser Gasgrill extrem kompakt daherkommt. ', 679, 5.00, NULL, 1, 0, 0, 0),
(6, 'Holzkohle Kugelgrill Ø 57cm', 'Napoleons Holzkohlegrill NK22CK-L mit geschraubten Beinen setzt alles auf die Komfort-Karte: Dank des drehbaren Deckels mit Eckscharnier kann der Grillmeister sicher über der Grillfläche hantieren. Ein großer Aschebehälter aus Stahl und der roboste Kohlerost sind nur weitere Annehmlichkeiten. Auf seinen großen, wetterbeständigen Rädern und mit seinen geschraubten Beinen lässt sich der Rodeo NK22CK-L einfach durchs Gelände ziehen. So ist er immer genau dort, wo Sie grillen wollen! Holzkohle Kugelgrill Ø 57cm', 199, 5.00, NULL, 0, 1, 0, 1),
(8, 'Test Griller', 'Der beste Griller der Welt', 9.99, 5.00, NULL, 1, 1, 1, 0),
(20, 'Griller with image', '', 0, 0.00, NULL, 0, 0, 0, 0),
(30, 'Griller mit Bild', 'Wow dieser Griller hat sogar ein Bild!', 949.99, 4.50, '../Frontend/res/img/products/6481f8b978031_products-image(1).jpg', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products_orders`
--

DROP TABLE IF EXISTS `products_orders`;
CREATE TABLE `products_orders` (
  `fk_orderId` int(11) NOT NULL,
  `fk_productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- TRUNCATE Tabelle vor dem Einfügen `products_orders`
--

TRUNCATE TABLE `products_orders`;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
