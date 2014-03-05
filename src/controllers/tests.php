<?php
$app->map('/tests/run', function () use ($app) {
  $response = new response();

  foreach(test_server_model::search()->exec() as $test_server){
    /* @var $test_server test_server_model */
    $test_server->run();
  }

  $response->json();
})->via('GET', 'POST');
