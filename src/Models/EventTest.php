<?php
namespace Skeleton\Models;

class EventTest extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "event_tests";

  public $event_test_id;
  public $name;
  public $interval;
  public $code;
  public $expectation;

  private $_result;

  public function run(){
    ob_start();
    $function = create_function('$test', $this->code);
    $this->_result = $function($this);
    ob_end_clean();

    $validity_function = create_function('$result', $this->expectation);
    $validity = $validity_function($this->_result);
    if(!$validity){
      return Event::trigger($this, 'invalid');
    }else{
      return Event::trigger($this, 'valid');
    }
  }

  public function get_result(){
    return $this->_result;
  }
}