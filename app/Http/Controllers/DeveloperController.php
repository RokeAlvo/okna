<?php

namespace App\Http\Controllers;

use App\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        if (str_contains(url()->current(),'/test')) {
            return view('developers.test', compact('developer'));
        }
        return view('developers.show', compact('developer'));
    }

}
