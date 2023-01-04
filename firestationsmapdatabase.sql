-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8080
-- Generation Time: Jan 04, 2023 at 09:22 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `firestationsmapdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `ID` int(11) NOT NULL COMMENT 'Identifiant de l''adresse',
  `USERID` int(11) NOT NULL COMMENT 'Identifiant du propriétaire de l''adresse',
  `ADDRESS` text NOT NULL COMMENT 'Libellé de l''adresse',
  `CITY` varchar(100) NOT NULL COMMENT 'Ville de l''adresse',
  `POSTALCODE` int(11) NOT NULL COMMENT 'Code postal de l''adresse',
  `ISMAIN` tinyint(1) NOT NULL COMMENT 'Identificateur de l''adresse principale de l''utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`ID`, `USERID`, `ADDRESS`, `CITY`, `POSTALCODE`, `ISMAIN`) VALUES
(25, 23, '5 Rue de la paix', 'Paris', 75002, 1),
(26, 23, '143 Avenue de Versailles', 'Paris', 75016, 0),
(27, 24, '3 rue de la paix', 'Paris', 75012, 1),
(28, 23, '11 avenue de friedland', 'Paris', 75008, 0);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `ID` int(11) NOT NULL COMMENT 'Identifiant du favoris dans la table',
  `USERID` int(11) NOT NULL COMMENT 'Identifiant de l''utilisateur auquel appartient le favoris',
  `SECTOR` varchar(100) NOT NULL COMMENT 'Secteur de la caserne favorite'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`ID`, `USERID`, `SECTOR`) VALUES
(152, 23, 'MALAR'),
(154, 23, 'SEVIGNE'),
(155, 23, 'AUTEUIL'),
(156, 23, 'DAUPHINE'),
(157, 23, 'BOURSAULT'),
(158, 23, 'PORT ROYAL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL COMMENT 'Identifiant de l''utilisateur',
  `USERNAME` varchar(100) NOT NULL COMMENT 'Pseudonyme de l''utilisateur',
  `LASTNAME` varchar(100) NOT NULL COMMENT 'Nom de famille de l''utilisateur',
  `FIRSTNAME` varchar(100) NOT NULL COMMENT 'Prénom de l''utilisateur',
  `PASSWORD` varchar(100) NOT NULL COMMENT 'Mot de passe crypté de l''utilisateur',
  `MAIL` varchar(100) NOT NULL COMMENT 'Adresse électronique de l''utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table contenant les utilisateurs inscris';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `LASTNAME`, `FIRSTNAME`, `PASSWORD`, `MAIL`) VALUES
(23, 'Zakiryo', 'Rudny', 'Yohan', '$2y$10$5NAwVGvZbuzOqgIKXhXg9eaculo5zzC.Ct8JKKMBgOaiHg0Gp67Ym', 'contactzakiryo@gmail.com'),
(24, 'Test2', 'TestNom', 'TestPrenom', '$2y$10$MtfeKdIZwx2SeSzSxhiClOAku9FkgAfYNdjVMTu1dP62UsM3hhmV6', 'test.test@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_USERID` (`USERID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_USERFAVID` (`USERID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l''adresse', AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du favoris dans la table', AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l''utilisateur', AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_USERID` FOREIGN KEY (`USERID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK_USERFAVID` FOREIGN KEY (`USERID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
