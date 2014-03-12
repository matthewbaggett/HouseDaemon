<?php
namespace LoneSatoshi\Models;

class Account extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "accounts";

  public $account_id;
  public $user_id;
  public $reference_id;
  public $address;
  public $created;
  public $coin_id;

  private $_coin;
  private $_transactions;

  /**
   * @return BalanceConfirmed
   */
  public function get_balance_confirmed(){
    $balance = BalanceConfirmed::search()->where('account_id', $this->account_id)->execOne();
    return $balance;
  }

  /**
   * @return BalanceUnconfirmed
   */
  public function get_balance_unconfirmed(){
    $balance = BalanceUnconfirmed::search()->where('account_id', $this->account_id)->execOne();
    return $balance;
  }

  /**
   * @return Coin
   */
  public function get_coin(){
    if(!$this->_coin){
      $this->_coin = Coin::search()->where('coin_id', $this->coin_id)->execOne();
    }
    return $this->_coin;
  }

  /**
   * @return Transaction[]
   */
  public function get_transactions(){
    if(!$this->_transactions){
      $this->_transactions = Transaction::search()->where('account_id', $this->account_id)->exec();
    }
    return $this->_transactions;
  }

}