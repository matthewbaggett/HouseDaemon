<?php

class SimplePageGrep{
  public static function grep($url, $selector){
    $dom = Sunra\PhpSimple\HtmlDomParser::file_get_html($url);
    $cell = $dom->find($selector, 0);
    return $cell->plaintext;
  }

  public function json($url){
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return json_decode($data);
  }
}