<?php
include 'db-config.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"];
    $doctorID = isset($_POST["doctorID"]) ? $_POST["doctorID"] : null;
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : null;
    $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : null;
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_BCRYPT) : null;
    $phoneNumber = isset($_POST["phoneNumber"]) ? $_POST["phoneNumber"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $worktime = isset($_POST["worktime"]) ? $_POST["worktime"] : null;
    $specialisation = isset($_POST["specialisation"]) ? $_POST["specialisation"] : null;
    $forget = isset($_POST["forget"]) ? $_POST["forget"] : null;
    $remember = isset($_POST["remember"]) ? $_POST["remember"] : null;

    if ($operation == "insert" || $operation == "update") {
        // Check if email already exists
        $checkEmailSql = "SELECT doctorID FROM Doctor WHERE email='$email'";
        $result = $conn->query($checkEmailSql);

        if ($result->num_rows > 0) {
            $existingDoctorID = $result->fetch_assoc()['doctorID'];
        } else {
            $existingDoctorID = null;
        }
    }

    if ($operation == "insert") {
        if ($existingDoctorID === null) {
            $sql = "INSERT INTO Doctor (firstName, lastName, password, phoneNumber, email, worktime, specialisation, forget, remember)
                    VALUES ('$firstName', '$lastName', '$password', '$phoneNumber', '$email', '$worktime', '$specialisation', '$forget', '$remember')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Email already exists.";
        }
    } elseif ($operation == "update") {
        if (!empty($doctorID)) {
            if ($existingDoctorID === null || $existingDoctorID == $doctorID) {
                $sql = "UPDATE Doctor
                        SET firstName='$firstName', lastName='$lastName', password='$password', phoneNumber='$phoneNumber', email='$email', worktime='$worktime', specialisation='$specialisation'
                        WHERE doctorID=$doctorID";

                echo "Executing query: $sql<br>";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully.<br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: Email already exists.<br>";
            }
        } else {
            echo "Doctor ID is required for updating a record.<br>";
        }
    }
}

$conn->close();
header("Location: ../admin.php");
?>