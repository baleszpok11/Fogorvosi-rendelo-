<?php
if(isset($_POST)){
    require 'db-config.php';
    global $conn;
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $passwordCon = $_POST["passwordConfirm"];
    $email = $_POST["email"];
    $username = $_POST["username"];

    if($password !== $passwordCon)
    {
        header("Location: ../register.php?message=Jelszó nem egyezik.");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO Patient (userName, firstName, lastName, phoneNumber, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $firstName, $lastName, $phoneNumber, $email, $hashed_password);

    if ($stmt->execute() === TRUE) {
        header("Location: ../index.php?message=Regisztráció sikeres volt.");
        exit();
    } else {
        header("Location: ../index.php?message=Regisztráció sikertelen volt.");
        exit();
    }
}
?>