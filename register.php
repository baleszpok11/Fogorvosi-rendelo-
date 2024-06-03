<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció</title>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Fogorvosi rendelő</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Kezdőoldal</a></li>
                <?php if (!isset($_SESSION['patientID'])): ?>
                    <li class="active"><a href="register.php">Regisztráció</a></li>
                    <li><a href="login.php">Bejelentkezés</a></li>
                <?php else: ?>
                    <li><a href="appointment.php">Időpont foglalás</a></li>
                    <li><a href="doctors.php">Orvosaink</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php">Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Regisztráció</h1>
    <form action="functions/regFunction.php" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="firstName">Keresztnév:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Keresztnév" required>
        </div>
        <div class="form-group">
            <label for="lastName">Vezetéknév:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Vezetéknév" required>
        </div>
        <div class="form-group">
            <label for="phoneNumber">Telefonszám:</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Telefonszám" required>
        </div>
        <div class="form-group">
            <label for="email">Email cím:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email cím" required>
            <small id="emailHelpBlock" class="form-text text-muted" style="display: none; color: red;">Kérem, adjon meg egy érvényes e-mail címet.</small>
        </div>
        <div class="form-group">
            <label for="password">Jelszó:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Jelszó" required>
            <small id="passwordHelpBlock" class="form-text text-muted" style="display: none; color: red;">A jelszónak legalább egy számot, egy nagybetűt, és egy speciális karaktert (pl. !) kell tartalmaznia.</small>
        </div>
        <div class="form-group">
            <label for="passwordConfirm">Jelszó megerősítése:</label>
            <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Jelszó megerősítése" required>
            <small id="passwordConfirmHelpBlock" class="form-text text-muted" style="display: none; color: red;">A jelszó és a megerősítés nem egyezik meg.</small>
        </div>
        <button type="submit" class="btn btn-primary" id="registerBtn" disabled>Regisztráció</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="functions/register.js"></script>

</body>
</html>