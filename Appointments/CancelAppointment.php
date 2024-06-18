<?php
include('../backend/conn.php');

if (isset($_GET['aid'])) {
    $aid = $_GET['aid'];
    $status="Cancelled";
    // Prepare and execute DELETE query
    $sql = $conn->prepare('UPDATE appointments SET Status = ? WHERE AppointmentID = ?');
    $sql->bind_param('si',$status,$aid);
    if ($sql->execute()) {
        // Alert message
        echo "<script>alert('Appointment Canceled successfully.');</script>";
        
        // Redirect after the alert
        echo "<script>window.location.replace('../patient/patientdash.php');</script>";
        exit(); // Ensure script execution stops after redirect
    } else {
        // Error handling if delete query fails
        echo "<script>alert('Failed to delete appointment.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }
} 
?>
