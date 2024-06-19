<?php
if(isset($_POST)){
    require 'db-config.php';
    require 'send_verification_email.php';

    global $conn;
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $passwordCon = $_POST["passwordConfirm"];
    $email = $_POST["email"];
    $username = strstr($email, '@', true);

    if($password !== $passwordCon) {
        header("Location: ../register.php?message=" . urlencode("Jelszó nem egyezik.") . "&type=alert");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("INSERT INTO Patient (userName, firstName, lastName, phoneNumber, email, password, auth) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $firstName, $lastName, $phoneNumber, $email, $hashed_password, $token);

    if ($stmt->execute() === TRUE) {
        if (send_verification_email($email, $token)) {
            header("Location: ../index.php?message=" . urlencode("Regisztráció sikeres volt. Ellenőrizze az email címét a megerősítéshez.") . "&type=success");
        } else {
            header("Location: ../index.php?message=" . urlencode("Regisztráció sikeres volt, de a megerősítő email küldése nem sikerült.") . "&type=alert");
        }
        exit();
    } else {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikertelen volt.") . "&type=alert");
        exit();
    }
}