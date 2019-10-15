<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Layout extends Model
{
    const LAYOUT_PATH = 'layouts/';
    const TMP_PATH = 'tmp/';

    protected $city;

    protected $storagePath;

    function __construct()
    {
        $this->city = getUrlPathFirstPart(true);
        $this->storagePath = $this->city === 'nsk' ? '/storage/' : '/storage-prod/';
    }

    public function getThumbnailAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::LAYOUT_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }
    public function getMainImageAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::LAYOUT_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }
    public function getMainImageOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::LAYOUT_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
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
    public function house()
    {
        return $this->belongsTo('App\House');
    }


    public function calculateFloorRangeFromApartments($short = true)
    {
        $floors = $this->apartments->pluck('floor')->toArray();
        $this->floor_range_array = getRanges($floors);
        $this->floor_min = min($floors);
        $this->floor_max = max($floors);

        $floorRange = implode(',', $this->floor_range_array);
        $countFloorRange = count($this->floor_range_array);
        $floorRangeShort = ($countFloorRange > 3) ? implode(',', array_slice($this->floor_range_array, 0, 3)) . ' и др. ' : $floorRange;

        $end = ($countFloorRange > 1) ? ' этажи' : ' этаж';

        $this->floor_range = $floorRange . $end;
        $this->floor_range_etc = $floorRangeShort . $end;
        $this->floor_range_numbers = $floorRangeShort;
        $this->floor_range_popup = $short ? $this->floor_range_numbers : $this->floor_range_etc;

        return $this->floor_range;
    }

    public function getPriceRange()
    {
        $apartments = $this->apartments()->get();
        $this->apartment_price_min = $apartments->min('price');
        $this->apartment_price_max = $apartments->max('price');
        $thousandsSeparator = chr(0xC2) . chr(0xA0); // неразрывный пробел
        $this->apartment_price_range = ($this->apartment_price_min == $this->apartment_price_max)
            ? number_format($this->apartment_price_min, 0, ',', $thousandsSeparator)
            : number_format($this->apartment_price_min, 0, ',', $thousandsSeparator) . $thousandsSeparator . '- ' . number_format($this->apartment_price_max, 0, ',', $thousandsSeparator);
        $this->apartment_price_range_short = ($this->apartment_price_min == $this->apartment_price_max)
            ? number_format(round($this->apartment_price_min / 1000), 0, ',', $thousandsSeparator)
            : number_format(round($this->apartment_price_min / 1000), 0, ',', $thousandsSeparator) . $thousandsSeparator . '- ' . number_format(round($this->apartment_price_max / 1000), 0, ',', $thousandsSeparator);
        return $this->apartment_price_range;
    }

    public function getPriceMeterRange()
    {
        $apartments = $this->apartments;
        $this->apartment_price_meter_min = $apartments->min('price_meter');
        $this->apartment_price_meter_max = $apartments->max('price_meter');
        $thousandsSeparator = chr(0xC2) . chr(0xA0); // неразрывный пробел
        $this->apartment_price_meter_range = ($this->apartment_price_meter_min == $this->apartment_price_meter_max)
            ? number_format($this->apartment_price_meter_min, 0, ',', $thousandsSeparator)
            : number_format($this->apartment_price_meter_min, 0, ',', $thousandsSeparator) . $thousandsSeparator . '- ' . number_format($this->apartment_price_meter_max, 0, ',', $thousandsSeparator);
        return $this->apartment_price_meter_range;
    }

    public function getRoomLabel($type = 'short')
    {
        $rooms = $this->rooms;
        if (!empty(ROOMS['merge'][$this->rooms])) {
            $rooms = ROOMS['merge'][$this->rooms];
        }
        $this->merge_rooms = $rooms . "";
        $this->room_label = !empty(ROOMS[$type][$rooms]) ? ROOMS[$type][$rooms] : 'Квартира';
        $this->room_label_short = !empty(ROOMS['short'][$rooms]) ? ROOMS['short'][$rooms] : 'кв.';
        $this->room_label_full = !empty(ROOMS['full'][$rooms]) ? ROOMS['full'][$rooms] : 'Квартира';
        $this->room_label_genitive = !empty(ROOMS['genitive'][$rooms]) ? ROOMS['genitive'][$rooms] : 'квартир';
        return $this->room_label;
    }

    public function getRoomPriceRange()
    {
        $range = $this->ranges->where('rooms', $this->rooms)->first();
        if ($range) {
            $thousandsSeparator = chr(0xC2) . chr(0xA0); // неразрывный пробел
            $this->price_min = $range->price_min;
            $this->price_min_format = number_format($range->price_min, 0, ',', $thousandsSeparator);
            $this->price_max = ($range->price_min == $range->price_max) ? $range->price_max * 1.15 : $range->price_max; // Дмитрий так захотел, чтобы не показывать пользователю точную цену
            $this->price_max_format = number_format($this->price_max, 0, ',', $thousandsSeparator);
            $this->price_range = $this->price_min_format . $thousandsSeparator . '- ' . $this->price_max_format;
        } else {
            $this->price_range = 0;
        }
        return $this->price_range;
    }

    public function getResidentialCompletionDate($type = 'short')
    {
        $this->residential_completion_date = !empty($this->residentialComplex) ? $this->residentialComplex->getCompletionDate($type) : null;
        return $this->residential_completion_date;
    }
}
