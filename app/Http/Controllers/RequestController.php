<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
use App\Mail\NewClientRequest;
use Illuminate\Http\Request;
use App\Request as ClientRequest;
use Illuminate\Support\Facades\Mail;

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
        $clientRequest = ClientRequest::with('layout.residential')->firstOrCreate($clientRequest->toArray());

        if ($clientRequest->wasRecentlyCreated) {
            Mail::to(MAILABLE)->send(new NewClientRequest($clientRequest));
        }

        return ($clientRequest) ? 1 : 0;
    }
}
