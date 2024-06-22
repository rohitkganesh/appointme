<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // primary validate function
    function validate($str)
    {
        return trim(htmlspecialchars($str));
    }
    //fullname validation
    if (empty($_POST['name'])) {
        $name_error = 'Name cannot be empty.';
    } else {
        $name = validate($_POST['name']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $name_error = 'Name can only contain letters and white spaces';
        }
    }

    //email validation
    if (empty($_POST['email'])) {
        $email_error = 'Please enter your email';
    } else {
        $email = validate($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = 'Invalid Email';
        }
    }


    //age validation

    if (empty($_POST['age'])) {
        $age_error = 'Date of birth is required';
    } else {
        $age = $_POST['age'];
        $dobDate = new DateTime($age);
        $currentDate = new DateTime();
        $maxDate = (clone $currentDate)->modify('-130 years');

        if ($dobDate > $currentDate) {
            $age_error = 'Date of birth cannot be in the future.';
        } elseif ($dobDate < $maxDate) {
            $age_error = 'Date of birth cannot exceed 130 years.';
        } else {
            $age_error = '';
        }
    }

    //password validation
    if (empty($_POST['password'])) {
        $password_error = 'Password cannot be empty';
    } else {
        $password = validate($_POST['password']);
        if (strlen($password) < 6) {
            $password_error = 'Password should be longer than 6 characters';
        }
    }

    //password match verify 
    if (!empty($password)) {
        $password1 = validate($_POST['password1']);
        if ($password != $password1) {
            $password1_error = "Password doesn't matches";
        }
    }
    //gender validation
    if (empty($_POST['gender'])) {
        $gender_error = 'Please enter your gender.';
    } else {
        $gender = $_POST['gender'];
    }

    //specialty validation for doctor
    if (empty($_POST['specialties'])) {
        $specialties_error = 'Specialties is required.';
    } else {
        $specialties = validate($_POST['specialties']);
    }
}
