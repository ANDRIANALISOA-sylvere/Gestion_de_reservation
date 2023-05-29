-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 04 avr. 2023 à 10:42
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservation`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `mdp` varchar(50) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`mdp`, `nom`, `prenom`, `email`) VALUES
('kelly', 'ANDRIAMAMPINDRY', 'Kelly Alphador', 'kelly@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idcli` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `numtel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE `place` (
  `place` int(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `idvoit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `idreserv` varchar(255) NOT NULL,
  `idvoit` varchar(255) NOT NULL,
  `idcli` int(50) NOT NULL,
  `place` int(40) NOT NULL,
  `date_reserv` datetime NOT NULL,
  `date_voyage` date NOT NULL,
  `payement` varchar(30) NOT NULL,
  `montant_avance` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `idvoit` varchar(255) NOT NULL,
  `design` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `nbrplace` int(255) NOT NULL,
  `frais` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`mdp`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idcli`);

--
-- Index pour la table `place`
--
ALTER TABLE `place`
  ADD KEY `idvoit` (`idvoit`);

--
-- Index pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD PRIMARY KEY (`idreserv`),
  ADD KEY `idvoit` (`idvoit`),
  ADD KEY `idcli` (`idcli`),
  ADD KEY `place` (`place`),
  ADD KEY `idvoit_2` (`idvoit`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`idvoit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idcli` int(255) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`idvoit`) REFERENCES `voiture` (`idvoit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD CONSTRAINT `reserver_ibfk_1` FOREIGN KEY (`idcli`) REFERENCES `client` (`idcli`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserver_ibfk_2` FOREIGN KEY (`idvoit`) REFERENCES `voiture` (`idvoit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
