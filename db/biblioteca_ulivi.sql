-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 15, 2024 alle 16:28
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca_ulivi`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPrenotazioneCarta` (IN `idUtente` INT, IN `idCarta` INT)   BEGIN
    -- Inserisci un record nella tabella tprenotazionevolume
    INSERT INTO tprenotazionecarta (idUtente, idCarta, data)
    VALUES (idUtente, idCarta, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPrenotazioneLibro` (IN `idUtente` INT, IN `idLibro` INT)   BEGIN
    -- Inserisci un record nella tabella tprenotazionevolume
    INSERT INTO tprenotazionelibro (idUtente, idLibro, data)
    VALUES (idUtente, idLibro, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPrenotazioneVolume` (IN `idUtente` INT, IN `idVolume` INT)   BEGIN
    -- Inserisci un record nella tabella tprenotazionevolume
    INSERT INTO tprenotazionevolume (idUtente, idVolume, data)
    VALUES (idUtente, idVolume, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RevocaPrestitoCarta` (IN `insIdCarta` INT, IN `insIdUtente` INT, IN `insIdPersonale` INT)   BEGIN
    DELETE FROM tprestitocarta WHERE idUtente = insIdUtente AND idCarta = insIdCarta;
	DELETE FROM tprenotazionecarta WHERE idUtente = insIdUtente AND idCarta = insIdCarta;
	UPDATE tcarta SET disponibile = 1 WHERE idCarta = insIdCarta;
    INSERT INTO trestituzionecarta (data, idPersonale, idUtente, idCarta) VALUES (NOW(), insIdPersonale, insIdUtente, insIdCarta);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RevocaPrestitoLibro` (IN `insIdLibro` INT, IN `insIdUtente` INT, IN `insIdPersonale` INT)   BEGIN
    DELETE FROM tprestitolibro WHERE idUtente = insIdUtente AND idLibro = insIdLibro;
	DELETE FROM tprenotazionelibro WHERE idUtente = insIdUtente AND idLibro = insIdLibro;
	UPDATE tlibro SET disponibile = 1 WHERE idLibro = insIdLibro;
    INSERT INTO trestituzionelibro (data, idPersonale, idUtente, idLibro) VALUES (NOW(), insIdPersonale, insIdUtente, insIdLibro);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RevocaPrestitoVolume` (IN `insIdVolume` INT, IN `insIdUtente` INT, IN `insIdPersonale` INT)   BEGIN
    DELETE FROM tprestitovolume WHERE idUtente = insIdUtente AND idVolume = insIdVolume;
	DELETE FROM tprenotazionevolume WHERE idUtente = insIdUtente AND idVolume = insIdVolume;
	UPDATE tvolume SET disponibile = 1 WHERE idVolume = insIdVolume;
    INSERT INTO trestituzionevolume (data, idPersonale, idUtente, idVolume) VALUES (NOW(), insIdPersonale, insIdUtente, insIdVolume);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `prenotazionilibri`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `prenotazionilibri` (
`data` date
,`titolo` varchar(255)
,`idUtente` int(11)
,`idLibro` int(11)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `tautorecarta`
--

CREATE TABLE `tautorecarta` (
  `idAutoreCarta` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `idCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tautorecarta`
--

INSERT INTO `tautorecarta` (`idAutoreCarta`, `nome`, `cognome`, `idCarta`) VALUES
(1, 'Giovanni', 'Rossi', 1),
(2, 'Maria', 'Bianchi', 1),
(3, 'Marco', 'Verdi', 1),
(4, 'Laura', 'Russo', 2),
(5, 'Luca', 'Ferrari', 3),
(6, 'Francesca', 'Esposito', 3),
(7, 'Davide', 'Romano', 11),
(8, 'Giulia', 'Galli', 12),
(9, 'Paolo', 'Conti', 13),
(10, 'Anna', 'Marchetti', 13),
(11, 'Giovanni', 'Rossi', 14),
(12, 'Maria', 'Bianchi', 15),
(13, 'Marco', 'Verdi', 15),
(14, 'Laura', 'Russo', 16),
(15, 'Luca', 'Ferrari', 17);

-- --------------------------------------------------------

--
-- Struttura della tabella `tautoreenciclopedia`
--

CREATE TABLE `tautoreenciclopedia` (
  `idAutoreEnciclopedia` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `idEnciclopedia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tautoreenciclopedia`
--

INSERT INTO `tautoreenciclopedia` (`idAutoreEnciclopedia`, `nome`, `cognome`, `idEnciclopedia`) VALUES
(1, 'Elena', 'Rossi', 1),
(2, 'Marco', 'Bianchi', 1),
(3, 'Anna', 'Moretti', 2),
(4, 'Luca', 'De Santis', 2),
(5, 'Chiara', 'Romano', 3),
(6, 'Giovanni', 'Martini', 4),
(7, 'Francesca', 'Conti', 4),
(8, 'Andrea', 'Russo', 4),
(9, 'Laura', 'Ferrari', 5),
(10, 'Matteo', 'Esposito', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `tcarta`
--

CREATE TABLE `tcarta` (
  `idCarta` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `annoPubblicazione` year(4) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `annoRiferimento` year(4) NOT NULL,
  `disponibile` tinyint(1) NOT NULL,
  `nomeCasaEditrice` varchar(255) NOT NULL,
  `codiceScaffale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tcarta`
--

INSERT INTO `tcarta` (`idCarta`, `titolo`, `annoPubblicazione`, `ISBN`, `annoRiferimento`, `disponibile`, `nomeCasaEditrice`, `codiceScaffale`) VALUES
(1, 'Carta Geo-Politica Italia', '2011', '978-1-23-456789-7', '2010', 1, 'Mondadori', 11),
(2, 'Carta Geo-Politica Europa', '2024', '423-9-31-43190-0', '2023', 1, 'Treccani', 12),
(3, 'Carta Geo-Politica Africa', '2015', '378-1-23-31234-7', '2013', 0, 'De Agostini', 13),
(11, 'Mappa Politica Asia', '2015', '378-2-23-31234-7', '2013', 0, 'De Agostini', 14),
(12, 'Carta Geo-Politica Mondiale', '2018', '978-1-45-987654-3', '2016', 1, 'National Geographic', 15),
(13, 'Mappa Politica Europa', '2014', '438-5-63-48765-9', '2012', 0, 'De Agostini', 16),
(14, 'Mappa Storica Antica Roma', '2010', '273-9-82-12345-2', '2008', 1, 'Mondadori', 17),
(15, 'Mappa Politica Canada', '2017', '764-2-34-98765-1', '2016', 1, 'Mondadori', 18),
(16, 'Mappa Politica Finlandia', '2019', '647-8-91-87654-0', '2018', 0, 'Feltrinelli', 19),
(17, 'Mappa Politica Russia', '2016', '567-3-45-67890-4', '2015', 1, 'Feltrnelli', 20);

-- --------------------------------------------------------

--
-- Struttura della tabella `tenciclopedia`
--

CREATE TABLE `tenciclopedia` (
  `idEnciclopedia` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `annoPubblicazione` year(4) NOT NULL,
  `nVolumi` int(11) NOT NULL,
  `nomeCasaEditrice` varchar(255) NOT NULL,
  `codiceScaffale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tenciclopedia`
--

INSERT INTO `tenciclopedia` (`idEnciclopedia`, `titolo`, `annoPubblicazione`, `nVolumi`, `nomeCasaEditrice`, `codiceScaffale`) VALUES
(1, 'Enciclopedia Universale: Dal Big Bang alla Vita Moderna', '2005', 3, 'Zanichelli', 21),
(2, 'Enciclopedia Universale: Dal Big Bang alla Vita Moderna', '2005', 3, 'Mondadori', 22),
(3, 'Enciclopedia Storica del Mondo Antico', '2020', 2, 'Treccani', 23),
(4, 'Enciclopedia delle Arti e della Cultura Globale', '2008', 3, 'Treccani', 24),
(5, 'Enciclopedia dei Popoli del Mondo: Storia, Cultura e Tradizioni', '2024', 4, 'Zanichelli', 25);

-- --------------------------------------------------------

--
-- Struttura della tabella `tfigurazionecarta`
--

CREATE TABLE `tfigurazionecarta` (
  `idFigurazioneCarta` int(11) NOT NULL,
  `nomeAutore` varchar(255) NOT NULL,
  `cognomeAutore` varchar(255) NOT NULL,
  `idCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tlibro`
--

CREATE TABLE `tlibro` (
  `idLibro` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `annoPubblicazione` year(4) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `disponibile` tinyint(1) NOT NULL,
  `nomeCasaEditrice` varchar(255) NOT NULL,
  `nomeAutore` varchar(255) NOT NULL,
  `cognomeAutore` varchar(255) NOT NULL,
  `codiceScaffale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tlibro`
--

INSERT INTO `tlibro` (`idLibro`, `titolo`, `annoPubblicazione`, `ISBN`, `disponibile`, `nomeCasaEditrice`, `nomeAutore`, `cognomeAutore`, `codiceScaffale`) VALUES
(2, 'Il mistero della villa abbandonata', '2023', '978-12-34-56789-0', 1, 'Mondadori', 'Giulia', 'Marini', 1),
(3, 'L\'eredità ritrovata', '2021', '978-13-24-56789-0', 1, 'Feltrinelli', 'Marco', 'Rossi', 2),
(4, 'Segreti nel buio', '1988', '978-14-34-56789-0', 1, 'Feltrinelli', 'Laura', 'Bianchi', 3),
(5, 'Viaggio nel tempo', '1998', '978-15-24-56789-0', 1, 'Mondadori', 'Giuseppe', 'Verdi', 4),
(6, 'Il segreto del faro', '2011', '978-16-34-56789-0', 1, 'Zanichelli', 'Sara', 'Gialli', 5),
(7, 'Ritorno al passato', '2023', '978-17-24-56789-0', 1, 'De Agostini', 'Marco', 'Rossi', 6),
(8, 'La trappola mortale', '2021', '978-18-34-56789-0', 1, 'Zanichelli', 'Giulia', 'Marini', 7),
(9, 'Il segreto della montagna', '2020', '978-19-24-56789-0', 1, 'Giunti', 'Antonio', 'Bianchi', 8),
(10, 'Il mistero del lago', '2019', '978-20-34-56789-0', 1, 'Giunti', 'Sara', 'Rossi', 9),
(11, 'La maledizione della cripta', '2022', '978-21-24-56789-0', 0, 'Mondadori', 'Marco', 'Verdi', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `tpersonale`
--

CREATE TABLE `tpersonale` (
  `idPersonale` int(11) NOT NULL,
  `nomeUtente` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tpersonale`
--

INSERT INTO `tpersonale` (`idPersonale`, `nomeUtente`, `password`) VALUES
(1, 'giovanni34', 'password'),
(2, 'lucia45', '1234');

-- --------------------------------------------------------

--
-- Struttura della tabella `tposizione`
--

CREATE TABLE `tposizione` (
  `codiceScaffale` int(11) NOT NULL,
  `identificativoArmadio` varchar(255) NOT NULL,
  `identificativoStanza` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tposizione`
--

INSERT INTO `tposizione` (`codiceScaffale`, `identificativoArmadio`, `identificativoStanza`) VALUES
(1, 'A', 'Stanza Libri'),
(2, 'A', 'Stanza Libri'),
(3, 'A', 'Stanza Libri'),
(4, 'A', 'Stanza Libri'),
(5, 'A', 'Stanza Libri'),
(6, 'B', 'Stanza Libri'),
(7, 'B', 'Stanza Libri'),
(8, 'B', 'Stanza Libri'),
(9, 'B', 'Stanza Libri'),
(10, 'B', 'Stanza Libri'),
(11, 'C', 'Stanza Carte'),
(12, 'C', 'Stanza Carte'),
(13, 'C', 'Stanza Carte'),
(14, 'C', 'Stanza Carte'),
(15, 'C', 'Stanza Carte'),
(16, 'C', 'Stanza Carte'),
(17, 'D', 'Stanza Carte'),
(18, 'D', 'Stanza Carte'),
(19, 'D', 'Stanza Carte'),
(20, 'E', 'Stanza Carte'),
(21, 'F', 'Stanza Enciclopedie'),
(22, 'F', 'Stanza Enciclopedie'),
(23, 'F', 'Stanza Enciclopedie'),
(24, 'G', 'Stanza Enciclopedie'),
(25, 'G', 'Stanza Enciclopedie');

-- --------------------------------------------------------

--
-- Struttura della tabella `tprenotazionecarta`
--

CREATE TABLE `tprenotazionecarta` (
  `idPrenotazioneCarta` int(11) NOT NULL,
  `data` date NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tprenotazionecarta`
--

INSERT INTO `tprenotazionecarta` (`idPrenotazioneCarta`, `data`, `idUtente`, `idCarta`) VALUES
(1, '2024-05-11', 1, 3),
(2, '2024-05-11', 1, 1),
(3, '2024-05-11', 1, 2),
(4, '2024-05-12', 2, 2),
(5, '2024-05-12', 2, 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `tprenotazionelibro`
--

CREATE TABLE `tprenotazionelibro` (
  `idPrenotazioneLibro` int(11) NOT NULL,
  `data` date NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tprenotazionelibro`
--

INSERT INTO `tprenotazionelibro` (`idPrenotazioneLibro`, `data`, `idUtente`, `idLibro`) VALUES
(2, '2024-05-11', 1, 3),
(4, '2024-05-12', 1, 9),
(5, '2024-05-12', 1, 5),
(6, '2024-05-12', 2, 10),
(7, '2024-05-12', 2, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `tprenotazionevolume`
--

CREATE TABLE `tprenotazionevolume` (
  `idPrenotazioneVolume` int(11) NOT NULL,
  `data` date NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idVolume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tprenotazionevolume`
--

INSERT INTO `tprenotazionevolume` (`idPrenotazioneVolume`, `data`, `idUtente`, `idVolume`) VALUES
(7, '2024-05-11', 1, 15),
(8, '2024-05-12', 2, 14),
(9, '2024-05-12', 2, 13),
(10, '2024-05-12', 2, 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `tprestitocarta`
--

CREATE TABLE `tprestitocarta` (
  `idPrestitoCarta` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonaleErogatore` int(11) NOT NULL,
  `idPersonaleConsegna` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tprestitocarta`
--

INSERT INTO `tprestitocarta` (`idPrestitoCarta`, `data`, `idPersonaleErogatore`, `idPersonaleConsegna`, `idUtente`, `idCarta`) VALUES
(1, '2024-05-08', 2, 1, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `tprestitolibro`
--

CREATE TABLE `tprestitolibro` (
  `idPrestitoLibro` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonaleErogatore` int(11) NOT NULL,
  `idPersonaleConsegna` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tprestitovolume`
--

CREATE TABLE `tprestitovolume` (
  `idPrestitoVolume` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonaleErogatore` int(11) NOT NULL,
  `idPersonaleConsegna` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idVolume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tprestitovolume`
--

INSERT INTO `tprestitovolume` (`idPrestitoVolume`, `data`, `idPersonaleErogatore`, `idPersonaleConsegna`, `idUtente`, `idVolume`) VALUES
(1, '2024-05-12', 2, 2, 2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `trestituzionecarta`
--

CREATE TABLE `trestituzionecarta` (
  `idRestituzioneCarta` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonale` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `trestituzionelibro`
--

CREATE TABLE `trestituzionelibro` (
  `idRestituzioneLibro` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonale` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `trestituzionevolume`
--

CREATE TABLE `trestituzionevolume` (
  `idRestituzioneVolume` int(11) NOT NULL,
  `data` date NOT NULL,
  `idPersonale` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idVolume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tscritturaenciclopedia`
--

CREATE TABLE `tscritturaenciclopedia` (
  `idScritturaEnciclopedia` int(11) NOT NULL,
  `nomeAutore` varchar(255) NOT NULL,
  `cognomeAutore` varchar(255) NOT NULL,
  `idEnciclopedia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ttelefono`
--

CREATE TABLE `ttelefono` (
  `numero` bigint(20) NOT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ttelefono`
--

INSERT INTO `ttelefono` (`numero`, `idUtente`) VALUES
(1234567891, 13),
(2345678912, 13),
(4324324235, 13);

-- --------------------------------------------------------

--
-- Struttura della tabella `tutente`
--

CREATE TABLE `tutente` (
  `idUtente` int(11) NOT NULL,
  `codiceFiscale` varchar(16) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tutente`
--

INSERT INTO `tutente` (`idUtente`, `codiceFiscale`, `nome`, `cognome`, `email`, `password`) VALUES
(1, 'BTDDXD72E63M298N', 'Mario', 'Rossi', 'mario.rossi@gmail.com', 'password'),
(2, 'JRKTVF91A54A178H', 'Giovanni', 'Romano', 'giovanni.romano@gmail.com', '1234'),
(3, 'FHGRBL90P65E803G', 'Mattia', 'Esposito', 'esposito.mattia@gmail.com', 'mattiaEsposito'),
(13, 'FSEDF234343124FD', 'Giovanni', 'Sussa', 'suss.fsdf@fdsf.csdf', 'testtest');

-- --------------------------------------------------------

--
-- Struttura della tabella `tvolume`
--

CREATE TABLE `tvolume` (
  `idVolume` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `disponibile` tinyint(1) NOT NULL,
  `idEnciclopedia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tvolume`
--

INSERT INTO `tvolume` (`idVolume`, `numero`, `ISBN`, `disponibile`, `idEnciclopedia`) VALUES
(1, 1, '978-1-23-456789-7', 1, 1),
(2, 2, '978-2-23-456789-7', 1, 1),
(3, 3, '978-3-23-456789-7', 1, 1),
(7, 1, '343-1-54-47653-9', 1, 2),
(8, 2, '343-2-54-47653-9', 0, 2),
(9, 3, '343-3-54-47653-9', 1, 2),
(10, 1, '432-1-43-34563-2', 0, 3),
(11, 2, '432-2-43-34563-2', 0, 3),
(13, 1, '265-1-54-64363-0', 1, 4),
(14, 2, '265-2-54-64363-0', 0, 4),
(15, 3, '265-3-54-64363-0', 1, 4),
(16, 1, '324-1-34-42353-4', 1, 5),
(17, 2, '324-2-34-42353-4', 1, 5),
(18, 3, '324-3-34-42353-4', 0, 5);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vprenotazionicarte`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vprenotazionicarte` (
`data` date
,`titolo` varchar(255)
,`idUtente` int(11)
,`idCarta` int(11)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vprenotazionivolumi`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vprenotazionivolumi` (
`data` date
,`titolo` varchar(255)
,`numero` int(11)
,`idUtente` int(11)
,`idVolume` int(11)
);

-- --------------------------------------------------------

--
-- Struttura per vista `prenotazionilibri`
--
DROP TABLE IF EXISTS `prenotazionilibri`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prenotazionilibri`  AS SELECT `tpb`.`data` AS `data`, `tl`.`titolo` AS `titolo`, `tpb`.`idUtente` AS `idUtente`, `tpb`.`idLibro` AS `idLibro` FROM (`tprenotazionelibro` `tpb` join `tlibro` `tl` on(`tpb`.`idLibro` = `tl`.`idLibro`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `vprenotazionicarte`
--
DROP TABLE IF EXISTS `vprenotazionicarte`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vprenotazionicarte`  AS SELECT `tpc`.`data` AS `data`, `tc`.`titolo` AS `titolo`, `tpc`.`idUtente` AS `idUtente`, `tpc`.`idCarta` AS `idCarta` FROM (`tprenotazionecarta` `tpc` join `tcarta` `tc` on(`tpc`.`idCarta` = `tc`.`idCarta`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `vprenotazionivolumi`
--
DROP TABLE IF EXISTS `vprenotazionivolumi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vprenotazionivolumi`  AS SELECT `tpv`.`data` AS `data`, `te`.`titolo` AS `titolo`, `tv`.`numero` AS `numero`, `tpv`.`idUtente` AS `idUtente`, `tpv`.`idVolume` AS `idVolume` FROM ((`tprenotazionevolume` `tpv` join `tvolume` `tv` on(`tpv`.`idVolume` = `tv`.`idVolume`)) join `tenciclopedia` `te` on(`tv`.`idEnciclopedia` = `te`.`idEnciclopedia`)) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `tautorecarta`
--
ALTER TABLE `tautorecarta`
  ADD PRIMARY KEY (`idAutoreCarta`);

--
-- Indici per le tabelle `tautoreenciclopedia`
--
ALTER TABLE `tautoreenciclopedia`
  ADD PRIMARY KEY (`idAutoreEnciclopedia`);

--
-- Indici per le tabelle `tcarta`
--
ALTER TABLE `tcarta`
  ADD PRIMARY KEY (`idCarta`);

--
-- Indici per le tabelle `tenciclopedia`
--
ALTER TABLE `tenciclopedia`
  ADD PRIMARY KEY (`idEnciclopedia`);

--
-- Indici per le tabelle `tfigurazionecarta`
--
ALTER TABLE `tfigurazionecarta`
  ADD PRIMARY KEY (`idFigurazioneCarta`);

--
-- Indici per le tabelle `tlibro`
--
ALTER TABLE `tlibro`
  ADD PRIMARY KEY (`idLibro`);

--
-- Indici per le tabelle `tpersonale`
--
ALTER TABLE `tpersonale`
  ADD PRIMARY KEY (`idPersonale`);

--
-- Indici per le tabelle `tposizione`
--
ALTER TABLE `tposizione`
  ADD PRIMARY KEY (`codiceScaffale`);

--
-- Indici per le tabelle `tprenotazionecarta`
--
ALTER TABLE `tprenotazionecarta`
  ADD PRIMARY KEY (`idPrenotazioneCarta`);

--
-- Indici per le tabelle `tprenotazionelibro`
--
ALTER TABLE `tprenotazionelibro`
  ADD PRIMARY KEY (`idPrenotazioneLibro`);

--
-- Indici per le tabelle `tprenotazionevolume`
--
ALTER TABLE `tprenotazionevolume`
  ADD PRIMARY KEY (`idPrenotazioneVolume`);

--
-- Indici per le tabelle `tprestitocarta`
--
ALTER TABLE `tprestitocarta`
  ADD PRIMARY KEY (`idPrestitoCarta`);

--
-- Indici per le tabelle `tprestitolibro`
--
ALTER TABLE `tprestitolibro`
  ADD PRIMARY KEY (`idPrestitoLibro`);

--
-- Indici per le tabelle `tprestitovolume`
--
ALTER TABLE `tprestitovolume`
  ADD PRIMARY KEY (`idPrestitoVolume`);

--
-- Indici per le tabelle `trestituzionecarta`
--
ALTER TABLE `trestituzionecarta`
  ADD PRIMARY KEY (`idRestituzioneCarta`);

--
-- Indici per le tabelle `trestituzionelibro`
--
ALTER TABLE `trestituzionelibro`
  ADD PRIMARY KEY (`idRestituzioneLibro`);

--
-- Indici per le tabelle `trestituzionevolume`
--
ALTER TABLE `trestituzionevolume`
  ADD PRIMARY KEY (`idRestituzioneVolume`);

--
-- Indici per le tabelle `tscritturaenciclopedia`
--
ALTER TABLE `tscritturaenciclopedia`
  ADD PRIMARY KEY (`idScritturaEnciclopedia`);

--
-- Indici per le tabelle `ttelefono`
--
ALTER TABLE `ttelefono`
  ADD PRIMARY KEY (`numero`);

--
-- Indici per le tabelle `tutente`
--
ALTER TABLE `tutente`
  ADD PRIMARY KEY (`idUtente`);

--
-- Indici per le tabelle `tvolume`
--
ALTER TABLE `tvolume`
  ADD PRIMARY KEY (`idVolume`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `tautorecarta`
--
ALTER TABLE `tautorecarta`
  MODIFY `idAutoreCarta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `tautoreenciclopedia`
--
ALTER TABLE `tautoreenciclopedia`
  MODIFY `idAutoreEnciclopedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `tcarta`
--
ALTER TABLE `tcarta`
  MODIFY `idCarta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `tenciclopedia`
--
ALTER TABLE `tenciclopedia`
  MODIFY `idEnciclopedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `tfigurazionecarta`
--
ALTER TABLE `tfigurazionecarta`
  MODIFY `idFigurazioneCarta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tlibro`
--
ALTER TABLE `tlibro`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `tpersonale`
--
ALTER TABLE `tpersonale`
  MODIFY `idPersonale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tposizione`
--
ALTER TABLE `tposizione`
  MODIFY `codiceScaffale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `tprenotazionecarta`
--
ALTER TABLE `tprenotazionecarta`
  MODIFY `idPrenotazioneCarta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `tprenotazionelibro`
--
ALTER TABLE `tprenotazionelibro`
  MODIFY `idPrenotazioneLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `tprenotazionevolume`
--
ALTER TABLE `tprenotazionevolume`
  MODIFY `idPrenotazioneVolume` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `tprestitocarta`
--
ALTER TABLE `tprestitocarta`
  MODIFY `idPrestitoCarta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `tprestitolibro`
--
ALTER TABLE `tprestitolibro`
  MODIFY `idPrestitoLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `tprestitovolume`
--
ALTER TABLE `tprestitovolume`
  MODIFY `idPrestitoVolume` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `trestituzionecarta`
--
ALTER TABLE `trestituzionecarta`
  MODIFY `idRestituzioneCarta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `trestituzionelibro`
--
ALTER TABLE `trestituzionelibro`
  MODIFY `idRestituzioneLibro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `trestituzionevolume`
--
ALTER TABLE `trestituzionevolume`
  MODIFY `idRestituzioneVolume` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tscritturaenciclopedia`
--
ALTER TABLE `tscritturaenciclopedia`
  MODIFY `idScritturaEnciclopedia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tutente`
--
ALTER TABLE `tutente`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `tvolume`
--
ALTER TABLE `tvolume`
  MODIFY `idVolume` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
