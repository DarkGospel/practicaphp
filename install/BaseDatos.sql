-- MySQL Workbench Synchronization
-- Generated: 2018-12-03 20:25
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: 2DAW

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
CREATE DATABASE IF NOT EXISTS practica_php;
CREATE TABLE IF NOT EXISTS `practica_php`.`usuario` (
  `nif` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido1` VARCHAR(45) NOT NULL,
  `apellido2` VARCHAR(45) NOT NULL,
  `foto` VARCHAR(45) NOT NULL,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `contrasena` VARCHAR(45) NOT NULL,
  `perfil_usuario` VARCHAR(45) NOT NULL,
  `telefono_movil` INT(9) NOT NULL,
  `telefono_fijo` INT(9) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `departamento` VARCHAR(45) NOT NULL,
  `pagina_web` VARCHAR(45) NOT NULL,
  `direccion_blog` VARCHAR(45) NOT NULL,
  `cuenta_twitter` VARCHAR(45) NOT NULL,
  `activo` TINYINT(4) NOT NULL,
  `fecha_solicitud` DATE NOT NULL,
  `asignaturas` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`nif`),
  UNIQUE INDEX `nombre_usuario_UNIQUE` (`nombre_usuario` ASC)  )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`solicitud` (
  `cod_solicitud` INT(11) NOT NULL,
  `cursos` VARCHAR(45) NULL DEFAULT NULL,
  `usuario_nif` INT(11) NOT NULL,
  PRIMARY KEY (`cod_solicitud`),
  INDEX `fk_solicitud_usuario_idx` (`usuario_nif` ASC)  ,
  CONSTRAINT `fk_solicitud_usuario`
    FOREIGN KEY (`usuario_nif`)
    REFERENCES `practica_php`.`usuario` (`nif`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`eso` (
  `codESO` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `curso` VARCHAR(45) NULL DEFAULT NULL,
  `grupo` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`codESO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`eso_has_solicitud` (
  `eso_ideso` INT(11) NOT NULL,
  `solicitud_cod_solicitud` INT(11) NOT NULL,
  PRIMARY KEY (`eso_ideso`, `solicitud_cod_solicitud`),
  INDEX `fk_eso_has_solicitud_solicitud1_idx` (`solicitud_cod_solicitud` ASC)  ,
  INDEX `fk_eso_has_solicitud_eso1_idx` (`eso_ideso` ASC)  ,
  CONSTRAINT `fk_eso_has_solicitud_eso1`
    FOREIGN KEY (`eso_ideso`)
    REFERENCES `practica_php`.`eso` (`codESO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_eso_has_solicitud_solicitud1`
    FOREIGN KEY (`solicitud_cod_solicitud`)
    REFERENCES `practica_php`.`solicitud` (`cod_solicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`bach` (
  `codBACH` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `curso` VARCHAR(45) NULL DEFAULT NULL,
  `grupo` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`codBACH`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`solicitud_has_bach` (
  `solicitud_cod_solicitud` INT(11) NOT NULL,
  `bach_codBACH` INT(11) NOT NULL,
  PRIMARY KEY (`solicitud_cod_solicitud`, `bach_codBACH`),
  INDEX `fk_solicitud_has_bach_bach1_idx` (`bach_codBACH` ASC)  ,
  INDEX `fk_solicitud_has_bach_solicitud1_idx` (`solicitud_cod_solicitud` ASC)  ,
  CONSTRAINT `fk_solicitud_has_bach_solicitud1`
    FOREIGN KEY (`solicitud_cod_solicitud`)
    REFERENCES `practica_php`.`solicitud` (`cod_solicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_has_bach_bach1`
    FOREIGN KEY (`bach_codBACH`)
    REFERENCES `practica_php`.`bach` (`codBACH`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`asignaturas_eso` (
  `codAsignatura` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `eso_codESO` INT(11) NOT NULL,
  INDEX `fk_asignaturas_eso1_idx` (`eso_codESO` ASC)  ,
  PRIMARY KEY (`codAsignatura`),
  CONSTRAINT `fk_asignaturas_eso1`
    FOREIGN KEY (`eso_codESO`)
    REFERENCES `practica_php`.`eso` (`codESO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`asignaturas_bach` (
  `codAsignatura` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `bach_codBACH` INT(11) NOT NULL,
  INDEX `fk_asignaturas_bach_bach1_idx` (`bach_codBACH` ASC)  ,
  PRIMARY KEY (`codAsignatura`),
  CONSTRAINT `fk_asignaturas_bach_bach1`
    FOREIGN KEY (`bach_codBACH`)
    REFERENCES `practica_php`.`bach` (`codBACH`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`familia_profesional` (
  `codFamiliaProfesional` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`codFamiliaProfesional`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`solicitud_has_familia_profesional` (
  `solicitud_cod_solicitud` INT(11) NOT NULL,
  `familia_profesional_codFamiliaProfesional` INT(11) NOT NULL,
  PRIMARY KEY (`solicitud_cod_solicitud`, `familia_profesional_codFamiliaProfesional`),
  INDEX `fk_solicitud_has_familia_profesional_familia_profesional1_idx` (`familia_profesional_codFamiliaProfesional` ASC)  ,
  INDEX `fk_solicitud_has_familia_profesional_solicitud1_idx` (`solicitud_cod_solicitud` ASC)  ,
  CONSTRAINT `fk_solicitud_has_familia_profesional_solicitud1`
    FOREIGN KEY (`solicitud_cod_solicitud`)
    REFERENCES `practica_php`.`solicitud` (`cod_solicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_has_familia_profesional_familia_profesional1`
    FOREIGN KEY (`familia_profesional_codFamiliaProfesional`)
    REFERENCES `practica_php`.`familia_profesional` (`codFamiliaProfesional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`ciclo_formativo` (
  `codCiclo` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `tipo` VARCHAR(45) NULL DEFAULT NULL,
  `ciclo_formativocol` VARCHAR(45) NULL DEFAULT NULL,
  `familia_profesional_codFamiliaProfesional` INT(11) NOT NULL,
  PRIMARY KEY (`codCiclo`, `familia_profesional_codFamiliaProfesional`),
  INDEX `fk_ciclo_formativo_familia_profesional1_idx` (`familia_profesional_codFamiliaProfesional` ASC)  ,
  CONSTRAINT `fk_ciclo_formativo_familia_profesional1`
    FOREIGN KEY (`familia_profesional_codFamiliaProfesional`)
    REFERENCES `practica_php`.`familia_profesional` (`codFamiliaProfesional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `practica_php`.`modulo` (
  `codModulo` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `curso` VARCHAR(45) NULL DEFAULT NULL,
  `grupo` VARCHAR(45) NULL DEFAULT NULL,
  `clave_matric` VARCHAR(45) NULL DEFAULT NULL,
  `ciclo_formativo_familia_profesional_codFamiliaProfesional` INT(11) NOT NULL,
  `ciclo_formativo_codCiclo` INT(11) NOT NULL,
  PRIMARY KEY (`codModulo`, `ciclo_formativo_familia_profesional_codFamiliaProfesional`, `ciclo_formativo_codCiclo`),
  CONSTRAINT `fk_modulo_ciclo_formativo1`
    FOREIGN KEY (`ciclo_formativo_codCiclo` , `ciclo_formativo_familia_profesional_codFamiliaProfesional`)
    REFERENCES `practica_php`.`ciclo_formativo` (`codCiclo` , `familia_profesional_codFamiliaProfesional`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
