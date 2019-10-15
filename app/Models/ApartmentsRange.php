<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentsRange extends Model
{

    /*public function getRoomsAttribute($value) {
        return (substr($value, -1) == 0) ? substr($value, 0, -1).'1' : $value;
    }*/

    public function getPriceRange()
    {
        return ($this->price_min == $this->price_max)
            ? number_format($this->price_min, 0, ',', ' ') . ' - ' . number_format($this->price_max * 1.15, 0, ',', ' ')
            : number_format($this->price_min, 0, ',', ' ') . ' - ' . number_format($this->price_max, 0, ',', ' ');
    }

    public function getRoomLabel($type = 'short')
    {
        $this->room_label = !empty(ROOMS[$type][$this->rooms]) ? ROOMS[$type][$this->rooms] : 'Квартира';
        return $this->room_label;
    }

    public static function mergeRooms($ranges)
    {

        $ranges = $ranges->keyBy('rooms');
        foreach ($ranges as $key => $range) {
            if (!empty(ROOMS['merge'][$range->rooms])) {
                $rightRange = $ranges->where('rooms', ROOMS['merge'][$range->rooms])->first();
                if ($rightRange !== null) {
                    $range->area_min = min($range->area_min, $rightRange->area_min);
                    $range->area_max = max($range->area_max, $rightRange->area_max);
                    $range->price_min = min($range->price_min, $rightRange->price_min);
                    $range->price_max = max($range->price_max, $rightRange->price_max);
                    unset($ranges[ROOMS['merge'][$range->rooms]]);
                    $range->rooms = ROOMS['merge'][$range->rooms];
                } else {
                    $range->rooms = ROOMS['merge'][$range->rooms];
                }
            }
        }

        return $ranges;
    }
}
