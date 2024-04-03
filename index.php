<?php session_start();
if (!isset($_SESSION['user'])=='rohit') {
    header('Location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <style>
        *{
            margin: 0;
        }
        .contents {
            position: fixed;
            z-index: -10;
            width: 100%;
            height: 100vh;
            background-image: url('images/home-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <?php include_once("components/navbar.php") ?>
    <?php include_once("components/footer.php") ?>
    <div class="contents"></div>
    <script src="Scripts/script.js"></script>
</body>

</html>