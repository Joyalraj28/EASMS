<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance Portal</title>
    <link rel="stylesheet" href="./css/style.css">
    <!-- jQuery -->
   <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./plugins/bootstrap-4.0.0/dist/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- JS -->
    <script src="./js/main.js"></script>
 
    <?php require_once('./Class/Attendancemark.php') ?>
</head>
<body>
<div class="main">
<div class="header">
    <img src="./img/ems.png" alt="">
    <h1>Employee Attendance Portal</h1>
</div>
<div class="content">
    <form id="attent-frm" action="" method="post">
        <input id='empid' type="number" placeholder="Enter employee id" name="empid" autofocus>
    </form>

    <div class="infomessage"></div>
    <div class="infofram"></div>


    <div class="megabutton">
    <button class="megabutton-LunchIn" hidden><i class="fas fa-utensils"></i>Lunch In</button>  
    <button  class="megabutton-SignOut" hidden><i class="fas fa-sign-in-alt"></i>Sign out</button>
    </div>

</div>
</div>


</body>
</html>
