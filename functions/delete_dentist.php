<?php
include 'db-config.php';

global $pdo;

// Retrieve doctorID from POST request and sanitize it
$doctorID = isset($_POST['doctorID']) ? intval($_POST['doctorID']) : null;

if (!empty($doctorID)) {
    try {
        // Prepare the SQL statement to prevent SQL injection
        $sql = $pdo->prepare("DELETE FROM Doctor WHERE doctorID = :doctorID");
        $sql->bindParam(':doctorID', $doctorID, PDO::PARAM_INT);

        if ($sql->execute()) {
            echo "Record deleted successfully.<br>";
        } else {
            echo "Error: Unable to execute the query.<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "Doctor ID is required for deleting a record.<br>";
}

$pdo = null;
?>
