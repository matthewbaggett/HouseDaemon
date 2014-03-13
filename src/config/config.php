<?php

// Database Settings
$database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
  'db_type' => 'Mysql',
  'db_hostname' => '127.0.0.1',
  'db_port' => '3306',
  'db_username' => 'lonesatoshi',
  'db_password' => 'WAncPKHEBEsj4tUt',
  'db_database' => 'lonesatoshi'
));

define("WALLET_BIN", "/home/dogecoin/dogecoind");
define("WALLET_ADDRESS","lonesatoshi.com");
define("WALLET_USERNAME", "dogecoin");
define("WALLET_PASSWORD", "WAncPKHEBEsj4tUt");

// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
$mailer_transport = Swift_SmtpTransport::newInstance('mail.lonesatoshi.com', 465, 'ssl')
  ->setUsername('system@lonesatoshi.com')
  ->setPassword('m-MzaSgN')
;
$mailer_from = array("system@lonesatoshi.com" => "LoneSatoshi System");
$mailer_default_to = array("matthew+lonesatoshicopies@baggett.me");
