<?php
namespace LoneSatoshi\Models;

class Account extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "accounts";

  public $account_id;
  public $user_id;
  public $address;
  public $created;
  public $coin_id;

  public function get_balance(){
    return '???';
  }

  /**
   * @return Coin
   */
  public function get_coin(){
    return Coin::search()->where('coin_id', $this->coin_id)->execOne();
  }

}