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

    //mobile validation
    if (empty($_POST['mobile'])) {
        $mobile_error = 'Mobile number is required.';
    } else {
        $mobile = validate($_POST['mobile']);
        if (!preg_match("/^9\d{9}$/", $mobile)) {
            $mobile_error = 'Invalid mobile number.';
        }
    }

    //age validation
    if (empty($_POST['age']) && validate($_POST['age']) == 0) {
        $age_error = 'Age is required.';
    } else {
        $age = validate($_POST['age']);
        if ($age < 0) {
            $age_error = 'Age cannot be negative.';
        } else if($age > 130){
            $age_error = 'Invalid age.';
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
}
