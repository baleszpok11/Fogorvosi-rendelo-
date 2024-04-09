<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
</head>
<?php
if(!isset($_SESSION['patientID'])){
    echo '<a href="register.php">Regisztráció</a>
<a href="login.php">Bejelentkezés</a>';
} else {
    echo $_SESSION['patientID'] . ' ' . $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ';
    echo '';
}
?>