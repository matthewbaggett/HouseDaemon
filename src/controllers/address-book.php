<?php

$app->get('/address-book', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();
  $addresses = \LoneSatoshi\Models\User::get_current()->get_addresses();

  $app->render('address-book/list.phtml', array(
    'addresses' => $addresses,
  ));
});
