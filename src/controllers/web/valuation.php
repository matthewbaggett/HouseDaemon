<?php

function make_valuation_chart_data($base_coin, $values){
  $headers = array();
  $data = array();

  $headers[] = 'Time';
  $units = array();

  foreach($values as $target_coin => $exchange_rates){
    $headers[] = $target_coin;
    foreach($exchange_rates as $exchange_rate){
      /* @var $exchange_rate \LoneSatoshi\Models\ExchangeRate */
      $units[$exchange_rate->date][$exchange_rate->output] = $exchange_rate->rate;
    }
  }

  foreach($units as $date => $j){
    $elem = array();
    $elem[] = strtotime($date);
    foreach($j as $output => $rate){
       $elem[] = $rate;
    }
    $data[] = $elem;
  }

  $result = array();

  //$result[] = $headers;
  foreach($data as $d){
    $result[] = $d;
  }

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

