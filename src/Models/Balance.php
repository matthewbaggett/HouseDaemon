<?php
namespace LoneSatoshi\Models;

class Balance extends \FourOneOne\ActiveRecord\ActiveRecord{
  public $account_id;
  public $user_id;
  public $username;
  public $balance;

  public function pay($address, $amount){
    echo "Pay {$amount} to {$address}<br />";
  }
}