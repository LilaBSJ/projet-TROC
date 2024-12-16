-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 09 fév. 2024 à 14:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_troc`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `desc_courte` varchar(255) NOT NULL,
  `desc_longue` text NOT NULL,
  `prix` int(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(45) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_photo` int(11) DEFAULT NULL,
  `id_categorie` int(3) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `desc_courte`, `desc_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `id_user`, `id_photo`, `id_categorie`, `created_at`) VALUES
(14, 'Offre d&#039;emploi', 'Recherche développeur web expérimenté', 'Rejoignez notre équipe dynamique en tant que développeur web expérimenté et contribuez à la création de solutions numériques innovantes. Nous recherchons un professionnel passionné possédant une solide expérience dans le développement web et une maîtrise avancée de plusieurs langages de programmation.\nResponsabilités :\nConcevoir, développer et déployer des applications web hautement performantes en utilisant les meilleures pratiques de développement.\nCollaborer avec les membres de l&#039;équipe pour comprendre les besoins des clients et proposer des solutions techniques efficaces.\nAssurer la maintenance, l&#039;optimisation et l&#039;amélioration continue des applications existantes.\nParticiper à la veille technologique et rester à jour avec les dernières tendances et innovations dans le domaine du développement web.\nExigences :\nExpérience avérée dans le développement web, avec une solide connaissance des langages tels que HTML, CSS, JavaScript, PHP, et/ou Python.\nMaîtrise des frameworks et bibliothèques populaires tels que React.js, Vue.js, Angular, Laravel, Django, etc.\nCapacité à travailler de manière autonome tout en étant un membre collaboratif et proactif de l&#039;équipe.\nFortes compétences en résolution de problèmes, en analyse et en communication.\nUne passion pour l&#039;apprentissage continu et le développement professionnel.', 3800, '', 'France', 'Paris', '39 rue Frémicourt', 75015, 25, 13, 1, '2024-02-04 12:06:38'),
(15, 'Voiture d&#039;occasion', 'Voiture compacte en bon état, idéale pour la ville', 'Nous vendons notre voiture d&#039;occasion, une berline compacte en excellent état. Parfaite pour les déplacements en ville, elle offre un faible kilométrage, une consommation économique et un intérieur spacieux', 3000, '', 'France', 'Strasbourg', '67 bld du Roi', 34024, 25, 14, 2, '2024-02-04 12:12:25'),
(16, 'Appartement à louer', 'Appartement lumineux avec vue sur la ville', 'À louer, un charmant appartement situé au cœur de la ville, offrant une vue imprenable sur les toits. Cet appartement lumineux comprend deux chambres, un salon spacieux, une cuisine équipée et une salle de bains moderne', 1200, '', 'France', 'Amiens', '34 rue Moucot', 90876, 25, 15, 3, '2024-02-04 12:18:19'),
(17, 'Location villa en bord de mer', 'Villa de vacances avec piscine privée', 'Profitez de vos vacances dans notre magnifique villa en bord de mer. Cette spacieuse propriété offre tout le confort nécessaire pour des vacances relaxantes, y compris une piscine privée, un jardin luxuriant et une vue panoramique sur l&#039;océan', 2000, '', 'France', 'Marseille', '34 rue Becon', 45678, 24, 16, 4, '2024-02-04 12:21:56'),
(18, 'Téléphone portable', 'Téléphone portable léger et performant', 'À vendre, un téléphone portable haut de gamme offrant des performances exceptionnelles dans un design élégant et léger. Doté d&#039;un processeur puissant, d&#039;un grand écran haute résolution et d&#039;une autonomie longue durée, ce téléphone est parfait pour le travail et les loisirs.', 390, '', 'France', 'Reims', '78 rue Bando', 34987, 24, 17, 5, '2024-02-04 12:25:14'),
(19, 'Vélo de montagne', 'Vélo robuste pour les sentiers de montagne', 'À vendre, un vélo de montagne de qualité supérieure, conçu pour affronter les sentiers les plus difficiles. Ce vélo robuste est équipé de composants haut de gamme, d&#039;une suspension performante et d&#039;un cadre en aluminium léger', 800, '', 'France', 'Toulouse', '23 rue Fremicourt', 75015, 24, 18, 6, '2024-02-04 12:27:13'),
(21, 'Cours de cuisine', 'Cours de cuisine à domicile', 'Offrez-vous une expérience culinaire unique avec nos cours de cuisine à domicile. Notre chef professionnel vous guidera à travers chaque étape de la préparation de délicieux plats, et vous apprendra des techniques et des astuces de cuisine que vous pourrez utiliser chez vous', 70, '', 'France', 'Marseille', '39 rue Frémicourt', 75015, 22, 20, 8, '2024-02-04 12:35:30'),
(22, 'Canapé convertible', 'Canapé confortable pour le salon', 'Vend canapé convertible en parfait état, idéal pour le salon ou la salle de séjour. Ce canapé spacieux et confortable se transforme facilement en un lit confortable pour les invités, et son design moderne s&#039;intègre parfaitement à tout type de décoration intérieure', 600, '', 'France', 'Amiens', '45 rue Molière', 75015, 22, 21, 9, '2024-02-04 12:37:18'),
(23, 'Robe de soirée', 'Robe élégante pour les occasions spéciales', 'À vendre, une magnifique robe de soirée en parfait état. Cette robe élégante est parfaite pour les occasions spéciales telles que les mariages, les cocktails ou les soirées formelles. Fabriquée avec des matériaux de haute qualité, elle offre un ajustement parfait et une silhouette flatteuse.La robe présente un corsage ajusté qui met en valeur la silhouette, tandis que la jupe fluide ajoute une touche d&#039;élégance et de mouvement. Le décolleté plongeant et le dos nu ajoutent une touche de sensualité, tandis que les détails en dentelle et les ornements délicats apportent une touche de sophistication.\r\nCette robe est non seulement magnifique, mais elle est également confortable à porter grâce à sa doublure douce et à son tissu respirant. Avec sa coupe classique et intemporelle, elle convient à toutes les morphologies et met en valeur la féminité de chaque femme.\r\nQue ce soit pour une soirée romantique, une célébration spéciale ou un événement mondain, cette robe sera le choix parfait pour briller et faire sensation. Ne manquez pas l&#039;occasion de vous démarquer avec cette robe de soirée exceptionnelle.', 80, '', 'France', 'Paris', '39 rue Frémicourt', 75015, 19, 22, 10, '2024-02-04 12:40:13'),
(24, 'Table de ping-pong', 'Table de ping-pong pliable', 'Vends une table de ping-pong pliable en excellent état. Cette table de taille réglementaire est parfaite pour les jeux en famille ou entre amis, et se range facilement lorsqu&#039;elle n&#039;est pas utilisée. Elle est livrée avec des raquettes et des balles de ping-pong', 68, '', 'France', 'Paris', '39 rue Frémicourt', 75015, 19, 23, 11, '2024-02-04 12:42:12'),
(31, 'Perceuse sans fil Bosch Professional 18V', 'Puissante perceuse sans fil pour les projets de bricolage et de construction.', 'Cette perceuse sans fil de Bosch Professional est l&#039;outil idéal pour tous vos projets de bricolage et de construction. Avec sa batterie longue durée de 18V, elle offre une puissance optimale pour percer dans le bois, le métal et le béton. Son mandrin autoserrant permet un changement rapide et facile des forets. Compacte et légère, elle est facile à manœuvrer même dans les espaces restreints. Livrée avec deux batteries et un chargeur rapide.', 150, '', 'France', 'Reims', '123 Rue de la Ping-Pongerie', 75001, 14, 26, 7, '2024-02-06 22:00:13');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motscles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(1, 'Emploi', 'Offres d\'emploi'),
(2, 'Vehicule', 'Voitures, Motos, Bateaux, Vélos, Equipement'),
(3, 'Immobilier', 'Ventes, Locations, Colocations, Bureaux, Logement'),
(4, 'Vacances', 'Camping, Hotels, Hôte '),
(5, 'Multimedia', 'Jeux Vidéos, Informatique, Image, Son, Téléphone'),
(6, 'Loisirs', 'Films, Musique, Livres'),
(7, 'Materiel', 'Outillage, Fournitures de Bureau, Matériel Agricole'),
(8, 'Services', 'Prestations de services, Evènements'),
(9, 'Maison', 'Ameublement, Electroménager, Bricolage, Jardinage'),
(10, 'Vetements', 'Jean, Chemise, Robe, Chaussure'),
(11, 'Autres', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(11) NOT NULL,
  `id_user_notant` int(11) DEFAULT NULL,
  `id_user_auteur` int(11) DEFAULT NULL,
  `note` int(3) NOT NULL,
  `avis` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo`) VALUES
