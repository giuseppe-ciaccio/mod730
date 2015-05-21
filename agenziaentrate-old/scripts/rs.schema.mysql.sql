-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 20 apr, 2013 at 02:31 PM
-- Versione MySQL: 5.1.66
-- Versione PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `agenziaentrate_rs`
--
CREATE DATABASE IF NOT EXISTS `agenziaentrate_rs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `agenziaentrate_rs`;

-- --------------------------------------------------------

--
-- Struttura della tabella `as_pubkey`
--

DROP TABLE IF EXISTS `as_pubkey`;
CREATE TABLE IF NOT EXISTS `as_pubkey` (
  `id` varchar(200) NOT NULL,
  `path` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds the Authorization Server public key file path';


-- --------------------------------------------------------

--
-- Struttura della tabella `rs_info`
--

DROP TABLE IF EXISTS `rs_info`;
CREATE TABLE IF NOT EXISTS `rs_info` (
  `id` varchar(200) NOT NULL,
  `shared_secret_key` varchar(64) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds the Resource Server information';


-- --------------------------------------------------------

