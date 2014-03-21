<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/exchanges/', function () use ($app) {

  $response = new StdClass();

  $response->Status = 'OKAY';
  ExchangeApi\Valuations::fetch();
  $response->Exchanges = ExchangeApi\Valuations::$valuations;

  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
