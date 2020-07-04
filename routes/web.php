<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/', "ApartmentController@index")->name("welcome");
Route::get('/apartment/{id}', 'ApartmentController@showApartment')->name('showApartment');
Route::get('/apartment-edit/{id}', 'ApartmentController@editApartment')->name('editApartment');
Route::post('/apartment-update/{id}', 'ApartmentController@updateApartment')->name('updateApartment');
