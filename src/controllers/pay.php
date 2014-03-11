<?php

$app->get('/pay/:address_book_id/:address', function ($address_book_id, $address) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $address_book_record = \LoneSatoshi\Models\AddressBook::search()->where('address_book_id', $address_book_id)->execOne();

  $pre_transaction_id = uniqid('pre_transaction_id_', true);

  $_SESSION[$pre_transaction_id] = array(
    'user_id' => \LoneSatoshi\Models\User::get_current()->user_id,
    'address' => $address_book_record->address,
    'address_book_id' => $address_book_id
  );
  $app->render('pay/pay.phtml', array(
    'address' => $address_book_record->address,
    'address_book_record_id' => $address_book_id,
    'pre_transaction_id' => $pre_transaction_id,
  ));
});

$app->post('/pay/:address_book_id/:address', function ($address_book_id, $address) use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  //echo "<pre>";
  //var_dump($_POST);

  $pre_transaction = $_SESSION[$_POST['pre-transaction-id']];
  //var_dump($pre_transaction);
  //exit;
  if(\LoneSatoshi\Models\User::get_current()->user_id == $pre_transaction['user_id']){
    if($address == $pre_transaction['address']){
      if($address_book_id == $pre_transaction['address_book_record_id']){
        try{
          \LoneSatoshi\Models\User::get_current()->pay($address, $_POST['amount']);
        }catch(Exception $e){
          die($e->getMessage());
        }
      }
    }
  }
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;
});
