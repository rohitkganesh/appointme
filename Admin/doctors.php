<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <style>
    
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f8f8;
}

tr {
    background-color: #f9f9f9;
}
.delete{
background-color: red;
color: white;
}
.delete:hover{
    background-color: 	#8B0000;
}
    </style>
</head>
<body>
    <div class="doctors">
        <?php
                include("../backend/conn.php");
                $stmt = $conn->prepare("SELECT * FROM doctor");
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    echo "<h3>Manage Doctor</h3>";
                    echo "<table>";
                    echo "<tr><th>Id</th><th>Name</th><th>Email</th><th>Availability</th><th>Specialties</th><th>Action</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        $availability= $row['Availability_start']."-".$row['Availability_End'];
                        echo "<tr>
                        <td>{$row['did']}</td>
                        <td>{$row['dname']}</td>
                        <td>{$row['demail']}</td>
                        <td>$availability</td>
                        <td>{$row['specialties']}</td>
                        <td>
                            <a href='updateDoc.php?id={$row['did']}' class='logout-btn'>Update</a>
                            <a href='deleteDoctor.php?id={$row['did']}' class='logout-btn delete' onclick='return confirm(\"Are you sure you want to delete this doctor?\")'>Delete</a>
                        </td>
                        </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No doctors found.</p>";
                }
                ?>
            </div>
            <div class="add-user">
                <br>
                <a class="logout-btn" href="addDoc.php">Add new Doctor</a>
            </div>
        </body>
        </html>
