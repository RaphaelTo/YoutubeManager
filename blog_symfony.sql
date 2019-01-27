-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  Dim 27 jan. 2019 à 15:30
-- Version du serveur :  10.3.12-MariaDB-log
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `name`, `date_publication`, `user_id`, `content`) VALUES
(2, 'Le nouveau article sur one piece', '2019-01-10 09:41:00', NULL, 'One piece pourrait etre l\'un des meilleurs manga s\'il n\'était pas aussi loong'),
(3, 'Le deuxieme article', '2019-01-11 12:09:00', 3, 'Blabla vive la france'),
(4, 'Le nouveau article sur naruto', '2019-01-11 18:34:00', 7, 'Naruto c\'est nul'),
(6, 'Le nouveau article sur naruto shippu', '2019-01-11 18:38:00', 7, 'Naruto c\'est nul part 2');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `birthday`, `roles`, `password`) VALUES
(3, 'Kevin', 'Leau', 'razer-raphael@live.fr', '2018-06-03 00:00:00', 'ROLE_USER', '$2y$13$U9Z.MCv5uKYQf5iVZyImsu/Beaa7GdYKu5SHEYyViCGXw5oLjIqRC'),
(4, 'Cathareeya', 'privée', 'catahreeya.v@gmail.com', '2018-09-15 00:00:00', 'ROLE_USER', '$2y$13$hDHtAkEO57SUhHyoRE7MreW7EB7HRAoRY6Ox2mgeE6A2Iv/6ZLEW.'),
(7, 'Raphael', 'Torres Paiva', 'paiva.raphaelt@gmail.com', '1997-03-09 00:00:00', 'ROLE_ADMIN', '$2y$13$IFdBipb85vtqEDGb/fXvaOQvBtMv.6csrYA83INHaMd5mDOo6g.qC'),
(8, NULL, NULL, 'admin@admin.com', NULL, 'ROLE_USER,ROLE_ADMIN', '$2y$13$EDSSODFCJ8kQzlW0JHHQjO1okOfekoczjQIlD4C9moXmc5AATxVYu'),
(9, 'Spircoco', 'Thibault', 'datemail@gmail.com', '1998-12-03 00:00:00', 'ROLE_USER', '$2y$13$Zfiu7eIe/aTJcHPtGr8MHeWn.9y3khIbqstAq1B5s4vMijgENUo3a'),
(10, 'Mayers', 'videl', 'dbz_con@gmail.com', '1997-03-09 00:00:00', 'ROLE_USER', '$2y$13$c4JswqM0.OPnuPxwmNOJEuZ25uS71q9uf0m6B9BdNShykTTm3Ve6S'),
(11, 'Testons', 'Efficacite', 'testeons@gmail.com', '1969-03-01 00:00:00', 'ROLE_USER', '$2y$13$mklV3YfO9SUnmfO4u1NTL.i5vH6OWOsjMnPKhFl5/vSDEh9Kq2GzW'),
(13, 'Patrick', 'Martin', 'dryssboss@live.fr', '2005-05-09 00:00:00', 'ROLE_USER', '$2y$13$2zfQE11sJ3zmbeKMHnPfruGGXpo1ncs/gwSrqa5cf8SSggprDsNHC'),
(14, 'Saucissons', 'sec', 'sticksaucissonssecs@live.fr', '1899-01-01 00:00:00', 'ROLE_USER', '$2y$13$fHkmWKsWljSVpz5dR9CVBeZaGPEsfOlGuEt.ScN1tliJ2twkMnHiO');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_23A0E665E237E06` (`name`),
  ADD KEY `IDX_23A0E66A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
