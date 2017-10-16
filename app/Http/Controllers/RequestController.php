<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function mortgage()
    {
        return view('requests.mortgage');
    }

    public function contacts()
    {
        return view('requests.contacts');
    }
}
