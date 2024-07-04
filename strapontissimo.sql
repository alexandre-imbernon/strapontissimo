-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 04 juil. 2024 à 09:26
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

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

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `statut` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_product` int DEFAULT NULL,
  `qté` int DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  UNIQUE KEY `id_commande` (`id_commande`,`id_product`),
  KEY `id_user` (`id_user`),
  KEY `id_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `id_product` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`),
  KEY `id_product` (`id_product`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id_panier`),
  UNIQUE KEY `id_user` (`id_user`,`id_product`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `id_user`, `id_product`, `quantity`) VALUES
(14, 1, 3, 2),
(15, 5, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `infoproduct` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` float(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  `date` date NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `id_category` int NOT NULL,
  `id_subcategory` int NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `products_ibfk_1` (`created_by`),
  KEY `products_ibfk_2` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(12, 'Siège pliable vertical sur base fixe JUMPSEAT 90 – finition noyer', 'JumpSeat Studio\r\ndimensions (fermé) : H933mm, L502mm, P121mm\r\ndimensions (ouvert) : H933mm, L502mm, P464mm\r\nentr\'axe min. : 559mm, hauteur de l\'assise : 432mm\r\nmatériaux : contreplaqué bouleau NAUF (sans urée formaldéhyde), acier avec traitement Microban® antimicrobien\r\ntissu : Camira Xtreme crêpe haute résistance grade 1 100% polyester recyclé garanti 10 ans\r\ncharge supportée : 300kg\r\ndesign : Ziba Design (Portland, Oregon, USA)\r\nproduit multi-breveté et lauréat de plus de 15 prix de design internationaux\r\nfabriqué en Italie\r\n', 1907.00, 'https://lapadd.com/wp-content/uploads/2021/12/siege-pliable-auditorium-conference-ancrage-sol-jumpseat-90-havana-finition-noyer.jpg', 2, '2024-06-24', NULL, NULL, 3, 4),
(13, 'Strapontin en bois verni et bronze\r\n', 'Découvrez notre strapontin rabattable, un savant mélange d\'élégance, de fonctionnalité et d\'économie d\'espace. Ce siège ingénieux allie une assise en bois de hêtre huilé à un mécanisme de pliage en bronze, offrant ainsi un mariage parfait entre le charme naturel du bois et la robustesse du métal.\r\n\r\nGrâce à son design astucieux, ce strapontin se fixe aisément à la verticale sur n\'importe quelle cloison, que ce soit dans une petite entrée, un couloir ou même une chambre à coucher. Lorsque l\'espace est précieux, notre siège rabattable se replie en un clin d\'œil à l\'aide de la poignée en bronze, libérant ainsi de la place lorsque vous en avez besoin.', 238.00, 'https://www.la-laitonnerie.com/4911-large_default/siege-table-carte-rabattable-bois-bronze.jpg', 8, '2024-07-01', NULL, NULL, 2, 1),
(14, 'Strapontin automatique AllHall Twist mélaminé anthracite', '\r\nLe strapontin automatique AllHall Twist mélaminé anthracite est un siège pliable de haute qualité, idéal pour les espaces restreints. Avec des dimensions de 26,5 cm de hauteur, 41 cm de largeur, et une profondeur allant de 15,5 cm à 42 cm, il est compact et pratique. Conçu avec un entraxe horizontal de 366 mm et un entraxe vertical de 184 mm pour le perçage, il se fixe facilement sur divers supports. Fabriqué en acier robuste et en assise multipli mélaminé, ce strapontin supporte une charge maximale de 200 kg. Il dispose d\'un mécanisme automatique basé sur la gravité et le contrepoids, garantissant une utilisation toujours silencieuse. Marqué et designé par AllHall, ce produit fabriqué en Pologne est livré avec un gabarit de montage, et est disponible en stock pour une livraison rapide.', 415.00, 'https://strapontin-store.com/wp-content/uploads/2019/06/strapontins-automatique-sans-dossier-twist-tps1-ferme-anthracite-anthracite-825x550.jpg', 3, '2024-07-01', NULL, NULL, 3, 6),
(15, 'Strapontin automatique Essem Design Jaxon assise pleine, blanc', 'Le strapontin automatique Essem Design Jaxon, avec son assise pleine en blanc, allie élégance et fonctionnalité. Ses dimensions sont optimisées pour un usage pratique : une largeur de 362 mm, une hauteur de 400 mm lorsqu\'il est plié, et une profondeur de 93 mm plié et 330 mm déplié. Conçu pour une installation facile, il offre plusieurs options d\'entraxe horizontal pour le perçage : 340 mm, 268 mm et 290 mm. Fabriqué avec des matériaux de qualité tels que le bouleau peint et l\'acier inoxydable, il supporte une charge maximale de 150 kg. Son mécanisme automatique repose sur un système de ressort, bien que son fonctionnement puisse occasionnellement produire un claquement. Ce produit signé Essem Design est fabriqué en Suède et est disponible en stock pour une livraison rapide.', 466.00, 'https://strapontin-store.com/wp-content/uploads/2016/11/strapontin-automatique-essem-design-jaxon-blanc-packshot-825x550.jpg', 6, '2024-07-01', NULL, NULL, 2, 1),
(16, 'Strapontin automatique AllHall Twist Plus mélaminé anthracite avec rembourrage\r\n', '\r\nLe strapontin automatique AllHall Twist Plus mélaminé anthracite avec rembourrage combine confort et robustesse. Ses dimensions pratiques incluent une hauteur de 44 cm, une largeur de 41 cm, et une profondeur de 12 cm plié à 42 cm déplié. Doté d\'un entraxe horizontal de 320 mm et de deux options d\'entraxe vertical (155 mm et 170 mm), il s\'installe facilement sur divers supports. Ce modèle pèse 8,05 kg et est fabriqué avec de l\'acier laqué epoxy et du multipli de 10 mm en mélaminé anthracite, supportant une charge maximale de 200 kg. Son mécanisme automatique utilise un vérin à gaz et un amortisseur, garantissant un fonctionnement toujours silencieux. Designé par AllHall, ce produit est fabriqué en Pologne et est livré avec un gabarit de montage. La livraison est prévue sous 5 à 7 semaines.', 610.00, 'https://strapontin-store.com/wp-content/uploads/2016/11/strapontin-automatique-allhall-twist-plus-packshot-graphite-graphite-graphite-solo-825x550.jpg', 8, '2024-07-01', NULL, NULL, 2, 3),
(17, 'Strapontin automatique AllHall Twist plaqué chêne', '\r\nLe strapontin automatique AllHall Twist plaqué chêne allie élégance et durabilité, parfait pour les espaces restreints. Ses dimensions sont de 26,5 cm de hauteur, 41 cm de largeur, et une profondeur de 15,5 cm plié à 42 cm déplié. Conçu avec un entraxe horizontal de 366 mm et un entraxe vertical de 184 mm pour le perçage, il est facile à installer. Fabriqué en acier robuste et doté d\'une assise en multipli mélaminé plaqué chêne, il peut supporter jusqu\'à 200 kg. Son mécanisme automatique fonctionne par gravité et contrepoids, garantissant un usage toujours silencieux. Ce modèle, conçu et fabriqué par AllHall en Pologne, est disponible en stock et livré avec un gabarit de montage pour une installation aisée.', 415.00, 'https://strapontin-store.com/wp-content/uploads/2019/06/strapontins-automatique-sans-dossier-twist-tps1-ouvert-chene-blanc-825x550.jpg', 4, '2024-07-01', NULL, NULL, 3, 4),
(18, 'Strapontin mural stade robuste intérieur extérieur - SMO\r\n', 'Strapontin mural rabattable pour intérieur et extérieur, ce produit est entièrement adaptable à tous les types de supports. Il vous sera possible de choisir le nombre de points d’ancrage entre 1 et 6. Vous pourrez tout autant installer ce siège sur du bois, du béton ou du métal. \r\n\r\nLes assises sont composées d’une structure en polyamide renforcée qui en font un produit extrêmement fiable et solide. Ce dernier peut être utilisé dans tous les lieux grand public, comme dans le milieu sportif, mais aussi dans des laboratoires de radiologie et d\'examens médicaux, les cabines d\'essayage de vêtements, les grandes surfaces commerciales… \r\n\r\nAvec ce strapontin, vous aurez le droit à un produit durable, fait dans des normes très précises lui permettant une résistance à toute épreuve :\r\n\r\nClasse 1 résistance au feu (UN) : polypropylène ignifugé M2.\r\nCertifié ISO 9001 2015 pour la pose en stade\r\nMécaniquement conforme aux normes Européennes\r\nRésistance aux UV conforme aux normes Européennes\r\nMarquage ISO 11456 2011 de l’UE – produit 100 % recyclable et répondant aux critères minimum environnementaux (CAM)\r\n\r\nLe design moderne et les coloris disponibles assurent également une esthétique conviviale dans tous les espaces. Ce siège pour stades ou espaces intérieurs est l’un des plus pratiques en plus de sa robustesse. En effet, replié il n’occupe que 30 cm de profondeur dans votre espace ce qui permet aux passants d’avoir toute la place nécessaire pour se déplacer librement.\r\n\r\nAucune partie métal n’est apparente, ce qui, en cas d’installation à l’extérieur permet d’accepter une forte humidité ambiante. Toutes les parties métalliques servent à renforcer la structure interne du strapontin mural.', 629.00, 'https://www.rdbureau.com/photo/2543_1646577258.jpg', 10, '2024-07-01', NULL, NULL, 3, 5),
(19, 'Siège rabattable en métal 2 ou 3 places - AL\r\n', 'Le siège rabattable en métal est disponible en deux variantes : 2 ou 3 places. Selon vos besoins vous pourrez donc aménager votre pièce comme vous l’entendez. Les deux modèles sont identiques en matière de fixation, de tenue et d’assise.\r\nL’assise de ce type de strapontin est entièrement rabattable ce qui permet un gain de place évident et une rangement facilité si vous souhaitez aérer la pièce dans laquelle se trouve les sièges. L’articulation des sièges est renforcée par deux bagues épaulées en acier de manière à assurer leur durabilité. L\'assise et le dossier sont soudés sur la structure pour plus de robustesse et de solidité.\r\n\r\nLes sièges sont en acier époxy traité anti-rayure et disponibles dans 46 coloris que vous pourrez librement choisir lors de votre commande. Il s’agit d’un produit facilement lavable puisqu’il est propre en passant simplement un coup de chiffon avec du désinfectant par exemple.\r\n\r\nFauteuil pour salle d’attente ou chaise sur poutre d’appoint pour salle de réunion, le siège rabattable peut être utile dans de nombreuses situations. Idéal pour les couloirs, les lieux publics et autres salles de réception, grâce à ses assises rabattables il prend peu de place ! Il sera également l’allié de tous les cabinets où de nombreux clients ou patients viendront s’asseoir.\r\n\r\nCe module de 2 ou 3 sièges en tôle perforée peut se poser sur le sol ou se fixer au sol, les pattes de fixation sont comprises dans la livraison. En version fixée au sol, ce produit est un bon choix pour des sièges supplémentaires en amphithéâtre.\r\n\r\nIls sont classifiés Norme AM18, et sont donc conformes au règlement de sécurité contre l\'incendie dans les E.R.P.', 648.00, 'https://www.rdbureau.com/photo/1622974838.jpg', 6, '2024-07-01', NULL, NULL, 2, 3),
(20, 'Strapontin de douche profilo avec pieds de soutien', 'Ce strapontin de douche vous offre une assise confortable et sécurisante lors de la douche. Il se relève contre le mur pour laisser l\'espace aux autres occupants du logement ou pour accéder plus facilement au bac à douche.', 179.00, 'https://www.aidealautonomie.net/80721-pdt_540/strapontin-de-douche-profilo-avec-pieds-de-soutien.jpg', 12, '2024-07-01', NULL, NULL, 2, 1),
(21, 'Siège de douche relevable lagon confort', 'Notre siège de douche relevable permet de prendre votre douche en tout confort.\r\nIl est relevable au mur et permet de conserver l’espace de la douche aux autres utilisateurs.\r\nLes pieds sont réglables en hauteur pour choisir votre hauteur d’assise.\r\nLe strapontin relevable bénéficie de coussins en mousse polyuréthane souple sur l’assise.\r\n\r\nCaractéristiques techniques :\r\nSiège en plastique sans effet froid\r\nStructure aluminium anti-corrosion\r\nAssise sans effet froid\r\nRelevable au mur\r\n\r\nDimensions :\r\nDimensions hors-tout siège : larg. 46 x prof. 54,6 x haut. 45/57 cm\r\nDimensions assise : larg. 46 x prof. 38 x haut.45/57 cm', 129.00, 'https://www.aidealautonomie.net/80651-pdt_540/siege-de-douche-relevable-lagon-confort.jpg', 13, '2024-07-01', NULL, NULL, 2, 1),
(22, 'Strapontin en SKAI gris rabattable avec dossier', 'Le strapontin en skaï gris rabattable avec dossier, modèle Pino 310, offre une solution pratique et élégante pour les sièges passagers. Ce strapontin est équipé d\'un mécanisme de rabattement par vérin à gaz, facilitant son utilisation. Il peut être fixé soit sur une cloison, soit sur une embase au sol, offrant une grande flexibilité d\'installation. Ce siège est doté d\'un dossier pour un confort accru. Pesant 12,69 kg, il mesure 500 mm de hauteur, 420 mm de largeur, et 480 mm de longueur. Ce produit ne présente aucun risque de matières dangereuses et est livré avec un poids total de 14 kg.', 320.00, 'https://www.seimi-equipements-marine.com/IMG/strapontin-skai-gris-rabattable-61212.jpg', 8, '2024-07-01', NULL, NULL, 3, 5),
(23, 'Siège rabattable en acier inoxydable accessible aux personnes à mobilité réduite', 'Le siège pliant en acier inoxydable est une aide précieuse pour les espaces extérieurs accessibles. Il se monte avec huit vis sur une paroi et peut supporter une charge allant jusqu\'à 120 kg. Lorsqu\'il n\'est pas utilisé, il peut être replié, ce qui le rend peu encombrant. Fabriqué avec des tubes en acier inoxydable de 1,5 mm d\'épaisseur et d\'un diamètre de 25 mm, ce siège est à la fois robuste et durable. La plaque de base de 3 mm d\'épaisseur, dotée de quatre ouvertures pour les vis, est entièrement soudée au support solide du siège pliant. La surface d\'assise est constituée de panneaux en acier inoxydable. La livraison inclut des vis en acier inoxydable, des écrous borgnes et des chevilles pour une fixation murale sécurisée. Dans notre boutique spécialisée en équipements accessibles, nous proposons une large gamme de sièges et de barres d\'appui en acier inoxydable et en acier revêtu par poudre, avec des diamètres de tube de 25 et 32 mm. Tous nos produits sont conçus et fabriqués conformément aux normes européennes pour les espaces accessibles. Nous prenons en compte toutes les particularités et possibilités des espaces extérieurs lors de la conception, en nous basant sur des principes d\'ergonomie et d\'esthétique.', 337.00, 'https://static5.redcart.pl/templates/images/thumb/8090/800/9999/de/0/templates/images/products/8090/291982100b575170e41487b93899ce5a.png', 2, '2024-07-01', NULL, NULL, 3, 6),
(24, 'Double Strapontin Fibrocit Diva des Années 1950', 'Découvrez le charme rétro du double strapontin rabattable circa 1950, un bijou d\'époque signé par la marque renommée Fibrocit. Modèle Diva, ces sièges emblématiques ont fait leur renommée dans les cinémas de quartier, où ils accueillaient les cinéphiles pour des séances inoubliables.\r\n\r\nCaractéristiques Techniques\r\nDimensions : Hauteur 80 cm x Largeur 125 cm x Profondeur 40 cm\r\nMatériaux :\r\nStructure : Solide et durable, la structure est entièrement en acier, assurant une longue durée de vie et une stabilité à toute épreuve.\r\nAssise et Dossier : Conçus en bois, l\'assise et le dossier offrent un confort classique et intemporel, tout en ajoutant une touche chaleureuse au design industriel de l\'acier.\r\nMécanisme : Le système de rabattement permet de gagner de l\'espace lorsqu\'il n\'est pas utilisé, rendant ce double strapontin pratique et fonctionnel pour les petits espaces.\r\nDesign et Esthétique\r\nLe modèle Diva se distingue par son esthétique vintage et son allure robuste. Les lignes épurées de la structure en acier contrastent élégamment avec la chaleur du bois, créant une pièce à la fois fonctionnelle et décorative. Ce double strapontin s\'intègre parfaitement dans des décors vintage, industriels ou même modernes, apportant une touche de nostalgie et d\'authenticité.\r\n\r\nHistoire et Utilisation\r\nAu cœur des années 1950, ces strapontins étaient le choix privilégié des cinémas de quartier, offrant une solution d\'assise compacte et confortable pour les spectateurs. Aujourd\'hui, ils peuvent être utilisés dans divers contextes : aménagement de home cinéma, décoration de cafés vintage, ou encore comme pièce maîtresse dans un loft industriel.\r\n\r\nRestauration et Entretien\r\nConservé dans son état d\'origine ou restauré avec soin, le double strapontin Fibrocit Diva peut être réhabilité pour retrouver tout son éclat. L\'entretien est simple : un dépoussiérage régulier et l\'application de produits adaptés pour le bois et l\'acier suffiront à préserver sa beauté et sa fonctionnalité.', 622.00, 'https://www.orangemetalic.fr/wp-content/uploads/2020/05/strapontins.jpg', 1, '2024-07-01', NULL, NULL, 3, 4),
(25, 'Strapontin enfant couleur bleu Houdaille SecureInternship', 'Découvrez le réducteur WC enfant Houdaille SecureInternship, au design simple et excellent, offrant une expérience d\'utilisation supérieure. Ce réducteur WC bébé est entièrement neuf et garantit une qualité irréprochable. Il accompagne parfaitement la nouvelle phase d\'apprentissage de l\'hygiène et de la première toilette pour les enfants. Fabriqué à partir de matériaux respectueux de l\'environnement, il prend soin de la peau sensible des enfants et ne contient aucun ingrédient dangereux. Idéal pour aider vos enfants à apprendre la propreté de manière autonome et confortable !\r\n\r\nCaractéristiques :\r\n\r\nTranches d\'âge : 7-9 mois, 13-18 mois, 19-24 mois, 2-3 ans\r\nType : Potties\r\nMotif : Animal\r\nMatériau : écologique PP\r\nHauteur : Réglable\r\nCaractéristique : pot de pliage à échelle\r\nFonction : Apprentissage de la propreté pour bébé\r\nTaille du produit : 37 * 38 * 59 cm\r\nCouleurs disponibles : Rose, Bleu\r\nOptez pour le réducteur WC Houdaille SecureInternship pour accompagner en douceur et en sécurité l\'apprentissage de la propreté de votre enfant.', 12.00, 'https://m.media-amazon.com/images/I/51dREO6gI-L._AC_SL1000_.jpg', 1, '2024-07-01', NULL, NULL, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `id_subcategory` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id_subcategory`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `registerdate` date NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `password`, `adresse`, `city`, `postcode`, `tel`, `registerdate`) VALUES
(1, 'alex', 'alex', 'alex@alex.fr', 'azerty', '10 ancienne rte de marseille', 'martigues', '13500', '', '0000-00-00'),
(3, 'asmaa', 'asmaa', 'asmaa@asmaa.fr', 'a', '', '', '', '', '0000-00-00'),
(5, 'tom', 'tom', 'tom@tom.fr', '$2y$10$XyPYkZermSmo/hyQCMmhQOvp/Q1qMXkd0WqMRFP1RmEIASuuZcyvC', 'tom', 'tom', '13400', '03928491', '2024-06-28');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
