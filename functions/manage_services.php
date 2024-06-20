<?php
include 'db-config.php';

$conn = getDbConnection();

if (isset($_POST['add_appointment'])) {
    $name = $_POST['appointment_name'];
    $price = $_POST['price'];
    $sql = "INSERT INTO Appointments (name, price) VALUES ('$name', $price)";
    $conn->query($sql);
}

if (isset($_POST['modify_appointment'])) {
    $id = $_POST['appointment_id_modify'];
    $name = $_POST['new_appointment_name'];
    $duration = $_POST['new_duration'];
    $price = $_POST['new_price'];
    $sql = "UPDATE Appointments SET name='$name', price=$price WHERE id=$id";
    $conn->query($sql);
}

if (isset($_POST['delete_appointment'])) {
    $id = $_POST['appointment_id_delete'];
    $sql = "DELETE FROM Appointments WHERE id=$id";
    $conn->query($sql);
}

$conn->close();
header("Location: ../admin.php");
?>
