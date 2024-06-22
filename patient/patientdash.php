<?php
session_start();
include ("../backend/conn.php");
if (isset($_SESSION['usertype']) && $_SESSION['usertype'] === 'patient') {
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $role = $_SESSION['usertype'];
    // Check if the 'newStatus' cookie is set

    if (isset($_SESSION['msg'])) {
        echo "<script>alert('{$_SESSION['msg']}');</script>";
        unset($_SESSION['msg']); // Clear the message after displaying it
    }
    if (!isset($_SESSION['login_message_shown'])) {
        $_SESSION['login_message_shown'] = true;
    }
    if (isset($_COOKIE['newStatus'])) {
        $newStatus = $_COOKIE['newStatus'];
        echo "<script>alert('Your appointment has been $newStatus')</script>";
        setcookie('newStatus', '', time() - 24 * 3600, '/');
    }
} else {
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
    <link rel="stylesheet" href="../Styles/footer-style.css">
    <!-- <link rel="stylesheet" href="../Styles/avatar.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <script src="https://kit.fontawesome.com/28cf9218f4.js" crossorigin="anonymous"></script> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
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
                        echo "<div class='user-avatar'>";
                        if ($avatar) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($avatar) . '" alt="Avatar" width="100" height="100">';
                        } else {
                            echo '<img src="../images/default-avatar.png" alt="Avatar" width="100" height="100">';
                        }
                        echo "</div>";
                        echo '<button onclick="addAvatar()">Edit</button>';
                        echo "<p class='username'>{$name}</p>";
                    }
                    ?>
                </div>
                <button class="logout-btn"><a href="../logout.php">Log out</a></button>
            </div>
            <div>
                <p><a href="#" onclick="home()">Home</a></p>
                <p><a href="#" onclick="reports()">Reports</a></p>
                <p><a href="#" onclick="appointments()">Appointments</a></p>
                <p><a href="#">Settings</a></p>
            </div>

        </div>
        <div class="right-body home">
            <div class="nav-con">
                <div class="header">
                    <div class="logo">
                        <a href="#">
                            <img id="img-logo" src="../images/logo.png" alt="logo of this app" height="65">
                        </a>
                    </div>
                    <div>
                        <h3 class="nav-con h3" id="date">date</h3>
                    </div>
                </div>
            </div>

            <div id="res">
                <?php
                include ("../components/home.php");
                ?>
            </div>
            <?php
            include ('../components/footer.php'); ?>
        </div>


    </section>
    <script>
        date = new Date();
        var month = 1 + date.getMonth();
        document.getElementById("date").innerHTML = date.getFullYear() + "/" + month + "/" + date.getDate();
        function loadContent(url) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("res").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url);
            xhttp.send();
        }
        function reports() {
            loadContent("../medical_reports/medical.php");
        }
        function home() {
            loadContent("../components/home.php");
        }
        function appointments() {
            loadContent("myAppointments.php");
        }
        function addAvatar() {
            loadContent("../components/avatar-upload.php")
        }
        function viewImage(mid) {
            console.log("View Image clicked for MID:", mid);
            window.open('../medical_reports/view.php?mid=' + mid, 'Image', 'width=600,height=400');
        }
        function medicalUpload() {
            window.open('../medical_reports/medical_upload.php', '_blank', 'width=800,height=1000');
        }


    </script>
</body>

</html>