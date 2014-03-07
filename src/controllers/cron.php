<?php

$app->get('/cron', function () use ($app) {
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  if(time() - 30 <= $cron_last_run){
    \LoneSatoshi\Models\Wallet::update_transaction_log();
    $block_count = \LoneSatoshi\Models\Wallet::get_info('blocks');
    echo "Block count is {$block_count}";
    \LoneSatoshi\Models\Setting::set("block_count", $block_count);
    \LoneSatoshi\Models\Setting::set("cron_last_run", time());
    die("Cron completed");
  }else{
    die("Too soon to run cron again");
  }
});
