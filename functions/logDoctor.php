<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db-config.php';
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);

    $sql = "SELECT * FROM Doctor WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['doctorID'] = $row['doctorID'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['phoneNumber'] = $row['phoneNumber'];
            $_SESSION['email'] = $row['email'];

            if ($remember_me) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me_cookie', $token, time() + (86400 * 30), "/"); // 30 napos cookie
                $sql = "UPDATE Doctor SET remember = ? WHERE doctorID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $token, $row['doctorID']);
                $stmt->execute();
            }

            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?message=" . urlencode("Helytelen jelszó vagy email cím.") . "&type=alert");
        }
    } else {
        header("Location: ../login.php?message=" . urlencode("Helytelen jelszó vagy email cím.") . "&type=alert");
    }
    $conn->close();
}