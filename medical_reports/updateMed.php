<?php
session_start();
include("../backend/conn.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the form is submitted
if (isset($_POST['update'])) {
    $mid = $_POST['mid'];
    $report_name = $_POST['report_name'];
    $comments = $_POST['comments'];

    // Handle file upload if a new file is provided
    if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] == 0) {
        $fileTmpPath = $_FILES['report_file']['tmp_name'];
        $fileName = $_FILES['report_file']['name'];
        $fileSize = $_FILES['report_file']['size'];
        $fileType = $_FILES['report_file']['type'];

        // Read the file content into a variable
        $fp = fopen($fileTmpPath, 'rb');
        $report_file = fread($fp, filesize($fileTmpPath));
        fclose($fp);

        $sql = "UPDATE medical_reports SET medical_name = ?, medical_file = ?, comments = ? WHERE mid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $report_name, $report_file, $comments, $mid);
    } else {
        // If no new file is uploaded, update only the text fields
        $sql = "UPDATE medical_reports SET medical_name = ?, comments = ? WHERE mid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $report_name, $comments, $mid);
    }

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Medical report updated successfully.";
    } else {
        $_SESSION['msg'] = "Error: Could not update the report.";
    }

    if (isset($_SESSION['msg'])) {
        echo "<script>alert('{$_SESSION['msg']}'); window.location.href = '../patient/patientdash.php';</script>";
        unset($_SESSION['msg']); // Clear the message after displaying it
    }
    exit();
}

// Fetch the report details for the form
$mid = $_GET['id'];
$query = "SELECT * FROM medical_reports WHERE mid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $mid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Report not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical Report</title>
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <link rel="stylesheet" href="../Styles/medical_upload.css">
</head>
<body>
    <div class="report-container">
        <h2>Update Medical Report</h2>
        <form action="updateMed.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="mid" value="<?php echo $mid; ?>">
            <div class="form-group">
                <label for="report_name">Report Name:</label>
                <input type="text" id="report_name" name="report_name" value="<?php echo $row['medical_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments"><?php echo $row['comments']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="report_file">Report File:</label>
                <input type="file" id="report_file" name="report_file" >
            </div>
            <div class="form-group">
                <button class="logout-btn" type="button" onclick="window.history.back()">Go Back</button> &nbsp; &nbsp;
                <input class="logout-btn" type="submit" name="update" value="Update">
            </div>
        </form>
    </div>
</body>
</html>
