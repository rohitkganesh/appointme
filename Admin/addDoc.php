<?php
session_start();
include('../backend/conn.php');
include('../backend/create.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Register || Appoint Me</title>
    <link rel="stylesheet" href="../Styles/login-style.css">
    <link rel="stylesheet" href="../Styles/footer-style.css">
</head>

<body>
    <div class="login-container">
        <div class="input-field signup-input-field">
            <h2>DOCTOR SIGN UP</h2>
            <form action="" method="post">
                <table>
                    <tr>
                        <td class="input-labels">
                            <p>First Name : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="fname" placeholder="First Name" pattern="[A-Za-Z]+" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Last Name : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="lname" placeholder="Last Name" pattern="[A-Za-Z]+" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Email : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="email" name="email" placeholder="Email" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Address : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="address" placeholder="Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Mobile No. : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="tel" name="mobile" placeholder="Mobile Number" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Password : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="password" name="password" placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>Confirm Password : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="password" name="password2" placeholder="Confirm Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels">
                            <p>DOB : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="date" name="dob" placeholder="Choose Date of Birth" required>
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
                    <tr>
                        <td class="input-labels">
                            <p>Specialties : </p>
                        </td>
                        <td class="signup-input-box">
                            <input class="login-input signup-input" type="text" name="specialties" placeholder="Specialties" required>
                        </td>
                    </tr>
                </table>
                <div>
                    <button id="login-btn" type="button" onclick="prev()">Go Back</button> &nbsp; &nbsp;
                    <input id="login-btn" type="submit" name="signup" value="Add Doctor">
                </div>
            </form>
            <?php if (!empty($msg)) { echo "<script>alert($msg);</script>"; } ?>
        </div>
    </div>
    <?php require_once("../components/footer.php") ?>
</body>
</html>
<script>
    function prev() {
        window.location.href = '../Admin/admindash.php';
    }
</script>
