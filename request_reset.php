<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Jelszó visszaállítás kérése</title>
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
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container" style="padding-top: 70px;">
    <h2>Jelszó visszaállítás kérése</h2>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>
    <form method="POST" action="functions/send_reset_email.php">
        <div class="form-group">
            <label for="email">Email cím:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Küldés</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>