<?php
include("../backend/conn.php");
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="../Styles/appointment.css">
    <script>
    </script>
</head>
<body>
<div>
    
    <h3>Your upcoming appointments:</h3>
    <div class="appointments">
        <?php
        $currentDateTime = date('Y-m-d H:i:s');

        // Prepare SQL to fetch appointments for the doctor
        $stmt = $conn->prepare("
            SELECT a.*, d.dname, d.specialties, p.*
            FROM appointments a
            JOIN doctor d ON a.did = d.did
            JOIN patient p ON a.pid = p.pid
            WHERE a.did = ?
            ORDER BY a.AppointmentDate ASC, a.AppointmentTime ASC

        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $appointmentDateTime = $row['AppointmentDate'] . ' ' . $row['AppointmentTime'];

                // Display upcoming appointments
                echo "<div class='appointment'>";
                echo "<div class='appointment-datetime'>";
                echo "<span>{$row['AppointmentDate']}</span>";
                echo "<span>{$row['AppointmentTime']}</span>";
                echo "</div>";
                echo "<div>Patient Name: {$row['pname']}</div>";
                echo "<div>Gender: {$row['pgender']}</div>";
                echo "<div>Description: {$row['ReasonForVisit']}</div>";
                echo "<div>Status: {$row['Status']}</div>";

                // Show buttons for actions based on appointment status
                if ($row['Status'] === 'Pending') {
                    // Approve button for pending appointments
                    echo "<div><button class='logout-btn'><a href='../Appointments/ChangeStatus.php?action=approve&aid={$row['AppointmentID']}' onclick='return confirm(\"Are you sure?\")'>Approve</a></button>&nbsp;&nbsp;
                    <button class='logout-btn'><a href='../Appointments/ChangeStatus.php?action=reject&aid={$row['AppointmentID']}'onclick='return confirm(\"Are you sure?\")'>Reject</a></button></div>";
                } elseif ($row['Status'] === 'Scheduled') {
                    // Cancel button for scheduled appointments
                    echo "<button class='logout-btn'><a href='../Appointments/ChangeStatus.php?action=cancel&aid={$row['AppointmentID']}' onclick='return confirm(\"Are you sure?\")'>Cancel</a></button>";
                    
                    // Display disabled Approve button for already scheduled appointments
                }

                echo "</div>";
            }
        } else {
            echo "<p>No appointments scheduled.</p>";
        }
        ?>
    </div>
 
</body>
</html>
