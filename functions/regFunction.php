<?php
if(isset($_POST)){
    require 'connection.php';
    global $conn;
    $lastName = $_POST["lastName"];
    $firstName = $_POST["firstName"];
    $jmbg = $_POST["jmbg"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["passwordConfirm"];
    $email = $_POST["email"];
    echo $password, $passwordConfirmation;
    if($password !== $passwordConfirmation)
    {
        echo '<script>alert("Password confirmation does not match"); window.location.href = "../register.php";</script>';
        $conn->close();
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO Patient (jmbg ,firstName, lastName, phoneNumber, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $jmbg, $firstName, $lastName, $phoneNumber, $email, $hashed_password);

    if ($stmt->execute() === TRUE) {
        echo '<script>alert("A regisztráció sikeres volt!"); window.location.href = "../index.php";</script>';
        $conn->close();
        exit();
    } else {
        echo '<script>alert("A regisztáció sikertelen volt!"); window.location.href = "../index.php";</script>';
        $conn->close();
        exit();
    }
}