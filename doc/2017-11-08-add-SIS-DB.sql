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
