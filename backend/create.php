<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $name = $fname . " " . $lname;
    $email = $_POST['email'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $specialties = isset($_POST['specialties']) ? $_POST['specialties'] : ''; // Specialties for doctors
    $msg = '';

    if ($password === $password2) {
        $stmt = $conn->prepare("
            SELECT demail AS email FROM doctor WHERE demail = ?
            UNION
            SELECT pemail AS email FROM patient WHERE pemail = ?
            UNION
            SELECT email FROM admin WHERE email = ? LIMIT 1
        ");
        $stmt->bind_param('sss', $email, $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msg = "Email already used. Cannot use twice.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if (!empty($specialties)) { // If specialties is provided, it's a doctor
                $role = 'doctor';
                $stmt = $conn->prepare('INSERT INTO doctor(dname, demail, daddress, dmobile, dpassword, ddob, dgender, specialties) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssssss', $name, $email, $address, $mobile, $hash, $dob, $gender, $specialties);
            } else { // Else, it's a patient
                $role = 'patient';
                $stmt = $conn->prepare('INSERT INTO patient(pname, pemail, paddress, pmobile, ppassword, pdob, pgender) VALUES(?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('sssssss', $name, $email, $address, $mobile, $hash, $dob, $gender);
            }

            if ($stmt->execute()) {
                $msg = 'User Created Successfully';
                echo "<script>
                        alert('$msg');
                        window.location.href = '" . ($role == 'patient' ? "login.php" : "../Admin/admindash.php") . "';
                      </script>";
                exit(); // Ensure the script stops after the redirect
            } else {
                $msg = 'User could not be created. ' . htmlspecialchars($stmt->error);
            }
        }
        $stmt->close();
    } else {
        $msg = "Password Confirmation Error! Reconfirm Password";
    }
}
?>

<!-- Include the message variable to be used in signup.php -->
<?php 
if (!empty($msg)) {
    echo "<script>alert('$msg');</script>";
} 
?>
