<?php
include('../backend/conn.php');
$doc_id = $_GET['id'];
$sql = $conn -> prepare('DELETE FROM doctor WHERE did=?');
$sql->bind_param('i',$doc_id);
if($sql->execute()){
    echo "<script>alert('Doctor deleted succesfully.')</script>";
    header("Location:admindash.php");
}
?>
