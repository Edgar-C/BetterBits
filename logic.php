<?
require("php_includes/check_login_status.php");
if($user_ok == true) {
$bytes = random_bytes(40);
$chaz = bin2hex($bytes);
$t = substr($chaz,40,40);
$r = substr($chaz,0,40);
$z = substr($chaz,34,12);
$key = $z;
//echo 't='.$t;
//echo 'and r='.$r;
//create password for them and set key file
//they hit the switch
$hashi = password_hash($t, PASSWORD_BCRYPT);
$pass1 = substr($hashi, -53);
#$tashi = password_hash($r, PASSWORD_BCRYPT);
#$pass2 = substr($tashi, -53);
//insert api cred
$sql = "INSERT INTO api (pass1, pass2, keyfile) VALUES('$pass1','$r','$key')";
$query = mysqli_query($db_conx, $sql);
echo '<center>SAVE YOUR PASSWORDS AND BE CAREFUL WHO YOU SHARE YOR DATA WITH! <br> pass1: '.$t.' <br>pass2: '.$r.'</center>';
echo '<center><br><br> example code: <b>curl -X POST -F "pass1=" -F "pass2=" https://cloudcare.org/api</b><br><p>Do not refresh page</p></center>';
echo '<meta http-equiv="refresh" content="22;url=login">';
//echo $log_username':'$key >> ../rbasef;
$file77 = '../rbasef';
$nu = $log_username.':'.$key.PHP_EOL;
file_put_contents($file77,$nu,FILE_APPEND);
} else {
echo 'you got to be logged in';
include("rere.php");
}
?>
