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
}