-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 14, 2024 alle 18:30
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

-- --------------------------------------------------------

--
-- Struttura per vista `prenotazionilibri`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prenotazionilibri`  AS SELECT `tpb`.`data` AS `data`, `tl`.`titolo` AS `titolo`, `tpb`.`idUtente` AS `idUtente`, `tpb`.`idLibro` AS `idLibro` FROM (`tprenotazionelibro` `tpb` join `tlibro` `tl` on(`tpb`.`idLibro` = `tl`.`idLibro`)) ;

--
-- VIEW `prenotazionilibri`
-- Dati: Nessuno
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
