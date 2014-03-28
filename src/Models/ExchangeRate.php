<?php
namespace LoneSatoshi\Models;

class ExchangeRate extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "exchange_rate";

  public $batch_id;
  public $date;
  public $source;
  public $input;
  public $output;
  public $via;
  public $input_btc_value;
  public $output_btc_value;
  public $rate;

}