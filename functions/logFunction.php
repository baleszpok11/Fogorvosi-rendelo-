<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connection.php';
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;

    $sql = "SELECT * FROM Patient WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['jmbg'] = $row['jmbg'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['phoneNumber'] = $row['phoneNumber'];
            $_SESSION['email'] = $row['email'];

            if ($remember_me) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me_cookie', $token, time() + (86400 * 30), "/"); // 30 napos cookie
                $sql = "UPDATE Patient SET token = '$token' WHERE jmbg = " . $row['jmbg'];
                $conn->query($sql);
            }

            header("Location: ../index.php");
            exit();
        } else {
            $error_message = "Helytelen jelszó vagy email cím.";
        }
    } else {
        $error_message = "Helytelen jelszó vagy email cím.";
    }
}

$conn->close();
?>
