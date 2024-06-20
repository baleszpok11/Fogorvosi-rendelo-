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
    $healthRating = trim($_POST['healthRating']);

    try {
        $stmt = $conn->prepare("INSERT INTO PatientRecords (patientID, doctorID, procedureDate, procedureDetails, notes, procedureID, healthRating) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssii", $patientID, $doctorID, $procedureDate, $procedureDetails, $notes, $procedureID, $healthRating);
    }
    catch(Exception $e) {
        header("Location: ../add_patient_records.php?message=" . urlencode("Hiba történt a kezelési adat hozzáadása közben: " . $e->getMessage()));
    }
    if ($stmt->execute()) {
        header("Location: ../add_patient_records.php?message=" . urlencode("Kezelési adat sikeresen hozzáadva.") . "&type=success");
    } else {
        header("Location: ../add_patient_records.php?message=" . urlencode("Hiba történt a kezelési adat hozzáadása közben: " . $stmt->error));
    }
} else {
    header("Location: ../index.php?message=Nem jogosult a művelet végrehajtására.");
    exit();
}
?>
