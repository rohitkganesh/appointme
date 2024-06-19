<?php
session_start();
include ('../backend/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password || Appoint Me</title>
    <link rel="stylesheet" href="../Styles/login-style.css">
    <link rel="stylesheet" href="../Styles/login-style.css">
    <link rel="stylesheet" href="../Styles/footer-style.css">
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
    include('otp-works.php');
    if (isset($_POST['send-otp'])) {
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        $stmt = $conn->prepare('SELECT pid,pname FROM patient WHERE pemail = ? AND pmobile = ?');
        $stmt->bind_param('ss', $email, $mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pid = $row['pid'];
            $forgot_error = sendmail($email,$row['pname']);
            header('Refresh:2, url=otp-verify.php?id='.$pid);
        } else {
            $forgot_error = "User/Patient doesn't exists.";
        }
    }
    ?>
    <div class="login-container" id="fetch-container">
        <div class="input-field">
            <h3 id="forgot-h3">FORGOT PASSWORD</h3>
            <form action="#" method="post">
                <div class="login-input-container">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" class="login-input" name="email" placeholder="Email Address" value="<?php if (isset($email))
                        echo $email ?>">
                    </div>
                    <div class="login-input-container">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" class="login-input" name="mobile" placeholder="Mobile Number" value="<?php if (isset($mobile))
                        echo $mobile ?>">
                    </div>
                    <div class="error login-error">
                    <?php if (isset($forgot_error))
                        echo $forgot_error ?>
                    </div>
                    <input id="login-btn" type="submit" name="send-otp" value="SEND OTP">
                    <p class="or">OR</p>
                    <p class="signup-link login-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
                    <p class="signup-link login-link"><a href="login.php">Log In</a></p>

                </form>
            </div>
        </div>
    <?php require_once ("../components/footer.php") ?>
</body>

</html>