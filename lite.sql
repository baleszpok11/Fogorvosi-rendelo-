-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2024 at 03:28 PM
-- Server version: 8.0.37-0ubuntu0.20.04.3
-- PHP Version: 8.3.3-1+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appointment`
--

CREATE TABLE `Appointment` (
  `appID` int NOT NULL,
  `schedule` datetime NOT NULL,
  `doctorID` int NOT NULL,
  `patientID` int NOT NULL,
  `procedureID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Appointment`
--

INSERT INTO `Appointment` (`appID`, `schedule`, `doctorID`, `patientID`, `procedureID`) VALUES
(44, '2024-06-21 12:30:00', 3, 20, 7),
(45, '2024-06-27 10:00:00', 3, 20, 8),
(47, '2024-06-27 11:00:00', 3, 20, 2),
(48, '2024-06-28 09:00:00', 2, 20, 3),
(49, '2024-06-25 09:00:00', 2, 20, 4),
(50, '2024-06-26 09:00:00', 2, 20, 3),
(51, '2024-06-21 10:00:00', 3, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Doctor`
--

CREATE TABLE `Doctor` (
  `doctorID` int NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phoneNumber` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `worktime` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `specialisation` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `forget` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Doctor`
--

INSERT INTO `Doctor` (`doctorID`, `firstName`, `lastName`, `password`, `phoneNumber`, `email`, `worktime`, `specialisation`, `forget`, `remember`) VALUES
(1, 'John', 'Doe', '7c6a180b36896a0a8c02787eeafb0e4c', '123-456-7890', 'john.doe@example.com', '08:00-16:00', 'Dentistry', '', ''),
(2, 'Andrew', 'Smith', '6cb75f652a9b52798eb6cf2201057c73', '234-567-8901', 'jane.smith@example.com', '09:00-17:00', 'Orthodontics', '', ''),
(3, 'Alice', 'Johnson', '819b0643d6b89dc9b579fdfc9094f28e', '345-678-9012', 'alice.johnson@example.com', '10:00-18:00', 'Pediatric Dentistry', '', ''),
(4, 'Bob', 'Williams', '34cc93ece0ba9e3f6f235d4af979b16c', '456-789-0123', 'bob.williams@example.com', '07:00-15:00', 'Endodontics', '', ''),
(6, 'Jani', 'Doe', '$2b$12$X15ArsizZ0FzwnyrNkr.cuU9RI43Yf51EvIxiYNSW5ho1tUYfGwXO', '123-456-7890', 'jani.doe@example.com', '08:00-16:00', 'Dentistry', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `DoctorSchedule`
--

CREATE TABLE `DoctorSchedule` (
  `doctorID` int NOT NULL,
  `Monday` tinyint(1) NOT NULL DEFAULT '0',
  `Tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `Wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `Thursday` tinyint(1) NOT NULL DEFAULT '0',
  `Friday` tinyint(1) NOT NULL DEFAULT '0',
  `Saturday` tinyint(1) NOT NULL DEFAULT '0',
  `Sunday` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `DoctorSchedule`
--

INSERT INTO `DoctorSchedule` (`doctorID`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`, `Saturday`, `Sunday`) VALUES
(1, 1, 1, 1, 0, 0, 1, 1),
(2, 1, 1, 1, 1, 1, 0, 0),
(3, 1, 1, 1, 1, 1, 0, 0),
(4, 1, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `patientID` int NOT NULL,
  `userName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phoneNumber` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `forgot` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `auth` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`patientID`, `userName`, `firstName`, `lastName`, `password`, `phoneNumber`, `email`, `forgot`, `remember`, `auth`) VALUES
(13, 'Test1', 'Test1', 'Test1', '$2y$10$nfuoQp/sl1E8wiHzhPtki.HXOJSswvy7FSP5Th8v6BrLKcmB3xptS', 'Test1', 'Test1@Test1.Test1', NULL, NULL, NULL),
(14, 'Test2', 'Test2', 'Test2', '$2y$10$eLpCcX2bLOey6soJOeBmzOX8fkbWcfUwherkl6uPVT6eygbCUqpa2', 'Test2', 'Test2@Test2.Test2', NULL, NULL, NULL),
(15, 'Test3', 'Test3', 'Test3', '$2y$10$KizvbPelcvpk.FH4xv2A2eo3q9XOQ1bZrDKoUHldiXVS.lLlqshzi', 'Test3', 'Test3@Tes3.Test3', NULL, NULL, NULL),
(20, 'balogbalesz1234', 'Balint', 'Balog', '$2y$10$fDl9jaMRNgHIQnr4SOg80.J1e1OfnM0wWMULgh8TxTj9vl5USxRVm', '0631257023', 'balogbalesz1234@gmail.com', NULL, '7e28466ffd12ff8fc959294e7c5c6c4aa90fa0ffa352ce89afa5f70daf8ecc99', '');

-- --------------------------------------------------------

--
-- Table structure for table `PatientRecords`
--

CREATE TABLE `PatientRecords` (
  `recordID` int NOT NULL,
  `patientID` int DEFAULT NULL,
  `doctorID` int DEFAULT NULL,
  `procedureDate` date DEFAULT NULL,
  `procedureDetails` text COLLATE utf8mb4_general_ci,
  `notes` text COLLATE utf8mb4_general_ci,
  `procedureID` int DEFAULT NULL,
  `healthRating` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PatientRecords`
--

INSERT INTO `PatientRecords` (`recordID`, `patientID`, `doctorID`, `procedureDate`, `procedureDetails`, `notes`, `procedureID`, `healthRating`) VALUES
(7, 20, 6, '2024-06-20', 'nice', 'nice', 2, 10),
(8, 20, 6, '2024-06-18', '<?php\r\nsession_start();\r\n\r\nif (!isset($_SESSION[\"doctorID\"])) {\r\n    header(\"location: index.php?message=\" . urlencode(\"Jelentkezzen be\") . \"&type=alert\");\r\n    exit();\r\n}\r\n\r\nrequire \'functions/db-config.php\';\r\nglobal $conn;\r\n\r\n$patientID = isset($_POST[\'patientID\']) ? intval($_POST[\'patientID\']) : 0;\r\n\r\n$patientRecords = [];\r\n\r\nif ($patientID > 0) {\r\n    $sql = \"SELECT p.firstName, p.lastName, pr.procedureDate, pr.procedureDetails, pr.notes, proc.procedureName, proc.price \r\n            FROM PatientRecords pr\r\n            JOIN Patient p ON pr.patientID = p.patientID\r\n            JOIN Procedures proc ON pr.procedureID = proc.procedureID\r\n            WHERE pr.patientID = ?\";\r\n    $stmt = $conn->prepare($sql);\r\n    $stmt->bind_param(\"i\", $patientID);\r\n    $stmt->execute();\r\n    $result = $stmt->get_result();\r\n\r\n    while ($row = $result->fetch_assoc()) {\r\n        $patientRecords[] = $row;\r\n    }\r\n}\r\n?>\r\n\r\n<!DOCTYPE html>\r\n<html lang=\"hu\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <title>Beteg rekordok</title>\r\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css\">\r\n</head>\r\n<body>\r\n\r\n<nav class=\"navbar navbar-default navbar-fixed-top\">\r\n    <div class=\"container\">\r\n        <div class=\"navbar-header\">\r\n            <a class=\"navbar-brand\" href=\"#\">Fogorvosi rendelő</a>\r\n        </div>\r\n        <ul class=\"nav navbar-nav navbar-right\">\r\n            <li><a href=\"index.php\">Kezdőoldal</a></li>\r\n            <li><a href=\"appointment.php\">Időpont foglalás</a></li>\r\n            <li><a href=\"view_patient_records.php\">Beteg rekordok</a></li>\r\n            <li class=\"dropdown\">\r\n                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">\r\n                    <?php echo $_SESSION[\'firstName\'] . \' \' . $_SESSION[\'lastName\']; ?> <span class=\"caret\"></span>\r\n                </a>\r\n                <ul class=\"dropdown-menu\">\r\n                    <li><a href=\"functions/logOutFunction.php\">Kijelentkezés</a></li>\r\n                </ul>\r\n            </li>\r\n        </ul>\r\n    </div>\r\n</nav>\r\n\r\n<div class=\"container\" style=\"padding-top: 70px;\">\r\n    <h2>Beteg rekordok</h2>\r\n    <form method=\"POST\" action=\"view_patient_records.php\" class=\"form-inline\">\r\n        <div class=\"form-group\">\r\n            <label for=\"patientID\">Beteg ID:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"patientID\" name=\"patientID\" placeholder=\"Adja meg a beteg ID-jét\" required>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\">Keresés</button>\r\n    </form>\r\n    <?php if ($patientID > 0 && empty($patientRecords)): ?>\r\n        <div class=\"alert alert-warning\" role=\"alert\" style=\"margin-top: 10px;\">Nincsenek rekordok ehhez a beteghez.</div>\r\n    <?php endif; ?>\r\n    <?php if (!empty($patientRecords)): ?>\r\n    <table class=\"table table-bordered\" style=\"margin-top: 20px;\">\r\n        <thead>\r\n        <tr>\r\n            <th>Beteg neve</th>\r\n            <th>Eljárás dátuma</th>\r\n            <th>Eljárás részletei</th>\r\n            <th>Megjegyzések</th>\r\n            <th>Eljárás neve</th>\r\n            <th>Ár</th>\r\n        </tr>\r\n        </thead>\r\n        <tbody>\r\n        <?php foreach ($patientRecords as $record): ?>\r\n            <tr>\r\n                <td><?php echo htmlspecialchars($record[\'firstName\'] . \' \' . $record[\'lastName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDate\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDetails\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'notes\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'price\']); ?> HUF</td>\r\n            </tr>\r\n        <?php endforeach; ?>\r\n        </tbody>\r\n    </table>\r\n    <?php endif; ?>\r\n</div>\r\n\r\n<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>\r\n<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js\"></script>\r\n</body>\r\n</html>\r\n<?php\r\nsession_start();\r\n\r\nif (!isset($_SESSION[\"doctorID\"])) {\r\n    header(\"location: index.php?message=\" . urlencode(\"Jelentkezzen be\") . \"&type=alert\");\r\n    exit();\r\n}\r\n\r\nrequire \'functions/db-config.php\';\r\nglobal $conn;\r\n\r\n$patientID = isset($_POST[\'patientID\']) ? intval($_POST[\'patientID\']) : 0;\r\n\r\n$patientRecords = [];\r\n\r\nif ($patientID > 0) {\r\n    $sql = \"SELECT p.firstName, p.lastName, pr.procedureDate, pr.procedureDetails, pr.notes, proc.procedureName, proc.price \r\n            FROM PatientRecords pr\r\n            JOIN Patient p ON pr.patientID = p.patientID\r\n            JOIN Procedures proc ON pr.procedureID = proc.procedureID\r\n            WHERE pr.patientID = ?\";\r\n    $stmt = $conn->prepare($sql);\r\n    $stmt->bind_param(\"i\", $patientID);\r\n    $stmt->execute();\r\n    $result = $stmt->get_result();\r\n\r\n    while ($row = $result->fetch_assoc()) {\r\n        $patientRecords[] = $row;\r\n    }\r\n}\r\n?>\r\n\r\n<!DOCTYPE html>\r\n<html lang=\"hu\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <title>Beteg rekordok</title>\r\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css\">\r\n</head>\r\n<body>\r\n\r\n<nav class=\"navbar navbar-default navbar-fixed-top\">\r\n    <div class=\"container\">\r\n        <div class=\"navbar-header\">\r\n            <a class=\"navbar-brand\" href=\"#\">Fogorvosi rendelő</a>\r\n        </div>\r\n        <ul class=\"nav navbar-nav navbar-right\">\r\n            <li><a href=\"index.php\">Kezdőoldal</a></li>\r\n            <li><a href=\"appointment.php\">Időpont foglalás</a></li>\r\n            <li><a href=\"view_patient_records.php\">Beteg rekordok</a></li>\r\n            <li class=\"dropdown\">\r\n                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">\r\n                    <?php echo $_SESSION[\'firstName\'] . \' \' . $_SESSION[\'lastName\']; ?> <span class=\"caret\"></span>\r\n                </a>\r\n                <ul class=\"dropdown-menu\">\r\n                    <li><a href=\"functions/logOutFunction.php\">Kijelentkezés</a></li>\r\n                </ul>\r\n            </li>\r\n        </ul>\r\n    </div>\r\n</nav>\r\n\r\n<div class=\"container\" style=\"padding-top: 70px;\">\r\n    <h2>Beteg rekordok</h2>\r\n    <form method=\"POST\" action=\"view_patient_records.php\" class=\"form-inline\">\r\n        <div class=\"form-group\">\r\n            <label for=\"patientID\">Beteg ID:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"patientID\" name=\"patientID\" placeholder=\"Adja meg a beteg ID-jét\" required>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\">Keresés</button>\r\n    </form>\r\n    <?php if ($patientID > 0 && empty($patientRecords)): ?>\r\n        <div class=\"alert alert-warning\" role=\"alert\" style=\"margin-top: 10px;\">Nincsenek rekordok ehhez a beteghez.</div>\r\n    <?php endif; ?>\r\n    <?php if (!empty($patientRecords)): ?>\r\n    <table class=\"table table-bordered\" style=\"margin-top: 20px;\">\r\n        <thead>\r\n        <tr>\r\n            <th>Beteg neve</th>\r\n            <th>Eljárás dátuma</th>\r\n            <th>Eljárás részletei</th>\r\n            <th>Megjegyzések</th>\r\n            <th>Eljárás neve</th>\r\n            <th>Ár</th>\r\n        </tr>\r\n        </thead>\r\n        <tbody>\r\n        <?php foreach ($patientRecords as $record): ?>\r\n            <tr>\r\n                <td><?php echo htmlspecialchars($record[\'firstName\'] . \' \' . $record[\'lastName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDate\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDetails\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'notes\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'price\']); ?> HUF</td>\r\n            </tr>\r\n        <?php endforeach; ?>\r\n        </tbody>\r\n    </table>\r\n    <?php endif; ?>\r\n</div>\r\n\r\n<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>\r\n<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js\"></script>\r\n</body>\r\n</html>', '<?php\r\nsession_start();\r\n\r\nif (!isset($_SESSION[\"doctorID\"])) {\r\n    header(\"location: index.php?message=\" . urlencode(\"Jelentkezzen be\") . \"&type=alert\");\r\n    exit();\r\n}\r\n\r\nrequire \'functions/db-config.php\';\r\nglobal $conn;\r\n\r\n$patientID = isset($_POST[\'patientID\']) ? intval($_POST[\'patientID\']) : 0;\r\n\r\n$patientRecords = [];\r\n\r\nif ($patientID > 0) {\r\n    $sql = \"SELECT p.firstName, p.lastName, pr.procedureDate, pr.procedureDetails, pr.notes, proc.procedureName, proc.price \r\n            FROM PatientRecords pr\r\n            JOIN Patient p ON pr.patientID = p.patientID\r\n            JOIN Procedures proc ON pr.procedureID = proc.procedureID\r\n            WHERE pr.patientID = ?\";\r\n    $stmt = $conn->prepare($sql);\r\n    $stmt->bind_param(\"i\", $patientID);\r\n    $stmt->execute();\r\n    $result = $stmt->get_result();\r\n\r\n    while ($row = $result->fetch_assoc()) {\r\n        $patientRecords[] = $row;\r\n    }\r\n}\r\n?>\r\n\r\n<!DOCTYPE html>\r\n<html lang=\"hu\">\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <title>Beteg rekordok</title>\r\n    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css\">\r\n</head>\r\n<body>\r\n\r\n<nav class=\"navbar navbar-default navbar-fixed-top\">\r\n    <div class=\"container\">\r\n        <div class=\"navbar-header\">\r\n            <a class=\"navbar-brand\" href=\"#\">Fogorvosi rendelő</a>\r\n        </div>\r\n        <ul class=\"nav navbar-nav navbar-right\">\r\n            <li><a href=\"index.php\">Kezdőoldal</a></li>\r\n            <li><a href=\"appointment.php\">Időpont foglalás</a></li>\r\n            <li><a href=\"view_patient_records.php\">Beteg rekordok</a></li>\r\n            <li class=\"dropdown\">\r\n                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">\r\n                    <?php echo $_SESSION[\'firstName\'] . \' \' . $_SESSION[\'lastName\']; ?> <span class=\"caret\"></span>\r\n                </a>\r\n                <ul class=\"dropdown-menu\">\r\n                    <li><a href=\"functions/logOutFunction.php\">Kijelentkezés</a></li>\r\n                </ul>\r\n            </li>\r\n        </ul>\r\n    </div>\r\n</nav>\r\n\r\n<div class=\"container\" style=\"padding-top: 70px;\">\r\n    <h2>Beteg rekordok</h2>\r\n    <form method=\"POST\" action=\"view_patient_records.php\" class=\"form-inline\">\r\n        <div class=\"form-group\">\r\n            <label for=\"patientID\">Beteg ID:</label>\r\n            <input type=\"text\" class=\"form-control\" id=\"patientID\" name=\"patientID\" placeholder=\"Adja meg a beteg ID-jét\" required>\r\n        </div>\r\n        <button type=\"submit\" class=\"btn btn-primary\">Keresés</button>\r\n    </form>\r\n    <?php if ($patientID > 0 && empty($patientRecords)): ?>\r\n        <div class=\"alert alert-warning\" role=\"alert\" style=\"margin-top: 10px;\">Nincsenek rekordok ehhez a beteghez.</div>\r\n    <?php endif; ?>\r\n    <?php if (!empty($patientRecords)): ?>\r\n    <table class=\"table table-bordered\" style=\"margin-top: 20px;\">\r\n        <thead>\r\n        <tr>\r\n            <th>Beteg neve</th>\r\n            <th>Eljárás dátuma</th>\r\n            <th>Eljárás részletei</th>\r\n            <th>Megjegyzések</th>\r\n            <th>Eljárás neve</th>\r\n            <th>Ár</th>\r\n        </tr>\r\n        </thead>\r\n        <tbody>\r\n        <?php foreach ($patientRecords as $record): ?>\r\n            <tr>\r\n                <td><?php echo htmlspecialchars($record[\'firstName\'] . \' \' . $record[\'lastName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDate\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureDetails\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'notes\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'procedureName\']); ?></td>\r\n                <td><?php echo htmlspecialchars($record[\'price\']); ?> HUF</td>\r\n            </tr>\r\n        <?php endforeach; ?>\r\n        </tbody>\r\n    </table>\r\n    <?php endif; ?>\r\n</div>\r\n\r\n<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>\r\n<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js\"></script>\r\n</body>\r\n</html>', 6, 9),
(9, 20, 6, '2024-06-17', 'add', 'asd', 3, 6),
(10, 20, 6, '2024-06-20', 'asd', 'asd', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Procedures`
--

CREATE TABLE `Procedures` (
  `procedureID` int NOT NULL,
  `procedureName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Procedures`
--

INSERT INTO `Procedures` (`procedureID`, `procedureName`, `price`) VALUES
(2, 'Fogkő eltávolítás', 15000.00),
(3, 'Fogtömés', 20000.00),
(4, 'Gyökérkezelés', 35000.00),
(5, 'Fogfehérítés', 40000.00),
(6, 'Röntgen', 5000.00),
(7, 'Fogpótlás', 60000.00),
(8, 'Implantáció', 120000.00),
(9, 'Fogszabályozás', 80000.00),
(10, 'Szájsebészet', 70000.00),
(11, 'Éjszakai harapásemelő', 10000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD PRIMARY KEY (`appID`),
  ADD UNIQUE KEY `unique_schedule_doctor` (`schedule`,`doctorID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `procedureID` (`procedureID`);

--
-- Indexes for table `Doctor`
--
ALTER TABLE `Doctor`
  ADD PRIMARY KEY (`doctorID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `DoctorSchedule`
--
ALTER TABLE `DoctorSchedule`
  ADD PRIMARY KEY (`doctorID`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`patientID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `PatientRecords`
--
ALTER TABLE `PatientRecords`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `doctorID` (`doctorID`);

--
-- Indexes for table `Procedures`
--
ALTER TABLE `Procedures`
  ADD PRIMARY KEY (`procedureID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appointment`
--
ALTER TABLE `Appointment`
  MODIFY `appID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `Doctor`
--
ALTER TABLE `Doctor`
  MODIFY `doctorID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Patient`
--
ALTER TABLE `Patient`
  MODIFY `patientID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `PatientRecords`
--
ALTER TABLE `PatientRecords`
  MODIFY `recordID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Procedures`
--
ALTER TABLE `Procedures`
  MODIFY `procedureID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Appointment`
--
ALTER TABLE `Appointment`
  ADD CONSTRAINT `doctorID` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patientID` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `procedureID` FOREIGN KEY (`procedureID`) REFERENCES `Procedures` (`procedureID`);

--
-- Constraints for table `DoctorSchedule`
--
ALTER TABLE `DoctorSchedule`
  ADD CONSTRAINT `doctorschedule_ibfk_1` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PatientRecords`
--
ALTER TABLE `PatientRecords`
  ADD CONSTRAINT `patientrecords_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`),
  ADD CONSTRAINT `patientrecords_ibfk_2` FOREIGN KEY (`doctorID`) REFERENCES `Doctor` (`doctorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
