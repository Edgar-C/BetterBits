<?
$sql = "SELECT * FROM users WHERE username='$log_username' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
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
