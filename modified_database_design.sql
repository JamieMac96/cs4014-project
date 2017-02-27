SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `CS4014_project_database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `CS4014_project_database` ;

-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Subject`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Subject` (
  `SubjectID` INT NOT NULL AUTO_INCREMENT,
  `SubjectName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`SubjectID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`User` (
  `StudentID` INT NOT NULL AUTO_INCREMENT,
  `Subjects_SubjectID` INT NOT NULL,
  `ForeName` VARCHAR(35) NOT NULL,
  `Lastname` VARCHAR(35) NOT NULL,
  `EmailAddress` VARCHAR(255) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `reputation` INT NOT NULL,
  `IsMod` TINYINT(1) NOT NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE INDEX `EmailAddress_UNIQUE` (`EmailAddress` ASC),
  INDEX `fk_Users_Subjects_idx` (`Subjects_SubjectID` ASC),
  UNIQUE INDEX `StudentID_UNIQUE` (`StudentID` ASC),
  CONSTRAINT `fk_Users_Subjects`
    FOREIGN KEY (`Subjects_SubjectID`)
    REFERENCES `CS4014_project_database`.`Subject` (`SubjectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Task` (
  `TaskID` INT NOT NULL AUTO_INCREMENT,
  `Users_StudentID` INT NOT NULL,
  `Subjects_SubjectID` INT NOT NULL,
  `Title` VARCHAR(75) NOT NULL,
  `Description` VARCHAR(300) NOT NULL,
  `NumPages` INT NOT NULL,
  `NumWords` INT NOT NULL,
  `ClaimantID` VARCHAR(45) NULL,
  PRIMARY KEY (`TaskID`),
  INDEX `fk_Tasks_Subjects1_idx` (`Subjects_SubjectID` ASC),
  INDEX `fk_Tasks_Users1_idx` (`Users_StudentID` ASC),
  CONSTRAINT `fk_Tasks_Subjects1`
    FOREIGN KEY (`Subjects_SubjectID`)
    REFERENCES `CS4014_project_database`.`Subject` (`SubjectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tasks_Users1`
    FOREIGN KEY (`Users_StudentID`)
    REFERENCES `CS4014_project_database`.`User` (`StudentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Deadline`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Deadline` (
  `Tasks_TaskID` INT NOT NULL,
  `Claim` DATE NOT NULL,
  `Completion` DATE NOT NULL,
  INDEX `fk_Deadlines_Tasks1_idx` (`Tasks_TaskID` ASC),
  CONSTRAINT `fk_Deadlines_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Format`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Format` (
  `FormatID` INT NOT NULL AUTO_INCREMENT,
  `FormatVal` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`FormatID`),
  UNIQUE INDEX `FormatVal_UNIQUE` (`FormatVal` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Document`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Document` (
  `DocumentID` INT NOT NULL AUTO_INCREMENT,
  `DocumentURL` VARCHAR(255) NOT NULL,
  `Type` VARCHAR(45) NOT NULL,
  `Tasks_TaskID` INT NOT NULL,
  `Format_FormatID` INT NOT NULL,
  UNIQUE INDEX `DocumentURL_UNIQUE` (`DocumentURL` ASC),
  INDEX `fk_Documents_Tasks1_idx` (`Tasks_TaskID` ASC),
  PRIMARY KEY (`DocumentID`),
  INDEX `fk_Document_Format1_idx` (`Format_FormatID` ASC),
  CONSTRAINT `fk_Documents_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Document_Format1`
    FOREIGN KEY (`Format_FormatID`)
    REFERENCES `CS4014_project_database`.`Format` (`FormatID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Flag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Flag` (
  `Tasks_TaskID` INT NOT NULL,
  `Complaint` VARCHAR(200) NOT NULL,
  INDEX `fk_Flags_Tasks1_idx` (`Tasks_TaskID` ASC),
  CONSTRAINT `fk_Flags_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`BannedUser`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`BannedUser` (
  `BanID` INT NOT NULL AUTO_INCREMENT,
  `EmailAddress` VARCHAR(255) NOT NULL,
  `Reason` VARCHAR(200) NULL,
  PRIMARY KEY (`BanID`),
  UNIQUE INDEX `EmailAddress_UNIQUE` (`EmailAddress` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Clicks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Clicks` (
  `clickID` INT NOT NULL AUTO_INCREMENT,
  `Tasks_TaskID` INT NOT NULL,
  `Users_StudentID` INT NOT NULL,
  INDEX `fk_Clicks_Tasks1_idx` (`Tasks_TaskID` ASC),
  PRIMARY KEY (`clickID`),
  INDEX `fk_Clicks_Users1_idx` (`Users_StudentID` ASC),
  CONSTRAINT `fk_Clicks_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Clicks_Users1`
    FOREIGN KEY (`Users_StudentID`)
    REFERENCES `CS4014_project_database`.`User` (`StudentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Tag` (
  `TagID` INT NOT NULL AUTO_INCREMENT,
  `Value` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`TagID`),
  UNIQUE INDEX `Value_UNIQUE` (`Value` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`TaskTag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`TaskTag` (
  `TaskTagID` INT NOT NULL AUTO_INCREMENT,
  `Tags_TagID` INT NOT NULL,
  `Tasks_TaskID` INT NOT NULL,
  INDEX `fk_TaskTags_Tags1_idx` (`Tags_TagID` ASC),
  PRIMARY KEY (`TaskTagID`),
  INDEX `fk_TaskTags_Tasks1_idx` (`Tasks_TaskID` ASC),
  CONSTRAINT `fk_TaskTags_Tags1`
    FOREIGN KEY (`Tags_TagID`)
    REFERENCES `CS4014_project_database`.`Tag` (`TagID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TaskTags_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Status` (
  `StatusID` INT NOT NULL AUTO_INCREMENT,
  `StatusVal` VARCHAR(45) NOT NULL,
  `Tasks_TaskID` INT NOT NULL,
  PRIMARY KEY (`StatusID`),
  UNIQUE INDEX `StatusVal_UNIQUE` (`StatusVal` ASC),
  INDEX `fk_Status_Tasks1_idx` (`Tasks_TaskID` ASC),
  CONSTRAINT `fk_Status_Tasks1`
    FOREIGN KEY (`Tasks_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
