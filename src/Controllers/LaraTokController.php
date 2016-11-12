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

  public function admin() {
    if (!config('laratok.api.api_key') && !config('laratok.api_secret.key')) {
      return 'Please, add api_key and secret_key to the laratok config file in /config/laratok.php';
    }
    $sessions = DB::table('laratok_tokens')
      ->leftJoin('laratok_sessions', 'laratok_tokens.session_id', '=', 'laratok_sessions.id')
      ->select('laratok_sessions.session_name', 'laratok_tokens.*')
      ->get()
      ->groupBy('session_name');

    return view('laratok::admin.laratok', compact('sessions'));
  }

  public function simple() {
    $laratok = DB::table('laratok_sessions')
      ->select('sessionId')
      ->crossJoin('laratok_tokens', 'laratok_sessions.id', '=', 'laratok_tokens.session_id')
      ->select('laratok_tokens.*', 'laratok_sessions.*')
      ->get()
      ->first();
    return $laratok;
    //return view('laratok::examples.simples', compact('laratok'));
  }
}