<?php

namespace NextSpoiler\Models;

class Spoiler extends \FourOneOne\ActiveRecord\ActiveRecord{
  protected $_table = "spoilers";

  public $spoiler_id;
  public $series_id;
  public $created;
  public $relevent_until;
  public $spoiler;
}