<?php
session_start();
require 'functions/db-config.php';
global $conn;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT patientID FROM Patient WHERE auth = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt = $conn->prepare("UPDATE Patient SET auth = NULL WHERE patientID = ?");
        $stmt->bind_param("i", $row['patientID']);
        if ($stmt->execute()) {
            header("Location: index.php?message=" . urlencode("Email cím megerősítve.") . "&type=success");
            exit();
        } else {
            header("Location: index.php?message=" . urlencode("Hiba történt a fiók megerősítése közben.") . "&type=alert");
            exit();
        }
    } else {
        header("Location: index.php?message=" . urlencode("Érvénytelen megerősítési token.") . "&type=alert");
        exit();
    }
} else {
    header("Location: index.php?message=" . urlencode("Nincs megerősítési token megadva.") . "&type=alert");
    exit();
}