<?php

function make_valuation_chart_data($values){
  $headers = array();
  $data = array();
  var_dump($values);exit;

  foreach($values as $thingy){
  }

  $result = array();

  $result[] = $headers;
  foreach($data as $d){
    $result[] = $d;
  }

  return $result;
}

$app->get('/valuation/:coin/', function ($coina) use ($app) {

  $values = array();
  foreach(array('BTC', 'GBP', 'USD') as $coinb){
    $values[$coinb] = \LoneSatoshi\Models\Valuation::search()
      ->where('from', $coina)
      ->where('to', $coinb)
      ->where('source','average')
      ->exec();
    if(!$values[$coinb]){
      $values[$coinb] = \LoneSatoshi\Models\Valuation::search()
        ->where('to', $coina)
        ->where('from', $coinb)
        ->where('source','average')
        ->exec();
    }
  }
  $app->render('valuation/track.phtml', array(
    'values' => $values,
    'valuations' => make_valuation_chart_data($values),
  ));
});

$app->get('/valuation/:coina/:coinb', function ($coina, $coinb) use ($app) {
  $values = array();
  $values[$coinb] = \LoneSatoshi\Models\Valuation::search()
    ->where('from', $coina)
    ->where('to', $coinb)
    ->where('source','average')
    ->exec();
  if(!$values[$coinb]){
    $values[$coinb] = \LoneSatoshi\Models\Valuation::search()
      ->where('to', $coina)
      ->where('from', $coinb)
      ->where('source','average')
      ->exec();
  }
  $app->render('valuation/track.phtml', array(
    'values' => $values,
    'valuations' => make_valuation_chart_data($values),
  ));
});

