<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/auth/:api_key', function ($api_key) use ($app) {

  $response = new StdClass();
  $api = \LoneSatoshi\Models\ApiKey::search()
    ->where('api_key', $api_key)
    ->where('revoked', 'No')
    ->execOne();
  if($api instanceof \LoneSatoshi\Models\ApiKey){
    $session = $api->create_session();
    $response->Status = 'OKAY';
    $response->Session = $session->get_session_array();
  }else{
    $response->Status = 'FAIL';
    $response->FailureMessage = 'API key not valid';
  }

  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
