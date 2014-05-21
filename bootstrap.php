<?php

set_time_limit(120);
if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the " . APP_NAME . " root directory.");
}

// Load Auto loaded things
require_once("./vendor/autoload.php");
require_once("./vendor/fouroneone/session/FourOneOne/Session/Session.php");

// Load not-autoloaded-things
require_once("./src/config/config.php");
require_once("./src/lib/mail.php");
require_once("./src/lib/simple_page_grep.php");

if(PHP_SAPI != 'cli'){
  // Decide if we're the API version or the Web version
  if(substr($_SERVER['SERVER_NAME'], 0, 4) == 'api.'){
    $mode = 'api';
  }else{
    $mode = "web";
  }


}