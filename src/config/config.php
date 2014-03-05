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

define("RPCUSERNAME", "lonesatoshi");
define("RPCPASSWORD", "WAncPKHEBEsj4tUtWAncPKHEBEsj4tUt");
define("WALLET_ADDRESS","lostsatoshi.fouroneone.us");
define("WALLET_USERNAME", "dogecoin");
define("WALLET_PASSWORD", "WAncPKHEBEsj4tUt");

// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
/*$mailer_transport = Swift_SmtpTransport::newInstance('.me', 465, 'ssl')
  ->setUsername('')
  ->setPassword('MTFV^S5k')
;*/
//$mailer_from = array("boris@souschef.io" =>"Boris the SousChef");
//$mailer_default_to = array("matthew@baggett.me");