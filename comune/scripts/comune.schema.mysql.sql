-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 14 mag, 2013 at 12:43 PM
-- Versione MySQL: 5.1.66
-- Versione PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `comune_dati`
--
DROP DATABASE `comune_dati`;
CREATE DATABASE `comune_dati` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `comune_dati`;

-- --------------------------------------------------------

--
-- Struttura della tabella `nucleo_familiare`
--

CREATE TABLE IF NOT EXISTS `nucleo_familiare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cf` varchar(16) NOT NULL,
  `tipo` enum('coniuge', 'primo_figlio', 'figlio', 'altro') NOT NULL,
  `minore_tre_anni` int NOT NULL,
  `cf_app` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cf_app` (`cf_app`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `nucleo_familiare`
--



--
-- Struttura della tabella `residente`
--

CREATE TABLE IF NOT EXISTS `residente` (
  `cf` varchar(16) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `sesso` enum('M','F') NOT NULL,
  `data_nascita` datetime NOT NULL,
  `comune_nascita` varchar(100) NOT NULL,
  `provincia_nascita` varchar(100) NOT NULL,
  `stato_civile` enum('celibe/nubile','coniugato/a','vedovo/a','separato/a','divorziato/a','tutelato/a','minore') NOT NULL,
  `comune_residenza` varchar(100) NOT NULL,
  `provincia_residenza` varchar(100) NOT NULL,
  `cap_residenza` varchar(100) NOT NULL,
  `tipologia_residenza` varchar(100) NOT NULL,
  `indirizzo_residenza` varchar(100) NOT NULL,
  `numcivico_residenza` varchar(20) NOT NULL,
  `frazione_residenza` varchar(100) NOT NULL,
  `ultima_variazione_residenza` datetime NOT NULL,
  PRIMARY KEY (`cf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

