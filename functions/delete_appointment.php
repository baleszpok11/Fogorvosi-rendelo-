<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_SESSION["patientID"]) || isset($_SESSION["doctorID"]))) {
    require 'db-config.php';
    global $pdo;

    $appID = intval($_POST['appID']);

    try {
        $stmt = $pdo->prepare("SELECT schedule FROM Appointment WHERE appID = ?");
        $stmt->execute([$appID]);
        $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($appointment) {
            $currentDateTime = new DateTime();
            $appointmentDateTime = new DateTime($appointment['schedule']);

            $interval = $currentDateTime->diff($appointmentDateTime);
            $hoursDiff = ($interval->days * 24) + $interval->h + ($interval->i / 60);

            if ($hoursDiff > 4) {
                $stmt = $pdo->prepare("DELETE FROM Appointment WHERE appID = ?");
                $stmt->execute([$appID]);

                header("Location: ../view_appointments.php?message=" . urlencode("Időpont sikeresen törölve.") . "&type=success");
            } else {
                header("Location: ../view_appointments.php?message=" . urlencode("Az időpont már nincs törölhető állapotban.") . "&type=alert");
            }
        } else {
            header("Location: ../view_appointments.php?message=" . urlencode("Az időpont nem található.") . "&type=alert");
        }
    } catch (PDOException $e) {
        header("Location: ../view_appointments.php?message=" . urlencode("Hiba történt az időpont törlése közben: " . $e->getMessage()) . "&type=alert");
    }
    exit();
} else {
    header("Location: ../index.php?message=Nem jogosult a művelet végrehajtására.");
    exit();
}