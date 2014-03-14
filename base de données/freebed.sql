SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `freebed` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `freebed` ;

-- -----------------------------------------------------
-- Table `freebed`.`adresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`adresses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `adresse` VARCHAR(255) NULL,
  `cp` INT(5) NULL,
  `ville` VARCHAR(255) NULL,
  `pays` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pseudo` VARCHAR(45) NULL,
  `nom` VARCHAR(45) NULL,
  `prenom` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(255) NULL,
  `bailleur` TINYINT(1) NULL,
  `adresses_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_adresses1_idx` (`adresses_id` ASC),
  CONSTRAINT `fk_users_adresses1`
    FOREIGN KEY (`adresses_id`)
    REFERENCES `freebed`.`adresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`biens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`biens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL,
  `type` SET('Appartement','Gite', 'Chambre') NULL,
  `surface` VARCHAR(45) NULL,
  `tarif_week` FLOAT(8,2) NULL,
  `tarif_day` FLOAT(8,2) NULL,
  `description` MEDIUMTEXT NULL,
  `visites` INT NULL,
  `users_id` INT NOT NULL,
  `adresse_id` INT NOT NULL,
  `active` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_biens_users_idx` (`users_id` ASC),
  INDEX `fk_biens_adresse1_idx` (`adresse_id` ASC),
  CONSTRAINT `fk_biens_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `freebed`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_biens_adresse1`
    FOREIGN KEY (`adresse_id`)
    REFERENCES `freebed`.`adresses` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`date_disponibilites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`date_disponibilites` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_debut` DATE NULL,
  `date_fin` DATE NULL,
  `biens_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_date_disponibilites_biens1_idx` (`biens_id` ASC),
  CONSTRAINT `fk_date_disponibilites_biens1`
    FOREIGN KEY (`biens_id`)
    REFERENCES `freebed`.`biens` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL,
  `url` VARCHAR(255) NULL,
  `biens_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_images_biens1_idx` (`biens_id` ASC),
  CONSTRAINT `fk_images_biens1`
    FOREIGN KEY (`biens_id`)
    REFERENCES `freebed`.`biens` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`avis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`avis` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `commentaire` MEDIUMTEXT NULL,
  `note` TINYINT(2) NULL,
  `biens_id` INT NOT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_avis_biens1_idx` (`biens_id` ASC),
  INDEX `fk_avis_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_avis_biens1`
    FOREIGN KEY (`biens_id`)
    REFERENCES `freebed`.`biens` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_avis_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `freebed`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`locations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`locations` (
  `users_id` INT NOT NULL,
  `biens_id` INT NOT NULL,
  `date_debut` DATE NULL,
  `date_fin` DATE NULL,
  PRIMARY KEY (`users_id`, `biens_id`),
  INDEX `fk_users_has_biens_biens1_idx` (`biens_id` ASC),
  INDEX `fk_users_has_biens_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_biens_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `freebed`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_biens_biens1`
    FOREIGN KEY (`biens_id`)
    REFERENCES `freebed`.`biens` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `freebed`.`ip_vues`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `freebed`.`ip_vues` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(45) NULL,
  `date` DATE NULL,
  `biens_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ip_vues_biens1_idx` (`biens_id` ASC),
  CONSTRAINT `fk_ip_vues_biens1`
    FOREIGN KEY (`biens_id`)
    REFERENCES `freebed`.`biens` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
