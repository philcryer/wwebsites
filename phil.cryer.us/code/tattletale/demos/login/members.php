<?php 
	require_once('settings.php');
	checkLogin('1 2');

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
			<?php if ( isset( $error ) ) { echo '                   <p class="error">' . $error . '</p>' . "\n";}?>
			        </div>


				<!--    <div id="container" style="width:230px;">-->
				<div class="Container">
				  <div id="Dialog">

				       <!--           <form class="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">-->
						          <dl>



<?php
	echo 'Welcome ' . get_username ( $_SESSION['user_id'] ) . ' - you have successfully logged in. You may do the following:<br /><br /><a href="update_profile.php" title="update your profile">update your profile</a>';
	
	
	/* we show the manage users link only if the logged in member has admin rights */
	if ( isadmin ( $_SESSION['user_id'] ) ):
?>
	<br /><br />
	It seems that you're an admin. You may <a href="manage_users.php" title="manage users">manage users</a> or <a href="admin_settings.php" title="edit site settings">edit site settings</a>.
<?php
	endif;
?>
	<br /><br />
	<a href="sniffer.html" title="sniffer">sniff browser details</a>
	<br /><br />
	
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
