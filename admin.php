<?php
include 'functions/db-config.php';
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Fogászati Rendszer</title>
    <style>
        div {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>

<!-- First Division: Manage Appointments -->
<div>
    <h2>Időpontok kezelése</h2>
    <!-- Form to add a new appointment -->
    <form action="functions/manage_services.php" method="post">
        <h3>Új időpont felvitele</h3>
        <label for="service_name">Időpont neve:</label>
        <input type="text" id="service_name" name="service_name"><br>

        <label for="price">Ár:</label>
        <input type="number" id="price" name="price"><br>
        <input type="submit" name="add_service" value="Hozzáadás">
    </form>

    <!-- Form to modify an existing appointment -->
    <form action="functions/manage_services.php" method="post">
        <h3>Időpont módosítása</h3>
        <label for="service_id_modify">Időpont ID:</label>
        <input type="number" id="service_id_modify" name="service_id_modify"><br>
        <label for="new_service_name">Új név:</label>
        <input type="text" id="new_service_name" name="new_service_name"><br>

        <label for="new_price">Új ár:</label>
        <input type="number" id="new_price" name="new_price"><br>
        <input type="submit" name="modify_service" value="Módosítás">
    </form>

    <!-- Form to delete an appointment -->
    <form action="functions/manage_services.php" method="post">
        <h3>Időpont törlése</h3>
        <label for="service_id_delete">Időpont ID:</label>
        <input type="number" id="service_id_delete" name="service_id_delete"><br>
        <input type="submit" name="delete_service" value="Törlés">
    </form>
</div>

<!-- Second Division: Manage Doctors -->
<div>
    <h2>Orvos bevitele és módosítása</h2>
    <form action="functions/manage_dentists.php" method="post">
        <label for="operation">Operation:</label>
        <select name="operation" id="operation">
            <option value="insert">Insert</option>
            <option value="update">Update</option>
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

    <!-- Form to delete a doctor -->
    <form action="functions/manage_dentists.php" method="post">
        <h3>Orvos törlése</h3>
        <label for="dentist_id_delete">Orvos ID:</label>
        <input type="number" id="dentist_id_delete" name="dentist_id_delete"><br>
        <input type="submit" name="delete_dentist" value="Törlés">
    </form>
</div>

<!-- Third Division: View Reservations -->
<div>
    <h2>Foglalások megtekintése</h2>
    <form action="functions/view_reservations.php" method="post">
        <label for="date">Dátum:</label>
        <input type="date" id="date" name="date"><br>
        <input type="submit" name="view_reservations" value="Megtekintés">
    </form>
</div>

</body>
</html>
