-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 juil. 2023 à 11:50
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sortir_com_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location_id` int NOT NULL,
  `state_id` int NOT NULL,
  `site_id` int NOT NULL,
  `organiser_id` int NOT NULL,
  `activity_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `duration` int DEFAULT NULL,
  `closing_date` datetime NOT NULL,
  `max_registration` int NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `picture_url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_AC74095A64D218E` (`location_id`),
  KEY `IDX_AC74095A5D83CC1` (`state_id`),
  KEY `IDX_AC74095AF6BD1646` (`site_id`),
  KEY `IDX_AC74095AA0631C12` (`organiser_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity`
--

INSERT INTO `activity` (`id`, `location_id`, `state_id`, `site_id`, `organiser_id`, `activity_name`, `start_date`, `duration`, `closing_date`, `max_registration`, `description`, `picture_url`, `cancellation_reason`) VALUES
(49, 4, 3, 1, 1, 'Baignade à Fouesnant', '2023-07-07 18:00:00', 120, '2023-07-07 00:00:00', 15, 'Baignade de fin de projet : il faut chaud et on veut se détendre. Pensez aux serviettes, maillots de bain et gâteaux apéro.', NULL, NULL),
(50, 5, 1, 1, 1, 'Initiation au tir à l\'arc', '2023-07-22 14:00:00', 180, '2023-07-17 00:00:00', 10, 'Initiation au tir en extérieur avec le club des Archers de l\'Odet. Prévoir habits pour être dehors, vêtements proches du corps en haut (pour éviter de prendre des flèches dans les manches).', NULL, NULL),
(51, 4, 1, 1, 3, 'Plage !', '2023-07-28 14:00:00', 180, '2023-07-25 00:00:00', 4, 'Je peux conduire !', NULL, NULL),
(52, 3, 1, 1, 2, 'Jeux vidéo chez Maï', '2023-07-09 16:30:00', 180, '2023-07-07 10:00:00', 5, 'Ramenez vos manettes !\r\nGang beasts, Thrine et autres.', NULL, NULL),
(53, 8, 2, 2, 5, 'Goûter', '2023-07-08 15:30:00', 90, '2023-07-08 10:00:00', 6, 'Goûter à la Dînette, petit resto/salon de thé avec gâteaux maison et bonne sélection de thés.', NULL, NULL),
(54, 3, 6, 1, 1, 'Apéro de vacances', '2023-07-08 17:00:00', 120, '2023-07-07 17:00:00', 5, 'Apéro à la maison, j\'ai assez de gobelets', NULL, 'aeae'),
(55, 1, 2, 1, 1, 'Apéro dînatoire', '2023-07-15 17:00:00', 120, '2023-07-14 17:00:00', 5, 'Apéro et planches (fromages, fromages + charcuterie, charcuterie, légumes)', NULL, NULL),
(56, 1, 2, 1, 2, 'JDR au bar', '2023-07-12 18:00:00', 180, '2023-07-09 10:00:00', 5, 'Scénario personnalisé, amenez crayons et gommes.', NULL, NULL),
(57, 6, 3, 1, 3, 'Restaurant italien', '2023-07-11 19:00:00', 90, '2023-07-08 11:30:00', 10, 'Merci de respecter les délais, je les appelle samedi 8 juillet pour la réservation.', NULL, NULL),
(58, 7, 3, 2, 5, 'Exposition LU', '2023-07-11 19:00:00', 60, '2023-07-07 11:30:00', 5, 'Exposition en cours au Lieu Unique, let\'s go !', NULL, NULL),
(60, 4, 3, 1, 2, 'Plage naturiste', '2023-07-08 11:30:00', 240, '2023-07-05 11:30:00', 2, 'Allez les tout nus ! TOUS À POIL !', NULL, NULL),
(62, 9, 5, 1, 1, 'Apéro de milieu de projet', '2023-06-30 17:30:00', 150, '2023-06-29 22:00:00', 15, 'Il est fatigant ce projet ! Allons boire un coup.', NULL, NULL),
(63, 8, 5, 2, 5, 'Thé + gâteaux = goûter', '2023-07-01 16:00:00', 120, '2023-06-28 11:30:00', 6, 'Thés variés, ambiance cosy, super bons gâteaux.', NULL, NULL),
(64, 3, 6, 1, 1, 'GROSSE PART...', '2023-07-09 19:30:00', 120, '2023-07-03 11:00:00', 7, '... tie de JDR ! Venez les copains ! On va péter des tronches.', NULL, 'Mon chat a tout cassé chez moi. Désolée, je ne peux plus recevoir !'),
(65, 4, 6, 1, 2, 'Bain de minuit', '2023-07-08 23:30:00', 240, '2023-07-05 11:30:00', 2, 'Allez les tout nus ! TOUS À POIL !', NULL, 'Il fait trop froid en fait.');

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `city`
--

INSERT INTO `city` (`id`, `city_name`, `post_code`) VALUES
(1, 'Quimper', '29000'),
(2, 'Ergué-Gabéric', '29500'),
(3, 'Fouesnant', '29170'),
(4, 'Saint-Herblain', '44800'),
(5, 'Nantes', '44000');

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
('DoctrineMigrations\\Version20230627131332', '2023-06-27 13:13:47', 1201),
('DoctrineMigrations\\Version20230629071229', '2023-06-29 07:13:03', 204),
('DoctrineMigrations\\Version20230704144919', '2023-07-04 14:49:34', 71),
('DoctrineMigrations\\Version20230706094125', '2023-07-06 09:41:39', 126);

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_id` int NOT NULL,
  `location_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E9E89CB8BAC62AF` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id`, `city_id`, `location_name`, `street`, `latitude`, `longitude`) VALUES
