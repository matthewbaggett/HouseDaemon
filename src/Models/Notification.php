<?php

namespace LoneSatoshi\Models;

class Notification extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "notifications";

  const Critical = 1;
  const Warning = 5;
  const Dull = 9;

  const EmailThreshold = Notification::Warning;

  public $notification_id;
  public $user_id;
  public $level;
  public $message;
  public $variables;
  public $created;

  static public function send($level, $message, $values = null, User $user = null){
    if($user === null){
      $user = User::get_current();
    }
    $note = new Notification();
    $note->created = date("Y-m-d H:i:s");
    $note->user_id = $user->user_id;
    $note->message = $message;
    $note->variables = serialize($values);
    $note->level = intval($level);
    $note->save();
    if($level >= Notification::EmailThreshold){
      $note->send_email();
    }
    return $note;
  }

  public function send_email(){
    $message = $this->message;
    foreach(unserialize($this->variables) as $key => $value){
      $message = str_replace($key, $value, $message);
    }
    return \send_mail(
      $this->get_user()->email,
      $message,
      $message
    );
  }

  /**
   * @return User
   */
  public function get_user(){
    return User::search()->where('user_id', $this->user_id)->execOne();
  }

}