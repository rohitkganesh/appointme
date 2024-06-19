<?php
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header("Location:../login.php");
}
include ('../backend/formValidation.php');
include ('../backend/create.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Register || Appoint Me</title>
    <link rel="stylesheet" href="../Styles/signup-style.css">
    <link rel="stylesheet" href="../Styles/footer-style.css">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <!-- <script src="https://kit.fontawesome.com/28cf9218f4.js" crossorigin="anonymous"></script> -->
    <!-- FontAwesome 6 from cdnjs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <div class="signup-input-field">
            <h3 id="signup">ADD DOCTOR</h3>
            <form action="#" method="post">
                <table>
                    <tr>
                        <td class="input-labels">
                            <!-- <p>First Name : </p> -->
                            <i class="fa-solid fa-user"></i>
                        </td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="text" name="name" placeholder="Full Name" value="<?php if (isset($name))
                                echo $name ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2"><span class="error">
                                <?php if (isset($name_error))
                                echo $name_error ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="input-labels">
                                <!-- <p>Email : </p> -->
                                <i class="fa-solid fa-envelope"></i>
                            </td>
                            <td class="signup-input-box">
                                <input class="signup-input" type="text" name="email" placeholder="Email" value="<?php if (isset($email))
                                echo $email ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($email_error))
                                echo $email_error ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="input-labels">
                                <!-- <p>Mobile No. : </p> -->
                                <i class="fa-solid fa-phone"></i>
                            </td>
                            <td class="signup-input-box">
                                <input class="signup-input" type="number" name="mobile" placeholder="Mobile Number" value="<?php if (isset($mobile))
                                echo $mobile ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($mobile_error))
                                echo $mobile_error ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="input-labels">
                                <!-- <p>age : </p> -->
                                <i class="fa-regular fa-calendar-days"></i>
                            </td>
                            <td class="signup-input-box">
                                <input class="signup-input" type="date" name="age" placeholder="Age in years" value="<?php if (isset($age))
                                echo $age ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($age_error))
                                echo $age_error ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="input-labels">
                                <!-- <p>Password : </p> -->
                                <i class="fa-solid fa-lock"></i>
                            </td>
                            <td class="signup-input-box">
                                <input class="signup-input" type="password" name="password" value="<?php if (isset($password))
                                echo $password ?>" placeholder="Password">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($password_error))
                                echo $password_error ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="input-labels">
                                <!-- <p>Confirm Password : </p> -->
                                <i class="fa-solid fa-lock"></i>
                            </td>
                            <td class="signup-input-box">
                                <input class="signup-input" type="password" name="password1" value="<?php if (isset($password1))
                                echo $password1 ?>" placeholder="Confirm Password">
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($password1_error))
                                echo $password1_error; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <!-- <p>speciality : </p> -->
                            <i class="fa-solid fa-user-doctor"></i>
                        </td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="text" name="specialties" value="<?php if (isset($specialties))
                                echo $specialties ?>" placeholder="Specialties" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="error-box" colspan="2">
                                <span class="error">
                                <?php if (isset($specialties_error))
                                echo $specialties_error; ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="input-labels">
                            <!-- <p>Gender : </p> -->
                            <i class="fa-solid fa-venus-mars"></i>
                        </td>
                        <td class="signup-input-box">
                            <input type="radio" name="gender" id="male" value="male" hidden>
                            <label for="male" class="radio-button"> Male</label>
                            <input type="radio" name="gender" id="female" value="female" hidden>
                            <label for="female" class="radio-button"> Female </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error">
                                <?php if (isset($gender_error))
                                    echo $gender_error ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <!-- signup button -->
                    <input id="signup-btn" type="submit" name="login" value="SUBMIT">
                    <p class="error">
                    <?php if (isset($msg))
                                    echo $msg ?>
                    </p>

                <?php require_once ("../components/footer.php") ?>
</body>

</html>
<script>
    function prev() {
        window.location.href = '../Admin/admindash.php';
    }
</script>