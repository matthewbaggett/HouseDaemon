<?php

$app->get('/cron', function () use ($app) {
  ob_start();
  $run = false;
  if(\LoneSatoshi\Models\User::get_current() instanceof \LoneSatoshi\Models\User){
    if(\LoneSatoshi\Models\User::get_current()->is_admin()){
      $run = true;
    }
  }
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  echo "Date now       : " . date("Y-m-d H:i:s") . "\n";
  echo "Date last run  : " . date("Y-m-d H:i:s", $cron_last_run) . "\n";
  echo "Last cron took : " . number_format(\LoneSatoshi\Models\Setting::get("cron_execution_time"),3) . " seconds" . "\n";
  if((time() - $cron_last_run) > 30){
    $run = true;
  }

  echo "Last cron run  : " . (time() - $cron_last_run) . " seconds ago \n";
  if($run){
    $cron_start = microtime(true);
    foreach(\LoneSatoshi\Models\Wallet::search()->exec() as $wallet){
      /* @var $wallet \LoneSatoshi\Models\Wallet */
      $wallet->update_transaction_log();
      $block_count = $wallet->get_info('blocks');
      echo "{$wallet->get_coin()->name} Block count is {$block_count} \n";
      \LoneSatoshi\Models\Setting::set("block_count_" . $wallet->get_coin()->name, $block_count);
    }

    $cron_end = microtime(true);
    $exec_time = $cron_end - $cron_start;
    \LoneSatoshi\Models\Setting::set('cron_execution_time', $exec_time);
    \LoneSatoshi\Models\Setting::set("cron_last_run", time());

    if($exec_time >= \LoneSatoshi\Models\Setting::get("max_cron_delay",null,10)){
      $admin_users = \LoneSatoshi\Models\User::search()->where('type','Admin')->exec();
      foreach($admin_users as $admin_user){
        /* @var $admin_user \LoneSatoshi\Models\User */
        \LoneSatoshi\Models\Notification::send(
          \LoneSatoshi\Models\Notification::Critical,
          "Cron slow. Took :time to complete",
          array(
               ":time" => $exec_time
          ),
          $admin_user
        );
      }
    }
    echo "Cron completed in {$exec_time}";
  }else{
    echo "Too soon to run cron again.";
  }

  $output = ob_get_contents();
  ob_end_clean();

  header("Content-type: text/plain");
  echo $output;
});
