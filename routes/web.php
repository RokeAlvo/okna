<?php

Route::get('/', 'SiteController@index')->name('site.index');

Route::get('developers', 'DeveloperController@index')->name('developers.index');
Route::get('developer/{alias}', 'DeveloperController@show')->name('developers.show');
Route::get('developer/{alias}/test', 'DeveloperController@show')->name('developers.test');

Route::get('search/new-buildings', 'ResidentialComplexController@index')->name('residentials.index');
Route::get('residential-complex/{alias}', 'ResidentialComplexController@show')->name('residentials.show');

Route::get('mortgage', 'RequestController@mortgage')->name('requests.mortgage');
Route::get('contacts', 'RequestController@contacts')->name('requests.contacts');
Route::post('requests', 'RequestController@store')->name('requests.store');
