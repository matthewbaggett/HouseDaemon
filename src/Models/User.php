<?php
namespace LoneSatoshi\Models;

class User extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "users";

  public $user_id;
  public $username;
  public $displayname;
  public $password;
  public $email;
  public $created;

  public function set_password($password){
    // TODO: Something a bit better than SHA1 I think.
    $this->password = hash("SHA1", $password);
    return $this;
  }
}