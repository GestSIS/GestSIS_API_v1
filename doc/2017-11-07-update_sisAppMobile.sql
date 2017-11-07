-- --------------------------------------------------------------------------------
-- Ajout de la colonne SIS_Mobile afin de savoir si le sis à acheter GestSIS Mobile
-- Note: boolean sera transforme en tinyint(1)
-- 2017-11-07 / Bastien Wermeille
-- --------------------------------------------------------------------------------
ALTER TABLE SIS add column SIS_Mobile boolean;

UPDATE SIS SET SIS_Mobile=0;
UPDATE SIS SET SIS_Mobile=0 WHERE SIS_ID=56;
