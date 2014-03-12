<?php

require_once(dirname(__FILE__) . "/../../lib/json_pretty_print.php");

$app->get('/status/', function () use ($app) {

  $response = new StdClass();
  $response->Status = 'OKAY';
  $response->Times = new StdClass();
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  $time_to_parse_transaction_log = \LoneSatoshi\Models\Setting::get('cron_execution_time');
  $response->Times->LastUpdate = date("Y-m-d H:i:s", $cron_last_run);
  $response->Times->LastUpdateSecondsSince = (time() - $cron_last_run);
  $response->Times->TransactionLogDelay = $time_to_parse_transaction_log;
  $response->BlockCount = \LoneSatoshi\Models\Setting::get("block_count");


  header("Content-type: application/json");
  echo json_pretty_print($response);
  exit;

});
