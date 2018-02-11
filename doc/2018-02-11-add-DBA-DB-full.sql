--
-- Structure de la table `Base_Donnees`
--

CREATE TABLE `Base_Donnees` (
  `BDO_ID` int(10) UNSIGNED NOT NULL,
  `BDO_Host` varchar(255) NOT NULL,
  `BDO_Port` int(10) NOT NULL,
  `BDO_User` text NOT NULL,
  `BDO_PWD` text NOT NULL,
  `BDO_Nom` varchar(255) NOT NULL,
  `BDO_Charset` varchar(255) NOT NULL,
  `BDO_Collation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `Base_Donnees`
  ADD PRIMARY KEY (`BDO_ID`);

ALTER TABLE `Base_Donnees`
  MODIFY `BDO_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Passe en table en InnoDB pour pouvoir créer les jointures correctement
ALTER TABLE SIS ENGINE=InnoDB;
alter table SIS add column SIS_Actif boolean;
alter table SIS add column BDO_ID int(10) unsigned default null;
alter table SIS add column SIS_URL text default NULL;
ALTER TABLE SIS add column SIS_Mobile boolean DEFAULT 0;
ALTER TABLE SIS ADD INDEX `IND_SIS_BDO_ID` (`BDO_ID`);
ALTER TABLE `SIS` ADD CONSTRAINT `CTR_FK_SIS_BDO_ID` FOREIGN KEY (`BDO_ID`) REFERENCES `Base_Donnees`(`BDO_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;


--
-- Structure de la table `Log_Cat`
--

CREATE TABLE `Log_Cat` (
  `LCA_ID` int(10) UNSIGNED NOT NULL,
  `LCA_Code` varchar(50) NOT NULL,
  `LCA_Limit` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Log_Cat` (`LCA_ID`, `LCA_Code`, `LCA_Limit`) VALUES
(1, 'login-fail', 100),
(2, 'login-success', NULL),
(3, 'create-account-fail', 50),
(4, 'activate-account-fail', 50),
(5, 'create-account-success', NULL),
(6, 'activate-account-success', NULL);

ALTER TABLE `Log_Cat`
  ADD PRIMARY KEY (`LCA_ID`);

ALTER TABLE `Log_Cat`
  MODIFY `LCA_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Structure de la table `Log`
--

CREATE TABLE `Log` (
    `LOG_ID` int(10) UNSIGNED NOT NULL,
    `LOG_IP` varchar(255) DEFAULT NULL,
    `LOG_Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `LCA_ID` int(10) UNSIGNED DEFAULT NULL,
    `LOG_Details` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `Log`
ADD PRIMARY KEY (`LOG_ID`),
ADD KEY `LCA_ID` (`LCA_ID`);

ALTER TABLE `Log`
MODIFY `LOG_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `Log`
ADD CONSTRAINT `CTR_FK_LOG_LCA_ID` FOREIGN KEY (`LCA_ID`) REFERENCES `Log_Cat` (`LCA_ID`);

-- Mise a jour des données par SIS
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=0;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='hs.gestsis.ch' WHERE SIS_ID=11;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='6-12.gestsis.ch' WHERE SIS_ID=12;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='haut-plateau.gestsis.ch' WHERE SIS_ID=15;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='val-terbi.gestsis.ch' WHERE SIS_ID=16;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='vendline.gestsis.ch' WHERE SIS_ID=21;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='cdd.gestsis.ch' WHERE SIS_ID=22;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='calabri.gestsis.ch' WHERE SIS_ID=23;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='basse-allaine.gestsis.ch' WHERE SIS_ID=24;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='mont-terri.gestsis.ch' WHERE SIS_ID=25;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='la-baroche.gestsis.ch' WHERE SIS_ID=26;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='fmo.gestsis.ch' WHERE SIS_ID=31;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='fmc.gestsis.ch' WHERE SIS_ID=32;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=41;
UPDATE SIS SET SIS_ACTIF=1, SIS_URL='valdor.gestsis.ch' WHERE SIS_ID=51;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=55;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=96;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=97;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=98;
UPDATE SIS SET SIS_ACTIF=0 WHERE SIS_ID=99;

--
-- Structure de la table `Transfert_App`
--
CREATE TABLE `Transfert_App` (
  `TRA_ID` int(11) NOT NULL,
  `TAC_ID` int(11) NOT NULL,
  `SIS_ID` int(10) UNSIGNED NOT NULL,
  `TRA_Designation` varchar(255) NOT NULL,
  `TRA_Contenu` mediumtext NOT NULL,
  `TRA_Reference` varchar(255) DEFAULT NULL,
  `TRA_Complet` tinyint(1) NOT NULL,
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
  ADD CONSTRAINT `CTR_FK_TRA_TAC_ID` FOREIGN KEY (`TAC_ID`) REFERENCES `Transfert_App_Cat` (`TAC_ID`),
  ADD CONSTRAINT `CTR_FK_TRA_SIS_ID` FOREIGN KEY (`SIS_ID`) REFERENCES `SIS` (`SIS_ID`);


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
