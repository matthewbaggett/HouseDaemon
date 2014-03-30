<?php

$app->get('/transactions', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $account_ids = array();
  $accounts = \LoneSatoshi\Models\Account::search()
    ->where('user_id', $_SESSION['user']->user_id)
    ->exec();
  foreach($accounts as $account){
    /* @var $account \LoneSatoshi\Models\Account */
    $account_ids[] = $account->account_id;
  }
  $app->render('transactions/list.phtml', array(
    'transactions' => \LoneSatoshi\Models\Transaction::search()
        ->where('account_id', $account_ids, "IN")
        ->order("date",'DESC')
        ->exec(),
  ));
});

$app->get('/transactions/view/:account_id', function ($account_id) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $account_ids = array();
  $accounts = \LoneSatoshi\Models\Account::search()
    ->where('user_id', $_SESSION['user']->user_id)
    ->where('account_id', $account_id)
    ->exec();
  foreach($accounts as $account){
    /* @var $account \LoneSatoshi\Models\Account */
    $account_ids[] = $account->account_id;
  }
  $app->render('transactions/list.phtml', array(
    'transactions' => \LoneSatoshi\Models\Transaction::search()
        ->where('account_id', $account_ids, "IN")
        ->order("date",'DESC')
        ->exec(),
  ));
});

$app->get('/transactions/refresh/:account_id', function ($account_id) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $user = \LoneSatoshi\Models\User::get_current();
  /* @var $account \LoneSatoshi\Models\Account */
  $account = \LoneSatoshi\Models\Account::search()->where('account_id', $account_id)->where('user_id', $user->user_id)->execOne();
  $account->refresh();

  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;
});
