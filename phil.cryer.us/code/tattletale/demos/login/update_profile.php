<?php 
	require_once('settings.php');
	checkLogin('1 2');
	
	$query = "SELECT * FROM `" . DBPREFIX . "users` WHERE `ID` = " . $db->qstr ( $_SESSION['user_id'] );
	$row = $db->getRow ( $query );
	
	if ( array_key_exists ( '_submit_check', $_POST ) )
	{
		if ( valid_email ( $_POST['email'] ) )
		{			
			$update = "UPDATE " . DBPREFIX . "users SET Email = " . $db->qstr ( $_POST['email'] );
			
			//do we allow users to change their usernames
			if ( ALLOW_USERNAME_CHANGE ) {
				$update .= ", Username = " . $db->qstr ( $_POST['username'] );
			}
			
			//if we have a new password via POST we update the old one
			if ( $_POST['password'] != '' ):
				$update .= ", Password = " . $db->qstr ( md5 ( $_POST['password'] ) );
			endif;
			
			$update .= " WHERE ID = " . $db->qstr ( $_SESSION['user_id'] );
			
			if ( $db->query ( $update ) )
			{
				$msg = 'Your profile was successfully updated!';
			}
			else {
				$error = 'I was unable to save your profile. Please contact the administrator at ' . ADMIN_EMAIL;
			}			 
		}
		else {
			$error = 'Invalid email address';
		}
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Project Tattletale - user authentication and login demo</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
</head>



<!--<body>-->
<body class="login" onload="document.forms[0].elements[0].focus();">
	<div id="log">
<?php	if ( isset ( $error ) )	{ echo '			<p class="error">' . $error . '</p>' . "\n";	}	?>
<?php	if ( isset ( $msg ) )	{ echo '			<p class="msg">' . $msg . '</p>' . "\n";	}	?>
	</div>
	
<div class="Container">
  <div id="Dialog">
	<form class="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="_submit_check" value="1"/> 

<dl>
    		<dt>Username:</dt>
			<dd><input type="hidden" name="_submit_check" value="1"/></dd>
			<div style="margin-top:12px; margin-bottom:10px">
		<input class="input" type="text" id="username" name="username" size="32" <?php if ( ! ALLOW_USERNAME_CHANGE ): echo 'disabled'; endif; ?> value="<?=$row->Username?>" />
			</div>
			
		<dt>Password:</dt>
			<div style="margin-top:12px; margin-bottom:10px">
		<input class="input" type="password" id="password" name="password" size="32" value="<?=$row->Password?>" />
	</div>	
		<dt>Email:</dt>
			<div style="margin-top:12px; margin-bottom:10px">
		<input class="input" type="text" id="email" name="email" size="32" value="<?=$row->Email?>" />
		</div>
		
		                        <dd><input type="image" name="Login" value="Login"  class="submit-btn" src="images/submit.jpg" alt="Submit" title="submit" /></dd>

		<div class="clear"></div>
					
	</form>
	
	<a href="logout.php">logout</a>
	 </dl>
	 </form>

	                                   </div>


	
  <div id="footer">
	<small>&copy;2007 Project Tattletale&nbsp;&nbsp;&nbsp;</small>
  </div>
	</div>
	
</body>

</html>
