<?php
session_start();

if (!isset($_SESSION["doctorID"])) {
    header("location: index.php?message=" . urlencode("Jelentkezzen be") . "&type=alert");
    exit();
}

require 'functions/db-config.php';
global $pdo;

$patientID = isset($_POST['patientID']) ? intval($_POST['patientID']) : 0;

$patientRecords = [];

if ($patientID > 0) {
    $sql = "SELECT p.firstName, p.lastName, pr.procedureDate, pr.procedureDetails, pr.notes, proc.procedureName, proc.price 
            FROM PatientRecords pr
            JOIN Patient p ON pr.patientID = p.patientID
            JOIN Procedures proc ON pr.procedureID = proc.procedureID
            WHERE pr.patientID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$patientID]);
    $patientRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Beteg karton</title>
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
            <li><a href="doctors.php">Orvosaink</a></li>
            <li><a href="add_patient_records.php">Karton írása</a></li>
            <li class="active"><a href="view_patient_records.php">Kartonok megtekintése</a></li>
            <li><a href="view_patient_health.php">Fogak megtekintése</a></li>
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
    <h2>Beteg karton</h2>
    <form method="POST" action="view_patient_records.php" class="form-inline">
        <div class="form-group">
            <label for="patientID">Beteg ID:</label>
            <input type="text" class="form-control" id="patientID" name="patientID" placeholder="Adja meg a beteg ID-jét" required>
        </div>
        <button type="submit" class="btn btn-primary">Keresés</button>
    </form>
    <?php if ($patientID > 0 && empty($patientRecords)): ?>
        <div class="alert alert-warning" role="alert" style="margin-top: 10px;">Nincsenek rekordok ehhez a beteghez.</div>
    <?php endif; ?>
    <?php if (!empty($patientRecords)): ?>
        <table class="table table-bordered" style="margin-top: 20px;">
            <thead>
            <tr>
                <th>Beteg neve</th>
                <th>Eljárás dátuma</th>
                <th>Eljárás részletei</th>
                <th>Megjegyzések</th>
                <th>Eljárás neve</th>
                <th>Ár</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($patientRecords as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['firstName'] . ' ' . $record['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($record['procedureDate']); ?></td>
                    <td><?php echo htmlspecialchars($record['procedureDetails']); ?></td>
                    <td><?php echo htmlspecialchars($record['notes']); ?></td>
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