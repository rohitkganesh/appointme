<?php
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'patient') {
    header("Location: ../login.php");
    exit();
}

include('../backend/conn.php');

$pid = $_SESSION['id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to validate and sanitize inputs
    function validate($str) {
        return trim(htmlspecialchars($str));
    }

    $current_password = validate($_POST['current_password'] ?? '');
    $new_password = validate($_POST['new_password'] ?? '');
    $confirm_password = validate($_POST['confirm_password'] ?? '');

    // Validate current password
    if (empty($current_password)) {
        $errors['current_password'] = 'Current password is required.';
    }

    // Validate new password
    if (empty($new_password)) {
        $errors['new_password'] = 'New password is required.';
    } elseif (strlen($new_password) < 6) {
        $errors['new_password'] = 'Password should be longer than 6 characters.';
    }

    // Validate confirm password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your new password.';
    } elseif ($new_password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // Check if the current password is correct
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT ppassword FROM patient WHERE pid = ?");
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctor = $result->fetch_assoc();

        if (!password_verify($current_password, $doctor['ppassword'])) {
            $errors['current_password'] = 'Current password is incorrect.';
        }
    }

    // If there are no errors, update the password
    if (empty($errors)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE patient SET ppassword = ? WHERE pid = ?");
        $stmt->bind_param('si', $hashed_password, $pid);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Password updated successfully');
                    window.close();
                  </script>";
            exit();
        } else {
            $errors['form'] = "Failed to update password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password || Appoint Me</title>
    <link rel="stylesheet" href="../Styles/signup-style.css">
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .signup-input-field {
            position: fixed;
            top: 15%;
            left: 20%;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-input-field">
            <h3>Change Password</h3>
            <form action="../patient/changePatientpassword.php" method="post">
                <table>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-lock"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['current_password'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-lock"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['new_password'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-lock"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['confirm_password'] ?? ''; ?></span>
                        </td>
                    </tr>
                </table>
                <div>
                    <button class="logout-btn" type="button" onclick="window.close()">Go Back</button>
                    <input class="logout-btn" type="submit" name="update" value="CHANGE PASSWORD">
                </div>
                <p class="error"><?php echo $errors['form'] ?? ''; ?></p>
            </form>
        </div>
    </div>
   
</body>
</html>
