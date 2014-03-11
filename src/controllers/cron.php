<?php

$app->get('/cron', function () use ($app) {
  header("Content-type: text/plain");
  $run = false;
  if(\LoneSatoshi\Models\User::get_current() instanceof \LoneSatoshi\Models\User){
    if(\LoneSatoshi\Models\User::get_current()->is_admin()){
      $run = true;
    }
  }
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  echo "Date now       : " . date("Y-m-d H:i:s") . "\n";
  echo "Date last run  : " . date("Y-m-d H:i:s", $cron_last_run) . "\n";
  echo "Last cron took : " . number_format(\LoneSatoshi\Models\Setting::get("cron_execution_time"),3) . " seconds" . "\n";
  if((time() - $cron_last_run) > 30){
    $run = true;
  }

  echo "Last cron run  :  " . (time() - $cron_last_run) . " seconds ago \n";
  if($run){
    $cron_start = microtime(true);
    \LoneSatoshi\Models\Wallet::update_transaction_log();
    $block_count = \LoneSatoshi\Models\Wallet::get_info('blocks');
    echo "Block count is {$block_count} \n";
    \LoneSatoshi\Models\Setting::set("block_count", $block_count);

    $cron_end = microtime(true);
    $exec_time = $cron_end - $cron_start;
    \LoneSatoshi\Models\Setting::set('cron_execution_time', $exec_time);
    \LoneSatoshi\Models\Setting::set("cron_last_run", time());
    die("Cron completed in {$exec_time}");
  }else{
    die("Too soon to run cron again.");
  }
});
