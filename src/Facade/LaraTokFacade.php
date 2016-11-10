<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 22:34
 */

namespace VincenzoGambino\LaraTok\Facade;

use Illuminate\Support\Facades\Facade;
class LaraTokFacade extends Facade
{
  protected static function getFacadeAccessor() {
    return 'vincenzogambino-laratok';
  }
}