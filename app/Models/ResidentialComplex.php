<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ResidentialComplex extends Model
{
    protected $table = 'residential_complexes';

    public function getThumbnailAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }

    public function getMainImageAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }

    public function getBgImageOriginalAttribute($value)
    {
        return 'http://smartcrm.pro' . $value;
    }


    public function isSpecific()
    {
        return in_array($this->id, array_keys(SPECIFIC_RESIDENTIALS));
    }


    public function images()
    {
        return $this->hasMany('App\Image', 'imageable_id')->where('imageable_type', 'residential_complexes');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function developer()
    {
        return $this->belongsTo('App\Developer');
    }

    public function features()
    {
        return $this->hasMany('App\ResidentialComplexFeature', 'res_complex_id', 'id');
    }

    public function houses()
    {
        return $this->hasMany('App\House');
    }

    public function ranges()
    {
        return $this->hasMany('App\ApartmentsRange');
    }

    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    public function layouts()
    {
        return $this->hasMany('App\Layout');
    }


    public function scopeActive($query, $status = true)
    {
        return $query->where('status', $status);
    }

    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias)->limit(1);
    }

    public function scopeSearch($q, $request, $alias)
    {
        return $q->with([
            'images',
            'features',
            'developer.residentials' => function ($q) use ($alias) {
                $q->where('alias', '<>', $alias);
            },
            'houses',
            'layouts' => function ($q) use ($request) {
                $q->select('id', 'residential_complex_id', 'rooms', 'area', 'thumbnail')
                    ->whereHas('apartments', function ($q) use ($request) {
                        if ($request->has('floor_range')) {
                            if (!empty($request->floor_range[0]) && !empty($request->floor_range[1])) {
                                $q->whereBetween('floor', $request->floor_range);
                            } elseif (!empty($request->floor_range[0])) {
                                $q->where('floor', '>=', $request->floor_range[0]);
                            } elseif (!empty($request->floor_range[1])) {
                                $q->where('floor', '<=', $request->floor_range[1]);
                            }
                        }
                    })->with([
                        'apartments' => function ($q) {
                            $q->select('id', 'layout_id', 'floor');
                        }
                    ]);
                if ($request->has('area_range')) {
                    if (!empty($request->area_range[0]) && !empty($request->area_range[1])) {
                        $q->whereBetween('area', $request->area_range);
                    } elseif (!empty($request->area_range[0])) {
                        $q->where('area', '>=', $request->area_range[0]);
                    } elseif (!empty($request->area_range[1])) {
                        $q->where('area', '<=', $request->area_range[1]);
                    }
                }
                if ($request->has('rooms')) {
                    if (!empty($request->rooms)) {
                        $q->whereIn('rooms', $request->rooms);
                    }
                }
                /*if ($request->page > 1) {
                    $q->skip(($request->page - 1) * $request->per_page);
                }
                $q->take($request->per_page);*/
            },
            'ranges' => function ($q) {
                $q->orderBy('rooms');
            },
        ]);
    }


    public function getHousesCompletionDatesRange()
    {
        function isBuilt(Carbon $now, $year, $quarter)
        {
            return $now->year > $year || ($now->year == $year && $now->quarter > $quarter);
        }

        function getQuarter($quarter)
        {
            return in_array($quarter, [1, 2, 3, 4]) ? QUARTERS['short'][$quarter] : '';
        }

        $nowDate = Carbon::now();
        if ($this->houses->count() > 1) {
            $minCompletionYear = $this->houses->min('completion_year');
            $maxCompletionYear = $this->houses->max('completion_year');
            $minCompletionDecade = $this->houses->where('completion_year', $minCompletionYear)->min('completion_decade');
            $maxCompletionDecade = $this->houses->where('completion_year', $maxCompletionYear)->max('completion_decade');
            $minCompletionDate = (!isBuilt($nowDate, $minCompletionYear, $minCompletionDecade))
                ? getQuarter($minCompletionDecade) . ' ' . $minCompletionYear
                : 'Сдан';
            if ($minCompletionYear != $nowDate->year || $minCompletionDecade != $nowDate->quarter) :
                $maxCompletionDate = (!isBuilt($nowDate, $maxCompletionYear, $maxCompletionDecade))
                    ? getQuarter($maxCompletionDecade) . ' ' . $maxCompletionYear
                    : 'Сдан';
            endif;
            return (!isset($maxCompletionDate) || $minCompletionDate == $maxCompletionDate)
                ? $minCompletionDate
                : $minCompletionDate . ' - ' . $maxCompletionDate;
        } else {
            $house = $this->houses->first();
            if ($house == null) {
                return '';
            }
            return (!isBuilt($nowDate, $house->completion_year, $house->completion_decade))
                ? getQuarter($house->completion_decade) . ' ' . $house->completion_year
                : 'Сдан';
        }
    }

    public function getGallery()
    {
        $images = $this->images
            ->whereIn('type', [2, 3])
            ->groupBy(function ($image) {
                return substr($image->path, -20);
            });
        foreach ($images as $key => $imageGroup) {
            $images['http://smartcrm.pro' . $imageGroup->where('type', 2)->first()->path] = 'http://smartcrm.pro' . $imageGroup->where('type', 3)->last()->path;
            unset($images[$key]);
        }
        return $images;
    }

}
