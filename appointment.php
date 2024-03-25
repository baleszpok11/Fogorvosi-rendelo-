<?php
session_start();

// felhasználó a login oldalra kerül ha nincs bejelentkezve
if (!isset($_SESSION['jmbg'])) {
    header("Location: login.php");
    exit();
}

require 'functions/connection.php';
global $conn;
// foglalható idők generálása
function generateTimeSlots($start, $end, $interval = '30 minutes')
{
    $slots = array();
    $current = strtotime($start);
    $end = strtotime($end);

    while ($current <= $end) {
        $slots[] = date('H:i', $current);
        $current = strtotime('+' . $interval, $current);
    }

    return $slots;
}

// munkaidő
$workTimeSlots = array(
    'Monday' => generateTimeSlots('08:00', '15:30'),
    'Tuesday' => generateTimeSlots('10:00', '17:30'),
    'Wednesday' => generateTimeSlots('08:00', '15:30'),
    'Thursday' => generateTimeSlots('10:00', '17:30'),
    'Friday' => generateTimeSlots('08:00', '15:30')
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];

// ellenőrzés, hogy az idő a jövőben van-e
    if (strtotime($date) < strtotime('today')) {
        $error_message = "You cannot schedule appointments for past dates.";
    } else {
// ellenőrzés a kiválasztott időre
        $currentDay = date('l', strtotime($date));
        $workTimeSlots = array(
            'Monday' => generateTimeSlots('08:00', '15:30'),
            'Tuesday' => generateTimeSlots('10:00', '17:30'),
            'Wednesday' => generateTimeSlots('08:00', '15:30'),
            'Thursday' => generateTimeSlots('10:00', '17:30'),
            'Friday' => generateTimeSlots('08:00', '15:30')
        );

        if (!in_array($time, $workTimeSlots[$currentDay])) {
            $error_message = "A választott idő nem elérhető.";
        } else {
            // ellenőrzés, hogy a megadott idő foglalt-e
            $sql = "SELECT * FROM Appointment WHERE appointmentTime = '$date $time'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error_message = "A választott idő már foglalt.";
            } else {
                $userID = $_SESSION['jmbg'];
                $doctorID = "";
                $status = "scheduled";

                $sql = "INSERT INTO Appointment (userID, doctorID, appointmentTime, status) 
                        VALUES ('$userID', '$doctorID', '$date $time', '$status')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: appointment.php");
                    exit();
                } else {
                    $error_message = "Error scheduling appointment: " . $conn->error;
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Időpont foglalás</title>
</head>
<body>
<h2>Időpont foglalás</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="date">Válasszon dátumot:</label>
    <input type="date" id="date" name="date" required><br><br>

    <label for="time">Válasszon időt:</label>
    <select id="time" name="time" required>
        <?php foreach ($workTimeSlots[date('l')] as $slot): ?>
            <option value="<?php echo $slot; ?>"><?php echo $slot; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Foglalás">
</form>
</body>
</html>
