<?php
define("TIME_STARTUP",  microtime(true));
define("WEB_HOST",      $_SERVER['HTTP_HOST']);
define("WEB_ROOT",      dirname($_SERVER['SCRIPT_NAME']));
define("WEB_DISK_ROOT", dirname($_SERVER['SCRIPT_FILENAME']));
define("APP_DISK_ROOT", WEB_DISK_ROOT);
define("APP_ROOT",      APP_DISK_ROOT);
define("WEB_IS_SSL",    $_SERVER['SERVER_PORT']==443?true:false);
define("APP_NAME",      "HouseDaemon");
define("THEME",         "Custom");

error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the " . APP_NAME . " root directory.");
}

require_once("./vendor/autoload.php");
require_once("./vendor/fouroneone/session/FourOneOne/Session/Session.php");
require_once("./src/config/config.php");
require_once("./src/lib/mail.php");

$app = new \Slim\Slim(array(
  'templates.path' => './templates',
));
$session = new \FourOneOne\Session();

require_once("themes/Base/base.inc");
require_once("themes/" . THEME . "/template.inc");

$app->view()->setSiteTitle(APP_NAME);

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);

if(substr($_SERVER['SERVER_NAME'], 0, 4) == 'api.'){
  $mode = 'api';
}else{
  $mode = "web";
}

$file_list = scandir("./src/controllers/{$mode}");
sort($file_list);
foreach($file_list as $file){
  switch($file){
    case '.':
    case '..':
      // Do nothing
      break;
    default:
      require_once("./src/controllers/{$mode}/{$file}");
  }
}


$app->run();