<?
//if($_SERVER["HTTPS"] != "on") {
// $pageURL = "Location: https://";
// if ($_SERVER["SERVER_PORT"] != "80") {
// $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
// } else {
//  $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
// }
// header($pageURL);
//}
//require_once("php_includes/check_login_status.php");
//if($user_ok == false) {
//header("location: logout");
//exit();
//}
$sql = "SELECT * FROM users WHERE username='$log_username' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
$lastlogin = $row["lastlogin"];
$time1 = strtotime($lastlogin);
$killatime = ($time1 + 19999);
$nowt = time();
if($nowt > $killatime) {
        session_unset();
        session_destroy();
header("location: logout");
}
}
?>
