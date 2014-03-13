<?php
namespace LoneSatoshi\Models;

class Wallet extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "wallets";

  public $wallet_id;
  public $name;
  public $coin_id;
  public $host;
  public $username;
  public $password;
  public $binary;
  public $last_access;

  private $_coin;

  /**
   * @return Coin
   */
  public function get_coin(){
    if(!$this->_coin){
      $this->_coin = Coin::search()->where('coin_id', $this->coin_id)->execOne();
    }
    return $this->_coin;
  }

  public function call($command){
    $ip_addr = gethostbyname($this->host);
    $configuration = new \Ssh\Configuration($ip_addr);
    $authentication = new \Ssh\Authentication\Password($this->username, $this->password);
    $session = new \Ssh\Session($configuration, $authentication);
    $exec = $session->getExec();

    $command = $this->binary . " {$command}";

    // Write to Wallet Action Log.
    $wallet_action = new WalletAction();
    $wallet_action->wallet_id = $this->wallet_id;
    $wallet_action->time = date("Y-m-d H:i:s");
    $wallet_action->action = $command;
    $wallet_action->completed = 'No';
    $wallet_action->save();

    // Do the command
    $result = $exec->run($command, false, null, 80, 25, 0);
    $result = trim($result);

    // Mark wallet action completed
    $wallet_action->completed = 'Yes';
    $wallet_action->save();

    // Update last_access on wallet.
    $this->last_access = date("Y-m-d H:i:s");
    $this->save();

    return $result;
  }

  public function get_info($element){
    $output = $this->call("getinfo");
    $result = json_decode($output,true);
    return $result[$element];
  }

  public function create_account_in_wallet(User $user, Coin $coin){
    $account = new Account();
    $account->user_id = $user->user_id;
    $account->reference_id = $user->username . "|" . date("Y-m-d") . "|" . date("H:i:s");
    $command = "getnewaddress " . str_replace("|","\\|", $account->reference_id);
    $account->address = $this->call($command);
    $account->created = date("Y-m-d H:i:s");
    $account->coin_id = $coin->coin_id;
    $account->save();
  }

  public function update_transaction_log(){
    //$last = Transaction::search()->order('date', 'DESC')->execOne();

    $raw_transactions = $this->call("listtransactions");
    $raw_transactions = json_decode($raw_transactions);

    foreach($raw_transactions as $raw_transaction){
      $new_transaction = false;
      $transaction = Transaction::search()
        ->where('txid', $raw_transaction->txid)
        ->where('reference_id', $raw_transaction->account)
        ->execOne();
      if(!$transaction instanceof Transaction){
        $transaction = new Transaction();
        $new_transaction = true;
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
      $transaction->date_received = isset($raw_transaction->timereceived) ? date("Y-m-d H:i:s", $raw_transaction->timereceived) : null;
      $transaction->block_hash    = isset($raw_transaction->blockhash) ? $raw_transaction->blockhash : null;
      $transaction->block_index   = isset($raw_transaction->blockindex) ? $raw_transaction->blockindex : null;
      $transaction->block_time    = isset($raw_transaction->blocktime) ? date("Y-m-d H:i:s", $raw_transaction->blocktime) : null;
      $transaction->save();
      if($new_transaction && $transaction->category == 'receive'){
        Notification::send(
          Notification::Warning,
          "Received Payment: :amount :coin into :address",
          array(
            ':amount' => $transaction->amount,
            ':coin' => $transaction->get_account()->get_coin()->name,
            ':address' => $transaction->address,
          ),
          $transaction->get_account()->get_user()
        );
      }
    }
  }

  public function update_peer_log(){
    $raw_peers = $this->call("getpeerinfo");
    $raw_peers = json_decode($raw_peers);
    $yesterday = strtotime("yesterday");
    foreach($raw_peers as $raw_peer){
      $addr_bits = explode(":",$raw_peer->addr,2);
      $ip = $addr_bits[0];
      $port = $addr_bits[1];
      $peer = NetworkPeer::search()
        ->where('address', $ip)
        ->where('port', $port)
        ->where('connection_time', date("Y-m-d H:i:s", $yesterday), ">")
        ->where('wallet_id', $this->wallet_id)
        ->execOne();
      if(!$peer instanceof NetworkPeer){
        $peer = new NetworkPeer();
        $new_peer = true;
      }
      $peer->wallet_id = $this->wallet_id;
      $peer->address = $ip;
      $peer->port = $port;
      $peer->last_send = $raw_peer->lastsend;
      $peer->last_recv = $raw_peer->lastrecv;
      $peer->bytes_sent = $raw_peer->bytessent;
      $peer->bytes_recv = $raw_peer->bytesrecv;
      $peer->blocks_requested = $raw_peer->blocksrequested;
      $peer->connection_time = $raw_peer->conntime;
      $peer->version = $raw_peer->version;
      $peer->subversion = $raw_peer->subver;
      $peer->inbound = $raw_peer->inbound ? 'true':'false';
      $peer->starting_height = $raw_peer->startingheight;
      $peer->ban_score = $raw_peer->banscore;

      $peer->save();
    }
  }
}