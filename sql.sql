-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 05 Wrz 2019, 15:22
-- Wersja serwera: 10.1.40-MariaDB-cll-lve
-- Wersja PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `spectral_dust`
--
CREATE DATABASE IF NOT EXISTS `spectral_dust` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `spectral_dust`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `CONFIG`
--

CREATE TABLE `CONFIG` (
  `ID` int(11) NOT NULL,
  `TIME_MEASURE` int(11) NOT NULL,
  `N_MEASURES` int(11) NOT NULL,
  `BREAK_TIME` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `LAST_LATITUDE` text NOT NULL,
  `LAST_LONGITUDE` text NOT NULL,
  `ACCURACY` float NOT NULL,
  `LAST_ACTIVE` datetime NOT NULL,
  `LAST_MODIFY` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RADIUS` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `PM`
--

CREATE TABLE `PM` (
  `ID` int(11) NOT NULL,
  `PM2_5` int(11) NOT NULL,
  `PM10` int(11) NOT NULL,
  `PM2_5_CORR` int(11) NOT NULL,
  `PM_10_CORR` int(11) NOT NULL,
  `HUMIDITY` text NOT NULL,
  `TEMPERATURE` text NOT NULL,
  `PRESSURE` text NOT NULL,
  `ID_SESSION` int(11) NOT NULL,
  `LATITUDE_ORG` text NOT NULL,
  `LONGITUDE_ORG` text NOT NULL,
  `LATITUDE_CEN` text NOT NULL,
  `LONGITUDE_CEN` text NOT NULL,
  `DATE_SAVE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `CONFIG`
--
ALTER TABLE `CONFIG`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `PM`
--
ALTER TABLE `PM`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `CONFIG`
--
ALTER TABLE `CONFIG`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `PM`
--
ALTER TABLE `PM`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
