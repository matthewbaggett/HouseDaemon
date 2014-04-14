<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/load/', function () use ($app) {

  $response = new StdClass();
  $response->Status = 'OKAY';

  $load = sys_getloadavg();
  $response->cpu_load = array(
    '1 min' => $load[0],
    '5 min' => $load[1],
    '15 min' => $load[2]
  );

  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
