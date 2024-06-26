<?php
session_start();
$message = $_GET['message'] ?? '';
$messageType = $_GET['type'] ?? 'info';

require 'functions/db-config.php';
global $pdo;

if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    $stmt = $pdo->prepare("SELECT patientID FROM Patient WHERE remember_token = :token");
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("SELECT doctorID FROM Doctor WHERE remember_token = :token");
    $stmt2->execute([':token' => $token]);
    $doctor = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($doctor) {
        $_SESSION['doctorID'] = $doctor['doctorID'];
    } else {
        setcookie('remember_me', '', time() - 3600, "/", "", false, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
    <style>
        body {
            padding-top: 70px;
        }
    </style>
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
                <li class="active"><a href="index.php">Kezdőoldal</a></li>
                <li><a href="doctors.php">Orvosaink</a></li>
                <?php if (!isset($_SESSION['patientID']) && !isset($_SESSION['doctorID'])): ?>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <?php
                    if (isset($_SESSION['patientID'])) {
                        echo '<li><a href="appointment.php">Időpont foglalás</a></li>';
                        echo '<li><a href="view_appointments.php">Foglalásaim</a></li>';
                        echo '<li><a href="view_my_records.php">Kartonom</a></li>';
                    }
                    if (isset($_SESSION['doctorID'])) {
                        echo '<li><a href="add_patient_records.php">Karton írása</a></li>';
                        echo '<li><a href="view_patient_records.php">Kartonok megtekintése</a></li>';
                        echo '<li><a href="view_patient_health.php">Fogak állapota</a></li>';
                        echo '<li><a href="view_appointments.php">Foglalásaim</a></li>';
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
                            <?php
                            if(isset($_SESSION['patientID'])) {
                                echo '<li><a href="profile.php">Profil</a></li>"';
                            }
                            ?>
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if ($message !== ''): ?>
        <div class="alert alert-<?php echo $messageType; ?>" role="alert"><?php echo $message; ?></div>
    <?php endif; ?>
    <h2>Eljárások és árak</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Eljárás</th>
            <th>Ár</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $stmt = $pdo->query("SELECT procedureName, price FROM Procedures");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>{$row['procedureName']}</td><td>{$row['price']} Ft</td></tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='2'>Hiba történt az eljárások betöltése közben: " . $e->getMessage() . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>