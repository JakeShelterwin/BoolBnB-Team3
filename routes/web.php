<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/apartment-create', 'HomeController@createApartment')->name('createApartment');
Route::post('/apartment-store', 'HomeController@storeApartment')->name('storeApartment');
Route::get('/apartment-edit/{id}', 'HomeController@editApartment')->name('editApartment');
Route::post('/apartment-update/{id}', 'HomeController@updateApartment')->name('updateApartment');
Route::get('/apartment-delete/{id}', 'HomeController@deleteApartment')->name('deleteApartment');

Route::get('/', "ApartmentController@index")->name("welcome");
Route::get('/apartment/{id}', 'ApartmentController@showApartment')->name('showApartment');
