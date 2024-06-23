<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';

function send_verification_email($email, $token)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'in-v3.mailjet.com';
        $mail->SMTPAuth = true;
        $mail->Username = '81ea24ce778b6e7ecc44af9aaaca1da3';
        $mail->Password = '418bade66c7e26bbc9fb672efadd6512';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('balogbalesz1234@gmail.com', 'Balint');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email megerősítés';
        $verificationLink = "https://lite.stud.vts.su.ac.rs/verify.php?token=$token";
        $mail->Body = "Kérjük, erősítse meg az email címét az alábbi linkre kattintva: <a href='$verificationLink'>Email megerősítése</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

?>
