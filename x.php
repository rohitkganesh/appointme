<?php
include('backend/conn.php');
$hash = password_hash("hello123",PASSWORD_DEFAULT);
$sql = "INSERT INTO admin (name,email,password) values ('rohit ganesh','rohit@x.com','$hash');";
if($conn->query($sql)){
    echo "added admin rohit";
}