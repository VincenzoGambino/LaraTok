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
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function examples() {
    $sessions = DB::table('laratok_tokens')
      ->leftJoin('laratok_sessions', 'laratok_tokens.session_id', '=', 'laratok_sessions.id')
      ->select('laratok_sessions.session_name', 'laratok_tokens.*')
      ->where('laratok_sessions.session_name', '=', self::LARATOK_SESSION_NAME_EXAMPLE)
      ->get()
      ->groupBy('session_name');

    return view('laratok::examples.examples', compact('sessions'));
  }

  /**
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function generateExamples() {
    $sessions = DB::table('laratok_sessions')
      ->select('sessionId')
      ->where('session_name', '=', self::LARATOK_SESSION_NAME_EXAMPLE)
      ->get()
      ->first();
    if ($sessions == NULL) {
      $laratok = new LaraTok();
      $session = $laratok->generateSession(self::LARATOK_SESSION_NAME_EXAMPLE);
      $laratok->generateToken($session);
    }
    return redirect('laratok/examples');
  }

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function simple() {
    $laratok = DB::table('laratok_sessions')
      ->select('sessionId')
      ->crossJoin('laratok_tokens', 'laratok_sessions.id', '=', 'laratok_tokens.session_id')
      ->select('laratok_tokens.*', 'laratok_sessions.*')
      ->get()
      ->first();

    return view('laratok::examples.simples', compact('laratok'));
  }

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function simpleSignaling() {
    $laratok = DB::table('laratok_sessions')
      ->select('sessionId')
      ->crossJoin('laratok_tokens', 'laratok_sessions.id', '=', 'laratok_tokens.session_id')
      ->select('laratok_tokens.*', 'laratok_sessions.*')
      ->get()
      ->first();

    return view('laratok::examples.signaling', compact('laratok'));
  }
}
