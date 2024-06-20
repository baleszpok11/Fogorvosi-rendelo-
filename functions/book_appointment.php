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
    $procedure_id = $_POST['procedure_id'];
    $appointment_day = $_POST['appointment_day'];
    $appointment_time = $_POST['appointment_time'];

    // Ellenőrizze, hogy a kiválasztott nap a doktor munkanapja-e
    $stmt = $conn->prepare("SELECT Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday FROM DoctorSchedule WHERE doctorID = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_assoc();

    if (!$schedule) {
        $message = 'Az orvos ütemezése nem található.';
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

    // Ellenőrizze, hogy a kiválasztott időpont az orvos munkaidején belül van-e
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

    // Időpont beillesztése az adatbázisba
    $appointment_datetime = date('Y-m-d H:i:s', strtotime("$appointment_day $appointment_time"));
    $stmt3 = $conn->prepare("INSERT INTO Appointment (schedule, doctorID, patientID, procedureID) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("siii", $appointment_datetime, $doctor_id, $user_id, $procedure_id);

    try {
        $stmt3->execute();
        $message = 'Az időpont sikeresen lefoglalva.';
        header("Location: ../appointment.php?message=" . urlencode($message));
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Ismétlődő bejegyzés hibakód
            $message = 'Az időpont már foglalt.';
            header("Location: ../appointment.php?message=" . urlencode($message));
        } else {
            $message = 'Hiba történt az időpont foglalása közben. Kérjük, próbálja újra.';
            header("Location: ../appointment.php?message=" . urlencode($message));
        }
    }

    exit();
} else {
    $message = 'Érvénytelen kérési mód.';
    header("Location: ../appointment.php?message=" . urlencode($message));
    exit();
}