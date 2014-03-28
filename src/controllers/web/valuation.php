<?php

function make_valuation_chart_data($base_coin, $values){
  $headers = array();
  $data = array();

  $headers[] = 'Time';

  foreach($values as $target_coin => $exchange_rates){
    $headers[] = $target_coin;
    $unit = array();
    $unit[] = end($exchange_rates)->date;
    foreach($exchange_rates as $exchange_rate){
      /* @var $exchange_rate \LoneSatoshi\Models\ExchangeRate */
      $data[] = $exchange_rate->rate;
    }
  }

  $result = array();

  $result[] = $headers;
  foreach($data as $d){
    $result[] = $d;
  }

  krumo($result);exit;

  return $result;
}

$app->get('/valuation/:coin/', function ($coina) use ($app) {

  $values = array();
  foreach(array('BTC', 'GBP', 'USD') as $coinb){
    $values[$coinb] = \LoneSatoshi\Models\ExchangeRate::search()
      ->where('input', $coina)
      ->where('output', $coinb)
      ->exec();
  }
  $app->render('valuation/track.phtml', array(
    'values' => $values,
    'valuations' => make_valuation_chart_data($coina, $values),
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
    'valuations' => make_valuation_chart_data($coina, $values),
  ));
});

