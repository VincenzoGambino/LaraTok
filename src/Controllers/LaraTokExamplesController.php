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

class LaraTokExamplesController extends BaseController {

  const LARATOK_SESSION_NAME_EXAMPLE = 'laratok_session_example';

  /**
   * View list of example tokens.
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function examples() {

    // Retrieve tokens.
    $sessions = DB::table('laratok_tokens')
      ->leftJoin('laratok_sessions', 'laratok_tokens.session_id', '=', 'laratok_sessions.id')
      ->select('laratok_sessions.session_name', 'laratok_tokens.*')
      ->where('laratok_sessions.session_name', '=', self::LARATOK_SESSION_NAME_EXAMPLE)
      ->get()
      ->groupBy('session_name');

    return view('laratok::examples.examples', compact('sessions'));
  }

  /**
   * Generate example tokens and session.
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function generateExamples() {

    // Check if session example already exists.
    $sessions = DB::table('laratok_sessions')
      ->select('sessionId')
      ->where('session_name', '=', self::LARATOK_SESSION_NAME_EXAMPLE)
      ->get()
      ->first();

    // if it not exists, it will generate the session example.
    if ($sessions == NULL) {
      $laratok = new LaraTok();
      $session_params = array();
      $session_params['name'] = self::LARATOK_SESSION_NAME_EXAMPLE;
      $session = $laratok->generateSession($session_params);
      $laratok->generateToken($session);
    }
    return redirect('laratok/examples');
  }

  /**
   * Display Simple one to one video chat.
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function simple() {

    // Retrieve session and token.
    $laratok = DB::table('laratok_sessions')
      ->select('sessionId')
      ->crossJoin('laratok_tokens', 'laratok_sessions.id', '=', 'laratok_tokens.session_id')
      ->select('laratok_tokens.*', 'laratok_sessions.*')
      ->get()
      ->first();

    return view('laratok::examples.simples', compact('laratok'));
  }

  /**
   * Display one to one video chat with messaggin.
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function simpleSignaling() {

    // Retrieve session and token.
    $laratok = DB::table('laratok_sessions')
      ->select('sessionId')
      ->crossJoin('laratok_tokens', 'laratok_sessions.id', '=', 'laratok_tokens.session_id')
      ->select('laratok_tokens.*', 'laratok_sessions.*')
      ->get()
      ->first();

    return view('laratok::examples.signaling', compact('laratok'));
  }
}
