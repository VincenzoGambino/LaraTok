<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 22:23
 */

namespace VincenzoGambino\LaraTok;

use OpenTok\OpenTok;

class LaraTok {

  public $api_key;
  public $api_secret;
  public $opentok;

  public function __construct() {
    $this->api_key = config('laratok.api.api_key');
    $this->api_secret = config('laratok.api.api_secret');
    $this->opentok = new OpenTok($this->api_key, $this->api_secret);
  }

  function generateSession() {
    $this->session = $this->opentok->createSession();
    dd($this->session);
  }
}