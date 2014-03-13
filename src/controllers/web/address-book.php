<?php

$app->get('/address-book', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $addresses = \LoneSatoshi\Models\User::get_current()->get_addresses();

  $app->render('address-book/list.phtml', array(
    'addresses' => $addresses,
  ));
});

$app->post('/address-book/add', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $user = \LoneSatoshi\Models\User::get_current();
  $coin = \LoneSatoshi\Models\Coin::search()->where('coin_id', intval($_POST['coin']))->execOne();
  if(!$coin instanceof \LoneSatoshi\Models\Coin){
    die("Must select a valid coin");
  }
  $new_address = new \LoneSatoshi\Models\AddressBook();
  $new_address->user_id = $user->user_id;
  $new_address->address = $_POST['address'];
  $new_address->name = $_POST['name'];
  $new_address->coin_id = $coin->coin_id;
  $new_address->created = date("Y-m-d H:i:s");
  $new_address->save();
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;
});
