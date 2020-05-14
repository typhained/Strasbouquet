-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 14 Mai 2020 à 17:55
-- Version du serveur :  5.7.30-0ubuntu0.18.04.1
-- Version de PHP :  7.2.30-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `strasbouquet`
--

--
-- Contenu de la table `bouquet`
--

INSERT INTO `bouquet` (`id`, `nom`, `prix`, `description`, `saisonnier`) VALUES
(6, 'Vanille Fraise', 39, 'Composé en rose et blanc, avec des roses et des hypéricums, ce ravissant bouquet rond promet d\'accompagner vos plus beaux messages en toute occasion.', 'Remerciement'),
(7, 'Rouge idylle', 50, 'Dévoilez vos plus beaux sentiments avec notre bouquet Rouge idylle, une création de roses rouges aux tiges longues, composée tout en hauteur et délicatement mise en valeur par des graminées.', 'Amour'),
(8, 'A la folie', 60, 'Vous l\'aimez un peu... Beaucoup ? Déclarez votre flamme avec notre bouquet A la folie, réalisé avec une sélection de superbes roses rouges tiges hautes et gros boutons.', 'Amour'),
(9, 'Eternelle', 41, 'Réalisé avec une superbe rose rouge, des lisianthus et gypsophile blancs, ce bouquet mis en valeur par un travail délicat de feuillage est présenté en série limitée et en exclusivité.', 'Amour'),
(10, 'Agathe', 34, 'Composé en rose et parme avec des roses, des lisianthus, des fleurs de saison et de l\'eucalyptus, ce bouquet s\'offre sans modération et en toute bonne occasion.', 'Mariage'),
(11, 'Délicatesse', 53, 'Invitez votre destinataire à vivre un délicieux moment avec notre bouquet Délicatesse. Une création très douce travaillée en arrondi avec des roses et de l\'eucalyptus.', 'Remerciement'),
(12, 'Coeur d\'ange', 99, 'Une création réalisée avec des fleurs et feuillage de valeurs, comme l’orchidée, la rose, le lisianthyus et le typha plat.', 'Deuil'),
(13, 'Paradilys', 90, 'Bouquet de lys et alstroemérias composé dans des tons rose, blanc et fuchsia. Une création florale majestueuse qui exprime toute la générosité des sentiments et le bonheur d\'offrir de nouvelles émotions.', 'Anniversaire'),
(14, 'Vert coton', 39, 'La rose blanche se met au service de vos plus belles occasions avec notre bouquet Vert coton.', 'Mariage'),
(15, 'Amour éternel', 59, 'Symbole floral de l’amour éternel et sincère,ce bouquet se compose de roses, germinis et autres fleurs variées rouges et vertes. Un bouquet de sympathie très chaleureux qui témoigne avec force de votre attachement et de votre réconfort.', 'Deuil'),
(16, 'Blueberry', 33, 'Offrez une surprise avec notre bouquet Blueberry, une création de fleurs naturelles réalisée avec des roses, des lisianthus, du chardon et des fleurs de saison, composée dans des tons blanc, bleu et parme.', 'Naissance'),
(17, 'Avalanche', 99, 'Composé de roses, lisianthus et fleurs de saison aux tons vert et blanc, mises en valeur par l\'eucalyptus et les graminées, ce bouquet très décoratif promet de faire sensation sur une table de cérémonie ou de réception.', 'Naissance'),
(18, 'Cupidon', 50, 'Composé avec des roses rouges et des hypéricums sertis d\'aspidistra, ce coeur floral est le fidèle messager de vos plus belles déclarations.', 'Amour'),
(19, 'Zeste tendre', 49, 'Réalisé avec des roses, des lisianthus et de l\'alstroeméria , cet assemblage de fleurs naturelles aux teintes pastel acidulé promet de provoquer une surprise pleine d\'émotion et de vitalité.', 'Anniversaire'),
(20, 'Venus', 45, 'Partagez avec votre destinataire tous les événements heureux de la vie avec Vénus, notre bouquet composé avec des roses, alstroemérias et autres fleurs variées à dominante rose.', 'Anniversaire'),
(21, 'Auréal', 37, 'omposée de roses, lisianthus et autres fleurs variées dans des tons crème et jaune pâle, cette création de fleurs champêtres et naturelles promet de créer une belle surprise en toute occasion.', 'Anniversaire'),
(22, 'Bosquet', 69, '. Composée de conifères et de plantes vertes et fleuries de saison roses, parme et violettes, cette coupe4 transmet un message naturel de sympathie et de réconfort dans l’épreuve du deuil.', 'Deuil'),
(23, 'Sonate', 38, 'Présenté dans sa bulle d\'eau8, ce bouquet rond de chrysanthèmes en camaïeu rose adresse un message de condoléances tendre et délicat.', 'Deuil'),
(24, 'Cristal', 34, 'Composé avec des roses, lisianthus, graminées et eucalyptus à dominante blanc et jaune, ce bouquet champêtre transmet un message emprunt de bonne humeur et de générosité.', 'Remerciement'),
(25, 'Liberty', 37, 'Une création dédiée aux grandes occasions en fuchsia, orange et rose pâle avec des roses, alstroemérias, germinis et autres fleurs variées délicatement mis en valeur par l\'eucalyptus.', 'Remerciement'),
(26, 'Féerie', 79, 'Composée avec des roses, lisianthus, hortensias, clématites et autres fleurs variées aux couleurs rose, bleu, pêche et parme, cette création champêtre et décorative promet un très bel effet, au bureau comme à la maison.', 'Naissance'),
(27, 'Magilys', 65, 'Emmené par le splendide lys composé dans des tons rose et blanc, notre bouquet promet de transmettre votre message avec beaucoup d\'élégance.', 'Naissance'),
(28, 'Pure sensation', 63, 'Prisée des grandes cérémonies comme le mariage, la rose blanche est avant tout associée au respect des sentiments et à la fidélité.', 'Mariage'),
(29, 'Pureté', 150, 'Angélique et raffinée, la rose blanche sait aussi sublimer vos plaisirs d\'offrir de chaque jour. Preuve en est ce sublime bouquet Pureté de 40 roses blanches gros boutons, imposant par la taille autant que par son authenticité.', 'Mariage');

