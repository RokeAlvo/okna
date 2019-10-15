<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Developer extends Model
{
    const DEV_PATH = 'developers/';
    const TMP_PATH = 'tmp/';

    protected $city;

    protected $storagePath;

    function __construct() {
        parent::__construct();
        $this->city = getUrlPathFirstPart(true);
        $this->storagePath = $this->city === 'nsk' ? '/storage/' : '/storage-prod/';
    }

    public function getLogoAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::DEV_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getLogoOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::DEV_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
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

    public function apartments()
    {
        return $this->hasMany('App\Apartment', 'owner_id', 'id')->where('owner', 1);
    }

    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias)->limit(1);
    }

    public function scopeActive($query, $status = true)
    {
        $query->where('status', $status);
        if(isset(ALWAYS_INACTIVE_RESIDENTIALS[getUrlPathFirstPart()])) {
            $query->whereNotIn('id', ALWAYS_INACTIVE_RESIDENTIALS[getUrlPathFirstPart()]);
        }
        return $query;
    }


}
