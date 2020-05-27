--
-- Structure de la table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_User` tinyint(5) DEFAULT NULL,
  `isCompany` bit(1) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companySiret` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `fromCompany` varchar(255) NOT NULL,
  `creationDate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `requestcart`;
CREATE TABLE IF NOT EXISTS `requestcart` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_Request` int(5) NOT NULL,
  `id_Product` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_requestcart_request` (`id_Request`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Contraintes pour la table `requestcart`
--
ALTER TABLE `requestcart`
  ADD CONSTRAINT `FK_requestcart_request` FOREIGN KEY (`id_Request`) REFERENCES `request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
