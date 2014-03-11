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
  $new_address = new \LoneSatoshi\Models\AddressBook();
  $new_address->user_id = \LoneSatoshi\Models\User::get_current()->user_id;
  $new_address->address = $_POST['address'];
  $new_address->name = $_POST['name'];
  $new_address->created = date("Y-m-d H:i:s");
  $new_address->save();
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;
});
