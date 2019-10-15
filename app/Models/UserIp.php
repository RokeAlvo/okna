<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool|string $ip
 * @property int $user_id
 * @property int $requests
 */
class UserIp extends Model
{
    protected $table = 'user_ip';

    protected $fillable = [
      'user_id', 'ip', 'project'
    ];

    protected $casts = [
      'user_id' => 'integer',
      'requests' => 'integer'
    ];

    protected $connection = 'novosibirsk';

}
