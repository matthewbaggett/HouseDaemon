<?php
namespace LoneSatoshi\Models;

class User extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "users";

  public $user_id;
  public $username;
  public $displayname;
  public $password;
  public $email;
  public $created;

  public function set_password($password){
    // TODO: Something a bit better than SHA1 I think.
    $this->password = hash("SHA1", $password);
    return $this;
  }

  static public function check_logged_in(){
    if(self::get_current() instanceof User){
      return false;
    }else{
      header("Location: /login");
      exit;
    }
  }

  /**
   * Get the current user.
   * @return User|false
   */
  static public function get_current(){
    if(isset($_SESSION['user'])){
      if($_SESSION['user'] instanceof User){
        return User::search()->where('user_id', $_SESSION['user']->user_id)->execOne();
      }
    }
    return false;
  }

  /**
   * Get users addressbook.
   *
   * @return AddressBook[]|false
   */
  public function get_addresses(){
    return AddressBook::search()->where('user_id', $this->user_id)->exec();
  }

  /**
   * @return Balance[]|false
   */
  public function get_balances($sort_by = null, $direction = null){
    $query = Balance::search();
    $query->where('user_id', $this->user_id);
    if($sort_by !== null){
      $query->order($sort_by, $direction);
    }
    return $query->exec();
  }

  public function pay($address, $amount){
    // Loop over balances until paid.
    foreach($this->get_balances('balance', 'ASC') as $balance){
      if($balance->balance >= $amount){
        $balance->pay($address, $amount);
        continue;
      }else{
        $amount = $amount - $balance->balance;
        $balance->pay($address, $balance->balance);
      }
    }
    exit;

  }
}