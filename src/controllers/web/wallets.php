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
  $app->render('wallets/list.phtml', array(
    'accounts' => \LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec(),
  ));
});
