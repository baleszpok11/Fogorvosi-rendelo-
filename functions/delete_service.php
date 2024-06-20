<?php
include 'db-config.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $procedureID = isset($_POST['procedureID']) ? intval($_POST['procedureID']) : null;

    if (!empty($procedureID)) {
        $sql = $conn->prepare("DELETE FROM Procedures WHERE procedureID = ?");
        $sql->bind_param("i", $procedureID);

        if ($sql->execute()) {
            echo "Procedure deleted successfully.";
        } else {
            echo "Error: " . $sql->error;
        }

        $sql->close();
    } else {
        echo "Procedure ID is required for deleting a record.";
    }
} else {
    echo "No form submitted.";
}

$conn->close();

