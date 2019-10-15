<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    public function layout()
    {
        return $this->belongsTo('App\Layout');
    }

    public function house()
    {
        return $this->belongsTo('App\House');
    }

    public function getRoomLabel($type = 'short')
    {
        return $this->room_label = !empty(ROOMS[$type][$this->rooms]) ? ROOMS[$type][$this->rooms] : '';
    }

    public function scopeRooms($q, $request)
    {
        if ($request->has('rooms')) {
            $rooms = $request->rooms;
            foreach ($rooms as $room) {
                if ($roomStudio = array_search($room, ROOMS['merge'])) {
                    $rooms[] = $roomStudio;
                }
            }
            return $q->whereIn('rooms', $rooms);
        }
    }

    public function scopeAreaRange($q, $request)
    {
        if ($request->has('area_range')) {
            if (!empty($request->area_range[0]) && !empty($request->area_range[1])) {
                $q->whereBetween('area', $request->area_range);
            } elseif (!empty($request->area_range[0])) {
                $q->where('area', '>=', $request->area_range[0]);
            } elseif (!empty($request->area_range[1])) {
                $q->where('area', '<=', $request->area_range[1]);
            }
        }
        return $q;
    }

    public function scopePriceRange($q, $request, $multiplication = 1)
    {
        if ($request->has('price_range')) {
            if (!empty($request->price_range[0]) && !empty($request->price_range[1])) {
                $q->whereBetween('price', [$request->price_range[0] * $multiplication, $request->price_range[1] * $multiplication]);
            } elseif (!empty($request->price_range[0])) {
                $q->where('price', '>=', $request->price_range[0] * $multiplication);
            } elseif (!empty($request->area_range[1])) {
                $q->where('price', '<=', $request->price_range[1] * $multiplication);
            }
        }
        return $q;
    }
}
