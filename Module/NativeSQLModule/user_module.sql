--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `isCompany` bit(1) NOT NULL DEFAULT b'0',
  `companyName` varchar(255) DEFAULT NULL,
  `companySiret` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'0',
  `isAdmin` bit(1) NOT NULL DEFAULT b'0',
  `fromCompany` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

