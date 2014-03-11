<?php
namespace LoneSatoshi\Models;

class AddressBook extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "address_book";

  public $address_book_id;
  public $user_id;
  public $name;
  public $address;
  public $created;
}