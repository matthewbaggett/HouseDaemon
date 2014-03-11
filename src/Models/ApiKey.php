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
   * @return ApiSession
   */
  public function create_session(){
    $session = new ApiSession();
    $session->api_key_id = $this->api_key_id;
    $session->created = date("Y-m-d H:i:s");
    $session->expires = date("Y-m-d H:i:s", time() + 1800);
    $session->session_key = uniqid("Session_", true);
    $session->save();
    return $session;
  }
}