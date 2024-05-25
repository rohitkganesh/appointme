<?php
session_start();
include("../backend/conn.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['name']) || !isset($_SESSION['usertype'])) {
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['email'];
$usertype = $_SESSION['usertype'];

if (isset($_POST['upload'])) {
    $avatar = $_FILES['avatar']['tmp_name'];
    if ($avatar) {
        $imgData = file_get_contents($avatar);

        // Determine the correct table and column for the avatar update
        switch ($usertype) {
            case 'doctor':
                $stmt = $conn->prepare("UPDATE doctor SET avatar = ? WHERE demail = ?");
                break;
            case 'patient':
                $stmt = $conn->prepare("UPDATE patient SET avatar = ? WHERE pemail = ?");
                break;
            case 'admin':
                $stmt = $conn->prepare("UPDATE admin SET avatar = ? WHERE email = ?");
                break;
            default:
                $_SESSION['msg'] = "Invalid user type.";
                header("Location: doctordash.php");
                exit();
        }

        $stmt->bind_param('bs', $imgData, $email);
        $stmt->send_long_data(0, $imgData);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Avatar uploaded successfully!";
        } else {
            $_SESSION['msg'] = "Failed to upload avatar: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "Please select an image to upload.";
    }    
}
switch ($usertype) {
    case 'doctor':
        header("Location: ../doctor/doctordash.php");
        break;
    case 'patient':
        header("Location: ../patient/patientdash.php");
        break;
    case 'admin':
        header("Location: ../admin/admindash.php");
        break;
    default:
        header("Location: ../login.php");
}
exit();
