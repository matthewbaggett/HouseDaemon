<?php

namespace LoneSatoshi\Models;

class NetworkPeer extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "network_peers";

  public $network_peer_id;
  public $wallet_id;
  public $address;
  public $port;
  public $last_send;
  public $last_recv;
  public $bytes_sent;
  public $bytes_recv;
  public $blocks_requested;
  public $connection_time;
  public $version;
  public $subversion;
  public $inbound;
  public $starting_height;
  public $ban_score;
  public $last_seen;

}