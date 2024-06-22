<?php
session_start();
include("../backend/conn.php");
if (isset($_SESSION['id'])) {
    $did=$_SESSION['id'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $availability_start = $_POST['availability_start'];
        $availability_end = $_POST['availability_end'];
        
        $stmt = $conn->prepare("UPDATE doctor SET availability_start = ?, Availability_End = ? WHERE did = ?");
        $stmt->bind_param('ssi', $availability_start, $availability_end, $did);  // Corrected bind_param types
        
        if ($stmt->execute()) {
            echo "<script>alert('Availability updated successfully');
             window.location.href = '../doctor/doctordash.php';
            </script>";
            
            exit();
        } else {
            echo "<script>alert('Failed to update availability');</script>";
        }
    }
}else{
    echo "Unauthorized accesss";
}
?>
