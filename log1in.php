<?php
if($_SERVER["HTTPS"] != "on") {
 $pageURL = "Location: https://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
 }
 header($pageURL);
}
include_once("php_includes/check_login_status.php");
if($user_ok == true){
	header("location: account?u=".$_SESSION["username"]);
    exit();
}
if(isset($_POST["password"])){
	include_once("db_conx.php");
	$e = mysqli_real_escape_string($db_conx, $_POST["email"]);
	$p = ($_POST['password']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	if($e == "" || $p == ""){
		echo "login failed missing input";
        exit();
	} else {
		$sql = "SELECT id, username, password, email FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
	$db_email = $row[3];
}		
$xavior = '$2y$10$'.$db_pass_str;
if(password_verify($p, $xavior)){
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			$_SESSION['email'] = $db_email;
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
include_once("php_includes/check_login_status.php");
header("location: account?u=".$_SESSION['username']);
exit();
		} else {
			echo "login failed credentials didn't match";
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log In</title>
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
	border-radius: 5px;
}
</style>
</head>
<body style="position: relative;background-color:black;vertical-align:middle;">
<?php include_once("template_pageTop.php"); ?>
<div id="bod" style="background-color:black;">
  <h3 style="vertical-align:middle; width: 50%; margin: 0px auto;color:silver;">Log In Here</h3>
  <form action="log1in" method="post">
 <div style="border-radius:7px;display: -moz-inline-stack;color: grey;">Private Credential:</div><br>
    <input autocapitalize="off" type="text" name="email" maxlength="88" autofocus style="border-radius:9px;padding:11px;width:250px"><br><br>
    <div style="border-radius:7px;display: -moz-inline-stack;color: grey;">Password:</div><br>
    <input type="password" name="password" maxlength="100" style="border-radius:9px;padding:11px;width:250px;"><br>
    <br /><br />
    <button id="loginbtn" type='submit'>Log In</button> 
    <p id="status"></p>
  </form>
</div>
<?php include_once("template_pageBottom.php"); ?>
</body>
</html>
