<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
      'alias', 'name', 'url', 'mango_widget_id', 'mango_group_id'
    ];

    protected $casts = [
      'alias' => 'string',
      'url' => 'string',
      'name' => 'string',
      'mango_widget_id' => 'integer',
      'mango_group_id' => 'integer'
    ];

    public function calls()
    {
        return $this->hasMany(Call::class, 'site_id', 'id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'site_id', 'id');
    }

    public function scopeWidget($q, $widgetId)
    {
        return $q->where('mango_widget_id', $widgetId);
    }
    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias);
    }

    public function isStilton()
    {
        return $this->alias === 'stilton';
    }
}
