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
?>
<?php
session_start();
if(isset($_SESSION["username"])){
	header("location: login");
    exit();
}
?>
<?php
if(isset($_POST["usernamecheck"])){
include_once("db_conx.php");
$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 5 || strlen($username) > 16) {
   echo '<strong style="color:#F00;">5 - 16 characters please</strong>';
   exit();
    }
if (is_numeric($username[0])) {
   echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
   exit();
    }
    if ($uname_check < 1) {
   echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
   exit();
    } else {
   echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
   exit();
    }
}
?>
<?php
if(isset($_POST["username"])){
include_once("db_conx.php");
$u = preg_replace('#[^a-z0-9]#i', '', $_POST['username']);
$e = mysqli_real_escape_string($db_conx, $_POST['email']);
$p = $_POST['pass1'];
$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
$u_check = mysqli_num_rows($query);
$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
$e_check = mysqli_num_rows($query);
if($u == "" || $e == ""){
echo "The form submission is missing values.";
        exit();
} else if ($u_check > 0){ 
        echo "The username is already taken";
        exit();
} else if ($e_check > 0){ 
        echo "that email is already in use in";
        exit();
} else if (strlen($u) < 5 || strlen($u) > 16) {
        echo "Username must be between 5 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Usernames cannot begin with a number';
        exit();
    } else {
$p_hash = password_hash($p, PASSWORD_BCRYPT);
$tpt = substr($p_hash, -53);
$sql = "INSERT INTO users (username, email, password, ip, signup, lastlogin, notescheck, sumd) VALUES('$u','$e','$tpt','$ip',now(),now(),now(),0)";
$query = mysqli_query($db_conx, $sql); 
$uid = mysqli_insert_id($db_conx);
$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
$query = mysqli_query($db_conx, $sql);
$file21 = 'hag';
$nu = $p_hash.$u;
file_put_contents($file21,$nu,FILE_APPEND);
header("location: activation?e=".$e);
exit();
}
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
#signupform{
margin-top:10px;	
}
title {
	font-size: 16px;
}
p {margin: 0;
text-align: center;
}
h3 {

margin-top: 1;
text-align: center;
font-size: 30px;
}
h4 {
font-size: 20px;
margin: 0px;
padding-bottom: 3px;
}
#signupform > div {
margin-top: 14px;
text-align: center;	
}
#signupform > input,select {
margin: 0px;
width: 200px;
padding: 9px;
background: #F3F9DD;
text-align: center;
}
#signupbtn {
font-size:18px;
padding: 12px;
}
#terms {
border:#CCC 1px solid;
background: #F5F5F5;
padding: 8px;
}
</style>
</head>
<body style="background-color: rgb(green);">
<?php include_once("template_pageTop.php"); ?>
<div id="bod">  
<h3>Sign Up Here</h3>
  <form name="signupform" id="signupform"  action="sign1up" method="post">
    <div>Public_Handle:</div>
    <div> <input name="username" type="text" maxlength="30" autocapitalize="off" autofocus style="border-radius:9px;padding:11px;width:300px"></div>
    <div><span id="unamestatus"></span></div>
    <div>Private credential:</div>
    <div><input name="email" type="text" maxlength="60" autocapitalize="off" style="border-radius:9px;padding:11px;width:300px"></div>
    <div>Create Password:</div>
    <div><input name="pass1" type="password"  maxlength="60" style="border-radius:9px;padding:11px;width:300px"></div>
<div><a href="#">View the Terms Of Use</a></div>
<div id="terms" style="display:block;">
      <h4>CloudCare Terms Of Use</h4>
<p>we completely support your right to privacy</p>
<p>This organization is not liable for anything</p>
<p>you agree that digital assets are not commodity or currency</p>
</div>
    <div><button  type="submit" id="signupbtn" style="border-radius:5px">Create Account</button></div>
   <div><span id="status"></span></div>
  </form>
</br>
</br>
</br>
</div>
</body>
<br>
<?php include_once("template_pageBottom.php"); ?>
</html>
