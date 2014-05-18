<?php
require_once("bootstrap.php");

// Initialise app.
$app = new \Slim\Slim(array(
  'templates.path' => './templates',
));
$session = new \FourOneOne\Session();
$app->view()->setSiteTitle(APP_NAME);
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
$app->run();