<?php
namespace LoneSatoshi\Models;

class Balance extends \FourOneOne\ActiveRecord\ActiveRecord{
  public $account_id;
  public $user_id;
  public $username;
  public $balance;

  /**
   * @return Account
   */
  public function get_account(){
    return Account::search()->where('account_id', $this->account_id)->execOne();
  }

  public function pay($address, $amount){
    echo "Pay {$amount} to {$address} from {$this->get_account()->address} ({$this->balance}<br />";
  }
}