<?php
if($_SERVER["HTTPS"] != "on") {
 $pageURL = "Location: https://";
header($pageURL);
}
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'Android'))
 {
  header('Location: mlogin');
exit();
}
require("php_includes/check_login_status.php");
if($user_ok == true){
	header("location: account?u=".$_SESSION["username"]);
   exit();
}
if(isset($_POST["e"])){
	require_once("db_conx.php");
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = ($_POST['p']);
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));	
	if($e == "" || $p == ""){
		echo "login_faild";
        exit();
	} 
else
{
		$sql = "SELECT id, email, password, username FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_email = $row[1];
        $db_pass_str = $row[2];
	$db_username = $row[3];
}		
$xavior = '$2y$10$'.$db_pass_str;
if(password_verify($p, $xavior))
{
			$_SESSION['userid'] = $db_id;
			$_SESSION['email'] = $db_email;
			$_SESSION['password'] = $db_pass_str;
			$_SESSION['username'] = $db_username;
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE email='$db_email' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
header("location: account?u=".$_SESSION["username"]);
		} else {
			echo "login_fail";
exit();
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<noscript>
<meta http-equiv="refresh" content="0;url=log1in">
</noscript>
<meta charset="UTF-8">
<title>Login</title>
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
	width: 450px;
	padding: 12px;
	background:  #d6d6c2;
	border-radius: 11px;
	background-color: black;
	color: green;
	border-color: black;
}
#loginbtn {
	font-size:17px;
	padding: 15px;
	border-radius:11px;
}
</style>
<script src="js/stuntn.js"></script>
<script src="js/good.js"></script>
<script>
function emptyElement(z){
	_(z).innerHTML = "";
}
function login(){
	var e = _("email").value;
	var p = _("password").value;
	if(e == "" || p == ""){
		_("status").innerHTML = "Missing Data";
	} else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = 'Wait ...';
		var ajax = ajaxObj("POST", "login");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = "Login unsuccessful, try again.";
					_("loginbtn").style.display = "block";
				} else {
  window.location = "login.php";
				}
	        }
        }
        ajax.send("e="+e+"&p="+p);
	}
}
</script>
</head>
<?php header("Location:bb#m");?>
<body style="position: relative;background-color:#060505;vertical-align:middle;">
<?php include_once("template_pageTop.php"); ?>
<div id="bod" style="background-color:#060505">
  <h3 style="vertical-align:middle; width: 50%; margin: 0px auto;color:silver;font-size: 40px;">Log In</h3>
  <form id="loginform" onsubmit="return false;">
 <div style="display: -moz-inline-stack;color: grey;">Private Credential:</div><br>
    <input autocapitalize="off" type="text" id="email" onfocus="emptyElement('status')" maxlength="88" autofocus ><br><br><br>
    <div style="display: -moz-inline-stack;color: grey;">Password:</div><br>
    <input style="width:600px" type="password" id="password" onfocus="emptyElement('status')" maxlength="100"><br>
    <br /><br />
    <button id="loginbtn" onclick="login()">Login</button> 
    <p id="status"></p>
  </form>
</div>
<?php include_once("template_pageBottom.php"); ?>
</body>
</html>
