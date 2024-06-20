<?php
session_start();
$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
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
                            <li class="active"><a href="profile.php">Profil</a></li>
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
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Profil</h2>
            <?php if ($message !== ''): ?>
                <div class="alert alert-info" role="alert"><?php echo $message; ?></div>
            <?php endif; ?>
            <form id="profileForm" method="POST" action="functions/update_profile.php" class="form-horizontal">
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-3 control-label">Új jelszó</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword" name="newPassword"
                               placeholder="Új jelszó">
                        <small id="passwordHelpBlock" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPhoneNumber" class="col-sm-3 control-label">Telefonszám</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber"
                               placeholder="Telefonszám">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-3 control-label">Email cím</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email cím">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">Profil frissítése</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#profileForm').submit(function (e) {
            e.preventDefault();

            var password = $('#inputPassword').val();
            if (password !== '' && !isValidPassword(password)) {
                $('#passwordHelpBlock').text('A jelszónak legalább 8 karakter hosszúnak kell lennie, és tartalmaznia kell egy speciális karaktert, egy számot és egy nagybetűt.');
                return;
            }

            $('#passwordHelpBlock').text('');

            var formData = $(this).serialize();
            $.ajax({
                url: 'functions/update_profile.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    if (response.success) {
                        $('#inputPassword').val('');
                        $('#inputPhoneNumber').val('');
                        $('#inputEmail').val('');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Hiba történt a kérés feldolgozása közben. Kérjük, próbálja újra.');
                }
            });
        });

        function isValidPassword(password) {
            var passwordRegex = /^(?=.*[!@#$%^&*()_+\-={}\[\]:;"'<>,.?\/\\])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            return passwordRegex.test(password);
        }
    });
</script>

</body>
</html>