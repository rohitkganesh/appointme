<?php
session_start();
include("../backend/conn.php");

if (isset($_SESSION['email']) && isset($_SESSION['name'])) {
    $pid = $_SESSION['id'];

    if (isset($_GET['did']) && is_numeric($_GET['did'])) {
        $did = $_GET['did'];

        // Prepare the statements
        $query1 = "SELECT * FROM patient WHERE pid = ?";
        $query2 = "SELECT * FROM doctor WHERE did = ?";

        if ($stmt1 = $conn->prepare($query1)) {
            $stmt1->bind_param('i', $pid);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            if ($result1->num_rows > 0) {
                $patient = $result1->fetch_assoc();
            } else {
                echo "Patient not found.";
                exit();
            }
            $stmt1->close();
        } else {
            echo "Failed to prepare the patient SQL statement.";
            exit();
        }

        if ($stmt2 = $conn->prepare($query2)) {
            $stmt2->bind_param('i', $did);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $doctor = $result2->fetch_assoc();
            } else {
                echo "Doctor not found.";
                exit();
            }
            $stmt2->close();
        } else {
            echo "Failed to prepare the doctor SQL statement.";
            exit();
        }
    } else {
        echo "Invalid doctor ID.";
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="report-container">
        <h2>Book your appointment</h2>
        <form action="../Appointments/newAppointment.php" method="post">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($patient['pname']); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="doctor_name">Doctor Name:</label>
                <input type="text" id="doctor_name" name="doctor_name" value="<?php echo htmlspecialchars($doctor['dname']); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" required>
            </div>
            <div class="form-group">
                <label for="appointment_time">Appointment Time:</label>
                <input type="time" id="appointment_time" name="appointment_time" required>
            </div>
            <div class="form-group">
                <label for="reason_for_visit">Reason for Visit:</label>
                <textarea id="reason_for_visit" name="reason_for_visit" required></textarea>
            </div>
            <div class="form-group">
                <button class="logout-btn" type="button" onclick="prev()">Go Back</button> &nbsp; &nbsp;
                <button class="logout-btn" type="submit" name="upload">Book Appointment</button>
            </div>
            <input type="hidden" name="pid" value="<?php echo htmlspecialchars($pid); ?>">
            <input type="hidden" name="did" value="<?php echo htmlspecialchars($did); ?>">
        </form>
    </div>
    <script>
        function prev() {
            window.close();
        }
    </script>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .report-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    h2 {
        margin-bottom: 20px;
        font-size: 24px;
        text-align: center;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input, textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .logout-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 4px;
    }
    .logout-btn:hover {
        background-color: #0056b3;
    }
</style>
