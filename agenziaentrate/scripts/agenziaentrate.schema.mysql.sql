SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Database: `agenziaentrate_dati`
--

DROP DATABASE `agenziaentrate_dati`;
CREATE DATABASE `agenziaentrate_dati` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `agenziaentrate_dati`;


CREATE TABLE IF NOT EXISTS `contribuente` (
  `cf` varchar(16) NOT NULL,
  `cf_sostituto_imposta` varchar(16) NOT NULL,
  PRIMARY KEY (`cf`),
  KEY `cf_sostituto_imposta` (`cf_sostituto_imposta`),
  CONSTRAINT `fk_sost_imp` FOREIGN KEY (`cf_sostituto_imposta`) REFERENCES `sostituto_imposta` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `sostituto_imposta` (
  `cf` varchar(16) NOT NULL,
  `denominazione` varchar(100) NOT NULL,
  `comune` varchar(100) NOT NULL,
  `provincia` varchar(3) NOT NULL,
  `tipologia_indirizzo` varchar(50) NOT NULL,
  `indirizzo` varchar(100) NOT NULL,
  `num_civico` varchar(10) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `frazione` varchar(100) NOT NULL,
  `telfax` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codice_sede` varchar(10) NOT NULL,
  PRIMARY KEY (`cf`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `spesa_medica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `importo` decimal(10, 2) NOT NULL,
  `prestatore` varchar(50) NOT NULL,
  `indirizzo_prestatore` varchar(150) NOT NULL,
  `data_acquisto` date NULL,
  `aliquota_iva` int NOT NULL,
  `descrizione` varchar(200),
  `cf_app` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cf_app` (`cf_app`),
  CONSTRAINT `fk_spesa_medica_cf_app` FOREIGN KEY (`cf_app`) REFERENCES `contribuente` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `cud` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reddito` decimal(10,2) NOT NULL,
  `tipologia_reddito` ENUM ('pensione', 'dipendente_o_assimilati') NOT NULL,
  `periodo_lavoro` int NOT NULL,
  `rit_irpef` decimal(10,2) NOT NULL,
  `rit_add_reg` decimal(10,2) NOT NULL,
  `rit_acc_add_com_prec` decimal(10,2) NOT NULL,
  `rit_sal_add_com_prec` decimal(10,2) NOT NULL,
  `rit_acc_add_com_cur` decimal(10,2) NOT NULL,
  `cf_app` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cf_app` (`cf_app`),
  CONSTRAINT `fk_cud_cf_app` FOREIGN KEY (`cf_app`) REFERENCES `contribuente` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `contratto` (
  `id` int NOT NULL AUTO_INCREMENT,
/*  `tipo` IN ('terreno', 'fabbricato') NOT NULL,*/
  `numero` varchar(10) NOT NULL,
  `serie` varchar(10) NOT NULL,
  `id_oggetto` int NOT NULL,
  `dal` datetime NOT NULL,
/*  `al` datetime,*/
/*  `tipo_titolare` ENUM ('locatario', 'conduttore') NOT NULL,*/
  `canone` decimal(10,2) NOT NULL,
  `cf_app` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cf_app` (`cf_app`),
  CONSTRAINT `fk_contratto_cf_app` FOREIGN KEY (`cf_app`) REFERENCES `contribuente` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
