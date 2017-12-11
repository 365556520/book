-- MySQL Script generated by MySQL Workbench
-- Mon Dec 11 14:19:19 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema book
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema book
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `book` DEFAULT CHARACTER SET utf8 ;
USE `book` ;

-- -----------------------------------------------------
-- Table `book`.`book_member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_member` (
  `member_id` INT UNIQUE NOT NULL AUTO_INCREMENT COMMENT '//用户id',
  `member_nickname` VARCHAR(16) NULL COMMENT '//用户昵称',
  `member_email` VARCHAR(80) NULL,
  `member_phone` VARCHAR(45) NULL COMMENT '//用户手机',
  `member_password` VARCHAR(255) NOT NULL COMMENT '//用户密码',
  `member_active` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`member_id`));


-- -----------------------------------------------------
-- Table `book`.`book_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_category` (
  `category_id` INT UNIQUE NOT NULL AUTO_INCREMENT COMMENT '//书类别id',
  `category_name` VARCHAR(20) NULL COMMENT '//书类别名称',
  `category_no` INT NULL COMMENT '//书类别排序',
  `category_preview` VARCHAR(255) NULL COMMENT '//书类别缩略图',
  `parent_id` VARCHAR(45) NULL COMMENT '//父类别ID',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`category_id`));


-- -----------------------------------------------------
-- Table `book`.`book_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_product` (
  `product_id` INT UNIQUE NOT NULL AUTO_INCREMENT COMMENT '//产品id',
  `product_name` VARCHAR(30) NULL COMMENT '//产品名称',
  `product_summary` VARCHAR(255) NULL COMMENT '//产品详细情',
  `product_price` DECIMAL(10,2) NULL COMMENT '//产品价钱',
  `product_preview` VARCHAR(255) NULL COMMENT '//预览图',
  `category_id` INT NULL COMMENT '//产品分类id',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`product_id`));


-- -----------------------------------------------------
-- Table `book`.`book_pdt_content`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_pdt_content` (
  `content_id` INT UNIQUE NOT NULL AUTO_INCREMENT COMMENT '//产品详情内容id',
  `content` VARCHAR(20000) NULL COMMENT '//产品内容',
  `product_id` INT NULL COMMENT '//产品id',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`content_id`));


-- -----------------------------------------------------
-- Table `book`.`book_pdt_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_pdt_images` (
  `image_id` INT UNIQUE NOT NULL AUTO_INCREMENT COMMENT '//产品图片id',
  `image_path` VARCHAR(200) NULL COMMENT '//产品图片路径',
  `image_no` INT NULL COMMENT '//产品图片排序',
  `product_id` INT NULL COMMENT '//产品id',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`image_id`));


-- -----------------------------------------------------
-- Table `book`.`book_temp_phone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_temp_phone` (
  `phone_id` INT UNIQUE NOT NULL AUTO_INCREMENT,
  `phone_phone` VARCHAR(11) NULL,
  `phone_code` VARCHAR(7) NULL,
  `phone_deadline` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`phone_id`));


-- -----------------------------------------------------
-- Table `book`.`book_temp_email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book`.`book_temp_email` (
  `email_id` INT UNIQUE NOT NULL AUTO_INCREMENT,
  `email_member_id` INT NOT NULL,
  `email_code` VARCHAR(45) NULL,
  `email_deadline` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`email_id`));


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
