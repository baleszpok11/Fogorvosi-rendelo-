<?php
session_start();

// cookie törlése
if (isset($_COOKIE['remember_me_cookie'])) {
    unset($_COOKIE['remember_me_cookie']);
    setcookie('remember_me_cookie', '', ['expires' => time() - 3600, 'path' => '/']);
}

// session törlése
$_SESSION = array();

session_destroy();

header("Location: ../index.php");
exit();
