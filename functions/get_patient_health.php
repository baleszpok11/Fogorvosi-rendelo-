<?php
require 'db-config.php';
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['patientID'])) {
    $patientID = intval($_POST['patientID']);

    try {
        $stmt = $pdo->prepare("SELECT procedureDate, healthRating FROM PatientRecords WHERE patientID = ? ORDER BY procedureDate");
        $stmt->bindParam(1, $patientID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $labels = [];
            $scores = [];

            foreach ($result as $row) {
                $labels[] = $row['procedureDate'];
                $scores[] = $row['healthRating'];
            }

            echo json_encode(["success" => true, "labels" => $labels, "scores" => $scores]);
        } else {
            echo json_encode(["success" => false, "message" => "Nincs adat a megadott pácienshez."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Hibás kérés."]);
}
