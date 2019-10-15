<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetrikaGoal extends Model
{
    protected $fillable = [
        'alias'
    ];

    protected $casts = [
        'alias' => 'string'
    ];

    public function reaches()
    {
        return $this->hasMany(MetrikaReachGoal::class, 'goal_id', 'id');
    }

    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias);
    }
}
