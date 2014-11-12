-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 21 apr, 2013 at 12:03 AM
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
USE `dichred_client`;

--
-- Dump dei dati per la tabella `client`
--

-- the secret is md5sum of id
INSERT INTO `client` (`id`, `secret`, `description`, `as_auth_endpoint`, `as_token_endpoint`) VALUES
('dichred_clientid1', '7aba9979f96d797400ed5e6503f85972', 'Compilazione (automatica) online della dichiarazione dei redditi - 730.', 'https://localhost/oauth/v2/oauth/authorize', 'https://localhost/oauth/v2/oauth/token');

--
-- Dump dei dati per la tabella `scope`
--

INSERT INTO `scope` (`id`, `description`) VALUES
('lettura_dati_anagrafici', 'Comune - lettura dati anagrafici (nome, cognome, residenza, data e luogo di nascita, stato civile)'), ('lettura_dati_sostituto_imposta','Agenzia delle Entrate - lettura dati sostituto d\'imposta'), ('lettura_dati_contratti_locazione_fabbricati','Agenzia delle Entrate - lettura dati contratti locazione dei fabbricati'), ('lettura_dati_cud','Agenzia delle Entrate - lettura dati del CUD'), ('lettura_dati_spese_mediche','Agenzia delle Entrate - lettura dati delle spese mediche'), ('lettura_dati_fabbricati', 'Agenzia del Territorio - lettura dati dei fabbricati in possesso');
