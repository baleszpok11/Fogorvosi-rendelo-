<?php
include 'db-config.php';

global $conn;

// Retrieve doctorID from POST request and sanitize it
$doctorID = isset($_POST['doctorID']) ? intval($_POST['doctorID']) : null;

if (!empty($doctorID)) {
    // Prepare the SQL statement to prevent SQL injection
    $sql = $conn->prepare("DELETE FROM Doctor WHERE doctorID = ?");
    $sql->  bind_param("i", $doctorID);



    if ($sql->execute()) {
        echo "Record deleted successfully.<br>";
    } else {
        echo "Error: " . $sql->error . "<br>";
    }

    $sql->close();
} else {
    echo "Doctor ID is required for deleting a record.<br>";
}

$conn->close();
?>
