-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Jeu 05 Mars 2015 à 08:07
-- Version du serveur :  5.5.38
-- Version de PHP :  5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `M152_Fontaines`
--

-- --------------------------------------------------------

--
-- Structure de la table `fontaines`
--

CREATE TABLE `fontaines` (
`id_fontaine` int(4) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(4) NOT NULL,
  `photo` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `fontaines`
--

INSERT INTO `fontaines` (`id_fontaine`, `lat`, `lng`, `active`, `id_user`, `photo`) VALUES
(2, '46.1902742', '6.1649', 1, 1, 0),
(3, '46.2002742', '6.14648409', 1, 1, 0),
(7, '46.197485', '6.134175', 1, 1, 0),
(8, '46.215602', '6.147436', 1, 1, 0),
(9, '46.179479', '6.138764', 1, 1, 0),
(10, '46.251425', '6.202463', 1, 1, 0),
(11, '46.2085045', '6.16473689', 1, 1, 0),
(12, '46.1946741', '6.14961862', 1, 1, 0),
(15, '46.2074256', '6.15594863', 1, 4, 0),
(16, '46.2074256', '6.15594863', 1, 4, 1),
(17, '46.1898061', '6.14176511', 1, 4, 1),
(18, '46.1900316', '6.14412009', 1, 4, 1),
(19, '46.1894014', '6.14490866', 1, 4, 1),
(20, '46.2074282', '6.15594863', 1, 4, 0),
(21, '46.1902742', '6.14648409', 1, 4, 1),
(22, '46.1886031', '6.14567577', 1, 4, 1),
(23, '46.1934925', '6.13986074', 1, 4, 1),
(24, '46.1908830', '6.14899635', 0, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id_user` int(4) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `rayon` int(100) NOT NULL DEFAULT '500',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `mdp`, `rayon`, `admin`, `deleted`) VALUES
(1, 'Robin', '123', 1500, 1, 0),
(2, 'u1', '123', 500, 0, 1),
(3, 'u2', '123', 500, 0, 1),
(4, 'Antonio', 'secret', 500, 1, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `fontaines`
--
ALTER TABLE `fontaines`
 ADD PRIMARY KEY (`id_fontaine`), ADD KEY `id_user` (`id_user`), ADD KEY `id_user_2` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `fontaines`
--
ALTER TABLE `fontaines`
MODIFY `id_fontaine` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fontaines`
--
ALTER TABLE `fontaines`
ADD CONSTRAINT `fontaines_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
