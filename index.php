<?php
require_once("bootstrap.php");

// Initialise app.
$app = new \Slim\Slim(array(
  'templates.path' => './templates',
));
$session = new \FourOneOne\Session();

// Load Theme
require_once("themes/Base/base.inc");
require_once("themes/" . THEME . "/template.inc");

// Load all controllers.
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

$app->view()->setSiteTitle(APP_NAME);
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
$app->run();