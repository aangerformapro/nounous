-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 29 août 2023 à 10:45
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
  `status` enum('PENDING','ACCEPTED','DECLINED','DONE') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appointments`
--

INSERT INTO `appointments` (`id`, `id_enfant`, `id_availability`, `status`) VALUES
(1, NULL, 2, 'PENDING'),
(2, NULL, 3, 'PENDING'),
(3, NULL, 3, 'PENDING'),
(4, NULL, 3, 'PENDING'),
(5, NULL, 3, 'PENDING'),
(6, NULL, 3, 'PENDING');

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

--
-- Déchargement des données de la table `availabilities`
--

INSERT INTO `availabilities` (`id`, `id_nounou`, `start`, `end`, `hourly_rate`, `date`) VALUES
(1, 5, '07:50:00', '15:50:00', 3.57, '2023-08-30'),
(2, 5, '07:20:00', '18:50:00', 3.57, '2023-08-31'),
(3, 5, '07:00:00', '18:00:00', 3.78, '2023-09-01');

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

--
-- Déchargement des données de la table `enfants`
--

INSERT INTO `enfants` (`id`, `id_parent`, `nom`, `prenom`, `birthday`) VALUES
(1, 4, 'Bear', 'Baby', '2023-08-08'),
(3, 4, 'Bear', 'Enfant Dix', '2023-08-01'),
(4, 4, 'Bear', 'gffgfg', '2008-08-26');

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

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `id_user`, `session`, `expires`) VALUES
(1, 1, '583c6714ff53af84e9256a0e8817000fba668d61', '2023-08-28 14:16:20'),
(2, 1, 'a4ad4985eac50384b11e7f2e75b99db93e04fa4c', '2023-08-28 14:21:32'),
(3, 1, '6adb9d04eda4d98a56a4d280be21a16050466c57', '2023-08-28 15:04:08'),
(6, 3, 'b5fa13e0c747ca6cfbbc02098082df359d53a2cf', '2023-08-29 13:38:41'),
(11, 5, '920e2c5a6ba0084cef7f6f82422dc1ae2cddcc6f', '2023-09-01 16:15:18');

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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `nom`, `prenom`, `address`, `zip`, `city`, `phone`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'fkjgkfgjf@gmail.com', '$2y$10$ojCZMYCsyFyesVR3Flr/DurqX2X6b9CkH0JM/Hdi.PEFo5GP1cH36', 'PARENT', 'Nom', 'Prénom', '5 rue de la vachette', '71100', 'Chalon-sur-Saône', '0123456789', 'FEMALE', '2023-08-21 11:29:00', '2023-08-21 11:29:00'),
(3, 'fkjgkfgjfdfdff@gmail.com', '$2y$10$DFCxqr5r/TCATZ33OZpG9.5r70SeYPtTnIN9XHnjBrwuLoJHZCLYG', 'BABYSITTER', 'yuyu', 'yuyu', '50 rue de la boue', '80080', 'Amiens', '0234567890', 'MALE', '2023-08-22 09:48:50', '2023-08-22 09:48:50'),
(4, 'maman@famille.com', '$2y$10$S0VGmhbsr.J8Q7usEbylTeZNJl7oU/fToGJPpkTsGc0D2TzTTa8dC', 'PARENT', 'Bear', 'Mama', '30 rue de bercy', '33000', 'Bordeaux', '0234567891', 'FEMALE', '2023-08-24 14:10:28', '2023-08-24 14:10:28'),
(5, 'nourice@dailysitter.com', '$2y$10$aldwcFf7pVub8EhZDlzXhur8g.n4LQlMNkZyZop3YI7tfKWKaBQyC', 'BABYSITTER', 'Poppins', 'Mary', '5 Rue du chateau', '69100', 'Villeurbanne', '0312456789', 'FEMALE', '2023-08-24 16:12:02', '2023-08-24 16:12:02');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `enfants`
--
ALTER TABLE `enfants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `planing_enfants`
--
ALTER TABLE `planing_enfants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
