<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 22:23
 */

namespace VincenzoGambino\LaraTok;

use Illuminate\Support\Facades\Schema;
use OpenTok\OpenTok;
use VincenzoGambino\LaraTok\Facade\LaraTokFacade;
use VincenzoGambino\LaraTok\Models\LaraTokSessionModel;
use VincenzoGambino\LaraTok\Models\LaraTokTokenModel;
class LaraTok {

    /**
     * @var mixed
     */
    private $api_key;
    private $api_secret;
    private $opentok;
    private $session;
    const LARATOK_SESSION_NAME_EXAMPLE = 'laratok_session_example';


    /**
     * LaraTok constructor.
     *
     * Initialise the OpenTok object.
     */
    public function __construct() {
      $this->api_key = config('laratok.api.api_key');
      $this->api_secret = config('laratok.api.api_secret');
      $this->opentok = new OpenTok($this->api_key, $this->api_secret);
    }

  /**
   * @param null $media_mode
   * @param null $archive_mode
   * @param null $location
   * @param null $name
   */
    function generateSession($media_mode = NULL, $archive_mode = NULL, $location = NULL, $name = NULL) {
      $sessionOptions = array(
        'archiveMode' => $archive_mode != NULL ? $archive_mode : config('laratok.session.archive_mode'),
        'mediaMode' => $media_mode != null ? $media_mode : config('laratok.session.media_mode'),
        'location' => $location != NULL ? $location : config('laratok.session.location'),
      );
      $this->session = $this->opentok->createSession($sessionOptions);
      $session_id = $this->session->getSessionId();
      $name = $this->generateRandomName($name);
      LaraTokSessionModel::create([
        'session_name' => $name,
        'sessionId' => $session_id,
        'media_mode' => $sessionOptions['mediaMode'],
        'archive_mode' => $sessionOptions['archiveMode'],
        'location' => $sessionOptions['location'],
      ]);
      return $session_id;
    }

    /**
     * @param null $session_name
     * @return null|string
     */
    static function generateRandomName($session_name = NULL) {
      if($session_name == NULL) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $session_name = '';
        for ($i = 0; $i < 20; $i++) {
          $session_name .= $characters[rand(0, $charactersLength - 1)];
        }
      }
      if (Schema::hasTable('laratok_sessions')) {
        $name = LaraTokSessionModel::where('session_name', '=', $session_name)->get();
      }
      else {
        $name = 0;
      }
      $count = count($name);
      $session_name = $count >= 1 ? $session_name . '-' . $count : $session_name;
      return $session_name;
    }

  /**
   * @param null $session_id
   * @param null $role
   * @param null $expire_time
   * @param null $data
   */
    public function generateToken($session_id = NULL, $role = NULL, $expire_time = NULL, $data = NULL)  {
      $tokenOptions = array(
        'role' => $role != NULL ? $role : config('laratok.token.role'),
        'expireTime' => $expire_time != NULL ? $expire_time : config('laratok.token.expire_time'),
        'data' => $data != NULL ? $data : '',
      );
      $this->token = $this->opentok->generateToken($session_id, $tokenOptions);
      $laratok_session_id = LaraTokSessionModel::where('sessionId', '=', $session_id)->firstOrFail();
       LaraTokTokenModel::create([
        'session_id' => $laratok_session_id['id'],
        'token_id' => $this->token,
        'role' => $tokenOptions['role'],
        'expire_time' => $tokenOptions['expireTime'],
        'data' => $tokenOptions['data'],
      ]);
    }
}
