<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>WebStarter Admin Template - Login</title>

<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" href="css/webstarter-login.css" type="text/css" media="screen" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.vAlign.js"></script>
<script type="text/javascript" src="js/ws.login.init.js"></script>

<!--[if lte IE 6]>

<script type="text/javascript" src="js/jquery.pngFix.js"></script>
<script type="text/javascript" src="js/jquery.pngFix.init.js"></script>

<![endif]-->

</head>

<body>

<div id="bg">
	<div id="core">
		<div id="logo">
			<img src="img/ws_login_logo.png" alt="Logo" />
		</div>

		<div id="box">
			<form name="loginForm" action="validar.php" method="post">
				<div id="pleaseLogin">
					<div id="pleaseLoginLeft">WebStarter:</div>
					<div id="pleaseLoginRight">Please log in to continue</div>
					
					<div class="clear"></div>
				</div>
				
				<div class="space20"></div>

				<div id="userField">
					<input type="text" name="usuario" value="" />
				</div>
				
				<div class="space10"></div>

				<div id="passwordField">
					<input type="password" name="password" value="" />
				</div>
				
				<div class="space10"></div>

				<div id="loginButton">
					<a href="javascript:document.loginForm.submit();"><img src="img/ws_login_button.png" alt="Login" title="Login" /></a>
				</div>

				<div id="forgottenPassword">
					<a href="#lostPassword">Lost your password?</a>
				</div>

				<div class="clear"></div>

				<input type="submit" style="display: none;" />
			</form>
		</div><!-- END OF #box -->
	</div><!-- END OF #core -->
</div><!-- END OF #bg -->

</body>
</html>