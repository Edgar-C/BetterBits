<?php
#session_start();
if($_SERVER['REQUEST_URI'] == '/mlogin') {
$loginLink = '<h3><a href="signup">Signup</a></h3>';
} else {
$loginLink = '<h3><a style="font-size:40px" href="login">Login</a></h3>';
}
include_once("php_includes/check_login_status.php");
if($user_ok == true) {
$envelope = '<a href="#text" title="Settings"><img src="" width="22" height="12" alt="Settings"></a>';
$loginLink = '<a href="login">'.$log_username.'</a> &nbsp; | &nbsp; <a href="logout">Log Out</a>';
}
?>
<div id="pgTp">
  <div id="pgTprap">
    <div id="Lego">
   <!--   <a href="https://cloudcare.org"> -->
        <img src="images/logo.png" >
      </a>
    </div>
    <div id="pgTpspc">
<div id="nu1">
        <div>
          <?php echo $envelope; ?> &nbsp; &nbsp; <?php echo $loginLink; ?>
        </div>
      </div>
<div id="nu2">
<div>
        </div>
      </div>
    </div>
  </div>
</div>
