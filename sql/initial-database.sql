SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `dvs_hotel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `dvs_hotel` ;

-- -----------------------------------------------------
-- Table `mydb`.`address`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dvs_hotel`.`address` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `line1` VARCHAR(20) NOT NULL ,
  `line2` VARCHAR(20) NULL DEFAULT NULL ,
  `city` VARCHAR(25) NOT NULL ,
  `postcode` VARCHAR(10) NOT NULL ,
  `country` VARCHAR(20) NOT NULL DEFAULT 'United Kingdom' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mydb`.`booking`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dvs_hotel`.`booking` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `room` INT(11) NOT NULL ,
  `noOfPeople` INT(11) NOT NULL ,
  `startdate` DATE NOT NULL ,
  `enddate` DATE NOT NULL ,
  PRIMARY KEY (`id`),
  KEY `room` (`room`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mydb`.`creditcard`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dvs_hotel`.`creditcard` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `card` BLOB NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mydb`.`customer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dvs_hotel`.`customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `firstname` VARCHAR(20) NOT NULL ,
  `surname` VARCHAR(20) NOT NULL ,
  `address` INT(11) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `booking` INT(11) NULL ,
  `creditcard` INT(11) NOT NULL ,
  `language` VARCHAR(25) NOT NULL DEFAULT 'English',
  PRIMARY KEY (`id`) ,
  KEY `booking` (`booking`) ,
  KEY `creditcard` (`creditcard`),
  KEY `address` (`address`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mydb`.`language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dvs_hotel`.`message` (
  `id` INT(4) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `code` VARCHAR(5) NOT NULL ,
  `content` BLOB NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `dvs_hotel`.`room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  `maxPeople` int(11) NOT NULL,
  `minPeople` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`room`) REFERENCES `room` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_5` FOREIGN KEY (`creditcard`) REFERENCES `creditcard` (`id`),
  ADD CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`address`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `customer_ibfk_4` FOREIGN KEY (`booking`) REFERENCES `booking` (`id`);



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
