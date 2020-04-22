-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 14 Avril 2020 à 17:21
-- Version du serveur :  5.7.29-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.3

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
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `saisonnier` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_catalogue`
--

CREATE TABLE `bouquet_catalogue` (
  `id_bouquet_concept` int(11) NOT NULL,
  `id_catalogue_unitaire` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_concept`
--

CREATE TABLE `bouquet_concept` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_panier` int(11) NOT NULL,
  `prix_total` int(11) NOT NULL,
  `carte` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bouquet_panier`
--

CREATE TABLE `bouquet_panier` (
  `id_panier` int(11) NOT NULL,
  `id_bouquet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_unitaire`
--

CREATE TABLE `catalogue_unitaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `couleur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gallerie`
--

CREATE TABLE `gallerie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `file1` varchar(255) NOT NULL,
  `file2` varchar(255) DEFAULT NULL,
  `id_bouquet` int(11) NOT NULL,
  `id_catalogue_unitaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `id_bouquet` int(11) NOT NULL,
  `prix_total` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `num_Tel` int(11) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `historique` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `id_bouquet_concept` (`id_bouquet_concept`),
  ADD KEY `id_catalogue_unitaire` (`id_catalogue_unitaire`);

--
-- Index pour la table `bouquet_concept`
--
ALTER TABLE `bouquet_concept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_panier` (`id_panier`);

--
-- Index pour la table `bouquet_panier`
--
ALTER TABLE `bouquet_panier`
  ADD KEY `id_panier` (`id_panier`),
  ADD KEY `id_bouquet` (`id_bouquet`);

--
-- Index pour la table `catalogue_unitaire`
--
ALTER TABLE `catalogue_unitaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gallerie`
--
ALTER TABLE `gallerie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bouquet` (`id_bouquet`),
  ADD KEY `id_catalogue_unitaire` (`id_catalogue_unitaire`);

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
-- AUTO_INCREMENT pour la table `gallerie`
--
ALTER TABLE `gallerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bouquet_catalogue`
--
ALTER TABLE `bouquet_catalogue`
  ADD CONSTRAINT `bouquet_catalogue_ibfk_1` FOREIGN KEY (`id_bouquet_concept`) REFERENCES `bouquet_concept` (`id`),
  ADD CONSTRAINT `bouquet_catalogue_ibfk_2` FOREIGN KEY (`id_catalogue_unitaire`) REFERENCES `catalogue_unitaire` (`id`);

--
-- Contraintes pour la table `bouquet_concept`
--
ALTER TABLE `bouquet_concept`
  ADD CONSTRAINT `bouquet_concept_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `bouquet_concept_ibfk_2` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`);

--
-- Contraintes pour la table `bouquet_panier`
--
ALTER TABLE `bouquet_panier`
  ADD CONSTRAINT `bouquet_panier_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `bouquet_panier_ibfk_2` FOREIGN KEY (`id_bouquet`) REFERENCES `bouquet` (`id`);

--
-- Contraintes pour la table `gallerie`
--
ALTER TABLE `gallerie`
  ADD CONSTRAINT `gallerie_ibfk_1` FOREIGN KEY (`id_bouquet`) REFERENCES `bouquet` (`id`),
  ADD CONSTRAINT `gallerie_ibfk_2` FOREIGN KEY (`id_catalogue_unitaire`) REFERENCES `catalogue_unitaire` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
