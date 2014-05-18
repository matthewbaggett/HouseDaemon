<?php
require_once("bootstrap.php");

class Cycler{
  private $_start_microtime;
  private $_cycle_count = 0;

  public function __construct(){
    $this->_start_microtime = microtime(true);
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
    }
    echo "[" . number_format($time_since_begin,3) . "] > {$message}";
    if($return){
      echo "\n";
    }
  }
}

class HouseEventReceiver{
  public function check_for_events(Cycler $cyc){
    $tests = \Skeleton\Models\EventTest::search()->exec();
    $events_triggered = array();
    foreach($tests as $test){
      /* @var $test \Skeleton\Models\EventTest */
      $events_triggered = array_merge($events_triggered, $test->run());
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
  usleep(500);
});