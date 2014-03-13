<?php
namespace LoneSatoshi\Models;

class WalletAction extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "wallet_actions";

  public $wallet_action_id;
  public $wallet_id;
  public $action;
  public $time;
  public $completed = 'No';

}