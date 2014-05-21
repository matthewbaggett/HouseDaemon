<?php
define("TIME_STARTUP",  microtime(true));
define("APP_ROOT",      dirname($_SERVER['SCRIPT_FILENAME']));
if(php_sapi_name() != 'cli'){
  // Web
  define("WEB_HOST",      $_SERVER['HTTP_HOST']);
  define("WEB_ROOT",      dirname($_SERVER['SCRIPT_NAME']));
  define("WEB_DISK_ROOT", APP_ROOT );
  define("WEB_IS_SSL",    $_SERVER['SERVER_PORT']==443?true:false);
}else{
  // CLI
  define("CYCLE_SLEEP", 500000); // 0.5 seconds
}
define("APP_DISK_ROOT", APP_ROOT);
define("APP_NAME",      "HouseDaemon");
define("THEME",         "Custom");

// Set up error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set up database.

define("DATABASE_TYPE", "Mysql");
define("DATABASE_PORT", "3306");
define("DATABASE_USER", "housedaemon");
define("DATABASE_PASS", "YZur4BBjSRhHeMru");
define("DATABASE_DB", "housedaemon");

switch(gethostname()){
  case 'Surrey.local':
    define("DATABASE_HOST", "25.72.204.22");
    break;

  default:
    define("DATABASE_HOST", "localhost");
    break;
}

// Database Settings
$database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
  'db_type'     => DATABASE_TYPE,
  'db_hostname' => DATABASE_HOST,
  'db_port'     => DATABASE_PORT,
  'db_username' => DATABASE_USER,
  'db_password' => DATABASE_PASS,
  'db_database' => DATABASE_DB
));

// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
$mailer_transport = Swift_SmtpTransport::newInstance('mailserver.example.com', 465, 'ssl')
  ->setUsername('example@example.com')
  ->setPassword('password')
;
$mailer_from = array("system@example.com" => "Example");
$mailer_default_to = array("you@example.com");
