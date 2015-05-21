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
-- Database: `comune_rs`
--
USE `comune_rs`;

--
-- Struttura della tabella `rset_info`
--

DROP TABLE IF EXISTS `rset_info`;
CREATE TABLE IF NOT EXISTS `rset_info` (
  `rset_id` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `uri` varchar(200) NOT NULL,
  `table` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(200) DEFAULT NULL,
  `colselect` varchar(300) NOT NULL,
  PRIMARY KEY (`rset_id`),
  FULLTEXT KEY `name` (`name`,`uri`,`description`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Struttura della tabella `rset_scope`
--

DROP TABLE IF EXISTS `rset_scope`;
CREATE TABLE IF NOT EXISTS `rset_scope` (
  `scope_uri` varchar(100) NOT NULL,
  `rset_id` varchar(100) NOT NULL,
  PRIMARY KEY (`scope_uri`,`rset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Struttura della tabella `scope`
--

DROP TABLE IF EXISTS `scope`;
CREATE TABLE IF NOT EXISTS `scope` (
  `scope_id` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `uri` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`scope_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

