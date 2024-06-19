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

    // Extract username from email
    $username = strstr($email, '@', true);

    if($password !== $passwordCon) {
        header("Location: ../register.php?message=" . urlencode("Jelszó nem egyezik.") . "&type=alert");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO Patient (userName, firstName, lastName, phoneNumber, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $firstName, $lastName, $phoneNumber, $email, $hashed_password);

    if ($stmt->execute() === TRUE) {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikeres volt.") . "&type=success");
        exit();
    } else {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikertelen volt.") . "&type=alert");
        exit();
    }
}
?>
