<?php
include 'db-config.php';

global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"];
    $procedureID = isset($_POST["procedureID"]) ? intval($_POST["procedureID"]) : null;
    $procedureName = isset($_POST["procedureName"]) ? $_POST["procedureName"] : null;
    $price = isset($_POST["price"]) ? floatval($_POST["price"]) : null;

    if ($operation == "insert") {
        $sql = "INSERT INTO Procedures (procedureName, price) VALUES (:procedureName, :price)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':procedureName', $procedureName, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "New procedure created successfully.";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } elseif ($operation == "update") {
        if (!empty($procedureID)) {
            $sql = "UPDATE Procedures SET procedureName = :procedureName, price = :price WHERE procedureID = :procedureID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':procedureName', $procedureName, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':procedureID', $procedureID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Procedure updated successfully.";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Procedure ID is required for updating a record.";
        }
    }
} else {
    echo "No form submitted.";
}

header("Location: ../admin.php");
exit();
?>
