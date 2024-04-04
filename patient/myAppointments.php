<!-- myAppointments.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <style>
        .appointments{
            margin:0;
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:space-around;
            flex-wrap: wrap;
        }
        .appointment{
            border:2px solid gray;
            border-radius:8px;
            margin-bottom:20px;
            padding:20px;
            height:120px;
            width:180px;
        }
    </style>
</head>
<body>
    <?php
    echo "<h2>My Appointments</h2>";
    echo "<p class='p1'>Your upcoming appointments:</p>";
    // Add content, such as images, lists, etc.
    echo "<div class='appointments'>
    <div class='appointment'>Appointment1</div>
    <div class='appointment'>Appointment2</div>
    <div class='appointment'>Appointment3</div>
    <div class='appointment'>Appointment4</div>
    <div class='appointment'>Appointment4</div>
    <div class='appointment'>Appointment4</div>
    </div";
    // Add more content as needed
    ?>
</body>
</html>
