<?php
include('../backend/conn.php');
$med_id = $_GET['id'];
$sql = $conn -> prepare('DELETE FROM medical_reports WHERE mid=?');
$sql->bind_param('i',$med_id);
if($sql->execute()){
    echo "<script>alert('Doctor deleted succesfully.')</script>";
    header("Location:../patient/patientdash.php");
}
