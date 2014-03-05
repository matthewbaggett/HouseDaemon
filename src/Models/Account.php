<?php
namespace LoneSatoshi\Models;

class Account extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "accounts";

  public $account_id;
  public $user_id;
  public $address;
  public $created;

}