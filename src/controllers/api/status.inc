<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/status/', function () use ($app) {

  $response = new StdClass();
  $response->Status = 'OKAY';
  $response->Times = new StdClass();
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  $time_to_parse_transaction_log = \LoneSatoshi\Models\Setting::get('cron_execution_time');
  $response->Times->LastUpdate = date("Y-m-d H:i:s", $cron_last_run);
  $response->Times->LastUpdateSecondsSince = intVal(time() - $cron_last_run);
  $response->Times->TransactionLogDelay = floatVal($time_to_parse_transaction_log);
  $response->BlockCount = intVal(\LoneSatoshi\Models\Setting::get("block_count"));
  $response->TransactionDensity = array();
  foreach(\LoneSatoshi\Models\TransactionDensity::search()->exec() as $density){
    $response->TransactionDensity[$density->time_period] = array(
      "Frequency" => $density->frequency,
      "Volume" => $density->volume
    );
  }


  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
