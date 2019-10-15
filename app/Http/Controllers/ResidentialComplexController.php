<?php

namespace App\Http\Controllers;

use App\ApartmentsRange;
use App\Http\Requests\SearchResidentialComplexRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\ResidentialComplex;
use App\Apartment;
use App\House;
use App\PaymentMethod;
use App\Infrastructure;
use App\HouseMaterial;
use Illuminate\Support\Facades\Cache;
use App\District;
use Carbon\Carbon;

class ResidentialComplexController extends Controller
{
    public function index()
    {
        $city = DB::getDefaultConnection();
        $residentials = Cache::remember("$city-residentials", 240, function () {
            return ResidentialComplex::select('id', 'developer_id', 'title', 'alias', 'address', 'thumbnail', 'latitude', 'longitude', 'count_parking', 'count_underground_parking',
                'completion_year', 'completion_decade')
                ->active()
                ->has('ranges')->where('status', true)
                ->with([
                    'developer' => function ($q) {
                        $q->select('id', 'name');
                    },
                    'ranges' => function($q){
                        $q->select('id', 'residential_complex_id', 'rooms', 'area_min', 'area_max', 'price_min', 'price_max')->orderBy('rooms');
                    },
                    'houses' => function($q){
                        $q->select('id', 'residential_complex_id', 'house_material_id', 'decoration_type', DB::raw("CONCAT(`completion_year`, `completion_decade`) AS completion_deadline"))
                            ->with([
                                'material' => function($q){
                                    $q->select('id', 'name');
                                },
                                'paymentMethods' => function($q){
                                    $q->select((new PaymentMethod())->getTable() . '.id');
                                }
                            ])->orderBy('completion_deadline');
                    },
                    'infrastructures' => function($q){
                        $q->select((new Infrastructure())->getTable() . '.id');
                    }
                ])
                ->get()->transform(function(&$residential) {
                    $residential->transformToSearchFormat();

                    return $residential;
                });
        });

        return response()->json([
            'residentials' => $residentials,
            'roomsFilter' => ROOMS['filter'],
            'completionYears' => $residentials->pluck('completion_year')->unique()->sortBy(function($value){ return IntVal($value); })->values(),
            'paymentMethods' => PaymentMethod::select('id', 'name')->searchable()->get(),
            'houseMaterials' => HouseMaterial::select('id', 'name')->get(),
            'decorationTypes' => moveKeyToValue(DECORATION_TYPE_LABELS),
            'infrastructures' => Infrastructure::select('id', 'name', 'searchable')->searchable()->get(),
        ]);
    }
    public function searchNewBuildings(SearchResidentialComplexRequest $request)
    {
        $residentials = ResidentialComplex::with([
            'developer' => function ($q) {
                $q->select('id', 'name');
            },
            'district' => function ($q) {
                $q->select('id', 'name');
            },
            'ranges' => function ($q) {
                $q->select('id', 'residential_complex_id', 'rooms', 'area_min', 'area_max', 'price_min', 'price_max')->orderBy('rooms');
            }
        ])
            ->when($request->has('districts'), function ($q) use ($request) {
                $q->whereIn('district_id', $request->districts);
            })
            ->when($request->has('completion_date_range'), function ($q) use ($request) {
                $q->whereHas('houses', function ($q) use ($request) {
                    $q->builtBetween($request->completion_date_range);
                });
            })
            ->when(($request->has('rooms') || $request->has('area_range')), function ($q) use ($request) {
                $q->whereHas('apartments', function ($q) use ($request) {
                    if ($request->has('rooms')) {
                        $rooms = $request->rooms;
                        foreach (ROOMS['merge'] as $key => $room) {
                            if (in_array($room, $rooms)) {
                                $rooms[$key] = $key;
                            }
                        }
                        $q->whereIn('rooms', $rooms);
                    }
                    if ($request->has('area_range')) {
                        $q->areaRange($request);
                    }
                    if ($request->has('price_range')) {
                        $q->priceRange($request, 1000);
                    }
                });
            })
            ->has('apartments')
            ->active()
            ->latest()
            ->paginate(10);

        foreach ($residentials as $residential) {
            $residential->ranges = ApartmentsRange::mergeRooms($residential->ranges);
            if ($residential->ranges->count() > 3) {
                $rangesToMerge = $residential->ranges->splice(2);
                $thirdRange = $rangesToMerge->first();
                $thirdRange->area_min = $rangesToMerge->min('area_min');
                $thirdRange->area_max = $rangesToMerge->max('area_max');
                $thirdRange->price_min = $rangesToMerge->min('price_min');
                $thirdRange->price_max = $rangesToMerge->max('price_max');
                $thirdRange->plus = '+';
                $residential->ranges = $residential->ranges->take(2)->push($thirdRange);
            }
        }

        $districts = District::select('id', 'name')->get();
        $currentDate = Carbon::now();
        $completionDatesList = [];
        for ($i = 0; $i < 16; $i++) {
            $completionDatesList[$currentDate->year . $currentDate->quarter] = QUARTERS['short'][$currentDate->quarter] . ' ' . $currentDate->year;
            $currentDate->addQuarter();
        }

        return view('residentials.index', compact('residentials', 'districts', 'completionDatesList'));
    }

