<?php
/**
* Your Twitter App Info
*/
if(function_exists('ini_set')){

	ini_set('display_errors',0);
}    
// Consumer Key
define('CONSUMER_KEY', 'lWJqxyFIBTGQ1VTOC9GskA');
define('CONSUMER_SECRET', 'X52rrmbjHLDwGJu7VjzuJgtPfmE5kt3W3HSeTXHwc');
// User Access Token
define('ACCESS_TOKEN', '1139429131-KVEYkdtIRA915cmW5hxXfHizo5jiUIrHIgTNULh');
define('ACCESS_SECRET', 'ZlFa7jtqjM2B0w2A7ZnevOLZ2YwHWNB0vRH3uQugc8c');
if ( !defined('ABSPATH') ){
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
define('ABSPATH', $path_to_wp);
}
require_once(ABSPATH."/wp-config.php");
?>    