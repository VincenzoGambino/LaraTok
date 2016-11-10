<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 23:19
 */

Route::group(['namespace' => 'VincenzoGambino\LaraTok\Controllers', 'prefix'=>'laratok'], function() {
  Route::get('', 'LaraTokController@admin');
});