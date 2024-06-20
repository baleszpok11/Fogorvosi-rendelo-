<?php
require 'db-config.php';
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patientID'])) {
    $patientID = intval($_POST['patientID']);

    $stmt = $pdo->prepare("SELECT procedureDate, healthRating FROM PatientRecords WHERE patientID = ?");
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patientID'])) {
        $patientID = intval($_POST['patientID']);

        try {
            $stmt = $pdo->prepare("SELECT procedureDate, healthRating FROM PatientRecords WHERE patientID = :patientID");
            $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
            $stmt->execute();

            if ($result->num_rows > 0) {
                $labels = [];
                $scores = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $labels[] = $row['procedureDate'];
                    $scores[] = $row['healthRating'];
                }
                echo json_encode(["success" => true, "labels" => $labels, "scores" => $scores]);
            } else {
                echo json_encode(["success" => false, "message" => "Nincs adat a megadott pácienshez."]);

                echo json_encode(['success' => true, 'labels' => $labels, 'scores' => $scores]);
            }
        } catch
        (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Hibás kérés."]);
    }
}