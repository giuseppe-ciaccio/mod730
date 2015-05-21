USE `comune_dati`;

/*
 * RESIDENTE
 *
 */
 
INSERT INTO `residente` (`cf`,`nome`,`cognome`,`sesso`,`data_nascita`,`comune_nascita`,`provincia_nascita`,`stato_civile`,`comune_residenza`,`provincia_residenza`,`cap_residenza`,`tipologia_residenza`,`indirizzo_residenza`,`numcivico_residenza`,`frazione_residenza`,`ultima_variazione_residenza`) VALUES ('RSSMRA85T10A562S','Rossi','Mario','M','1985-12-10 12:30:06','SAN GIULIANO TERME','PI','coniugato/a','Pisa','PI','56100','piazza','Roma','3','','2010-06-27 07:28:58');

/*
 * ======================================================
 * Familiari a carico
 */
 
INSERT INTO `nucleo_familiare` (`cf`,`tipo`,`minore_tre_anni`,`cf_app`) VALUES ('RSSLRA86T50A562W', 'coniuge', 0, 'RSSMRA85T10A562S');
INSERT INTO `nucleo_familiare` (`cf`,`tipo`,`minore_tre_anni`,`cf_app`) VALUES ('RSSCHR90T50A562J', 'primo_figlio', 0, 'RSSMRA85T10A562S');
INSERT INTO `nucleo_familiare` (`cf`,`tipo`,`minore_tre_anni`,`cf_app`) VALUES ('RSSFNC94T10A562A', 'figlio', 0, 'RSSMRA85T10A562S');

