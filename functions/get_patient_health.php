<?php
require 'db-config.php';
global $conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patientID'])) {
    $patientID = $_POST['patientID'];

    try {
        $stmt = $conn->prepare("SELECT procedureDate, healthRating FROM PatientRecords WHERE patientID = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $result = $stmt->get_result();

        $labels = [];
        $scores = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['procedureDate'];
            $scores[] = $row['healthRating'];
        }

        $stmt->close();
        $conn->close();

        echo json_encode(['success' => true, 'labels' => $labels, 'scores' => $scores]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
