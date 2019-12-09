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
if(isset($_SESSION["username"])){
	header("location: login");
    exit();
}
include_once("db_conx.php");
if(isset($_POST["usernamecheck"])){
$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 5 || strlen($username) > 16) {
   echo '<h4><strong style="color:#F00;">5 - 16 characters please</strong></h4>';
   exit();
    }
if (is_numeric($username[0])) {
   echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
   exit();
    }
    if ($uname_check < 1) {
   echo '<h1><strong style="color:#009900;">' . $username . ' is OK</strong></h1>';
   exit();
    } else {
   echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
   exit();
    }
}
if(isset($_POST["u"])){
$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
$e = mysqli_real_escape_string($db_conx, $_POST['e']);
$p = $_POST['p'];
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
        echo "That Handle is already taken";
        exit();
} else if ($e_check > 0){ 
        echo "that Credential is already in use";
        exit();
} else if (strlen($u) < 5 || strlen($u) > 16) {
        echo "Handles must be between 5 and 16 char";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Handles cannot begin with a number';
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
<head>
<title>Sign Up</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
div#fadeout{
        opacity: 1;
	position: fixed;
	z-index:10;
	top: 60px;
	width: 100%;    
}
div#fadeout > div#faden {
	color:#FFF;
}
#signupform{
margin-top:-100px;	
background-radius: 11px;
}
title {
	font-size: 25px;
}
p {margin: 0;
text-align: center;
}
h5 {
margin-top: 1;
text-align: center;
font-size: 80px;
}
h4 {
text-align: center;
font-size: 40px;
margin: 0px;
padding-bottom: 7px;
}
#signupform > div {
margin-top: 20px;
text-align: center;	
border-radius: 11px;
}
#signupform > div > input {
border-radius: 11px;
margin: 0px;
width: 95%;
padding: 40px;
background: #F3F9DD;
text-align: center;
font-size: 20px;
}
#signupform > input,select {
margin: 0px;
width: 95%;
padding: 60px;
background: #F3F9DD;
text-align: center;
border-radius: 11px;
}
#signupbtn {
font-size:18px;
padding: 20px;
border-radius: 9px;
}
#terms {
border:#CCC 1px solid;
background: #black;
padding: 8px;
}
.tip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tip .tipt {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}

.tip:hover .tipt {
    visibility: visible;
}
</style>
<script src="js/valve.js"></script>
<script src="js/pipe.js"></script>
<script>
function restrict(elem){
var zap = _(elem);
var pop = new RegExp;
if(elem == "private"){
zap = /[' "]/gi;
} else if(elem == "name"){
zap = /[^a-z0-9]/gi;
}
pop.value = pop.value.replace(zap, "");
}
function emptyElement(z){
_(z).innerHTML = "";
}
function checkname(){
var u = _("name").value;
if(u != ""){
_("unamestatus").innerHTML = 'Working! ...';
var ajax = ajaxObj("POST", "msignup.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           _("unamestatus").innerHTML = ajax.responseText;
       }
        }
        ajax.send("usernamecheck="+u);
}
}
function signup(){
var u = _("name").value;
var e = _("private").value;
var p1 = _("pass1").value;
var status = _("status");
if(u == "" || p1 == "" || e == ""){
status.innerHTML = "missing form data";
} else if( _("terms").style.display == "none"){
status.innerHTML = "View the terms of use";
} else {
_("signupbtn").style.display = "none";
status.innerHTML = 'Wait ...';
var ajax = ajaxObj("POST", "msignup.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           if(ajax.responseText != "signup_success"){
status.innerHTML = ajax.responseText;
_("signupbtn").style.display = "none";
} else {
window.scrollTo(0,0);
_("signupform").innerHTML = "blank";
}
       }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1);
}
}
function openTerms(){
_("terms").style.display = "block";
emptyElement("status");
}
</script>
<noscript>
<meta http-equiv="refresh" content="0;url=sign1up">
</noscript>
<?php require_once("mpgTp.php"); ?>
</head>
<body style="background-color: rgb(54, 65, 51);">
<h5 style="color:#1f2c22">Create</h5>
  <form name="signupform" id="signupform" onsubmit="return false">
<center>   <div class="tip">Public Handle:<span class="tipt">An easy to remember name/address for receiving bitcoin</span>
</div></center>
    <div> <input style="border-radius:11px" id="name" type="text" onblur="checkname()" onkeyup="restrict('username')" maxlength="30" autocapitalize="off" autofocus></div>
    <div><span style="color:#038d03" id="unamestatus"></span></div>
    <div>First Password</div>
    <div><input id="private" type="text" onfocus="emptyElement('status')" maxlength="60" autocapitalize="off"></div>
    <div>Second Password:</div>
    <div><input id="pass1" type="password" onfocus="emptyElement('status')" maxlength="60"></div>
<div><a href="#" onclick="openTerms()" onmousedown="openTerms()" style="color:orange;font-size:30px">View the Terms Of Use</a></div>
<div id="terms" style="display:none;">
      <h4>CloudCare Terms Of Use</h4>
<p>we completely support your right to privacy</p>
<p>This organization is not liable for anything</p>
<p>you agree that digital assets are not commodity or currency</p></h3>
</div>
 <div><button  id="signupbtn" onclick="signup()">Create Account</button></div>
<div><span id="status"></span></div>
  </form>
</br>
</br>
</br>
</div>
</div>
</div>
</body>
<br>
<?php include_once("template_pageBottom.php"); ?>
</html>
