<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="index.php">Kezdőoldal</a></li>
        <li><a href="register.php">Regisztráció</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
    </ul>
</div>
<div class="header">

    <div class="title">
        <h1>Regisztráció</h1>
    </div>
</div>
    <div class="container">
<form action="functions/regFunction.php" method="POST" onsubmit="return validateForm()">
    <label for="jmbg"></label>
    <input type="text" id="jmbg" name="jmbg" placeholder="JMBG" required><br><br>
    <br>
    <label for="firstName"></label>
    <input type="text" id="firstName" name="firstName" placeholder="Keresztnév" required><br><br>
    <br>
    <label for="lastName"></label>
    <input type="text" id="lastName" name="lastName" placeholder="Vezetéknév" required><br><br>
    <br>
    <label for="phoneNumber"></label>
    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Telefonszám" required><br><br>
    <br>
    <label for="email"></label>
    <input type="email" id="email" name="email" placeholder="Email cím" required><br><br>
    <small id="emailHelpBlock" style="display: none; color: red;">Kérem, adjon meg egy érvényes e-mail címet.</small>
    <br>
    <label for="password"></label>
    <input type="password" id="password" name="password" placeholder="Jelszó" required><br><br>
    <small id="passwordHelpBlock" style="display: none; color: red;">A jelszónak legalább egy számot, egy nagybetűt, és
        egy speciális karaktert (pl. !) kell tartalmaznia.</small>
    <br>
    <label for="passwordConfirm"></label>
    <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Jelszó megerősítése" required>
    <small id="passwordConfirmHelpBlock" style="display: none; color: red;">A jelszó és a megerősítés nem egyezik
        meg.</small><br><br>
    <br>
    <input type="submit" value="Regisztráció" name="register" id="registerBtn" disabled>
</form>
</div>
<script src="functions/register.js"></script>
</body>