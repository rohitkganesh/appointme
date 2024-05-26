<?php 
session_start();
include("../backend/conn.php");
if(isset($_SESSION['email']) && isset($_SESSION['name'])){
    
} else {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Medical Report</title>
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <link rel="stylesheet" href="../Styles/medical_upload.css">

    </style>
</head>
<body>
    <div class="report-container">
        <h2>Upload Medical Report</h2>
        <form action="../medical_reports/medical_report.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="report_name">Report Name:</label>
                <input type="text" id="report_name" name="report_name" required>
            </div>
            <div class="form-group">
                <label for="report_file">Report File:</label>
                <input type="file" id="report_file" name="report_file" accept=".pdf,.doc,.docx,.jpg,.png" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments"></textarea>
            </div>
            <div class="form-group">
                <button class="logout-btn" type="button" onclick="prev()">Go Back</button> &nbsp; &nbsp;
                <input class="logout-btn" type="submit" name="upload" value="Upload">
            </div>
        </form>
    </div>
    <script>
        function prev() {
            window.close();
        }
    </script>
</body>
</html>