    public function show(Request $request, $alias)
    {
        // session(['device' => ""]); //Delete after dev
        // dd(session('device'));
        $city = getUrlPathFirstPart();
        $workTime = Config::get('database.connections')[$city]['workTime'] ?? null;
        if ($workTime) {
            $workTimeStart = Carbon::parse($workTime[0]);
            $workTimeEnd = Carbon::parse($workTime[1]);
            $now = Carbon::now();
            if ($now->isWeekday()) {
                $isWorkTime = $now->between($workTimeStart, $workTimeEnd);
            } elseif ($now->isSaturday()) {
                $isWorkTime = $now->between(Carbon::parse('10:00'), Carbon::parse('16:00'));
            } else {
                $isWorkTime = $now->between($workTimeStart, $workTimeEnd) && !$now->isSunday();
            }
        } else {
            $isWorkTime = true;
        }
        
        $splitTesting = runSplitTesting(['residentialComplexShowPopup']);
        $popup = $splitTesting->get('residentialComplexShowPopup');
        $popupType = $popup['key']; 
        extract($popup['value']);
        if ($request->ajax()/* && in_array($city, ['novosibirsk', 'krasnoyarsk', 'barnaul'])*/) {
            $residential = ResidentialComplex::select('id', 'title', 'alias', 'description', 'district_id', 'address', 'completion_decade', 'completion_year', 'latitude', 'longitude',
                'count_parking', 'count_underground_parking', 'discount_title', 'discount_description', 'discount_start', 'discount_finish', 'status', 'minutes_to_metro', 
                'metro_station_id', 'project_declaration', 'bg_image_original', 'main_image')
                ->alias($alias)
                ->active()
                ->with([
                    'features',
                    'infrastructures',
                    'images',
                    'mortgageOST' => function ($q) {
                        $q->select('id', 'residential_complex_id', 'percent_from', 'comment');
                    },
                    'mortgageWIF',
                    'tradeIn',
                    'installment' => function ($q) {
                        $q->select('id', 'residential_complex_id', 'percent', 'comment');
                    },
                    'district' => function ($q) {
                        $q->select('id', 'name');
                    },
                    'houses' => function ($q) {
                        $q->select('id', 'decoration_type', 'floor_count', 'residential_complex_id', 'house_material_id')
                            ->with([
                                'material' => function ($q) {
                                    $q->select('id', 'name');
                                }
                            ]);
                    },
                    'layouts' => function ($q) {
                        $q->select('id', 'residential_complex_id', 'rooms', 'area', 'thumbnail', 'main_image')
                            ->has('apartments')
                            ->with([
                                'apartments' => function ($q) {
                                    $q->select('id', 'layout_id', 'floor', 'rooms', 'ceiling_height', 'house_id', 'price');
                                }
                            ]);
                    },
                    'metroStation' => function ($q) {
                        $q->select('id', 'name');
                    }
                ])
                ->firstOrFail();

            $residential->transformToDetailFormat();
            
            $closestResidentials = ResidentialComplex::select((new ResidentialComplex)->getTable() . '.id', 'alias', 'title', 'developer_id', 'thumbnail')
                ->closestTo($residential->latitude, $residential->longitude)
                ->where((new ResidentialComplex)->getTable() . '.id', '!=', $residential->id)
                ->active()
                ->hasCoordinates()
                ->has('apartments')
                ->leftJoin('apartments_ranges AS ranges', function($join) {
                    $join->on('ranges.residential_complex_id', '=', (new ResidentialComplex)->getTable() . '.id')
                        ->groupBy('ranges.residential_complex_id');
                })
                ->selectRaw('MIN(ranges.price_min) AS price_min')
                ->with([
                    'developer' => function($q){
                        $q->select('id', 'name');
                    }
                ])
                ->groupBy( (new ResidentialComplex)->getTable() . '.id', 'alias', 'title', 'developer_id', 'thumbnail', 'latitude', 'longitude')
                ->orderBy('distance')
                ->take(3)
                ->get()->toArray();

            unset($residential->houses);
            return response()->json(compact('residential', 'closestResidentials', 'gaLabel', 'gaGoalLabel', 'gaGoalPhoneLabel', 'popupType', 'isWorkTime'));
        }

        $residential = ResidentialComplex::alias($alias)->search($request, $alias)->active()->firstOrFail();

        $residential->full_decoration = $residential->houses->pluck('decoration_type')->unique()->contains(DECORATION_TYPES['full']);
        $residential->material = $residential->houses->where('material.alias', 'monolith-brick')->count()
            ? 'Монолит-кирпич'
            : ($residential->houses->where('material.alias', 'brick')->count()
                ? 'Кирпич'
                : false
            );

        $residential->completion_date_description = $residential->getCompletionDate('full');
        $residential->completion_date_description = $residential->completion_date_description !== 'Сдан' ? $residential->completion_date_description . ' г.' : $residential->completion_date_description;

        $housesSortByCompletionDate = $residential->houses->sortBy(function ($house) {
            return $house->completion_year . $house->completion_decade;
        });
        $minCompletionDate = $housesSortByCompletionDate->first()->getCompletionDate();
        $maxCompletionDate = $housesSortByCompletionDate->last()->getCompletionDate();
        $residential->completion_date_range = $minCompletionDate == $maxCompletionDate ? $minCompletionDate : $minCompletionDate . ' - ' . $maxCompletionDate;

        $residential->infrastructures = $residential->infrastructures->unique('name');

        $residential->ranges = ApartmentsRange::mergeRooms($residential->ranges);
        $residential->main_ranges = $residential->ranges->filter(function ($range) {
            return !empty(ROOMS['main'][$range->rooms]) || !empty(ROOMS['merge'][$range->rooms]);
        })->keyBy('rooms')->sortBy('rooms');
        $temp = $residential->layouts;
        unset($residential->layouts);
        $residential->layouts = $temp->transform(function ($layout) use ($floors_short) {
            $layout->getRoomLabel();
            $layout->calculateFloorRangeFromApartments($floors_short);
            $layout->getPriceRange();
            $layout->getRoomPriceRange();
            $layout->getResidentialCompletionDate('short');
            $layout->area = round($layout->area);
            $layout->groupByKey = key(array_filter(ROOMS['filter'], function ($group) use ($layout) {
                return in_array($layout->rooms, $group['range']);
            }));
            return $layout;
        })->sortBy('area')->values();

        $residential->getHousesFloorRange();
        $residential->getPaymentMethods(true);

        /*$layoutCount = $residential->layouts->count();*/

        if ($request->ajax() && empty($request->residential_alias)) {
            if ($request->has('room')) {
                if ($roomStudio = array_search($request->room, ROOMS['merge'])) {
                    return response()->json($residential->layouts->whereIn('rooms', [$request->room, $roomStudio])->values());
                } else {
                    return response()->json($residential->layouts->where('rooms', $request->room)->values());
                }
            }
            return response()
                ->json($residential->layouts/*->slice(($request->page - 1) * $request->per_page, $request->per_page))
                ->header('x-total-layouts', $layoutCount*/);
        }
        
        runSplitTesting(['residentialComplexShowView', 'residentialComplexShowMobileView']);
        $view = $splitTesting->get('residentialComplexShowView')['value'];
        $viewMobile = $splitTesting->get('residentialComplexShowMobileView');
        $mobileApartmentsView = $viewMobile['key']; $mobileApartmentsViewGoal = $viewMobile['value'];
        
        /*$allFlatsButton = session($city . '-all-flats-button');
        $allFlatsButtons = ['show' => 'button-all-flats', 'hide' => 'with-out-button-all-flats'];
        if (empty($allFlatsButton) || empty($allFlatsButtons[$allFlatsButton])) {
            $allFlatsButton = array_rand($allFlatsButtons);
            session([$city . '-all-flats-button' => $allFlatsButton]);
        }
        $allFlatsButtonGoal = $allFlatsButtons[$allFlatsButton];*/

        /*$layoutSize = session($city . '-layout-size');
        $layoutSizes = ['small' => 'small-layouts', 'big' => 'big-layouts'];
        if (empty($layoutSize) || empty($layoutSizes[$layoutSize])) {
            $layoutSize = array_rand($layoutSizes);
            session([$city . '-layout-size' => $layoutSize]);
        }
        $layoutSizeGoal = $layoutSizes[$layoutSize];*/

        $isActiveDiscount = ($residential->discount_title && (($residential->discount_finish >= date('Y-m-d') && ($residential->discount_start <= date('Y-m-d') || $residential->discount_start === NULL)) || (($residential->discount_finish >= date('Y-m-d') || $residential->discount_finish === NULL) && $residential->discount_start <= date('Y-m-d')) || ($residential->discount_finish === NULL && $residential->discount_start === NULL)));

        $data = compact('residential', 'gaLabel', 'gaGoalLabel', 'gaGoalPhoneLabel', 'popupType', 'layoutSizeGoal', 'mobileApartmentsView', 'mobileApartmentsViewGoal', 'isActiveDiscount', 'isWorkTime');

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view($view, $data);
    }

    public function mapSearch()
    {
        $contacts = SITE_CONTACTS[getUrlPathFirstPart()];
        return view('v2.mapSearch', compact('contacts'));
    }

    public function mortgageParams()
    {
        return response()->json([
            'rooms' => ROOMS['filter'],
            'minPrice' => Apartment::min('price')
        ]);
    }

    public function getCount(SearchResidentialComplexRequest $request)
    {
        /*$request = new SearchResidentialComplexRequest([
            'rooms_list' => [21, 30],
            'price_from' => 4850000
        ]);*/

        return response()->json(ResidentialComplex::whereHas('ranges', function ($q) use ($request) {
            $q->when(!empty($request->price_from), function ($q) use ($request) {
                $q->where('price_min', '<=', $request->price_from);
            })->when(!empty($request->rooms_list), function ($q) use ($request) {
                $q->whereIn('rooms', array_map('strval', $request->rooms_list));
            });
        })->count());
    }

    /*public function getOneRoomLayouts(Request $request)
    {
        return response()->json(
            Layout::room($request->room)->transform(function ($layout) {
                $layout->getRoomLabel();
                $layout->calculateFloorRangeFromApartments();
                $layout->getRoomPriceRange();
                return $layout;
            })->get()
        );
    }*/
}
