-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 02 Janvier 2018 à 19:26
-- Version du serveur :  5.5.57-MariaDB
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `sishs_gestSIS`
--

-- --------------------------------------------------------

--
-- Structure de la table `API_Cle`
--

CREATE TABLE `API_Cle` (
  `APC_ID` int(11) NOT NULL,
  `SIS_ID` int(10) UNSIGNED NOT NULL,
  `APC_Client_ID` varchar(40) NOT NULL,
  `APC_Client_Secret` text NOT NULL,
  `APC_Date_Creation` timestamp NULL DEFAULT NULL,
  `APC_Date_Revocation` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `API_Cle_Role`
--

CREATE TABLE `API_Cle_Role` (
  `ACR_ID` int(11) NOT NULL,
  `APC_ID` int(11) NOT NULL,
  `APR_ID` int(11) NOT NULL,
  `ACR_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `API_Role`
--

CREATE TABLE `API_Role` (
  `APR_ID` int(11) NOT NULL,
  `APR_Code` varchar(255) NOT NULL,
  `APR_Designation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `API_Role`
--

INSERT INTO `API_Role` (`APR_ID`, `APR_Code`, `APR_Designation`) VALUES
(1, 'transfert_all', 'Gestion des transfert'),
(2, 'tache_all', 'Gestion des tâches'),
(3, 'document_read', 'Visualisation des documents'),
(4, 'effectif_read', 'Visualisation des effectifs'),
(5, 'effectif_all', 'Visualisation du détail des effectifs'),
(6, 'user_all', 'Gestion des utilisateurs'),
(7, 'tache_add', 'Ajout d\'une tâche'),
(8, 'materiel_read', 'Visualisation du matériel'),
(9, 'intervention_read', 'Visualisation des interventions'),
(10, 'agenda_read', 'Visualisation de l\'agenda'),
(11, 'exercice_read', 'Visualisation des exercices'),
(12, 'ctrl_med_read', 'Visualisation des contrôles médicaux'),
(13, 'tache_prioritaire_all', 'Gestion des tâches prioritaires'),
(14, 'entreprise_read', 'Visualisation des entreprises'),
(15, 'decompte_read', 'Visualisation des décomptes'),
(16, 'decompte_all', 'Gestion des décomptes');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `API_Cle`
--
ALTER TABLE `API_Cle`
  ADD PRIMARY KEY (`APC_ID`),
  ADD KEY `IND_APC_SIS_ID` (`SIS_ID`);

--
-- Index pour la table `API_Cle_Role`
--
ALTER TABLE `API_Cle_Role`
  ADD PRIMARY KEY (`ACR_ID`),
  ADD UNIQUE KEY `IND_UN_ACR_APC_APC_ID` (`APC_ID`,`APR_ID`),
  ADD KEY `IND_ACR_APR_ID` (`APR_ID`);

--
-- Index pour la table `API_Role`
--
ALTER TABLE `API_Role`
  ADD PRIMARY KEY (`APR_ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `API_Cle`
--
ALTER TABLE `API_Cle`
  MODIFY `APC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `API_Cle_Role`
--
ALTER TABLE `API_Cle_Role`
  MODIFY `ACR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `API_Role`
--
ALTER TABLE `API_Role`
  MODIFY `APR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `API_Cle`
--
ALTER TABLE `API_Cle`
  ADD CONSTRAINT `CTR_FK_APC_SIS_ID` FOREIGN KEY (`SIS_ID`) REFERENCES `SIS` (`SIS_ID`);

--
-- Contraintes pour la table `API_Cle_Role`
--
ALTER TABLE `API_Cle_Role`
  ADD CONSTRAINT `CTR_FK_ACR_APC_ID` FOREIGN KEY (`APC_ID`) REFERENCES `API_Cle` (`APC_ID`),
  ADD CONSTRAINT `CTR_FK_ACR_APR_ID` FOREIGN KEY (`APR_ID`) REFERENCES `API_Role` (`APR_ID`);
