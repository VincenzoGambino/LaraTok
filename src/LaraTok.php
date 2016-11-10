<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 22:23
 */

namespace VincenzoGambino\LaraTok;

use OpenTok\OpenTok;
use OpenTok\MediaMode;

class LaraTok {

  private $api_key;
  private $api_secret;
  private $opentok;
  private $session;


  /**
   * LaraTok constructor.
   */
  public function __construct() {
    $this->api_key = config('laratok.api.api_key');
    $this->api_secret = config('laratok.api.api_secret');
    $this->opentok = new OpenTok($this->api_key, $this->api_secret);
  }

  function generateSession($media_mode = NULL, $archive_mode = NULL, $location = NULL, $name = NULL) {
    $sessionOptions = array(
      'MediaMode' => $media_mode != null ? $media_mode : config('laratok.session.media_mode'),
      'ArchiveMode' => $archive_mode != NULL ? $archive_mode : config('laratok.session.archive_mode'),
      'location' => $location != NULL ? $location : config('laratok.session.location'),
    );
    $name = $name =! NULL ? $name : 'abcde';
    $this->session = $this->opentok->createSession($sessionOptions);
    dd($this->session);
  }
}