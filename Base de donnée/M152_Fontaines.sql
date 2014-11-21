-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Ven 21 Novembre 2014 à 12:55
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
  `id_user` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id_user` int(4) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
MODIFY `id_fontaine` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fontaines`
--
ALTER TABLE `fontaines`
ADD CONSTRAINT `fontaines_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
