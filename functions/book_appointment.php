<?php
global $pdo;
session_start();
require 'db-config.php';

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
    $stmt = $pdo->prepare("SELECT Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday FROM DoctorSchedule WHERE doctorID = :doctor_id");
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $stmt2 = $pdo->prepare("SELECT worktime FROM Doctor WHERE doctorID = :doctor_id");
    $stmt2->bindParam(':doctor_id', $doctor_id);
    $stmt2->execute();
    $doctor = $stmt2->fetch(PDO::FETCH_ASSOC);

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
    $stmt3 = $pdo->prepare("INSERT INTO Appointment (schedule, doctorID, patientID, procedureID) VALUES (:schedule, :doctor_id, :patient_id, :procedure_id)");
    $stmt3->bindParam(':schedule', $appointment_datetime);
    $stmt3->bindParam(':doctor_id', $doctor_id);
    $stmt3->bindParam(':patient_id', $user_id);
    $stmt3->bindParam(':procedure_id', $procedure_id);

    try {
        $stmt3->execute();
        $message = 'Az időpont sikeresen lefoglalva.';
        header("Location: ../appointment.php?message=" . urlencode($message));
    } catch (PDOException $e) {
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
?>
