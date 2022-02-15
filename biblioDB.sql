-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 15 fév. 2022 à 14:40
-- Version du serveur :  8.0.28-0ubuntu0.20.04.3
-- Version de PHP : 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biblioDB`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `summary` varchar(400) NOT NULL,
  `release_date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `for_child` tinyint(1) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `summary`, `release_date`, `category`, `for_child`, `quantity`) VALUES
(3, 'Le seigneurs des bateaux', 'J.R.R Titanic', 'Des nains doivent jeter une encre au sommet de l\'iceberg maudit après une longue aventure dans la terre du centre.', '2017-02-10', 'Fantasy', 1, 10),
(4, 'Hello World', 'John Doe', 'Un livre merveilleux sur la programmation', '2015-06-12', 'Informatique', 1, 1),
(8, 'La femme de chambre argonienne', 'Crassius Curio', 'L\'histoire d\'une jeune femme de chambre argonienne', '0568-12-02', 'Fantasy Adult', 0, 47),
(9, 'Figaro Mag', 'G.W Bush', 'La conquête du Bush', '2001-09-11', 'politique', 1, 1),
(11, 'Star Peace', 'Lucas George', 'Dans une galaxie lointaine, très lointaine, il ne se passait rien.', '1977-05-25', 'Science Fiction', 1, 29),
(12, 'Les gelées au goulag', 'J. Staline', 'Les histoires d\'une bande d\'amis qui passent leurs vacances en camp de vacance.', '1917-11-07', 'Humour politique', 0, 42),
(15, 'Test', 'test', 'dadada', '5486-02-01', 'dadada', 1, 49);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `adress` varchar(95) NOT NULL,
  `city` varchar(35) NOT NULL,
  `mail` varchar(62) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `birth_date`, `adress`, `city`, `mail`, `phone`) VALUES
(1, 'John', 'Doe', '2017-01-01', '42 rue de la vérité', 'Poil', 'john@Doe.mail', '0666666666'),
(2, 'Jules', 'Noir--Vermeulen', '1995-01-03', '3 rue Dinanderie', 'Rouen', 'jules@mail.com', '0677777703'),
(5, 'Jacky', 'Glacial', '1986-12-24', '22 rue de la perlouze', 'Amiens', 'jacky@mail.fr', '0621235489'),
(10, 'Jeanne', 'Jaycho', '1990-01-01', 'Place du vieux marché', 'Rouen', 'jeanne@hotmail.com', '03 25 23 24 25'),
(11, 'Testoda', 'Testada', '1986-03-31', '420 rue de la moula', 'Moncuq', 'test@mail.test', '03 22 54 89 65'),
(12, 'Matéo', 'Salgoss', '2010-08-17', '2 rue de la poisse', 'Paris', 'matéo@mail.com', '06 77 08 09 45'),
(13, 'Test', 'Testttt', '1995-01-03', '42 route kekchoz', 'Paris', 'test@mail.fr', '0680325647');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_date` datetime DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `history`
--

INSERT INTO `history` (`id`, `client_id`, `book_id`, `borrow_date`, `returned_date`, `due_date`, `user_id`) VALUES
(31, 2, 3, '2022-02-03 14:59:27', '2022-02-15 11:25:26', '2022-02-23 14:59:27', 1),
(32, 2, 3, '2022-02-04 10:24:39', '2022-02-15 11:25:29', '2022-02-05 10:24:39', 1),
(35, 5, 3, '2022-02-07 09:38:21', '2022-02-07 09:45:48', '2022-02-08 09:38:21', 1),
(36, 2, 8, '2022-02-07 09:56:30', '2022-02-07 13:28:07', '2022-02-08 09:56:30', 1),
(37, 5, 9, '2022-02-07 09:56:34', '2022-02-07 09:59:19', '2022-02-08 09:56:34', 1),
(40, 2, 8, '2022-02-07 13:27:41', '2022-02-15 11:25:23', '2022-02-14 13:27:41', 1),
(41, 5, 3, '2022-02-07 13:30:57', '2022-02-07 13:31:52', '2022-02-22 13:30:57', 1),
(42, 5, 4, '2022-02-07 13:55:20', '2022-02-07 13:55:45', '2022-02-14 13:55:20', 1),
(43, 10, 8, '2022-02-14 12:08:32', NULL, '2022-02-21 12:08:32', 1),
(44, 10, 3, '2022-02-14 13:56:10', NULL, '2022-02-21 13:56:10', 1),
(46, 10, 8, '2022-02-14 13:56:14', NULL, '2022-02-21 13:56:14', 1),
(47, 5, 8, '2022-02-14 13:56:17', '2022-02-15 14:08:59', '2022-02-21 13:56:17', 1),
(49, 1, 3, '2022-02-15 11:11:40', NULL, '2022-02-22 11:11:40', 1),
(51, 1, 11, '2022-02-15 11:26:09', NULL, '2022-02-25 11:26:09', 1),
(52, 10, 15, '2022-02-15 14:08:24', NULL, '2022-02-22 14:08:24', 1),
(53, 5, 9, '2022-02-15 14:08:37', '2022-02-15 14:08:55', '2022-02-22 14:08:37', 1),
(54, 5, 3, '2022-02-15 14:34:29', '2022-02-15 14:35:06', '2022-02-22 14:34:29', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$dY.xVOSbI2JyWSG7dW3vdeeKI37TlWsrsKzXYrDyXrs/rj/xvWq.G'),
(2, 'jules@mail.com', '[]', '$2y$13$1ynLOt8DKXyjWHpLMxzG0.Gdas7Fpa8DHpBs0SNysnwPiyz4eDquS'),
(3, 'test@test.test', '[]', '$2y$13$0WO.DTs1zMJ6OtNjBPUC4ezmSwyHVjjDFCYwtzjnBzoeT6U/rLXQS');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `history_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
