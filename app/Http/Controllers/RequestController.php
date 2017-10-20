<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as ClientRequest;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'client_phone' => 'required|string'
        ]);
        $clientRequest = ClientRequest::create($request->all());
        return true;
    }
}
