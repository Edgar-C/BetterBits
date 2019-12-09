<?php
session_start();
require("db_conx.php");
$user_ok = false;
$log_id = "";
$log_email = "";
$log_username = "";
$log_password = "";
// User Verify function
function evalLoggedUser($db_conx,$id,$e,$p,$u) {
        $sql = "SELECT * FROM users WHERE id='$id' AND email='$e' AND password='$p' AND username='$u' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
        if($numrows > 0){
                return true;
        }
else { echo 'false'; exit();
}
}
if(isset($_SESSION["userid"]) && isset($_SESSION["email"]) && isset($_SESSION["password"])) {
        $log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
        $log_email = preg_replace('#[^a-z0-9]#i', '', $_SESSION['email']);
        $log_password = preg_replace('#[^a-z0-9$./]#i', '', $_SESSION['password']);
        $log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
        // Verify the user
        $user_ok = evalLoggedUser($db_conx,$log_id,$log_email,$log_password,$log_username);
}
?>
