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

USE `agenziaentrate_dati`;


LOCK TABLES `sostituto_imposta` WRITE;
/*!40000 ALTER TABLE `sostituto_imposta` DISABLE KEYS */;
INSERT INTO `sostituto_imposta` (`cf`, `denominazione`, `comune`, `provincia`, `tipologia_indirizzo`, `indirizzo`, `num_civico`, `cap`, `frazione`, `telfax`, `email`, `codice_sede`) VALUES ('00826040156', 'SDI Sostituto Di Imposta', 'Genova', 'GE', 'via', 'XX Settembre', '5A', '16121', '', '010539923', 'info@sdi.it', '1');
/*!40000 ALTER TABLE `sostituto_imposta` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `contribuente` WRITE;
/*!40000 ALTER TABLE `contribuente` DISABLE KEYS */;
INSERT INTO `contribuente` (`cf`, `cf_sostituto_imposta`) VALUES ('RSSMRA85T10A562S', '00826040156');
/*!40000 ALTER TABLE `contribuente` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `spesa_medica` WRITE;
/*!40000 ALTER TABLE `spesa_medica` DISABLE KEYS */;
INSERT INTO `spesa_medica` (`importo`, `prestatore`, `indirizzo_prestatore`, `data_acquisto`, `aliquota_iva`, `descrizione`, `cf_app`) VALUES (50.00, 'Farmacia S. Anna dei frati Carmelitani scalzi', 'Piazza S. Anna, 8 - Genova', '2012-11-27 00:00:00', 4, 'Farmaco XXX', 'RSSMRA85T10A562S'), (150.33, 'Farmacia ADAMI snc', 'Via Tosco Romagnola, 2157 - Visignano - (PI)', '2012-09-02 00:00:00', 10, 'Farmaco A, B, C', 'RSSMRA85T10A562S'), (75.20, 'Farmacia BOTTARI', 'Borgo Stretto, 31 - Pisa (PI)', '2012-12-07 00:00:00', 4, 'Farmaco A', 'RSSMRA85T10A562S'), (350.10, 'Farmacia DEL CARMINE', 'Corso Italia, 54 - Pisa (PI)', '2012-06-07 00:00:00', 4, 'Farmaco D', 'RSSMRA85T10A562S'), (30.10, 'Farmacia SAN MARCO', 'Via Carlo Cattaneo - Pisa (PI)', '2012-04-27 00:00:00', 10, 'Farmaco W', 'RSSMRA85T10A562S');
/*!40000 ALTER TABLE `spesa_medica` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `cud` WRITE;
/*!40000 ALTER TABLE `cud` DISABLE KEYS */;
INSERT INTO `cud` (`reddito`, `tipologia_reddito`, `periodo_lavoro`, `rit_irpef`, `rit_add_reg`, `rit_acc_add_com_prec`, `rit_sal_add_com_prec`, `rit_acc_add_com_cur`, `cf_app`) VALUES (80000.00, 'dipendente_o_assimilati', 365, 130.00, 50.00, 50.50, 10.10, 40.40, 'RSSMRA85T10A562S');
/*!40000 ALTER TABLE `cud` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `contratto` WRITE;
/*!40000 ALTER TABLE `contratto` DISABLE KEYS */;
INSERT INTO `contratto` (/*`tipo`, */`numero`, `serie`, `id_oggetto`, `dal`, /*`al`, `tipo_titolare`,*/ `canone`, `cf_app`) VALUES ('324A', '3T', 1, '2010-06-27 00:00:00', 10000.00, 'RSSMRA85T10A562S');
/*!40000 ALTER TABLE `contratto` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
