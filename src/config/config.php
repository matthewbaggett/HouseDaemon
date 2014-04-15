<?php

// Database Settings
switch(gethostname()){
  case 'houston':
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type' => 'Mysql',
      'db_hostname' => 'sql.nextspoiler.com',
      'db_port' => '3306',
      'db_username' => 'nextspoiler',
      'db_password' => 'hcVfPZx4nLCBtK8q',
      'db_database' => 'nextspoiler'
    ));
    break;
  default:
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type' => 'Mysql',
      'db_hostname' => '127.0.0.1',
      'db_port' => '3306',
      'db_username' => 'nextspoiler',
      'db_password' => 'hcVfPZx4nLCBtK8q',
      'db_database' => 'nextspoiler'
    ));
}


// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
$mailer_transport = Swift_SmtpTransport::newInstance('mail.nextspoiler.com', 465, 'ssl')
  ->setUsername('system@nextspoiler.com')
  ->setPassword('m-MzaSgN')
;
$mailer_from = array("system@nextspoiler.com" => "NextSpoiler");
$mailer_default_to = array("matthew+nextspoilercopies@baggett.me");
