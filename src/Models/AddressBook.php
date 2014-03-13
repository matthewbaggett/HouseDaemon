<?php
namespace LoneSatoshi\Models;

class AddressBook extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "address_book";

  public $address_book_id;
  public $user_id;
  public $name;
  public $coin_id;
  public $address;
  public $created;

  /**
   * @return Coin
   */
  public function get_coin(){
    return Coin::search()->where('coin_id', $this->coin_id)->execOne();
  }

  /**
   * @return Account[]
   */
  public function get_accounts(){
    return Account::search()->where('user_id', $this->user_id)->where('coin_id', $this->coin_id)->exec();
  }

  /**
   * Convenience function to get an available balance from the coin/wallet combo that this address book record refers to
   * @return float
   */
  public function get_available_balance(){
    $balance = 0;
    foreach($this->get_accounts() as $account){
      $confirmed_balance = $account->get_balance_confirmed();
      if($confirmed_balance instanceof BalanceConfirmed){
        $balance = $balance + $confirmed_balance->balance;
      }
    }
    return $balance;
  }
}