<?php

$app->get('/wallets', function () use ($app) {
  \LoneSatoshi\Models\Wallet::update_transaction_log();
  $app->render('wallets/list.phtml', array(
    'accounts' => \LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec(),
  ));
});
