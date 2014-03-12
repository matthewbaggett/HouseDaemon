<?php

namespace LoneSatoshi\Models;


class ApiKey extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "api_keys";

  public $api_key_id;
  public $user_id;
  public $api_key;
  public $created;
  public $revoked = 'No';

  /**
   * @return ApiSession|false
   */
  public function get_current_session(){
    return ApiSession::search()
      ->where('api_key_id', $this->api_key_id)
      ->where('expires', date("Y-m-d H:i:s"), ">=")
      ->execOne();
  }

  /**
   * @return ApiSession
   */
  public function create_session(){
    $session = $this->get_current_session();
    if(!$session instanceof ApiSession){
      $session = new ApiSession();
      $session->api_key_id = $this->api_key_id;
      $session->created = date("Y-m-d H:i:s");
      $session->session_key = uniqid("Session_", true);
    }
    $session->expires = date("Y-m-d H:i:s", time() + 1800);
    $session->save();
    return $session;
  }

  /**
   * @return false|User
   */
  public function get_user(){
    return User::search()->where('user_id', $this->user_id)->execOne();
  }
}