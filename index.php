<?php

define("TIME_STARTUP", microtime(true));
define("WEB_HOST", $_SERVER['HTTP_HOST']);
define("WEB_ROOT", dirname($_SERVER['SCRIPT_NAME']));
define("WEB_DISK_ROOT", dirname($_SERVER['SCRIPT_FILENAME']));
define("APP_DISK_ROOT", WEB_DISK_ROOT . "/../");
define("APP_ROOT", APP_DISK_ROOT);
define("WEB_IS_SSL", $_SERVER['SERVER_PORT']==443?true:false);
define("APP_NAME", "LoneSatoshi");
define("THEME", "LoneSatoshi");

error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the Sous root directory.");
}

require_once("./vendor/autoload.php");
require_once("./vendor/fouroneone/session/FourOneOne/Session/Session.php");
require_once("./src/config/config.php");

$app = new \Slim\Slim(array(
  'templates.path' => './templates',
));
$session = new \FourOneOne\Session();

require_once("themes/Base/base.inc");
require_once("themes/" . THEME . "/" . THEME . ".inc");

$app->view()->setSiteTitle(APP_NAME);

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);

require_once("./src/controllers/dashboard.php");
require_once("./src/controllers/index.php");
require_once("./src/controllers/login.php");
require_once("./src/controllers/servers.php");
require_once("./src/controllers/tests.php");

$app->run();