<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db-config.php';
    global $pdo;

    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;

    $sql = "SELECT * FROM Patient WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['patientID'] = $row['patientID'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['phoneNumber'] = $row['phoneNumber'];
            $_SESSION['email'] = $row['email'];

            if ($remember_me) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me_cookie', $token, time() + (86400 * 30), "/"); // 30 days cookie
                $sql = "UPDATE Patient SET remember = :token WHERE patientID = :patientID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':patientID', $row['patientID'], PDO::PARAM_INT);
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

    // Redirect back to login page with error message
    header("Location: ../login.php?error=" . urlencode($error_message));
    exit();
} else {
    header("Location: ../login.php");
    exit();
}
?>
