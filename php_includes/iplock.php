<?
#put this include after a db_conx in account.php to thawrt random ip address attacks on session
$ip1 = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
#require_once("db_conx.php");
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
$ip = $row["ip"];
}
if($ip != $ip1) {
        session_unset();
        session_destroy();
header("location: login");
        exit;
}
?>
