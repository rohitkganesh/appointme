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
                        $avatar = $row['Avatar'];
                        $start =new DateTime($row['Availability_start']);
                        $end =new DateTime($row['Availability_End']);
                        $availability= $start->format('H:i') . '-' . $end->format('H:i');
                        echo "<div class='choose-doctor'>";
                        if ($avatar) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar">';
                        } else {
                            echo '<img src="../images/default-avatar.png" alt="Avatar">';
                        }
                        echo "<span>Name: {$row['dname']}</span>";
                        echo "<span>Availability: {$availability}</span>";
                        echo "<span>Specialty: {$row['specialties']}</span>";
                        echo "<button class='logout-btn'><a href='../Appointments/AppointmentForm.php?did={$row['did']}' target='_blank'>Book now</a></button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No doctors found.</p>";
                }
                ?>
            </div>
   