--
-- Contenu de la table `catalogue_unitaire`
--

INSERT INTO `catalogue_unitaire` (`id`, `nom`, `type`, `prix`, `couleur`) VALUES
(3, 'Oeillet', 'fleurs', 2, 'rose'),
(4, 'Lys', 'fleurs', 3, 'blanc'),
(5, 'Rose', 'fleurs', 3, 'blanc'),
(6, 'Germini', 'fleurs', 2, 'blanc'),
(7, 'Pivoine', 'fleurs', 2, 'blanc'),
(8, 'Hortensia', 'fleurs', 2, 'blanc'),
(9, 'Fougère', 'feuilles', 1, 'vert'),
(10, 'Herbe de Pampa', 'herbes', 1, 'blanc'),
(11, 'Couronne', 'accessoires', 5, 'vert'),
(12, 'Monstera', 'feuilles', 2, 'vert'),
(13, 'Cineraire Maritime', 'feuilles', 2, 'blanc'),
(14, 'Chaton', 'herbes', 1, 'blanc'),
(15, 'Lagurus', 'herbes', 1, 'jaune'),
(16, 'Oeillet', 'fleurs', 2, 'violet'),
(17, 'Oeillet', 'fleurs', 2, 'violet'),
(18, 'Hortensia', 'fleurs', 2, 'bleu'),
(19, 'Germini', 'fleurs', 2, 'orange'),
(20, 'Rose', 'fleurs', 3, 'rouge'),
(21, 'Echevaria', 'feuilles', 3, 'vert'),
(22, 'Cage à oiseaux', 'autres', 10, 'blanc');

--
-- Contenu de la table `galerie`
--

