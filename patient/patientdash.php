<?php
session_start();
include("../backend/conn.php");
if(isset($_SESSION['email']) && isset($_SESSION['name'])){
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $role=$_SESSION['usertype'];

    if(isset($_SESSION['msg'])) {
        echo "<script>alert('{$_SESSION['msg']}');</script>";
        unset($_SESSION['msg']); // Clear the message after displaying it
    }

    // Check if the login message has been shown
    if(!isset($_SESSION['login_message_shown'])) {
        $message = "Login successful. Welcome  $role , $name  ( $email )";
        echo "<script>alert('$message');</script>";
        // Set session variable to indicate message has been shown
        $_SESSION['login_message_shown'] = true;
}} else {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/dashboard.css">
    <link rel="stylesheet" href="../Styles/style-prev.css">
    <link rel="stylesheet" href="../Styles/avatar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
   
  <section class="section-body">

    <div class="left-body">
        <div class="patient">
        <div class="avatar-container">
            <?php
            $stmt = $conn->prepare("SELECT * FROM patient WHERE pemail = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['pname'];
                $avatar = $row['Avatar'];
                if ($avatar) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar">';
                } else {
                    echo '<img src="../images/default-avatar.png" alt="Avatar" ';
                }
                echo '<br><button onclick="addAvatar()">Edit</button>';
                echo "<p>{$name}</p>";
            }
            ?>
        </div>
            <button class="logout-btn"><a href="../logout.php">Log out</a></button>
        </div>
        <div>
            <p><a href="#">Home</a></p>
            <p><a href="#"onclick="reports()">Reports</p>
            <p><a href="#" onclick="appointments()">Appointments</a></p>
            <p><a href="#">Settings</a></p>
        </div>
            
    </div>
    <div class="right-body home">
            <div class="nav-con">
                <div>
                    <h3 class="nav-con h3" >APPOINT ME</h3>
                </div>
                <div>
                    <h3 class="nav-con h3" id="date">date</h3>
                </div>
            </div>
        
        <div id="res">
            

        </div>
    </div>
    

  </section>
<script>
    date = new Date();
    var month= 1+ date.getMonth();
    document.getElementById("date").innerHTML= date.getFullYear()+"/"+month  +"/"+date.getDate();
    function loadContent(url){
        const xhttp= new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                    document.getElementById("res").innerHTML=this.responseText;
                }
            };
            xhttp.open("GET",url);
            xhttp.send();
    }
    function reports() {
        loadContent("../medical_reports/medical.php");
    }
    function appointments(){
        loadContent("myAppointments.php");
    }
    function addAvatar(){
        loadContent("../components/avatar-upload.php")
    }
    function viewImage(mid) {
            console.log("View Image clicked for MID:", mid);
            window.open('../medical_reports/view.php?mid=' + mid, 'Image', 'width=600,height=400');
        }
    function medicalUpload() {
            window.open('../medical_reports/medical_upload.php' , '_blank', 'width=800,height=1000');
        }
    

</script>
</body>
</html>

