<?php

namespace LoneSatoshi\Models;

require_once(APP_DISK_ROOT . "/vendor/geoip/geoip/src/timezone.php");

class Location extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "locations";

  public $location_id;
  public $address;
  public $country;
  public $country_2;
  public $country_3;
  public $continent;
  public $region;
  public $region_name;
  public $latitude;
  public $longitude;
  public $city;
  public $metro_code;
  public $postal_code;
  public $time_zone;
  public $org;

  /**
   * @param $ip_addr
   * @return Location
   */
  static public function populate($ip_addr){
    $location = Location::search()
      ->where('address', $ip_addr)
      ->execOne();
    if($location instanceof Location){
      return $location;
    }else{
      $location = new Location();

      // Set up Maxmind stuff
      $gi = geoip_open(APP_DISK_ROOT . "/geo/GeoIP.dat", GEOIP_STANDARD);
      $gicity = geoip_open(APP_DISK_ROOT . "/geo/GeoLiteCity.dat", GEOIP_STANDARD);
      global $GEOIP_REGION_NAME;

      // Get Data.
      $city = geoip_record_by_addr($gicity, $ip_addr);
      $org = geoip_org_by_addr($gi, $ip_addr);
      var_dump($org);exit;

      // Populate.
      require(APP_DISK_ROOT . "/vendor/geoip/geoip/src/geoipregionvars.php");

      $region_name = $GEOIP_REGION_NAME[$city->country_code][$city->region];

      //die("Region Name for {$ip_addr} [{$city->country_code}][{$city->region}] = {$region_name}");
      $location->address = $ip_addr;
      $location->country = $city->country_name;
      $location->country_2 = $city->country_code;
      $location->country_3 = $city->country_code3;
      $location->continent = $city->continent_code;
      $location->region = $city->region;
      $location->region_name = $region_name;
      $location->latitude = $city->latitude;
      $location->longitude = $city->longitude;
      $location->city = $city->city;
      $location->metro_code = $city->metro_code;
      $location->postal_code = $city->postal_code;
      try{
        $location->time_zone = \get_time_zone($city->country_code, $city->region);
      }catch(\Exception $e){
        $location->time_zone = null;
      }
      $location->org = $org;

      // Save 'er down.
      $location->save();

      return $location;
    }
  }

  static public function get_by_ip($ip_addr){
    return self::populate($ip_addr);
  }

  public function get_place(){
    if(!$this->country){
      return "Unknown Place";
    }
    if(!$this->region){
      return "{$this->country}";
    }
    if(!$this->city){
      return "{$this->region}, {$this->country}";
    }else{
      return "{$this->city}, {$this->region}, {$this->country_3}";
    }
  }

}