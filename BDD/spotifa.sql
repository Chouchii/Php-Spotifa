-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 12 fév. 2019 à 15:46
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `spotifa`
--

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(200) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `date` int(200) NOT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `album`
--

INSERT INTO `album` (`id_album`, `title`, `date`) VALUES
(1, 'Album1', 2001),
(2, 'Album2', 2010),
(3, 'Album3', 2006),
(4, 'Album4', 2008),
(5, 'Album5', 2005),
(6, 'Album6', 2002),
(7, 'Album7', 2009),
(8, 'Album8', 2008),
(9, 'Album9', 2009),
(10, 'Album10', 2015);

-- --------------------------------------------------------

--
-- Structure de la table `artists`
--

DROP TABLE IF EXISTS `artists`;
CREATE TABLE IF NOT EXISTS `artists` (
  `id_artist` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `age` int(3) NOT NULL,
  PRIMARY KEY (`id_artist`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `artists`
--

INSERT INTO `artists` (`id_artist`, `nom`, `gender`, `age`) VALUES
(1, 'Saez', 'Homme', 41),
(2, 'Orelsan', 'Homme', 36),
(3, 'Agnes obel', 'Femme', 38),
(4, 'Gerald de palmas', 'Homme', 51),
(5, 'Jose gonzalez', 'Homme', 40);

-- --------------------------------------------------------

--
-- Structure de la table `liked`
--

DROP TABLE IF EXISTS `liked`;
CREATE TABLE IF NOT EXISTS `liked` (
  `id_song` int(11) NOT NULL,
  `ref_user` int(11) NOT NULL,
  KEY `id_song` (`id_song`),
  KEY `ref_user` (`ref_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
CREATE TABLE IF NOT EXISTS `playlists` (
  `id_playlist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `creation_date` varchar(255) NOT NULL,
  `ref_user` int(11) NOT NULL,
  PRIMARY KEY (`id_playlist`),
  KEY `fk_ref_user` (`ref_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `playlists`
--

INSERT INTO `playlists` (`id_playlist`, `name`, `creation_date`, `ref_user`) VALUES
(1, 'rap', '2019', 3),
(5, 'herere', '2019', 4);

-- --------------------------------------------------------

--
-- Structure de la table `playlist_content`
--

DROP TABLE IF EXISTS `playlist_content`;
CREATE TABLE IF NOT EXISTS `playlist_content` (
  `id_playlist` int(11) NOT NULL,
  `id_song` int(11) NOT NULL,
  KEY `fk_id_playlist` (`id_playlist`),
  KEY `fk_id_song` (`id_song`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `playlist_content`
--

INSERT INTO `playlist_content` (`id_playlist`, `id_song`) VALUES
(1, 2),
(1, 1),
(5, 16),
(1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `id_song` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `id_artist` int(11) NOT NULL,
  `id_album` int(11) NOT NULL,
  PRIMARY KEY (`id_song`),
  KEY `id_artist` (`id_artist`),
  KEY `id_album` (`id_album`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `songs`
--

INSERT INTO `songs` (`id_song`, `titre`, `release_date`, `id_artist`, `id_album`) VALUES
(1, 'La pluie', '2017', 2, 1),
(2, 'La terre est ronde', '2011', 2, 1),
(3, 'Putain vous m\'aurez plus', '2008', 1, 2),
(4, 'Jeune et con', '1999', 1, 2),
(5, 'Tout va bien', '2017', 2, 1),
(6, 'Changement', '2009', 2, 8),
(7, 'Pilule', '2010', 1, 9),
(8, 'A ton nom', '2002', 1, 9),
(9, 'Heartbeats', '2003', 5, 3),
(10, 'Familliar', '2016', 3, 4),
(11, 'Une seule vie', '2000', 4, 5),
(12, 'Teardrop', '2007', 5, 3),
(13, 'Elle s\'ennuie', '2002', 4, 6),
(14, 'Crosses', '2003', 5, 6),
(15, 'The curse', '2013', 3, 4),
(16, 'Far away', '2010', 5, 3),
(17, 'Brother sparrow', '2011', 3, 10),
(18, 'Au paradis', '2004', 4, 5),
(19, 'Riverside', '2011', 3, 10),
(20, 'Il faut qu\'on s\'batte', '2016', 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ref_user` int(5) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ref_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ref_user`, `pseudo`, `address`, `mail`, `phone`, `mdp`) VALUES
(3, 'Amelie', '2 rue des plantes', 'amelie@mail.fr', 123456, '25f9e794323b453885f5181f1b624d0b'),
(4, 'Ame', '1 rue de la plage', 'ame@gmail.fr', 789456123, '202cb962ac59075b964b07152d234b70');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `liked`
--
ALTER TABLE `liked`
  ADD CONSTRAINT `id_song` FOREIGN KEY (`id_song`) REFERENCES `songs` (`id_song`),
  ADD CONSTRAINT `ref_user` FOREIGN KEY (`ref_user`) REFERENCES `users` (`ref_user`);

--
-- Contraintes pour la table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `fk_ref_user` FOREIGN KEY (`ref_user`) REFERENCES `users` (`ref_user`);

--
-- Contraintes pour la table `playlist_content`
--
ALTER TABLE `playlist_content`
  ADD CONSTRAINT `fk_id_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `playlists` (`id_playlist`),
  ADD CONSTRAINT `fk_id_song` FOREIGN KEY (`id_song`) REFERENCES `songs` (`id_song`);

--
-- Contraintes pour la table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `fk_id_album` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `fk_id_artist` FOREIGN KEY (`id_artist`) REFERENCES `artists` (`id_artist`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
