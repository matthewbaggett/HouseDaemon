<?php

$app->get('/dashboard', function () use ($app) {
  \NextSpoiler\Models\User::check_logged_in();

  $app->render('dashboard/dashboard.phtml', array(
    'accounts' => \NextSpoiler\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec(),
  ));
});
