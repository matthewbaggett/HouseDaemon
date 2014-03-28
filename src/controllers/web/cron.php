<?php

$app->get('/cron', function () use ($app) {
  $output = '';
  $run = false;
  if(\LoneSatoshi\Models\User::get_current() instanceof \LoneSatoshi\Models\User){
    if(\LoneSatoshi\Models\User::get_current()->is_admin()){
      $run = true;
    }
  }
  $cron_last_run = \LoneSatoshi\Models\Setting::get("cron_last_run");
  $output.= "Date now       : " . date("Y-m-d H:i:s") . "\n";
  $output.= "Date last run  : " . date("Y-m-d H:i:s", $cron_last_run) . "\n";
  $output.= "Last cron took : " . number_format(\LoneSatoshi\Models\Setting::get("cron_execution_time"),3) . " seconds" . "\n";
  if((time() - $cron_last_run) > 30){
    $run = true;
  }

  $output.= "Last cron run  : " . (time() - $cron_last_run) . " seconds ago \n";
  if($run){
    $cron_start = microtime(true);
    foreach(\LoneSatoshi\Models\Wallet::search()->exec() as $wallet){
      /* @var $wallet \LoneSatoshi\Models\Wallet */
      $wallet->update_transaction_log();
      $wallet->update_peer_log();
      $block_count = $wallet->get_info('blocks');
      $output.= "{$wallet->get_coin()->name} Block count is {$block_count} \n";
      \LoneSatoshi\Models\Setting::set("block_count_" . $wallet->get_coin()->name, $block_count);
    }

    $week_ago = strtotime('1 week ago');

    $old_network_peers = \LoneSatoshi\Models\NetworkPeer::search()->where('last_recv', $week_ago,'<')->exec();
    foreach($old_network_peers as $old_network_peer){
      $old_network_peer->delete();
    }
    $output.= "Deleted " . count($old_network_peers) . " old network peers\n";

    $old_notifications = \LoneSatoshi\Models\Notification::search()->where('created', date("Y-m-d H:i:s", $week_ago),'<')->exec();
    foreach($old_notifications as $old_notification){
      $old_notification->delete();
    }
    $output.= "Deleted " . count($old_notifications) . " old notifications\n";

    $old_wallet_actions = \LoneSatoshi\Models\Notification::search()->where('created', date("Y-m-d H:i:s", $week_ago),'<')->exec();
    foreach($old_wallet_actions as $old_wallet_action){
      $old_wallet_action->delete();
    }
    $output.= "Deleted " . count($old_wallet_actions) . " old wallet actions\n";

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
    $output.= "Cron completed in {$exec_time}";
  }else{
    $output.= "Too soon to run cron again.";
  }

  header("Content-type: text/plain");
  echo $output;
  exit;


});

$app->get('/cron/valuations', function () use ($app) {
  $output = '';
  $updated = \ExchangeApi\Valuations::fetch();

  if($updated){
    $data = \ExchangeApi\Valuations::get_data();
    $time_updated = date("Y-m-d H:i:s");
    foreach($data as $source_name => $source_data){
      foreach($source_data as $from_key => $to){
        foreach($to as $to_key => $data){
          $valuation = new \LoneSatoshi\Models\Valuation();
          $valuation->source = $source_name;
          $valuation->from = $from_key;
          $valuation->to = $to_key;
          $valuation->value = $data['price'];
          $valuation->updated = $time_updated;
          $valuation->save();
        }
      }
    }
  }
  header("Content-type: text/plain");
  echo $output;
  exit;


});


