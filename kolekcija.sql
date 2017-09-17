-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2015 at 08:22 
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kolekcija`
--

-- --------------------------------------------------------

--
-- Table structure for table `filmovi`
--

CREATE TABLE IF NOT EXISTS `filmovi` (
`id` int(10) unsigned NOT NULL,
  `naslov` varchar(255) COLLATE cp1250_croatian_ci NOT NULL,
  `id_zanr` int(10) unsigned DEFAULT NULL,
  `godina` int(10) unsigned NOT NULL,
  `trajanje` int(10) unsigned NOT NULL,
  `slika` varchar(255) COLLATE cp1250_croatian_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=cp1250 COLLATE=cp1250_croatian_ci;

--
-- Dumping data for table `filmovi`
--

INSERT INTO `filmovi` (`id`, `naslov`, `id_zanr`, `godina`, `trajanje`, `slika`) VALUES
(1, 'Antitrust', 11, 2001, 109, 'antitrust_2001.jpg'),
(2, 'Firewall', 11, 2006, 100, 'firewall_2006.jpg'),
(3, 'Tron', 12, 1982, 95, 'tron_1982.jpg'),
(4, 'Tron: Legacy', 12, 2010, 127, 'tron_legacy_2010.jpg'),
(18, 'Hackers', 11, 1995, 107, 'hackers_1995.jpg'),
(19, 'Operation Swordfish', 11, 2001, 99, 'operation_swordfish_2001.jpg'),
(20, 'Operation Takedown', 1, 2000, 92, 'operation_takedown_2000.jpg'),
(22, 'The Social Network', 9, 2010, 120, 'the_social_network_2010.jpg'),
(24, 'Pirates of Silicone Valley', 9, 2010, 95, 'pirates_of_silicone_valley_1999.jpg'),
(25, 'WarGames', 12, 1983, 114, 'war_games_1983.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE IF NOT EXISTS `zanr` (
`id` int(10) unsigned NOT NULL,
  `naziv` varchar(255) COLLATE cp1250_croatian_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=cp1250 COLLATE=cp1250_croatian_ci;

--
-- Dumping data for table `zanr`
--

INSERT INTO `zanr` (`id`, `naziv`) VALUES
(2, 'Animirani film'),
(10, 'Avanturistički film'),
(1, 'Biografski film'),
(15, 'Dokumentarni film'),
(9, 'Drama'),
(14, 'Dugometražni film'),
(16, 'Eksperimentalni film'),
(13, 'Horor'),
(18, 'Jednominutni film'),
(4, 'Komedija'),
(17, 'Kratkometražni film'),
(5, 'Kriminalistički'),
(7, 'Ljubavni film'),
(8, 'Mjuzikl'),
(3, 'Povijesni film'),
(11, 'Triler'),
(6, 'Vestern'),
(12, 'Znanstvenofantastični');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filmovi`
--
ALTER TABLE `filmovi`
 ADD PRIMARY KEY (`id`), ADD KEY `id_zanr` (`id_zanr`);

--
-- Indexes for table `zanr`
--
ALTER TABLE `zanr`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `naziv` (`naziv`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filmovi`
--
ALTER TABLE `filmovi`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `zanr`
--
ALTER TABLE `zanr`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `filmovi`
--
ALTER TABLE `filmovi`
ADD CONSTRAINT `filmovi_ibfk_1` FOREIGN KEY (`id_zanr`) REFERENCES `zanr` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
