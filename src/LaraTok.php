<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/10/2016
 * Time: 22:23
 */

namespace VincenzoGambino\LaraTok;

use OpenTok\OpenTok;

class LaraTok {

  public $api_key;
  public $api_secret;
  public $opentok;

  public function __construct() {
    $this->api_key = config('laratok.key.api_key');
    $this->api_secret = config('laratok.key.api_secret');
    $this->opentok = new OpenTok($this->api_key, $this->api_secret);
  }
}