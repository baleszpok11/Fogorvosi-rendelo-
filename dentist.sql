-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Jún 18. 13:09
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
  `appID` int(11) NOT NULL,
  `schedule` datetime NOT NULL,
  `doctorID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `Appointment`
--

INSERT INTO `Appointment` (`appID`, `schedule`, `doctorID`, `patientID`) VALUES
(1, '2024-06-12 10:00:00', 3, 1),
(2, '2024-06-12 14:00:00', 1, 1),
(4, '2024-06-03 07:00:00', 4, 1),
(5, '2024-06-07 07:00:00', 4, 1),
(8, '2024-06-13 10:00:00', 3, 1),
(9, '2024-06-05 07:00:00', 4, 1),
(10, '2024-06-05 09:00:00', 2, 1),
(11, '2024-06-07 09:00:00', 2, 1),
(12, '2024-06-03 08:00:00', 1, 1),
(16, '2024-06-07 08:00:00', 1, 1),
(18, '2024-06-03 08:30:00', 1, 1),
(19, '2024-06-04 08:00:00', 1, 1),
(22, '2024-06-03 09:00:00', 1, 11),
(24, '2024-06-04 10:30:00', 1, 11),
(25, '2024-10-08 08:00:00', 1, 12),
(26, '2024-07-16 08:00:00', 1, 12);

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
  `worktime` varchar(50) NOT NULL,
  `specialisation` varchar(100) NOT NULL,
  `forget` varchar(255) NOT NULL,
  `remember` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `Doctor`
--

INSERT INTO `Doctor` (`doctorID`, `firstName`, `lastName`, `password`, `phoneNumber`, `email`, `worktime`, `specialisation`, `forget`, `remember`) VALUES
(1, 'John', 'Doe', '7c6a180b36896a0a8c02787eeafb0e4c', '123-456-7890', 'john.doe@example.com', '08:00-16:00', 'Dentistry', '', ''),
(2, 'Andrew', 'Smith', '6cb75f652a9b52798eb6cf2201057c73', '234-567-8901', 'jane.smith@example.com', '09:00-17:00', 'Orthodontics', '', ''),
(3, 'Alice', 'Johnson', '819b0643d6b89dc9b579fdfc9094f28e', '345-678-9012', 'alice.johnson@example.com', '10:00-18:00', 'Pediatric Dentistry', '', ''),
(4, 'Bob', 'Williams', '34cc93ece0ba9e3f6f235d4af979b16c', '456-789-0123', 'bob.williams@example.com', '07:00-15:00', 'Endodontics', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `DoctorSchedule`
--

CREATE TABLE `DoctorSchedule` (
  `doctorID` int(11) NOT NULL,
  `Monday` tinyint(1) NOT NULL DEFAULT 0,
  `Tuesday` tinyint(1) NOT NULL DEFAULT 0,
  `Wednesday` tinyint(1) NOT NULL DEFAULT 0,
  `Thursday` tinyint(1) NOT NULL DEFAULT 0,
  `Friday` tinyint(1) NOT NULL DEFAULT 0,
  `Saturday` tinyint(1) NOT NULL DEFAULT 0,
  `Sunday` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `DoctorSchedule`
--

INSERT INTO `DoctorSchedule` (`doctorID`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Sunday`) VALUES
(1, 1, 1, 1, 0, 0, 1, 1),
(2, 1, 1, 1, 1, 1, 0, 0),
(3, 1, 1, 1, 1, 1, 0, 0),
(4, 1, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Patient`
--

CREATE TABLE `Patient` (
  `patientID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `forgot` varchar(255) DEFAULT NULL,
  `remember` varchar(255) DEFAULT NULL,
  `auth` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `Patient`
--

INSERT INTO `Patient` (`patientID`, `userName`, `firstName`, `lastName`, `password`, `phoneNumber`, `email`, `forgot`, `remember`, `auth`) VALUES
(1, '', 'Balint', 'Balog', '$2y$10$Va8zpU.BTa1cq6kk4/dcye775PXglsuVWzITH6h6gZJp5OShZKWBy', '5', 'asd@gmail.com', NULL, NULL, ''),
(2, '', 'Seruga', 'Seril', '$2y$10$QXiATrCGBOOvW1GeJAs/zu0evsFOie/KOln26TaeM4sAt1UBdurny', '555666555', 'example@gmail.com', NULL, NULL, ''),
(3, '', 'balint', 'balog', '$2y$10$7EvpDlpxDpAT0/3yBnGX1el5/L3x3T1NgHhpSlqtI5vGSHDg3aNxy', '03', 'b@gmail.com', NULL, NULL, ''),
(4, '', 'test', 'test', '$2y$10$i8ngZ2olDku8QpMfgRWDQOmznakaRYYaMsVz5kq8Farz07jPG7.DK', 'test', 'test@test.test', NULL, NULL, ''),
(5, '', 'test1', 'test1', '$2y$10$bQHg7v366w4SDyLLKV4A9e3/dxIbn69XvQPt58vJwhdxIg7PCJfwS', 'test1', 'test1@test1.test1', NULL, NULL, ''),
(6, '', 'Test2', 'Test2', '$2y$10$eenN6LtkAWrudkcnMWpxXeahIADYz9s/QwQwSQnH.nb3ho15jV0EC', 'Test2', 'test2@test2.test2', NULL, NULL, ''),
(7, '', 'Test3', 'Test3', '$2y$10$kQq.4wqzEmHpOEoBjGqOWezyyl6g4h48JP28SSnMcwwSXw/lWKRXu', 'Test3', 'test3@test3.com', NULL, NULL, ''),
(8, '', 'Test4', 'Test4', '$2y$10$rNCMZTurBnDEVSixYLRec.CvR6lVwz78kfbkZLSCEY0O9dwEgZz0S', 'Test4', 'test4@test4.com', NULL, NULL, ''),
(9, '', 'Test5', 'Test5', '$2y$10$8of2IKMn44WQCjDwIozcseB1Q4yWl85F3vT2isD5kYDNblRy1kQ0q', 'Test5', 'test5@test5.test5', NULL, NULL, ''),
(10, '', 'Test6', 'Test6', '$2y$10$OMpOmWOLcObEsdVBMMy2LeWuxLYKngHIzqku4wx4PI6k7kOnWqjey', 'Test6', 'Test6@Test6.Test6', NULL, NULL, ''),
(11, '', 'Test8', 'Test8', '$2y$10$HO/m/w.KZ950dNdGy2eEcuvV.c1fZ4fXYT50hIxll7H8G79bTB7y.', '0652759823', 'Test8@Test8.com', NULL, NULL, ''),
(12, 'Test9', 'Test9', 'Test9', '$2y$10$8vnU4MKuH1kFdOaqjTv3fuFWG5a9x12fpt3/K3ohEEvVbLAVUwm2.', 'Test9', 'Test9@Test9.Test9', NULL, '5c516836c31c6b6f2d6fb1adaa2565560801505cafb8646f8c6698c3fd7a0910', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `PatientRecords`
--

CREATE TABLE `PatientRecords` (
  `recordID` int(11) NOT NULL,
  `patientID` int(11) DEFAULT NULL,
  `doctorID` int(11) DEFAULT NULL,
  `procedureDate` date DEFAULT NULL,
  `procedureDetails` text DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Procedures`
--

CREATE TABLE `Procedures` (
  `procedureID` int(11) NOT NULL,
  `procedureName` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`appID`),
  ADD UNIQUE KEY `schedule` (`schedule`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctorID` (`doctorID`);

--
-- A tábla indexei `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`doctorID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `DoctorSchedule`
--
ALTER TABLE `DoctorSchedule`
  ADD PRIMARY KEY (`doctorID`);

--
-- A tábla indexei `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`patientID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `PatientRecords`
--
ALTER TABLE `PatientRecords`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctorID` (`doctorID`);

--
-- A tábla indexei `Procedures`
--
ALTER TABLE `Procedures`
  ADD PRIMARY KEY (`procedureID`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `Appointment`
--
ALTER TABLE `Appointment`
  MODIFY `appID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT a táblához `Doctor`
--
ALTER TABLE `Doctor`
  MODIFY `doctorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `Patient`
--
ALTER TABLE `Patient`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `PatientRecords`
--
ALTER TABLE `PatientRecords`
  MODIFY `recordID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `Procedures`
--
ALTER TABLE `Procedures`
  MODIFY `procedureID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `Appointment`
--
ALTER TABLE `Appointment`
  ADD CONSTRAINT `doctorID` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patientID` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `DoctorSchedule`
--
ALTER TABLE `DoctorSchedule`
  ADD CONSTRAINT `doctorschedule_ibfk_1` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `PatientRecords`
--
ALTER TABLE `PatientRecords`
  ADD CONSTRAINT `patientrecords_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`),
  ADD CONSTRAINT `patientrecords_ibfk_2` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
