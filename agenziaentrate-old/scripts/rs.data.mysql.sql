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
-- Database: `agenziaentrate_rs`
--
USE `agenziaentrate_rs`;

--
-- Dump dei dati per la tabella `as_pubkey`
--

INSERT INTO `as_pubkey` (`id`, `path`) VALUES
('AS_1', 'public/pubkeys/as1_pub.pem'),
('AS_2', 'public/pubkeys/as2_pub.pem'),
('AS_3', 'public/pubkeys/as3_pub.pem'),
('AS_4', 'public/pubkeys/as4_pub.pem'),
('AS_5', 'public/pubkeys/as5_pub.pem');

--
-- Dump dei dati per la tabella `rs_info`
--
-- the shared_secret_key in this case is md5sum of id
INSERT INTO `rs_info` (`id`, `shared_secret_key`, `description`) VALUES
('agenziaentrate_rs_id', '936630ba1ecfb6e37803bd90140a8c93d61d4068d281c44acc428ea44701074c', 'Questo server si occupa delle richieste indirizzate alla Agenzia delle Entrate.');
