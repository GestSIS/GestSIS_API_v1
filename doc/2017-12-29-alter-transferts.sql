ALTER TABLE `Transfert_App` ADD `TRA_Reference` VARCHAR(255) NULL AFTER `TRA_Contenu`, ADD `TRA_Complet` BOOLEAN NOT NULL AFTER `TRA_Reference`;
