<?php
ob_start();

// ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
// ini_set('display_errors', 'Off');
// ini_set('log_errors', 'On');
// ini_set('error_log', 'path/to/errors.log');

// define site paths
define('PRIVATE_PATH', __DIR__);
define('PROJECT_PATH', dirname(PRIVATE_PATH));
define('PUBLIC_PATH', PROJECT_PATH . '/public');
define('SHARED_PATH', PRIVATE_PATH . '/shared');

// dynamically define WWW_ROOT
$string_root_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$www_root = substr($_SERVER['SCRIPT_NAME'], 0, $string_root_end);
define('WWW_ROOT', $www_root);

// connect to the database (create database handler)

// include functions
require_once('functions.php');
require_once('validation_functions.php');
require_once('security_functions.php');
require_once('db_credentials.php');

// include classes manually
require_once('classes/database.class.php');
require_once('classes/database_object.class.php');
require_once('classes/user.class.php');
require_once('classes/session.class.php');
require_once('classes/driver.class.php');
require_once('classes/vehicle.class.php');
require_once('classes/upload_file.class.php');


// include classes dinamically
// define my_autoload func. to include all files(classes) from folder classes/*.class.php
function my_autoload($class) {
	if(preg_match('/\A\w+\Z/', $class)) {
		require_once(PRIVATE_PATH . '/classes/' . $class . '.class.php');
	}
}

// register my autoload function
spl_autoload_register('my_autoload');

$db = new Database();
//var_dump($db);
DatabaseObject::set_database($db);
$session = new Session();
$errors = [];
$message = [];