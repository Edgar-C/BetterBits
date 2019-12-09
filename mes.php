<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="10;url=login">
<noscript>
<meta http-equiv="refresh" content="10;url=login">
</noscript>
</head>
<body>
<?php
$message = "";
$mes = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['mes']);
if($mes == "activation_failure"){
	$message = '<h2>Activation Error</h2> Sorry there seems to have been an issue activating your account at this time. We have already notified ourselves of this issue and we will contact you via email when we have identified the issue.';
} else if($mes == "activation_success"){
	$message = '<h2>Activation Success</h2> Your account is now activated. <a href="donate">how to support the technology</a>';
} else {
	$message = $mes;
}
?>
<div><?php echo $message; ?></div>
</body>
</html>
