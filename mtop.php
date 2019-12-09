<?php
session_start();
include_once("php_includes/check_login_status.php");
$loginLink = '<a href="signup">Signup</a> &nbsp; | &nbsp; <a href="login">Login</a>';
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
