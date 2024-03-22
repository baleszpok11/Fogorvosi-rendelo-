<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <title>Fogorvosi rendelő</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
</head>
<body>
<div id="container">
    <div class="header">

        <div class="title">
            <h1>Fogorvosi rendelő</h1>
        </div>
        <div class="info">

            <div class="manu">
                <ul>
                    <li><a href="index.php">Kezdőlap</a></li>
                    <li><a href="#">Áraink</a></li>
                    <li><a href="#">Időpont foglalás</a></li>
                    <li><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                </ul>
            </div>

        </div>

    </div>
    <hr>
    <div class="middle"></div>

    </div>
<hr>
<footer>
    <div id="informations">
        <div class="work_time">
            <ul>
                <li>Hetfő: <b>10:00 - 18:00</b> </li>
                <li>Kedd: <b>10:00 - 18:00</b> </li>
                <li>Szerda: <b>10:00 - 18:00</b></li>
                <li>Csütörtök: <b>10:00 - 18:00</b></li>
                <li>Péntek: <b>10:00 - 18:00</b> </li>
                <li>Szombat: <b>10:00 - 18:00</b></li>
                <li>Vasárnap: <b>10:00 - 18:00</b> </li>
            </ul>
        </div>
        <div class="contacts">
            <ul>
                <li>Tel: <b>06 20 564 2821</b></li>
                <li>Email: <b>fogorvos@gmail.com</b></li>
                <li>Cím: <b>valami</b></li>
            </ul>
        </div>
    </div>
    <div class="locations">
        <a href="https://www.google.com/maps?authuser=3" target="_blank">Megtalálsz minket ITT</a>
        <iframe id="Google_map" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d22127.937621963854!2d19.811934!3d46.11106235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ssr!2srs!4v1711112002250!5m2!1ssr!2srs" width="90%" height="90%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</footer>
</body>