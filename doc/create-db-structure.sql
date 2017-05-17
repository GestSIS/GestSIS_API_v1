-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mer 17 Mai 2017 à 20:12
-- Version du serveur :  5.5.54-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `sishs_webgestsis`
--

-- --------------------------------------------------------

--
-- Structure de la table `BASE_DONNEES`
--

CREATE TABLE `BASE_DONNEES` (
  `BDO_PK` int(11) NOT NULL,
  `BDO_HOST` varchar(255) NOT NULL,
  `BDO_PORT` int(11) NOT NULL,
  `BDO_USER` text NOT NULL,
  `BDO_PWD` text NOT NULL,
  `BDO_NOM` varchar(255) NOT NULL,
  `BDO_CHARSET` varchar(255) NOT NULL,
  `BDO_COLLATION` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `LOG`
--

CREATE TABLE `LOG` (
  `LOG_PK` int(11) NOT NULL,
  `LOG_IP` varchar(255) NOT NULL,
  `LOG_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LOG_LCA_FK` int(11) NOT NULL,
  `LOG_DETAILS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `LOG_CATEGORIE`
--

CREATE TABLE `LOG_CATEGORIE` (
  `LCA_PK` int(11) NOT NULL,
  `LCA_CODE` varchar(255) NOT NULL,
  `LCA_LIMITE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `SIS`
--

CREATE TABLE `SIS` (
  `SIS_PK` int(11) NOT NULL,
  `SIS_NOM` varchar(255) NOT NULL,
  `SIS_ACTIF` tinyint(1) NOT NULL,
  `SIS_BDO_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `BASE_DONNEES`
--
ALTER TABLE `BASE_DONNEES`
  ADD PRIMARY KEY (`BDO_PK`);

--
-- Index pour la table `LOG`
--
ALTER TABLE `LOG`
  ADD PRIMARY KEY (`LOG_PK`),
  ADD KEY `FK_LOG_LOG_CATEGORIE` (`LOG_LCA_FK`);

--
-- Index pour la table `LOG_CATEGORIE`
--
ALTER TABLE `LOG_CATEGORIE`
  ADD PRIMARY KEY (`LCA_PK`);

--
-- Index pour la table `SIS`
--
ALTER TABLE `SIS`
  ADD PRIMARY KEY (`SIS_PK`),
  ADD KEY `FK_SIS_BASE_DONNEES` (`SIS_BDO_FK`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `BASE_DONNEES`
--
ALTER TABLE `BASE_DONNEES`
  MODIFY `BDO_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `LOG`
--
ALTER TABLE `LOG`
  MODIFY `LOG_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `LOG_CATEGORIE`
--
ALTER TABLE `LOG_CATEGORIE`
  MODIFY `LCA_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `SIS`
--
ALTER TABLE `SIS`
  MODIFY `SIS_PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `LOG`
--
ALTER TABLE `LOG`
  ADD CONSTRAINT `FK_LOG_LOG_CATEGORIE` FOREIGN KEY (`LOG_LCA_FK`) REFERENCES `LOG_CATEGORIE` (`LCA_PK`);

--
-- Contraintes pour la table `SIS`
--
ALTER TABLE `SIS`
  ADD CONSTRAINT `FK_SIS_BASE_DONNEES` FOREIGN KEY (`SIS_BDO_FK`) REFERENCES `BASE_DONNEES` (`BDO_PK`);
