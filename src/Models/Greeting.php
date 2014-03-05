<?php

namespace LoneSatoshi\Models;


class Greeting extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "greetings";

  public $greeting_id;
  public $origin;
  public $greeting;
}