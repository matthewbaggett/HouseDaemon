<?php
namespace Skeleton\Models;

class Event extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "events";

  public $event_id;
  public $event_test_id;
  public $state;
  public $result;
  public $created;

  /**
   * @param EventTest $event_test
   * @param $state
   * @return Event
   */
  static public function trigger(EventTest $event_test, $state){
    $event = new Event();
    $event->event_test_id = $event_test->event_test_id;
    $event->state = $state;
    $event->result = $event_test->get_result();
    $event->created = date("Y-m-d H:i:s");
    $event->save();
    $event->propagate();
    return $event;
  }

  public function propagate(){
    // TODO
  }
}