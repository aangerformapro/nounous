-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 août 2023 à 10:40
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `babysitter`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `id_enfant` int(11) DEFAULT NULL,
  `id_availability` int(11) NOT NULL,
  `status` enum('PENDING','ACCEPTED','DECLINED','DONE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` int(11) NOT NULL,
  `id_nounou` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `hourly_rate` float NOT NULL DEFAULT 3.49,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enfants`
--

CREATE TABLE `enfants` (
  `id` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `planing_enfants`
--

CREATE TABLE `planing_enfants` (
  `id` int(11) NOT NULL,
  `id_enfant` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('PARENT','BABYSITTER') NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_enfant` (`id_enfant`),
  ADD KEY `id_availability` (`id_availability`);

--
-- Index pour la table `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nounou` (`id_nounou`);

--
-- Index pour la table `enfants`
--
ALTER TABLE `enfants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_parent` (`id_parent`);

--
-- Index pour la table `planing_enfants`
--
ALTER TABLE `planing_enfants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_enfant` (`id_enfant`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enfants`
--
ALTER TABLE `enfants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `planing_enfants`
--
ALTER TABLE `planing_enfants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`id_enfant`) REFERENCES `enfants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`id_availability`) REFERENCES `availabilities` (`id`);

--
-- Contraintes pour la table `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_ibfk_1` FOREIGN KEY (`id_nounou`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `enfants`
--
ALTER TABLE `enfants`
  ADD CONSTRAINT `enfants_ibfk_1` FOREIGN KEY (`id_parent`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `planing_enfants`
--
ALTER TABLE `planing_enfants`
  ADD CONSTRAINT `planing_enfants_ibfk_1` FOREIGN KEY (`id_enfant`) REFERENCES `enfants` (`id`);

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
