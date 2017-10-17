<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    public function getThumbnailAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }


    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    public function calculateFloorRangeFromApartments()
    {
        $floors = $this->apartments->pluck('floor')->toArray();
        $this->floor_range = getRanges($floors);
        $this->floor_min = min($floors);
        $this->floor_max = max($floors);

        if (count($this->floor_range) > 2) {
            $this->floor_range = implode(',', array_slice($this->floor_range, 0, 2)) . ' и др. этажи';
        } elseif (count($this->floor_range) > 1) {
            $this->floor_range = implode(',', $this->floor_range) . ' этажи';
        } else {
            $this->floor_range = implode(',', $this->floor_range) . ' этаж';
        }
    }

    public function getRoomLabel()
    {
        $this->room_label = !empty(ROOMS['short'][$this->rooms]) ? ROOMS['short'][$this->rooms] : 'Квартира';
    }
}
