-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 01 juil. 2024 à 08:22
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `strapontissimo`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`) VALUES
(5, 'Tom', 'e1608f75c5d7813f3d4031cb30bfb786507d98137538ff8e128a6ff74e84e643', 'tom@tom.com');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `nom`) VALUES
(1, 'Nom de la catégorie manquante'),
(2, 'Intérieur'),
(3, 'Extérieur');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `statut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `qté` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_panier` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `id_user`, `id_product`, `quantity`) VALUES
(14, 1, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `infoproduct` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `id_subcategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id_product`, `nom`, `infoproduct`, `price`, `image`, `stock`, `date`, `created_by`, `updated_by`, `id_category`, `id_subcategory`) VALUES
(1, 'Housse en cuir de renne pour strapontin Edblad – gris argile', 'cuir de renne gris argile\r\nvelcro de fixation (facile à installer et à retirer)\r\ndesign : Hans Edblad (Suède)', 46.00, 'https://lapadd.com/wp-content/uploads/2021/11/housse-en-cuir-de-renne-pour-strapontin-edblad-gris-argile.jpg', 4, '2024-06-24', NULL, NULL, 2, 3),
(2, 'Strapontin à blocage vertical Cutter\r\n', 'Skagerak\r\nlargeur 38,5 x profondeur 31 x hauteur 9,5 cm\r\nlargeur maximale repliée : 7,7 cm\r\nmatériaux : teck, chêne ou hêtre peint + mécanisme en acier inoxydable\r\nmécanisme de blocage en position verticale (remontée manuelle)\r\nfabriqué au Danemark\r\ndesign : Niels Hvass (Danemark)', 361.00, 'https://lapadd.com/wp-content/uploads/2021/11/strapontins-a-blocage-vertical-cutter-de-skagerak-chene-clair-packshot.jpg', 2, '2024-06-24', NULL, NULL, 3, 4),
(3, 'Strapontin automatique JAXON standard, assise pleine', 'dimensions (relevé) : largeur 362mm, hauteur 400mm, épaisseur 93mm\r\nassise : largeur 300mm, profondeur 320mm, épaisseur 21mm\r\n4 finitions : chêne, hêtre, bouleau, blanc (peinture)\r\ndisponible également avec assise ajourée / treillis\r\nmatériaux : ferronnerie en acier laminé chromé, assise en bois massif (plein ou treillis)\r\ncharge max. : 150kg (sous réserve que la cloison et les fixations utilisées supportent également 150kg)\r\ndesign : Essem Design (Suède)', 266.00, 'https://lapadd.com/wp-content/uploads/2021/11/strapontin-automatique-jaxon-essem-design-chene-plein-packshot-ferme.jpg', 2, '2024-06-24', NULL, NULL, 2, 1),
(4, 'Strapontin automatique JAXON, assise treillis\r\n', 'Essem Design\r\ndimensions (relevé) : largeur 362mm, hauteur 400mm, épaisseur 93mm\r\nassise : largeur 300mm, profondeur 320mm, épaisseur 21mm\r\n3 finitions : chêne, hêtre, bouleau\r\ndisponible également avec assise pleine\r\nmatériaux : ferronnerie en acier laminé chromé, assise en bois massif (plein ou treillis)\r\ncharge max. : 150kg (sous réserve que la cloison et les fixations utilisées supportent également 150kg)\r\ndesign : Essem Design (Suède)\r\n', 599.00, 'https://lapadd.com/wp-content/uploads/2021/11/strapontin-automatique-jaxon-finition-chene-treillis-essem-design.jpg', 6, '2024-06-24', NULL, NULL, 2, 1),
(5, 'Strapontin automatique avec dossier Twist Plus', 'Allhall\r\ndimensions: H 44cm, Larg. 41cm, Prof. 12cm / 42cm\r\npoids: 8,05 kg\r\nassise et dossier : contreplaqué chêne naturel ou mélaminé 10mm\r\nchâssis : acier avec peinture epoxy poudrée (blanc, gris texturé ou anthracite texturé)\r\nlivré avec 6 goujons à expansion pour fixation dans un mur plein, béton, brique pleine, pierre...\r\ncharge supportée : 200kg (conforme à la norme EN 12727 sur la résistance des sièges de stade ou auditorium)\r\nclassement feu : M2, difficilement inflammable\r\ngarantie 2 ans\r\nfabriqué en Pologne\r\n', 624.00, 'https://lapadd.com/wp-content/uploads/2021/12/strapontin-automatique-avec-dossier-packshot-ouvert-ferme-sw-fw.jpg', 2, '2024-06-24', NULL, NULL, 3, 5),
(6, 'Banc de 2 strapontins automatiques avec dossier sur base mobile', 'Allhall\r\nassise et dossier : contreplaqué chêne naturel ou mélaminé 10mm\r\nchâssis : acier avec peinture epoxy poudrée (blanc, gris texturé ou anthracite texturé)\r\nbase : acier avec peinture epoxy poudrée\r\ngarantie 2 ans\r\nfabriqué en Pologne', 1279.00, 'https://lapadd.com/wp-content/uploads/2021/11/banc-de-2-strapontins-automatiques-avec-dossier-sur-base-mobile-front.jpg', 1, '2024-06-24', NULL, NULL, 3, 5),
(7, 'Banc de 3 strapontins automatiques avec dossier sur base mobile', 'Allhall\r\nassise et dossier : contreplaqué chêne naturel ou mélaminé 10mm\r\nchâssis : acier avec peinture epoxy poudrée (blanc, gris texturé ou anthracite texturé)\r\nbase : acier avec peinture epoxy poudrée\r\ngarantie 2 ans\r\nfabriqué en Pologne', 2628.00, 'https://lapadd.com/wp-content/uploads/2021/11/banc-de-3-strapontins-automatiques-avec-dossier-sur-base-mobile-front.jpg', 7, '2024-06-24', NULL, NULL, 3, 5),
(8, 'Strapontin automatique indoor ou outdoor Pfalz, assise treillis métallique', 'Tole & Tech\r\ndimensions selon configuration, voir détails ci-dessous\r\nmatériaux : acier (traité par cataphorèse KTL) + peinture epoxy poudrée + visseries inox résistants à la corrosion\r\nclassement feu : DIN 4102-A1 pour la structure, DIN 4102-A2 pour le revêtement (ignifuges, non inflammable)\r\nautomatique, conforme aux normes ERP, ressort réglable pour ajuster la vitesse de remontée de l\'assise\r\ndimensions sur mesure possibles sur demande\r\ndesign et fabrication : Allemagne', 522.00, 'https://lapadd.com/wp-content/uploads/2024/03/strapontin-ToleTech-outdoor-metal-Pfalz-mural-sans-dossier-1.jpg', 8, '2024-06-24', NULL, NULL, 3, 6),
(9, 'Strapontin automatique articulé JUMPSEAT WALL – finition bouleau\r\n', 'JumpSeat Studio\r\npoids : 22kg, charge dynamique supportée : 300kg\r\ndimensions (fermé) : H813mm, L502mm, P102mm\r\ndimensions (ouvert) : H813mm, L502mm, P464mm\r\nentr\'axe min. : 559mm\r\ndistance du sol : min. 153mm, hauteur min. de l\'assise min. 432mm\r\nmatériaux : contreplaqué bouleau NAUF (sans urée formaldéhyde), acier avec traitement Microban® antimicrobien\r\ntissu : Camira Xtreme crêpe haute résistance grade 1 100% polyester recyclé garanti 10 ans\r\ndesign : Ziba Design (Portland, Oregon, USA)\r\nproduit multi-breveté et lauréat de plus de 15 prix de design internationaux\r\nfabriqué en Italie\r\n', 1367.00, 'https://lapadd.com/wp-content/uploads/2021/12/strapontin-automatique-articule-jumpseat-wall-packshot-bouleau-havana.jpg', 4, '2024-06-24', NULL, NULL, 3, 4),
(10, 'Strapontin automatique articulé JUMPSEAT WALL – finition noyer', 'JumpSeat Studio\r\npoids : 22kg, charge dynamique supportée : 300kg\r\ndimensions (fermé) : H813mm, L502mm, P102mm\r\ndimensions (ouvert) : H813mm, L502mm, P464mm\r\nentr\'axe min. : 559mm\r\ndistance du sol : min. 153mm, hauteur min. de l\'assise min. 432mm\r\nmatériaux : contreplaqué bouleau NAUF (sans urée formaldéhyde), acier avec traitement Microban® antimicrobien\r\ntissu : Camira Xtreme crêpe haute résistance grade 1 100% polyester recyclé garanti 10 ans\r\ndesign : Ziba Design (Portland, Oregon, USA)\r\nproduit multi-breveté et lauréat de plus de 15 prix de design internationaux\r\nfabriqué en Italie\r\n', 1907.00, 'https://lapadd.com/wp-content/uploads/2021/12/strapontin-automatique-articule-jumpseat-wall-packshot-noyer-havana.jpg', 4, '2024-06-24', NULL, NULL, 3, 4),
(11, 'Strapontin automatique indoor ou outdoor Pfalz, assise plein en aluminium', 'Tole & Tech\r\ndimensions selon configuration, voir détails ci-dessous\r\nmatériaux : acier (traité par cataphorèse KTL) + peinture epoxy poudrée + visseries inox résistants à la corrosion\r\nclassement feu : DIN 4102-A1 pour la structure, DIN 4102-A2 pour le revêtement (ignifuges, non inflammable)\r\nautomatique, conforme aux normes ERP, ressort réglable pour ajuster la vitesse de remontée de l\'assise\r\ndimensions sur mesure possibles sur demande\r\ndesign et fabrication : Allemagne', 579.00, 'https://lapadd.com/wp-content/uploads/2024/04/strapontin-ToleTech-outdoor-metal-Pfalz-mural-assise-pleine-sans-dossier-1.jpg', 3, '2024-06-24', NULL, NULL, 3, 6),
(12, 'Siège pliable vertical sur base fixe JUMPSEAT 90 – finition noyer', 'JumpSeat Studio\r\ndimensions (fermé) : H933mm, L502mm, P121mm\r\ndimensions (ouvert) : H933mm, L502mm, P464mm\r\nentr\'axe min. : 559mm, hauteur de l\'assise : 432mm\r\nmatériaux : contreplaqué bouleau NAUF (sans urée formaldéhyde), acier avec traitement Microban® antimicrobien\r\ntissu : Camira Xtreme crêpe haute résistance grade 1 100% polyester recyclé garanti 10 ans\r\ncharge supportée : 300kg\r\ndesign : Ziba Design (Portland, Oregon, USA)\r\nproduit multi-breveté et lauréat de plus de 15 prix de design internationaux\r\nfabriqué en Italie\r\n', 1907.00, 'https://lapadd.com/wp-content/uploads/2021/12/siege-pliable-auditorium-conference-ancrage-sol-jumpseat-90-havana-finition-noyer.jpg', 2, '2024-06-24', NULL, NULL, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

CREATE TABLE `subcategory` (
  `id_subcategory` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `subcategory`
--

INSERT INTO `subcategory` (`id_subcategory`, `nom`, `id_category`) VALUES
(1, 'Bois', 2),
(2, 'Plastique', 2),
(3, 'Métal', 2),
(4, 'Bois', 3),
(5, 'Plastique', 3),
(6, 'Métal', 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registerdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `password`, `adresse`, `city`, `postcode`, `tel`, `registerdate`) VALUES
(1, 'alex', 'alex', 'alex@alex.fr', 'azerty', '10 ancienne rte de marseille', 'martigues', '13500', '', '0000-00-00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD UNIQUE KEY `id_commande` (`id_commande`,`id_product`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_panier`),
  ADD UNIQUE KEY `id_user` (`id_user`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `products_ibfk_1` (`created_by`),
  ADD KEY `products_ibfk_2` (`updated_by`);

--
-- Index pour la table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id_subcategory`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id_subcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
