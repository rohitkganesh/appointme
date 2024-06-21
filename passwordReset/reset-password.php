<?php
session_start();
include ('../backend/conn.php');
if (!$_SESSION['verified']) {
    header('Location:../login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password || Appoint Me</title>
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
    if (isset($_POST['reset'])) {
        if (empty($_POST['password'])) {
            $forgot_error = 'Password cannot be empty';
        } else {
            $password = trim(htmlspecialchars($_POST['password']));
            if (strlen($password) < 6) {
                $forgot_error = 'Password should be longer than 6 characters';
            }
        }

        if (empty($forgot_error)) {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $pid = $_SESSION['verified'];
            $sql = $conn->prepare('UPDATE patient SET ppassword=? WHERE pid=?');
            $sql->bind_param('si', $hashedPass, $pid);
            if ($sql->execute()) {
                $forgot_error = '<span style="color:green;margin-left: -35px;">Password Changed</span>';
                unset($_SESSION['verified']);
                unset($_SESSION['otp']);
                header("Refresh:2, url=../login.php");
            } else {
                $forgot_error = 'Password reset failed.';
            }
        }
    }
    ?>
    <div class="login-container" id="fetch-container">
        <div class="input-field">
            <h3 id="forgot-h3">FORGOT PASSWORD</h3>
            <form action="#" method="post">
                <div class="login-input-container">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" class="login-input" name="password" placeholder="New Password" value="<?php if (isset($password))
                        echo $password ?>">
                    </div>
                    <div class="error login-error">
                    <?php if (isset($forgot_error))
                        echo $forgot_error ?>
                    </div>
                    <input id="login-btn" type="submit" name="reset" value="SUBMIT">
                    <p class="or">OR</p>
                    <p class="signup-link login-link">Don't have an account? <a href="../signup.php">Sign Up</a></p>
                    <p class="signup-link login-link"><a href="../login.php">Log In</a></p>

                </form>
            </div>
            <div class="intro">
                <img src="../images/logo.png" width="400" alt="my-logo">
                <p class="headings">Welcome to our online appointment booking site.</p>
                <p class="headings">Here you can book your appointment with your preferred doctor just in few clicks.</p>
            </div>
        </div>
    <?php require_once ("../components/footer.php") ?>
</body>

</html>