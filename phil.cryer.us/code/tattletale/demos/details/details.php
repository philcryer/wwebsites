<?php include("inc/computer_info.js"); ?>
<?php include("inc/browser_detection.php"); ?>
<?php
echo ( browser_detection( 'number' ) .'<br>'. 
browser_detection( 'browser' ) .'<br>'.  
browser_detection( 'ie_version' ) .'<br>'.
browser_detection( 'moz_version' ) .'<br>'.
browser_detection( 'moz_version_number' ) .'<br>'.
browser_detection( 'os' ) .'<br>'.  
browser_detection( 'os_number' ) .'<br>'.
browser_detection( 'safe_browser' ) .'<br>'.

browser_detection( 'dom' ) .'<br>'.
browser_detection( 'safe' ) .'<br>'.

browser_detection( 'a_os_data' ) .'<br>'.
browser_detection( 'browser_name' ) .'<br>'.
browser_detection( 'version_number' ) .'<br>'.
browser_detection( 'math_version_number' ) .'<br>'.
browser_detection( 'moz_rv' ) .'<br>'.
browser_detection( 'moz_rv_full' ) .'<br>'.
browser_detection( 'moz_release' ) .'<br>'.
browser_detection( 'b_success' ) .'<br>'.
browser_detection( 'browser_user_agent' ) .'<br>'.

browser_detection( 'type' ) );
?>
