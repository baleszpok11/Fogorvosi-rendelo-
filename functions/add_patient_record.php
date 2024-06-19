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

    // Check if patientID exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Patient WHERE patientID = ?");
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        header("Location: ../add_patient_records.php?message=" . urlencode("A megadott páciens ID nem létezik.") . "&type=danger");
        exit();
    }

    // Insert the patient record
    try {
        $stmt = $conn->prepare("INSERT INTO PatientRecords (patientID, doctorID, procedureDate, procedureDetails, notes, procedureID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssi", $patientID, $doctorID, $procedureDate, $procedureDetails, $notes, $procedureID);
    } catch (Exception $e) {
        header("Location: ../add_patient_records.php?message=" . urlencode("Hiba történt a kezelési adat hozzáadása közben: " . $e->getMessage()));
        exit();
    }

    if ($stmt->execute()) {
        header("Location: ../add_patient_records.php?message=" . urlencode("Kezelési adat sikeresen hozzáadva.") . "&type=success");
    } else {
        header("Location: ../add_patient_records.php?message=" . urlencode("Hiba történt a kezelési adat hozzáadása közben: " . $stmt->error) . "&type=danger");
    }
    $stmt->close();
} else {
    header("Location: ../index.php?message=Nem jogosult a művelet végrehajtására.");
    exit();
}