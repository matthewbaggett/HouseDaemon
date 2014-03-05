<?php
/**
 * Created by PhpStorm.
 * User: geusebio
 * Date: 05/03/2014
 * Time: 17:49
 */
namespace tests;
require_once("./vendor/autoload.php");
require_once("./src/config/config.inc");


class ModelAccountTest extends \PHPUnit_Framework_TestCase {

  public function testAccountHasCorrectProperties(){
    $o = new \LoneSatoshi\Models\Account();
    $this->assertEquals(true, property_exists($o, "account_id"), "Has Account ID");
    $this->assertEquals(true, property_exists($o, "user_id"), "Has User ID");
    $this->assertEquals(true, property_exists($o, "address"), "Has Address");
    $this->assertEquals(true, property_exists($o, "created"), "Has Created");
  }

  public function testAccountCanSaveAndLoadAndDestroy(){
    $test_user = ModelUserTest::getTestUser()->save();
    $o = new \LoneSatoshi\Models\Account();
    $o->address = "Test_" . uniqid();
    $o->created = date("Y-m-d H:i:s");
    $o->user_id = $test_user->user_id;

    $o->save();

    //Check that $o got an account_id set to it.
    $this->assertGreaterThan(0, $o->account_id, "Account ID set by primary key insertion");

    // Pull out the saved item.
    $j = \LoneSatoshi\Models\Account::search()->where('account_id', $o->account_id)->execOne();

    $this->assertEquals("LoneSatoshi\\Models\\Account", get_class($j), "Object was retrieved");
    $this->assertEquals($o->created, $j->created, "Created Date matches");
    $this->assertEquals($o->user_id, $j->user_id, "User ID matches");
    $this->assertEquals($o->address, $j->address, "Address matches");

    // Destroy the item.
    $j->delete();

    // Try to pull the deleted item again
    $j = \LoneSatoshi\Models\Account::search()->where('account_id', $o->account_id)->execOne();

    $this->assertEquals(false, $j, "Object was destroyed");

    // Clean up

    $test_user->delete();
  }
}
 