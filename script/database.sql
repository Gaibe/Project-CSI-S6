CREATE TABLE IF NOT EXISTS `projet_csi`.`produit` (
  `id_produit` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` VARCHAR(255) NOT NULL,
  `prix` FLOAT(6,2) NOT NULL,
  `description` TEXT NULL,
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
  `id_adresse` INT(10) UNSIGNED NOT NULL,
  `rue` VARCHAR(255) NULL,
  `ville` VARCHAR(50) NOT NULL,
  `code_postal` SMALLINT(5) NOT NULL,
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