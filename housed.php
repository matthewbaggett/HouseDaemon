#!/usr/bin/php
<?php
require_once("bootstrap.php");

class Cycler{
  private $_start_microtime;
  private $_cycle_count = 0;

  public function __construct(){
    $this->_start_microtime = microtime(true);
    set_time_limit(0);
  }

  public function run($callback){
    $persist = array();
    while(true){
      $this->_cycle_count++;
      $this->log("Cycle #{$this->_cycle_count}",false);
      $callback($persist);
    }
  }

  public function log($message, $return = true){
    $time_since_begin = microtime(true) - $this->_start_microtime;
    if(!$return){
      echo "\r";
    }else{
      echo "\n";
    }
    echo "[" . number_format($time_since_begin,3) . "][" . date("Y-m-d H:i:s") . "] > {$message}";
  }
}

class HouseEventReceiver{
  public function check_for_events(Cycler $cyc){
    $tests = \Skeleton\Models\EventTest::search()->exec();
    $events_triggered = array();
    foreach($tests as $test){
      /* @var $test \Skeleton\Models\EventTest */
      $age = time() - $test->interval;
      $recent_event_test = \Skeleton\Models\Event::search()
        ->where('event_test_id', $test->event_test_id)
        ->where('created',date("Y-m-d H:i:s", $age), '>=')
        ->execOne();
      if($recent_event_test instanceof \Skeleton\Models\Event){
        //$cyc->log("Skip {$test->name}");
        continue;
      }
      $cyc->log("Run {$test->name}");
      $result = $test->run();
      echo "\n";
      if(is_array($result)){
        $events_triggered = array_merge($events_triggered, $result);
      }
    }
    if(count($events_triggered) > 0){
      $cyc->log(count($events_triggered) . " events triggered");
    }
  }
}

$app = new HouseEventReceiver();

$cyc = new Cycler();
$cyc->run(function($persist) use ($cyc, $app){
  $app->check_for_events($cyc);
  usleep(CYCLE_SLEEP);
});
