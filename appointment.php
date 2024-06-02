<!DOCTYPE html>
<html>
<head>
    <title>Book an Appointment</title>
</head>
<body>
<h1>Book an Appointment</h1>
<form id="appointmentForm" method="POST" action="book_appointment.php">
    <label for="doctor">Choose a doctor:</label>
    <select id="doctor" name="doctor_id">
        <!-- Populate this with a list of doctors from your database -->
        <?php
        // Include database configuration
        require 'functions/database.php';
        global $conn;

        // Fetch doctors from the database
        $result = $conn->query("SELECT doctorID, firstName, lastName FROM Doctor");
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"{$row['doctorID']}\">{$row['firstName']} {$row['lastName']}</option>";
        }
        ?>
    </select><br><br>

    <label for="appointment_time">Choose a time:</label>
    <select id="appointment_time" name="appointment_time">
        <!-- Populate this with valid 30-minute intervals -->
        <?php
        function populateTimeIntervals($start, $end)
        {
            $startTime = strtotime($start);
            $endTime = strtotime($end);

            while ($startTime < $endTime) {
                $time = date('H:i', $startTime);
                echo "<option value=\"$time\">$time</option>";
                $startTime = strtotime('+30 minutes', $startTime);
            }
        }

        // Assuming default time intervals for simplicity
        populateTimeIntervals('08:00', '18:00');
        ?>
    </select><br><br>

    <input type="submit" value="Book Appointment">
</form>

<?php
// Display message if any
if (isset($_GET['message'])) {
    echo "<p>{$_GET['message']}</p>";
}
?>
</body>
</html>
