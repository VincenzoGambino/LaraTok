<?php
/**
 * Created by Vincenzo Gambino
 * Date: 22/06/2016
 * Time: 22:58
 */

return [
  'api' => [
    'api_key' => '',
    'api_secret' => '',
  ],
  'session' => [
    'media_mode' => 'enabled', // enabled = relayed, disbaled = routed
    'archive_mode' => 'manual', // manual, always
    'location' => NULL,
  ],
  'token' => [
    'role' => 'publisher', // moderator, publisher, subscriber
    'expire_date' => NULL,
    'data' => NULL,
  ],
];
