<?php

$app->get('/valuation/:coina/:coinb', function ($coina, $coinb) use ($app) {

  $values = \LoneSatoshi\Models\Valuation::search()
    ->where('from', $coina)
    ->where('to', $coinb)
    ->where('source','average')
    ->exec();
  if(!$values){
    $values = \LoneSatoshi\Models\Valuation::search()
      ->where('to', $coina)
      ->where('from', $coinb)
      ->where('source','average')
      ->exec();
  }
  $app->render('valuations/track.phtml', array(
    'values' => $values
  ));
});

