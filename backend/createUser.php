<?php
include ('conn.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $msg = '';

    $stmt = $conn->prepare('SELECT email FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $msg = "Email already used. Cannot use twice.....";
    } else {
        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare('INSERT INTO users(email, password, name) VALUES(?, ?, ?)');
        $stmt->bind_param('sss', $email, $hash, $name);
        if ($stmt->execute()) {
            $msg = 'User Created Successfully';
        } else {
            $msg = 'User could not be created.';
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<style>
    fieldset {
        width: max-content;
        padding: 10px;
    }

    p {
        display: inline-block;
        width: 70px;
        margin: 5px;
    }

    #submit {
        margin-left: 41%;
        margin-top: 15px;
        padding: 5px 10px;
        background-color: gray;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 17px;
    }

    #submit:hover {
        background-color: black;
    }
</style>

<body>
    <fieldset>
        <legend>Create User</legend>
        <form action="#" method="post">
            <p>Email :</p>
            <input type="email" name="email"><br>
            <p>Password :</p>
            <input type="password" name="password"><br>
            <p>Name :</p>
            <input type="text" name="name"><br>
            <span>
                <?php if (isset($msg))
                    echo $msg ?>
                </span><br>
                <input type="submit" id="submit">
            </form>
        </fieldset>
    </body>

    </html>