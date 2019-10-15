<?php

namespace App\Http\Controllers;

use App\ResidentialComplex;
use App\Developer;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index() {
        $subdomain = getUrlPathFirstPart();
        if (!empty($subdomain)) {
            return view('index');
        } else {
            return view('main');
        }
    }

    public function getMenu()
    {
        return response()->json([
            ['title' => 'Главная', 'route' => route('site.index')],
            ['title' => 'Новостройки', 'route' => route('residentials.spa')],
            ['title' => 'Застройщики', 'route' => route('developers.index')],
            ['title' => 'Ипотека', 'route' => route('ipoteka.spa')],
        ]);
    }

    public function sitemap()
    {
        $residentials = collect();
        $developers = collect();
        $routes = [];
        foreach (array_filter(config('database.connections'), function ($conn) {
            return !empty($conn['timezoneSettings']);
        }) as $city => $connection) {
            DB::setDefaultConnection($city);
            $urlFirstPart = preg_replace('/(https\:\/\/[^\/]*)(\/)?(novosibirsk)?(.*)/', "$1/$city$4", env('APP_URL'));
            $residentials = $residentials->merge(ResidentialComplex::select('id', 'alias', 'updated_at')->get()->transform(function(&$residential) use ($urlFirstPart){
                $residential->route = $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('residentials.show', $residential->alias, false));
                return $residential;
            }));
            $developers = $developers->merge(Developer::select('id', 'alias', 'updated_at')->get()->transform(function(&$developer) use ($urlFirstPart){
                $developer->route = $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('developers.show', $developer->alias, false));
                return $developer;
            }));
            $routes = array_merge($routes, [
                $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('site.index', [], false)),
                $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('developers.index', [], false)),
                $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('residentials.spa', [], false)),
                $urlFirstPart . preg_replace('/sitemap.xml\//', "", route('ipoteka.spa', false)),
            ]);
        }
        return view('sitemap')->with(compact('residentials', 'developers', 'routes'));
    }
}
