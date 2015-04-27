CREATE TABLE IF NOT EXISTS `projet_csi`.`produit` (
  `id_produit` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` VARCHAR(255) NOT NULL,
  `prix` FLOAT(6,2) NOT NULL,
  `description` TEXT NULL,
  `image_url` VARCHAR(255) NULL,
  PRIMARY KEY (`id_produit`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`categorie` (
  `id_categorie` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_categorie`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `projet_csi`.`client` (
  `id_client` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `pseudo` VARCHAR(255) NOT NULL,
  `mot_passe` VARCHAR(255) NOT NULL,
  `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` ENUM('membre','admin') NOT NULL DEFAULT 'membre',
  PRIMARY KEY (`id_client`),
  UNIQUE INDEX `pseudo_UNIQUE` (`pseudo` ASC))
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `projet_csi`.`panier` (
  `id_panier` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` INT(10) UNSIGNED NOT NULL,
  `prix_total` FLOAT(8,2) NOT NULL DEFAULT 0.00,
  `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_valide` TINYINT(1) NOT NULL DEFAULT 0,
  `quantite_totale` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_panier`),
  INDEX `fk_panier_client_id_client_idx` (`id_client` ASC),
  CONSTRAINT `fk_panier_client_id_client`
    FOREIGN KEY (`id_client`)
    REFERENCES `projet_csi`.`client` (`id_client`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;




CREATE TABLE IF NOT EXISTS `projet_csi`.`reduction` (
  `id_reduction` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant_reduction` FLOAT(5,2) NOT NULL,
  `nombre_produit` SMALLINT(5) NOT NULL DEFAULT 0,
  `date_debut` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fin` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id_reduction`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`magasin` (
  `id_magasin` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_magasin`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `projet_csi`.`adresse` (
  `id_adresse` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rue` VARCHAR(255) NULL,
  `ville` VARCHAR(50) NOT NULL,
  `code_postal` INT(6) NOT NULL,
  PRIMARY KEY (`id_adresse`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`commande` (
  `id_commande` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_panier` BIGINT(20) UNSIGNED NOT NULL,
  `id_magasin` SMALLINT(5) UNSIGNED NOT NULL,
  `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `heure_retrait` TIMESTAMP NOT NULL,
  `num_quai` TINYINT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_commande`),
  INDEX `fk_commande_panier_id_panier_idx` (`id_panier` ASC),
  INDEX `fk_commande_magasin_id_magasin_idx` (`id_magasin` ASC),
  CONSTRAINT `fk_commande_panier_id_panier`
    FOREIGN KEY (`id_panier`)
    REFERENCES `projet_csi`.`panier` (`id_panier`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_commande_magasin_id_magasin`
    FOREIGN KEY (`id_magasin`)
    REFERENCES `projet_csi`.`magasin` (`id_magasin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`bilan` (
  `id_bilan` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant_total` FLOAT(10,2) NOT NULL,
  `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` ENUM('journalier','hebdomadaire','mensuel') NOT NULL,
  PRIMARY KEY (`id_bilan`))
ENGINE = InnoDB;







CREATE TABLE IF NOT EXISTS `projet_csi`.`magasin_has_adresse` (
  `magasin_id_magasin` SMALLINT(5) UNSIGNED NOT NULL,
  `adresse_id_adresse` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`magasin_id_magasin`, `adresse_id_adresse`),
  INDEX `fk_magasin_has_adresse_adresse1_idx` (`adresse_id_adresse` ASC),
  INDEX `fk_magasin_has_adresse_magasin1_idx` (`magasin_id_magasin` ASC),
  CONSTRAINT `fk_magasin_has_adresse_magasin1`
    FOREIGN KEY (`magasin_id_magasin`)
    REFERENCES `projet_csi`.`magasin` (`id_magasin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_magasin_has_adresse_adresse1`
    FOREIGN KEY (`adresse_id_adresse`)
    REFERENCES `projet_csi`.`adresse` (`id_adresse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`client_has_adresse` (
  `client_id_client` INT(10) UNSIGNED NOT NULL,
  `adresse_id_adresse` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`client_id_client`, `adresse_id_adresse`),
  INDEX `fk_client_has_adresse_adresse1_idx` (`adresse_id_adresse` ASC),
  INDEX `fk_client_has_adresse_client1_idx` (`client_id_client` ASC),
  CONSTRAINT `fk_client_has_adresse_client1`
    FOREIGN KEY (`client_id_client`)
    REFERENCES `projet_csi`.`client` (`id_client`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_has_adresse_adresse1`
    FOREIGN KEY (`adresse_id_adresse`)
    REFERENCES `projet_csi`.`adresse` (`id_adresse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`bilan_has_produit` (
  `bilan_id_bilan` SMALLINT(5) UNSIGNED NOT NULL,
  `produit_id_produit` BIGINT(10) UNSIGNED NOT NULL,
  `quantite` INT(10) NOT NULL,
  `montant` FLOAT(8,2) NOT NULL,
  PRIMARY KEY (`bilan_id_bilan`, `produit_id_produit`),
  INDEX `fk_bilan_has_produit_produit1_idx` (`produit_id_produit` ASC),
  INDEX `fk_bilan_has_produit_bilan1_idx` (`bilan_id_bilan` ASC),
  CONSTRAINT `fk_bilan_has_produit_bilan1`
    FOREIGN KEY (`bilan_id_bilan`)
    REFERENCES `projet_csi`.`bilan` (`id_bilan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bilan_has_produit_produit1`
    FOREIGN KEY (`produit_id_produit`)
    REFERENCES `projet_csi`.`produit` (`id_produit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `projet_csi`.`reduction_has_produit` (
  `reduction_id_reduction` BIGINT(20) UNSIGNED NOT NULL,
  `produit_id_produit` BIGINT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`reduction_id_reduction`, `produit_id_produit`),
  INDEX `fk_reduction_has_produit_produit1_idx` (`produit_id_produit` ASC),
  INDEX `fk_reduction_has_produit_reduction1_idx` (`reduction_id_reduction` ASC),
  CONSTRAINT `fk_reduction_has_produit_reduction1`
    FOREIGN KEY (`reduction_id_reduction`)
    REFERENCES `projet_csi`.`reduction` (`id_reduction`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reduction_has_produit_produit1`
    FOREIGN KEY (`produit_id_produit`)
    REFERENCES `projet_csi`.`produit` (`id_produit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `projet_csi`.`produit_has_categorie` (
  `produit_id_produit` BIGINT(10) UNSIGNED NOT NULL,
  `categorie_id_categorie` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`produit_id_produit`, `categorie_id_categorie`),
  INDEX `fk_produit_has_categorie_categorie1_idx` (`categorie_id_categorie` ASC),
  INDEX `fk_produit_has_categorie_produit_idx` (`produit_id_produit` ASC),
  CONSTRAINT `fk_produit_has_categorie_produit`
    FOREIGN KEY (`produit_id_produit`)
    REFERENCES `projet_csi`.`produit` (`id_produit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produit_has_categorie_categorie1`
    FOREIGN KEY (`categorie_id_categorie`)
    REFERENCES `projet_csi`.`categorie` (`id_categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `projet_csi`.`panier_has_produit` (
  `panier_id_panier` BIGINT(20) UNSIGNED NOT NULL,
  `produit_id_produit` BIGINT(10) UNSIGNED NOT NULL,
  `quantite` SMALLINT(5) NOT NULL,
  `prix_produit` FLOAT(6,2) NOT NULL,
  PRIMARY KEY (`panier_id_panier`, `produit_id_produit`),
  INDEX `fk_panier_has_produit_produit1_idx` (`produit_id_produit` ASC),
  INDEX `fk_panier_has_produit_panier1_idx` (`panier_id_panier` ASC),
  CONSTRAINT `fk_panier_has_produit_panier1`
    FOREIGN KEY (`panier_id_panier`)
    REFERENCES `projet_csi`.`panier` (`id_panier`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_panier_has_produit_produit1`
    FOREIGN KEY (`produit_id_produit`)
    REFERENCES `projet_csi`.`produit` (`id_produit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `projet_csi`.`reduction_has_client` (
  `reduction_id_reduction` BIGINT(20) UNSIGNED NOT NULL,
  `client_id_client` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`reduction_id_reduction`, `client_id_client`),
  INDEX `fk_reduction_has_client_client1_idx` (`client_id_client` ASC),
  INDEX `fk_reduction_has_client_reduction1_idx` (`reduction_id_reduction` ASC),
  CONSTRAINT `fk_reduction_has_client_reduction1`
    FOREIGN KEY (`reduction_id_reduction`)
    REFERENCES `projet_csi`.`reduction` (`id_reduction`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reduction_has_client_client1`
    FOREIGN KEY (`client_id_client`)
    REFERENCES `projet_csi`.`client` (`id_client`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `projet_csi`.`client` (`nom`, `prenom`, `email`, `pseudo`, `mot_passe`, `role`)
VALUES ('projet', 'admin', 'admin@csi.com', 'projet_csi', '3cfe9d1883c5819dd5fdcc3c57fa7a892db0c56c', 'admin');


INSERT INTO `projet_csi`.`client` (`nom`, `prenom`, `email`, `pseudo`, `mot_passe`, `role`)
VALUES ('Schweitzer', 'Victorien', 'Victorien@csi.com', 'victo', '3cfe9d1883c5819dd5fdcc3c57fa7a892db0c56c', 'admin');

INSERT INTO `projet_csi`.`client` (`nom`, `prenom`, `email`, `pseudo`, `mot_passe`, `role`)
VALUES ('Zeghadi', 'Sofiane', 'Sofiane@csi.com', 'Sofiane', '3cfe9d1883c5819dd5fdcc3c57fa7a892db0c56c', 'admin');


INSERT INTO categorie (nom)
VALUES ('viande');

INSERT INTO categorie (nom)
VALUES ('poisson');

INSERT INTO categorie (nom)
VALUES ('fruits');

INSERT INTO categorie (nom)
VALUES ('légume');

INSERT INTO categorie (nom)
VALUES ('boisson');



INSERT INTO `produit` (`id_produit`, `libelle`, `prix`, `description`, `image_url`) VALUES
(1, 'Viande bovine rôti 1KG', 15.90, 'Origine : France\r\nLieu d''élevage : France\r\nLieu d''abattage : France\r\nType : Viande\r\nCatégorie : Vache\r\n15.90 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=727519&use=d&cat=p&typeid=i'),
(2, 'Porc : Côte sans os', 4.98, 'Origine : France\r\n4 Tranche\r\n440g\r\n11.32 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=734673&use=d&cat=p&typeid=i'),
(3, 'Boisson aux fruits Oasis zéro Tropical', 1.73, '2L\r\n0.87 € / l\r\nIdéal pour toute la famille !', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=722781&use=d&cat=p&typeid=i'),
(4, 'Boisson aux fruits Jafaden Orange', 1.19, '2L\r\n0.60 € / l\r\nBon ... Et frais !', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=727181&use=d&cat=p&typeid=i'),
(5, 'Oranges à jus', 3.99, 'Douceur du Verger\r\nFilet 3kg\r\nVariété : Salustiana\r\nOrigine : Espagne\r\nCatégorie : 1\r\nCalibre : 5/6\r\n1.33 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=751415&use=d&cat=p&typeid=i'),
(6, 'Bananes Sachet 5 fruits', 1.49, 'Variété : Cavendish\r\nOrigine : Antilles Françaises\r\nCatégorie : Extra\r\nCalibre : 18', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=528924&use=d&cat=p&typeid=i'),
(7, 'Carottes', 1.49, 'Variété : Carotte\r\nOrigine : France\r\nCatégorie : 1\r\nCalibre : 25/40\r\n0.75 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=271995&use=d&cat=p&typeid=i'),
(8, 'Chou fleur', 1.69, 'Variété : Chou fleur\r\nOrigine : France - Bretagne\r\nCatégorie : 1', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=476654&use=d&cat=p&typeid=i'),
(9, 'Poissons panés', 2.13, 'Ronde des Mers\r\nColin d''Alaska 2x100g\r\n10.65 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=485919&use=d&cat=p&typeid=i'),
(10, 'Petites crevettes roses Ronde des mers', 1.86, '125g\r\n14.88 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=640383&use=d&cat=p&typeid=i'),
(11, 'Viande bovine 2x steak* à griller', 3.87, '260g 14.88 € / kg\r\nOrigine : France\r\nLieu d''élevage : France\r\nLieu d''abattage : France\r\nType : Laitière\r\nCatégorie : Vache', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=659532&use=d&cat=p&typeid=i'),
(12, 'Porc : Rôti fumé', 9.75, 'Origine France - 850g\r\n11.47 € / kg', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=727895&use=d&cat=p&typeid=i'),
(13, 'Pavés de Saumon', 5.30, '2x140g - 18.93 € / kg\r\nMode de production : Élevé(e) en\r\nZone de pêche : Norvège\r\nDécongelé : Non\r\nNom scientifique : Salmo salar\r\nEngin de pêche -', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=618940&use=d&cat=p&typeid=i'),
(14, 'Poires Conférence', 1.99, '1kg - 1.99 € / kg\r\nVariété : Conférence\r\nOrigine : Belgique\r\nCatégorie : 1\r\nCalibre : 55/65', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=271996&use=d&cat=p&typeid=i'),
(15, 'Soda Coca Cola', 9.54, 'bouteille 6x1,5L - 1.06 € / l\r\nPour votre santé, évitez de grignoter entre les repas.', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=768398&use=d&cat=p&typeid=i'),
(16, 'Poivrons tricolores', 1.99, '500g - 3.98 € / kg\r\nVariété : California\r\nOrigine : Espagne\r\nCatégorie : 1\r\nCalibre : G', 'http://fd2-photos.leclercdrive.fr/image.ashx?id=8369&use=d&cat=p&typeid=i');

INSERT INTO `produit_has_categorie` (`produit_id_produit`, `categorie_id_categorie`) VALUES
(1, 1),
(2, 1),
(11, 1),
(12, 1),
(9, 2),
(10, 2),
(13, 2),
(5, 3),
(6, 3),
(14, 3),
(7, 4),
(8, 4),
(16, 4),
(3, 5),
(4, 5),
(15, 5);



INSERT INTO `magasin` (`id_magasin`, `nom`) VALUES
(1, 'Magasin du Louvre'),
(2, 'Magasin de luxe'),
(3, 'bazar du baobab'),
(4, 'décostyle'),
(5, 'Matrix Interior Design'),
(6, 'he Warner Brothers Store'),
(7, 'Super Saver Foods');

INSERT INTO `adresse` (`id_adresse`, `rue`, `ville`, `code_postal`) VALUES
(1, '12, rue de la Bresse', 'Vosges', 88000),
(2, NULL, 'Strasbourg', 67000),
(3, '6, rue de la source', 'Nancy', 54000),
(4, '13, Rue de la Pompe', 'MAMOUDZOU', 97600),
(5, '30, rue Isambard', 'FRESNES', 94260),
(6, '97, rue des Dunes', 'SAINT-MÉDARD-EN-JALLES', 33160),
(7, '15, Rue de Verdun', 'MONTGERON', 91230);

INSERT INTO `magasin_has_adresse` (`magasin_id_magasin`, `adresse_id_adresse`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);



INSERT INTO `bilan` (`id_bilan`, `montant_total`, `date_creation`, `type`) VALUES
(1, 15.00, '2015-04-22 17:07:21', 'mensuel'),
(2, 12.00, '2015-04-22 17:14:10', 'mensuel'),
(3, 12.00, '2015-04-22 17:14:26', 'mensuel'),
(4, 12.00, '2015-04-22 17:14:33', 'mensuel');



INSERT INTO `bilan_has_produit` (`bilan_id_bilan`, `produit_id_produit`, `quantite`, `montant`) VALUES
(1, 1, 2, 3.00),
(1, 3, 5, 3.00),
(1, 4, 3, 3.00),
(1, 6, 8, 3.00),
(1, 7, 2, 3.00),
(1, 8, 2, 3.00),
(1, 9, 3, 3.00),
(1, 10, 2, 3.00),
(1, 11, 2, 3.00),
(1, 12, 1, 3.00),
(1, 13, 2, 3.00),
(1, 14, 6, 3.00),
(2, 2, 1, 3.00),
(2, 4, 6, 3.00),
(2, 8, 4, 3.00),
(2, 9, 4, 3.00),
(3, 5, 2, 3.00),
(3, 8, 5, 3.00);