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
-- Database: `dichred_client`
--
CREATE DATABASE IF NOT EXISTS `dichred_client` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dichred_client`;

-- --------------------------------------------------------

--
-- Struttura della tabella `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` varchar(200) NOT NULL,
  `secret` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `as_auth_endpoint` varchar(2000) NOT NULL,
  `as_token_endpoint` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds the client info';


-- --------------------------------------------------------

--
-- Struttura della tabella `scope`
--

DROP TABLE IF EXISTS `scope`;
CREATE TABLE IF NOT EXISTS `scope` (
  `id` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds scopes used to request data';


-- --------------------------------------------------------

