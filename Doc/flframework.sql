-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 19 Janvier 2014 à 22:01
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `flframework`
--

-- --------------------------------------------------------

--
-- Structure de la table `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
	`id` tinyint(5) NOT NULL AUTO_INCREMENT,
	`code` varchar(2) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `lang`
--

INSERT INTO `lang` (`id`, `code`) VALUES
(1, 'fr'),
(2, 'en');

-- --------------------------------------------------------

--
-- Structure de la table `rewrittingurl`
--

CREATE TABLE IF NOT EXISTS `rewrittingurl` (
	`id` tinyint(5) NOT NULL AUTO_INCREMENT,
	`idRouteUrl` tinyint(5) NOT NULL,
	`urlMatched` varchar(255) NOT NULL,
	`lang` varchar(2) NOT NULL DEFAULT 'fr',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `rewrittingurl`
--

INSERT INTO `rewrittingurl` (`id`, `idRouteUrl`, `urlMatched`, `lang`) VALUES
(1, 1, '/accueil.html', 'fr'),
(2, 1, '/en/home.html', 'en'),
(3, 2, '/404.html', 'fr'),
(4, 2, '/en/404.html', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `routeurl`
--

CREATE TABLE IF NOT EXISTS `routeurl` (
	`id` tinyint(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '',
	`controller` varchar(100) NOT NULL DEFAULT '',
	`action` varchar(100) NOT NULL DEFAULT '',
	`order` tinyint(2) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `routeurl`
--

INSERT INTO `routeurl` (`id`, `name`, `controller`, `action`, `order`) VALUES
(1, 'home', 'home', 'index', 0),
(2, 'error404', 'home', 'error404', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
