<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    public function getThumbnailAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }

    public function getMainImageAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }


    public function ranges()
    {
        return $this->hasMany('App\ApartmentsRange', 'residential_complex_id', 'residential_complex_id');
    }


    /*public function scopeRoom($q, $room)
    {
        return $q->select('id', 'residential_complex_id', 'rooms', 'area', 'thumbnail')
            ->whereHas('apartments')
            ->with([
                'apartments' => function ($q) {
                    $q->select('id', 'layout_id', 'floor');
                }
            ])
            ->where('rooms', $room);
    }*/


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

    public function getRoomPriceRange()
    {
        $range = $this->ranges()->where('rooms', $this->rooms)->first();
        $this->price_min = $range->price_min;
        $this->price_min_format = number_format($range->price_min, 0, ',', ' ');
        $this->price_max = ($range->price_min == $range->price_max) ? $range->price_max * 1.15 : $range->price_max;
        $this->price_max_format = number_format($this->price_max, 0, ',', ' ');
        $this->price_range = $this->price_min_format . ' - ' . $this->price_max_format;
        return $this->price_range;
    }
}
