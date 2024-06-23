<?php
session_start();
?>
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
        
    </style>
</head>
<body>
    <h3>Medicals reports</h3>
    <p>Keep your reports safe here.</p>
    <div class="doctors">
        <?php
            include("../backend/conn.php");
            $email=$_SESSION['email'];
            $query = "SELECT * FROM `medical_reports` 
                      WHERE pid = (SELECT pid FROM patient WHERE pemail =?) 
                      ORDER BY updated_at DESC;";
                      
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Name</th><th>File</th><th>Details</th><th>Modified date</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>{$row['medical_name']}</td>
                    <td><a href='#' onclick='viewImage({$row['mid']})' class='logout-btn'>View Image</a></td>
                    <td>{$row['comments']}</td>
                    <td>{$row['updated_at']}</td>
                    <td>
                        <a href='../medical_reports/updateMed.php?id={$row['mid']}' class='logout-btn'>Update</a>
                        <a href='../medical_reports/deleteMed.php?id={$row['mid']}' class='logout-btn delete' onclick='return confirm(\"Are you sure you want to delete this medical report?\")'>Delete</a>
                    </td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No Reports found.</p>";
            }
        ?>
    </div>
    <div class="add-user">
        <br>
        <a class="logout-btn" href="#" onclick='medicalUpload()'>Upload Medical Reports</a>
    </div>

</body>
</html>
