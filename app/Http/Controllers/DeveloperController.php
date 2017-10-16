<?php

namespace App\Http\Controllers;

use App\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::with('statistics')
            ->get()
            ->sortByDesc(function ($residential) {
                return count($residential->statistics);
            });
        return view('developers.index', compact('developers'));
    }

    public function show($alias)
    {
        $developer = Developer::alias($alias)->first();
        return view('developers.show', compact('developer'));
    }

}
