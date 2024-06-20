<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Páciens egészségi állapot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="source/images/favicon_io/favicon-16x16.png">
    <style>
        canvas {
            border: 1px solid #ccc;
            margin-top: 20px;
            width: 100%;
            height: 400px;
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
            <li><a href="view_appointments.php">Foglalásaim</a></li>
            <li><a href="admin.php">Admin oldal</a></li>
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
            var ctx = document.getElementById('healthChart').getContext('2d');
            labels.sort(); // Sort labels (dates) in ascending order
            var sortedScores = [];
            labels.forEach((label, index) => {
                sortedScores.push(scores[index]);
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Egészségi állapot',
                        data: sortedScores,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 10,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'x',
                            },
                            zoom: {
                                enabled: true,
                                mode: 'x',
                                speed: 0.1
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.0.0/dist/chartjs-plugin-zoom.min.js"></script>
</body>
</html>