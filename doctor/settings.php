<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}
?>
<link rel="stylesheet" href="../Styles/style-prev.css">
<div>
    <h2>Settings</h2>
    <div>
        <button class="logout-btn" onclick="UpdateProfile()">Edit Profile</button>
    </div>
    <div>
        <button class="logout-btn" onclick="ChangePassword()">Change Password</button>
    </div>
    <div>
        <button class="logout-btn" onclick="UpdateAvailability()">Update Availability</button>
    </div>
</div>