INSERT INTO `galerie` (`id`, `nom`, `file1`, `id_bouquet`, `id_catalogue_unitaire`) VALUES
(6, 'Vanille Fraise', 'assets/uploads/5ebd3b4c5438e.jpg', 6, NULL),
(7, 'Rouge idylle', 'assets/uploads/5ebd3bb3e165d.jpg', 7, NULL),
(8, 'A la folie', 'assets/uploads/5ebd3bf809654.jpg', 8, NULL),
(9, 'Eternelle', 'assets/uploads/5ebd3c7058018.jpg', 9, NULL),
(10, 'Agathe', 'assets/uploads/5ebd3cf937b62.jpg', 10, NULL),
(11, 'Délicatesse', 'assets/uploads/5ebd3e2c870e2.jpg', 11, NULL),
(12, 'Coeur d\'ange', 'assets/uploads/5ebd3ea0b3024.jpg', 12, NULL),
(13, 'Paradilys', 'assets/uploads/5ebd3f02ca773.jpg', 13, NULL),
(14, 'Vert coton', 'assets/uploads/5ebd3f6575aff.jpg', 14, NULL),
(15, 'Amour éternel', 'assets/uploads/5ebd3fd834157.jpg', 15, NULL),
(16, 'Blueberry', 'assets/uploads/5ebd405e37081.png', 16, NULL),
(17, 'Avalanche', 'assets/uploads/5ebd40de12b16.png', 17, NULL),
(18, 'Oeillet', 'assets/uploads/5ebd4b01c513d.jpg', NULL, 3),
(19, 'Lys', 'assets/uploads/5ebd4f002194e.jpg', NULL, 4),
(20, 'Rose', 'assets/uploads/5ebd4fb53fa1d.jpg', NULL, 5),
(21, 'Germini', 'assets/uploads/5ebd51c1ae8e1.jpg', NULL, 6),
(22, 'Pivoine', 'assets/uploads/5ebd51d374f0c.jpg', NULL, 7),
(23, 'Hortensia', 'assets/uploads/5ebd5338734aa.jpg', NULL, 8),
(24, 'Fougère', 'assets/uploads/5ebd53de439dc.jpg', NULL, 9),
(25, 'Herbe de Pampa', 'assets/uploads/5ebd53f6c7afd.jpg', NULL, 10),
(26, 'Couronne', 'assets/uploads/5ebd543e61de8.png', NULL, 11),
(27, 'Monstera', 'assets/uploads/5ebd547dd4687.jpg', NULL, 12),
(28, 'Cineraire Maritime', 'assets/uploads/5ebd54c0cf069.jpg', NULL, 13),
(29, 'Chaton', 'assets/uploads/5ebd54fb24efb.jpg', NULL, 14),
(30, 'Lagurus', 'assets/uploads/5ebd552f6d7a9.jpg', NULL, 15),
(32, 'Oeillet', 'assets/uploads/5ebd56207af11.jpg', NULL, 17),
(33, 'Hortensia', 'assets/uploads/5ebd5a6c13bfe.jpg', NULL, 18),
(34, 'Germini', 'assets/uploads/5ebd5aa27da5f.jpg', NULL, 19),
(35, 'Rose', 'assets/uploads/5ebd5af6bfe5e.jpg', NULL, 20),
(36, 'Echevaria', 'assets/uploads/5ebd5bd1e8448.jpg', NULL, 21),
(37, 'Cage à oiseaux', 'assets/uploads/5ebd5c795e1b3.jpg', NULL, 22),
(38, 'Cupidon', 'assets/uploads/5ebd5f4fcc950.png', 18, NULL),
(39, 'Zeste tendre', 'assets/uploads/5ebd5fe1e7f28.jpg', 19, NULL),
(40, 'Venus', 'assets/uploads/5ebd6028724f7.png', 20, NULL),
(41, 'Auréal', 'assets/uploads/5ebd6090b49cf.png', 21, NULL),
(42, 'Bosquet', 'assets/uploads/5ebd60f1923d3.jpg', 22, NULL),
(43, 'Sonate', 'assets/uploads/5ebd616a457c0.jpg', 23, NULL),
(44, 'Cristal', 'assets/uploads/5ebd6202034d7.jpg', 24, NULL),
(45, 'Liberty', 'assets/uploads/5ebd6244c6b98.png', 25, NULL),
(46, 'Féerie', 'assets/uploads/5ebd6464f2bb7.png', 26, NULL),
(47, 'Magilys', 'assets/uploads/5ebd64979369f.png', 27, NULL),
(48, 'Pure sensation', 'assets/uploads/5ebd660c2e4bf.jpg', 28, NULL),
(49, 'Pureté', 'assets/uploads/5ebd6689e3d71.jpg', 29, NULL);

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `password`, `mail`, `role`, `historique`, `num_Tel`) VALUES
(1, 'Client', 'CLIENT', '$2y$10$HH9DkJWeLBXPVAaFcQwjWevOpO3ykjFia9pBncywDPhGk2OthZXga', 'client@gmail.com', 'client', NULL, '0203568956'),
(2, 'Admin', 'SUPER', '$2y$10$wsfp2GX25rkkdXGbZrI5FOf2dbQHk49LyxSAzr3WP8SEJDlFf843S', 'admin@gmail.com', 'admin', NULL, '0356895689');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
