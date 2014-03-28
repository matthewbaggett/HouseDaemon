<?php
namespace LoneSatoshi\Models;

class ValuationBatch extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "valuation_batches";

  public $valuation_batch_id;
  public $updated;

}