<?php
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
    $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;

    if (empty($newPassword) && empty($phoneNumber) && empty($email)) {
        $response["message"] = "Nincs frissítendő adat.";
        echo json_encode($response);
        exit;
    }

    if (!isset($_SESSION['patientID'])) {
        $response["message"] = "Nem található azonosító.";
        echo json_encode($response);
        exit;
    }

    $patientID = $_SESSION['patientID'];

    require 'db-config.php';
    global $pdo;

    $sql = "UPDATE Patient SET ";

    $updates = [];
    if (!empty($newPassword)) {
        if (!preg_match('/^(?=.*[!@#$%^&*()_+{}\[\]:;"\'<>,.?\/])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $newPassword)) {
            $response["message"] = "A jelszónak legalább 8 karakter hosszúnak kell lennie, és tartalmaznia kell egy speciális karaktert, egy számot és egy nagybetűt.";
            echo json_encode($response);
            exit;
        }
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updates[] = "password = :password";
    }

    if (!empty($phoneNumber)) {
        $updates[] = "phoneNumber = :phoneNumber";
    }

    if (!empty($email)) {
        $updates[] = "email = :email";
    }

    if (!empty($updates)) {
        $sql .= implode(", ", $updates);
        $sql .= " WHERE patientID = :patientID";

        try {
            $stmt = $pdo->prepare($sql);

            if (!empty($newPassword)) {
                $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            }
            if (!empty($phoneNumber)) {
                $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
            }
            if (!empty($email)) {
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            }
            $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $response["success"] = true;
                $response["message"] = "Profil sikeresen frissítve.";
            } else {
                $response["message"] = "Hiba történt a profil frissítése közben: " . implode(" ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $response["message"] = "Hiba történt a profil frissítése közben: " . $e->getMessage();
        }
    }
} else {
    $response["message"] = "Érvénytelen kérés.";
}

echo json_encode($response);