(1, 1, 'Le vin dans les voiles', '15 rue de la Providence', 47.99738993792046, -4.107613431274707),
(2, 4, 'Berlin 1989', '9 Rue des Piliers de la Chauvinière', 47.2309808, -1.6380008),
(3, 1, 'Chez Maïwenn', 'Soirée jeux vidéo', 48.3712455, -4.883058),
(4, 3, 'Plage de Fouesnant', 'Dsc de Bellevue', 47.8853043, -3.9873065),
(5, 1, 'Les Archers de Quimper', '131 boulevard Creach Gwen', 47.973324685063, -4.0971993306899),
(6, 2, 'À la Capitale', 'Route du Cimetière', 47.99652365282115, -4.0277809306557115),
(7, 5, 'Le Lieu Unique', 'Rue de la Biscuiterie', 47.21542993372667, -1.5456180024709723),
(8, 5, 'Dînette', '12 Rue du Château', 47.216301781054405, -1.552131435274961),
(9, 1, 'V and B', '52 Av. de Kéradennec', 47.9770456133708, -4.076995175858896);

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

-- --------------------------------------------------------

--
-- Structure de la table `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE IF NOT EXISTS `registration` (
  `registration_date` datetime NOT NULL,
  `activity_id` int NOT NULL,
  `participant_id` int NOT NULL,
  PRIMARY KEY (`activity_id`,`participant_id`),
  KEY `IDX_62A8A7A781C06096` (`activity_id`),
  KEY `IDX_62A8A7A79D1C3019` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `registration`
--

INSERT INTO `registration` (`registration_date`, `activity_id`, `participant_id`) VALUES
('2023-07-03 12:05:51', 49, 1),
('2023-07-03 12:06:16', 49, 2),
('2023-07-03 12:06:07', 49, 3),
('2023-07-06 06:16:53', 53, 1),
('2023-07-05 10:02:30', 54, 2),
('2023-07-05 10:01:05', 55, 2),
('2023-07-05 10:02:45', 56, 3),
('2023-07-05 13:58:19', 56, 4);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site`
--

INSERT INTO `site` (`id`, `site_name`) VALUES
(1, 'Quimper'),
(2, 'Saint-Herblain'),
(3, 'Rennes');

-- --------------------------------------------------------

--
-- Structure de la table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `state`
--

