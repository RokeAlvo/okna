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

    public function getMainImageOriginalAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }


    public function ranges()
    {
        return $this->hasMany('App\ApartmentsRange', 'residential_complex_id', 'residential_complex_id');
    }

    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    public function residentialComplex()
    {
        return $this->belongsTo('App\ResidentialComplex');
    }


    public function calculateFloorRangeFromApartments($type = 'short')
    {
        $floors = $this->apartments->pluck('floor')->toArray();
        $this->floor_range = getRanges($floors);
        $this->floor_min = min($floors);
        $this->floor_max = max($floors);

        if ($type == 'short') {
            if (count($this->floor_range) > 3) {
                $this->floor_range = implode(',', array_slice($this->floor_range, 0, 3)) . ' и др. этажи';
            } elseif (count($this->floor_range) > 1) {
                $this->floor_range = implode(',', $this->floor_range) . ' этажи';
            } else {
                $this->floor_range = implode(',', $this->floor_range) . ' этаж';
            }
        } elseif ($type == 'full') {
            if (count($this->floor_range) > 1) {
                $this->floor_range = implode(',', $this->floor_range) . ' этажи';
            } else {
                $this->floor_range = implode(',', $this->floor_range) . ' этаж';
            }
        }
        return $this->floor_range;
    }

    public function getPriceRange()
    {
        $apartments = $this->apartments;
        $this->apartment_price_min = $apartments->min('price');
        $this->apartment_price_max = $apartments->max('price');
        $this->apartment_price_range = ($this->apartment_price_min == $this->apartment_price_max)
            ? number_format($this->apartment_price_min, 0, ',', ' ')
            : number_format($this->apartment_price_min, 0, ',', ' ') . ' - ' . number_format($this->apartment_price_max, 0, ',', ' ');
        return $this->apartment_price_range;
    }

    public function getPriceMeterRange()
    {
        $apartments = $this->apartments;
        $this->apartment_price_meter_min = $apartments->min('price_meter');
        $this->apartment_price_meter_max = $apartments->max('price_meter');
        $this->apartment_price_meter_range = ($this->apartment_price_meter_min == $this->apartment_price_meter_max)
            ? number_format($this->apartment_price_meter_min, 0, ',', ' ')
            : number_format($this->apartment_price_meter_min, 0, ',', ' ') . ' - ' . number_format($this->apartment_price_meter_max, 0, ',', ' ');
        return $this->apartment_price_meter_range;
    }

    public function getRoomLabel($type = 'short')
    {
        $this->room_label = !empty(ROOMS[$type][$this->rooms]) ? ROOMS[$type][$this->rooms] : 'Квартира';
        return $this->room_label;
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
