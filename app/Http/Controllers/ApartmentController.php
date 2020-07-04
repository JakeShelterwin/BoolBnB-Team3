<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Apartment;
use App\Service;

class ApartmentController extends Controller
{
    public function index(){
      $apartments = Apartment::all();
      return view('welcome', compact("apartments"));
    }
    public function showApartment($id){
      $apartment = Apartment::findOrFail($id);
      return view('showApartment', compact("apartment"));
    }

}