INSERT INTO `state` (`id`, `label`) VALUES
(1, 'en création'),
(2, 'ouverte'),
(3, 'clôturée'),
(4, 'en cours'),
(5, 'terminée'),
(6, 'annulée'),
(7, 'archivée');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `is_admin`, `is_active`) VALUES
(1, 'maiwenn', '[\"ROLE_USER\"]', '$2y$13$/mYQ7vOLqF5oDAL8Ys3tTOHxpWLlxsKLo.uumCSgXlKtXgGoSvS9y', 0, 1),
(2, 'ken', '[\"ROLE_USER\"]', '$2y$13$Xo7ha7iOXmeaXC5WPrbf.uHM2H9LuMZwMq92VgNTnVXhAfQruaGPm', 0, 1),
(3, 'hadhemi', '[\"ROLE_USER\"]', '$2y$13$9ErLawrc4pqlVJzYMd59UeChhENE0SkkabK7Uui8h9vfZWF04TYjO', 0, 1),
(4, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$MmZ0SkngwIfCxMFPhQNZkef3vPserDql5uj3QvME5fkR4Fe/.ig.a', 1, 1),
(5, 'hermine', '[\"ROLE_USER\"]', '$2y$13$gr1tpTQYj.tHEih4pcRWiecOpa.gxq7BSbQ2l/xLJ3XY.hOZTmluu', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_adress` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture_url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D95AB405A76ED395` (`user_id`),
  KEY `IDX_D95AB405F6BD1646` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_profile`
--

INSERT INTO `user_profile` (`id`, `site_id`, `user_id`, `last_name`, `first_name`, `phone_number`, `email_adress`, `picture_url`) VALUES
(1, 1, 1, 'Julien', 'Maïwenn', '0204060810', 'mai@mail.fr', NULL),
(2, 1, 2, 'Poulmarc\'h', 'Ken', '0908070605', 'ken@mail.fr', NULL),
(3, 1, 3, 'Enneb', 'Hadhemi', '0204060810', 'hadhemi@mail.fr', NULL),
(4, 2, 4, 'Admin', 'Super', '0101010101', 'admin@mail.fr', NULL),
(5, 2, 5, 'Leblanc', 'Hermine', '0103050709', 'hermine@mail.fr', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `FK_AC74095A5D83CC1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`),
  ADD CONSTRAINT `FK_AC74095A64D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `FK_AC74095AA0631C12` FOREIGN KEY (`organiser_id`) REFERENCES `user_profile` (`id`),
  ADD CONSTRAINT `FK_AC74095AF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_5E9E89CB8BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Contraintes pour la table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `FK_62A8A7A781C06096` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `FK_62A8A7A79D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `user_profile` (`id`);

--
-- Contraintes pour la table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `FK_D95AB405A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D95AB405F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `activity state : clôturée`$$
CREATE DEFINER=`root`@`localhost` EVENT `activity state : clôturée` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-07-03 09:30:23' ENDS '2023-07-15 09:30:23' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE activity SET state_id=3 WHERE state_id=2 AND closing_date<NOW()$$

DROP EVENT IF EXISTS `activity state : en cours`$$
CREATE DEFINER=`root`@`localhost` EVENT `activity state : en cours` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-06-28 12:44:12' ENDS '2023-07-14 12:44:12' ON COMPLETION PRESERVE ENABLE DO UPDATE activity SET state_id=4 WHERE state_id=3 AND start_date<NOW()$$

DROP EVENT IF EXISTS `activity state : archivée`$$
CREATE DEFINER=`root`@`localhost` EVENT `activity state : archivée` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-07-03 10:17:13' ENDS '2023-07-15 10:17:13' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE activity SET state_id=7 WHERE (state_id=5 OR state_id=6) AND DATE_ADD(start_date, INTERVAL 1 MONTH)<NOW()$$

DROP EVENT IF EXISTS `activity state : terminée`$$
CREATE DEFINER=`root`@`localhost` EVENT `activity state : terminée` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-07-03 11:19:25' ENDS '2023-07-15 11:19:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE activity SET state_id=5 WHERE state_id=4 AND DATE_ADD(start_date,INTERVAL duration MINUTE)<NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
