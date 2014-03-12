<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/balances/:session_key', function ($session_key) use ($app) {

  $response = new StdClass();
  $session = \LoneSatoshi\Models\ApiSession::load($session_key);

  if(!$session->get_api_key() instanceof \LoneSatoshi\Models\ApiKey){
    $response->Status = 'FAIL';
    $response->FailureMessage = 'API key not valid or API session expired';
  }else{
    $response->Status = 'OKAY';
    $response->Session = $session->get_session_array();
    $response->BalancesConfirmed = \LoneSatoshi\Models\BalanceConfirmed::search()
      ->where('user_id', $session->get_api_key()->get_user()->user_id)
      ->exec();
    $response->BalancesUnconfirmed = \LoneSatoshi\Models\BalanceUnconfirmed::search()
      ->where('user_id', $session->get_api_key()->get_user()->user_id)
      ->exec();

    foreach($response->BalancesConfirmed as &$balance){
      $balance = $balance->get_balance_array();
    }
    foreach($response->BalancesUnconfirmed as &$balance){
      $balance = $balance->get_balance_array();
    }
  }

  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
