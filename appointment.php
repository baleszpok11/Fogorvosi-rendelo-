<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
</head>
<body>
<h2>Book Appointment</h2>
<form action="bookAppointment.php" method="post">
    <label for="doctor">Select Doctor:</label>
    <select name="doctor" id="doctor">
        <?php
        while ($rowDoctor = $resultDoctors->fetch_assoc()) {
            echo "<option value='{$rowDoctor['doctorID']}'>{$rowDoctor['firstName']} {$rowDoctor['lastName']}</option>";
        }
        ?>
    </select>
    <br>
    <label for="date">Select Date:</label>
    <select name="date" id="date">
        <!-- Populate dates based on selected doctor's work schedule -->
        <?php
        // Fetch work schedule for the selected doctor
        $selectedDoctorID = $_POST['doctor'];
        $sqlWorkSchedule = "SELECT DISTINCT DATE_FORMAT(workDate, '%Y-%m-%d') AS workDate FROM WorkTime WHERE doctorID = $selectedDoctorID";
        $resultWorkSchedule = $conn->query($sqlWorkSchedule);
        while ($rowWorkSchedule = $resultWorkSchedule->fetch_assoc()) {
            echo "<option value='{$rowWorkSchedule['workDate']}'>{$rowWorkSchedule['workDate']}</option>";
        }
        ?>
    </select>
    <br>
    <label for="time">Select Time:</label>
    <select name="time" id="time">
        <!-- Populate times based on selected doctor's work schedule and selected date -->
        <?php
        $selectedDate = $_POST['date'];
        $sqlTimeSlots = "SELECT startTime, endTime FROM WorkTime WHERE doctorID = $selectedDoctorID AND workDate = '$selectedDate'";
        $resultTimeSlots = $conn->query($sqlTimeSlots);
        while ($rowTimeSlots = $resultTimeSlots->fetch_assoc()) {
            $startTime = strtotime($rowTimeSlots['startTime']);
            $endTime = strtotime($rowTimeSlots['endTime']);
            while ($startTime < $endTime) {
                echo "<option value='".date('H:i', $startTime)."'>".date('H:i', $startTime)."</option>";
                $startTime += (30 * 60); // Add 30 minutes
            }
        }
        ?>
    </select>
    <br>
    <input type="submit" value="Book Appointment">
</form>
</body>
</html>
