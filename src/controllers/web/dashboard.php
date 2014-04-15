<?php

$app->get('/dashboard', function () use ($app) {
  \NextSpoiler\Models\User::check_logged_in();

  $app->render('dashboard/dashboard.phtml', array());
});
