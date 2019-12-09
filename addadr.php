<?php
session_start();
#require("php_includes/check_login_status.php");
#if($user_ok == false) {
#echo "broke";
#exit();
#}
$file97 = './boomers';
$du = $_SESSION['username'];
file_put_contents($file97,$du);
header("location: 1sec.php"); 
#echo $du;
exit();
?>
