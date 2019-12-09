<?php
session_start();
if($_POST["ass1"] === ""){
header('location: login');
}
if(!$_POST["ass1"] == ""){
 GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$nub = $_POST["ass1"];
if($nub == ""){
		echo "failed missing input";
        exit();
	} 
else {
$p_hash = password_hash($nub, PASSWORD_BCRYPT);
$tpt = substr($p_hash, -53);
$qes = $_SESSION['username'];
require("db_conx.php");
$sql = "UPDATE users SET password='$tpt' WHERE username='$qes'";
$query = mysqli_query($db_conx, $sql);
echo "Updated successfully".$qes;
header('location: logout');
}		
}
?>
<meta charset="UTF-8">
<title>UPDATE</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
bod {
        background-color:black;
}
title {
	text-align:center;
}
h3 {
	text-align:center
}
#loginform{
	margin-top:24px;	
	text-align:center;	
}
#loginform > div {
	margin-top: 12px;	
}
#loginform > input {
	width: 350px;
	padding: 11px;
	background:  #d6d6c2;
	border-radius: 11px;
}
#loginbtn {
	font-size:15px;
	padding: 10px;
}
</style>
<div id="bod" style="">
  <h3 style="vertical-align:middle; width: 50%; margin: 0px auto;color:silver;"></h3>
  <form action="upidi.php" method="post">
 <div style="display: -moz-inline-stack;color: grey;">new password:</div><br><br>
    <input style="border-radius: 20px;padding:9px;-moz-user-focus:normal" autocapitalize="off" type="text" name="ass1" maxlength="99" autofocus><br><br>
    <br /><br />
    <button style="padding:9px;border-radius:5px" id="updator" type='submit'>Update</button> 
  </form>
</div>
