<?php
include("../backend/conn.php");

if (isset($_GET['mid'])) {
    $mid = $_GET['mid'];
    $stmt = $conn->prepare("SELECT medical_file FROM medical_reports WHERE mid = ?");
    $stmt->bind_param("i", $mid);
    $stmt->execute();
    $stmt->bind_result($medical_file);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    
    if ($medical_file) {
        header("Content-type: image/jpeg");
        echo $medical_file;
    } else {
        echo "No image found.";
    }
} else {
    echo "Invalid request.";
}
?>
