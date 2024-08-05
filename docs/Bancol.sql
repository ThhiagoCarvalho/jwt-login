-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema sistema_usuarios
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sistema_usuarios
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistema_usuarios` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `sistema_usuarios` ;

-- -----------------------------------------------------
-- Table `sistema_usuarios`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_usuarios`.`usuario` (
  `idUsuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomeUsuario` VARCHAR(64) NULL DEFAULT NULL,
  `emailUsuario` VARCHAR(64) NULL DEFAULT NULL,
  `senha` VARCHAR(64) NULL DEFAULT NULL,
  `nascimento` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
