<?php
namespace LoneSatoshi\Models;

class Valuation extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "valuations";

  public $valuation_id;
  public $valuation_batch_id;
  public $source;
  public $from;
  public $to;
  public $value;
  public $updated;

}