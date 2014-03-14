<?php

namespace LoneSatoshi\Models;

class Location extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "locations";

  public $location_id;
  public $address;
  public $country;
  public $country_3;
  public $continent;
  public $region;
  public $org;

  /**
   * @param $ip_addr
   * @return Location
   */
  static public function populate($ip_addr){
    $location = Location::search()->where('address', $ip_addr)->execOne();
    if($location instanceof Location){
      return $location;
    }else{
      $location = new Location();
      $gi = geoip_open(APP_DISK_ROOT . "/GeoIP.dat", GEOIP_STANDARD);
      $location->country = geoip_country_name_by_addr($gi, $ip_addr);
      $location->country_3 = geoip_country_code3_by_name($gi, $ip_addr);
      $location->continent = geoip_continent_code_by_name($gi, $ip_addr);
      $location->region = geoip_region_by_addr($gi, $ip_addr);
      $location->org = geoip_org_by_addr($gi, $ip_addr);
      $location->save();

      return $location;
    }

  }

}