-- Nouvelle table à créer dans les bases de données spécifiques à chaque SIS

CREATE TABLE `Telephone` (
  `TEL_ID` int(11) NOT NULL,
  `TEL_Numero` varchar(20) NOT NULL,
  `TEL_Designation` varchar(255) NOT NULL,
  `TEL_Tri` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Telephone`
--
ALTER TABLE `Telephone`
  ADD PRIMARY KEY (`TEL_ID`);

ALTER TABLE `Telephone`
  MODIFY `TEL_ID` int(11) NOT NULL AUTO_INCREMENT;

-- Nouveaux droits
ALTER TABLE `Users` ADD `USER_GestTranfertApp` TINYINT NULL DEFAULT '0' COMMENT 'Gestion des transferts de l\'application mobile' AFTER `USER_GestDecompte`;
ALTER TABLE `Users` ADD `USER_GestPresenceExeApp` TINYINT NULL DEFAULT '0' COMMENT 'Gestion des présences aux exercices de l\'application mobile' AFTER `USER_GestTranfertApp`;
ALTER TABLE `Users` ADD `USER_GestRapportInterApp` TINYINT NULL DEFAULT '0' COMMENT 'Gestion des rapports d\'intervention de l\'application mobile' AFTER `USER_GestPresenceExeApp`;
