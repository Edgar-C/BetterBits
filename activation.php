<?php
//if (isset($_GET['id']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
if (isset($_GET['e'])) {
// Connect to database and sanitize incoming $_GET variables
    include_once("php_includes/db_conx.php");
        $e = mysqli_real_escape_string($db_conx, $_GET['e']);
        // Evaluate the lengths of the incoming $_GET variable
        if(strlen($e) < 5){
                // Log this issue into a text file and email details to yourself
                header("location: message?mes=activation_string_length_issues");
        exit();
        }
        // Check their credentials against the database
        $sql = "SELECT * FROM users WHERE email='$e' LIMIT 1";
  $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
        // Evaluate for a match in the system (0 = no match, 1 = match)
        if($numrows == 0){
                // Log this potential hack attempt to text file and email details to yourself
                header("location: mes?mes=Your credentials are not matching anything in our system");
        exit();
        }
        $sql = "UPDATE users SET activated='1' WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
        $sql = "SELECT * FROM users WHERE email='$e' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
        $numrows = mysqli_num_rows($query);
    if($numrows == 0){
        header("location: mes?mes=activation_failure");
   exit();
    } else if($numrows == 1) {
        header("location: mes?mes=activation_success");
        exit();
    }
} else {
        header("location: mes?mes=missing_GET_variables");
    exit();
}
?>
<meta http-equiv="refresh" content="4;url=bb#m">
