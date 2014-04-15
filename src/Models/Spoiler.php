<?php

namespace NextSpoiler\Models;

class Spoiler extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "spoilers";

  public $spoiler_id;
  public $series_id;
  public $created;
  public $relevant_until;
  public $spoiler;
  public $user_id;

  private $_user;

  /**
   * Get related user.
   * @return User
   */
  public function get_user(){
    if(!$this->_user){
      $this->_user = User::search()->where('user_id', $this->user_id)->execOne();
    }
    return $this->_user;
  }
}