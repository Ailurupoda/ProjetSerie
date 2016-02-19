-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 19 Février 2016 à 13:22
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `nextwatch`
--

-- --------------------------------------------------------

--
-- Structure de la table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `idWord` int(10) NOT NULL AUTO_INCREMENT,
  `word` varchar(16) NOT NULL,
  `nbOcc` int(10) NOT NULL,
  PRIMARY KEY (`idWord`),
  UNIQUE KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `keywords`
--

TRUNCATE TABLE `keywords`;
-- --------------------------------------------------------

--
-- Structure de la table `liked`
--

DROP TABLE IF EXISTS `liked`;
CREATE TABLE IF NOT EXISTS `liked` (
  `idUser` int(3) NOT NULL DEFAULT '0',
  `idSerie` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`,`idSerie`),
  KEY `idSerie` (`idSerie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `liked`
--

TRUNCATE TABLE `liked`;
-- --------------------------------------------------------

--
-- Structure de la table `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE IF NOT EXISTS `series` (
  `idSerie` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `picture` text NOT NULL,
  PRIMARY KEY (`idSerie`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `series`
--

TRUNCATE TABLE `series`;
-- --------------------------------------------------------

--
-- Structure de la table `serieskeywords`
--

DROP TABLE IF EXISTS `serieskeywords`;
CREATE TABLE IF NOT EXISTS `serieskeywords` (
  `idWord` int(10) NOT NULL,
  `idSerie` int(4) NOT NULL,
  `nbOcc` int(10) NOT NULL,
  PRIMARY KEY (`idWord`,`idSerie`),
  KEY `idSerie_cpp` (`idSerie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `serieskeywords`
--

TRUNCATE TABLE `serieskeywords`;
-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(3) NOT NULL AUTO_INCREMENT,
  `password` varchar(10) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `users`
--

TRUNCATE TABLE `users`;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `liked`
--
ALTER TABLE `liked`
  ADD CONSTRAINT `liked_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `series` (`idSerie`),
  ADD CONSTRAINT `liked_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `serieskeywords`
--
ALTER TABLE `serieskeywords`
  ADD CONSTRAINT `idSerie_cpp` FOREIGN KEY (`idSerie`) REFERENCES `series` (`idSerie`),
  ADD CONSTRAINT `idWord_cpp` FOREIGN KEY (`idWord`) REFERENCES `keywords` (`idWord`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
