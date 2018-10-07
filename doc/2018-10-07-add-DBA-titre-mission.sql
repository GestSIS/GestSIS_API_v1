CREATE TABLE `Titre_Mission` (
  `TIM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIM_Designation` varchar(250) NOT NULL,
  `TIM_Actif` bit(1) NOT NULL,
  `TIM_Tri` int(10) DEFAULT NULL,
  PRIMARY KEY (`TIM_ID`)
) ENGINE=InnoDB;
