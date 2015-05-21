-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 20 apr, 2013 at 02:31 PM
-- Versione MySQL: 5.1.66
-- Versione PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Struttura della tabella `client`
--

DROP TABLE IF EXISTS `authserver`;
CREATE TABLE IF NOT EXISTS `authserver` (
  `id` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `auth_endpoint` varchar(2000) NOT NULL,
  `token_endpoint` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds the client info';

--
-- Struttura della tabella `scope`
--

DROP TABLE IF EXISTS `scope`;
CREATE TABLE IF NOT EXISTS `scope` (
  `id` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table holds scopes used to request data';
