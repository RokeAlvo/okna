<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    public function getLogoAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }

    public function statistics()
    {
        return $this->hasMany('App\DeveloperStatistic');
    }

    public function features()
    {
        return $this->hasMany('App\DeveloperFeature', 'dev_id', 'id');
    }

    public function residentials()
    {
        return $this->hasMany('App\ResidentialComplex');
    }

    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias)->limit(1);
    }

    public function scopeActive($query, $status = true)
    {
        return $query->where('status', $status);
    }


}
