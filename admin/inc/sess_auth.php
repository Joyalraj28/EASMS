<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

DBConnection::debugtaglog("SESSION",strpos($link, 'forgotpassword.php').'=>'.$link);
DBConnection::debugtaglog("USER",isset($_SESSION['userdata']) ? "T":"F");


if(strpos($link, 'forgotpassword.php'))
{
    //redirect('admin/forgotpassword.php');
}

if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php') && !strpos($link, 'forgotpassword.php'))
{
    
	redirect('admin/login.php');
}
if(isset($_SESSION['userdata']) && strpos($link, 'login.php') && !strpos($link, 'forgotpassword.php'))
{
    echo "<script>alert('".$_SESSION['userdata']['login_type']."');</script>";
	redirect('admin/index.php');
}
// $module = array('','admin','faculty','student');
if(isset($_SESSION['userdata']) && (strpos($link, 'index.php') || strpos($link, 'admin/')) &&  $_SESSION['userdata']['login_type'] && ($_SESSION['userdata']['login_type'] !=  1 && $_SESSION['userdata']['login_type'] !=  2 && $_SESSION['userdata']['login_type'] !=  3)){
    
    
    DBConnection::consolelog($_SESSION['userdata']['login_type']);

    
    //exit;
}
