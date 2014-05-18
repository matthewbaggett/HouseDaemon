<?php
namespace Skeleton\Models;

class EventTest extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "tests";

  public $test_id;
  public $name;
  public $code_to_run;
}