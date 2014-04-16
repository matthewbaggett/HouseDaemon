<?php

// Database Settings
switch(gethostname()){
  case 'hostnamehere':
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type'     => 'Mysql',
      'db_hostname' => 'localhost',
      'db_port'     => '3306',
      'db_username' => 'username',
      'db_password' => 'password',
      'db_database' => 'database'
    ));
    break;
  default:
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type'     => 'Mysql',
      'db_hostname' => 'localhost',
      'db_port'     => '3306',
      'db_username' => 'username',
      'db_password' => 'password',
      'db_database' => 'database'
    ));
}


// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
$mailer_transport = Swift_SmtpTransport::newInstance('mailserver.example.com', 465, 'ssl')
  ->setUsername('example@example.com')
  ->setPassword('password')
;
$mailer_from = array("system@example.com" => "Example");
$mailer_default_to = array("you@example.com");
