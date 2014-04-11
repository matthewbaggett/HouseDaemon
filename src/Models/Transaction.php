<?php

namespace LoneSatoshi\Models;

class Transaction extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "transactions";

  public $transaction_id;
  public $account_id;
  public $reference_id;
  public $address;
  public $category;
  public $amount;
  public $confirmations;
  public $txid;
  public $date;
  public $date_received;
  public $block_hash;
  public $block_index;
  public $block_time;

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

  public function get_transaction_array(){
    return array(
      'transaction_id' => $this->transaction_id,
      'address' => $this->address,
      'category' => $this->category,
      'txid' => $this->txid,
      'date' => $this->date,
      'confirmations' => $this->confirmations,
      'block' => array(
        'hash' => $this->block_hash,
        'index' => $this->block_index,
        'time' => $this->block_time,
      )
    );
  }

}