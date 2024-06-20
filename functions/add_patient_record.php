<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['doctorID'])) {
    require 'db-config.php';
    global $pdo;
    $doctorID = $_SESSION['doctorID'];
    $patientID = trim($_POST['patientID']);
    $procedureDate = trim($_POST['procedureDate']);
    $procedureDetails = trim($_POST['procedureDetails']);
    $notes = trim($_POST['notes']);
    $procedureID = trim($_POST['procedure_id']);
    $healthRating = trim($_POST['healthRating']);

    try {
        $stmt = $pdo->prepare("INSERT INTO PatientRecords (patientID, doctorID, procedureDate, procedureDetails, notes, procedureID, healthRating) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$patientID, $doctorID, $procedureDate, $procedureDetails, $notes, $procedureID, $healthRating]);

        header("Location: ../add_patient_records.php?message=" . urlencode("Kezelési adat sikeresen hozzáadva.") . "&type=success");
        exit();
    } catch (PDOException $e) {
        header("Location: ../add_patient_records.php?message=" . urlencode("Hiba történt a kezelési adat hozzáadása közben: " . $e->getMessage()) . "&type=alert");
        exit();
    }
} else {
    header("Location: ../index.php?message=Nem jogosult a művelet végrehajtására.");
    exit();
}