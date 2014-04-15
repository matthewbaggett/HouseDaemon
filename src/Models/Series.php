<?php

namespace NextSpoiler\Models;

class Series extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "series";

  public $series_id;
  public $created;
  public $name;
  public $user_id;

  private $_user;

  /**
   * Get the next spoiler
   * @return Spoiler
   */
  public function get_next_spoiler(){
    $spoiler_search = Spoiler::search();
    $spoiler_search->where('relevant_until', date("Y-m-d H:i:s"), '>=');
    $spoiler_search->where('series_id', $this->series_id);
    return $spoiler_search->execOne();
  }

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