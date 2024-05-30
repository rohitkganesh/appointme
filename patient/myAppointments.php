<?php
include("../backend/conn.php")
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
        
        <div class="appointment">Appointment1</div>
        <div class="appointment">Appointment2</div>
        <div class="appointment">Appointment3</div>
        <div class="appointment">Appointment4</div>
        <div class="appointment">Appointment4</div>
        
    </div>
</div>
 
</body>
</html>
