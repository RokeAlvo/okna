<?php

namespace App\Http\Controllers;

use App\ApartmentsRange;
use App\Developer;
use App\MortgageOST;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::with('statistics')
            ->has('apartments')
            ->active()
            ->get()
            ->sortByDesc(function ($residential) {
                return count($residential->statistics);
            });
        return view('developers.index', compact('developers'));
    }

    public function show(Request $request, $alias)
    {
        $developer = Developer::alias($alias)
            ->with([
                'residentials' => function ($q) use ($request) {
                    $q->has('apartments')
                        ->select('id', 'alias', 'title','address', 'district_id', 'developer_id', 'completion_passed', 'completion_decade', 'completion_year', 'search_image','thumbnail', 'status', 'latitude', 'longitude', 'count_underground_parking','metro_station_id')
                        ->with([
                            'district' => function ($q) {
                                $q->select('id', 'name');
                            },
                            'apartments' => function ($q) use ($request) {
                                $q->select('id', 'price', 'area', 'rooms', 'residential_complex_id'/*, 'floor'*/)
                                    ->rooms($request)
                                    ->areaRange($request)
                                    ->priceRange($request);
                            },
                            'ranges' => function ($q) {
                                $q->select('id', 'residential_complex_id', 'rooms', 'price_min','price_max','area_min','area_max');
                            },
                            'layouts' => function ($q) use ($request) {
                                $q->whereHas('apartments', function ($q) use ($request) {
                                    $q->select('floor')
                                        ->rooms($request)
                                        ->areaRange($request)
                                        ->priceRange($request);
                                })->select('id', 'residential_complex_id', 'rooms', 'area', 'thumbnail', 'main_image');
                            },
                            'mortgageOST',
                            'mortgageWIF',
                            'tradeIn',
                            'installment',
                            'metroStation',
                            'houses' => function ($q) {
                                $q->with('paymentMethods');
                            }
                        ])
                        ->withCount('houses')
                        ->active();
                },
            ])
            ->withCount('apartments')
            ->active()
            ->firstOrFail();

        $city = getUrlPathFirstPart();
        $splitTesting = runSplitTesting(['developersShowPopup', 'developersShowView']);
        $popup = $splitTesting->get('developersShowPopup');
        $popupType = $popup['key']; 
        extract($popup['value']);

        $apartments = collect();
        $developer->residentials = $developer->residentials->transform(function ($residential) use (&$apartments, $floors_short) {
            $apartments = $apartments->merge($residential->apartments);
            $residential->getCompletionDate('full');
            /*$residential->getBanksMinMortgagePercent();*/
            $residential->showLayouts = false;
            $residential->routeShow = route('residentials.spa', [$residential->alias]);
            $residential->mergedRanges = ApartmentsRange::mergeRooms($residential->ranges)
                ->transform(function ($range) use ($residential) {
                    $range->getRoomLabel();
                    $rangeRoomStudio = array_search($range->rooms, ROOMS['merge']);
                    $range->apartments_count = $residential->apartments->whereIn('rooms', [$range->rooms, $rangeRoomStudio])->count();
                    return $range;
                })
                ->sortBy('rooms');
            if (!empty($residential->installment)) {
                $residential->installment->getCreditPeriodRange();
            }
            $residential->minMortgagePercent = !empty($residential->mortgageOST->percent_from) ? $residential->mortgageOST->percent_from : MortgageOST::MIN_MORTGAGE_PERCENT;
            $residential->getPaymentMethods(true);
            $residential->layouts->transform(function ($layout) use ($floors_short) {
                $layout->getRoomLabel();
                $layout->getResidentialCompletionDate('short');
                $layout->calculateFloorRangeFromApartments($floors_short);
                $layout->getRoomPriceRange();
                $layout->getPriceRange();
                $layout->area = round($layout->area);
                return $layout;
            })->sortBy('rooms');
            $residential->full_decoration = $residential->houses->pluck('decoration_type')->unique()->contains(DECORATION_TYPES['full']);
            $residential->material = $residential->houses->where('house.material', 'Монолит-кирпич')->count()
            ? 'Монолит-кирпич'
            : ($residential->houses->where('house.material', 'Кирпич')->count()
                ? 'Кирпич'
                : false
            );
            $residential->getHousesFloorRange();
            $residential->getPaymentMethods(true);
            $housesSortByCompletionDate = $residential->houses->sortBy(function ($house) {
                return $house->completion_year . $house->completion_decade;
            });
            $minCompletionDate = $housesSortByCompletionDate->first()->getCompletionDate();
            $maxCompletionDate = $housesSortByCompletionDate->last()->getCompletionDate();
            $residential->completion_date_range = $minCompletionDate == $maxCompletionDate ? $minCompletionDate : $minCompletionDate . ' - ' . $maxCompletionDate;
            $residential->price_min = $residential->mergedRanges->min('price_min');

            return $residential;
        })/*->keyBy('id')*/;

        $apartmentRanges = [
            'minPrice' => $apartments->min('price'),
            'maxPrice' => $apartments->max('price'),
            'minArea' => floor($apartments->min('area')),
            'maxArea' => ceil($apartments->max('area')),
        ];

        $roomRanges = $apartments
            ->groupBy('rooms')
            ->reject(function ($apartments) {
                return in_array($apartments->first()->rooms, array_keys(ROOMS['merge']));
            })
            ->transform(function ($roomApartments) {
                $roomApartments = $roomApartments->first();
                $roomApartments->getRoomLabel();
                return $roomApartments;
            })
            ->sortBy('rooms');

        if ($request->ajax()) {
            return response()
                ->json($developer->residentials)
                ->header('x-total-apartments', $apartments->count());
        }
        
        $view = $splitTesting->get('developersShowView')['value'];

        /*if (str_contains(url()->current(), '/test')) {
            return view('developers.test', compact('developer', 'apartmentRanges', 'roomRanges', 'gaLabel', 'popupType'));
        }*/
        return view($view, compact('developer', 'apartmentRanges', 'roomRanges', 'gaLabel', 'gaGoalLabel', 'popupType'));
    }

}
