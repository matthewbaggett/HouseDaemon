<?php

namespace LoneSatoshi\Models;

class TransactionDensity extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "transaction_frequency";

  public $frequency;
  public $time_period;
  public $volume;

}