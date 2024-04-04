<?php
include ('backend/conn.php');
include('backend/create.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register || Appoint Me</title>
    <link rel="stylesheet" href="Styles/login-style.css">
</head>

<body>
    <div class="login-container">
        <div class="input-field signup-input-field">
            <h2>SIGN UP</h2>
            <form action="#" method="post">
                <table>
                    <tr>
                        <td class="input-labels">
                            <p>First Name : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="fname" placeholder="First Name"
                                pattern="[A-Za-Z]" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Last Name : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="lname" placeholder="Last Name"
                                pattern="[A-Za-Z]" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Email : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="email" name="email" placeholder="Email"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Mobile No. : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="tel" name="phone" placeholder="Mobile Number"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Password : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="password" name="password"
                                placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Confirm Password : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="password" name="password2"
                                placeholder="Confirm Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>DOB : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="date" name="dob"
                                placeholder="Choose Date of Birth" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Gender : </p>
                        </td>
                        <td class="signup-input-box">
                            <input type="radio" name="gender" id="male" value="male" required>
                            <label for="male">Male</label>
                            <input type="radio" name="gender" id="female" value="female" required>
                            <label for="female">Female</label>
                        </td>
                    </tr>
                </table>
                <!-- <input class="login-input signup-input" type="text" name="username" placeholder="Username" required>
                <input class="login-input" type="password" name="password" placeholder="Password" required> -->
                <input id="login-btn" type="submit" name="login" value="SIGN UP">
                <p class="or">OR</p>
                <p class="signup-link login-link">Already have an account? <a href="login.php">Log In</a></p>
            </form>
        </div>
    </div>
    <?php require_once("components/footer.php") ?>
</body>

</html>