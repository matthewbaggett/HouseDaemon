<?php

$app->get('/cron', function () use ($app) {
  \LoneSatoshi\Models\Wallet::update_transaction_log();
  $block_count = \LoneSatoshi\Models\Wallet::get_info('blocks');
  echo "Block count is {$block_count}";
  \LoneSatoshi\Models\Setting::set("block_count", $block_count);
  die("Cron completed");
});
