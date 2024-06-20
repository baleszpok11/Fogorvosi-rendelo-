<?php
session_start();

if (!isset($_SESSION["patientID"])) {
    header("location: index.php?message=" . urlencode("Jelentkezzen be") . "&type=alert");
    exit();
}

require 'functions/db-config.php';
global $conn;

$patientID = $_SESSION['patientID'];

$patientRecords = [];

$sql = "SELECT pr.procedureDate, pr.procedureDetails, pr.notes, d.firstName AS doctorFirstName, d.lastName AS doctorLastName, proc.procedureName, proc.price 
        FROM PatientRecords pr
        JOIN Doctor d ON pr.doctorID = d.doctorID
        JOIN Procedures proc ON pr.procedureID = proc.procedureID
        WHERE pr.patientID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $patientRecords[] = $row;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Saját rekordok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Fogorvosi rendelő</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Kezdőoldal</a></li>
            <li><a href="appointment.php">Időpont foglalás</a></li>
            <li><a href="view_my_records.php">Saját rekordok</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style="padding-top: 70px;">
    <h2>Saját rekordok</h2>
    <?php if (empty($patientRecords)): ?>
        <div class="alert alert-warning" role="alert" style="margin-top: 10px;">Nincsenek rekordok.</div>
    <?php endif; ?>
    <?php if (!empty($patientRecords)): ?>
        <table class="table table-bordered" style="margin-top: 20px;">
            <thead>
            <tr>
                <th>Eljárás dátuma</th>
                <th>Eljárás részletei</th>
                <th>Megjegyzések</th>
                <th>Orvos neve</th>
                <th>Eljárás neve</th>
                <th>Ár</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($patientRecords as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['procedureDate']); ?></td>
                    <td><?php echo htmlspecialchars($record['procedureDetails']); ?></td>
                    <td><?php echo htmlspecialchars($record['notes']); ?></td>
                    <td><?php echo htmlspecialchars($record['doctorFirstName'] . ' ' . $record['doctorLastName']); ?></td>
                    <td><?php echo htmlspecialchars($record['procedureName']); ?></td>
                    <td><?php echo htmlspecialchars($record['price']); ?> HUF</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>