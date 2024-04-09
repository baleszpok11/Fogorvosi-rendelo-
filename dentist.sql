-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Ápr 09. 16:29
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
-- Tábla szerkezet ehhez a táblához `Doctor`
--

CREATE TABLE `Doctor` (
                          `doctorID` int(11) NOT NULL,
                          `firstName` varchar(50) NOT NULL,
                          `lastName` varchar(50) NOT NULL,
                          `password` varchar(255) NOT NULL,
                          `phoneNumber` varchar(20) NOT NULL,
                          `email` varchar(100) NOT NULL,
                          `specialization` varchar(100) NOT NULL,
                          `forget` varchar(255) NOT NULL,
                          `remember` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Patient`
--

CREATE TABLE `Patient` (
                           `patientID` int(11) NOT NULL,
                           `firstName` varchar(50) NOT NULL,
                           `lastName` varchar(50) NOT NULL,
                           `password` varchar(255) NOT NULL,
                           `phoneNumber` varchar(20) DEFAULT NULL,
                           `email` varchar(100) NOT NULL,
                           `forgot` varchar(255) DEFAULT NULL,
                           `remember` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `Doctor`
--
ALTER TABLE `Doctor`
    ADD PRIMARY KEY (`doctorID`),
    ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `Patient`
--
ALTER TABLE `Patient`
    ADD PRIMARY KEY (`patientID`),
    ADD UNIQUE KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `Doctor`
--
ALTER TABLE `Doctor`
    MODIFY `doctorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `Patient`
--
ALTER TABLE `Patient`
    MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
