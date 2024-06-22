<?php
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header("Location:../login.php");
    exit();
}

include('../backend/conn.php');
if (isset($_GET['id'])) {
    $did = $_GET['id'];
} else {
    echo "Doctor ID is missing.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to validate and sanitize inputs
    function validate($str) {
        return trim(htmlspecialchars($str));
    }

    $errors = [];

    $name = validate($_POST['name'] ?? '');
    $email = validate($_POST['email'] ?? '');
    $age = validate($_POST['age'] ?? '');
    $specialties = validate($_POST['specialties'] ?? '');
    $gender = validate($_POST['gender'] ?? '');

    // Fullname validation
    if (empty($name)) {
        $errors['name'] = 'Name cannot be empty.';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errors['name'] = 'Name can only contain letters and white spaces.';
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = 'Please enter your email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Age validation
    if (empty($age)) {
        $errors['age'] = 'Date of birth is required.';
    } else {
        $dobDate = new DateTime($age);
        $currentDate = new DateTime();
        $maxDate = (clone $currentDate)->modify('-130 years');

        if ($dobDate > $currentDate) {
            $errors['age'] = 'Date of birth cannot be in the future.';
        } elseif ($dobDate < $maxDate) {
            $errors['age'] = 'Date of birth cannot exceed 130 years.';
        }
    }

    // Gender validation
    if (empty($gender)) {
        $errors['gender'] = 'Please enter your gender.';
    }

    // Specialties validation
    if (empty($specialties)) {
        $errors['specialties'] = 'Specialties is required.';
    }

    // If there are no errors, update the database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE doctor SET dname = ?, demail = ?, ddob = ?, specialties = ?, dgender = ? WHERE did = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('sssssi', $name, $email, $age, $specialties, $gender, $did);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Profile updated successfully');
                    window.location.href = '../Admin/admindash.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Failed to update profile');
                    window.location.href = '../Admin/admindash.php';
                  </script>";
        }
    } else {
        $msg = implode('<br>', $errors);
    }
} else {
    // Fetch doctor details from the database
    $stmt = $conn->prepare("SELECT dname, demail, ddob, specialties, dgender FROM doctor WHERE did = ?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();

    $name = $doctor['dname'];
    $email = $doctor['demail'];
    $age = $doctor['ddob'];
    $specialties = $doctor['specialties'];
    $gender = $doctor['dgender'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor Profile || Appoint Me</title>
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
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-input-field">
            <h3>Profile Update</h3>
            <form action="updateDoc.php?id=<?php echo htmlspecialchars($did); ?>" method="post">
                <table>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-user"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($name); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['name'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-envelope"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="text" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['email'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-regular fa-calendar-days"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="date" name="age" placeholder="Date of Birth" value="<?php echo htmlspecialchars($age); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['age'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-user-doctor"></i></td>
                        <td class="signup-input-box">
                            <input class="signup-input" type="text" name="specialties" placeholder="Specialties" value="<?php echo htmlspecialchars($specialties); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['specialties'] ?? ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="input-labels"><i class="fa-solid fa-venus-mars"></i></td>
                        <td class="signup-input-box">
                            <input type="radio" name="gender" id="male" value="male" <?php if ($gender == 'male') echo 'checked'; ?> hidden>
                            <label for="male" class="radio-button"> Male</label>
                            <input type="radio" name="gender" id="female" value="female" <?php if ($gender == 'female') echo 'checked'; ?> hidden>
                            <label for="female" class="radio-button"> Female </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="error-box" colspan="2">
                            <span class="error"><?php echo $errors['gender'] ?? ''; ?></span>
                        </td>
                    </tr>
                </table>
                <div>
                    <button class="logout-btn" type="button" onclick="window.close()">Go Back</button>
                    <input class="logout-btn" type="submit" name="update" value="UPDATE">
                </div>
                
            </form>
        </div>
    </div>

</body>
</html>
