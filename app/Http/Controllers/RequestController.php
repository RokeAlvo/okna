<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
use App\Layout;
use App\Mail\NewClientRequest;
use App\ResidentialComplex;
use Illuminate\Http\Request;
use App\Request as ClientRequest;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Site;

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
        parse_str(session('query-string'), $queryString);
        //dd(array_merge($request->all(), $queryString, ['device' => session('device')]));
        $curl = curl_init(getRequestStoreRoute());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        $postfields = array_merge($request->all(), $queryString, ['device' => IntVal(session('device')), 'site_id' => Site::alias('okna')->first()->id]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($curl);
        //dd($result);
        /*if (!$result) {
            dd(curl_errno($curl).": ".curl_error($curl));
            //dd(curl_getinfo($curl));
        }*/
        curl_close($curl);

        return response()->json(!!$result);

        /*if (app()->environment('local') && $clientRequest->wasRecentlyCreated) {
            $uri = 'http://localhost:3000/new-order';
        } elseif (app()->environment('production') && $clientRequest->wasRecentlyCreated) {
            Mail::to(MAILABLE[getUrlPathFirstPart()])->send(new NewClientRequest($clientRequest));
            // TODO Расскоментировать, когда websockets будут готовы
            //$uri = request()->getSchemeAndHttpHost() . ':3000/new-order';
            //$client = new Client();
            //$client->post($uri, ['query' => $query]);
        }

        if ($request->ajax()) {
            //return ($clientRequest) ? 1 : 0;
            return response()->json(!!$clientRequest);
        } else {
            return ($clientRequest)
              ? back()->with('message_success', 'Спасибо за заявку!')
              : back()->with('message_error', 'Ошибка при сохранении заявки!');
        }*/
    }
}
