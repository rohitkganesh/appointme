<?php
session_start();
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}
else{
    $user="Session variable not set";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dashboard.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<script>
var user = "<?php echo $user; ?>";
alert("Welcome "+user); 
</script>
   
  <section class="section-body">

    <div class="left-body">
        <div class="patient">
            <p>Patient name</p>
            <button><a href="../login.php">Log out</a></button>
        </div>
        <div>
            <p><a href="patientdash.php">Home</a></p>
            <p><a href="#"onclick="reports()">Reports</p>
            <p><a href="#" onclick="appointments()">My appointments</a></p>
            <p><a href="">Settings</a></p>
        </div>
            
    </div>
    <div class="right-body home">
        <div class="nav">
            <div class="nav-con">
                
                <h3>APPOINT ME</h3>
            </div>
            <H3 id="date">date</H3>
        </div>
        <div id="res">
            

        </div>
    </div>
    

  </section>
<script>
    date = new Date();
    document.getElementById("date").innerHTML= date.getFullYear()+"/"+date.getMonth()  +"/"+date.getDate();
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
        loadContent("reports.php");
    }
    function appointments(){
        loadContent("myAppointments.php");
    }

</script>
</body>
</html>
