<?php

$app->get('/dashboard', function () use ($app) {
  \LoneSatoshi\Models\User::check_logged_in();

  $app->render('dashboard/dashboard.phtml', array(
    'accounts' => \LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec(),
    'block_count' => \LoneSatoshi\Models\Setting::get("block_count")
  ));
});
