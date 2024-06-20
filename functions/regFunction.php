<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db-config.php';
    require 'send_verification_email.php';

    global $pdo;
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $passwordCon = $_POST["passwordConfirm"];
    $email = $_POST["email"];
    $username = strstr($email, '@', true);

    if ($password !== $passwordCon) {
        header("Location: ../register.php?message=" . urlencode("Jelszó nem egyezik.") . "&type=alert");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16));

    try {
        $stmt = $pdo->prepare("INSERT INTO Patient (userName, firstName, lastName, phoneNumber, email, password, auth) VALUES (:username, :firstName, :lastName, :phoneNumber, :email, :password, :auth)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':auth', $token, PDO::PARAM_STR);

        if ($stmt->execute()) {
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
    } catch (PDOException $e) {
        header("Location: ../index.php?message=" . urlencode("Regisztráció sikertelen volt: " . $e->getMessage()) . "&type=alert");
        exit();
    }
} else {
    header("Location: ../register.php");
    exit();
}
?>
