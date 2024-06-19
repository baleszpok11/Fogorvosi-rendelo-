<?php
require '../vendor/autoload.php'; // Ensure PHPMailer is loaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST)) {
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

    if ($password !== $passwordCon) {
        header("Location: ../register.php?message=" . urlencode("Jelszó nem egyezik.") . "&type=alert");
        exit();
    }

    // Generate unique token
    $token = bin2hex(random_bytes(16));
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO Patient (userName, firstName, lastName, phoneNumber, email, password, auth) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $firstName, $lastName, $phoneNumber, $email, $hashed_password, $token);

    if ($stmt->execute() === TRUE) {
        // Send verification email
        sendVerificationEmail($email, $token);
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikeres volt. Kérjük, ellenőrizze az email fiókját a megerősítéshez.") . "&type=success");
        exit();
    } else {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikertelen volt.") . "&type=alert");
        exit();
    }
}

function sendVerificationEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mailjet.com'; // Mailjet SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_mailjet_username'; // Mailjet username
        $mail->Password = 'your_mailjet_password'; // Mailjet password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('no-reply@yourdomain.com', 'Fogorvosi Rendelő');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email megerősítése';
        $mail->Body    = "Kérjük, kattintson a következő linkre az email cím megerősítéséhez: <a href='http://localhost:8000/Fogorvosi-rendelo-/verify.php?token=$token'>Megerősítés</a>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}