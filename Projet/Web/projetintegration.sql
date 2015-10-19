-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 29 Septembre 2015 à 12:03
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `projetintegration`
--

-- --------------------------------------------------------

--
-- Structure de la table `activation`
--

CREATE TABLE IF NOT EXISTS `activation` (
  `id_user` int(11) NOT NULL,
  `code` char(6) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_user`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` longtext NOT NULL,
  `Signalee` tinyint(1) NOT NULL DEFAULT '0',
  `ByGroup` tinyint(1) NOT NULL DEFAULT '0',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

CREATE TABLE IF NOT EXISTS `amis` (
  `id_user_1` int(11) NOT NULL,
  `id_user_2` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_user_1`,`id_user_2`),
  KEY `id_user_2` (`id_user_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_activity`
--

CREATE TABLE IF NOT EXISTS `categorie_activity` (
  `id_categorie` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_categorie`,`id_activity`),
  KEY `id_activity` (`id_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE IF NOT EXISTS `droit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_source` int(11) NOT NULL,
  `id_user_dest` int(11) NOT NULL,
  `id_message_parent` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_source` (`id_user_source`),
  KEY `id_user_dest` (`id_user_dest`),
  KEY `id_message_parent` (`id_message_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` longtext NOT NULL,
  `Mdp` longtext NOT NULL,
  `DateInscription` datetime NOT NULL,
  `DateLastIdea` datetime DEFAULT NULL,
  `DateLastConnect` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id_User` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `ByGroup` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_User`,`id_activity`),
  KEY `id_activity` (`id_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user_droit`
--

CREATE TABLE IF NOT EXISTS `user_droit` (
  `id_Droits` int(11) NOT NULL,
  `id_User` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`id_Droits`,`id_User`),
  KEY `id_User` (`id_User`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `activation`
--
ALTER TABLE `activation`
  ADD CONSTRAINT `activation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`id_user_2`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`id_user_1`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `categorie_activity`
--
ALTER TABLE `categorie_activity`
  ADD CONSTRAINT `categorie_activity_ibfk_2` FOREIGN KEY (`id_activity`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `categorie_activity_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`id_message_parent`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_user_source`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user_dest`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_2` FOREIGN KEY (`id_activity`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_droit`
--
ALTER TABLE `user_droit`
  ADD CONSTRAINT `user_droit_ibfk_2` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_droit_ibfk_1` FOREIGN KEY (`id_Droits`) REFERENCES `droit` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
