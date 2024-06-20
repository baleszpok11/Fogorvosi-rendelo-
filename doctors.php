<?php
session_start();
require 'functions/db-config.php';
global $conn;

$query = "SELECT doctorID, firstName, lastName, specialisation, phoneNumber, email FROM Doctor";
$result = $conn->query($query);

$doctors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
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

        .doctor-image {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
        }

        .doctor-details {
            display: none;
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
                <?php if (!isset($_SESSION['patientID']) && !isset($_SESSION['doctorID'])): ?>
                    <li class="active"><a href="doctors.php">Orvosaink</a></li>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                <li class="active"><a href="doctors.php">Orvosaink</a></li>
                <?php
                if (isset($_SESSION['doctorID'])) {
                    echo '<li><a href="add_patient_records.php">Karton</a></li>';
                }
                if(isset($_SESSION['patientID'])) {
                    echo '<li><a href="appointment.php">Időpont foglalás</a></li>';
                    echo '<li><a href="view_appointments.php">Foglalásaim</a></li>';
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?> <span
                                class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['patientID'])): ?>
                            <li><a href="profile.php">Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        <?php else: ?>
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        <?php endif ?>
                    </ul>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Orvosok</h1>
    <div id="doctors" class="row">
        <?php foreach ($doctors as $doctor): ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo htmlspecialchars($doctor['firstName'] . ' ' . $doctor['lastName']); ?></h3>
                    </div>
                    <div class="panel-body">
                        <img src="source/images/doctors/<?php echo $doctor['doctorID']; ?>.jpg"
                             alt="<?php echo htmlspecialchars($doctor['firstName'] . ' ' . $doctor['lastName']); ?>"
                             class="doctor-image">
                        <p><strong>Specializáció:</strong> <?php echo htmlspecialchars($doctor['specialisation']); ?>
                        </p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
                        <p><strong>Telefon:</strong> <?php echo htmlspecialchars($doctor['phoneNumber']); ?></p>
                        <button class="btn btn-info" onclick="loadDoctorDetails(<?php echo $doctor['doctorID']; ?>)">
                            Részletek
                        </button>
                        <div id="doctor-details-<?php echo $doctor['doctorID']; ?>" class="doctor-details">
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function loadDoctorDetails(doctorID) {
        $.ajax({
            url: 'functions/get_doctor_worktime.php',
            method: 'GET',
            data: {doctor_id: doctorID},
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                var detailsDiv = $('#doctor-details-' + doctorID);
                detailsDiv.html(`
                <p><strong>Munkanapok:</strong></p>
                <ul>
                    <li>Hétfő: ${data.days.Monday ? 'Igen' : 'Nem'}</li>
                    <li>Kedd: ${data.days.Tuesday ? 'Igen' : 'Nem'}</li>
                    <li>Szerda: ${data.days.Wednesday ? 'Igen' : 'Nem'}</li>
                    <li>Csütörtök: ${data.days.Thursday ? 'Igen' : 'Nem'}</li>
                    <li>Péntek: ${data.days.Friday ? 'Igen' : 'Nem'}</li>
                    <li>Szombat: ${data.days.Saturday ? 'Igen' : 'Nem'}</li>
                    <li>Vasárnap: ${data.days.Sunday ? 'Igen' : 'Nem'}</li>
                </ul>
                <p><strong>Munkakezdés:</strong> ${data.start}</p>
                <p><strong>Munkabefejezés:</strong> ${data.end}</p>
            `);
                detailsDiv.slideToggle();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching doctor details:', error);
            }
        });
    }
</script>
</body>
</html>
