<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dentist";

$conn = new mysqli($servername, $username, $password, $database);

if($conn -> connect_error){
    die('Csatlakozás sikertelen ' . $conn->connect_error);
}