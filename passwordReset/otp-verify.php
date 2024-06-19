<?php
session_start();
include ('../backend/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification || Appoint Me</title>
    <link rel="stylesheet" href="../Styles/login-style.css">
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <script src="https://kit.fontawesome.com/28cf9218f4.js" crossorigin="anonymous"></script> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <?php
    include ('otp-works.php');
    if (isset($_POST['send-otp'])) {
        $pid = $_GET['id'];

        $stmt = $conn->prepare('SELECT pid,otp,otp_expiry FROM patient WHERE pid = ?');
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pid = $row['pid'];
            otpverify($otp,$pid);
        } else {
            $forgot_error = "OTP expired or invalid.";
        }
    }
    ?>
    <div class="login-container">
        <div class="input-field">
            <h2>Verify OTP</h2>
            <form id="forgotpassword" method="post">
                <div class="login-input-container">
                    <i class="fa-solid fa-lock"></i>
                    <input type="text" class="login-input" name="otp" placeholder="Enter 6 digit OTP here">
                </div>
                <div id="otp-error" class="login-error error">

                </div>
                <input id="otp-btn" type="submit" name="verify-otp" value="SUBMIT">
            </form>
        </div>
    </div>
    <?php require_once ("../components/footer.php") ?>
</body>

</html>