<?php
/**
 * Created by PhpStorm.
 * User: geusebio
 * Date: 05/03/2014
 * Time: 17:49
 */
namespace tests;
use LoneSatoshi\Models\User;

require_once("./vendor/autoload.php");
require_once("./src/config/config.php");


class ModelUserTest extends \PHPUnit_Framework_TestCase {

  static public function GetTestUser(){
    $o = new User();
    $o->username = uniqid("Goon");
    $o->created = date("Y-m-d H:i:s");
    $o->displayname = uniqid("DisplayName ");
    $o->email = "{$o->username}@example.com";
    $o->set_password(uniqid());
    return $o;
  }

  public function testAccountHasCorrectProperties(){
    $o = new User();
    $this->assertEquals(true, property_exists($o, "user_id"), "Has User ID");
    $this->assertEquals(true, property_exists($o, "username"), "Has Username");
    $this->assertEquals(true, property_exists($o, "displayname"), "Has Displayname");
    $this->assertEquals(true, property_exists($o, "email"), "Has Email");
    $this->assertEquals(true, property_exists($o, "created"), "Has Created");
  }

  public function testAccountCanSaveAndLoadAndDestroy(){

    $o = self::GetTestUser()->save();


    //Check that $o got an account_id set to it.
    $this->assertGreaterThan(0, $o->user_id, "User ID set by primary key insertion");

    // Pull out the saved item.
    $j = User::search()->where('user_id', $o->user_id)->execOne();

    $this->assertEquals("LoneSatoshi\\Models\\User", get_class($j), "Object was retrieved");
    $this->assertEquals($o->created, $j->created, "Created Date matches");
    $this->assertEquals($o->user_id, $j->user_id, "User ID matches");
    $this->assertEquals($o->username, $j->username, "Username matches");
    $this->assertEquals($o->displayname, $j->displayname, "Display name matches");

    // Destroy the item.
    $j->delete();

    // Try to pull the deleted item again
    $j = User::search()->where('account_id', $o->user_id)->execOne();

    $this->assertEquals(false, $j, "Clone Object was destroyed");

    // Try to reload the old $o object.

    $gone = $o->reload();
    $this->assertEquals(false, $gone, "Original Object was destroyed");

  }

  /**
   * @expectedException Exception
   *
   */
  public function testAccountEmailAddressMustBeUnique(){
    $user_one = self::GetTestUser();
    $user_two = self::GetTestUser();

    $user_two->email = $user_one->email;

    $user_one->save();

    $user_two->save();

    $user_one->delete();

  }
}
 