<?php

$app->get('/dashboard', function () use ($app) {
  $app->render('dashboard/dashboard.phtml', array(
    'accounts' => \LoneSatoshi\Models\Account::search()->where('user_id', $_SESSION['user']->user_id)->exec(),
  ));
});
