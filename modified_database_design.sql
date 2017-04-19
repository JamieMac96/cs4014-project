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
  `UserID` INT NOT NULL AUTO_INCREMENT,
  `Subject_SubjectID` INT NOT NULL,
  `ForeName` VARCHAR(35) NOT NULL,
  `Lastname` VARCHAR(35) NOT NULL,
  `EmailAddress` VARCHAR(255) NOT NULL,
  `StudentID` INT NOT NULL,
  `Password` VARCHAR(65) NOT NULL,
  `reputation` INT NOT NULL,
  `IsMod` TINYINT(1) NOT NULL,
  `PasswordSalt` VARCHAR(64) NOT NULL,
  `ProfilePicURL` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE INDEX `EmailAddress_UNIQUE` (`EmailAddress` ASC),
  INDEX `fk_Users_Subjects_idx` (`Subject_SubjectID` ASC),
  UNIQUE INDEX `UserID_UNIQUE` (`UserID` ASC),
  CONSTRAINT `fk_Users_Subjects`
    FOREIGN KEY (`Subject_SubjectID`)
    REFERENCES `CS4014_project_database`.`Subject` (`SubjectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Status` (
  `StatusID` INT NOT NULL AUTO_INCREMENT,
  `StatusVal` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`StatusID`),
  UNIQUE INDEX `StatusVal_UNIQUE` (`StatusVal` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`TaskType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`TaskType` (
  `TaskTypeID` INT NOT NULL AUTO_INCREMENT,
  `TaskTypeVal` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`TaskTypeID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Task` (
  `TaskID` INT NOT NULL AUTO_INCREMENT,
  `User_UserID` INT NOT NULL,
  `TaskType_TaskTypeID` INT NOT NULL,
  `Subject_SubjectID` INT NOT NULL,
  `Status_StatusID` INT NOT NULL,
  `Title` VARCHAR(75) NOT NULL,
  `Description` VARCHAR(300) NOT NULL,
  `NumPages` INT NOT NULL,
  `NumWords` INT NOT NULL,
  `ClaimantID` INT NULL,
  `Rated` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`TaskID`),
  INDEX `fk_Tasks_Subjects1_idx` (`Subject_SubjectID` ASC),
  INDEX `fk_Tasks_Users1_idx` (`User_UserID` ASC),
  INDEX `fk_Task_Status1_idx` (`Status_StatusID` ASC),
  INDEX `fk_Task_TaskType1_idx` (`TaskType_TaskTypeID` ASC),
  CONSTRAINT `fk_Tasks_Subjects1`
    FOREIGN KEY (`Subject_SubjectID`)
    REFERENCES `CS4014_project_database`.`Subject` (`SubjectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tasks_Users1`
    FOREIGN KEY (`User_UserID`)
    REFERENCES `CS4014_project_database`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Task_Status1`
    FOREIGN KEY (`Status_StatusID`)
    REFERENCES `CS4014_project_database`.`Status` (`StatusID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Task_TaskType1`
    FOREIGN KEY (`TaskType_TaskTypeID`)
    REFERENCES `CS4014_project_database`.`TaskType` (`TaskTypeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Deadline`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Deadline` (
  `Task_TaskID` INT NOT NULL,
  `Claim` DATE NOT NULL,
  `Completion` DATE NOT NULL,
  INDEX `fk_Deadlines_Tasks1_idx` (`Task_TaskID` ASC),
  PRIMARY KEY (`Task_TaskID`),
  CONSTRAINT `fk_Deadlines_Tasks1`
    FOREIGN KEY (`Task_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE CASCADE
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
-- Table `CS4014_project_database`.`DocumentType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`DocumentType` (
  `DocumentTypeID` INT NOT NULL AUTO_INCREMENT,
  `DocumentTypeVal` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`DocumentTypeID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Document`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Document` (
  `DocumentID` INT NOT NULL AUTO_INCREMENT,
  `DocumentURL` VARCHAR(255) NOT NULL,
  `SampleURL` VARCHAR(255) NOT NULL,
  `Task_TaskID` INT NOT NULL,
  `Format_FormatID` INT NOT NULL,
  `DocumentType_DocumentTypeID` INT NOT NULL,
  UNIQUE INDEX `DocumentURL_UNIQUE` (`DocumentURL` ASC),
  INDEX `fk_Documents_Tasks1_idx` (`Task_TaskID` ASC),
  PRIMARY KEY (`DocumentID`),
  INDEX `fk_Document_Format1_idx` (`Format_FormatID` ASC),
  INDEX `fk_Document_DocumentType1_idx` (`DocumentType_DocumentTypeID` ASC),
  CONSTRAINT `fk_Documents_Tasks1`
    FOREIGN KEY (`Task_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Document_Format1`
    FOREIGN KEY (`Format_FormatID`)
    REFERENCES `CS4014_project_database`.`Format` (`FormatID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Document_DocumentType1`
    FOREIGN KEY (`DocumentType_DocumentTypeID`)
    REFERENCES `CS4014_project_database`.`DocumentType` (`DocumentTypeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CS4014_project_database`.`Flag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Flag` (
  `FlagID` INT NOT NULL AUTO_INCREMENT,
  `Task_TaskID` INT NOT NULL,
  `Complaint` VARCHAR(200) NOT NULL,
  INDEX `fk_Flags_Tasks1_idx` (`Task_TaskID` ASC),
  PRIMARY KEY (`FlagID`),
  CONSTRAINT `fk_Flags_Tasks1`
    FOREIGN KEY (`Task_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE CASCADE
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
CREATE TABLE IF NOT EXISTS `CS4014_project_database`.`Click` (
  `clickID` INT NOT NULL AUTO_INCREMENT,
  `Task_TaskID` INT NOT NULL,
  `User_UserID` INT NOT NULL,
  INDEX `fk_Clicks_Tasks1_idx` (`Task_TaskID` ASC),
  PRIMARY KEY (`clickID`),
  INDEX `fk_Clicks_Users1_idx` (`User_UserID` ASC),
  CONSTRAINT `fk_Clicks_Tasks1`
    FOREIGN KEY (`Task_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Clicks_Users1`
    FOREIGN KEY (`User_UserID`)
    REFERENCES `CS4014_project_database`.`User` (`UserID`)
    ON DELETE CASCADE
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
  `Tag_TagID` INT NOT NULL,
  `Task_TaskID` INT NOT NULL,
  INDEX `fk_TaskTags_Tags1_idx` (`Tag_TagID` ASC),
  PRIMARY KEY (`TaskTagID`),
  INDEX `fk_TaskTags_Tasks1_idx` (`Task_TaskID` ASC),
  CONSTRAINT `fk_TaskTags_Tags1`
    FOREIGN KEY (`Tag_TagID`)
    REFERENCES `CS4014_project_database`.`Tag` (`TagID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TaskTags_Tasks1`
    FOREIGN KEY (`Task_TaskID`)
    REFERENCES `CS4014_project_database`.`Task` (`TaskID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


DROP VIEW IF EXISTS JoinedDocument;

CREATE VIEW JoinedDocument AS

SELECT * FROM Document, DocumentType, Format
	WHERE Document.DocumentType_DocumentTypeID = DocumentType.DocumentTypeID
	AND Document.Format_FormatID = Format.FormatID;

DROP VIEW IF EXISTS JoinedTag;

CREATE VIEW JoinedTag AS

SELECT *
	FROM TaskTag
	LEFT JOIN Tag
	ON TaskTag.Tag_TagID = Tag.TagID;

DROP VIEW IF EXISTS JoinedTask;

CREATE VIEW JoinedTask AS

SELECT TaskID,User_UserID,Title,TaskTypeVal,Description,NumPages,
NumWords,FormatVal,DocumentTypeVal,SubjectName,
DocumentURL,Claim,Completion,StatusVal,ClaimantID,Rated,SampleURL

FROM Task
LEFT JOIN Deadline
ON Task.TaskID = Deadline.Task_TaskID
LEFT JOIN JoinedDocument
ON Task.TaskID = JoinedDocument.Task_TaskID
LEFT JOIN TaskType
ON Task.TaskType_TaskTypeID = TaskType.TaskTypeID
LEFT JOIN Subject
ON Task.Subject_SubjectID = Subject.subjectID
LEFT JOIN Status
ON Task.Status_StatusID = Status.StatusID;




USE `CS4014_project_database` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
