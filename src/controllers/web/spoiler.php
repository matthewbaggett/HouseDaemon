<?php

$app->get('/:series_name', function ($series_name) use ($app) {
  $series = \NextSpoiler\Models\Series::search()->where('url', $series_name)->execOne();

  if($series instanceof \NextSpoiler\Models\Series){
    $spoiler = $series->get_next_spoiler();
    $app->render('spoiler/spoil.phtml', array(
      'series' => $series,
      'spoiler' => $spoiler,
    ));
  }else{
    header("Location: " . $app->view->url(""));
    exit;
  }
});
