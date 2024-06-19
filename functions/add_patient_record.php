<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['doctorID'])) {
    require 'db-config.php';
    global $conn;
    $doctorID = $_SESSION['doctorID'];
    $patientID = trim($_POST['patientID']);
    $procedureDate = trim($_POST['procedureDate']);
    $procedureDetails = trim($_POST['procedureDetails']);
    $notes = trim($_POST['notes']);
    $procedureID = trim($_POST['procedure_id']);

    $stmt = $conn->prepare("INSERT INTO PatientRecords (patientID, doctorID, procedureDate, procedureDetails, notes, procedureID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssi", $patientID, $doctorID, $procedureDate, $procedureDetails, $notes, $procedureID);

    if ($stmt->execute()) {
        header("Location: ../add_patient_record.php?message=Kezelési adat sikeresen hozzáadva.");
    } else {
        header("Location: ../add_patient_record.php?message=Hiba történt a kezelési adat hozzáadása közben: " . $stmt->error);
    }
} else {
    header("Location: ../index.php?message=Nem jogosult a művelet végrehajtására.");
    exit();
}