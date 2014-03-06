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

}