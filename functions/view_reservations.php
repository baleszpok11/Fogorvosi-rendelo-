<?php
include '../functions/db-config.php';
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = isset($_POST['date']) ? $_POST['date'] : null;

    if (!empty($date)) {
        try {
            // Prepare the SQL query to fetch bookings for the selected date
            $stmt = $pdo->prepare("SELECT * FROM Appointment WHERE DATE(schedule) = :date");
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                echo "<h2>Bookings for " . htmlspecialchars($date) . ":</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Schedule</th>
                            <th>Doctor ID</th>
                            <th>Patient ID</th>
                            <th>Procedure ID</th>
                        </tr>";
                foreach ($result as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['appID']) . "</td>
                            <td>" . htmlspecialchars($row['schedule']) . "</td>
                            <td>" . htmlspecialchars($row['doctorID']) . "</td>
                            <td>" . htmlspecialchars($row['patientID']) . "</td>
                            <td>" . htmlspecialchars($row['procedureID']) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "Nincs foglalás erre a dátumra";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Adat szükséges.";
    }
} else {
    echo "Helytelen kitöltés.";
}
?>
