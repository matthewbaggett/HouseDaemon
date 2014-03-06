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
}