<?php
session_start();
include("../backend/conn.php");

// Check if action and appointment ID (aid) are provided via GET method
if(isset($_GET['action']) && isset($_GET['aid'])){
    // Sanitize inputs
    $action = $_GET['action'];
    $aid = intval($_GET['aid']); // Convert to integer for safety

    // Validate action (only 'approve', 'reject', or 'cancel' are allowed)
    if(in_array($action, ['approve', 'reject', 'cancel'])){
        // Update appointment status based on action
        switch($action){
            case 'approve':
                $newStatus = 'Scheduled';
                break;
            case 'reject':
                $newStatus = 'Rejected';
                break;
            case 'cancel':
                $newStatus = 'Cancelled';
                break;
            default:
                // Handle invalid action (though this should not happen with current check)
                die("Invalid action specified.");
        }

        // Prepare and execute the update statement
        $stmt = $conn->prepare("UPDATE appointments SET Status = ? WHERE AppointmentID = ?");
        $stmt->bind_param('si', $newStatus, $aid);
        if($stmt->execute()){
            // Successful update
            // Set a cookie named 'newStatus' with the updated status value
            setcookie('newStatus', $newStatus, time() + 24*3600, '/'); // Cookie expires in 24 hours
            $stmt->close(); // Close statement
            echo "<script>alert('Appointment status updated successfully.');</script>";
            header("Location: ../doctor/doctordash.php");
            exit(); // Ensure no further output
        } else {
            // Failed to update
            echo "<script>alert('Failed to update appointment status.');</script>";
            $stmt->close(); // Close statement on failure as well
        }
    } else {
        // Invalid action provided
        echo "<script>alert('Invalid action specified.');</script>";
    }
} else {
    // Missing required parameters
    echo "<script>alert('Missing parameters.');</script>";
}
?>
