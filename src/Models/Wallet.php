<?php
namespace LoneSatoshi\Models;

class Wallet{
  static public function call($command){
    $ip_addr = gethostbyname(WALLET_ADDRESS);
    $configuration = new \Ssh\Configuration($ip_addr);
    $authentication = new \Ssh\Authentication\Password(WALLET_USERNAME, WALLET_PASSWORD);
    $session = new \Ssh\Session($configuration, $authentication);
    $exec = $session->getExec();

    return $exec->run("dogecoind {$command}", false, null, 80, 25, 0);
  }

  static public function get_info($element){
    $result = json_decode(self::call("getinfo"),true);
    krumo($result);
    return $result[$element];
  }
}