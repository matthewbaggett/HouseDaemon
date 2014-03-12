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

    $result = trim($result);

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
      $transaction = Transaction::search()
        ->where('txid', $raw_transaction->txid)
        ->where('reference_id', $raw_transaction->account)
        ->execOne();
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
      $transaction->date          = date("Y-m-d H:i:s", $raw_transaction->time);
      $transaction->date_received = date("Y-m-d H:i:s", $raw_transaction->timereceived);
      $transaction->block_hash    = isset($raw_transaction->blockhash) ? $raw_transaction->blockhash : null;
      $transaction->block_index   = isset($raw_transaction->blockindex) ? $raw_transaction->blockindex : null;
      $transaction->block_time    = isset($raw_transaction->blocktime) ? date("Y-m-d H:i:s", $raw_transaction->blocktime) : null;
      $transaction->save();
    }
  }

  static public function create_wallet(User $user, Coin $coin){

    $account = new Account();
    $account->user_id = $user->user_id;
    $account->reference_id = $user->username . "|" . date("Y-m-d") . "|" . date("H:i:s");
    $command = "getnewaddress " . str_replace("|","\\|", $account->reference_id);
    $account->address = self::call($command);
    $account->created = date("Y-m-d H:i:s");
    $account->coin_id = $coin->coin_id;
    $account->save();
  }
}