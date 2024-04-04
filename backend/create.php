<?php
include ('conn.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $name= $fname." ".$lname;
    $email = $_POST['email'];
    $mobile= $_POST['phone'];
    $password = $_POST['password'];
    $password2= $_POST['password2'];
    $dob= $_POST['dob'];
    $gender= $_POST['gender'];
    $msg = '';
    if ($password==$password2){
    $stmt = $conn->prepare('SELECT email FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $msg = "Email already used. Cannot use twice.....";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO patient(Name, Email, Mobile, Password, DOB, Gender) VALUES(?, ?, ?, ?, ?, ? )');
        $stmt->bind_param('ssssss',$name,$email,$mobile,$hash,$dob,$gender);
        // $database->query("INSERT INTO patient(Name, Email, Mobile, Password, DOB, Gender) VALUES ('$name','$email','$mobile','$password','$dob','$gender');");
        $user = $conn->prepare('INSERT INTO users(usertype,email, password) VALUES(?, ?, ?)');
        $usertype='patient';
        $user->bind_param('sss',$usertype, $email, $hash);
        if ($stmt->execute()) {
            if($user->execute()){
                $msg = 'User Created Successfully';
            }
        } else {
            $msg = 'User could not be created.';
        }
    }
}
else{
    $msg="Password Confirmation Error! Reconfirm Password";
}
}