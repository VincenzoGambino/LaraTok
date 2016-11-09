<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/10/2016
 * Time: 23:19
 */

Route::group(['namespace' => 'VincenzoGambino\LaraTok\Controllers', 'prefix'=>'laratok'], function() {
  Route::get('', 'LaraTokController@admin');
});