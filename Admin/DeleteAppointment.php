<?php
session_start();
include("../backend/conn.php");

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['aid'])) {
    $appointmentID = intval($_GET['aid']);

    // Prepare SQL to delete the appointment
    $stmt = $conn->prepare("DELETE FROM appointments WHERE AppointmentID = ?");
    $stmt->bind_param('i', $appointmentID);

    if ($stmt->execute()) {
        // If deletion is successful, redirect to the appointments page
        echo "<script>alert('appointment deleted successfully!')
        window.location.href = '../admin/admindash.php'
        </script>";
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
