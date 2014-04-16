<?php

$app->get('/dashboard', function () use ($app) {
  \Skeleton\Models\User::check_logged_in();

  $app->render('dashboard/dashboard.phtml', array());
});
