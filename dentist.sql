-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Már 26. 22:02
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `dentist`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Appointment`
--

CREATE TABLE `Appointment` (
  `appointmentID` int(11) NOT NULL,
  `userID` varchar(13) NOT NULL,
  `doctorID` varchar(13) NOT NULL,
  `appointmentTime` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `Appointment`
--

INSERT INTO `Appointment` (`appointmentID`, `userID`, `doctorID`, `appointmentTime`, `status`) VALUES
(1, '310104', '', '2024-03-25 08:00:00', 'scheduled'),
(2, '310104', '', '2024-04-19 08:00:00', 'scheduled');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Doctor`
--

CREATE TABLE `Doctor` (
  `jmbg` varchar(13) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phoneNumber` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Patient`
--

CREATE TABLE `Patient` (
  `jmbg` varchar(13) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phoneNumber` varchar(12) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `Patient`
--

INSERT INTO `Patient` (`jmbg`, `firstName`, `lastName`, `phoneNumber`, `password`, `email`, `token`) VALUES
('1', '1', '1', '1', '$2y$10$NGB86iacVDURR/5uIez5G.UcjHOesZdXcX.OOz0F7jhYvz5nsngH2', '1@gmail.com', NULL),
('310104', 'Bálint', 'Balog', '0631257023', '$2y$10$PSCD2jh3QV0PmB8cmWQCpexijd4lGmlM4OUMl5DQNATNUupIBRMeO', 'balogbalesz1234@gmail.com', '734d2a10abbf21c9a2b19767991abf7f02942d40a7a424cef4ae07b2e42b2794');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`appointmentID`);

--
-- A tábla indexei `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`jmbg`);

--
-- A tábla indexei `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`jmbg`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `Appointment`
--
ALTER TABLE `Appointment`
  MODIFY `appointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
