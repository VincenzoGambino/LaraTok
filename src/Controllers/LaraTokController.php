<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/10/2016
 * Time: 23:23
 */
namespace VincenzoGambino\LaraTok\Controllers;

use ClassPreloader\Config;
use Illuminate\Routing\Controller as BaseController;
use VincenzoGambino\LaraTok\LaraTok;

class LaraTokController extends BaseController {

  public function admin() {
    if (!config('laratok.api.api_key') && !config('laratok.api_secret.key')) {
      return 'Please, add api_key and secret key to the laratok config file';
    }
    return 'Installed';
  }
}