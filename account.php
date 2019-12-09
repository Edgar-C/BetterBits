<?php
require("php_includes/check_login_status.php");
if($user_ok == false) {
header('location: lost');
exit();
}
require("timedoh.php");
$u = "";
$userlevel = "";
$joindate = "";
$lastsession = "";
$ip = "";
if(isset($_GET["u"])){
$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} 
require_once("db_conx.php");
$sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
echo "username".$u." is not yet actived";
    exit();	
}
$isOwner = "no";
if($u == $log_username && $user_ok == true){
$isOwner = "yes";
}
else
{
echo "nah";
exit;
}
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
$profile_id = $row["id"];
$userlevel = $row["userlevel"];
$signup = $row["signup"];
$lastlogin = $row["lastlogin"];
$ip = $row["ip"];
$adr = $row["adder"];
$bcoin = $row["sumd"];
}
?>
<!DOCTYPE html>
<html>
<link rel="icon" type="image/png" href="favicon.png">
<head>
<meta http-equiv="refresh" content="700;url=login">
<meta charset="UTF-8">
<title><?php echo $u; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style>
    position :fixed;
    animation: jack 5.4s infinite;
animation-iteration-count: 1;
#nasti {
    position :relative;
    animation: stack .3s infinite;
animation-iteration-count: 1;
}
@keyframes stack {
  from { opacity: 0}
  to   { opacity: 1}
}
#switch {
    position :fixed;
    animation: jack 1.4s infinite;
animation-iteration-count: 1;
}
@keyframes jack {
  from { opacity: 0}
  to   { opacity: .96}
}
.lightbox .blur {
background-color: gray;
position: fixed;
z-index: 1;
top: 0px;
left: 0px;
width: 100%;
height: 100%;
opacity: .96;
}

.lightbox .box {
    height: 400px;
	width: -webkit-min-content;
    width: -moz-min-content;
    width: min-content;
        min-width:600px;
    margin: 2% auto;
    padding:20px;
    background-color:#b1b1b1;
    box-shadow: 0 0 10000px #fff7f7;
position:relative;
z-index: 9;
border-radius: 11px
}
.lightbox .title {
        margin:0;
        padding:0 0 10px 0px;
        border-bottom:1px #ccc solid;
        font-size:22px;
}
.lightbox .content {
        display:block;
        padding:12px 0 0 0px;
        font-size:28px;
        line-height:24px;
}
.lightbox .close {
        float:right;
        display:block;
        text-decoration:none;
        font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size:22px;
        color:#858585;
}
.lightbox {
    /** Hide the lightbox */
    display: none;
    /** Apply basic lightbox styling */
    position: fixed;
    z-index: 9999;
    width: 100%;
    height: 60%;
    top: 0;
    left: 0;
    color:#333333;
}
  .lightbox:target {
    /** Show lightbox when it is target */
    display: block;
    outline: none;
}
</style>
<script src="js/stuntn.js"></script>
<script src="js/good.js"></script>
</head>
<body style='background-color:black' id='nasti'>
<?php  include_once("template_pageTop.php");  ?>
<div id="bod">
<br>
  <p style='color:green;font-size:26px;'>Bits: <?php echo $bcoin; ?></p>
<br>
<?php 
require("derder.php");
?>
<br>
<br>
<p style='color:green;font-size:20px;'>Address: <?php echo $adr;?></p>
<br>
<a href='<?php echo $u;?>'><img src='<?php echo $u;?>'></img></a>
</div>
<div style="" class="lightbox" id="switch">
<div class="blur"></div>    
<br>
<br>
<div class="box">
        <a class="close" href="#">x</a>
       <center> <p class="title">Change Password</p> </center>
        <div class="content">
<?php
require_once("upidi.php");
?>
        </div>
    </div>
</div>
<div>   
<form action = "addadr.php" method = "post" style="position:fixed;z-index:1">
<input style='border-radius:11px;padding:7px' type="submit" name="Get" value="Get Address" />
    </form>
</div>
</body>
<?php 
include_once("template_pageBottom.php");
?>
</html>
