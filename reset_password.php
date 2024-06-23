<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Jelszó visszaállítása</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="padding-top: 70px;">
    <h2>Jelszó visszaállítása</h2>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php endif; ?>
    <form method="POST" action="functions/reset_password.php">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <div class="form-group">
            <label for="password">Új jelszó:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Jelszó megerősítése:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Visszaállítás</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>