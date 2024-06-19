<?php
session_start();
include("../backend/conn.php");

// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}


// Get the patient ID from the session
$pid = $_SESSION['id'];

// Function to delete expired appointments
function deleteExpiredAppointments($conn, $currentDateTime)
{
    $stmt = $conn->prepare("
        DELETE FROM appointments 
        WHERE AppointmentDate < ? 
        OR (AppointmentDate = ? AND AppointmentTime < ?)
    ");
    $stmt->bind_param('sss', $currentDate, $currentDate, $currentTime);
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    $stmt->execute();
    $stmt->close();
}

// Delete appointments that have passed
deleteExpiredAppointments($conn, date('Y-m-d H:i:s'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="../Styles/appointment.css">
</head>
<body>
<div>
    
    <h3 >Book a appointment:</h3>
    <div class= "new-appointment">
    <?php
                $stmt = $conn->prepare("SELECT * FROM doctor");
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $avatar=$row['Avatar'];
                        echo "<div class='choose-doctor'>";
                        if($avatar){
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar">';
                        }
                        else{
                            echo '<img src="../images/default-avatar.png" alt="Avatar" ';
                        }

                        echo "<span>Name:{$row['dname']}</span>";
                        echo "<span>Speciality:{$row ['specialties']}</span>";
                        echo "<button class='logout-btn'><a href='#'>Book now</a></button> ";
                        echo "</div>";
                    }
                
                } else {
                    echo "<p>No doctors found.</p>";
                }
                ?>
       </div>
    <h3 >Your upcoming appointments:</h3>
    <div class="appointments">
    <?php
$currentDateTime = date('Y-m-d H:i:s');

$stmt = $conn->prepare("
    SELECT a.*, d.dname, d.specialties 
    FROM appointments a 
    JOIN doctor d ON a.did = d.did 
    WHERE a.pid = ? 
    ORDER BY a.AppointmentDate ASC, a.AppointmentTime ASC
");
$stmt->bind_param('i', $pid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointmentDateTime = $row['AppointmentDate'] . ' ' . $row['AppointmentTime'];
        
        echo "<div class='appointment'>";
        echo "<div class='appointment-datetime'>";
        echo "<span>{$row['AppointmentDate']}</span>";
        echo "<span>{$row['AppointmentTime']}</span>";
        echo "</div>";
        echo "<div>Doctor Name: {$row['dname']}</div>";
        echo "<div>Specialty: {$row['specialties']}</div>";
        echo "<div>Status: {$row['Status']}</div>";

        // Show cancel button only if status is 'Pending' or 'Scheduled'
        if ($row['Status'] === 'Pending' || $row['Status'] === 'Scheduled') {
            echo "<button class='logout-btn'><a href='../Appointments/CancelAppointment.php?aid={$row['AppointmentID']}' onclick='return confirm(\"Are you sure you want to cancel this appointment?\")'>Cancel</a></button>";
        }

        echo "</div>";
    }
} else {
    echo "<p>No appointments scheduled.</p>";
}
?>
    </div>
</div>
</body>
</html>
