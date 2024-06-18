<?php
require 'db-config.php';
global $conn;

if (isset($_GET['doctor_id']) && isset($_GET['date'])) {
    $doctor_id = $_GET['doctor_id'];
    $date = $_GET['date'];

    $stmt = $conn->prepare("SELECT A.appID, A.schedule, D.firstName, D.lastName FROM Appointment A INNER JOIN Doctor D ON A.doctorID = D.doctorID WHERE A.doctorID = ? AND DATE(A.schedule) = ?");
    $stmt->bind_param("is", $doctor_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedSlots = [];
    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = [
            'id' => $row['appID'],
            'doctor' => $row['firstName'] . ' ' . $row['lastName'],
            'day' => date('Y-m-d', strtotime($row['schedule'])),
            'time' => date('H:i', strtotime($row['schedule']))
        ];
    }

    echo json_encode($bookedSlots);
} else {
    echo json_encode([]);
}
?>