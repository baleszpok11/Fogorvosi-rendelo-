<head>
    <title>Bejelentkezés</title>
    <link rel="icon" type="image/x-icon" href="style/favicon_io/favicon-16x16.png">
    <link rel="stylesheet" href="style/style.css">
</head>
<div class="navbar">
    <ul>
        <li><a href="index.php">Kezdőoldal</a></li>
        <li><a href="register.php">Regisztráció</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
    </ul>
</div>
<div class="header">

    <div class="title">
        <h1>Bejelentkezés</h1>
    </div>
</div>
<div class="container">
<form action="functions/logFunction.php" method="post">
    <label for="email"></label>
    <input type="email" id="email" name="email" placeholder="Email" required><br><br>

    <label for="password"></label>
    <input type="password" id="password" name="password" placeholder="Jelszó" required><br><br>

    <label for="remember_me">
        Remember Me
        <input type="checkbox" id="remember_me" name="remember_me">
    </label><br><br>


    <input type="submit" value="Login">
</form>
</div>