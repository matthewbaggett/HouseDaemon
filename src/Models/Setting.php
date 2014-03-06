<?php

namespace LoneSatoshi\Models;

class Setting extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "settings";

  public $setting_id;
  public $name;
  public $user_id;
  public $value;


  static public function set($name, $value, $user_id = null){
    $setting = Setting::search()->where('name', $name)->execOne();
    if(!$setting instanceof Setting){
      $setting = new Setting();
    }
    $setting->name = $name;
    $setting->value = $value;
    $setting->user_id = $user_id;
    $setting->save();
  }

  static public function get($name, $user_id = null){
    $setting = Setting::search()
      ->where('name', $name)
      ->where('user_id', $user_id)
      ->execOne();
    if($setting instanceof Setting){
      return $setting->value;
    }
  }
}