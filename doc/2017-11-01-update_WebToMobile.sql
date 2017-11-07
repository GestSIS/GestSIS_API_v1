-- --------------------------------------------------------------------------------
-- Ajout des tables log/logCat/BaseDonnees/
-- Ainsi que mdofication de la table SIS, ajout de la colonne SIS_Actif, BDO_Id et SIS_Url
-- Note: boolean sera transforme en tinyint(1)
-- 2017-11-01 / Bastien Wermeille
-- --------------------------------------------------------------------------------

-- ---------------------------------------
-- A MODIFIER POUR UTILISER LA BONNE BD --
-- ---------------------------------------
-- USE `test`;

DROP TABLE IF EXISTS logging;
DROP TABLE IF EXISTS loggingcategorie;
DROP TABLE IF EXISTS `log`;
DROP TABLE IF EXISTS `log_cat`;
DROP TABLE IF EXISTS `basedonnees`;


alter table SIS add column SIS_Actif boolean;
alter table SIS add column BDO_ID int(10);
alter table SIS add column SIS_URL text;

create table Base_Donnees (
    BDO_ID int(10) PRIMARY KEY,
    BDO_Host varchar(255),
    BDO_Port int(10),
    BDO_User text,
    BDO_PWD text,
    BDO_Nom varchar(255),
    BDO_Charset varchar(255),
    BDO_Collation varchar(255)
)CHARACTER SET utf8mb4 collate utf8mb4_general_ci;

--
-- AUTO_INCREMENT pour la table `Base_Donnees`
--
ALTER TABLE `Base_Donnees`
  MODIFY `BDO_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

-- LoggingCategorie table
create table Log_Cat(
	LCA_ID int(10) PRIMARY KEY,
	LCA_Code varchar(50) NOT NULL,
	LCA_Limit int(10)
)CHARACTER SET utf8mb4 collate utf8mb4_general_ci;

ALTER TABLE `Log_Cat`
  MODIFY `LCA_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;


-- Logging table
create table `Log` (
	LOG_ID int(10) UNSIGNED NOT NULL PRIMARY KEY,
	LOG_IP varchar(255),
	LOG_Timestamp timestamp DEFAULT CURRENT_TIMESTAMP,
	LCA_ID int(10) UNSIGNED,
	LOG_Details text
)CHARACTER SET utf8mb4 collate utf8mb4_general_ci;


ALTER TABLE `Log`
ADD FOREIGN KEY (LCA_ID) REFERENCES Log_Cat(LCA_ID);

ALTER TABLE `Log`
  MODIFY `LOG_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;


-- Ajout de données de bases
INSERT INTO Log_Cat VALUES (1, 'login-fail', 100);
INSERT INTO Log_Cat VALUES (2, 'login-success', 0);

-- Mise a jour des données par SIS
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=0;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='hs.gestsis.ch' WHERE SIS_ID=11;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='6-12.gestsis.ch' WHERE SIS_ID=12;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='haut-plateau.gestsis.ch' WHERE SIS_ID=15;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='val-terbi.gestsis.ch' WHERE SIS_ID=16;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='vendline.gestsis.ch' WHERE SIS_ID=21;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='cdd.gestsis.ch' WHERE SIS_ID=22;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='calabri.gestsis.ch' WHERE SIS_ID=23;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='basse-allaine.gestsis.ch' WHERE SIS_ID=24;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='mont-terri.gestsis.ch' WHERE SIS_ID=25;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='la-baroche.gestsis.ch' WHERE SIS_ID=26;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='fmo.gestsis.ch' WHERE SIS_ID=31;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='fmc.gestsis.ch' WHERE SIS_ID=32;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=41;
UPDATE SIS SET SIS_ACTIF=1, BDO_ID=0, SIS_URL='valdor.gestsis.ch' WHERE SIS_ID=51;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=55;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=96;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=97;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=98;
UPDATE SIS SET SIS_ACTIF=0, BDO_ID=0, SIS_URL='' WHERE SIS_ID=99;
