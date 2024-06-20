<?php
include 'db-config.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"];
    $procedureID = isset($_POST["procedureID"]) ? intval($_POST["procedureID"]) : null;
    $procedureName = isset($_POST["procedureName"]) ? $_POST["procedureName"] : null;
    $price = isset($_POST["price"]) ? floatval($_POST["price"]) : null;

    if ($operation == "insert") {
        $sql = $conn->prepare("INSERT INTO Procedures (procedureName, price) VALUES (?, ?)");
        $sql->bind_param("sd", $procedureName, $price);

        if ($sql->execute()) {
            echo "New procedure created successfully.";
        } else {
            echo "Error: " . $sql->error;
        }

        $sql->close();
    } elseif ($operation == "update") {
        if (!empty($procedureID)) {
            $sql = $conn->prepare("UPDATE Procedures SET procedureName = ?, price = ? WHERE procedureID = ?");
            $sql->bind_param("sdi", $procedureName, $price, $procedureID);

            if ($sql->execute()) {
                echo "Procedure updated successfully.";
            } else {
                echo "Error: " . $sql->error;
            }

            $sql->close();
        } else {
            echo "Procedure ID is required for updating a record.";
        }
    }
} else {
    echo "No form submitted.";
}

$conn->close();
header("Location: ../admin.php");
?>
