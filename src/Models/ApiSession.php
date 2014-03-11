<?php

namespace LoneSatoshi\Models;


class ApiSession extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "api_sessions";

  public $session_id;
  public $api_key_id;
  public $session_key;
  public $created;
  public $expires;
}