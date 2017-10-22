<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
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

    public function store(CreateRequestRequest $request)
    {
        $clientRequest = new ClientRequest;
        $clientRequest->fill($request->only('client_phone', 'type', 'layout_id'));
        $clientRequest = ClientRequest::firstOrCreate($clientRequest->toArray());
        return ($clientRequest) ? 1 : 0;
    }
}
