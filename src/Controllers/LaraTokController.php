<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 23:23
 */
namespace VincenzoGambino\LaraTok\Controllers;

use ClassPreloader\Config;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use VincenzoGambino\LaraTok\LaraTok;
use VincenzoGambino\LaraTok\Models\LaraTokTokenModel;

class LaraTokController extends BaseController {

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
   */
  public function admin() {
    if (empty(config('laratok.api.api_key')) && empty(config('laratok.api.api_secret'))) {
      $no_api = 'Please, add api_key and secret_key to the laratok config file in /config/laratok.php';
      return view('laratok::examples.examples', compact('no_api'));
    }
    $sessions = DB::table('laratok_tokens')
      ->leftJoin('laratok_sessions', 'laratok_tokens.session_id', '=', 'laratok_sessions.id')
      ->select('laratok_sessions.session_name', 'laratok_tokens.*')
      ->get()
      ->groupBy('session_name');

    return view('laratok::admin.admin', compact('sessions'));
  }
}
