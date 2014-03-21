<?php
namespace LoneSatoshi\Models;

class Balance extends \FourOneOne\ActiveRecord\ActiveRecord{
  public $account_id;
  public $user_id;
  public $username;
  public $balance;

  private $_account;

  /**
   * @return Account
   */
  public function get_account(){
    if(!$this->_account){
      $this->_account = Account::search()->where('account_id', $this->account_id)->execOne();
    }
    return $this->_account;
  }

  public function pay(Coin $check_coin, $address, $amount){
    //echo "Pay {$amount} to {$address} from {$this->get_account()->address} ({$this->balance})<br />";
    $account = $this->get_account();
    $coin = $account->get_coin();
    $wallet = $coin->get_wallet();
    if($coin->coin_id != $check_coin->coin_id){
      throw new \Exception("Coin ID does not match Check Coin ID");
      exit;
    }
    $command = "sendfrom " . str_replace("|","\\|", $account->reference_id) . " " . $address . " " . $amount;
    //echo "Command: {$command}<br />";
    $wallet->call($command);
  }

  public function get_balance_array(){
    return array(
      'address' => $this->get_account()->address,
      'balance' => $this->balance,
      'created' => $this->get_account()->created,
      'coin' => $this->get_account()->get_coin()->name,
    );
  }

  public function get_valuation($to){
    $from = $this->get_account()->get_coin()->symbol;
    try{
      return \ExchangeApi\Valuations::get_price(
        $from,
        $to,
        $this->balance
      );
    }catch(\ExchangeApi\Exception $e){
      return 0;
    }
  }
}