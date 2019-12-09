<?php
include_once("php_includes/check_login_status.php");
if($user_ok == false) {
header("location: login");
exit();
}
if($_POST['ass1'] === "") {
header("location: login");
}
#require("timedoh.php");
if($_POST['ass1']){
$siom = preg_replace('[-]', '',$_POST["ass1"]);
$com = preg_replace('[;]', '',$siom);
$qes = $_SESSION['username'];
include_once("db_conx.php");
$sql = "SELECT * FROM users WHERE username='$qes'";
$query = mysqli_query($db_conx, $sql);
while($row = mysqli_fetch_array($query)) {
$david = $row["sumd"];
}
if($david < $com) {
echo '<center>insuffient funds</center><meta http-equiv="refresh" content="5;url=login">';
exit;
} else {
$pom = mysqli_real_escape_string($db_conx, $com);
$sql = "UPDATE users SET sumd = sumd - ".$pom." WHERE username='$qes'";
$query = mysqli_query($db_conx, $sql);
shell_exec("bash /var/www/actuator $qes");
if($_POST['ass2']) {
$snapso = $_POST["ass2"];
$rom = preg_replace('[;]', '',$snapso);
$ding = strlen($rom);
if($ding == 34) {
$benten = 'burntcha';
file_put_contents($benten,$rom.','.$com);
//UPDATE users SET sumd = sumd - .00005 WHERE username='$qes'";
header("location: login");
//echo $rom.$com;
exit;
} else {
//search $rom update keyfile if exist
$sql = "UPDATE users SET sumd = sumd + ".$pom." WHERE username='$rom'";
$query = mysqli_query($db_conx, $sql);
shell_exec("bash /var/www/actuator $rom");
//echo $rom;
//exit;
header("location: message?mes=".$pom." sent successfully to ".$rom);
exit;
}
}
}
}
?>
<div>  
<form action="derder" method="post">
 <div style="color:green;-moz-inline-stack;font-color:green">Amount:</div><br>
    <input style='background-color:black;color:green;border-radius:11px;padding:13px;padding-right:300px' autocapitalize="off" type="decimal" name="ass1" maxlength="10" autofocus><br><br>
    <br />
     <div style="display: -moz-inline-stack;color: green;">To:</div><br>
    <input style='background-color:black;color:green;border-radius:11px;padding:13px;padding-right:300px' autocapitalize="off" type="text" name="ass2" maxlength="34">
<br>
    <button style='color:green;border-radius:11px;padding:15px;padding-left:30px;padding-right:30px' id="updator" type='submit'>Send</button> 
  </form>
</div>
