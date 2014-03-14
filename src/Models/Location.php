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
  public $region_name;
  public $latitude;
  public $longitude;
  public $metro_code;
  public $postal_code;
  public $time_zone;
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

      // Set up Maxmind stuff
      global $GEOIP_REGION_NAME;
      $gi = geoip_open(APP_DISK_ROOT . "/geo/GeoIP.dat", GEOIP_STANDARD);
      $gicity = geoip_open(APP_DISK_ROOT . "/geo/GeoLiteCity.dat", GEOIP_STANDARD);
      $city = geoip_record_by_addr($gicity, $ip_addr);

      // Populate.
      $location->country = $city->country_name;
      $location->country_3 = $city->country_code3;
      $location->continent = $city->continent_code;
      $location->region = $city->region;
      $location->region_name = $GEOIP_REGION_NAME[$city->country_code][$city->region];
      $location->latitude = $city->latitude;
      $location->longitude = $city->longitude;
      $location->metro_code = $city->metro_code;
      $location->postal_code = $city->postal_code;
      $location->time_zone = get_time_zone($city->country_code, $city->region);
      $location->org = \geoip_org_by_addr($gi, $ip_addr);

      // Save 'er down.
      $location->save();

      return $location;
    }

  }

  static public function get_by_ip($ip_addr){
    return self::populate($ip_addr);
  }

}