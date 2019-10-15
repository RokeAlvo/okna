<?php
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\DeviceDetector;

if(isset($_SERVER['HTTP_USER_AGENT'])) {
    session()->remove('device');
    DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
    $deviceDetector = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
    $deviceDetector->parse();
    $device = $deviceDetector->isDesktop();
    session(['device' => strval($device)]);
} else {
    $device = true;
}

Route::get('/', 'SiteController@index')->name('site.index');

Route::get('sitemap.xml', 'SiteController@sitemap')->name('sitemap');

$subdomain = getUrlPathFirstPart();

Route::group(['prefix' => $subdomain], function () use ($device, $subdomain) {

    if (!empty($subdomain) && !empty(\Config::get('database.connections')[$subdomain])) {
        Route::get('/', 'SiteController@index')->name('site.index');

        Route::post('get-menu', 'SiteController@getMenu')->name('site.getMenu');
    }

    Route::get('developers', 'DeveloperController@index')->name('developers.index');
    Route::get('developer/{alias}', 'DeveloperController@show')->name('developers.show');
    //Route::get('test/developer/{alias}', 'DeveloperController@show')->name('developers.test');

    Route::group(['prefix' => 'residential-complex'], function () {
        Route::post('index', 'ResidentialComplexController@index')->name('residentials.index');
    });
    // Route::get('search/new-buildings', 'ResidentialComplexController@index')->name('residentials.old-index');
    
    Route::post('residential-complex/mortgage-params', 'ResidentialComplexController@mortgageParams')->name('residentials.mortgageParams');
    Route::post('residential-complex/get-count', 'ResidentialComplexController@getCount')->name('residentials.getCount');
    //if($subdomain === 'novosibirsk') {
    //if(in_array($subdomain,['novosibirsk', 'krasnoyarsk', 'barnaul'])) {
        Route::get('novostroyki/{vue1?}/{vue2?}/{vue3?}/{vue4?}', function() {
            return view('v2.templates.spa');
        })->name('residentials.spa');
        Route::post('residential-complex/{alias}', 'ResidentialComplexController@show')->name('residentials.show');
    /*} else {
        Route::get('search/new-buildings', 'ResidentialComplexController@searchNewBuildings')->name('residentials.spa');
        Route::get('residential-complex/{alias}', 'ResidentialComplexController@show')->name('residentials.show');
    }*/

    //Route::get('mortgage', 'RequestController@mortgage')->name('requests.mortgage');
    Route::get('mortgage', 'RequestController@mortgage')->name('ipoteka.spa');
    Route::get('contacts', 'RequestController@contacts')->name('requests.contacts');
    Route::post('requests', 'RequestController@store')->name('requests.store');
    Route::get('partners', function () {
        return view('partners');
    })->name('partners');

    Route::post('goals/create', 'MetrikaController@create')->name('goals.create');

    Route::get('ipoteka/{vue1?}/{vue2?}/{vue3?}/{vue4?}/{vue5?}', function() {
        return view('v2.templates.spa');
    })->name('ipoteka.spa');
    /* Route::get('novostroyki/{vue1?}/{vue2?}/{vue3?}/{vue4?}', function() {
        return view('v2.templates.spa');
    })->name('residentials.spa');*/
});
//need for gzip ob_start("ob_gzhandler");