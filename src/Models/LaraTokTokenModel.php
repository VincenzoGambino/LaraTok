<?php

namespace VincenzoGambino\LaraTok;

use Illuminate\Database\Eloquent\Model;

class LaraTokTokenModel extends Model
{
    //
    protected $table = 'laratok_tokens';
    protected $fillable = [
      'session_id',
      'token_id',
      'role',
      'expire_time',
      'data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sessionID() {
      return $this->belongsToMany('LaraTok\LaraTokSessionModel');
    }
}