(13, 'C:/xampp/htdocs/projet_troc/img/dev.jpg'),
(14, 'C:/xampp/htdocs/projet_troc/img/voiture.png'),
(15, 'C:/xampp/htdocs/projet_troc/img/appart.jpeg'),
(16, 'C:/xampp/htdocs/projet_troc/img/villa.jpeg'),
(17, 'C:/xampp/htdocs/projet_troc/img/produit-4.png'),
(18, 'C:/xampp/htdocs/projet_troc/img/velo.jpeg'),
(19, 'C:/xampp/htdocs/projet_troc/img/perceuse.jpeg'),
(20, 'C:/xampp/htdocs/projet_troc/img/cours.jpeg'),
(21, 'C:/xampp/htdocs/projet_troc/img/canape.jpeg'),
(22, 'C:/xampp/htdocs/projet_troc/img/robe.jpg'),
(23, 'C:/xampp/htdocs/projet_troc/img/table.jpg'),
(24, '_robe.jpg'),
(25, '_robe.jpg'),
(26, '_perceuse.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('h','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `created_at`) VALUES
(14, 'Varnava', '$2y$10$gdAYswiC.2NOPYXNuFQAO.8/fY9IKy7JTAFuh3wvuRYR6ooYIADp.', 'Jitina', 'Lila', '0625223551', 'jitina@gmail.com', '', 1, '2024-01-27 17:27:21'),
(15, 'Orthodoxe', '$2y$10$ECaf7NFOaEBklUn2NA0pLuQZ8/PZsb7Vmd9QFfAMHmK9/AhfIXo4q', 'Krief', 'David', '0625223551', 'david.krief@gmail.com', 'h', 0, '2024-01-28 15:35:19'),
(16, 'Snelochka', '$2y$10$7Jz44co6dXVXO.dDggNRzOHYxssmdzH7p0x2zlMjhqmFIAJ23a4/e', 'Libellule', 'Nelli', '0625223551', 'schastie@gmail.com', 'f', 0, '2024-01-29 10:28:29'),
(19, 'Sputnik', '$2y$10$avwNwR1hHouawm/F.UZJhegszBjb3YNhhqRhIVc.7Iy144ZZXItP.', 'Borisovitch', 'Barnabe', '0625223551', 'elgranchik@gmail.com', 'h', 0, '2024-01-29 15:44:49'),
(22, 'Mamochka', '$2y$10$FK1w6YWJFB11E6Q082xcRuKFF1Rz3nhFsDTE5Veq1KtusaBCqzb5S', 'Dorogaya', 'Musichka', '0533734626', 'mulichka@yahoo.com', 'f', 0, '2024-01-29 16:34:13'),
(24, 'Mishka', '$2y$10$4.qSO2D4aadB/1XCS5z7NuG7534qlLqCn3NwEghZRfC7yAHakihK2', 'Mini', 'Mimi', '0625223551', 'soukhinina@yahoo.com', 'h', 0, '2024-02-03 20:12:39'),
(25, 'Khazar', '$2y$10$iPAggqm3BisAjqMOBGIlMuaYstKzALLftmd6fgdF.CkPZQ8XjD.8m', 'Kniaz', 'Batiy', '0625223551', 'orda@gmail.com', 'h', 0, '2024-02-04 11:56:32'),
(26, 'Karapuzik', '$2y$10$/KFKYHgyWWtALSta2Ekq8e01pQC8XAxL2k6x1qvYF6MxEPOpS1osi', 'Granovsky', 'Edik', '0533734626', 'edik@gmail.com', 'h', 0, '2024-02-06 14:55:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `id_photo` (`id_photo`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id_user_notant` (`id_user_notant`),
  ADD KEY `id_user_auteur` (`id_user_auteur`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`id_photo`) REFERENCES `photo` (`id_photo`),
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `annonce_ibfk_4` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_user_auteur`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_user_notant`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
