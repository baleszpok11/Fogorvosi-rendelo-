<?php
require 'db-config.php';
global $conn;

if (isset($_GET['doctor_id']) && isset($_GET['date'])) {
    $doctor_id = $_GET['doctor_id'];
    $date = $_GET['date'];

    $stmt = $conn->prepare("SELECT TIME(schedule) AS time FROM Appointment WHERE doctorID = ? AND DATE(schedule) = ?");
    $stmt->bind_param("is", $doctor_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedTimes = [];
    while ($row = $result->fetch_assoc()) {
        $bookedTimes[] = $row['time'];
    }

    echo json_encode($bookedTimes);
} else {
    echo json_encode([]);
}