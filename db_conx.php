<?php
$db_conx = mysqli_connect('localhost', 'root', 'Random_Pass', 'usracc');
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>
