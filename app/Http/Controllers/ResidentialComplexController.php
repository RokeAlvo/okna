<?php

namespace App\Http\Controllers;

use App\Layout;
use App\ResidentialComplex;
use Illuminate\Http\Request;

class ResidentialComplexController extends Controller
{
    public function index()
    {
        $residentials = ResidentialComplex::with([
            'developer',
            'ranges' => function ($q) {
                $q->select('id', 'residential_complex_id', 'rooms', 'area_min', 'area_max', 'price_min', 'price_max')->orderBy('rooms');
            }
        ])
            ->has('apartments')
            ->active()
            ->paginate(10);
        foreach ($residentials as $residential) {
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
        return view('residentials.index', compact('residentials'));
    }

    public function show(Request $request, $alias)
    {
        $residential = ResidentialComplex::alias($alias)->search($request, $alias)->first();

        $residential->layouts = $residential->layouts->transform(function ($layout) {
            $layout->getRoomLabel();
            $layout->calculateFloorRangeFromApartments();
            $layout->getRoomPriceRange();
            return $layout;
        })->sortBy('area');

        $layoutCount = $residential->layouts->count();

        if ($request->ajax()) {
            if ($request->has('room')) {
                return response()->json($residential->layouts->where('rooms', $request->room));
            }
            return response()
                ->json($residential->layouts->slice(($request->page - 1) * $request->per_page, $request->per_page))
                ->header('x-total-layouts', $layoutCount);
        }

        return view('residentials.show', compact('residential'));
    }

    public function getOneRoomLayouts(Request $request)
    {
        return response()->json(
            Layout::room($request->room)->transform(function ($layout) {
                $layout->getRoomLabel();
                $layout->calculateFloorRangeFromApartments();
                $layout->getRoomPriceRange();
                return $layout;
            })->get()
        );
    }
}
