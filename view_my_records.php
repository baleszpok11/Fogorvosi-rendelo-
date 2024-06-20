<?php
session_start();

if (!isset($_SESSION["patientID"])) {
    header("location: index.php?message=" . urlencode("Jelentkezzen be") . "&type=alert");
    exit();
}

require 'functions/db-config.php';
global $pdo;

$patientID = $_SESSION['patientID'];

$patientRecords = [];

$sql = "SELECT pr.procedureDate, pr.procedureDetails, pr.notes, d.firstName AS doctorFirstName, d.lastName AS doctorLastName, proc.procedureName, pr.price 
        FROM PatientRecords pr
        JOIN Doctor d ON pr.doctorID = d.doctorID
        JOIN Procedures proc ON pr.procedureID = proc.procedureID
        WHERE pr.patientID = ? ORDER BY pr.procedureDate DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$patientID]);
$patientRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Saját rekordok</title>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Fogorvosi rendelő</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Kezdőoldal</a></li>
                <li><a href="doctors.php">Orvosaink</a></li>
                <?php if (!isset($_SESSION['patientID']) && !isset($_SESSION['doctorID'])): ?>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <?php
                    if (isset($_SESSION['patientID'])) {
                        echo '<li><a href="appointment.php">Időpont foglalás</a></li>';
                        echo '<li><a href="view_appointments.php">Foglalásaim</a></li>';
                        echo '<li class="active"><a href="view_my_records.php">Kartonom</a></li>';
                    }
                    if (isset($_SESSION['doctorID'])) {
                        echo '<li><a href="add_patient_records.php">Karton írása</a></li>';
                        echo '<li><a href="view_my_records.php">Kartonok megtekintése</a></li>';
                        echo '<li><a href="view_patient_health.php">Fogak állapota</a></li>';
                        echo '<li><a href="admin.php">Admin oldal</a></li>';
                    }
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?> <span
                                    class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
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