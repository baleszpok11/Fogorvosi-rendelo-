<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db-config.php';
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;

    $sql = "SELECT * FROM Patient WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['patientID'] = $row['patientID'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['phoneNumber'] = $row['phoneNumber'];
            $_SESSION['email'] = $row['email'];

            if ($remember_me) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me_cookie', $token, time() + (86400 * 30), "/"); // 30 days cookie
                $sql = "UPDATE Patient SET remember = ? WHERE patientID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $token, $row['patientID']);
                $stmt->execute();
            }

            header("Location: ../index.php");
            exit();
        } else {
            $error_message = "Helytelen jelszó vagy email cím.";
        }
    } else {
        $error_message = "Helytelen jelszó vagy email cím.";
    }
    $stmt->close();
    $conn->close();

    // Redirect back to login page with error message
    header("Location: ../login.php?error=" . urlencode($error_message));
    exit();
} else {
    header("Location: ../login.php");
    exit();
}