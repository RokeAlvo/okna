<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetrikaReachGoal extends Model
{
    protected $fillable = [
        'goal_id', 'url', 'ip'
    ];

    protected $casts = [
        'goal_id' => 'integer',
        'url' => 'string'
    ];

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = mb_substr($value, 0, 250);
    }

    public function goal()
    {
        return $this->belongsTo(MetrikaGoal::class, 'goal_id', 'id');
    }
}
