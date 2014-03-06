<?php

$app->get('/cron', function () use ($app) {
  \LoneSatoshi\Models\Wallet::update_transaction_log();
  die("Cron completed");
});
