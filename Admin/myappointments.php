<?php
session_start();
include("../backend/conn.php");

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$currentDateTime = date('Y-m-d H:i:s');

// Prepare SQL to fetch all appointments
$stmt = $conn->prepare("
    SELECT a.*, d.dname,d.specialties, p.pname, p.pgender, p.pemail
    FROM appointments a
    JOIN doctor d ON a.did = d.did
    JOIN patient p ON a.pid = p.pid
    ORDER BY a.AppointmentDate ASC, a.AppointmentTime ASC
");
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <link rel="stylesheet" href="../Styles/appointment.css">
</head>
<body>
    <h3>All Appointments:</h3>
    <div class="appointments">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='appointment'>";
                echo "<div class='appointment-datetime'>";
                echo "<span>{$row['AppointmentDate']}</span>";
                echo "<span>{$row['AppointmentTime']}</span>";
                echo "</div>";
                echo "<div>Doctor Name: {$row['dname']}</div>";
                echo "<div>Specialties: {$row['specialties']}</div>";
                echo "<div>Patient Name: {$row['pname']}</div>";
                echo "<div>Email: {$row['pemail']}</div>";
                echo "<div>Gender: {$row['pgender']}</div>";
                echo "<div>Description: {$row['ReasonForVisit']}</div>";
                echo "<div>Status: {$row['Status']}</div>";

                if ($row['Status'] === 'Cancelled' || $row['Status'] === 'Expired'||$row['Status'] === 'Rejected') {
                    echo "<button class='logout-btn'><a href='../admin/DeleteAppointment.php?aid={$row['AppointmentID']}' onclick='return confirm(\"Are you sure you want to delete this appointment?\")'>Delete</a></button>";
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
