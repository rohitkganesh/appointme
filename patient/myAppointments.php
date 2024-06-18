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
    <h3>Book an appointment:</h3>
    <div class="new-appointment">
        <?php
        $stmt = $conn->prepare("SELECT * FROM doctor");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $avatar = $row['Avatar'];
                echo "<div class='choose-doctor'>";
                if ($avatar) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar">';
                } else {
                    echo '<img src="../images/default-avatar.png" alt="Avatar">';
                }
                echo "<span>Name: {$row['dname']}</span>";
                echo "<span>Speciality: {$row['specialties']}</span>";
                echo "<button class='logout-btn'><a href='../Appointments/AppointmentForm.php?did={$row['did']}' target='_blank'>Book now</a></button>";
                echo "</div>";
            }
        } else {
            echo "<p>No doctors found.</p>";
        }
        ?>
    </div>

    <h3>Your upcoming appointments:</h3>
    <div class="appointments">
    <?php
        $stmt = $conn->prepare("
            SELECT a.*, d.dname, d.specialties 
            FROM appointments a 
            JOIN doctor d ON a.did = d.did 
            WHERE a.pid = ? AND a.Status = 'Scheduled'
        ");
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='appointment'>";
                echo "<div class='appointment-datetime'>";
                echo "<span>{$row['AppointmentDate']}</span>";
                echo "<span>{$row['AppointmentTime']}</span>";
                echo "</div>";
                echo "<div>Doctor Name: {$row['dname']}</div>";
                echo "<div>Speciality: {$row['specialties']}</div>";
                echo "<button class='logout-btn'><a href='DeleteAppointment.php?aid={$row['AppointmentID']}'>Delete</a></button>";
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
