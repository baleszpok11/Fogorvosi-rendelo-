<?php
session_start();
if (!isset($_SESSION["patientID"]) && !isset($_SESSION["doctorID"])) {
    header("location: index.php?message=Jelentkezzen be");
    exit();
}

require 'functions/db-config.php';
global $pdo;
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Foglalásaim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 70px;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
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
                        echo '<li class="active"><a href="view_appointments.php">Foglalásaim</a></li>';
                        echo '<li><a href="view_my_records.php">Kartonom</a></li>';
                    }
                    if (isset($_SESSION['doctorID'])) {
                        echo '<li><a href="add_patient_records.php">Karton írása</a></li>';
                        echo '<li><a href="view_patient_records.php">Kartonok megtekintése</a></li>';
                        echo '<li><a href="view_patient_health.php">Fogak állapota</a></li>';
                        echo '<li class="active"><a href="view_appointments.php">Foglalásaim</a></li>';
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

<div class="container">
    <h1>Foglalásaim</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Dátum</th>
            <th>Időpont</th>
            <th>Orvos</th>
            <th>Eljárás</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION['patientID'])) {
            $patientID = $_SESSION["patientID"];
            $sql = "SELECT a.schedule, d.firstName, d.lastName, p.procedureName 
                    FROM Appointment a 
                    JOIN Doctor d ON a.doctorID = d.doctorID 
                    JOIN Procedures p ON a.procedureID = p.procedureID 
                    WHERE a.patientID = ? AND a.schedule > NOW() ORDER BY a.schedule ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$patientID]);
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        if (isset($_SESSION['doctorID'])) {
            $doctorID = $_SESSION["doctorID"];
            $sql = "SELECT a.schedule, pa.firstName, pa.lastName, p.procedureName 
                    FROM Appointment a 
                    JOIN Patient pa ON a.patientID = pa.patientID 
                    JOIN Procedures p ON a.procedureID = p.procedureID 
                    WHERE a.doctorID = ? AND a.schedule > NOW() ORDER BY a.schedule ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$doctorID]);
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        foreach ($appointments as $appointment) {
            echo "<tr>";
            echo "<td>" . date('Y-m-d', strtotime($appointment['schedule'])) . "</td>";
            echo "<td>" . date('H:i', strtotime($appointment['schedule'])) . "</td>";
            echo "<td>" . htmlspecialchars($appointment['firstName'] . ' ' . $appointment['lastName']) . "</td>";
            echo "<td>" . htmlspecialchars($appointment['procedureName']) . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
