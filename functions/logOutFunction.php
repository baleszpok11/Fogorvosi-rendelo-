<?php
session_start();
require 'db-config.php';
global $conn;
// cookie törlése
if (isset($_COOKIE['remember_me_cookie'])) {
    unset($_COOKIE['remember_me_cookie']);
    setcookie('remember_me_cookie', '', ['expires' => time() - 3600, 'path' => '/']);
    $sql = "UPDATE Patient SET remember = NULL WHERE patientID = " . $_SESSION['patientID'];
    $conn->query($sql);
}

// session törlése
$_SESSION = array();

session_destroy();

header("Location: ../index.php");
exit();
