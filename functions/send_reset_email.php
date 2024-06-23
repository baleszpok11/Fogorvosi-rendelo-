<?php
require '../vendor/autoload.php';
require 'db-config.php';
global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT patientID, email FROM Patient WHERE email = ?");
    $stmt->execute([$email]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("SELECT doctorID, email FROM Doctor WHERE email = ?");
    $stmt2->execute([$email]);
    $doctor = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($patient || $doctor) {
        $token = bin2hex(random_bytes(16));

        if ($patient) {
            $stmt = $pdo->prepare("UPDATE Patient SET forgot = ? WHERE email = ?");
            $stmt->execute([$token, $email]);
        } elseif ($doctor) {
            $stmt2 = $pdo->prepare("UPDATE Doctor SET forgot = ? WHERE email = ?");
            $stmt2->execute([$token, $email]);
        }

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'in-v3.mailjet.com';
        $mail->SMTPAuth = true;
        $mail->Username = '81ea24ce778b6e7ecc44af9aaaca1da3';
        $mail->Password = '418bade66c7e26bbc9fb672efadd6512';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('balogbalesz1234@gmail.com', 'Fogorvosi rendelő');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Subject = 'Jelszó visszaállítás';
        $mail->Body = "<p>Kedves felhasználó!</p>
                       <p>Kattintson az alábbi linkre a jelszó visszaállításához:</p>
                       <p><a href='https://lite.stud.vts.su.ac.rs/reset_password.php?token=$token'>Jelszó visszaállítása</a></p>
                       <p>Ha nem Ön kérte a jelszó visszaállítását, kérjük, hagyja figyelmen kívül ezt az üzenetet.</p>";

        if (!$mail->send()) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            header("Location: ../request_reset.php?message=" . urlencode($mail->ErrorInfo) . "&type=alert");
        } else {
            header("Location: ../request_reset.php?message=" . urlencode("Ellenőrizze az email fiókját a jelszó visszaállításához.") . "&type=success");
        }
    } else {
        header("Location: ../request_reset.php?message=" . urlencode("Az email cím nem található.") . "&type=alert");
    }
    exit();
} else {
    header("Location: ../index.php?message=" . urlencode("Hibás kérés.") . "&type=alert");
    exit();
}