<?php

namespace App\Http\Controllers;

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
        $residential = ResidentialComplex::with([
            'images',
            'features',
            'developer.residentials' => function ($q) use ($alias) {
                $q->where('alias', '<>', $alias);
            },
            'houses',
            'layouts' => function ($q) {
                $q->has('apartments')->with('apartments');
            },
            'ranges' => function ($q) {
                $q->orderBy('rooms');
            },
        ])->alias($alias)->first();


        if ($request->ajax()) {
            $residential->layouts = $residential->layouts->transform(function ($layout) {
                $layout->getRoomLabel();
                $layout->calculateFloorRangeFromApartments();
                return $layout;
            })->sortBy('area');
            return response()
                ->json($residential->layouts->splice(($request->page - 1) * $request->per_page, $request->per_page))
                ->header('x-total-layouts', $residential->layouts->count());
        }

        return view('residentials.show', compact('residential'));
    }
}
