<?php

define("TIME_STARTUP", microtime(true));
define("APP_ROOT", dirname(__FILE__));
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the Sous root directory.");
}

require_once("./vendor/autoload.php");
require_once("./vendor/fouroneone/session/FourOneOne/Session/Session.php");
require_once("./src/config/config.inc");

$app = new \Slim\Slim(array());

$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);

require_once("./src/controllers/servers.php");
require_once("./src/controllers/tests.php");

$app->run();