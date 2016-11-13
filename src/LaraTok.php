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


    /**
     * LaraTok constructor.
     *
     * Initialise the OpenTok object.
     */
    public function __construct() {
      if (empty(config('laratok.api.api_key')) || empty(config('laratok.api.api_secret'))) {
        return 'Please, add api_key and secret_key to the laratok config file in /config/laratok.php';
      }
      $this->api_key = config('laratok.api.api_key');
      $this->api_secret = config('laratok.api.api_secret');
      $this->opentok = new OpenTok($this->api_key, $this->api_secret);
    }

  /**
   * Generate Session.
   * @param array $params Array containing the necessary params.
   *     $params [
   *        'media_mode' => (String) Media mode. Default larartok.session.media_mode
   *        'archive_mode' => (String) Archive mode. Default larartok.session.archive_mode
   *        'location' => (String) Location. Default larartok.session.location
   *        'name' => (String) Session name. Optional.
   *     ]
   * @return string $session_id
   */
    public function generateSession($params=NULL) {

      // Build sessionsOption array
      $sessionOptions = array(
        'archiveMode' => isset($params['archive_mode']) ? $params['archive_mode'] : config('laratok.session.archive_mode'),
        'mediaMode' => isset($params['media_mode']) ? $params['media_mode'] : config('laratok.session.media_mode'),
        'location' => isset($params['location']) ? $params['location'] : config('laratok.session.location'),
      );

      // Generate Session.
      $this->session = $this->opentok->createSession($sessionOptions);
      $session_id = $this->session->getSessionId();

      // Generate name.
      $name = isset($params['name']) ? $params['name'] : NULL;
      $name = $this->generateRandomName($name);

      // Save session in the database.
      LaraTokSessionModel::create([
        'session_name' => $name,
        'sessionId' => $session_id,
        'media_mode' => $sessionOptions['mediaMode'],
        'archive_mode' => $sessionOptions['archiveMode'],
        'location' => $sessionOptions['location'],
      ]);

      // Return session_id
      return $session_id;
    }

    /**
     * @param null $session_name
     * @return string $session_name
     */
    public function generateRandomName($session_name = NULL) {

      // Generate 20 characters random name.
      if($session_name == NULL) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $session_name = '';
        for ($i = 0; $i < 20; $i++) {
          $session_name .= $characters[rand(0, $charactersLength - 1)];
        }
      }

      // Check if name already exists.
      if (Schema::hasTable('laratok_sessions')) {
        $name = LaraTokSessionModel::where('session_name', '=', $session_name)->get();
      }
      else {
        $name = 0;
      }
      $count = count($name);

      // If it already exists, it will add a number at the end of the name.
      $session_name = $count >= 1 ? $session_name . '-' . $count : $session_name;
      return $session_name;
    }

  /**
   * Generate Token.
   * @param string $session_id.
   *
   * @param array $params Array containing the necessary params.
   *     $params [
   *        'role' => (String) Role. Default larartok.session.role
   *        'expire_time' => (String) Expire time. Default larartok.session.expire_time
   *        'data' => (String) Data. Default larartok.session.data
   *     ]
   * @return string $session_id
   */
    public function generateToken($session_id, $params=NULL)  {

      // Generate tokenOptions array.
      $tokenOptions = array(
        'role' => isset($params['role']) ? $params['role'] : config('laratok.token.role'),
        'expireTime' => isset($params['expire_time']) ? $params['expire_time'] : config('laratok.token.expire_time'),
        'data' => isset($params['data']) ? $params['data'] : '',
      );
      $this->token = $this->opentok->generateToken($session_id, $tokenOptions);

      $laratok_session_id = LaraTokSessionModel::where('sessionId', '=', $session_id)->firstOrFail();

      // Save token in database.
       LaraTokTokenModel::create([
        'session_id' => $laratok_session_id['id'],
        'token_id' => $this->token,
        'role' => $tokenOptions['role'],
        'expire_time' => $tokenOptions['expireTime'],
        'data' => $tokenOptions['data'],
      ]);
    }
}
