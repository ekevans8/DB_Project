-- MySQL Script generated by MySQL Workbench
-- 11/20/15 14:24:54
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema musicTracker
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `musicTracker` ;

-- -----------------------------------------------------
-- Schema musicTracker
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `musicTracker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `musicTracker` ;

-- -----------------------------------------------------
-- Table `musicTracker`.`tracklist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`tracklist` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`tracklist` (
  `albumId` INT NOT NULL,
  `songId` INT NOT NULL,
  `artistId` INT NOT NULL,
  PRIMARY KEY (`albumId`, `songId`, `artistId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`album` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`album` (
  `albumId` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `recordLabel` VARCHAR(100) NOT NULL,
  `releaseDate` DATE NOT NULL,
  PRIMARY KEY (`albumId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`favorite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`favorite` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`favorite` (
  `username` VARCHAR(16) NOT NULL,
  `artistId` INT NOT NULL,
  PRIMARY KEY (`username`, `artistId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`artist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`artist` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`artist` (
  `artistId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `formDate` DATE NOT NULL,
  `breakupDate` DATE NULL,
  `formationZipCode` INT NOT NULL,
  PRIMARY KEY (`artistId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`user` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`user` (
  `username` VARCHAR(16) NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `age` INT NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `zipcode` INT NOT NULL,
  `isModerator` TINYINT(1) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`song`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`song` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`song` (
  `songId` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `duration` DOUBLE NOT NULL,
  `track_number` INT NULL,
  PRIMARY KEY (`songId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`performance_playlist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`performance_playlist` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`performance_playlist` (
  `performanceId` INT NOT NULL,
  `songId` INT NOT NULL,
  `artistId` INT NOT NULL,
  PRIMARY KEY (`performanceId`, `songId`, `artistId`),
  INDEX `fk_performance_playlist_song2_idx` (`songId` ASC),
  INDEX `fk_performance_playlist_artist1_idx` (`artistId` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`venue`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`venue` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`venue` (
  `venueId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `streetAddress` VARCHAR(200) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `zipcode` INT NOT NULL,
  PRIMARY KEY (`venueId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`performance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`performance` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`performance` (
  `performanceId` INT NOT NULL AUTO_INCREMENT,
  `duration` DOUBLE NOT NULL,
  `venueId` INT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`performanceId`),
  INDEX `fk_performance_venue2_idx` (`venueId` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`attended_performance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`attended_performance` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`attended_performance` (
  `username` VARCHAR(16) NOT NULL,
  `performanceId` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`, `performanceId`),
  INDEX `fk_attended_performance_performance2_idx` (`performanceId` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`comment` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`comment` (
  `commentId` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(16) NOT NULL,
  `artistId` INT NOT NULL,
  `performanceId` INT NOT NULL,
  `comment` VARCHAR(300) NOT NULL,
  `postDate` DATE NOT NULL,
  PRIMARY KEY (`commentId`),
  INDEX `fk_comment_user2_idx` (`username` ASC),
  INDEX `fk_comment_artist2_idx` (`artistId` ASC),
  INDEX `fk_comment_performance2_idx` (`performanceId` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `musicTracker`.`member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `musicTracker`.`member` ;

CREATE TABLE IF NOT EXISTS `musicTracker`.`member` (
  `memberId` INT NOT NULL AUTO_INCREMENT,
  `artistId` INT NOT NULL,
  `joinDate` DATE NOT NULL,
  `leaveDate` DATE NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`memberId`),
  INDEX `fk_member_artist2_idx` (`artistId` ASC))
ENGINE = InnoDB;

USE `musicTracker` ;

-- -----------------------------------------------------
-- Placeholder table for view `musicTracker`.`artistinfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `musicTracker`.`artistinfo` (`artistName` INT, `artistFormDate` INT, `artistBreakupDate` INT, `memberJoinDate` INT, `memberLeaveDate` INT, `memberName` INT);

-- -----------------------------------------------------
-- Placeholder table for view `musicTracker`.`favoriteartistinfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `musicTracker`.`favoriteartistinfo` (`username` INT, `artistName` INT);

-- -----------------------------------------------------
-- Placeholder table for view `musicTracker`.`AlbumSummaries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `musicTracker`.`AlbumSummaries` (`albumId` INT, `Album_Title` INT, `recordLabel` INT, `releaseDate` INT, `Song_Title` INT, `duration` INT, `track_number` INT, `Artist_Name` INT, `songId` INT);

-- -----------------------------------------------------
-- Placeholder table for view `musicTracker`.`PerformanceSummary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `musicTracker`.`PerformanceSummary` (`performanceId` INT, `duration` INT, `date` INT, `VenuName` INT, `streetAddress` INT, `city` INT, `state` INT, `zipcode` INT, `SongTitle` INT, `Artist` INT, `artistId` INT, `venueId` INT);

-- -----------------------------------------------------
-- View `musicTracker`.`artistinfo`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `musicTracker`.`artistinfo` ;
DROP TABLE IF EXISTS `musicTracker`.`artistinfo`;
USE `musicTracker`;
CREATE  OR REPLACE VIEW `artistinfo` AS
    SELECT 
        `ar`.`name` AS `artistName`,
        `ar`.`formDate` AS `artistFormDate`,
        `ar`.`breakupDate` AS `artistBreakupDate`,
        `mr`.`joinDate` AS `memberJoinDate`,
        `mr`.`leaveDate` AS `memberLeaveDate`,
        `mr`.`name` AS `memberName`
    FROM
        `artist` `ar`
        JOIN `member` `mr` ON `ar`.`artistId` = `mr`.`artistId`;

-- -----------------------------------------------------
-- View `musicTracker`.`favoriteartistinfo`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `musicTracker`.`favoriteartistinfo` ;
DROP TABLE IF EXISTS `musicTracker`.`favoriteartistinfo`;
USE `musicTracker`;
CREATE  OR REPLACE VIEW `favoriteartistinfo` AS
select 
fav.username,
ast.name as artistName
from favorite fav join artist ast on fav.artistId = ast.artistId;

-- -----------------------------------------------------
-- View `musicTracker`.`AlbumSummaries`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `musicTracker`.`AlbumSummaries` ;
DROP TABLE IF EXISTS `musicTracker`.`AlbumSummaries`;
USE `musicTracker`;
CREATE  OR REPLACE VIEW `AlbumSummaries` AS
    SELECT 
        alb.albumId,
        alb.title AS Album_Title,
        alb.recordLabel,
        alb.releaseDate,
        sg.title AS Song_Title,
        sg.duration,
        sg.track_number,
        art.name AS Artist_Name,
        sg.songId
    FROM
        album alb
            JOIN
        tracklist tl ON alb.albumId = tl.albumId
            JOIN
        song sg ON tl.songId = sg.songId
            JOIN
        artist art ON tl.artistId = art.artistId;


-- -----------------------------------------------------
-- View `musicTracker`.`PerformanceSummary`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `musicTracker`.`PerformanceSummary` ;
DROP TABLE IF EXISTS `musicTracker`.`PerformanceSummary`;
USE `musicTracker`;
CREATE  OR REPLACE VIEW `PerformanceSummary` AS
    SELECT 
        pro.performanceId,
        pro.duration,
        pro.date,
        ven.name AS VenuName,
        ven.streetAddress,
        ven.city,
        ven.state,
        ven.zipcode,
        sg.title AS SongTitle,
        art.name AS Artist,
		proPlay.artistId,
        pro.venueId
    FROM
        performance pro
            JOIN
        venue ven ON pro.venueId = ven.venueId
            JOIN
        performance_playlist proPlay ON pro.performanceId = proPlay.performanceId
            JOIN
        song sg ON proPlay.songId = sg.songId
            JOIN
        artist art ON proPlay.artistId = art.artistId;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
