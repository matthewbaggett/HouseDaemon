<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/transactions/:session_key', function ($session_key) use ($app) {

  $response = new StdClass();
  $session = \LoneSatoshi\Models\ApiSession::load($session_key);

  if(!$session->get_api_key() instanceof \LoneSatoshi\Models\ApiKey){
    $response->Status = 'FAIL';
    $response->FailureMessage = 'API key not valid or API session expired';
  }else{
    $response->Status = 'OKAY';
    $response->Session = $session->get_session_array();
    $response->Accounts = array();
    foreach(\LoneSatoshi\Models\Account::search()->where('user_id', $session->get_api_key()->get_user()->user_id)->exec() as $account){
      /* @var $account \LoneSatoshi\Models\Account */
      foreach($account->get_transactions() as $transaction){
        $response->Accounts[$account->address][] = $transaction->get_transaction_array();
      }
    }
  }

  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
