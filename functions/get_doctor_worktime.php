<?php
require 'db-config.php';
global $conn;

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    $stmt = $conn->prepare("SELECT worktime FROM Doctor WHERE doctorID = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();

    $stmt2 = $conn->prepare("SELECT Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday FROM DoctorSchedule WHERE doctorID = ?");
    $stmt2->bind_param("i", $doctor_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $schedule = $result2->fetch_assoc();

    if ($doctor && $schedule) {
        $worktime = explode('-', $doctor['worktime']);
        $start_time = $worktime[0];
        $end_time = $worktime[1];

        echo json_encode([
            'start' => $start_time,
            'end' => $end_time,
            'days' => $schedule
        ]);
    } else {
        echo json_encode(['error' => 'Doctor not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>