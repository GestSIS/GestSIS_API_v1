-- Passe en table en InnoDB pour pouvoir créer les jointures correctement
ALTER TABLE SIS ENGINE=InnoDB;

--
-- Structure de la table `Transfert_App`
--

CREATE TABLE `Transfert_App` (
  `TRA_ID` int(11) NOT NULL,
  `TAC_ID` int(11) NOT NULL,
  `SIS_ID` int(10) UNSIGNED NOT NULL,
  `TRA_Designation` varchar(255) NOT NULL,
  `TRA_Contenu` mediumtext NOT NULL,
  `TRA_Date_Creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TRA_Date_Reception` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Transfert_App_Cat`
--

CREATE TABLE `Transfert_App_Cat` (
  `TAC_ID` int(11) NOT NULL,
  `TAC_Designation` varchar(255) NOT NULL,
  `TAC_Code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `Transfert_App_Cat`
--

INSERT INTO `Transfert_App_Cat` (`TAC_ID`, `TAC_Designation`, `TAC_Code`) VALUES
(1, 'Rapport d\'intervention', 'rapport-intervention'),
(2, 'Présences à un exercice', 'presences-exercice');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Transfert_App`
--
ALTER TABLE `Transfert_App`
  ADD PRIMARY KEY (`TRA_ID`),
  ADD KEY `IND_TRA_TAC_ID` (`TAC_ID`),
  ADD KEY `IND_TRA_SIS_ID` (`SIS_ID`);

--
-- Index pour la table `Transfert_App_Cat`
--
ALTER TABLE `Transfert_App_Cat`
  ADD PRIMARY KEY (`TAC_ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Transfert_App`
--
ALTER TABLE `Transfert_App`
  MODIFY `TRA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table `Transfert_App_Cat`
--
ALTER TABLE `Transfert_App_Cat`
  MODIFY `TAC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Transfert_App`
--
ALTER TABLE `Transfert_App`
  ADD CONSTRAINT `Transfert_App_ibfk_2` FOREIGN KEY (`SIS_ID`) REFERENCES `SIS` (`SIS_ID`),
  ADD CONSTRAINT `Transfert_App_ibfk_1` FOREIGN KEY (`TAC_ID`) REFERENCES `Transfert_App_Cat` (`TAC_ID`);
