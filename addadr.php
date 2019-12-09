<?php
session_start();
$file97 = './boomers';
$du = $_SESSION['username'];
file_put_contents($file97,$du);
header("location: 1sec.php"); 
exit();
?>
