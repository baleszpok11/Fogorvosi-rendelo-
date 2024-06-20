<?php
include 'db-config.php';

$conn = getDbConnection();

if (isset($_POST['view_reservations'])) {
    $date = $_POST['date'];
    $sql = "SELECT * FROM Reservations WHERE date='$date'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Foglalások $date dátumra</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Időpont: " . $row["appointment_id"] . " - Orvos: " . $row["doctor_id"] . " - Időpont: " . $row["time"] . "<br>";
        }
    } else {
        echo "Nincs foglalás ezen a napon.";
    }
}

$conn->close();
?>
