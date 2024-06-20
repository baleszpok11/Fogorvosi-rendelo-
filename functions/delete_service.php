<?php
global $pdo;
include 'db-config.php'; // Include your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize procedureID
    $procedureID = isset($_POST['procedureID']) ? intval($_POST['procedureID']) : null;

    if (!empty($procedureID)) {
        try {
            // Prepare the SQL statement
            $sql = $pdo->prepare("DELETE FROM Procedures WHERE procedureID = :procedureID");
            $sql->bindParam(':procedureID', $procedureID, PDO::PARAM_INT);

            // Execute the SQL statement
            if ($sql->execute()) {
                echo "Procedure deleted successfully.";
            } else {
                echo "Error: Unable to execute the query.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Procedure ID is required for deleting a record.";
    }
} else {
    // No form submitted
    echo "No form submitted.";
}

// Close the PDO connection
$pdo = null;

