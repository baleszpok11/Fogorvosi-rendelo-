<?php
session_start();
$message = isset($_GET['message']) ? $_GET['message'] : '';
$messageType = isset($_GET['type']) ? $_GET['type'] : 'info';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
                <?php if (!isset($_SESSION['patientID'])): ?>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <li><a href="appointment.php">Időpont foglalás</a></li>
                    <li><a href="doctors.php">Orvosaink</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">Profil</a></li>
                            <li role="separator" class="divider"></li>
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
        require 'functions/db-config.php';
        global $pdo;
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