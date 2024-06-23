<?php
include("../backend/conn.php");
?>
<link rel="stylesheet" href="../Styles/appointment.css">
<h3>Book an appointment:</h3>
<div class="new-appointment">
    <?php
    $stmt = $conn->prepare("SELECT * FROM doctor");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // appointment booked or not 
            $did = $row['did'];
            $appointment = $conn->prepare("SELECT * FROM appointments WHERE pid = ? AND did = ? AND Status IN('Scheduled', 'Pending')");
            $appointment->bind_param("ii", $pid, $did);
            $appointment->execute();
            $appointment_result = $appointment->get_result();
            $has_appointment = $appointment_result->num_rows > 0;
            $appointment_status = $has_appointment ? $appointment_result->fetch_assoc()['Status'] : '';
            //AppointmentSlotCheck
            // $today = date('Y-m-d');
            // $tomorrow = date('Y-m-d', strtotime('+1 day'));
            // $dayAfterTomorrow = date('Y-m-d', strtotime('+2 days'));
            
            // // Prepare the SQL query
            // $slotCheck = $conn->prepare("SELECT d.*, COUNT(a.AppointmentID) AS booked_count
            //                         FROM doctor d
            //                         LEFT JOIN appointments a ON d.did = a.AppointmentID
            //                             AND a.Status IN ('Scheduled', 'Pending')
            //                             AND (DATE(a.AppointmentDate) = ? OR DATE(a.AppointmentDate) = ?)
            //                         GROUP BY d.did");
            
            // // Bind parameters and execute the query for tomorrow and the day after tomorrow
            // $slotCheck->bind_param("ss", $tomorrow, $dayAfterTomorrow);
            // $slotCheck->execute();
            // $slotResult = $slotCheck->get_result();
            // while($slot=$slotResult->fetch_assoc()){
            //     $bookCount=$slot['booked_count'];
            //     $appointment_limit=
            //     $remaining_slot=
            // }
            // Doctor
            $avatar = $row['Avatar'];
            $start = new DateTime($row['Availability_start']);
            $end = new DateTime($row['Availability_End']);
            $availability = $start->format('H:i') . '-' . $end->format('H:i');
            echo "<div class='choose-doctor'>";
            if ($avatar) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar">';
            } else {
                echo '<img src="../images/default-avatar.png" alt="Avatar">';
            }
            echo "<span>Name: {$row['dname']}</span>";
            echo "<span>Availability: {$availability}</span>";
            echo "<span>Specialty: {$row['specialties']}</span>";
            if ($has_appointment) {
                echo "<button class='logout-btn' onclick='doubleBookingCheck(\"{$appointment_status}\")'>Book now</button>";
            } else {
                echo "<button class='logout-btn'><a href='../Appointments/AppointmentForm.php?did={$row['did']}' target='_blank'>Book now</a></button>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No doctors found.</p>";
    }
    ?>
</div>
<script>
    function doubleBookingCheck(status) {
        if (status === 'Scheduled') {
            alert("Your appointment is already scheduled.");
        } else if (status === 'Pending') {
            alert("Your appointment is pending.");
        }
    }
</script>
