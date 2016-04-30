<?php
// Internal get_browser PHP command (requires php.ini pointing to current browscap.ini!)
echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";

$browser = get_browser(null, true);
print_r($browser);

// Loads the internal php_browscap.ini class
require 'inc/Browscap/browscap.inc';

// Loads the screen resolution logic
#require 'inc/Screen-resolution.php';

// Creates a new Browscap object (loads or creates the cache)
$bc = new Browscap('inc/Browscap/cache');

// Gets information about the current browser's user agent
$current_browser = $bc->getBrowser();

// Output the result
echo '<pre>';
print_r($current_browser);
echo '</pre>';
?>

