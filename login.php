<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In || Appoint Me</title>
    <link rel="stylesheet" href="Styles/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- <script src="https://kit.fontawesome.com/6645d5fb73.js" crossorigin="anonymous"></script> -->
</head>

<body>
    <?php
    include ('backend/login-form-validate.php');
    include ('backend/conn.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPass = $row['password'];
            if (password_verify($password,$hashedPass)) {
                $_SESSION['user'] = $row['email'];
                header("Location:patient\patientdash.php");
                exit();
            }
        }

        // $result = $conn->query("SELECT * FROM users");
        // while($result->num_rows >0){  
        //     $row = $result->fetch_assoc();          
        //     if ($username == $row['email'] && $password == $row['password'] ) {
        //         $_SESSION['user'] = 'rohit';
        //         header("Location:index.php");
        //         exit();
        //     }
    
        // }
    

    }
    ?>
    <div class="login-container">
        <div class="input-field">
            <h2>LOG IN</h2>
            <form action="#" method="post">
                <div class="login-input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" class="login-input" name="email" placeholder="Email Address" value="<?php if (isset($email))
                        echo $email ?>">
                        <p class="error">
                        <?php if (isset($email_error))
                        echo $email_error ?>
                        </p>
                    </div>
                    <div class="login-input-container">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="login-input" name="password" placeholder="Password" value="<?php if (isset($password))
                        echo $password ?>">
                        <p class="error">
                        <?php if (isset($password_error))
                        echo $password_error ?>
                        </p>
                    </div>
                    <input id="login-btn" type="submit" name="login" value="LOG IN">
                    <p class="or">OR</p>
                    <p class="signup-link login-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
                    <p class="signup-link login-link"><a href="forgot-password.php">Forgot Password</a></p>

                </form>
            </div>
        </div>
    <?php require_once ("components/footer.php") ?>
</body>

</html>