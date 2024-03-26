<head>
    <title>Bejelentkezés</title>
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
</head>
<div class="navbar">
    <ul>
        <li><a href="index.php">Kezdőoldal</a></li>
        <li><a href="register.php">Regisztráció</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
    </ul>
</div>
<form action="functions/logFunction.php" method="post">
    <label for="email"></label>
    <input type="email" id="email" name="email" placeholder="Email" required><br><br>

    <label for="password"></label>
    <input type="password" id="password" name="password" placeholder="Jelszó" required><br><br>

    <input type="checkbox" id="remember_me" name="remember_me">
    <label for="remember_me">Remember Me</label><br><br>

    <input type="submit" value="Login">
</form>