<?php

namespace App\Http\Controllers;

use App\MetrikaGoal;
use Illuminate\Http\Request;

class MetrikaController extends Controller
{
    public function create(Request $request)
    {
        /*$request = new Request([
            'goal' => 'new-design'
        ]);*/
        $this->validate($request, [
            'goal' => 'required|exists:metrika_goals,alias'
        ]);

        return response()->json((bool)MetrikaGoal::alias($request->goal)->first()->reaches()->create(['url' => $request->headers->get('referer'), 'ip' => $request->getClientIp()]));
    }
}
