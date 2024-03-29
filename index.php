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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="source/images/Lite.png" alt="BS Lite" style="height: auto; width: 100px">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php"></a>
                </li>
<?php
if(!isset($_SESSION['jmbg'])){
    echo '<li class="nav-item"><a class="nav-link" href="register.php">Regisztráció</a></li>
<li class="nav-item"><a class="nav-link" href="login.php">Bejelentkezés</a></li>';
} else {
    echo $_SESSION['jmbg'] . ' ' . $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] . ' ';
    echo '';
}
?>
            </ul>
        </div>
    </div>
</nav>
