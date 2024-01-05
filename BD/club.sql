-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 jan. 2024 à 17:37
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `club`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `code`, `nom`) VALUES
(1, 'M12', 'Moins de 12 ans');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `prenom`, `email`, `tel`) VALUES
(1, 'c', 'c', 'c@c', '0111111111'),
(2, 'd', 'd', 'd@d', '0111111111');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240105171423', '2024-01-05 17:14:30', 1503);

-- --------------------------------------------------------

--
-- Structure de la table `educateur`
--

DROP TABLE IF EXISTS `educateur`;
CREATE TABLE IF NOT EXISTS `educateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `licencie_id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_763C0122E7927C74` (`email`),
  UNIQUE KEY `UNIQ_763C0122B56DCD74` (`licencie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `educateur`
--

INSERT INTO `educateur` (`id`, `licencie_id`, `email`, `roles`, `password`) VALUES
(1, 1, 'l@l', '{\"0\": \"ROLE_ADMIN\"}', '$2y$10$i5W1iJcO.UgR9jvA8KW.c.A1UgNVwxTcLKF0nPPfD9ki.T/ChK/12');

-- --------------------------------------------------------

--
-- Structure de la table `licencie`
--

DROP TABLE IF EXISTS `licencie`;
CREATE TABLE IF NOT EXISTS `licencie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `contact_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3B755612BCF5E72D` (`categorie_id`),
  KEY `IDX_3B755612E7A1254A` (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `licencie`
--

INSERT INTO `licencie` (`id`, `categorie_id`, `contact_id`, `nom`, `prenom`) VALUES
(1, 1, 2, 'l', 'l'),
(2, 1, 2, 't', 't');

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact`
--

DROP TABLE IF EXISTS `mail_contact`;
CREATE TABLE IF NOT EXISTS `mail_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `educateur_id` int NOT NULL,
  `date_envoi` datetime NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_96DF67576BFC1A0E` (`educateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_contact`
--

INSERT INTO `mail_contact` (`id`, `educateur_id`, `date_envoi`, `objet`, `message`) VALUES
(1, 1, '2024-01-05 18:24:14', 'cc', 'cc');

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact_categorie`
--

DROP TABLE IF EXISTS `mail_contact_categorie`;
CREATE TABLE IF NOT EXISTS `mail_contact_categorie` (
  `mail_contact_id` int NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`mail_contact_id`,`categorie_id`),
  KEY `IDX_340E21C33362CFB6` (`mail_contact_id`),
  KEY `IDX_340E21C3BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_contact_categorie`
--

INSERT INTO `mail_contact_categorie` (`mail_contact_id`, `categorie_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact_contact`
--

DROP TABLE IF EXISTS `mail_contact_contact`;
CREATE TABLE IF NOT EXISTS `mail_contact_contact` (
  `mail_contact_id` int NOT NULL,
  `contact_id` int NOT NULL,
  PRIMARY KEY (`mail_contact_id`,`contact_id`),
  KEY `IDX_94F6F3BB3362CFB6` (`mail_contact_id`),
  KEY `IDX_94F6F3BBE7A1254A` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_contact_contact`
--

INSERT INTO `mail_contact_contact` (`mail_contact_id`, `contact_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mail_edu`
--

DROP TABLE IF EXISTS `mail_edu`;
CREATE TABLE IF NOT EXISTS `mail_edu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `educateur_id` int NOT NULL,
  `date_envoi` datetime NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8CB8D4A36BFC1A0E` (`educateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mail_edu_educateur`
--

DROP TABLE IF EXISTS `mail_edu_educateur`;
CREATE TABLE IF NOT EXISTS `mail_edu_educateur` (
  `mail_edu_id` int NOT NULL,
  `educateur_id` int NOT NULL,
  PRIMARY KEY (`mail_edu_id`,`educateur_id`),
  KEY `IDX_7A814C4C9D911D20` (`mail_edu_id`),
  KEY `IDX_7A814C4C6BFC1A0E` (`educateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `educateur`
--
ALTER TABLE `educateur`
  ADD CONSTRAINT `FK_763C0122B56DCD74` FOREIGN KEY (`licencie_id`) REFERENCES `licencie` (`id`);

--
-- Contraintes pour la table `licencie`
--
ALTER TABLE `licencie`
  ADD CONSTRAINT `FK_3B755612BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `FK_3B755612E7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`);

--
-- Contraintes pour la table `mail_contact`
--
ALTER TABLE `mail_contact`
  ADD CONSTRAINT `FK_96DF67576BFC1A0E` FOREIGN KEY (`educateur_id`) REFERENCES `educateur` (`id`);

--
-- Contraintes pour la table `mail_contact_categorie`
--
ALTER TABLE `mail_contact_categorie`
  ADD CONSTRAINT `FK_340E21C33362CFB6` FOREIGN KEY (`mail_contact_id`) REFERENCES `mail_contact` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_340E21C3BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mail_contact_contact`
--
ALTER TABLE `mail_contact_contact`
  ADD CONSTRAINT `FK_94F6F3BB3362CFB6` FOREIGN KEY (`mail_contact_id`) REFERENCES `mail_contact` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_94F6F3BBE7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mail_edu`
--
ALTER TABLE `mail_edu`
  ADD CONSTRAINT `FK_8CB8D4A36BFC1A0E` FOREIGN KEY (`educateur_id`) REFERENCES `educateur` (`id`);

--
-- Contraintes pour la table `mail_edu_educateur`
--
ALTER TABLE `mail_edu_educateur`
  ADD CONSTRAINT `FK_7A814C4C6BFC1A0E` FOREIGN KEY (`educateur_id`) REFERENCES `educateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7A814C4C9D911D20` FOREIGN KEY (`mail_edu_id`) REFERENCES `mail_edu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
