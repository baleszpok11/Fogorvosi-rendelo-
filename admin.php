<?php
session_start();
include 'functions/db-config.php';

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fogászati Rendszer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
    <style>
        div {

            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
        }
    </style>
    <script>
        function toggleFields() {
            var operation = document.getElementById("operation").value;
            var fields = document.querySelectorAll(".conditional-field");
            fields.forEach(function(field) {
                field.style.display = (operation === "delete") ? "none" : "block";
            });
        }
        function fetchBookings() {
            var date = document.getElementById("date-picker").value;
            if (date) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "functions/view_reservations.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("bookings").innerHTML = xhr.responseText;
                    }
                };
                xhr.send("date=" + encodeURIComponent(date));
            } else {
                alert("Kérem válasszon egy dátumot.");
            }
        }
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="index.php">Kezdőoldal</a></li>
                <li><a href="doctors.php">Orvosaink</a></li>
                <?php if (!isset($_SESSION['patientID']) && !isset($_SESSION['doctorID'])): ?>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <?php
                    if(isset($_SESSION['patientID'])) {
                        echo '<li><a href="appointment.php">Időpont foglalás</a></li>';
                        echo '<li><a href="view_appointments.php">Foglalásaim</a></li>';
                        echo '<li><a href="view_my_records.php">Kartonom</a></li>';
                    }
                    if(isset($_SESSION['doctorID'])) {

                    }
                    ?>
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

<div>
    <h2>Szolgáltatás Bevitele és modosítás </h2>
    <form action="functions/manage_services.php" method="post">
        <label for="operation">Lehetőség:</label>
        <select name="operation" id="operation" onchange="toggleFields()">
            <option value="insert">Bevitel</option>
            <option value="update">Módosítás</option>
        </select><br><br>

        <label for="procedureID">Szolgáltatás ID (frisítéshez):</label>
        <input type="text" id="procedureID" name="procedureID"><br><br>

        <label for="procedureName">Szolgáltatás neve:</label>
        <input type="text" id="procedureName" name="procedureName"><br><br>

        <label for="price">Ár:</label>
        <input type="text" id="price" name="price"><br><br>


        <input type="submit" value="Küldés">
    </form>
</div>
<div>
    <h2>Szolgáltatás törlése</h2>
    <form action="functions/delete_service.php" method="post">
        <label for="procedureID">Szolgáltatás ID:</label>
        <input type="number" id="procedureID" name="procedureID" required><br><br>
        <input type="submit" value="Törlés">
    </form>
</div>


<div>
    <h2>Orvos bevitele és módosítása</h2>
    <form action="functions/manage_dentists.php" method="post">
        <label for="operation">Lehetőségek:</label>
        <select name="operation" id="operation">
            <option value="insert">Bevitel</option>
            <option value="update">Módosítás</option>
        </select><br><br>

        <label for="doctorID">Doctor ID (módosításhoz):</label>
        <input type="text" id="doctorID" name="doctorID"><br><br>

        <label for="firstName">Vezeték név:</label>
        <input type="text" id="firstName" name="firstName" required><br><br>

        <label for="lastName">Utó név:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>

        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="phoneNumber">Telefon szám:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="worktime">Munka idő:</label>
        <input type="text" id="worktime" name="worktime" required><br><br>

        <label for="specialisation">Specializáció:</label>
        <input type="text" id="specialisation" name="specialisation" required><br><br>

        <input type="submit" value="küldés">
    </form>

</div>
<div>
    <h2>Orvos torlese</h2>
    <form action = "functions/delete_dentist.php" method="post">
    <label for="doctorID">Doctor ID:</label>
    <input type="number" id="doctorID" name="doctorID"><br><br>
    <input type="submit" value="küldés">
    </form>
</div>

<div>
    <h2>Foglalások megtekintése</h2>
    <form onsubmit="fetchBookings(); return false;">
        <label for="date-picker">Dátum:</label>
        <input type="date" id="date-picker" name="date" required><br><br>
        <input type="submit" value="Megtekintés">
    </form>
    <div id="bookings">

    </div>
</div>
<script>

    toggleFields();
</script>
</body>
</html>
