-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 06 Mai 2020 à 09:39
-- Version du serveur :  5.7.29-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `strasbouquet`
--

-- --------------------------------------------------------

--
-- Structure de la table `bouquet`
--

CREATE TABLE `bouquet` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `prix` float NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `saisonnier` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_catalogue`
--

CREATE TABLE `bouquet_catalogue` (
  `id_bouquet_concept` int(11) NOT NULL,
  `id_catalogue_unitaire` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_concept`
--

CREATE TABLE `bouquet_concept` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_panier` int(11) NOT NULL,
  `prix_total` float DEFAULT NULL,
  `carte` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_panier`
--

CREATE TABLE `bouquet_panier` (
  `id_panier` int(11) NOT NULL,
  `id_bouquet` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_unitaire`
--

CREATE TABLE `catalogue_unitaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `prix` float NOT NULL,
  `couleur` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `galerie`
--

CREATE TABLE `galerie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `file1` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_bouquet` int(11) DEFAULT NULL,
  `id_catalogue_unitaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `galerie`
--

INSERT INTO `galerie` (`id`, `nom`, `file1`, `id_bouquet`, `id_catalogue_unitaire`) VALUES
(1, 'Boquuet', 'assets/uploads/5eb123d2add8d.png', 6, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `id_bouquet` int(11) DEFAULT NULL,
  `prix_total` float DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `mail` varchar(255) COLLATE utf8_bin NOT NULL,
  `role` varchar(255) COLLATE utf8_bin NOT NULL,
  `historique` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `num_Tel` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `password`, `mail`, `role`, `historique`, `num_Tel`) VALUES
(1, 'Client', 'CLIENT', '$2y$10$MMoyn41UdQUEcRbD9ksbiO0aOv4uM0lwmDLI8TkgYhIe2hKTJguKK', 'client@gmail.com', 'client', NULL, '0203568956'),
(2, 'Admin', 'SUPER', '$2y$10$i/jG7MGyAvlsGSLaq0NVQ.I7fdYfdcsQhRTu9pOaJfIhd5NLnY062', 'admin@gmail.com', 'admin', NULL, '0356895689');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `bouquet`
--
ALTER TABLE `bouquet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bouquet_catalogue`
--
ALTER TABLE `bouquet_catalogue`
  ADD KEY `bouquet_catalogue_ibfk_1` (`id_bouquet_concept`),
  ADD KEY `bouquet_catalogue_ibfk_2` (`id_catalogue_unitaire`);

--
-- Index pour la table `bouquet_concept`
--
ALTER TABLE `bouquet_concept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bouquet_concept_ibfk_1` (`id_user`),
  ADD KEY `bouquet_concept_ibfk_2` (`id_panier`);

--
-- Index pour la table `bouquet_panier`
--
ALTER TABLE `bouquet_panier`
  ADD KEY `bouquet_panier_ibfk_1` (`id_panier`),
  ADD KEY `bouquet_panier_ibfk_2` (`id_bouquet`);

--
-- Index pour la table `catalogue_unitaire`
--
ALTER TABLE `catalogue_unitaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galerie_ibfk_1` (`id_bouquet`),
  ADD KEY `galerie_ibfk_2` (`id_catalogue_unitaire`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `bouquet`
--
ALTER TABLE `bouquet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bouquet_concept`
--
ALTER TABLE `bouquet_concept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `catalogue_unitaire`
--
ALTER TABLE `catalogue_unitaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `galerie`
--
ALTER TABLE `galerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bouquet_catalogue`
--
ALTER TABLE `bouquet_catalogue`
  ADD CONSTRAINT `bouquet_catalogue_ibfk_1` FOREIGN KEY (`id_bouquet_concept`) REFERENCES `bouquet_concept` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bouquet_catalogue_ibfk_2` FOREIGN KEY (`id_catalogue_unitaire`) REFERENCES `catalogue_unitaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bouquet_concept`
--
ALTER TABLE `bouquet_concept`
  ADD CONSTRAINT `bouquet_concept_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bouquet_concept_ibfk_2` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bouquet_panier`
--
ALTER TABLE `bouquet_panier`
  ADD CONSTRAINT `bouquet_panier_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bouquet_panier_ibfk_2` FOREIGN KEY (`id_bouquet`) REFERENCES `bouquet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `galerie`
--
ALTER TABLE `galerie`
  ADD CONSTRAINT `galerie_ibfk_1` FOREIGN KEY (`id_bouquet`) REFERENCES `bouquet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `galerie_ibfk_2` FOREIGN KEY (`id_catalogue_unitaire`) REFERENCES `catalogue_unitaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
