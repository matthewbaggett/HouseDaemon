<?php
namespace LoneSatoshi\Models;

class Coin extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "coins";

  public $coin_id;
  public $name;
  public $symbol;
  public $auto_generate_wallet = "No";
  public $chain_url_format_address;
  public $chain_url_format_transaction;

  /**
   * @return Wallet
   */
  public function get_wallet(){
    echo "Looking for wallet with coin_id {$this->coin_id}";
    $wallet = Wallet::search('coin_id', $this->coin_id)->execOne();
    var_dump($wallet);
    return $wallet;
  }

}