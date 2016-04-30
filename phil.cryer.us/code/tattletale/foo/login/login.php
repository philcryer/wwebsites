<?php
	require_once ( 'settings.php' );

	if ( array_key_exists ( '_submit_check', $_POST ) )
	{
		if ( $_POST['username'] != '' && $_POST['password'] != '' )
		{
			$query = 'SELECT ID, Username, Active, Password FROM ' . DBPREFIX . 'users WHERE Username = ' . $db->qstr ( $_POST['username'] ) . ' AND Password = ' . $db->qstr ( md5 ( $_POST['password'] ) );

			if ( $db->RecordCount ( $query ) == 1 )
			{
				$row = $db->getRow ( $query );
				if ( $row->Active == 1 )
				{
					set_login_sessions ( $row->ID, $row->Password, ( $_POST['remember'] ) ? TRUE : FALSE );
					header ( "Location: " . REDIRECT_AFTER_LOGIN );
				}
				elseif ( $row->Active == 0 ) {
					$error = 'Your membership was not activated. Please open the email that we sent and click on the activation link.';
				}
				elseif ( $row->Active == 2 ) {
					$error = 'You are suspended!';
				}
			}
			else {		
				$error = 'Login failed!';		
			}
		}
		else {
			$error = 'Please use both your username and password to access your account';
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Project Tattletale - user authentication and login demo</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
</head>
<!--<body>-->
<body class="login" onload="document.forms[0].elements[0].focus();">

	<div id="log">
<?php if ( isset( $error ) ) { echo '			<p class="error">' . $error . '</p>' . "\n";}?>
	</div>


<!--	<div id="container" style="width:230px;">-->
<div class="Container">
  <div id="Dialog">

		<form class="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<dl>
    		<dt>Username:</dt>
			<dd><input type="hidden" name="_submit_check" value="1"/></dd>
			<div style="margin-top:12px; margin-bottom:10px">
				<input class="input" type="text" name="username" id="username" size="25" maxlength="40" value="" />
			</div>
			<div style="margin-bottom:6px">
    		<dt>Password:</dt>
			<dd><input class="input" type="password" name="password" id="password" size="25" maxlength="32" /></dd>
			</div>

			<?php if ( ALLOW_REMEMBER_ME ):?>
<!--			<div style="margin-bottom:6px">--><div>
			<!--	<input type="checkbox" name="remember" id="remember" />
				<label for="remember">Remember me</label>-->
			      		<dd><input name="remember" value="1" type="checkbox"> Remember me</dd>
			<!--	<br class="clear" />-->
			</div>
			<?php endif;?>
			<dd><input type="image" name="Login" value="Login"  class="submit-btn" src="images/submit.jpg" alt="Submit" title="submit" /></dd>
		<dd><a href="register.php">Register</a> / <a href="forgot_password.php">Forgot password?</a></dd>
			
	</dl>
		</form>
		
  </div>
  <div id="footer">
	<small>&copy;2007 Project Tattletale&nbsp;&nbsp;&nbsp;</small>
  </div>
	</div>
	
</body>

</html>
