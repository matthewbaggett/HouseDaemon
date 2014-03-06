<?php

$app->get('/transactions', function () use ($app) {
  $account_ids = array();
  foreach(\LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec() as $account){
    /* @var $account \LoneSatoshi\Models\Account */
    $account_ids[] = $account->account_id;
  }
  $app->render('transactions/list.phtml', array(
    'transactions' => \LoneSatoshi\Models\Transaction::search()->where('account_id', $account_ids, "IN")->exec(),
  ));
});
