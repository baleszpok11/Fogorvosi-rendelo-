<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db-config.php';
    global $conn;
    $lastName = $_POST["lastName"];
    $firstName = $_POST["firstName"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $passwordCon = $_POST["passwordConfirm"];
    $email = $_POST["email"];

    if ($password !== $passwordCon) {
        header("Location: ../register.php?message=" . urlencode("Jelszavak nem egyeznek.") . "&type=error");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO Patient (firstName, lastName, phoneNumber, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $hashed_password);

    if ($stmt->execute() === TRUE) {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikeres volt.") . "&type=success");
        exit();
    } else {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikertelen volt.") . "&type=error");
        exit();
    }
}