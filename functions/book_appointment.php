<?php
session_start();
require 'db-config.php';
global $conn;

if (!isset($_SESSION['patientID'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['patientID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $appointment_day = $_POST['appointment_day'];
    $appointment_time = $_POST['appointment_time'];

    // ellenorzi a munkanapokat a doktorra
    $stmt = $conn->prepare("SELECT Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday FROM DoctorSchedule WHERE doctorID = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_assoc();

    if (!$schedule) {
        $message = 'Az orvos rendszere nem található.';
        header("Location: ../appointment.php?message=" . urlencode($message));
        exit();
    }

    $day_of_week = date('w', strtotime($appointment_day));
    $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    if (!$schedule[$days[$day_of_week]]) {
        $message = 'A kiválasztott orvos nem dolgozik a kiválasztott napon.';
        header("Location: ../appointment.php?message=" . urlencode($message));
        exit();
    }

    // ellenorzi hogy a valasztott ido a doktor munkaorain belul van e
    $stmt2 = $conn->prepare("SELECT worktime FROM Doctor WHERE doctorID = ?");
    $stmt2->bind_param("i", $doctor_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $doctor = $result2->fetch_assoc();

    if (!$doctor) {
        $message = 'Az orvos nem található.';
        header("Location: ../appointment.php?message=" . urlencode($message));
        exit();
    }

    $worktime = explode('-', $doctor['worktime']);
    $start_time = strtotime($worktime[0]);
    $end_time = strtotime($worktime[1]);
    $selected_time = strtotime($appointment_time);

    if ($selected_time < $start_time || $selected_time >= $end_time || ($selected_time - $start_time) % 1800 !== 0) {
        $message = 'Érvénytelen időpont.';
        header("Location: ../appointment.php?message=" . urlencode($message));
        exit();
    }

    // beszuras a bazisba
    $appointment_datetime = date('Y-m-d H:i:s', strtotime("$appointment_day $appointment_time"));
    $stmt3 = $conn->prepare("INSERT INTO Appointment (schedule, doctorID, patientID) VALUES (?, ?, ?)");
    $stmt3->bind_param("sii", $appointment_datetime, $doctor_id, $user_id);
    try {
        if ($stmt3->execute()) {
            $message = 'Időpont sikeresen lefoglalva.';
        } else {
            $message = 'Nem sikerült időpontot foglalni. Kérem, próbálja újra.';
        }
    } catch (mysqli_sql_exception $e) {
        $message = 'Az időpont már foglalt. Kérem, válasszon másik időpontot.';
    }

    header("Location: ../appointment.php?message=" . urlencode($message));
    exit();
} else {
    $message = 'Érvénytelen kérési módszer.';
    header("Location: ../index.php?message=" . urlencode($message));
    exit();
}
