<?php
namespace LoneSatoshi\Models;

class Response {

  public $request = null;
  public $params = null;
  public $state = "OKAY";
  public $response_length_bytes = 0;
  public $time = null;

  public function json(){
    $this->preprocess_response();
    $result = json_encode($this->to_array(), JSON_PRETTY_PRINT);
    header("Content-type: application/json");
    echo $result;
    exit;
  }

  public function to_array(){
    $array =  (array) $this;
    return $array;
  }

  private function preprocess_response(){
    $this->time = array(
      "SecondsStart" => TIME_STARTUP,
      "SecondsFinish" => microtime(true),
      "SecondsBusy" => microtime(true) - TIME_STARTUP,
    );
    $this->request = $_SERVER['REQUEST_URI'];
    $this->params = $_REQUEST;
  }
}