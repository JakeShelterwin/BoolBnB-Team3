<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/apartment-create', 'HomeController@createApartment')->name('createApartment');
Route::post('/apartment-store', 'HomeController@storeApartment')->name('storeApartment');
Route::get('/apartment-edit/{id}', 'HomeController@editApartment')->name('editApartment');
Route::post('/apartment-update/{id}', 'HomeController@updateApartment')->name('updateApartment');
Route::get('/apartment-delete/{id}', 'HomeController@deleteApartment')->name('deleteApartment');
Route::get('/apartment/{id}/stats', 'HomeController@showApartmentStatistics')->name('showApartmentStatistics');
Route::get('/apartment/{id}/sponsor', 'HomeController@sponsorApartment')->name('sponsorApartment');

// ROTTA CHE GESTISCE I PAGAMENTI
Route::get('/payment/make', 'HomeController@make')->name('payment.make');

Route::get('/documentation', function(){return view('documentation');})->name('documentation');

Route::get('/', "ApartmentController@index")->name("welcome");
Route::get('/searchApartments', "ApartmentController@searchApartments")->name("searchApartments");

Route::get('/apartment/{id}', 'ApartmentController@showApartment')->name('showApartment');


Route::get('/view/{id}', 'ApartmentController@storeView')->name('storeView');

Route::post('/message/apartment{id}', 'ApartmentController@storeMessage')->name('storeMessage');
