-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 19, 2023 alle 15:54
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utenze`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `ID_Utente` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Livello` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Struttura della tabella `spese`
--

CREATE TABLE spese (
   ID_Spese INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   ID_Utente INT NOT NULL,
   dataspesa DATE NOT NULL,
   importo NUMERIC(6,2) NOT NULL,
   descrizione VARCHAR(50)
);

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`Nome`, `Cognome`, `Username`, `Password`, `Livello`) VALUES
('Fabio', 'Pinzarrone', 'fabiopinza', 'password', 2),
('Utente', 'Amministratore', 'admin', 'admin', 2),
('Andrea', 'Davoli', 'driu', 'delfinogiallo', 1),
('Eduard', 'Sascau', 'sascu', 'AIUTO', 1),
('Nicholas', 'Valenzano', 'NichoZ', 'pollo', 9);

--
-- Dump dei dati per la tabella `spese`
--

INSERT INTO `spese` (`ID_Utente`,`dataspesa`,`importo`,`descrizione`) VALUES
(2,20230204,45.50,'pranzo'),
(2,20230205,60.00,'carburante'),
(1,20230204,100.00,'hotel');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
