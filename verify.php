<?php
require 'functions/db-config.php';
global $conn;
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT patientID FROM Patient WHERE auth = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $token);
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $patientID = $row['patientID'];

        $stmt = $conn->prepare("UPDATE Patient SET auth = NULL WHERE patientID = ?");
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("i", $patientID);
        if ($stmt->execute()) {
            header("Location: index.php?message=" . urlencode("Email cím megerősítve.") . "&type=success");
            exit();
        } else {
            header("Location: index.php?message=" . urlencode("Hiba történt a megerősítés során: " . $stmt->error) . "&type=alert");
            exit();
        }
    } else {
        header("Location: index.php?message=" . urlencode("Érvénytelen token.") . "&type=alert");
        exit();
    }
} else {
    header("Location: index.php?message=" . urlencode("Hiányzó token.") . "&type=alert");
    exit();
}