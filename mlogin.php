<?php
// Force HTTPS for security
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
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: account?u=".$_SESSION["username"]);
    exit();
}
?>
<?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
	// CONNECT TO THE DATABASE
	include_once("php_includes/db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = ($_POST['p']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($e == "" || $p == ""){
		echo "login_faild";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
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
//if(password_verify($p, $db_pass_str)){
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['email'] = $db_email;
			$_SESSION['password'] = $db_pass_str;
//			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
//			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
//    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		    exit();
		} else {
			echo "login_fail";
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
title {
	text-align:center;
}
h1 {
	text-align:center
}
#loginform{
	margin-top:30px;	
	text-align:center;	
}
#loginform > div {
	margin-top: 20px;	
}
#loginform > input {
	font-size:40px;
	height:60px;
#	width: 600px;
	width: 95%;
	background: #F3F9DD;
	border-radius: 16px;
}
#loginform > input[placeholder]
{
  line-height:30px;
  font-size:22px;
}
#loginbtn {
	width: 180px;
	height: 90px;
	font-size:24px;
	padding: 16px;
	border-radius: 9px;
}
</style>
<script src="js/valve.js"></script>
<script src="js/pipe.js"></script>
<script>
function emptyElement(z){
	_(z).innerHTML = "";
}
function login(){
	var e = _("email").value;
	var p = _("password").value;
	if(e == "" || p == ""){
		_("status").innerHTML = "Fill out all of the form data";
	} else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "mlogin.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = "Login unsuccessful, please try again.";
					_("loginbtn").style.display = "block";
				} else {
					window.location = "account?u="+ajax.responseText;
				}
	        }
        }
        ajax.send("e="+e+"&p="+p);
	}
}
</script>
</head>
<?php include_once("mpgTp.php"); ?>
<body>
<br> 
 <h1>Log In</h1>
  <!-- LOGIN FORM -->
  <form id="loginform" onsubmit="return false;">
    <div>First Password:</div>
    <input type="text" id="email" onfocus="emptyElement('status')" maxlength="88" autofocus >
    <div>Second Password:</div>
    <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
    <br /><br />
    <button id="loginbtn" onclick="login()">Log In</button> 
    <p id="status"></p>
  </form>
</div>
<?php include_once("template_pageBottom.php"); ?>
</body>
</html>
