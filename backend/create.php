<?php
include ('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        empty($age_error) &&
        empty($name_error) &&
        empty($email_error) &&
        empty($mobile_error) &&
        empty($password_error) &&
        empty($password1_error) &&
        empty($gender_error)
    ) {
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
            //password hashing
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if (!empty($specialties)) { // If specialties is provided, it's a doctor
                $role = 'doctor';
                $stmt = $conn->prepare('INSERT INTO doctor(dname, demail, dmobile, dpassword, ddob, dgender, specialties) VALUES(?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('sssssss', $name, $email, $mobile, $hash, $age, $gender, $specialties);
            } else { // Else, it's a patient
                $role = 'patient';
                $stmt = $conn->prepare('INSERT INTO patient(pname, pemail, pmobile, ppassword, pdob, pgender) VALUES(?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssss', $name, $email, $mobile, $hash, $age, $gender);
            }

            if ($stmt->execute()) {
                $msg = '<span style="color:green">Account created Successfully.<br>Log In to continue . . .</span>';
                ($role == 'patient') ? header('Refresh:2, url=login.php') : header('Refresh:2, url=../Admin/admindash.php');
                exit(); // Ensure the script stops after the redirect
            } else {
                $msg = 'User could not be created. ' . htmlspecialchars($stmt->error);
            }
        }
        $stmt->close();
    }
}
