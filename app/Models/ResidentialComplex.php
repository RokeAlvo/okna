<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ResidentialComplex extends Model
{
    const RC_PATH = 'residentials/';
    const TMP_PATH = 'tmp/';

    protected $table = 'residential_complexes';

    protected $city;

    protected $storagePath;

    function __construct()
    {

        parent::__construct();
        $this->city = getUrlPathFirstPart(true);
        $this->storagePath = $this->city === 'nsk' ? '/storage/' : '/storage-prod/';
    }

    public function getMainImageAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getMainImageOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getThumbnailAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getThumbnailOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getBgImageOriginalAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function getSearchImageAttribute($value)
    {
        if (!empty($value)) {
            return $this->storagePath . $this->city . '/' . self::RC_PATH . $this->id . '/' . $value;
        } else {
            return $value;
        }
    }

    public function isSpecific()
    {
        return in_array(
            $this->id,
            (!empty(SPECIFIC_RESIDENTIALS[getUrlPathFirstPart()]) && !empty(SPECIFIC_RESIDENTIALS[getUrlPathFirstPart()])) ? array_keys(SPECIFIC_RESIDENTIALS[getUrlPathFirstPart()]) : []
          ) ||
          in_array(
            $this->developer_id,
            (!empty(SPECIFIC_DEVELOPERS[getUrlPathFirstPart()]) && !empty(SPECIFIC_DEVELOPERS[getUrlPathFirstPart()])) ? array_keys(SPECIFIC_DEVELOPERS[getUrlPathFirstPart()]) : []
          );
    }


    public function images()
    {
        return $this->hasMany('App\ResidentialComplexGalleryImage', 'residential_complex_id');
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

    public function tradeIn()
    {
        return $this->hasOne('App\TradeIn');
    }

    public function installment()
    {
        return $this->hasOne('App\Installment');
    }

    public function mortgageOST()
    {
        return $this->hasOne('App\MortgageOST');
    }

    public function mortgageWIF()
    {
        return $this->hasOne('App\MortgageWIF');
    }

    public function banks()
    {
        return $this->hasManyThrough('App\Bank', 'App\House');
    }

    public function metroStation()
    {
        return $this->belongsTo(MetroStation::class, 'metro_station_id', 'id');
    }

    public function infrastructures()
    {
        return $this->belongsToMany('App\Infrastructure',
          'infrastructure_residential_complex',
          'res_complex_id',
          'infrastructure_id',
          'id');
    }


    public function scopeClosestTo($q, $lat, $lng, $alias = 'distance')
    {
        //To search by miles instead of kilometers, replace 6371 with 3959
        return $q->selectRaw('latitude, longitude, (6371 * acos (
                cos ( radians( ' . $lat . ' ) )
                * cos( radians( latitude ) )
                * cos( radians( longitude ) - radians( ' . $lng . ' ) )
                + sin ( radians( ' . $lat . ' ) )
                * sin( radians( latitude ) )
            )
        ) AS ' . $alias);
    }
    public function scopeActive($query, $status = true)
    {
        return $query->where('status_okna', $status)/*->whereNotIn('id', [30,118,119])->where('developer_id', '!=', 20)*/
          ;
    }
    public function scopeHasCoordinates($q)
    {
        return $q->whereNotNull('latitude')->whereNotNull('longitude');
    }

    public function scopeAlias($q, $alias)
    {
        return $q->where('alias', $alias)->limit(1);
    }

    public function scopeSearch($q, $request, $alias)
    {
        return $q->with([
          'infrastructures',
          'images',
          'features',
          'developer.residentials' => function ($q) use ($alias) {
              $q->has('apartments')
                ->with('district')
                ->active()
                ->where('alias', '<>', $alias);
          },
          'houses',
          'houses.material',
          'layouts' => function ($q) use ($request) {
              $q->select('id', 'residential_complex_id', 'rooms', 'area', 'thumbnail', 'main_image')
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
                      $q->select('id', 'layout_id', 'floor', 'rooms');
                  },
                  'residentialComplex' => function ($q) {
                      $q->select('id', 'completion_decade', 'completion_year');
                  },
                  'ranges'
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
                  $rooms = $request->rooms;
                  foreach ($rooms as $room) {
                      if ($roomStudio = array_search($room, ROOMS['merge'])) {
                          $rooms[] = (string)$roomStudio;
                      }
                  }
                  $q->whereIn('rooms', $rooms);
              }
              /*if ($request->page > 1) {
                  $q->skip(($request->page - 1) * $request->per_page);
              }
              $q->take($request->per_page);*/
          },
          'ranges' => function ($q) {
              $q->orderBy('rooms');
          },
          'mortgageOST',
          'mortgageWIF',
          'tradeIn',
          'installment',
          'district' => function ($q) {
              $q->select('id', 'name');
           },
        ]);
    }


    public function isAlreadyBuilt()
    {
        $nowDate = Carbon::now();
        return $this->completion_year < $nowDate->year || ($this->completion_year == $nowDate->year && $this->completion_decade < $nowDate->quarter);
    }


    public function getQuarterLabel($type = 'short')
    {
        $this->quarter_label = !empty(QUARTERS[$type][$this->completion_decade]) ? QUARTERS[$type][$this->completion_decade] : '';
        return $this->quarter_label;
    }

    public function getCompletionDate($type = 'short')
    {
        $this->completion_date = $this->getQuarterLabel($type) . ' ' . $this->completion_year;
        $this->completion_date_short = $this->getQuarterLabel('short') . ' ' . $this->completion_year;
        $this->completion_date_full = $this->getQuarterLabel('full') . ' ' . $this->completion_year;
        return $this->isAlreadyBuilt() ? 'Сдан' : $this->completion_date;
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
    public function getHousesFloorRange() {
        $min = $this->houses()->min('floor_count');
        $max = $this->houses()->max('floor_count');
        return $this->houses_floor_range = $min === $max ? $min : $min.'-'.$max;
    }

    public function getGallery()
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[$image->main] = $image->thumbnail;
        }
        return $images;
    }

    public function getLink()
    {
        return $this->link = route('residentials.spa', $this->alias);
    }

    public function getMetro()
    {
        return optional($this->metroStation)->name;
    }

    public function getPaymentMethods($toString = false)
    {
        $this->payment_methods = $this->houses->map(function ($house) {
            return $house->paymentMethods->pluck('name');
        })->collapse()->unique();

        $this->payment_methods = $toString
          ? $this->payment_methods->implode(', ')
          : $this->payment_methods->toArray();

        return $this->payment_methods;
    }

    public function getMaterials()
    {
        return implode(', ', $this->houses->pluck('material.name')->unique()->toArray());
    }

    public function transformToSearchFormat()
    {
        $this->materials = [];
        $this->getLink();
        $now = now();
        $completionDeadlineMin = $this->houses->first()->completion_deadline;
        $completionDeadlineMax = $this->houses->last()->completion_deadline;
        $this->completion_deadline_min = ['key' => intval(substr($completionDeadlineMin, 0, 4)), 'value' => getCompletionDeadlineFormatted($completionDeadlineMin)];
        $this->completion_deadline_max = ['key' => intval(substr($completionDeadlineMax, 0, 4)), 'value' => getCompletionDeadlineFormatted($completionDeadlineMax)];
        $this->payment_methods = collect();
        $materials = [];
        $decorationTypes = [];
        foreach($this->houses as $house) {
            $materials[] = ['id' => $house->material->id, 'title' => $house->material->name];
            $decorationTypes[] = intval($house->decoration_type);
            $this->payment_methods = $this->payment_methods->merge($house->paymentMethods->pluck('id'));
        }
        $this->materials = implode(', ', array_values(array_unique(array_column($materials, 'title'))));
        $this->material_ids = array_values(array_unique(array_column($materials, 'id')));
        $this->payment_methods = $this->payment_methods->unique()->values();
        $this->decoration_types = array_values(array_unique($decorationTypes));
        
        if ($now->year . $now->quarter > $this->completion_year . $this->completion_decade) {
            $this->completion_year = 'Сдан';
        }
        $roomsFilter = ROOMS['filter'];
        $this->price_min = $this->price_max = null;
        foreach($roomsFilter as $index => &$filter) {
            $areaMin = $areaMax = $priceMin = $priceMax = null;
            foreach($filter['range'] as &$key) {
                $range = $this->ranges->first(function($value) use ($key){ return intval($value->rooms) === $key; });
                if (!empty($range)) {
                    $areaMin = is_null($areaMin) ? $range['area_min'] : ($range['area_min'] < $areaMin ? $range['area_min'] : $areaMin);
                    $areaMax = $range['area_max'] > $areaMax ? $range['area_max'] : $areaMax;
                    $priceMin = is_null($priceMin) ? $range['price_min'] : ($range['price_min'] < $priceMin ? $range['price_min'] : $priceMin);
                    $priceMax = $range['price_max'] > $priceMax ? $range['price_max'] : $priceMax;

                    $this->price_min =  is_null($this->price_min) ? $priceMin : ($priceMin < $this->price_min ? $priceMin : $this->price_min);
                    $this->price_max = $priceMax > $this->price_max ? $priceMax : $this->price_max;
                }
            }
            if (is_null($areaMin)) {
                unset($roomsFilter[$index]);
            }
            $filter['area_min'] = $areaMin;
            $filter['area_max'] = $areaMax;
            $filter['price_min'] = $priceMin;
            $filter['price_max'] = $priceMax;
        }
        $this->apartments_formatted = array_values($roomsFilter);
        unset($this->completion_decade, $this->ranges);
    }

    public function transformToDetailFormat()
    {
        $this->floor_max = $this->houses->max('floor_count');
        $this->materials = $this->getMaterials();
        $this->completion_date_description = $this->getCompletionDate('full');
        $this->completion_date_description = $this->completion_date_description !== 'Сдан' ? $this->completion_date_description . ' г.' : $this->completion_date_description;
        /*$this->ranges_formatted = $this->ranges->transform(function($range){
            $range->layouts = $this->layouts->filter(function($layout) use ($range){
                if ($layout->rooms === $range->rooms) {
                    $layout->getRoomLabel();
                    $layout->area = round($layout->area);
                    $layout->decoration = [];
                    $layout->apartments->each(function($apart) use ($layout){
                        $layout->decoration = array_merge($layout->decoration, [DECORATION_TYPE_LABELS[$this->houses->first(function($house) use ($apart){
                            return $house->id === $apart->house_id;
                        })->decoration_type]]);
                    });
                    $layout->decoration = implode(', ', array_unique($layout->decoration));
                    
                    return $layout;
                }
            })->values();
            return $range;
        });*/
        $apartmentsFormatted = ROOMS['filter'];
        $residentialMinPrice = $residentialMaxPrice = $residentialMinArea = $residentialMaxArea = null;
        foreach($apartmentsFormatted as &$filter) {
            $minArea = $maxArea = $minPrice = $maxPrice = null;
            $filter['layouts'] = [];
            foreach($this->layouts as &$layout) {
                if (in_array($layout->rooms, $filter['range'])) {
                    $layout->getRoomLabel();
                    $layout->area = round($layout->area);
                    $minArea = $minArea == null ? $layout->area : ($layout->area !== null && $layout->area < $minArea ? $layout->area : $minArea);
                    $maxArea = $layout->area > $maxArea ? $layout->area : $maxArea;
                    $layout->decoration = [];
                    $layout->apartments->each(function($apart) use ($layout, &$minPrice, &$maxPrice){
                        $layout->decoration = array_merge($layout->decoration, [DECORATION_TYPE_LABELS[$this->houses->first(function($house) use ($apart){
                            return intval($house->id) === intval($apart->house_id);
                        })->decoration_type]]);
                        $minPrice = $minPrice == null ? $apart->price : ($apart->price !== null && $apart->price < $minPrice ? $apart->price : $minPrice);
                        $maxPrice = $apart->price > $maxPrice ? $apart->price : $maxPrice;
                    });
                    $layout->decoration = implode(', ', array_unique($layout->decoration));
                    
                    $filter['layouts'][] = $layout;
                    unset($layout);
                }
            }
            $filter['min_area'] = $minArea;
            $filter['max_area'] = $maxArea;
            $filter['min_price'] = $minPrice;
            $filter['max_price'] = $maxPrice;
            $residentialMinPrice = $residentialMinPrice == null ? $minPrice : ($minPrice !== null && $minPrice < $residentialMinPrice ? $minPrice : $residentialMinPrice);
            $residentialMaxPrice = $maxPrice > $residentialMaxPrice ? $maxPrice : $residentialMaxPrice;
            $residentialMinArea = $residentialMinArea == null ? $minArea : ($minArea !== null && $minArea < $residentialMinArea ? $minArea : $residentialMinArea);
            $residentialMaxArea = $maxArea > $residentialMaxArea ? $maxArea : $residentialMaxArea;
        }
        $this->ranges_formatted = $apartmentsFormatted;
        $this->apartments_price_min = $residentialMinPrice;
        $this->apartments_price_max = $residentialMaxPrice;
        $this->apartments_area_min = $residentialMinArea;
        $this->apartments_area_max = $residentialMaxArea;
    }

    /*public function getBanksMinMortgagePercent() {
        $this->banks_min_mortgage_complex = $this->banks->whereNotNull('percent_from')->orderBy('percent_from')->first();
        return (empty($bank)) ? Bank::MIN_MORTGAGE_PERCENT : $bank->percent_from;
    }*/

    // public function getPaymentMethods($toString = false)
    // {
    //     $this->payment_methods = $this->houses->map(function ($house) {
    //         return $house->paymentMethods->pluck('name');
    //     })->collapse()->unique();

    //     $this->payment_methods = $toString
    //       ? $this->payment_methods->implode(', ')
    //       : $this->payment_methods->toArray();

    //     return $this->payment_methods;
    // }
}
