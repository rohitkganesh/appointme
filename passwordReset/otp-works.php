<?php
function sendmail($user, $fname)
{
    include ('backend/conn.php');
    $to = $user;
    $otp = random_int(100000, 999999);
    $subject = 'Appoint Me - OTP - Password Reset';
    $from = 'Appoint Me <appointmeweb@gmail.com>';
    $message = 'Hello ' . $fname . '<br> Your OPT for password reset is : ' . $otp;
    $headers = "From: $from\r\n";
    $headers .= "X-Mailer: PHP \r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    // OTP expire time and storing in DB...
    $expiry = (new DateTime('+230 minutes'))->format('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE patient SET otp = ?, otp_expiry = ? WHERE pemail = ?");
    $stmt->bind_param('iss', $otp, $expiry, $to);
    if ($stmt->execute()) {
        if (mail($to, $subject, $message, $headers)) {
            return ('<span style="color:green;margin-left: -35px;">OTP sent succesfully to ' . $to . '.</span>');
        } else {
            return ('OTP sending failed.');
        }
    }
}

function otpverify($otp, $pid)
{
    include ('../backend/conn.php');
    $stmt = $conn->prepare('SELECT pemail,otp FROM patient WHERE otp = ? AND expiry > NOW()');
    $stmt->bind_param('i', $otp);
    $stmt->execute();
    $rs = $stmt->get_result();
    if ($rs->num_rows > 0) {
        header('Location:reset-password.php?id='.$pid);
    }

}
