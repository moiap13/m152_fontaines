-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 19 Février 2015 à 08:21
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `m152_fontaines`
--

-- --------------------------------------------------------

--
-- Structure de la table `fontaines`
--

CREATE TABLE IF NOT EXISTS `fontaines` (
  `id_fontaine` int(4) NOT NULL AUTO_INCREMENT,
  `lat` varchar(10) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(4) NOT NULL,
  PRIMARY KEY (`id_fontaine`),
  KEY `id_user` (`id_user`),
  KEY `id_user_2` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `fontaines`
--

INSERT INTO `fontaines` (`id_fontaine`, `lat`, `lng`, `active`, `id_user`) VALUES
(2, '46.1902742', '6.1649', 1, 1),
(3, '46.2002742', '6.14648409', 1, 1),
(7, '46.197485', '6.134175', 1, 1),
(8, '46.215602', '6.147436', 1, 1),
(9, '46.179479', '6.138764', 1, 1),
(10, '46.251425', '6.202463', 1, 1),
(11, '46.2085045', '6.16473689', 1, 1),
(12, '46.1946741', '6.14961862', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(4) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `rayon` int(100) NOT NULL DEFAULT '500',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `mdp`, `rayon`, `admin`, `deleted`) VALUES
(1, 'Robin', '123', 1500, 1, 0),
(2, 'u1', '123', 500, 0, 1),
(3, 'u2', '123', 500, 0, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fontaines`
--
ALTER TABLE `fontaines`
  ADD CONSTRAINT `fontaines_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
