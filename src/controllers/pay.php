<?php

$app->get('/pay/:address_book_id/:address', function ($address_book_id, $address) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $address_book_record = \LoneSatoshi\Models\AddressBook::search()->where('address_book_id', $address_book_id)->execOne();

  $pre_transaction_id = uniqid('pre_transaction_id_', true);

  $_SESSION[$pre_transaction_id] = array(
    'user_id' => \LoneSatoshi\Models\User::get_current()->user_id,
    'address_book_id' => $address_book_id
  );
  $app->render('pay/pay.phtml', array(
    'address' => $address_book_record->address,
    'pre_transaction_id' => $pre_transaction_id,
  ));
});

$app->post('/pay/:address_book_id/:address', function () use ($app) {
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
