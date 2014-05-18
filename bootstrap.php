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

// Load themes
if(PHP_SAPI != 'cli'){
  require_once("themes/Base/base.inc");
  require_once("themes/" . THEME . "/template.inc");

  // Decide if we're the API version or the Web version
  if(substr($_SERVER['SERVER_NAME'], 0, 4) == 'api.'){
    $mode = 'api';
  }else{
    $mode = "web";
  }

  // Load all controllers.
  $file_list = scandir("./src/controllers/{$mode}");
  sort($file_list);
  foreach($file_list as $file){
    switch($file){
      case '.':
      case '..':
        // Do nothing
        break;
      default:
        require_once("./src/controllers/{$mode}/{$file}");
    }
  }
}