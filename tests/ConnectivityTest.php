<?php
/**
 * Created by PhpStorm.
 * User: geusebio
 * Date: 05/03/2014
 * Time: 18:21
 */

namespace tests;


use FourOneOne\ActiveRecord\DatabaseLayer;

class ConnectivityTest extends \PHPUnit_Framework_TestCase {

  public function testDatabaseConnectivity(){
    $db = DatabaseLayer::get_instance();

    $this->assertGreaterThan(0, count($db->passthru("SHOW TABLES")->execute()), "Found some tables.");

  }
}
 