<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendEmail($to, $subject, $body, $from = 'balogbalesz1234@gmail.com', $fromName = 'Lite') {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'in-v3.mailjet.com'; // Mailjet SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = '81ea24ce778b6e7ecc44af9aaaca1da3'; // Mailjet API key
        $mail->Password   = '418bade66c7e26bbc9fb672efadd6512'; // Mailjet secret key
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}