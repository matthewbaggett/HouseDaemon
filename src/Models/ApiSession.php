<?php

namespace LoneSatoshi\Models;


class ApiSession extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "api_sessions";

  public $session_id;
  public $api_key_id;
  public $session_key;
  public $created;
  public $expires;


  /**
   * Load a session by session key
   * @param $session_key
   * @return ApiSession|False
   */
  static public function load($session_key){
    return ApiSession::search()
      ->where('session_key', $session_key)
      ->where('expires', date('Y-m-d H:i:s'), '>=')
      ->where('created', date('Y-m-d H:i:s'), '<=')
      ->execOne();
  }

  /**
   * @return ApiKey|false
   */
  public function get_api_key(){
    return ApiKey::search()->where('api_key_id', $this->api_key_id)->execOne();
  }

  public function get_session_array(){
    $a = (array) $this;
    unset($a['session_id'],$a['api_key_id']);
    return $a;
  }
}