<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 23:19
 */

Route::group(['namespace' => 'VincenzoGambino\LaraTok\Controllers', 'prefix'=>'laratok'], function() {
  Route::get('', 'LaraTokController@admin');
});

Route::group(['namespace' => 'VincenzoGambino\LaraTok\Controllers', 'prefix'=>'laratok/examples'], function() {
  Route::get('', 'LaraTokExamplesController@examples');
  Route::get('simple', 'LaraTokExamplesController@simple');
  Route::post('generate', 'LaraTokExamplesController@generateExamples');
});