<?php
	require_once('settings.php');

	if ( array_key_exists ( '_submit_check', $_POST ) )
	{
		if ( $_POST['username'] != '' && $_POST['password'] != '' && $_POST['password'] == $_POST['password_confirmed'] && $_POST['email'] != '' && valid_email ( $_POST['email'] ) == TRUE )
		{
			if ( ! checkUnique ( 'Username', $_POST['username'] ) )
			{
				$error = 'Username already taken. Please try again!';
			}
			elseif ( ! checkUnique ( 'Email', $_POST['email'] ) )
			{
				$error = 'The email you used is associated with another user. Please try again or use the "forgot password" feature!';
			}
			else {		
				$query = $db->query ( "INSERT INTO " . DBPREFIX . "users (`Username` , `Password`, `date_registered`, `Email`, `Random_key`) VALUES (" . $db->qstr ( $_POST['username'] ) . ", " . $db->qstr ( md5 ( $_POST['password'] ) ).", '" . time () . "', " . $db->qstr ( $_POST['email'] ) . ", '" . random_string ( 'alnum', 32 ) . "')" );
				
				$getUser = "SELECT ID, Username, Email, Random_key FROM " . DBPREFIX . "users WHERE Username = " . $db->qstr ( $_POST['username'] ) . "";
		
				if ( $db->RecordCount ( $getUser ) == 1 )
				{			
					$row = $db->getRow ( $getUser );
					
					$subject = "Activation email from " . DOMAIN_NAME;

					$message = "Dear ".$row->Username.", this is your activation link to join our website. In order to confirm your membership please click on the following link: <a href=\"" . APPLICATION_URL . "confirm.php?ID=" . $row->ID . "&key=" . $row->Random_key . "\">" . APPLICATION_URL . "confirm.php?ID=" . $row->ID . "&key=" . $row->Random_key . "</a> <br /><br />Thank you for joining";
					
					if ( send_email ( $subject, $row->Email, $message ) ) {
						$msg = 'Account registered. Please check your email for details on how to activate it.';
					}
					else {
						$error = 'I managed to register your membership but failed to send the validation email. Please contact the admin at ' . ADMIN_EMAIL;
					}
				}
				else {
					$error = 'User not found. Please contact the admin at ' . ADMIN_EMAIL;
				}
			}							
		}
		else {		
			$error = 'There was an error in your data. Please make sure you filled in all the required data, you provided a valid email address and that the password fields match one another.';	
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Project Tattletale - user authentication and login demo</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
</head>










<body class="login" onload="document.forms[0].elements[0].focus();">
	<div id="log">



<?php	if ( isset ( $error ) )	{ echo '			<p class="error">' . $error . '</p>' . "\n";	}	?>
<?php	if ( isset ( $msg ) )	{ echo '			<p class="msg">' . $msg . '</p>' . "\n";	} else {//if we have a mesage we don't need this form again.?>
	</div>




<div class="Container">
  <div id="Dialog">


	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">






	<dl>
    		<dt>Username:</dt>
		<dd><input type="hidden" name="_submit_check" value="1"/> </dd>
			<div style="margin-top:12px; margin-bottom:10px">
		<input class="input" type="text" id="username" name="username" size="32" value="<?php if(isset($_POST['username'])){echo $_POST['username'];}?>" />
		</div>
		


			<div style="margin-bottom:6px">
    		<dt>Password:</dt>
			<dd><input class="input" type="password" name="password" id="password" size="25" maxlength="32" value=""/></dd>
			</div>

			<div style="margin-bottom:6px">
    		<dt>Password:</dt>
			<dd> <input class="input" type="password" name="password_confirmed" id="password_confirmed" size="25" maxlength="32" value="" /></dd>
			</div>

			<div style="margin-bottom:6px">
    		<dt>Email:</dt>
			<dd><input class="input" type="text" id="email" name="email" size="25" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" /></dd>
			</div>
		
		
			<dd><input type="image" name="Login" value="Login"  class="submit-btn" src="images/submit.jpg" alt="Submit" title="submit" /></dd>
		<div class="clear"></div>
	</dl>
	</form>
  <div id="footer">
	<small>&copy;2007 Project Tattletale&nbsp;&nbsp;&nbsp;</small>
  </div>
	</div>
<? } ?>
</body>
</html>
