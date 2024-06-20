<?php
session_start(); // Start the PHP session for session variables

// Assuming $_SESSION['firstName'] and $_SESSION['lastName'] are set after user login/authentication
// Example:
// $_SESSION['firstName'] = 'John';
// $_SESSION['lastName'] = 'Doe';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Páciens egészségi állapot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        canvas {
            border: 1px solid #ccc;
            margin-top: 20px;
            width: 100%;
            height: 600px;
        }
    </style>
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
            <li><a href="add_patient_records.php">Karton írása</a></li>
            <li><a href="view_patient_records.php">Kartonok megtekintése</a></li>
            <li class="active"><a href="view_patient_health.php">Fogak állapota</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="profile.php">Profil</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="functions/logOutFunction.php">Kijelentkezés</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>Páciens egészségi állapot</h2>
    <form id="patientHealthForm" method="POST" action="">
        <div class="form-group">
            <label for="patientID">Páciens ID:</label>
            <input type="text" class="form-control" id="patientID" name="patientID" required>
        </div>
        <button type="submit" class="btn btn-primary">Lekérés</button>
    </form>
    <canvas id="healthChart" width="800" height="600"></canvas>
</div>

<script>
    $(document).ready(function() {
        $('#patientHealthForm').submit(function(e) {
            e.preventDefault();
            var patientID = $('#patientID').val();

            $.ajax({
                url: 'functions/get_patient_health.php',
                type: 'POST',
                data: { patientID: patientID },
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            drawChart(data.labels, data.scores);
                        } else {
                            alert(data.message);
                        }
                    } catch (error) {
                        console.error('JSON Parse error:', error);
                        alert('A feldolgozás közben hiba történt.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Hiba történt a kérés feldolgozása közben. Kérjük, próbálja újra.');
                }
            });
        });

        function drawChart(labels, scores) {
            var canvas = document.getElementById('healthChart');
            var ctx = canvas.getContext('2d');

            // Clear the canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            var width = (canvas.width - 50) / labels.length;
            var max = 10; // Egészség 1-10es skálán
            var paddingTop = 20;

            // Draw y-axis labels
            ctx.font = "12px Arial";
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            for (var i = 1; i <= 10; i++) {
                var y = canvas.height - 50 - (i / 10) * (canvas.height - 50 - paddingTop);
                ctx.fillText(i, 45, y);
                ctx.strokeStyle = "#e0e0e0";
                ctx.beginPath();
                ctx.moveTo(50, y);
                ctx.lineTo(canvas.width, y);
                ctx.stroke();
            }

            ctx.font = "12px Arial"; // Adjust font size
            for (var i = 0; i < labels.length; i++) {
                var height = (scores[i] / max) * (canvas.height - 50 - paddingTop);
                ctx.fillStyle = 'rgba(75, 192, 192, 0.2)';
                ctx.fillRect(i * width + 50, canvas.height - height - 50, width - 1, height);
                ctx.fillStyle = 'rgba(75, 192, 192, 1)';
                ctx.textAlign = 'center';
                ctx.fillText(scores[i], i * width + 50 + width / 2, canvas.height - height - 55);
                ctx.fillText(labels[i], i * width + 50 + width / 2, canvas.height - 20);
            }
        }
    });
</script>

</body>
</html>
