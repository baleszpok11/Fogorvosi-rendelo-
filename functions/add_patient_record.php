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
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM PatientRecords WHERE patientID = ? AND procedureDate < ?");
        $stmt->execute([$patientID, $procedureDate]);
        $visit_count = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT price FROM Procedures WHERE procedureID = ?");
        $stmt->execute([$procedureID]);
        $original_price = $stmt->fetchColumn();

        $discount_percentage = 0;
        if ($visit_count >= 15) {
            $discount_percentage = 15;
        } elseif ($visit_count >= 8) {
            $discount_percentage = 10;
        } elseif ($visit_count >= 3) {
            $discount_percentage = 5;
        }

        $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

        if ($discounted_price < 0) {
            $discounted_price = 0;
        }


        $stmt = $pdo->prepare("INSERT INTO PatientRecords (patientID, doctorID, procedureDate, procedureDetails, notes, procedureID, healthRating, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$patientID, $doctorID, $procedureDate, $procedureDetails, $notes, $procedureID, $healthRating, $discounted_price]);

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
?>
