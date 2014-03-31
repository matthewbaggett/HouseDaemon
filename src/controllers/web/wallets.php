<?php

$app->get('/wallets', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $coins_to_autogenerate_wallet = \LoneSatoshi\Models\Coin::search()->where('auto_generate_wallet','Yes')->exec();
  foreach($coins_to_autogenerate_wallet as $coin_to_autogenerate_wallet){
    /* @var $coin_to_autogenerate_wallet \LoneSatoshi\Models\Coin */
    $existing_wallet = \LoneSatoshi\Models\Account::search()
      ->where('coin_id', $coin_to_autogenerate_wallet->coin_id)
      ->where('user_id', $_SESSION['user']->user_id)
      ->execOne();
    if(!$existing_wallet instanceof \LoneSatoshi\Models\Account){
      $wallet = $coin_to_autogenerate_wallet->get_wallet();
      $wallet->create_account_in_wallet($_SESSION['user'], $coin_to_autogenerate_wallet);
    }
  }

  $accounts = \LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec();

  foreach($accounts as $account){
    /* @var $account \LoneSatoshi\Models\Account */
    $value = 0;
    if($account->get_balance_confirmed() instanceof \LoneSatoshi\Models\Balance){
      $value = $account->get_balance_confirmed()->get_valuation('BTC');
    }
    $accounts_weighted[number_format($value,8)] = $account;
  }
  ksort($accounts_weighted);
  krumo($accounts_weighted);
  $accounts_weighted = array_reverse($accounts_weighted);
  $app->render('wallets/list.phtml', array(
    'accounts' => $accounts_weighted,
  ));
});


$app->get('/wallets/rename/:account_id', function ($account_id) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $account = \LoneSatoshi\Models\Account::search()
    ->where('user_id', \LoneSatoshi\Models\User::get_current()->user_id)
    ->where('account_id', $account_id)
    ->execOne();

  $app->render('wallets/rename.phtml', array(
    'account' => $account
  ));
});

$app->post('/wallets/rename/:account_id', function ($account_id) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $account = \LoneSatoshi\Models\Account::search()
    ->where('user_id', \LoneSatoshi\Models\User::get_current()->user_id)
    ->where('account_id', $account_id)
    ->execOne();

  if(!$account instanceof \LoneSatoshi\Models\Account){
    die("No such account");
  }

  $account->name = $_POST['name'];
  $account->save();

  header("Location: /wallets");
  exit;
});

$app->get('/wallets/add', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $app->render('wallets/add.phtml', array(
    'coins' => \LoneSatoshi\Models\Coin::search()->exec(),
  ));
});


$app->post('/wallets/add', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $user = \LoneSatoshi\Models\User::get_current();
  /* @var $coin \LoneSatoshi\Models\Coin */
  $coin = \LoneSatoshi\Models\Coin::search()->where('coin_id', $_POST['coin'])->execOne();
  if(!$coin instanceof \LoneSatoshi\Models\Coin){
    die("Coin not found");
  }
  $wallet = $coin->get_wallet();
  if(!$wallet instanceof \LoneSatoshi\Models\Wallet){
    die("Wallet not found");
  }
  $wallet->create_account_in_wallet($user, $coin);
  header("Location: /wallets");
  exit;
});
