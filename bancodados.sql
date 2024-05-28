-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Categoria` (
  `idCategoria` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomeCategoria` VARCHAR(45) NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `ID_Categoria_UNIQUE` (`idCategoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Opcoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Opcoes` (
  `idOpcoes` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `localizacaoOpcao` VARCHAR(45) NOT NULL,
  `categoriaOpcao` VARCHAR(45) NOT NULL,
  `horarioFucionamento` VARCHAR(45) NOT NULL,
  `custoEstimado` VARCHAR(45) NOT NULL,
  `nomeOpcao` VARCHAR(45) NOT NULL,
  `Categoria_idCategoria` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idOpcoes`),
  UNIQUE INDEX `idOpcoes_UNIQUE` (`idOpcoes` ASC),
  INDEX `fk_Opcoes_Categoria1_idx` (`Categoria_idCategoria` ASC),
  CONSTRAINT `fk_Opcoes_Categoria1`
    FOREIGN KEY (`Categoria_idCategoria`)
    REFERENCES `mydb`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Usuario` (
  `idUsuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dataDate` VARCHAR(45) NOT NULL,
  `categoria_Date` VARCHAR(45) NOT NULL,
  `localizacaoDate` VARCHAR(64) NOT NULL,
  `Categoria_idCategoria` INT UNSIGNED NOT NULL,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC),
  INDEX `fk_Usuario_Categoria_idx` (`Categoria_idCategoria` ASC),
  CONSTRAINT `fk_Usuario_Categoria`
    FOREIGN KEY (`Categoria_idCategoria`)
    REFERENCES `mydb`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mydb`.`Categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`Categoria` (`idCategoria`, `nomeCategoria`) VALUES (1, 'Jantar Romantico');
INSERT INTO `mydb`.`Categoria` (`idCategoria`, `nomeCategoria`) VALUES (2, 'Filmes Romanticos');
INSERT INTO `mydb`.`Categoria` (`idCategoria`, `nomeCategoria`) VALUES (3, 'Baladas ');
INSERT INTO `mydb`.`Categoria` (`idCategoria`, `nomeCategoria`) VALUES (4, 'Passeio ao ar livre');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mydb`.`Opcoes`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`Opcoes` (`idOpcoes`, `localizacaoOpcao`, `categoriaOpcao`, `horarioFucionamento`, `custoEstimado`, `nomeOpcao`, `Categoria_idCategoria`) VALUES (1, 'Sao Paulo', 'Jantar romântico ', '17h - 22h ', 'R$350', 'Restaurante Donna', 1);
INSERT INTO `mydb`.`Opcoes` (`idOpcoes`, `localizacaoOpcao`, `categoriaOpcao`, `horarioFucionamento`, `custoEstimado`, `nomeOpcao`, `Categoria_idCategoria`) VALUES (2, 'Rio de Janeiro ', 'Filmes românticos', '13h - 22h', 'R$100', '500 dias com ela', 2);
INSERT INTO `mydb`.`Opcoes` (`idOpcoes`, `localizacaoOpcao`, `categoriaOpcao`, `horarioFucionamento`, `custoEstimado`, `nomeOpcao`, `Categoria_idCategoria`) VALUES (3, 'Minas Gerais', 'Balada', '17h - 24h', 'R$300', 'Bruder Music Hall', 3);
INSERT INTO `mydb`.`Opcoes` (`idOpcoes`, `localizacaoOpcao`, `categoriaOpcao`, `horarioFucionamento`, `custoEstimado`, `nomeOpcao`, `Categoria_idCategoria`) VALUES (4, 'Sao Paluo', 'Passeio ao ar livre', '10h - 17h', 'R$130', 'Parque Ibirapuera', 4);
INSERT INTO `mydb`.`Opcoes` (`idOpcoes`, `localizacaoOpcao`, `categoriaOpcao`, `horarioFucionamento`, `custoEstimado`, `nomeOpcao`, `Categoria_idCategoria`) VALUES (5, 'Rio de Janeiro', 'Balada', '18h - 24h', 'R$200', 'Rio Scenarium', 3);
COMMIT;

