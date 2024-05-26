<?php
session_start();
include("../backend/conn.php");

if(isset($_POST['upload'])) {
    $email = $_SESSION['email'];
    $report_name = $_POST['report_name'];
    $comments = $_POST['comments'];

    // Handle file upload
    if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] == 0) {
        $fileTmpPath = $_FILES['report_file']['tmp_name'];
        $fileName = $_FILES['report_file']['name'];
        $fileSize = $_FILES['report_file']['size'];
        $fileType = $_FILES['report_file']['type'];

        // Read the file content into a variable
        $fp = fopen($fileTmpPath, 'rb');
        $report_file = fread($fp, filesize($fileTmpPath));
        fclose($fp);

        // Get the patient's ID using their email
        $stmt = $conn->prepare("SELECT pid FROM patient WHERE pemail = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pid = $row['pid'];

            // Insert the data into the database
            $sql = "INSERT INTO medical_reports (pid, medical_name, medical_file, comments) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isss', $pid, $report_name, $report_file, $comments);

            if ($stmt->execute()) {
                $_SESSION['msg'] = "Medical report uploaded successfully.";
            } else {
                $_SESSION['msg'] = "Error: Could not upload the report.";
            }
        } else {
            $_SESSION['msg'] = "Error: Patient not found.";
        }
    } else {
        $_SESSION['msg'] = "Error: No file uploaded or there was an upload error.";
    }
} else {
    $_SESSION['msg'] = "Invalid request.";
}
if(isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}'); window.close();</script>";
    unset($_SESSION['msg']); // Clear the message after displaying it
}
else{
   exit();

}
?>
