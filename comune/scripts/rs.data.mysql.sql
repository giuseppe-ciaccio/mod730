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
-- Database: `comune_rs`
--
USE `comune_rs`;

--
-- Dump dei dati per la tabella `scope`
--
-- TODO: gli URL assoluti non vanno bene xke richiede di cablare hostname

INSERT INTO `scope` (`scope_id`, `name`, `uri`, `description`) VALUES
('SCOPE_1', 'read', 'https://localhost/comune/resource/readscope', 'lettura dati anagrafici'),
('SCOPE_2', 'write', 'https://localhost/comune/resource/writescope', 'scrittura dati anagrafici'),
('SCOPE_3', 'update', 'https://localhost/comune/resource/resource/updatescope', 'modifica dati anagrafici'),
('SCOPE_4', 'delete', 'https://localhost/comune/resource/resource/deletescope', 'cancellazione dati anagrafici');

