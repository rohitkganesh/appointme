<?php
session_start();
include("../backend/conn.php");

if (isset($_SESSION['email']) && isset($_SESSION['name'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pid = $_POST['pid'];
        $did = $_POST['did'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $reason_for_visit = $_POST['reason_for_visit'];

        // Insert the new appointment into the database
        $query = "INSERT INTO appointments (pid, did, AppointmentDate, AppointmentTime, ReasonForVisit, Status) VALUES (?, ?, ?, ?, ?, ?)";
        $status = 'Pending'; // Default status

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('iissss', $pid, $did, $appointment_date, $appointment_time, $reason_for_visit, $status);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Appointment booked successfully.');
                    window.close();
                </script>";
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}

$conn->close();
?>
