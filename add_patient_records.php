<?php
session_start();
if (!isset($_SESSION['doctorID'])) {
    header("location: index.php?message=" . urlencode("Jelentkezzen be") . "&type=alert");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Páciens kezelési adatainak hozzáadása</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Fogorvosi rendelő</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Kezdőoldal</a></li>
            <li><a href="doctors.php">Orvosaink</a></li>
            <li class="active"><a href="add_patient_records.php">Karton írása</a></li>
            <li><a href="view_patient_records.php">Kartonok megtekintése</a></li>
            <li><a href="view_patient_health.php">Fogak állapota</a></li>
            <li><a href="view_appointments.php">Foglalásaim</a></li>
            <li><a href="admin.php">Admin oldal</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Páciens kezelési adatainak hozzáadása</h2>
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-info" role="alert"><?php echo htmlspecialchars($_GET['message']); ?></div>
            <?php endif; ?>
            <form method="POST" action="functions/add_patient_record.php" class="form-horizontal">
                <div class="form-group">
                    <label for="patientID" class="col-sm-3 control-label">Páciens ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="patientID" name="patientID" placeholder="Páciens ID"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="procedureDate" class="col-sm-3 control-label">Eljárás dátuma</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="procedureDate" name="procedureDate" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="procedureDetails" class="col-sm-3 control-label">Eljárás részletei</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="procedureDetails" name="procedureDetails" rows="4"
                                  required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="col-sm-3 control-label">Megjegyzések</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="procedure" class="col-sm-3 control-label">Eljárás</label>
                    <div class="col-sm-9">
                        <select id="procedure" name="procedure_id" class="form-control" required>
                            <option value="">Válasszon eljárást</option>
                            <?php
                            require 'functions/db-config.php';
                            global $pdo;
                            $stmt = $pdo->query("SELECT procedureID, procedureName FROM Procedures");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value=\"{$row['procedureID']}\">{$row['procedureName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="healthRating" class="col-sm-3 control-label">Fogak állapota (1-10):</label>
                    <div class="col-sm-9">
                        <input type="number" min="1" max="10" class="form-control" id="healthRating" name="healthRating"
                               placeholder="Fogak állapota" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>