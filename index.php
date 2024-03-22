<?php
session_start();
?>
<head>
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
</head>
<div class="navbar-top">
    <a href="index.php">Főoldal</a>
    <?php
    if (!isset($_SESSION['jmbg'])) {
        echo '<div class="login-register">
            <a href="register.php">Regisztráció</a>
            <a href="login.php">Bejel</a>
    </div>';
    } else {
        echo '<div class ="logged"> <p>' . $_SESSION["jmbg"] . '</p>';
    }
    ?>
</div>