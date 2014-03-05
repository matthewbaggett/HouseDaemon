<?php
namespace LoneSatoshi\Models;

class User extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "users";

  public $user_id;
  public $username;
  public $displayname;
  public $email;
  public $created;

}