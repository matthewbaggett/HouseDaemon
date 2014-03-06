<?php
namespace LoneSatoshi\Models;

class Balance extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "balances";

  public $account_id;
  public $user_id;
  public $username;
  public $balance;


}