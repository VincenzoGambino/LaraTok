<?php

namespace VincenzoGambino\LaraTok\Models;

use Illuminate\Database\Eloquent\Model;

class LaraTokSessionModel extends Model
{
    protected $table = 'laratok_sessions';
    protected $fillable = [
      'session_name',
      'session_id',
      'media_mode',
      'archive_mode',
      'location'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens() {
      return $this->hasMany('LaraTok\LaraTokTokenModel');
    }
}
