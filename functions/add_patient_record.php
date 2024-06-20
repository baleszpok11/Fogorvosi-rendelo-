<?php
global $pdo;
include 'db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientID = isset($_POST["patientID"]) ? intval($_POST["patientID"]) : null;
    $recordDate = isset($_POST["recordDate"]) ? $_POST["recordDate"] : null;
    $description = isset($_POST["description"]) ? $_POST["description"] : null;
    $procedureID = isset($_POST["procedureID"]) ? intval($_POST["procedureID"]) : null;

    if ($patientID && $recordDate && $description && $procedureID) {
        try {
            $sql = $pdo->prepare("INSERT INTO PatientRecords (patientID, recordDate, description, procedureID) VALUES (:patientID, :recordDate, :description, :procedureID)");
            $sql->bindParam(':patientID', $patientID);
            $sql->bindParam(':recordDate', $recordDate);
            $sql->bindParam(':description', $description);
            $sql->bindParam(':procedureID', $procedureID);

            if ($sql->execute()) {
                echo "New patient record created successfully.";
            } else {
                echo "Error: Unable to execute the query.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "No form submitted.";
}

$pdo = null;
header("Location: ../admin.php");
?>
