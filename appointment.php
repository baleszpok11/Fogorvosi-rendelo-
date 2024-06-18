<?php
session_start();
if (!isset($_SESSION["patientID"])) {
    header("location: index.php?message=Jelentkezzen be");
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Időpont foglalása</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
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
                <li><a href="index.php">Kezdőoldal</a></li>
                <?php if (!isset($_SESSION['patientID'])): ?>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <li class="active"><a href="appointment.php">Időpont foglalás</a></li>
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
    <h1>Időpont foglalása</h1>
    <form id="appointmentForm" method="POST" action="functions/book_appointment.php" class="form-horizontal">
        <div class="form-group">
            <label for="doctor" class="col-sm-2 control-label">Válasszon orvost:</label>
            <div class="col-sm-10">
                <select id="doctor" name="doctor_id" class="form-control" required>
                    <option value="">Válasszon orvost</option>
                    <?php
                    require 'functions/db-config.php';
                    global $conn;

                    $result = $conn->query("SELECT doctorID, firstName, lastName FROM Doctor");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"{$row['doctorID']}\">{$row['firstName']} {$row['lastName']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="appointment_day" class="col-sm-2 control-label">Válasszon napot:</label>
            <div class="col-sm-10">
                <input type="text" id="appointment_day" name="appointment_day" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label for="appointment_time" class="col-sm-2 control-label">Válasszon időpontot:</label>
            <div class="col-sm-10">
                <select id="appointment_time" name="appointment_time" class="form-control" required>
                    <!-- Időintervallumok itt lesznek feltöltve -->
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Időpont foglalása</button>
            </div>
        </div>
    </form>
    <?php
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo "<div class='alert alert-info' role='alert'>$message</div>";
    }
    ?>
    <h2>Foglalt időpontok:</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Doktor</th>
            <th>Nap</th>
            <th>Időpont</th>
        </tr>
        </thead>
        <tbody id="bookedSlots">
        <!-- Itt lesznek megjelenítve a foglalt időpontok -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        let flatpickrInstance;
        $('#doctor').change(function () {
            var doctorId = $(this).val();
            if (doctorId) {
                $.ajax({
                    url: 'functions/get_doctor_worktime.php',
                    type: 'GET',
                    data: {doctor_id: doctorId},
                    dataType: 'json',
                    success: function (data) {
                        if (flatpickrInstance) {
                            flatpickrInstance.destroy();
                        }
                        var timeSelect = $('#appointment_time');
                        timeSelect.empty(); // Mezők kiürítése

                        var startTime = new Date('1970-01-01T' + data.start + ':00');
                        var endTime = new Date('1970-01-01T' + data.end + ':00');

                        while (startTime < endTime) {
                            var time = startTime.toTimeString().substring(0, 5);
                            timeSelect.append(new Option(time, time));
                            startTime.setMinutes(startTime.getMinutes() + 30);
                        }

                        var enabledDays = [];
                        if (data.days.Monday) enabledDays.push(1);
                        if (data.days.Tuesday) enabledDays.push(2);
                        if (data.days.Wednesday) enabledDays.push(3);
                        if (data.days.Thursday) enabledDays.push(4);
                        if (data.days.Friday) enabledDays.push(5);
                        if (data.days.Saturday) enabledDays.push(6);
                        if (data.days.Sunday) enabledDays.push(0);

                        flatpickrInstance = flatpickr("#appointment_day", {
                            dateFormat: "Y-m-d",
                            disable: [
                                function (date) {
                                    return !enabledDays.includes(date.getDay());
                                }
                            ],
                            minDate: "today"
                        });
                    }
                });
            } else {
                $('#appointment_time').empty();
                if (flatpickrInstance) {
                    flatpickrInstance.destroy();
                }
                $('#appointment_day').val('');
            }
        });

        function displayBookedSlots() {
            var selectedDate = $('#appointment_day').val();
            var selectedDoctorId = $('#doctor').val();

            $.ajax({
                url: 'functions/get_booked_times.php',
                type: 'GET',
                data: {doctor_id: selectedDoctorId, date: selectedDate},
                dataType: 'json',
                success: function (data) {
                    var bookedSlotsTable = $('#bookedSlots');
                    bookedSlotsTable.empty();

                    if (data && data.length > 0) {
                        data.forEach(function (slot) {
                            bookedSlotsTable.append('<tr><td>' + slot.doctor + '</td><td>' + slot.day + '</td><td>' + slot.time + '</td></tr>');
                        });
                    } else {
                        bookedSlotsTable.append('<tr><td colspan="3">Nincsenek foglalt időpontok erre a napra.</td></tr>');
                    }
                }
            });
        }

        $('#appointment_day').change(displayBookedSlots);
        $('#doctor').change(displayBookedSlots);

        displayBookedSlots();
    });
</script>
</body>
</html>