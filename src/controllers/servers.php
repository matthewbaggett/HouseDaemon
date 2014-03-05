<?php
$app->map('/servers/list', function () use ($app) {
  $response = new response();
  $response->servers = server_model::search()->where('deleted', 'no')->where('private', 'no')->exec();
  $response->json();
})->via('GET', 'POST');
