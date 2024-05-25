<?php
include('../backend/conn.php');

// Assuming these values come from a form submission or other source
$name='Admin';
$email = 'admin@gmail.com';
$password = 'admin';

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the SQL query to insert or update the admin record
$stmt = $conn->prepare('INSERT INTO admin (name,email, password) VALUES (?,?, ?)');
$stmt->bind_param('sss',$name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo 'Admin record inserted successfully.';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>
