<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In || Appoint Me</title>
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="Styles/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <script src="https://kit.fontawesome.com/28cf9218f4.js" crossorigin="anonymous"></script> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>
    <?php
    // include('backend/login-form-validate.php');  // Include validation script if needed
    include ('backend/conn.php');  // Include the database connection script
    
    // Initialize error messages
    $login_error = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the SQL statement with placeholders
        $stmt = $conn->prepare("SELECT 'doctor' AS usertype, dname AS name, demail AS email, dpassword AS password FROM doctor WHERE demail = ?
            UNION
            SELECT 'patient' AS usertype, pname AS name, pemail AS email, ppassword AS password FROM patient WHERE pemail = ?
            UNION
            SELECT 'admin' AS usertype, name, email, password FROM admin WHERE email = ?");

        $stmt->bind_param('sss', $email, $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPass = $row['password'];

            // Check password based on user type
            if (password_verify($password, $hashedPass)) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['usertype'] = $row['usertype'];

                if ($row['usertype'] == 'patient') {
                    header("Location: patient/patientdash.php");
                } elseif ($row['usertype'] == 'doctor') {
                    header("Location: doctor/doctordash.php");
                } elseif ($row['usertype'] == 'admin') {
                    header("Location: admin/admindash.php");
                }
                exit();
            } else {
                $login_error = "Incorrect email or password.";
            }
        } else {
            $login_error = "Incorrect email or password.";
        }
    }
    ?>
    <div class="login-container">
        <div class="input-field">
            <h2>LOG IN</h2>
            <form action="#" method="post">
                <div class="login-input-container">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" class="login-input" name="email" placeholder="Email Address" value="<?php if (isset($email))
                        echo htmlspecialchars($email); ?>">
                </div>
                <div class="login-input-container">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" class="login-input" name="password" placeholder="Password" value="<?php if (isset($password))
                        echo htmlspecialchars($password); ?>">
                </div>
                <div class="error login-error">
                    <?php if (isset($login_error))
                        echo $login_error ?>
                    </div>
                    <input id="login-btn" type="submit" name="login" value="LOG IN">
                    <p class="or">OR</p>
                    <p class="signup-link login-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
                    <p class="signup-link login-link"><a href="forgot-password.php">Forgot Password</a></p>
                </form>
            </div>
            <div class="intro">
                <img src="images/logo.png" width="400" alt="my-logo">
                <p class="headings">Welcome to our online appointment booking site.</p>
                <p class="headings">Here you can book your appointment with your preferred doctor just in few clicks.</p>
            </div>
        </div>
    <?php require_once ("components/footer.php"); ?>
</body>

</html>