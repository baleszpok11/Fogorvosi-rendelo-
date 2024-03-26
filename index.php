<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="index.php">Kezdőlap</a></li>
<?php
if(!isset($_SESSION['jmbg'])){
    echo '<li><a href="register.php">Register</a></li>
<li><a href="login.php">Login</a></li>';
} else {
    echo $_SESSION['jmbg'] . ' ' . $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ';
    echo '<li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>';
}
?>
<!--<a href="https://www.google.com/maps?authuser=3" target="_blank">Megtalálsz minket ITT</a>
<iframe id="Google_map" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d22127.937621963854!2d19.811934!3d46.11106235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ssr!2srs!4v1711112002250!5m2!1ssr!2srs" width="90%" height="90%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --!>
</body>