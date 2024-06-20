<?php
include 'db-config.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"];
    $doctorID = isset($_POST["doctorID"]) ? $_POST["doctorID"] : null;
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $worktime = $_POST["worktime"];
    $specialisation = $_POST["specialisation"];
    $forget = $_POST["forget"];
    $remember = $_POST["remember"];

    // Check if email already exists
    $checkEmailSql = "SELECT doctorID FROM Doctor WHERE email='$email'";
    $result = $conn->query($checkEmailSql);

    if ($result->num_rows > 0) {
        $existingDoctorID = $result->fetch_assoc()['doctorID'];
    } else {
        $existingDoctorID = null;
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
                        SET firstName='$firstName', lastName='$lastName', password='$password', phoneNumber='$phoneNumber', email='$email', worktime='$worktime', specialisation='$specialisation', forget='$forget', remember='$remember'
                        WHERE doctorID=$doctorID";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: Email already exists.";
            }
        } else {
            echo "Doctor ID is required for updating a record.";
        }
    }
}



if (isset($_POST['delete_doctor'])) {
    $id = $_POST['doctor_id_delete'];
    $sql = "DELETE FROM Doctors WHERE id=$id";
    $conn->query($sql);
}

$conn->close();
header("Location: ../admin.php");

