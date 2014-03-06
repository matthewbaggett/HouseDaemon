<?php
namespace LoneSatoshi\Models;

class Wallet{
  static public function call($command){
    $ip_addr = gethostbyname(WALLET_ADDRESS);
    $configuration = new \Ssh\Configuration($ip_addr);
    $authentication = new \Ssh\Authentication\Password(WALLET_USERNAME, WALLET_PASSWORD);
    $session = new \Ssh\Session($configuration, $authentication);
    $exec = $session->getExec();

    $command = WALLET_BIN . " {$command}";
    $result = $exec->run($command, false, null, 80, 25, 0);

    return $result;
  }

  static public function get_info($element){
    $output = self::call("getinfo");
    $result = json_decode($output,true);
    return $result[$element];
  }

  static public function update_transaction_log(){
    $last = Transaction::search()->order('date', 'DESC')->execOne();

    $raw_transactions = self::call("listtransactions");
    $raw_transactions = json_decode($raw_transactions);
    foreach($raw_transactions as $raw_transaction){
      $transaction = Transaction::search()->where('txid', $raw_transaction->txid)->execOne();
      if(!$transaction instanceof Transaction){
        $transaction = new Transaction();
      }
      $account = Account::search()->where('reference_id', $raw_transaction->account)->execOne();
      $transaction->account_id    = $account->account_id;
      $transaction->reference_id  = $raw_transaction->account;
      $transaction->address       = $raw_transaction->address;
      $transaction->category      = $raw_transaction->category;
      $transaction->amount        = $raw_transaction->amount;
      $transaction->confirmations = $raw_transaction->confirmations;
      $transaction->txid          = $raw_transaction->txid;
      $transaction->date          = date("Y-m-d H:i:s", $raw_transaction->date);
      $transaction->date_received = date("Y-m-d H:i:s", $raw_transaction->date_received);
      $transaction->block_hash    = isset($raw_transaction->block_hash) ? $raw_transaction->block_hash : null;
      $transaction->block_index   = isset($raw_transaction->block_index) ? $raw_transaction->block_index : null;
      $transaction->block_time    = isset($raw_transaction->block_time) ? $raw_transaction->block_time : null;
      $transaction->save();
    }
  }
}