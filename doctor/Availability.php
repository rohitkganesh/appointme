<?php
include("../backend/conn.php");
session_start();
if (isset($_SESSION['id'])) {
    $did = $_SESSION['id'];  
    $stmt = $conn->prepare("SELECT availability_start, availability_end FROM doctor WHERE did = ?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentAvailability = $result->fetch_assoc();

} else {
    echo "Unauthorized access.";
    exit();
}
?>
<style>
    .input-field {
        position: fixed;
        left: 20%;
        top: 15%;
    }
</style>
<link rel="stylesheet" href="../Styles/login-style.css">
<div class="login-container">
    <div class="input-field">
        <h2>Update Your Availability</h2>
        <form method="post" action="AvailabilityUpdate.php">
            <div class="login-input-container">
                <label for="availability_start">Start Time:</label>
                <input type="time" class="login-input" name="availability_start" value="<?php echo htmlspecialchars($currentAvailability['availability_start']); ?>" required>
            </div>
            <div class="login-input-container">
                <label for="availability_end">End Time:</label>
                <input type="time" class="login-input" name="availability_end" value="<?php echo htmlspecialchars($currentAvailability['availability_end']); ?>" required>
            </div>
            <div>
                <button class="logout-btn" type="button" onclick="prev()">Go back</button>
                <button type="submit" class="logout-btn">Update</button>
            </div>
        </form>
    </div>
</div>
