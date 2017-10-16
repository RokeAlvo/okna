<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    public function getThumbnailAttribute($value) {
        return 'http://smartcrm.pro' . $value;
    }


    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    public function calculateFloorRangeFromApartments() {
        $floors = $this->apartments->pluck('floor')->toArray();
        $this->floor_range = getRanges($floors);
        $this->floor_min = min($floors);
        $this->floor_max = max($floors);
    }

    public function getRoomLabel() {
        $this->room_label = !empty(ROOMS['short'][$this->rooms]) ? ROOMS['short'][$this->rooms] : 'Квартира';
    }
}
